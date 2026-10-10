<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateDocumentsAndCoreTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'name' => ['type' => 'VARCHAR','constraint' => 150],
            'code' => ['type' => 'VARCHAR','constraint' => 50,'null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('divisions', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'name' => ['type' => 'VARCHAR','constraint' => 100],
            'code' => ['type' => 'VARCHAR','constraint' => 50],
            'format_template' => ['type' => 'TEXT','null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('document_types', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'document_type_id' => ['type' => 'INT','unsigned' => true],
            'last_number' => ['type' => 'INT','unsigned' => true,'default' => 0],
            'year' => ['type' => 'INT','constraint' => 4,'default' => 2026],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['document_type_id','year']);
        $this->forge->addForeignKey('document_type_id','document_types','id','CASCADE','CASCADE');
        $this->forge->createTable('document_sequences', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'user_id' => ['type' => 'INT','unsigned' => true],
            'division_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'document_type_id' => ['type' => 'INT','unsigned' => true],
            'agenda_number' => ['type' => 'INT','unsigned' => true],
            'nomor_agenda' => ['type' => 'VARCHAR','constraint' => 30],
            'nomor_surat' => ['type' => 'VARCHAR','constraint' => 150],
            'tanggal' => ['type' => 'DATE'],
            'perihal' => ['type' => 'TEXT'],
            'surat_dari' => ['type' => 'VARCHAR','constraint' => 150],
            'nama_ditugaskan' => ['type' => 'VARCHAR','constraint' => 255,'null' => true],
            'status' => ['type' => 'VARCHAR','constraint' => 30,'default' => 'draft'],
            'data' => ['type' => 'LONGTEXT','null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
            'updated_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('division_id','divisions','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('document_type_id','document_types','id','CASCADE','CASCADE');
        $this->forge->createTable('documents', true);
    }

    public function down()
    {
        $this->forge->dropTable('documents', true);
        $this->forge->dropTable('document_sequences', true);
        $this->forge->dropTable('document_types', true);
        $this->forge->dropTable('divisions', true);
    }
}
