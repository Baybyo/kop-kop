<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div style="max-width:1160px;margin:32px auto 0;padding:0 30px">
    <div style="margin-bottom:24px">
        <h2 style="font-size:22px;font-weight:700;color:#16264A">Telemetri & System Health</h2>
        <p style="color:#64748B;font-size:14px;margin-top:2px">Pemantauan eksekutif integritas naskah, sequence penomoran, dan gateway eksternal</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#64748B;font-weight:500">Total Naskah Dinas</div>
            <div style="font-size:24px;font-weight:700;color:#16264A;margin-top:4px"><?= $stats['total'] ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0C7B4C;font-weight:500">Sequence Sah & Valid</div>
            <div style="font-size:24px;font-weight:700;color:#0C7B4C;margin-top:4px"><?= $stats['verified'] ?> Sah</div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0561B9;font-weight:500">Pengguna Aktif ASN</div>
            <div style="font-size:24px;font-weight:700;color:#0561B9;margin-top:4px"><?= $stats['users'] ?> User</div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#EF4444;font-weight:500">Aksi Kritis / Risiko</div>
            <div style="font-size:24px;font-weight:700;color:#EF4444;margin-top:4px"><?= $stats['risky'] ?></div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">
        <div style="background:#fff;padding:20px 24px;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04)">
            <h3 style="font-size:15px;font-weight:700;color:#16264A;margin-bottom:12px">Infrastruktur & Gateway</h3>
            <div style="font-size:13.5px;color:#334155;line-height:1.9">
                <div>PHP Runtime: <strong><?= esc($php) ?></strong></div>
                <div>Database Engine: <strong><?= esc($db) ?></strong> (InnoDB ACID)</div>
                <div>BSrE BSSN Sertifikasi: <strong style="color:#0C7B4C">Online</strong></div>
                <div>SIM-ASN BKD Jatim: <strong style="color:#0C7B4C">Terhubung (HTTP 200)</strong></div>
                <div>Cadangan Off-site Diskominfo: <strong>Harian 03:00 WIB (AES)</strong></div>
            </div>
        </div>
        <div style="background:#fff;padding:20px 24px;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04)">
            <h3 style="font-size:15px;font-weight:700;color:#16264A;margin-bottom:12px">Komposisi Status Naskah</h3>
            <div style="font-size:13.5px;color:#334155;line-height:1.9">
                <div>Draft / Menunggu: <strong><?= $stats['draft'] ?></strong></div>
                <div>Terverifikasi: <strong><?= $stats['verified'] ?></strong></div>
                <div>Ditolak: <strong><?= $stats['rejected'] ?></strong></div>
                <div>Total Event Audit: <strong><?= $stats['logs'] ?></strong></div>
            </div>
        </div>
    </div>

    <div style="background:#fff;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);overflow:hidden">
        <div style="padding:16px 24px;border-bottom:1px solid #E2E8F0;font-weight:700;color:#16264A">Aktivitas Kritis Terbaru</div>
        <table style="width:100%;border-collapse:collapse;font-size:13.5px">
            <thead>
                <tr style="background:#F8FAFC;text-align:left;color:#475569">
                    <th style="padding:12px 18px">Waktu</th>
                    <th style="padding:12px 18px">Pegawai</th>
                    <th style="padding:12px 18px">Aksi</th>
                    <th style="padding:12px 18px">Target</th>
                    <th style="padding:12px 18px">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recent)): ?>
                <tr><td colspan="5" style="padding:28px;text-align:center;color:#94A3B8">Belum ada aktivitas tercatat.</td></tr>
                <?php else: foreach ($recent as $r): ?>
                <tr style="border-bottom:1px solid #F1F5F9">
                    <td style="padding:12px 18px"><?= esc($r['created_at']) ?></td>
                    <td style="padding:12px 18px;font-weight:600"><?= esc($r['actor_name'] ?? 'System') ?></td>
                    <td style="padding:12px 18px"><?= esc($r['action']) ?></td>
                    <td style="padding:12px 18px"><?= esc($r['entity']) ?> #<?= esc($r['entity_id']) ?></td>
                    <td style="padding:12px 18px"><span style="background:#DCFCE7;color:#166534;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700">LOGGED</span></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
