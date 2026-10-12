<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
.rw-wrap{max-width:1160px;margin:36px auto 0;padding:0 30px;position:relative;z-index:5}
.rw-card{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:28px 30px}
.rw-card h2{font-size:20px;font-weight:700;margin-bottom:4px}
.rw-card p.sub{font-size:14px;color:var(--muted);margin-bottom:20px}
table{width:100%;border-collapse:collapse;font-size:14px}
th{text-align:left;padding:10px 12px;background:#F1F5F9;color:#334155;font-weight:600}
td{padding:11px 12px;border-top:1px solid #EEF2F7;vertical-align:top}
.badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12.5px;font-weight:600;background:#DBEAFE;color:#0561B9}
.st-verified{background:#D1FAE5;color:#065F46}.st-rejected{background:#FEE2E2;color:#991B1B}.st-draft{background:#FEF3C7;color:#92400E}
.btn-sm{padding:7px 14px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-block;margin-right:6px}
.btn-view{background:#EFF6FF;color:#0561B9;border:1px solid #BFDBFE}
.btn-print{background:#0561B9;color:#fff}
.btn-ok{background:#0C7B4C;color:#fff;border:none;cursor:pointer}
.btn-no{background:#FEF2F2;color:#DC2626;border:1px solid #FECACA;cursor:pointer}
.alert{padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:18px}
.alert-success{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0}
.alert-error{background:#FEF2F2;color:#DC2626;border:1px solid #FECACA}
.empty{text-align:center;padding:36px;color:#94A3B8}
.verif-head{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;margin-bottom:16px;flex-wrap:wrap}
.verif-head h2{font-size:20px;font-weight:700}
.verif-stats{display:flex;gap:8px}
.vstat{background:#fff;border:1px solid #E2E8F0;border-radius:10px;padding:8px 14px;font-size:13px;color:#475569}
.vstat.ok{background:#ECFDF5;border-color:#A7F3D0;color:#047857}.vstat.no{background:#FEF2F2;border-color:#FECACA;color:#DC2626}
.split{display:grid;grid-template-columns:340px 1fr;gap:16px}
.pane-list{display:flex;flex-direction:column;gap:8px;max-height:640px;overflow:auto}
.qitem{text-align:left;background:#fff;border:1.5px solid #E2E8F0;border-radius:12px;padding:12px 14px;cursor:pointer;display:flex;flex-direction:column;gap:4px;font-family:inherit}
.qitem.active{border-color:#0561B9;box-shadow:0 8px 20px rgba(5,97,185,.12)}
.qitem small{color:#64748B;font-size:12px}
.pane-prev{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:24px 26px;min-height:320px}
.qprev-head{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:14px}
.qprev-body{font-size:14px;color:#334155;display:flex;flex-direction:column;gap:8px;margin-bottom:16px}
.qprev-body .note{background:#FEF3C7;border:1px solid #FDE68A;border-radius:8px;padding:8px 12px;font-size:13px}
.qprev-act{display:flex;gap:8px;flex-wrap:wrap}
.muted{font-size:12.5px;color:#64748B}
@media(max-width:900px){.split{grid-template-columns:1fr}.rw-wrap{padding:0 18px}.pane-list{max-height:320px}}
@media(max-width:640px){.rw-card{padding:20px 18px}.verif-stats{flex-wrap:wrap}}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<?php if (!empty($isAdmin)): ?>
<div class="rw-wrap" style="max-width:1280px">
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<div class="verif-head">
<div>
<h2>Pusat Verifikasi Dokumen &amp; Tata Naskah Dinas</h2>
<p class="sub">Split-pane: antrean kiri, pratinjau kanan. Setujui atau tolak dengan catatan.</p>
</div>
<div class="verif-stats">
<span class="vstat">Draft: <b><?= count(array_filter($surat, fn($x) => ($x['status'] ?? 'draft') === 'draft')) ?></b></span>
<span class="vstat ok">Verified: <b><?= count(array_filter($surat, fn($x) => ($x['status'] ?? '') === 'verified')) ?></b></span>
<span class="vstat no">Rejected: <b><?= count(array_filter($surat, fn($x) => ($x['status'] ?? '') === 'rejected')) ?></b></span>
</div>
</div>
<?php if (empty($surat)): ?><div class="rw-card"><div class="empty">Belum ada surat.</div></div>
<?php else: ?>
<div class="split">
<div class="pane-list">
<?php foreach ($surat as $i => $s): $st = $s['status'] ?? 'draft'; ?>
<button class="qitem <?= $i === 0 ? 'active' : '' ?>" data-target="qprev-<?= $s['id'] ?>">
<span class="badge"><?= esc($s['nomor_agenda'] ?? '-') ?></span>
<strong><?= esc($s['jenis_surat']) ?></strong>
<small><?= esc($s['nomor_surat']) ?> · User #<?= esc($s['user_id']) ?></small>
<span class="badge <?= $st==='verified'?'st-verified':($st==='rejected'?'st-rejected':'st-draft') ?>"><?= strtoupper($st) ?></span>
</button>
<?php endforeach; ?>
</div>
<div class="pane-prev">
<?php foreach ($surat as $i => $s): $st = $s['status'] ?? 'draft'; ?>
<div id="qprev-<?= $s['id'] ?>" class="qprev" style="<?= $i === 0 ? '' : 'display:none' ?>">
<div class="qprev-head">
<div><strong><?= esc($s['jenis_surat']) ?></strong><div class="muted"><?= esc($s['nomor_surat']) ?> · <?= esc($s['tanggal'] ?? '') ?></div></div>
<span class="badge <?= $st==='verified'?'st-verified':($st==='rejected'?'st-rejected':'st-draft') ?>"><?= strtoupper($st) ?></span>
</div>
<div class="qprev-body">
<div><b>Perihal:</b> <?= esc($s['perihal'] ?? '-') ?></div>
<div><b>Dari:</b> <?= esc($s['surat_dari'] ?? '-') ?></div>
<?php if (!empty($s['catatan_admin'])): ?><div class="note">Catatan: <?= esc($s['catatan_admin']) ?></div><?php endif; ?>
</div>
<div class="qprev-act">
<a class="btn-sm btn-view" href="<?= site_url('surat/preview/'.$s['id']) ?>">Pratinjau Penuh</a>
<a class="btn-sm btn-print" href="<?= site_url('surat/pdf/'.$s['id']) ?>" target="_blank">PDF</a>
<?php if ($st === 'draft'): ?>
<form action="<?= site_url('admin/surat/'.$s['id'].'/verify') ?>" method="post" style="display:inline"><?= csrf_field() ?><input type="hidden" name="status" value="verified"><button class="btn-sm btn-ok" type="submit">Setujui</button></form>
<form action="<?= site_url('admin/surat/'.$s['id'].'/verify') ?>" method="post" style="display:inline" onsubmit="let v=prompt('Alasan penolakan (wajib):'); if(!v||!v.trim()){alert('Alasan wajib.');return false;} this.querySelector('[name=catatan_admin]').value=v; return true;"><?= csrf_field() ?><input type="hidden" name="status" value="rejected"><input type="hidden" name="catatan_admin" value=""><button class="btn-sm btn-no" type="submit">Tolak</button></form>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<script>document.querySelectorAll('.qitem').forEach(b=>b.addEventListener('click',()=>{document.querySelectorAll('.qitem').forEach(x=>x.classList.remove('active'));b.classList.add('active');document.querySelectorAll('.qprev').forEach(p=>p.style.display='none');document.getElementById(b.dataset.target).style.display='';}));</script>
<?php endif; ?>
</div>
<?php else: ?>
<div class="rw-wrap"><div class="rw-card">
<h2>Riwayat Surat Saya</h2>
<p class="sub">Surat yang kamu buat. Menunggu verifikasi admin.</p>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<?php if (empty($surat)): ?><div class="empty">Belum ada surat.</div>
<?php else: ?><div class="table-responsive"><table style="min-width:650px">
<tr><th>Agenda</th><th>Jenis</th><th>Nomor</th><th>Status</th><th>Aksi</th></tr>
<?php foreach ($surat as $s): $st = $s['status'] ?? 'draft'; ?><tr>
<td><span class="badge"><?= esc($s['nomor_agenda'] ?? '-') ?></span></td>
<td><?= esc($s['jenis_surat']) ?></td>
<td style="font-size:12.5px"><?= esc($s['nomor_surat']) ?></td>
<td><span class="badge <?= $st==='verified'?'st-verified':($st==='rejected'?'st-rejected':'st-draft') ?>"><?= strtoupper($st) ?></span><?php if(!empty($s['catatan_admin'])): ?><div style="font-size:11.5px;color:#64748B;max-width:160px;margin-top:4px"><?= esc($s['catatan_admin']) ?></div><?php endif; ?></td>
<td style="white-space:nowrap">
<a class="btn-sm btn-view" href="<?= site_url('surat/preview/'.$s['id']) ?>">Lihat</a>
<a class="btn-sm btn-print" href="<?= site_url('surat/pdf/'.$s['id']) ?>" target="_blank">PDF</a>
</td>
</tr><?php endforeach; ?>
</table></div><?php endif; ?>
</div></div>
<?php endif; ?>
<?= $this->endSection() ?>
