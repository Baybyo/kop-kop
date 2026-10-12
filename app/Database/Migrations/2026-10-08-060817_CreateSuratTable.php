<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nomor_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'data' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat');
    }

    public function down()
    {
        $this->forge->dropTable('surat');
    }
}