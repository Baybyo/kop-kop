<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKopsuratColumnsToSurat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('surat', [
            'user_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'id'],
            'agenda_number'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'jenis_surat'],
            'nomor_agenda'    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true, 'after' => 'agenda_number'],
            'nama_ditugaskan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'tanggal'],
            'perihal'         => ['type' => 'TEXT', 'null' => true, 'after' => 'nama_ditugaskan'],
            'surat_dari'      => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true, 'after' => 'perihal'],
            'status'          => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'draft', 'after' => 'surat_dari'],
            'catatan_admin'   => ['type' => 'TEXT', 'null' => true, 'after' => 'status'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('surat', ['user_id', 'agenda_number', 'nomor_agenda', 'nama_ditugaskan', 'perihal', 'surat_dari', 'status', 'catatan_admin']);
    }
}
