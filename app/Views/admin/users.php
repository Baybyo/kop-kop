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
    <h2 style="font-size:20px;font-weight:700;margin-bottom:4px">Kelola Pengguna & Role</h2>
    <p style="color:var(--muted);font-size:14px;margin-bottom:20px">Tambah atau edit akun pengguna dan role akses.</p>
    <?php if(session()->getFlashdata('success')): ?><div style="background:#ECFDF5;color:#047857;padding:12px;border-radius:10px;margin-bottom:15px"><?= session()->getFlashdata('success') ?></div><?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?><div style="background:#FEF2F2;color:#DC2626;padding:12px;border-radius:10px;margin-bottom:15px"><?= session()->getFlashdata('error') ?></div><?php endif; ?>

    <form action="<?= site_url('admin/users/save') ?>" method="post" style="background:#F8FAFC;padding:20px;border-radius:12px;border:1px solid #E2E8F0;margin-bottom:24px">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="userId" value="0">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px">
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Username</label><input type="text" name="username" id="userUsername" required style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Nama Lengkap</label><input type="text" name="name" id="userName" required style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Email</label><input type="email" name="email" id="userEmail" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Role</label>
                <select name="role" id="userRole" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1">
                    <option value="sekretariat">Sekretariat</option>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="penempatan">Penempatan</option>
                    <option value="pengawasan">Pengawasan</option>
                    <option value="hubungan_industrial">Hubungan Industrial</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Superadmin</option>
                </select>
            </div>
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Status</label>
                <select name="status" id="userStatus" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div><label style="font-size:13px;font-weight:600;display:block;margin-bottom:5px">Password (kosongkan jika tidak diubah)</label><input type="password" name="password" style="width:100%;padding:9px 12px;border-radius:8px;border:1px solid #CBD5E1"></div>
        </div>
        <div style="margin-top:16px"><button type="submit" style="background:#0C7B4C;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer">Simpan Pengguna</button> <button type="button" onclick="resetForm()" style="background:#E2E8F0;color:#334155;border:none;padding:10px 20px;border-radius:8px;font-weight:600;cursor:pointer;margin-left:8px">Reset</button></div>
    </form>

    <div style="overflow-x:auto"><table>
    <tr><th>ID</th><th>Username</th><th>Nama</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
    <?php foreach($users as $u): ?>
    <tr>
        <td>#<?= $u['id'] ?></td>
        <td><?= esc($u['username']) ?></td>
        <td><?= esc($u['name']) ?></td>
        <td><span style="padding:4px 10px;border-radius:20px;font-size:12px;background:#E2E8F0;font-weight:600"><?= esc($u['role']) ?></span></td>
        <td><?= esc($u['status'] ?? 'active') ?></td>
        <td><button type="button" onclick="editUser(<?= htmlspecialchars(json_encode($u), ENT_QUOTES, 'UTF-8') ?>)" style="background:#EFF6FF;color:#0561B9;border:1px solid #BFDBFE;padding:6px 12px;border-radius:8px;font-weight:600;cursor:pointer">Edit</button></td>
    </tr>
    <?php endforeach; ?>
    </table></div>
</div>
</div>
<script>
function editUser(u) {
    document.getElementById('userId').value = u.id;
    document.getElementById('userUsername').value = u.username;
    document.getElementById('userName').value = u.name;
    document.getElementById('userEmail').value = u.email || '';
    document.getElementById('userRole').value = u.role || 'sekretariat';
    document.getElementById('userStatus').value = u.status || 'active';
    window.scrollTo({top:0, behavior:'smooth'});
}
function resetForm() {
    document.getElementById('userId').value = 0;
    document.getElementById('userUsername').value = '';
    document.getElementById('userName').value = '';
    document.getElementById('userEmail').value = '';
    document.getElementById('userRole').value = 'sekretariat';
    document.getElementById('userStatus').value = 'active';
}
</script>
<?= $this->endSection() ?>
