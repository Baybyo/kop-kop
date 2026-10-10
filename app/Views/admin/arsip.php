<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div style="max-width:1160px;margin:32px auto 0;padding:0 30px">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
<div><h2 style="font-size:22px;font-weight:700;color:#16264A">Arsip & Monitoring Naskah</h2>
<p style="color:#64748B;font-size:14px;margin-top:2px">Repositori sentral surat terbit, sequence penomoran, validasi TTE</p></div>
<a href="<?= site_url('laporan/export?' . http_build_query($f)) ?>" style="background:#0C7B4C;color:#fff;padding:10px 18px;border-radius:10px;font-weight:600;font-size:14px">Cetak Buku Agenda</a>
</div>
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
<?php $cards = ['Total Berkas' => $rekap['total'], 'Terverifikasi' => $rekap['verified'], 'Draft' => $rekap['draft'], 'Ditolak' => $rekap['rejected']]; foreach ($cards as $k => $v): ?>
<div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)"><div style="font-size:13px;color:#64748B"><?= $k ?></div><div style="font-size:26px;font-weight:700;margin-top:4px"><?= $v ?></div></div>
<?php endforeach; ?>
</div>
<div style="background:#fff;padding:20px 24px;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);margin-bottom:24px">
<form method="get" action="<?= site_url('admin/arsip') ?>" style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:14px;align-items:end">
<div><label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Cari nomor / perihal</label><input type="text" name="q" value="<?= esc($f['q']) ?>" placeholder="nomor, agenda, perihal..." style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px"></div>
<div><label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Jenis</label><select name="jenis" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px"><option value="">Semua</option><?php foreach (['Surat Perintah Tugas', 'Surat Keputusan Kepala Dinas', 'Nota Dinas'] as $j): ?><option value="<?= $j ?>" <?= ($f['jenis'] === $j) ? 'selected' : '' ?>><?= $j ?></option><?php endforeach; ?></select></div>
<div><label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Status</label><select name="status" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px"><option value="">Semua</option><?php foreach (['draft', 'verified', 'rejected'] as $s): ?><option value="<?= $s ?>" <?= ($f['status'] === $s) ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?></select></div>
<button type="submit" style="background:#0561B9;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer">Filter</button>
</form>
</div>
<div style="background:#fff;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);overflow:hidden">
<table style="width:100%;border-collapse:collapse;font-size:13.5px">
<tr style="background:#F8FAFC;color:#475569;text-align:left"><th style="padding:14px 18px">Agenda</th><th style="padding:14px 18px">Nomor Surat</th><th style="padding:14px 18px">Perihal</th><th style="padding:14px 18px">Status</th><th style="padding:14px 18px;text-align:right">Aksi</th></tr>
<?php if (empty($rows)): ?><tr><td colspan="5" style="padding:32px;text-align:center;color:#94A3B8">Tidak ada arsip.</td></tr>
<?php else: foreach ($rows as $r): ?>
<tr style="border-bottom:1px solid #F1F5F9"><td style="padding:14px 18px;font-weight:600"><?= esc($r['nomor_agenda'] ?? '-') ?></td><td style="padding:14px 18px"><?= esc($r['nomor_surat']) ?><div style="font-size:12px;color:#64748B"><?= esc($r['jenis_surat']) ?> · <?= esc($r['tanggal']) ?></div></td><td style="padding:14px 18px;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= esc($r['perihal']) ?></td><td style="padding:14px 18px"><?= strtoupper(esc($r['status'] ?? 'draft')) ?></td><td style="padding:14px 18px;text-align:right"><a href="<?= site_url('surat/preview/' . $r['id']) ?>" style="color:#0561B9;font-weight:600">Detail &rarr;</a></td></tr>
<?php endforeach; endif; ?>
</table>
</div>
</div>
<?= $this->endSection() ?>
