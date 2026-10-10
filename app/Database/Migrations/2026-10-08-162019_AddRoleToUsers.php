<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'sekretariat', 'after' => 'name'],
            'nip' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'role'],
            'jabatan' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'nip'],
            'pangkat_golongan' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true, 'after' => 'jabatan'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['role', 'nip', 'jabatan', 'pangkat_golongan']);
    }
}
