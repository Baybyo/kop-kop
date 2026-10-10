<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
.form-wrap{max-width:860px;margin:40px auto 0;padding:0 30px;position:relative;z-index:5}
.form-card{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:36px 40px 32px}
.form-head{display:flex;align-items:center;gap:16px;padding-bottom:24px;border-bottom:1px solid #EEF2F7;margin-bottom:28px}
.form-head .fh-icon{width:52px;height:52px;border-radius:12px;background:var(--blue);color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.form-head h2{font-size:21px;font-weight:700}
.form-head p{font-size:14px;color:var(--muted);margin-top:3px}
.form-group{margin-bottom:20px}
.form-group label{display:block;font-size:14px;font-weight:600;color:#334155;margin-bottom:8px}
.form-group label .req{color:#EF4444}
.form-group input,.form-group textarea{width:100%;padding:12px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14.5px;font-family:inherit;color:var(--ink);outline:none;background:#fff}
.form-group input:focus,.form-group textarea:focus{border-color:var(--blue);box-shadow:0 0 0 4px rgba(5,97,185,.10)}
.form-group textarea{resize:vertical;min-height:90px}
input[readonly]{background:#F8FAFC;color:#475569;font-weight:600}
.nomor-grid{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.nomor-grid input{flex:1;min-width:90px;text-align:center;font-weight:600}
.nomor-grid input.auto{background:#F1F5F9;border-style:dashed}
.nomor-grid .sep{color:#94A3B8;font-size:18px;font-weight:700}
.hint{font-size:12.5px;color:#94A3B8;margin-top:6px}
.preview-box{background:#F8FAFC;border:1.5px dashed #CBD5E1;border-radius:10px;padding:14px 16px;font-size:14px;font-weight:600;color:#334155;margin-top:10px}
.preview-box span{color:var(--blue)}
.form-actions{display:flex;justify-content:space-between;margin-top:30px;padding-top:24px;border-top:1px solid #EEF2F7}
.btn{padding:13px 34px;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;font-family:inherit}
.btn-cancel{background:#F1F5F9;color:#475569;border:1.5px solid #E2E8F0}
.btn-submit{background:var(--blue);color:#fff;border:none;box-shadow:0 8px 18px rgba(5,97,185,.30)}
.btn-submit:hover{background:#1560C8}
.alert{padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:22px}
.alert-error{background:#FEF2F2;color:#DC2626;border:1px solid #FECACA}
@media(max-width:700px){.form-card{padding:26px 20px}}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="form-wrap"><div class="form-card">
<div class="form-head"><div class="fh-icon"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M7 3.5h6.5L18 8v10.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2z"/><path d="M13.2 3.7V8H18"/></svg></div>
<div><h2><?= esc($judul) ?></h2><p>Nomor agenda otomatis, berlanjut tanpa batas.</p></div></div>
<?php if (session()->getFlashdata('error')): ?><div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div><?php endif; ?>
<form action="<?= site_url('surat/simpan/' . $jenis) ?>" method="post"><?= csrf_field() ?>
<div class="form-group"><label>Nomor Agenda (otomatis)</label>
<input type="text" value="<?= esc($agendaFormatted) ?>" readonly>
<div class="hint">Counter berikutnya. Format 4 digit mulai 0001, otomatis jadi 5 digit setelah 9999.</div></div>
<div class="form-group"><label>Nomor Surat <span class="req">*</span></label>
<?php if ($jenis === 'perintah-tugas'): ?>
<div class="nomor-grid"><input name="nomor_prefix" placeholder="800" required value="<?= esc(old('nomor_prefix')) ?>"><span class="sep">/</span><input class="auto" value="<?= esc($agendaFormatted) ?>" readonly><span class="sep">/</span><input class="auto" value="108" readonly><span class="sep">/</span><input class="auto" value="<?= esc($tahun) ?>" readonly></div>
<?php elseif ($jenis === 'keputusan'): ?>
<div class="nomor-grid"><input name="nomor_prefix" placeholder="188" required value="<?= esc(old('nomor_prefix')) ?>"><span class="sep">/</span><input class="auto" value="<?= esc($agendaFormatted) ?>" readonly><span class="sep">/</span><input name="nomor_suffix" placeholder="KEP/108/2026" required value="<?= esc(old('nomor_suffix')) ?>"></div>
<?php else: ?>
<div class="nomor-grid"><input name="nomor_prefix" placeholder="005" required value="<?= esc(old('nomor_prefix')) ?>"><span class="sep">/</span><input class="auto" value="<?= esc($agendaFormatted) ?>" readonly><span class="sep">/</span><input class="auto" value="108" readonly><span class="sep">.</span><input name="sub_kode" placeholder="1" required style="max-width:100px" value="<?= esc(old('sub_kode')) ?>"><span class="sep">/</span><input class="auto" value="<?= esc($tahun) ?>" readonly></div>
<?php endif; ?>
<div class="preview-box" id="nomorPreview">Nomor: <span>-</span></div></div>
<div class="form-group"><label for="tanggal">Tanggal <span class="req">*</span></label>
<input type="date" id="tanggal" name="tanggal" value="<?= esc(old('tanggal', date('Y-m-d'))) ?>" required></div>
<div class="form-group"><label for="nama_ditugaskan">Nama yang Ditugaskan</label>
<input type="text" id="nama_ditugaskan" name="nama_ditugaskan" value="<?= esc(old('nama_ditugaskan')) ?>" placeholder="Nama pegawai yang ditugaskan"></div>
<div class="form-group"><label for="perihal">Perihal <span class="req">*</span></label>
<textarea id="perihal" name="perihal" placeholder="Tuliskan perihal surat..." required><?= esc(old('perihal')) ?></textarea></div>
<div class="form-group"><label for="surat_dari">Surat Dari <span class="req">*</span></label>
<input type="text" id="surat_dari" name="surat_dari" value="<?= esc(old('surat_dari', $suratDariDefault)) ?>" required></div>
<div class="form-actions"><a class="btn btn-cancel" href="<?= site_url('dashboard') ?>">Batal</a>
<button class="btn btn-submit" type="submit">Simpan &amp; Pratinjau &rarr;</button></div>
</form></div></div>
<script>
(function(){
var jenis='<?= esc($jenis, 'js') ?>', agenda='<?= esc($agendaFormatted, 'js') ?>', tahun='<?= esc($tahun, 'js') ?>';
function v(n){var el=document.querySelector('[name="'+n+'"]');return el?el.value.trim():'';}
function upd(){var s='';
if(jenis==='perintah-tugas')s=(v('nomor_prefix')||'…')+'/'+agenda+'/108/'+tahun;
else if(jenis==='keputusan')s=(v('nomor_prefix')||'…')+'/'+agenda+'/'+(v('nomor_suffix')||'…');
else s=(v('nomor_prefix')||'…')+'/'+agenda+'/108.'+(v('sub_kode')||'…')+'/'+tahun;
document.querySelector('#nomorPreview span').textContent=s;}
document.querySelectorAll('.nomor-grid input').forEach(function(el){el.addEventListener('input',upd);});upd();
})();
</script>
<?= $this->endSection() ?>
