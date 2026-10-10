<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
.pf-wrap{max-width:780px;margin:36px auto 0;padding:0 30px;position:relative;z-index:5}
.pf-card{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:32px 36px}
.pf-card h2{font-size:20px;font-weight:700;margin-bottom:6px}
.pf-card p.sub{font-size:14px;color:var(--muted);margin-bottom:24px}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.fg{margin-bottom:16px}
.fg label{display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:6px}
.fg input{width:100%;padding:11px 14px;border:1.5px solid #E2E8F0;border-radius:10px;font-size:14.5px;font-family:inherit}
.fg input:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 4px rgba(5,97,185,.10)}
.fg input[readonly]{background:#F8FAFC}
.badge-role{display:inline-block;padding:6px 14px;border-radius:20px;font-size:12.5px;font-weight:700;background:#16284A;color:#fff;margin-bottom:18px}
.btn{padding:12px 28px;border-radius:10px;font-weight:600;font-size:14.5px;cursor:pointer;border:none;background:var(--blue);color:#fff;font-family:inherit}
.alert{padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:18px}
.alert-success{background:#ECFDF5;color:#047857;border:1px solid #A7F3D0}
@media(max-width:700px){.grid{grid-template-columns:1fr}.pf-card{padding:26px 20px}}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="pf-wrap"><div class="pf-card">
<h2>Profil Pegawai</h2><p class="sub">Kelola data akun. Role melekat sistem.</p>
<?php if (session()->getFlashdata('success')): ?><div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div><?php endif; ?>
<span class="badge-role"><?= esc($user['role'] ?? '-') ?></span>
<form action="<?= site_url('profil/update') ?>" method="post"><?= csrf_field() ?>
<div class="grid">
<div class="fg"><label>Username</label><input value="<?= esc($user['username']) ?>" readonly></div>
<div class="fg"><label for="name">Nama Lengkap</label><input id="name" name="name" value="<?= esc($user['name']) ?>" required></div>
</div>
<div class="grid">
<div class="fg"><label for="nip">NIP</label><input id="nip" name="nip" value="<?= esc($user['nip'] ?? '') ?>" placeholder="1980xxxx..."></div>
<div class="fg"><label for="pangkat_golongan">Pangkat / Golongan</label><input id="pangkat_golongan" name="pangkat_golongan" value="<?= esc($user['pangkat_golongan'] ?? '') ?>" placeholder="Pembina / IV/a"></div>
</div>
<div class="fg"><label for="jabatan">Jabatan</label><input id="jabatan" name="jabatan" value="<?= esc($user['jabatan'] ?? '') ?>" placeholder="Kepala Bidang ..."></div>
<div class="fg"><label>Surat Dari (otomatis by role)</label><input value="<?= esc(suratDariByRole($user['role'] ?? null)) ?>" readonly></div>
<button class="btn" type="submit">Simpan Profil</button>
</form>
</div></div>
<?= $this->endSection() ?>
