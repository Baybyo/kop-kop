<?= $this->extend('layout/main') ?>
<?= $this->section('styles') ?>
<style>
@media(max-width:900px){.lp-stats{grid-template-columns:repeat(2,1fr)!important}.lp-filter{grid-template-columns:1fr 1fr!important}}
@media(max-width:640px){.lp-head{flex-direction:column;align-items:stretch!important}.lp-stats{grid-template-columns:1fr!important}.lp-filter{grid-template-columns:1fr!important}}
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="page-wrap">
    <div class="lp-head" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:24px">
        <div>
            <h2 style="font-size:22px;font-weight:700;color:#16264A">Laporan & Rekapitulasi Naskah Dinas</h2>
            <p style="color:#64748B;font-size:14px;margin-top:2px">Rekapitulasi berkas berdasarkan jenis, status, dan periode tanggal</p>
        </div>
        <div>
            <a href="<?= site_url('laporan/export?'.http_build_query($f)) ?>" style="display:inline-flex;align-items:center;gap:8px;background:#0C7B4C;color:#fff;padding:10px 18px;border-radius:10px;font-weight:600;font-size:14px">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Ekspor CSV
            </a>
        </div>
    </div>

    <!-- Ringkasan Stat -->
    <div class="lp-stats" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#64748B;font-weight:500">Total Berkas</div>
            <div style="font-size:26px;font-weight:700;color:#16264A;margin-top:4px"><?= $rekap['total'] ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0C7B4C;font-weight:500">Terverifikasi</div>
            <div style="font-size:26px;font-weight:700;color:#0C7B4C;margin-top:4px"><?= $rekap['verified'] ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#0561B9;font-weight:500">Menunggu (Draft)</div>
            <div style="font-size:26px;font-weight:700;color:#0561B9;margin-top:4px"><?= $rekap['draft'] ?></div>
        </div>
        <div style="background:#fff;padding:18px 20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.03)">
            <div style="font-size:13px;color:#EF4444;font-weight:500">Ditolak</div>
            <div style="font-size:26px;font-weight:700;color:#EF4444;margin-top:4px"><?= $rekap['rejected'] ?></div>
        </div>
    </div>

    <!-- Filter Form -->
    <div style="background:#fff;padding:20px 24px;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);margin-bottom:24px">
        <form method="get" action="<?= site_url('laporan') ?>" class="lp-filter" style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;align-items:end">
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Jenis Surat</label>
                <select name="jenis" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
                    <option value="">Semua Jenis</option>
                    <option value="Surat Perintah Tugas" <?= ($f['jenis']==='Surat Perintah Tugas')?'selected':'' ?>>SPT</option>
                    <option value="Surat Keputusan Kepala Dinas" <?= ($f['jenis']==='Surat Keputusan Kepala Dinas')?'selected':'' ?>>SK</option>
                    <option value="Nota Dinas" <?= ($f['jenis']==='Nota Dinas')?'selected':'' ?>>Nota Dinas</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Status</label>
                <select name="status" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
                    <option value="">Semua Status</option>
                    <option value="draft" <?= ($f['status']==='draft')?'selected':'' ?>>Draft / Pending</option>
                    <option value="verified" <?= ($f['status']==='verified')?'selected':'' ?>>Verified</option>
                    <option value="rejected" <?= ($f['status']==='rejected')?'selected':'' ?>>Rejected</option>
                </select>
            </div>
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Dari Tanggal</label>
                <input type="date" name="dari" value="<?= esc($f['dari']) ?>" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
            </div>
            <div>
                <label style="display:block;font-size:12.5px;font-weight:600;color:#475569;margin-bottom:6px">Sampai Tanggal</label>
                <input type="date" name="sampai" value="<?= esc($f['sampai']) ?>" style="width:100%;padding:9px 12px;border:1px solid #CBD5E1;border-radius:8px;font-size:13.5px">
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" style="flex:1;background:#0561B9;color:#fff;border:none;padding:10px;border-radius:8px;font-weight:600;font-size:13.5px;cursor:pointer">Filter</button>
                <a href="<?= site_url('laporan') ?>" style="padding:10px 14px;border:1px solid #CBD5E1;border-radius:8px;color:#64748B;font-size:13.5px;text-align:center">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive" style="background:#fff;border-radius:14px;box-shadow:0 4px 16px rgba(0,0,0,.04);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13.5px;min-width:700px">
            <thead>
                <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0;text-align:left;color:#475569;font-weight:600">
                    <th style="padding:14px 18px">ID</th>
                    <th style="padding:14px 18px">Nomor Surat / Agenda</th>
                    <th style="padding:14px 18px">Jenis Surat</th>
                    <th style="padding:14px 18px">Tanggal</th>
                    <th style="padding:14px 18px">Perihal</th>
                    <th style="padding:14px 18px">Status</th>
                    <th style="padding:14px 18px;text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="7" style="padding:32px;text-align:center;color:#94A3B8">Tidak ada data naskah dinas sesuai filter.</td>
                </tr>
                <?php else: foreach ($rows as $r): ?>
                <tr style="border-bottom:1px solid #F1F5F9">
                    <td style="padding:14px 18px;font-weight:600;color:#16264A">#<?= $r['id'] ?></td>
                    <td style="padding:14px 18px">
                        <div style="font-weight:600;color:#16264A"><?= esc($r['nomor_surat']) ?></div>
                        <div style="font-size:12px;color:#64748B">Agenda: <?= esc($r['nomor_agenda'] ?? '-') ?></div>
                    </td>
                    <td style="padding:14px 18px"><?= esc($r['jenis_surat']) ?></td>
                    <td style="padding:14px 18px"><?= esc($r['tanggal']) ?></td>
                    <td style="padding:14px 18px;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= esc($r['perihal']) ?></td>
                    <td style="padding:14px 18px">
                        <?php
                            $st = $r['status'] ?? 'draft';
                            $bg = '#F1F5F9'; $color = '#475569';
                            if ($st==='verified') { $bg='#DCFCE7'; $color='#166534'; }
                            elseif ($st==='rejected') { $bg='#FEE2E2'; $color='#991B1B'; }
                            elseif ($st==='draft') { $bg='#E0F2FE'; $color='#075985'; }
                        ?>
                        <span style="background:<?= $bg ?>;color:<?= $color ?>;padding:4px 10px;border-radius:20px;font-weight:600;font-size:11.5px;text-transform:uppercase"><?= esc($st) ?></span>
                    </td>
                    <td style="padding:14px 18px;text-align:right">
                        <a href="<?= site_url('surat/preview/'.$r['id']) ?>" style="color:#0561B9;font-weight:600;font-size:13px">Detail &rarr;</a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
