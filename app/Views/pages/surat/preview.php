<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
.prev-wrap{max-width:900px;margin:36px auto 0;padding:0 30px;position:relative;z-index:5}
.prev-actions{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap}
.btn{padding:12px 26px;border-radius:10px;font-size:14.5px;font-weight:600;font-family:inherit;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;border:1.5px solid transparent}
.btn-print{background:var(--blue);color:#fff;box-shadow:0 8px 18px rgba(5,97,185,.30);border:none}
.btn-back{background:#F1F5F9;color:#475569;border-color:#E2E8F0}
.btn-riwayat{background:#0C7B4C;color:#fff;border:none}
.alert{padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:18px}
.alert-success{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0}
.kertas{background:#fff;border-radius:8px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:56px 60px;color:#111;font-family:'Times New Roman',Times,serif}
.kop{display:flex;align-items:center;gap:18px;border-bottom:3px double #111;padding-bottom:14px;margin-bottom:6px}
.kop img{height:88px}
.kop-text{text-align:center;flex:1;line-height:1.35}
.kop-text h3{font-size:15px;font-weight:700;letter-spacing:.3px}
.kop-text h2{font-size:19px;font-weight:700}
.kop-text p{font-size:12.5px}
.judul-surat{text-align:center;margin:22px 0 18px}
.judul-surat h3{font-size:16px;text-decoration:underline;font-weight:700}
.judul-surat p{font-size:14px;margin-top:4px}
.isi{font-size:14.5px;line-height:1.8;text-align:justify}
.isi table{width:100%;border-collapse:collapse;margin:12px 0;font-size:14.5px}
.isi td{padding:3px 8px 3px 0;vertical-align:top}
.ttd{display:flex;justify-content:flex-end;margin-top:36px;font-size:14.5px;line-height:1.7}
.ttd div{text-align:center;min-width:260px}
.meta{font-size:12.5px;color:#64748B;margin-top:18px;font-family:Inter,sans-serif}
.tl-card{background:#fff;border-radius:16px;box-shadow:0 12px 28px rgba(15,23,42,.08);padding:20px 24px;margin-top:18px}
.tl-card h4{font-size:15px;font-weight:700;margin-bottom:12px}
.tl{display:flex;flex-direction:column;gap:14px}
.tl-item{display:flex;gap:12px;align-items:flex-start}
.tl-item .dot{width:12px;height:12px;border-radius:50%;background:#E2E8F0;flex-shrink:0;margin-top:3px}
.tl-item.done .dot{background:#0C7B4C}.tl-item.bad .dot{background:#DC2626}
.tl-item b{font-size:14px;display:block}.tl-item small{font-size:12.5px;color:#64748B;display:block;margin-top:2px}
.dlg{position:fixed;inset:0;background:rgba(15,23,42,.45);display:none;align-items:center;justify-content:center;z-index:999;padding:16px}
.dlg.open{display:flex}
.dlg-box{background:#fff;border-radius:16px;max-width:760px;width:100%;max-height:92vh;overflow:auto}
.dlg-head{display:flex;justify-content:space-between;align-items:center;padding:18px 20px;border-bottom:1px solid #E2E8F0}
.dlg-body{padding:20px}
.lembar{font-family:'Times New Roman',Times,serif;border:1.5px solid #111;padding:24px;color:#111}
.lembar h3{text-align:center;font-size:15px}
.lembar table{width:100%;border-collapse:collapse;margin-top:12px;font-size:13.5px}
.lembar th,.lembar td{border:1px solid #111;padding:7px 10px;text-align:left}
@media print{.dlg{display:block!important;position:static;background:#fff}.dlg-box{max-width:none;box-shadow:none}}
@media print{body *{visibility:hidden}.kertas,.kertas *{visibility:visible}.kertas{position:absolute;left:0;top:0;width:100%;box-shadow:none;border-radius:0;margin:0;padding:20mm 15mm}.prev-actions,.topbar,.sidebar,.alert,.meta{display:none!important}.content{background:#fff!important;padding:0!important}}
<?php if (!empty($print)): ?>.prev-actions,.topbar,.sidebar,.alert,.meta{display:none!important}<?php endif; ?>
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="prev-wrap">
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<div class="prev-actions">
<a class="btn btn-back" href="<?= site_url('dashboard') ?>">&larr; Beranda</a>
<a class="btn btn-riwayat" href="<?= site_url('riwayat') ?>">Riwayat</a>
<a class="btn btn-print" href="<?= site_url('surat/print/' . $surat['id']) ?>" <?= !empty($print) ? 'onclick="window.print();return false;"' : 'target="_blank"' ?>>Cetak</a><a class="btn btn-print" href="<?= site_url('surat/pdf/' . $surat['id']) ?>" target="_blank" style="background:#0C7B4C">Unduh PDF</a>
<button type="button" class="btn" style="background:#fff;border-color:#CBD5E1;color:#1E293B" onclick="document.getElementById('dlgDisposisi').classList.add('open')">Lembar Disposisi A4</button>
</div>

<!-- Modal Lembar Disposisi Resmi A4 (Mockup 06/07) -->
<div id="dlgDisposisi" class="dlg" onclick="if(event.target===this)this.classList.remove('open')">
<div class="dlg-box">
<div class="dlg-head">
<strong>Pratinjau &amp; Cetak Lembar Disposisi Kedinasan</strong>
<div style="display:flex;gap:8px">
<button type="button" class="btn-sm btn-print" onclick="window.print()">Cetak</button>
<button type="button" class="btn-sm btn-back" onclick="document.getElementById('dlgDisposisi').classList.remove('open')">&times; Tutup</button>
</div>
</div>
<div class="dlg-body">
<div class="lembar">
<h3>PEMERINTAH PROVINSI JAWA TIMUR<br>DINAS TENAGA KERJA DAN TRANSMIGRASI<br><u>LEMBAR DISPOSISI</u></h3>
<table>
<tr><td style="width:30%"><b>Surat Dari</b></td><td><?= esc($surat['surat_dari'] ?? '-') ?></td></tr>
<tr><td><b>No. / Tgl. Surat</b></td><td><?= esc($surat['nomor_surat'] ?? '-') ?> / <?= esc(date('d/m/Y', strtotime($surat['tanggal']))) ?></td></tr>
<tr><td><b>No. Agenda</b></td><td><?= esc($surat['nomor_agenda'] ?? '-') ?></td></tr>
<tr><td><b>Perihal</b></td><td><?= esc($surat['perihal'] ?? '-') ?></td></tr>
<tr><td><b>Status Naskah</b></td><td><?= strtoupper(esc($surat['status'] ?? 'DRAFT')) ?></td></tr>
<tr><td colspan="2" style="height:120px;vertical-align:top"><b>Instruksi / Catatan Pimpinan:</b><br><?= nl2br(esc($surat['catatan_admin'] ?? '')) ?></td></tr>
</table>
</div>
</div>
</div>
</div>
<div class="kertas">
<div class="kop">
<img src="<?= base_url('img/logo-jatim.png') ?>" alt="Jatim">
<div class="kop-text">
<h3>PEMERINTAH PROVINSI JAWA TIMUR</h3>
<h2>DINAS TENAGA KERJA DAN TRANSMIGRASI</h2>
<p>Jl. Dukuh Menanggal No. 124-126 Gayungan, Surabaya 60234<br>Telp. (031) 8283119, Fax. (031) 8290318, Website: disnakertrans.jatimprov.go.id</p>
</div>
<img src="<?= base_url('img/logo-disnakertrans.png') ?>" alt="Disnakertrans" style="height:72px">
</div>
<div class="judul-surat"><h3><?= esc(strtoupper($surat['jenis_surat'])) ?></h3><p>Nomor: <?= esc($surat['nomor_surat']) ?></p></div>
<div class="isi">
<table>
<tr><td style="width:170px">Nomor Agenda</td><td style="width:14px">:</td><td><?= esc($surat['nomor_agenda'] ?? '-') ?></td></tr>
<tr><td>Tanggal</td><td>:</td><td><?= esc(date('d F Y', strtotime($surat['tanggal']))) ?></td></tr>
<tr><td>Surat Dari</td><td>:</td><td><?= esc($surat['surat_dari'] ?? '-') ?></td></tr>
<?php if (!empty($surat['nama_ditugaskan'])): ?><tr><td>Ditugaskan</td><td>:</td><td><?= esc($surat['nama_ditugaskan']) ?></td></tr><?php endif; ?>
<tr><td>Perihal</td><td>:</td><td><?= esc($surat['perihal'] ?? '-') ?></td></tr>
</table>
<p style="margin-top:14px">Sehubungan dengan perihal tersebut di atas, mohon dapat ditindaklanjuti sesuai ketentuan yang berlaku. Surat ini dibuat sebagai kelengkapan administrasi <?= esc($surat['jenis_surat']) ?> di lingkungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
</div>
<div class="ttd"><div>
<p>Surabaya, <?= esc(date('d F Y', strtotime($surat['tanggal']))) ?></p>
<p>Kepala Dinas,</p><br><br><br>
<p><strong><u>( ............................................ )</u></strong></p>
<p>NIP. ............................................</p>
</div></div>
</div>
<div class="tl-card">
<h4>Riwayat Alur &amp; Disposisi</h4>
<div class="tl">
<div class="tl-item done"><span class="dot"></span><div><b>Dibuat</b><small><?= esc($surat['created_at'] ?? '-') ?> · <?= esc($surat['surat_dari'] ?? '-') ?></small></div></div>
<div class="tl-item <?= ($surat['status'] ?? 'draft') !== 'draft' ? 'done' : '' ?>"><span class="dot"></span><div><b>Diajukan Verifikasi</b><small>Agenda <?= esc($surat['nomor_agenda'] ?? '-') ?></small></div></div>
<div class="tl-item <?= ($surat['status'] ?? '') === 'verified' ? 'done' : (($surat['status'] ?? '') === 'rejected' ? 'bad' : '') ?>"><span class="dot"></span><div><b><?= strtoupper($surat['status'] ?? 'DRAFT') ?></b><?php if (!empty($surat['catatan_admin'])): ?><small><?= esc($surat['catatan_admin']) ?></small><?php endif; ?></div></div>
</div>
</div>
<div class="meta">Agenda <?= esc($surat['nomor_agenda'] ?? '-') ?> · Dibuat <?= esc($surat['created_at'] ?? '') ?></div>
</div>
<?php if (!empty($print)): ?><script>window.onload=function(){window.print();};</script><?php endif; ?>
<?= $this->endSection() ?>
