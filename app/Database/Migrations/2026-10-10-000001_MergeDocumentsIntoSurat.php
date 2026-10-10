<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class MergeDocumentsIntoSurat extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        if (!$db->fieldExists('division_id', 'surat')) {
            $this->forge->addColumn('surat', [
                'division_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'user_id'],
            ]);
        }
        if (!$db->fieldExists('document_type_id', 'surat')) {
            $this->forge->addColumn('surat', [
                'document_type_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true, 'after' => 'division_id'],
            ]);
        }
        $prefix = $db->getPrefix();
        $dbName = $db->getDatabase();
        $idx = function (string $table, string $col) use ($db, $dbName, $prefix): bool {
            $t = $prefix . $table;
            $row = $db->query("SELECT COUNT(*) AS c FROM INFORMATION_SCHEMA.STATISTICS WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_NAME=?", [$dbName, $t, $col])->getRowArray();
            return ((int)($row['c'] ?? 0)) > 0;
        };
        foreach ([
            ['surat', 'user_id'],
            ['surat', 'document_type_id'],
            ['surat', 'division_id'],
            ['surat', 'status'],
            ['surat', 'tanggal'],
        ] as [$t, $c]) {
            if (!$idx($t, $c)) {
                try { $db->query("CREATE INDEX `idx_{$t}_{$c}` ON `{$prefix}{$t}` (`{$c}`)"); } catch (\Throwable $e) {}
            }
        }
    }
    public function down()
    {
        $db = \Config\Database::connect();
        $prefix = $db->getPrefix();
        foreach (['user_id','document_type_id','division_id','status','tanggal'] as $c) {
            try { $db->query("DROP INDEX `idx_surat_{$c}` ON `{$prefix}surat`"); } catch (\Throwable $e) {}
        }
        if ($db->fieldExists('document_type_id', 'surat')) {
            try { $this->forge->dropColumn('surat', 'document_type_id'); } catch (\Throwable $e) {}
        }
        if ($db->fieldExists('division_id', 'surat')) {
            try { $this->forge->dropColumn('surat', 'division_id'); } catch (\Throwable $e) {}
        }
    }
}
