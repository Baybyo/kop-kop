<?php
namespace App\Controllers;
use App\Models\SuratModel;
use App\Models\UserModel;
class Admin extends BaseController
{
    private function layoutVars(string $active, string $title): array
    {
        $role = session()->get('role');
        $notif = notificationData($role, (int)session()->get('user_id'));
        return [
            'title'=>$title,'active'=>$active,'role'=>$role,
            'isAdmin'=>in_array($role,['admin','superadmin'],true),
            'notifCount'=>$notif['count'],'notifItems'=>$notif['items']
        ];
    }
    private function superOnly()
    {
        if (session()->get('role') !== 'superadmin' && session()->get('role_slug') !== 'superadmin') return redirect()->to('/dashboard')->with('error','Hanya superadmin.');
        return null;
    }
    private function setting(string $key, ?string $default = null): ?string
    {
        $row = \Config\Database::connect()->table('system_settings')->where('key',$key)->orderBy('id','DESC')->get()->getRowArray();
        return $row['value'] ?? $default;
    }
    private function saveSetting(string $key, string $value): void
    {
        $db = \Config\Database::connect();
        $row = $db->table('system_settings')->where('key',$key)->get()->getRowArray();
        if ($row) $db->table('system_settings')->where('id',$row['id'])->update(['value'=>$value]);
        else $db->table('system_settings')->insert(['key'=>$key,'value'=>$value]);
    }
    public function surat()
    {
        return redirect()->to('/admin/arsip');
    }
    public function arsip()
    {
        $db = \Config\Database::connect();
        $get = $this->request->getGet();
        $jenis = trim((string)($get['jenis'] ?? ''));
        $status = trim((string)($get['status'] ?? ''));
        $q = trim((string)($get['q'] ?? ''));
        $b = $db->table('surat s')->select('s.*, u.name AS pembuat')
            ->join('users u', 'u.id = s.user_id', 'left')->orderBy('s.id', 'DESC');
        if ($jenis !== '') $b = $b->where('s.jenis_surat', $jenis);
        if ($status !== '') $b = $b->where('s.status', $status);
        if ($q !== '') $b = $b->groupStart()->like('s.nomor_surat', $q)->orLike('s.perihal', $q)->orLike('s.nomor_agenda', $q)->groupEnd();
        $rows = $b->limit(200)->get()->getResultArray();
        $m = new SuratModel();
        $rekap = [
            'total' => $m->countAllResults(),
            'verified' => (clone $m)->where('status', 'verified')->countAllResults(),
            'draft' => (clone $m)->where('status', 'draft')->countAllResults(),
            'rejected' => (clone $m)->where('status', 'rejected')->countAllResults(),
        ];
        return view('admin/arsip', array_merge($this->layoutVars('arsip', 'Arsip & Monitoring Naskah'), [
            'rows' => $rows, 'rekap' => $rekap, 'f' => ['jenis' => $jenis, 'status' => $status, 'q' => $q],
        ]));
    }
    public function verify(int $id)
    {
        $m = new SuratModel();
        $s = $m->find($id);
        if (!$s) return redirect()->to('/riwayat')->with('error','Surat tidak ditemukan.');
        $st = trim((string)$this->request->getPost('status'));
        $cat = trim((string)$this->request->getPost('catatan_admin'));
        if (!in_array($st,['verified','rejected'],true)) return redirect()->to('/riwayat')->with('error','Status tidak valid.');
        if ($st==='rejected' && $cat==='') return redirect()->to('/riwayat')->with('error','Alasan penolakan wajib.');
        $old = $s['status'] ?? 'draft';
        $m->update($id, ['status'=>$st,'catatan_admin'=>$cat ?: null]);
        helper('kopsurat'); auditLog($st==='verified'?'APPROVE':'REJECT', 'surat', $id, ['from'=>$old,'to'=>$st,'catatan'=>$cat]);
        return redirect()->to('/riwayat')->with('success','Surat #'.$id.' di'.($st==='verified'?'verifikasi':'tolak').'.');
    }
    public function users()
    {
        if ($r = $this->superOnly()) return $r;
        $u = new UserModel();
        return view('admin/users', array_merge($this->layoutVars('manajemen_user','Kelola Pengguna'), ['users'=>$u->orderBy('id','ASC')->findAll()]));
    }
    public function userSave()
    {
        if ($r = $this->superOnly()) return $r;
        $id = (int)$this->request->getPost('id');
        $data = [
            'username'=>trim((string)$this->request->getPost('username')),
            'name'=>trim((string)$this->request->getPost('name')),
            'email'=>trim((string)$this->request->getPost('email')) ?: null,
            'role'=>trim((string)$this->request->getPost('role')) ?: 'sekretariat',
            'status'=>trim((string)$this->request->getPost('status')) ?: 'active',
        ];
        if ($data['username']===''||$data['name']==='') return redirect()->back()->with('error','Username dan nama wajib.');
        $pw = (string)$this->request->getPost('password');
        if ($pw!=='') $data['password'] = password_hash($pw, PASSWORD_DEFAULT);
        $u = new UserModel();
        if ($id>0) { if (!$u->update($id,$data)) return redirect()->back()->with('error','Gagal update.'); }
        else { if ($pw==='') return redirect()->back()->with('error','Password wajib untuk user baru.'); if (!$u->insert($data)) return redirect()->back()->with('error','Gagal tambah.'); }
        return redirect()->to('/admin/users')->with('success','Pengguna disimpan.');
    }
    public function penomoran()
    {
        if ($r = $this->superOnly()) return $r;
        $db = \Config\Database::connect();
        $types = $db->table('document_types')->orderBy('id','ASC')->get()->getResultArray();
        $seqs = $db->table('document_sequences')->where('year',(int)date('Y'))->get()->getResultArray();
        $seqMap = [];
        foreach ($seqs as $s) $seqMap[(int)$s['document_type_id']] = (int)$s['last_number'];
        return view('admin/penomoran', array_merge($this->layoutVars('penomoran','Konfigurasi Penomoran'), ['types'=>$types,'seqMap'=>$seqMap,'year'=>(int)date('Y')]));
    }
    public function penomoranSave()
    {
        if ($r = $this->superOnly()) return $r;
        $db = \Config\Database::connect();
        foreach ((array)$this->request->getPost('tpl') as $id => $tpl) {
            $tpl = trim((string)$tpl);
            if ($tpl!=='') $db->table('document_types')->where('id',(int)$id)->update(['format_template'=>$tpl]);
        }
        foreach ((array)$this->request->getPost('reset') as $id => $v) {
            $db->table('document_sequences')->where(['document_type_id'=>(int)$id,'year'=>(int)date('Y')])->update(['last_number'=>0]);
        }
        return redirect()->to('/admin/penomoran')->with('success','Template penomoran disimpan.');
    }
    public function kop()
    {
        if ($r = $this->superOnly()) return $r;
        return view('admin/kop', array_merge($this->layoutVars('kop','Kop Surat'), [
            'kop_line1'=>$this->setting('kop_line1','PEMERINTAH PROVINSI JAWA TIMUR'),
            'kop_line2'=>$this->setting('kop_line2','DINAS TENAGA KERJA DAN TRANSMIGRASI'),
            'kop_addr'=>$this->setting('kop_addr','Jl. Dukuh Menanggal No. 124-126 Gayungan, Surabaya 60234'),
            'kop_contact'=>$this->setting('kop_contact','Telp. (031) 8283119, Fax. (031) 8290318, Website: disnakertrans.jatimprov.go.id'),
        ]));
    }
    public function kopSave()
    {
        if ($r = $this->superOnly()) return $r;
        foreach (['kop_line1','kop_line2','kop_addr','kop_contact'] as $k) {
            $this->saveSetting($k, trim((string)$this->request->getPost($k)));
        }
        return redirect()->to('/admin/kop')->with('success','Kop surat disimpan.');
    }
}
