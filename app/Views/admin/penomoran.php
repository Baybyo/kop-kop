<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
table{width:100%;border-collapse:collapse;font-size:14px}
th{text-align:left;padding:10px 12px;background:#F1F5F9;color:#334155;font-weight:600}
td{padding:11px 12px;border-top:1px solid #EEF2F7;vertical-align:middle}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div style="max-width:1160px;margin:36px auto 0;padding:0 30px">
<div style="background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:28px 30px;margin-bottom:28px">
    <h2 style="font-size:20px;font-weight:700;margin-bottom:4px">Penomoran (<?= esc($year) ?>)</h2>
    <p style="color:var(--muted);font-size:14px;margin-bottom:20px">Token template: <code>{PREFIX}</code> <code>{AGENDA}</code> <code>{CODE}</code> <code>{YEAR}</code></p>
    <?php if(session()->getFlashdata('success')): ?><div style="background:#ECFDF5;color:#047857;padding:12px;border-radius:10px;margin-bottom:15px"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
    <form action="<?= site_url('admin/penomoran/save') ?>" method="post">
        <?= csrf_field() ?>
        <div style="overflow-x:auto"><table>
        <tr><th>Jenis</th><th>Kode</th><th>Terpakai <?= esc($year) ?></th><th>Template Format</th><th>Reset Counter</th></tr>
        <?php foreach($types as $t): $last = $seqMap[(int)$t['id']] ?? 0; ?>
        <tr>
            <td><strong><?= esc($t['name']) ?></strong></td>
            <td><?= esc($t['code']) ?></td>
            <td><span style="background:#DBEAFE;color:#0561B9;padding:4px 12px;border-radius:20px;font-weight:700;font-size:13px"><?= $last ?></span></td>
            <td><input type="text" name="tpl[<?= $t['id'] ?>]" value="<?= esc($t['format_template'] ?? '{PREFIX}/{AGENDA}/{CODE}/{YEAR}') ?>" style="width:320px;padding:8px 12px;border-radius:8px;border:1px solid #CBD5E1;font-family:monospace;font-size:13px"></td>
            <td><label style="font-size:13px"><input type="checkbox" name="reset[<?= $t['id'] ?>]" value="1"> Reset ke 0</label></td>
        </tr>
        <?php endforeach; ?>
        </table></div>
        <div style="margin-top:16px"><button type="submit" style="background:#0561B9;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer">Simpan Template</button></div>
    </form>
</div>
</div>
<?= $this->endSection() ?>
