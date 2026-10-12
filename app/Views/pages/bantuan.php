<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
.b-wrap{max-width:800px;margin:36px auto 0;padding:0 30px;position:relative;z-index:5}
.b-card{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:32px 36px}
.b-card h2{font-size:20px;font-weight:700;margin-bottom:6px}
.b-card p.sub{font-size:14px;color:var(--muted);margin-bottom:20px}
ol{margin:0 0 0 20px;font-size:14.5px;line-height:1.9;color:#334155}
code{background:#F1F5F9;padding:2px 8px;border-radius:6px;font-size:13px;color:#0561B9;font-weight:600}
.fmt{background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:14px 18px;margin:12px 0;font-size:14px}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="b-wrap"><div class="b-card">
<h2>Bantuan</h2><p class="sub">Panduan singkat sistem kop surat.</p>
<ol>
<li>Pilih jenis surat di Beranda.</li>
<li>Nomor agenda terisi <strong>otomatis</strong> (0001, 0002, ... 9999, 10000, dst).</li>
<li>Isi nomor manual + kolom otomatis, lalu perihal &amp; tanggal.</li>
<li>Klik <strong>Simpan &amp; Pratinjau</strong>, lalu <strong>Cetak / PDF</strong> (Ctrl+P → Save as PDF).</li>
<li>Riwayat: admin lihat semua, role lain milik sendiri.</li>
</ol>
<div class="fmt"><strong>Perintah Tugas:</strong> <code>[manual]/[agenda]/108/[tahun]</code></div>
<div class="fmt"><strong>Keputusan:</strong> <code>[manual]/[agenda]/[manual]</code></div>
<div class="fmt"><strong>Nota Dinas:</strong> <code>[manual]/[agenda]/108.[sub]/[tahun]</code></div>
</div></div>
<?= $this->endSection() ?>
