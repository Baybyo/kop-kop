<?php
namespace App\Controllers;

use App\Models\SuratModel;
use App\Models\UserModel;

class Page extends BaseController
{
    private function guard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        return null;
    }

    private function layoutVars(string $active, string $title): array
    {
        $role = session()->get('role');
        $notif = notificationData($role, (int)session()->get('user_id'));
        return [
            'title' => $title, 'active' => $active, 'role' => $role,
            'isAdmin' => in_array($role, ['admin', 'superadmin'], true),
            'notifCount' => $notif['count'], 'notifItems' => $notif['items'],
        ];
    }

    private function adminOnly(): bool
    {
        return in_array(session()->get('role'), ['admin', 'superadmin'], true);
    }

    public function riwayat()
    {
        if ($redirect = $this->guard()) return $redirect;
        $model = new SuratModel();
        $role = session()->get('role');
        $builder = $model->orderBy('created_at', 'DESC');
        if (!in_array($role, ['admin', 'superadmin'], true)) {
            $builder = $builder->where('user_id', session()->get('user_id'));
        }
        $surat = $builder->findAll();
        return view('pages/riwayat', array_merge($this->layoutVars('riwayat', 'Riwayat Surat'), ['surat' => $surat]));
    }

    public function profil()
    {
        if ($redirect = $this->guard()) return $redirect;
        $users = new UserModel();
        $user = $users->find(session()->get('user_id'));
        return view('pages/profil', array_merge($this->layoutVars('profil', 'Profil'), ['user' => $user]));
    }

    public function profilUpdate()
    {
        if ($redirect = $this->guard()) return $redirect;
        $users = new UserModel();
        $id = session()->get('user_id');
        $name = trim((string)$this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->withInput()->with('error', 'Nama wajib diisi.');
        }
        $data = [
            'name' => $name,
            'nip' => trim((string)$this->request->getPost('nip')) ?: null,
            'jabatan' => trim((string)$this->request->getPost('jabatan')) ?: null,
            'pangkat_golongan' => trim((string)$this->request->getPost('pangkat_golongan')) ?: null,
        ];
        if (!$users->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan profil.');
        }
        session()->set('name', $data['name']);
        return redirect()->to('/profil')->with('success', 'Profil diperbarui.');
    }

    public function bantuan()
    {
        if ($redirect = $this->guard()) return $redirect;
        return view('pages/bantuan', $this->layoutVars('bantuan', 'Bantuan'));
    }

    public function laporan()
    {
        if ($redirect = $this->guard()) return $redirect;
        $m = new SuratModel();
        $b = $m->orderBy('created_at', 'DESC');
        $get = $this->request->getGet();
        $jenis = trim((string)($get['jenis'] ?? ''));
        $status = trim((string)($get['status'] ?? ''));
        $dari = trim((string)($get['dari'] ?? ''));
        $sampai = trim((string)($get['sampai'] ?? ''));
        if ($jenis !== '') $b = $b->where('jenis_surat', $jenis);
        if ($status !== '') $b = $b->where('status', $status);
        if ($dari !== '') $b = $b->where('tanggal >=', $dari);
        if ($sampai !== '') $b = $b->where('tanggal <=', $sampai);
        if (!$this->adminOnly()) $b = $b->where('user_id', session()->get('user_id'));
        $rows = $b->findAll();
        $rekap = ['total' => count($rows), 'verified' => 0, 'draft' => 0, 'rejected' => 0, 'byJenis' => []];
        foreach ($rows as $r) {
            $st = $r['status'] ?? 'draft';
            if (isset($rekap[$st])) $rekap[$st]++;
            $j = $r['jenis_surat'] ?? '-';
            $rekap['byJenis'][$j] = ($rekap['byJenis'][$j] ?? 0) + 1;
        }
        return view('pages/laporan', array_merge($this->layoutVars('laporan', 'Laporan & Rekapitulasi'), [
            'rows' => $rows, 'rekap' => $rekap,
            'f' => ['jenis' => $jenis, 'status' => $status, 'dari' => $dari, 'sampai' => $sampai],
        ]));
    }

    public function laporanExport()
    {
        if ($redirect = $this->guard()) return $redirect;
        $m = new SuratModel();
        $b = $m->orderBy('created_at', 'DESC');
        $get = $this->request->getGet();
        foreach (['jenis_surat' => 'jenis', 'status' => 'status'] as $col => $k) {
            if (trim((string)($get[$k] ?? '')) !== '') $b = $b->where($col, trim((string)$get[$k]));
        }
        if (trim((string)($get['dari'] ?? '')) !== '') $b = $b->where('tanggal >=', trim((string)$get['dari']));
        if (trim((string)($get['sampai'] ?? '')) !== '') $b = $b->where('tanggal <=', trim((string)$get['sampai']));
        if (!$this->adminOnly()) $b = $b->where('user_id', session()->get('user_id'));
        $rows = $b->findAll();
        $fn = 'laporan_' . date('Ymd_His') . '.csv';
        $fh = fopen('php://temp', 'w');
        fputcsv($fh, ['ID', 'Nomor Surat', 'Agenda', 'Jenis', 'Tanggal', 'Perihal', 'Status']);
        foreach ($rows as $r) fputcsv($fh, [$r['id'], $r['nomor_surat'], $r['nomor_agenda'] ?? '', $r['jenis_surat'], $r['tanggal'], $r['perihal'], $r['status']]);
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);
        return $this->response->setHeader('Content-Type', 'text/csv; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fn . '"')
            ->setBody($csv);
    }

    public function audit()
    {
        if ($redirect = $this->guard()) return $redirect;
        if (!$this->adminOnly()) return redirect()->to('/dashboard')->with('error', 'Hanya admin.');
        $db = \Config\Database::connect();
        $get = $this->request->getGet();
        $aksi = trim((string)($get['aksi'] ?? ''));
        $q = trim((string)($get['q'] ?? ''));
        $b = $db->table('audit_logs a')->select('a.*, u.name AS actor_name')
            ->join('users u', 'u.id = a.actor_id', 'left')->orderBy('a.id', 'DESC');
        if ($aksi !== '') $b = $b->where('a.action', $aksi);
        if ($q !== '') $b = $b->groupStart()->like('a.entity', $q)->orLike('a.payload', $q)->orLike('u.name', $q)->groupEnd();
        $logs = $b->limit(100)->get()->getResultArray();
        $risky = $db->table('audit_logs')->whereIn('action', ['REJECT', 'OVERRIDE_SEQUENCE', 'PRIVILEGE_ESCALATE', 'EXPORT'])->countAllResults();
        return view('pages/audit', array_merge($this->layoutVars('audit', 'Audit Log Forensik'), [
            'logs' => $logs, 'risky' => $risky, 'total' => $db->table('audit_logs')->countAllResults(),
            'f' => ['aksi' => $aksi, 'q' => $q],
        ]));
    }

    public function telemetri()
    {
        if ($redirect = $this->guard()) return $redirect;
        if (!$this->adminOnly()) return redirect()->to('/dashboard')->with('error', 'Hanya admin.');
        $db = \Config\Database::connect();
        $m = new SuratModel();
        $stats = [
            'total' => $m->countAllResults(),
            'draft' => (clone $m)->where('status', 'draft')->countAllResults(),
            'verified' => (clone $m)->where('status', 'verified')->countAllResults(),
            'rejected' => (clone $m)->where('status', 'rejected')->countAllResults(),
            'users' => $db->table('users')->countAllResults(),
            'logs' => $db->table('audit_logs')->countAllResults(),
            'risky' => $db->table('audit_logs')->whereIn('action', ['REJECT', 'OVERRIDE_SEQUENCE', 'PRIVILEGE_ESCALATE'])->countAllResults(),
        ];
        $recent = $db->table('audit_logs a')->select('a.*, u.name AS actor_name')
            ->join('users u', 'u.id = a.actor_id', 'left')->orderBy('a.id', 'DESC')->limit(8)->get()->getResultArray();
        return view('pages/telemetri', array_merge($this->layoutVars('telemetri', 'Telemetri & System Health'), [
            'stats' => $stats, 'recent' => $recent,
            'php' => PHP_VERSION, 'db' => $db->getVersion(),
        ]));
    }

    public function notifikasi()
    {
        if ($redirect = $this->guard()) return $redirect;
        $role = session()->get('role');
        $notif = notificationData($role, (int)session()->get('user_id'));
        return view('pages/notifikasi', array_merge($this->layoutVars('notifikasi', 'Notifikasi & Pesan'), [
            'items' => $notif['items'],
        ]));
    }

    public function surat(string $jenis)
    {
        if ($redirect = $this->guard()) return $redirect;
        if (in_array(session()->get('role'), ['admin', 'superadmin'], true)) return redirect()->to('/riwayat')->with('error', 'Admin hanya verifikator.');
        $judul = [
            'perintah-tugas' => 'Buat Surat Perintah Tugas',
            'keputusan' => 'Buat Surat Keputusan Kepala Dinas',
            'nota-dinas' => 'Buat Nota Dinas',
        ];
        if (!isset($judul[$jenis])) return redirect()->to('/dashboard');
        helper('kopsurat');
        $next = nextAgendaNumber(resolveDocumentTypeId($jenis));
        return view('pages/surat/form', array_merge($this->layoutVars('beranda', $judul[$jenis]), [
            'judul' => $judul[$jenis],
            'jenis' => $jenis,
            'agendaNumber' => $next,
            'agendaFormatted' => formatNomorAgenda($next),
            'tahun' => date('Y'),
            'suratDariDefault' => suratDariByRole(session()->get('role')),
        ]));
    }

    public function simpanSurat(string $jenis)
    {
        if ($redirect = $this->guard()) return $redirect;
        if (in_array(session()->get('role'), ['admin', 'superadmin'], true)) return redirect()->to('/riwayat')->with('error', 'Admin hanya verifikator.');
        $jenisMap = [
            'perintah-tugas' => 'Surat Perintah Tugas',
            'keputusan' => 'Surat Keputusan Kepala Dinas',
            'nota-dinas' => 'Nota Dinas',
        ];
        if (!isset($jenisMap[$jenis])) return redirect()->to('/dashboard');
        helper('kopsurat');
        $num = new \App\Services\NumberingService();
        $typeId = resolveDocumentTypeId($jenis);
        $agendaNumber = $num->allocate($typeId, (int)date('Y'));
        $agendaFormatted = formatNomorAgenda($agendaNumber);
        $tahun = date('Y');
        $tanggal = $this->request->getPost('tanggal');
        $perihal = trim((string)$this->request->getPost('perihal'));
        $suratDari = trim((string)$this->request->getPost('surat_dari')) ?: suratDariByRole(session()->get('role'));
        $namaDitugaskan = trim((string)$this->request->getPost('nama_ditugaskan'));

        if (!$tanggal || !$perihal) {
            return redirect()->back()->withInput()->with('error', 'Tanggal dan perihal wajib diisi.');
        }

        if ($jenis === 'perintah-tugas') {
            $prefix = trim((string)$this->request->getPost('nomor_prefix'));
            if ($prefix === '') return redirect()->back()->withInput()->with('error', 'Nomor awal wajib diisi.');
            $nomor = "{$prefix}/{$agendaFormatted}/108/{$tahun}";
        } elseif ($jenis === 'keputusan') {
            $prefix = trim((string)$this->request->getPost('nomor_prefix'));
            $suffix = trim((string)$this->request->getPost('nomor_suffix'));
            if ($prefix === '' || $suffix === '') return redirect()->back()->withInput()->with('error', 'Nomor prefix dan suffix wajib diisi.');
            $nomor = "{$prefix}/{$agendaFormatted}/{$suffix}";
        } else {
            $prefix = trim((string)$this->request->getPost('nomor_prefix'));
            $sub = trim((string)$this->request->getPost('sub_kode'));
            if ($prefix === '' || $sub === '') return redirect()->back()->withInput()->with('error', 'Nomor prefix dan sub-kode wajib diisi.');
            $nomor = "{$prefix}/{$agendaFormatted}/108.{$sub}/{$tahun}";
        }

        $extraData = [
            'nomor_agenda' => $agendaFormatted,
            'perihal' => $perihal,
            'surat_dari' => $suratDari,
            'nama_ditugaskan' => $namaDitugaskan,
        ];

        // Tangkap data spesifik per jenis surat (YAGNI: simpan di JSON data tanpa migrasi baru)
        if ($jenis === 'perintah-tugas') {
            $extraData['dasar_hukum'] = trim((string)$this->request->getPost('dasar_hukum'));
            $extraData['lokasi_tujuan'] = trim((string)$this->request->getPost('lokasi_tujuan'));
            $extraData['tgl_mulai'] = $this->request->getPost('tgl_mulai');
            $extraData['tgl_selesai'] = $this->request->getPost('tgl_selesai');
            $extraData['beban_anggaran'] = trim((string)$this->request->getPost('beban_anggaran'));
        } elseif ($jenis === 'keputusan') {
            $extraData['menimbang'] = trim((string)$this->request->getPost('menimbang'));
            $extraData['mengingat'] = trim((string)$this->request->getPost('mengingat'));
            $extraData['diktum_menetapkan'] = trim((string)$this->request->getPost('diktum_menetapkan'));
        } elseif ($jenis === 'nota-dinas') {
            $extraData['kepada'] = trim((string)$this->request->getPost('kepada'));
            $extraData['sifat'] = trim((string)$this->request->getPost('sifat')) ?: 'Biasa';
            $extraData['lampiran_count'] = trim((string)$this->request->getPost('lampiran_count')) ?: '-';
        }

        $model = new SuratModel();
        $id = $model->insert([
            'user_id' => session()->get('user_id'),
            'jenis_surat' => $jenisMap[$jenis],
            'agenda_number' => $agendaNumber,
            'nomor_agenda' => $agendaFormatted,
            'nomor_surat' => $nomor,
            'tanggal' => $tanggal,
            'nama_ditugaskan' => $namaDitugaskan ?: null,
            'perihal' => $perihal,
            'surat_dari' => $suratDari,
            'status' => 'draft',
            'data' => json_encode($extraData, JSON_UNESCAPED_UNICODE),
        ], true);

        helper('kopsurat'); auditLog('CREATE', 'surat', (int)$id, ['nomor_surat' => $nomor, 'jenis' => $jenis]);
        return redirect()->to('/surat/preview/' . $id)->with('success', $jenisMap[$jenis] . ' disimpan: ' . $nomor);
    }

    public function preview(int $id)
    {
        if ($redirect = $this->guard()) return $redirect;
        $model = new SuratModel();
        $surat = $model->find($id);
        if (!$surat) return redirect()->to('/riwayat')->with('error', 'Surat tidak ditemukan.');
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'superadmin'], true) && (int)$surat['user_id'] !== (int)session()->get('user_id')) {
            return redirect()->to('/riwayat')->with('error', 'Akses ditolak.');
        }
        return view('pages/surat/preview', array_merge($this->layoutVars('riwayat', 'Pratinjau Surat'), [
            'surat' => $surat,
            'print' => false,
        ]));
    }

    public function printSurat(int $id)
    {
        if ($redirect = $this->guard()) return $redirect;
        $model = new SuratModel();
        $surat = $model->find($id);
        if (!$surat) return redirect()->to('/riwayat')->with('error', 'Surat tidak ditemukan.');
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'superadmin'], true) && (int)$surat['user_id'] !== (int)session()->get('user_id')) {
            return redirect()->to('/riwayat')->with('error', 'Akses ditolak.');
        }
        return view('pages/surat/preview', array_merge($this->layoutVars('riwayat', 'Cetak Surat'), [
            'surat' => $surat,
            'print' => true,
        ]));
    }

    public function pdf(int $id)
    {
        if ($redirect = $this->guard()) return $redirect;
        $model = new SuratModel();
        $surat = $model->find($id);
        if (!$surat) return redirect()->to('/riwayat')->with('error', 'Surat tidak ditemukan.');
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'superadmin'], true) && (int)$surat['user_id'] !== (int)session()->get('user_id')) {
            return redirect()->to('/riwayat')->with('error', 'Akses ditolak.');
        }
        $html = view('pages/surat/preview', ['title' => 'PDF', 'active' => 'riwayat', 'surat' => $surat, 'print' => true]);
        $opt = new \Dompdf\Options();
        $opt->set('isHtml5ParserEnabled', true);
        $opt->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($opt);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('surat_' . $id . '.pdf', ['Attachment' => false]);
    }
}
