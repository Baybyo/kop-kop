<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateRbacTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'slug' => ['type' => 'VARCHAR','constraint' => 30],
            'name' => ['type' => 'VARCHAR','constraint' => 100],
            'created_at' => ['type' => 'DATETIME','null' => true],
            'updated_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('roles', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'slug' => ['type' => 'VARCHAR','constraint' => 80],
            'name' => ['type' => 'VARCHAR','constraint' => 150],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('permissions', true);

        $this->forge->addField([
            'role_id' => ['type' => 'INT','unsigned' => true],
            'permission_id' => ['type' => 'INT','unsigned' => true],
        ]);
        $this->forge->addKey(['role_id','permission_id'], true);
        $this->forge->addForeignKey('role_id','roles','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('permission_id','permissions','id','CASCADE','CASCADE');
        $this->forge->createTable('role_permissions', true);
    }
    public function down()
    {
        $this->forge->dropTable('role_permissions', true);
        $this->forge->dropTable('permissions', true);
        $this->forge->dropTable('roles', true);
    }
}
