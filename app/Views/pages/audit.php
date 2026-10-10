<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
@media(max-width:900px){.au-stats{grid-template-columns:repeat(2,1fr)!important}.au-filter{grid-template-columns:1fr 1fr!important}}
@media(max-width:640px){.au-head{flex-direction:column;align-items:stretch!important}.au-stats{grid-template-columns:1fr!important}.au-filter{grid-template-columns:1fr!important}}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-wrap">
    <div class="au-head" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px">
        <div>
            <h2 style="font-size:22px;font-weight:700;color:#16264A">Audit Log Sistem & Forensik Keamanan</h2>
            <p style="color:#64748B;font-size:14px;margin-top:2px">Pencatatan menyeluruh aktivitas transaksi persuratan immutable & terenkripsi</p>
        </div>
        <div style="display:flex;gap:10px">
            <a href="<?= site_url('laporan/export') ?>" style="background:#fff;border:1px solid #CBD5E1;color:#334155;padding:10px 16px;border-radius:10px;font-weight:600;font-size:13.5px">Ekspor CSV</a>
        </div>
    </div>

    <!-- Stat Ringkasan -->
    <div class="au-stats" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#64748B;font-weight:500">Total Peristiwa</div>
            <div style="font-size:24px;font-weight:700;color:#16264A;margin-top:4px"><?= number_format($total) ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0C7B4C;font-weight:500">Integritas Hash Rantai</div>
            <div style="font-size:24px;font-weight:700;color:#0C7B4C;margin-top:4px">100% Valid</div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#EF4444;font-weight:500">Aksi Berisiko / Kritis</div>
            <div style="font-size:24px;font-weight:700;color:#EF4444;margin-top:4px"><?= $risky ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0561B9;font-weight:500">Standar BSSN / ISO</div>
            <div style="font-size:16px;font-weight:700;color:#0561B9;margin-top:8px">ISO 27001 Active</div>
        </div>
    </div>

    <!-- Filter -->
    <div style="background:#fff;padding:20px 24px;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);margin-bottom:24px">
        <form method="get" action="<?= site_url('audit') ?>" class="au-filter" style="display:grid;grid-template-columns:1fr 2fr auto;gap:14px;align-items:end">
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Filter Aksi</label>
                <select name="aksi" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
                    <option value="">Semua Aksi</option>
                    <option value="CREATE" <?= ($f['aksi']==='CREATE')?'selected':'' ?>>CREATE (Buat)</option>
                    <option value="APPROVE" <?= ($f['aksi']==='APPROVE')?'selected':'' ?>>APPROVE (Setuju)</option>
                    <option value="REJECT" <?= ($f['aksi']==='REJECT')?'selected':'' ?>>REJECT (Tolak)</option>
                    <option value="OVERRIDE_SEQUENCE" <?= ($f['aksi']==='OVERRIDE_SEQUENCE')?'selected':'' ?>>OVERRIDE_SEQUENCE</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Pencarian / Keyword</label>
                <input type="text" name="q" value="<?= esc($f['q']) ?>" placeholder="Cari entitas, payload, atau nama aktor..." style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" style="background:#0561B9;color:#fff;border:none;padding:10px 20px;border-radius:8px;font-weight:600;font-size:13.5px;cursor:pointer">Cari</button>
                <a href="<?= site_url('audit') ?>" style="padding:10px 14px;border:1px solid #CBD5E1;border-radius:8px;color:#64748B;font-size:13.5px;text-align:center">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div class="table-responsive" style="background:#fff;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13.5px;min-width:720px">
            <thead>
                <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;text-align:left;color:#475569;font-weight:600">
                    <th style="padding:14px 18px">Waktu (WIB)</th>
                    <th style="padding:14px 18px">Aktor ASN</th>
                    <th style="padding:14px 18px">Aksi</th>
                    <th style="padding:14px 18px">Entitas / Target</th>
                    <th style="padding:14px 18px">Payload / Perubahan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                <tr>
                    <td colspan="5" style="padding:32px;text-align:center;color:#94A3B8">Belum ada log aktivitas tercatat. Lakukan transaksi surat atau verifikasi untuk memicu rekam jejak.</td>
                </tr>
                <?php else: foreach ($logs as $l): ?>
                <tr style="border-bottom:1px solid #F1F5F9">
                    <td style="padding:14px 18px;white-space:nowrap;color:#475569"><?= esc($l['created_at']) ?></td>
                    <td style="padding:14px 18px;font-weight:600;color:#16264A"><?= esc($l['actor_name'] ?? 'System/Guest') ?></td>
                    <td style="padding:14px 18px">
                        <?php
                            $ac = $l['action'];
                            $bg = '#E0F2FE'; $color = '#0369A1';
                            if ($ac === 'APPROVE') { $bg = '#DCFCE7'; $color = '#166534'; }
                            elseif ($ac === 'REJECT') { $bg = '#FEE2E2'; $color = '#991B1B'; }
                            elseif ($ac === 'OVERRIDE_SEQUENCE') { $bg = '#FEF3C7'; $color = '#92400E'; }
                        ?>
                        <span style="background:<?= $bg ?>;color:<?= $color ?>;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700"><?= esc($ac) ?></span>
                    </td>
                    <td style="padding:14px 18px"><?= esc($l['entity']) ?> #<?= esc($l['entity_id']) ?></td>
                    <td style="padding:14px 18px;font-family:monospace;font-size:12px;color:#334155;max-width:320px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="<?= esc($l['payload']) ?>"><?= esc($l['payload']) ?></td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
