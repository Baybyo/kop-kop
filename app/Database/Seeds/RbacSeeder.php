<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class RbacSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['slug' => 'user', 'name' => 'User'],
            ['slug' => 'admin', 'name' => 'Admin'],
            ['slug' => 'superadmin', 'name' => 'Superadmin'],
        ];
        foreach ($roles as $r) $this->db->table('roles')->ignore(true)->insert($r);

        $perms = ['document.create','document.read.own','document.read.all','document.verify','document.manage','user.manage','settings.manage','audit.read','reports.read','admin.view'];
        foreach ($perms as $p) $this->db->table('permissions')->ignore(true)->insert(['slug' => $p, 'name' => $p]);

        $roleRows = $this->db->table('roles')->get()->getResultArray();
        $permRows = $this->db->table('permissions')->get()->getResultArray();
        $roleMap = array_column($roleRows, 'id', 'slug');
        $permMap = array_column($permRows, 'id', 'slug');

        $map = [
            'user' => ['document.create','document.read.own'],
            'admin' => ['document.create','document.read.all','document.verify','reports.read','admin.view'],
            'superadmin' => $perms,
        ];
        foreach ($map as $roleSlug => $ps) {
            foreach ($ps as $slug) {
                $this->db->table('role_permissions')->ignore(true)->insert([
                    'role_id' => $roleMap[$roleSlug],
                    'permission_id' => $permMap[$slug],
                ]);
            }
        }

        $divs = ['Sekretariat','Bidang Pelatihan dan Produktivitas','Bidang Penempatan dan Perluasan Kesempatan Kerja','Bidang Pengawasan Ketenagakerjaan dan K3','Bidang Hubungan Industrial dan Jaminan Sosial'];
        foreach ($divs as $d) $this->db->table('divisions')->ignore(true)->insert(['name' => $d]);

        $types = [
            ['name' => 'Surat Perintah Tugas','code' => 'SPT','format_template' => '{PREFIX}/{AGENDA}/108/{YEAR}'],
            ['name' => 'Surat Keputusan','code' => 'SK','format_template' => '{PREFIX}/{AGENDA}/{SUFFIX}'],
            ['name' => 'Nota Dinas','code' => 'ND','format_template' => '{PREFIX}/{AGENDA}/108.{SUB}/{YEAR}'],
        ];
        foreach ($types as $t) $this->db->table('document_types')->ignore(true)->insert($t);

        $this->db->table('system_settings')->ignore(true)->insert(['key' => 'kode_instansi','value' => '108']);
        $this->db->table('system_settings')->ignore(true)->insert(['key' => 'timezone','value' => 'Asia/Jakarta']);

        $divId = $this->db->table('divisions')->select('id')->limit(1)->get()->getRowArray()['id'] ?? null;
        $roleUser = $roleMap['user'] ?? null;
        $roleAdmin = $roleMap['admin'] ?? null;
        $roleSuper = $roleMap['superadmin'] ?? null;
        $pass = password_hash('password', PASSWORD_DEFAULT);
        foreach ([
            ['username' => 'user1','name' => 'User Demo','role_id' => $roleUser,'division_id' => $divId],
            ['username' => 'admin','name' => 'Admin','role_id' => $roleAdmin,'division_id' => $divId],
            ['username' => 'superadmin','name' => 'Superadmin','role_id' => $roleSuper,'division_id' => $divId],
        ] as $u) {
            if (!$this->db->table('users')->where('username',$u['username'])->get()->getRowArray()) {
                $this->db->table('users')->insert(['username'=>$u['username'],'password'=>$pass,'name'=>$u['name'],'role'=>($u['username']==='admin'?'admin':($u['username']==='superadmin'?'superadmin':'sekretariat')),'role_id'=>$u['role_id'],'division_id'=>$u['division_id']]);
            }
        }
    }
}
