<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<style>
.notif-wrap{max-width:760px;margin:32px auto 0;padding:0 20px}
.notif-card{background:#fff;border-radius:16px;box-shadow:0 18px 44px rgba(15,23,42,.10);padding:28px 30px}
.notif-head{display:flex;align-items:center;gap:14px;margin-bottom:22px}
.notif-ico{width:46px;height:46px;border-radius:12px;background:#E0EDFF;color:#0561B9;display:flex;align-items:center;justify-content:center}
.notif-head h2{font-size:20px;font-weight:700;color:#16264A}
.notif-head p{font-size:13.5px;color:#64748B;margin-top:2px}
.notif-item{display:flex;gap:14px;padding:15px 16px;border:1px solid #E8EEF6;border-radius:12px;margin-bottom:12px;transition:border .2s,box-shadow .2s}
.notif-item:hover{border-color:#0561B9;box-shadow:0 8px 20px rgba(5,97,185,.10)}
.notif-dot{width:10px;height:10px;border-radius:50%;margin-top:6px;flex-shrink:0}
.notif-body{flex:1;min-width:0}
.notif-title{font-weight:600;color:#16264A;font-size:14px;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.notif-sub{color:#64748B;font-size:13px;margin-top:4px}
.notif-msg{background:#F8FAFC;border:1px dashed #CBD5E1;border-radius:8px;padding:10px 12px;font-size:13px;color:#334155;margin-top:8px;display:<?= $isAdmin ? 'none' : 'block' ?>}
.notif-empty{text-align:center;color:#94A3B8;font-size:14px;padding:34px 10px}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="notif-wrap">
    <div class="notif-card">
        <div class="notif-head">
            <div class="notif-ico">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M6.5 9.5a5.5 5.5 0 0 1 11 0c0 4.5 1.8 5.8 1.8 5.8H4.7s1.8-1.3 1.8-5.8"/><path d="M10.2 19a2.2 2.2 0 0 0 3.6 0"/></svg>
            </div>
            <div>
                <h2>Notifikasi & Pesan Balasan</h2>
                <p><?= $isAdmin ? 'Naskah dinas menunggu verifikasi TU' : 'Status verifikasi & pesan balasan dari TU' ?></p>
            </div>
        </div>

        <?php if (empty($items)): ?>
            <div class="notif-empty">Tidak ada notifikasi baru.</div>
        <?php else: foreach ($items as $n):
            $st = $n['status'] ?? 'draft';
            $c = $st === 'verified' ? '#0C7B4C' : ($st === 'rejected' ? '#EF4444' : '#0561B9');
        ?>
        <a href="<?= site_url('surat/preview/'.$n['id']) ?>" class="notif-item">
            <span class="notif-dot" style="background:<?= $c ?>"></span>
            <div class="notif-body">
                <div class="notif-title">
                    #<?= $n['id'] ?> · <?= esc($n['jenis_surat']) ?>
                    <span style="background:<?= $c ?>1A;color:<?= $c ?>;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase"><?= esc($st) ?></span>
                </div>
                <div class="notif-sub"><?= esc(mb_strimwidth($n['perihal'] ?? $n['nomor_surat'] ?? '', 0, 90, '...')) ?> · <?= esc($n['tanggal'] ?? '') ?></div>
                <?php if (!$isAdmin && !empty($n['catatan_admin'])): ?>
                    <div class="notif-msg"><strong>Pesan TU:</strong> <?= esc($n['catatan_admin']) ?></div>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
