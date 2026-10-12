<?php
if (!function_exists('formatNomorAgenda')) {
    function formatNomorAgenda(int $number): string {
        $length = max(4, strlen((string)$number));
        return str_pad((string)$number, $length, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('suratDariByRole')) {
    function suratDariByRole(?string $role): string {
        $map = [
            'sekretariat' => 'Sekretariat',
            'pelatihan' => 'Bidang Pelatihan dan Produktivitas',
            'penempatan' => 'Bidang Penempatan dan Perluasan Kesempatan Kerja',
            'pengawasan' => 'Bidang Pengawasan Ketenagakerjaan dan K3',
            'hubungan_industrial' => 'Bidang Hubungan Industrial dan Jaminan Sosial',
            'admin' => 'Administrator',
            'superadmin' => 'Superadmin',
        ];
        return $map[$role ?? ''] ?? 'Dinas Tenaga Kerja dan Transmigrasi';
    }
}
if (!function_exists('resolveDocumentTypeId')) {
    function resolveDocumentTypeId(string $jenis): int {
        $map = ['perintah-tugas' => 'SPT','keputusan' => 'SK','nota-dinas' => 'ND'];
        $code = $map[$jenis] ?? 'SPT';
        $row = \Config\Database::connect()->table('document_types')->where('code', $code)->get()->getRowArray();
        return (int)($row['id'] ?? 1);
    }
}
if (!function_exists('notificationData')) {
    function notificationData(?string $role = null, ?int $userId = null): array {
        $role = $role ?? (string)session()->get('role');
        $userId = $userId ?? (int)session()->get('user_id');
        $db = \Config\Database::connect();
        $isAdmin = in_array($role, ['admin','superadmin'], true);
        if ($isAdmin) {
            $count = (int)$db->table('surat')->where('status','draft')->countAllResults();
            $items = $db->table('surat')->where('status','draft')->orderBy('created_at','DESC')->limit(5)->get()->getResultArray();
        } else {
            $count = (int)$db->table('surat')->where('user_id',$userId)->whereIn('status',['verified','rejected'])->countAllResults();
            $items = $db->table('surat')->where('user_id',$userId)->whereIn('status',['verified','rejected'])->orderBy('updated_at','DESC')->limit(5)->get()->getResultArray();
            if ($count===0) {
                $items = $db->table('surat')->where('user_id',$userId)->orderBy('created_at','DESC')->limit(5)->get()->getResultArray();
                $count = 0;
                foreach ($items as $it) { if (in_array($it['status'],['draft'],true)) $count++; }
                if ($count>5) $count=5;
            }
        }
        return ['count'=>$count,'items'=>$items,'isAdmin'=>$isAdmin];
    }
}
if (!function_exists('auditLog')) {
    function auditLog(string $action, ?string $entity = null, ?int $entityId = null, $payload = null): void {
        try {
            \Config\Database::connect()->table('audit_logs')->insert([
                'actor_id' => (int)session()->get('user_id') ?: null,
                'action' => $action, 'entity' => $entity, 'entity_id' => $entityId,
                'payload' => is_string($payload) ? $payload : json_encode($payload ?? [], JSON_UNESCAPED_UNICODE),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {}
    }
}
// ponytail: preview-only peek via MAX, real allocation happens in NumberingService::allocate (FOR UPDATE) at save time.
if (!function_exists('nextAgendaNumber')) {
    function nextAgendaNumber(?int $documentTypeId = null): int {
        if ($documentTypeId === null) return 1;
        $db = \Config\Database::connect();
        $row = $db->table('document_sequences')->selectMax('last_number', 'm')->where('document_type_id', $documentTypeId)->get()->getRowArray();
        return (int)($row['m'] ?? 0) + 1;
    }
}
