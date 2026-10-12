<?php
namespace App\Services;
use Config\Database;
class NumberingService
{
    public function allocate(int $documentTypeId, ?int $year = null): int
    {
        $year ??= (int) date('Y');
        $db = Database::connect();
        $db->transStart();
        $row = $db->query(
            'SELECT id, last_number FROM document_sequences WHERE document_type_id = ? AND `year` = ? FOR UPDATE',
            [$documentTypeId, $year]
        )->getRowArray();
        if (!$row) {
            $db->table('document_sequences')->insert(['document_type_id' => $documentTypeId, 'last_number' => 1, 'year' => $year]);
            $next = 1;
        } else {
            $next = ((int) $row['last_number']) + 1;
            $db->table('document_sequences')->where('id', $row['id'])->update(['last_number' => $next]);
        }
        $db->transComplete();
        return $next;
    }

    public function buildNumber(string $prefix, int $agenda, string $code, string $year, string $template = '{PREFIX}/{AGENDA}/{CODE}/{YEAR}'): array
    {
        $agendaFmt = str_pad((string) $agenda, 4, '0', STR_PAD_LEFT);
        $number = str_replace(['{PREFIX}','{AGENDA}','{CODE}','{YEAR}'], [$prefix, $agendaFmt, $code, $year], $template);
        return ['number' => $number, 'agenda' => $agenda, 'agenda_formatted' => $agendaFmt];
    }
}
