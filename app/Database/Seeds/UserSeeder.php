<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['username' => 'admin', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'name' => 'Administrator', 'role' => 'admin'],
            ['username' => 'superadmin', 'password' => password_hash('super123', PASSWORD_DEFAULT), 'name' => 'Super Administrator', 'role' => 'superadmin'],
            ['username' => 'sekretariat', 'password' => password_hash('sekretariat123', PASSWORD_DEFAULT), 'name' => 'Staff Sekretariat', 'role' => 'sekretariat'],
            ['username' => 'pelatihan', 'password' => password_hash('pelatihan123', PASSWORD_DEFAULT), 'name' => 'Staff Pelatihan', 'role' => 'pelatihan'],
            ['username' => 'penempatan', 'password' => password_hash('penempatan123', PASSWORD_DEFAULT), 'name' => 'Staff Penempatan', 'role' => 'penempatan'],
            ['username' => 'pengawasan', 'password' => password_hash('pengawasan123', PASSWORD_DEFAULT), 'name' => 'Staff Pengawasan', 'role' => 'pengawasan'],
            ['username' => 'industrial', 'password' => password_hash('industrial123', PASSWORD_DEFAULT), 'name' => 'Staff Hubungan Industrial', 'role' => 'hubungan_industrial'],
        ];

        foreach ($users as $u) {
            $exists = $this->db->table('users')->where('username', $u['username'])->get()->getRowArray();
            if ($exists) {
                $this->db->table('users')->where('username', $u['username'])->update([
                    'password' => $u['password'],
                    'name' => $u['name'],
                    'role' => $u['role'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                continue;
            }
            $u['created_at'] = date('Y-m-d H:i:s');
            $u['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('users')->insert($u);
        }
    }
}