<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class AlterUsersForRbac extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        if (!$db->fieldExists('email','users')) {
            $this->forge->addColumn('users', [
                'email' => ['type' => 'VARCHAR','constraint' => 150,'null' => true,'after' => 'name'],
            ]);
        }
        if (!$db->fieldExists('role_id','users')) {
            $this->forge->addColumn('users', [
                'role_id' => ['type' => 'INT','constraint' => 11,'unsigned' => true,'null' => true,'after' => 'role'],
                'division_id' => ['type' => 'INT','constraint' => 11,'unsigned' => true,'null' => true,'after' => 'role_id'],
                'status' => ['type' => 'VARCHAR','constraint' => 20,'default' => 'active','after' => 'pangkat_golongan'],
                'deleted_at' => ['type' => 'DATETIME','null' => true,'after' => 'updated_at'],
            ]);
        }
    }
    public function down()
    {
        $this->forge->dropColumn('users', ['role_id','division_id','status','deleted_at','email']);
    }
}
