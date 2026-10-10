<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div style="max-width:1160px;margin:36px auto 0;padding:0 30px">
<div style="background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:28px 30px;margin-bottom:28px">
    <h2 style="font-size:20px;font-weight:700;margin-bottom:4px">Kop Surat</h2>
    <p style="color:var(--muted);font-size:14px;margin-bottom:20px">Baris kop untuk header PDF. Tampil di kop tercetak (NumberingService tidak diubah).</p>
    <?php if(session()->getFlashdata('success')): ?><div style="background:#ECFDF5;color:#047857;padding:12px;border-radius:10px;margin-bottom:15px"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
    <form action="<?= site_url('admin/kop/save') ?>" method="post" style="display:grid;gap:14px;max-width:640px">
        <?= csrf_field() ?>
        <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Baris 1</label><input type="text" name="kop_line1" value="<?= esc($kop_line1) ?>" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
        <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Baris 2</label><input type="text" name="kop_line2" value="<?= esc($kop_line2) ?>" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
        <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Alamat</label><input type="text" name="kop_addr" value="<?= esc($kop_addr) ?>" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
        <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Kontak</label><input type="text" name="kop_contact" value="<?= esc($kop_contact) ?>" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
        <div><button type="submit" style="background:#0C7B4C;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer">Simpan Kop</button></div>
    </form>
</div>
</div>
<?= $this->endSection() ?>
