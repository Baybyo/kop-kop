<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateSupportTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'document_id' => ['type' => 'INT','unsigned' => true],
            'status_from' => ['type' => 'VARCHAR','constraint' => 30,'null' => true],
            'status_to' => ['type' => 'VARCHAR','constraint' => 30],
            'note' => ['type' => 'TEXT','null' => true],
            'actor_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('document_status_histories', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'document_id' => ['type' => 'INT','unsigned' => true],
            'action' => ['type' => 'VARCHAR','constraint' => 30],
            'note' => ['type' => 'TEXT','null' => true],
            'actor_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('document_verifications', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'document_id' => ['type' => 'INT','unsigned' => true],
            'file_name' => ['type' => 'VARCHAR','constraint' => 255],
            'file_path' => ['type' => 'VARCHAR','constraint' => 255],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('document_attachments', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            'sender_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'receiver_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'subject' => ['type' => 'VARCHAR','constraint' => 150,'null' => true],
            'body' => ['type' => 'TEXT'],
            'is_read' => ['type' => 'TINYINT','constraint' => 1,'default' => 0],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('messages', true);

        $this->forge->addField([
            'id' => ['type' => 'BIGINT','unsigned' => true,'auto_increment' => true],
            'actor_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'action' => ['type' => 'VARCHAR','constraint' => 80],
            'entity' => ['type' => 'VARCHAR','constraint' => 80,'null' => true],
            'entity_id' => ['type' => 'INT','unsigned' => true,'null' => true],
            'payload' => ['type' => 'TEXT','null' => true],
            'created_at' => ['type' => 'DATETIME','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('audit_logs', true);

        $this->forge->addField([
            'id' => ['type' => 'INT','unsigned' => true,'auto_increment' => true],
            '`key`' => ['type' => 'VARCHAR','constraint' => 100],
            'value' => ['type' => 'TEXT','null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('system_settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('system_settings', true);
        $this->forge->dropTable('audit_logs', true);
        $this->forge->dropTable('messages', true);
        $this->forge->dropTable('document_attachments', true);
        $this->forge->dropTable('document_verifications', true);
        $this->forge->dropTable('document_status_histories', true);
    }
}
