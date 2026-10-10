<?= $this->extend('layout/main') ?>

<?= $this->section('styles') ?>
<style>
    .hero {
        position: relative;
        height: 340px;
        overflow: hidden;
    }

    .hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 58%;
        display: block;
    }

    .hero .hero-wave {
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 100%;
        height: 120px;
        display: block;
    }

    .cards {
        position: relative;
        z-index: 5;
        max-width: 1160px;
        margin: 4px auto 0;
        padding: 0 36px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .card {
        background: #fff;
        border-radius: 16px;
        padding: 34px 28px 76px;
        text-align: center;
        box-shadow: 0 18px 44px rgba(15, 23, 42, .10);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 26px 54px rgba(15, 23, 42, .15);
    }

    .card-icon {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .card-icon svg { width: 52px; height: 52px; }

    .card h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.35;
        min-height: 54px;
    }

    .card-line {
        width: 46px;
        height: 3.5px;
        border-radius: 3px;
        margin: 14px 0 16px;
    }

    .card-btn {
        width: 100%;
        margin-top: auto;
        padding: 14px;
        border-radius: 10px;
        color: #fff;
        font-size: 15.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        position: relative;
        z-index: 2;
        transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    }

    .card-btn:hover { transform: translateY(-2px); filter: brightness(1.08); }
    .card-btn:active { transform: translateY(0); }

    .card-wave {
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 100%;
        height: 66px;
        display: block;
        z-index: 1;
    }

    /* tema kartu */
    .card.blue  .card-icon { background: #DBEAFE; }
    .card.blue  .card-line { background: #3B82F6; }
    .card.blue  .card-btn  { background: #0561B9; box-shadow: 0 8px 18px rgba(5,97,185,.30); }

    .card.green .card-icon { background: #D1FAE5; }
    .card.green .card-line { background: #10B981; }
    .card.green .card-btn  { background: #0C7B4C; box-shadow: 0 8px 18px rgba(12,123,76,.30); }

    .card.purple .card-icon { background: #EDE9FE; }
    .card.purple .card-line { background: #8B5CF6; }
    .card.purple .card-btn  { background: #6D2FD0; box-shadow: 0 8px 18px rgba(109,47,208,.30); }

    .page-waves {
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 100%;
        height: 210px;
        display: block;
        z-index: 1;
        pointer-events: none;
    }

    .dash-stats-admin,.dash-stats-user{position:relative;z-index:6}
    @media (max-width: 1000px) {
        .hero { height: 230px; }
        .cards { grid-template-columns: 1fr; margin-top: 0; max-width: 480px; }
        .dash-stats-admin{flex-direction:column!important;padding:0 18px!important;margin:-50px auto 22px!important}
        .dash-stats-user{grid-template-columns:repeat(2,1fr)!important;padding:0 18px!important;margin:-50px auto 22px!important}
    }
    @media (max-width:640px){.dash-stats-user{grid-template-columns:1fr!important}}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<section class="hero">
    <img src="<?= base_url('img/gedung-disnaker.webp') ?>" alt="Gedung Disnakertrans Provinsi Jawa Timur">
    <svg class="hero-wave" viewBox="0 0 1440 120" preserveAspectRatio="none">
        <path fill="#FFFFFF" d="M0,72 C230,124 440,34 710,56 C985,78 1205,128 1440,66 L1440,120 L0,120 Z"/>
    </svg>
</section>

<?php if (!empty($isAdmin)): ?>
<div class="dash-stats-admin" style="max-width: 1160px; margin: -60px auto 20px; padding: 0 36px; display: flex; gap: 20px; position: relative; z-index: 6;">
    <div style="background: #fff; padding: 20px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); flex: 1;">
        <h4 style="color: #64748B; font-size: 13px; text-transform: uppercase; font-weight: 600;">Total Surat Masuk / Dibuat</h4>
        <p style="font-size: 28px; font-weight: 700; color: #16264A; margin-top: 5px;"><?= esc($stats['totalSurat'] ?? 0) ?></p>
    </div>
    <div style="background: #fff; padding: 20px 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); flex: 1;">
        <h4 style="color: #64748B; font-size: 13px; text-transform: uppercase; font-weight: 600;">Total Pengguna Aktif</h4>
        <p style="font-size: 28px; font-weight: 700; color: #0561B9; margin-top: 5px;"><?= esc($stats['totalUser'] ?? 0) ?></p>
    </div>
</div>
<?php endif; ?>

<?php if (empty($isAdmin)): ?>
<div class="dash-stats-user" style="max-width: 1160px; margin: -60px auto 20px; padding: 0 36px; display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; position: relative; z-index: 6;">
    <div style="background: #fff; padding: 20px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <h4 style="color: #64748B; font-size: 12px; text-transform: uppercase; font-weight: 600;">Total Surat Saya</h4>
        <p style="font-size: 28px; font-weight: 700; color: #16264A; margin-top: 5px;"><?= esc($stats['totalSaya'] ?? 0) ?></p>
        <span style="font-size: 12px; color: #64748B;">Tahun Berjalan <?= date('Y') ?></span>
    </div>
    <div style="background: #fff; padding: 20px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <h4 style="color: #64748B; font-size: 12px; text-transform: uppercase; font-weight: 600;">Draft Tersimpan</h4>
        <p style="font-size: 28px; font-weight: 700; color: #64748B; margin-top: 5px;"><?= esc($stats['draftCount'] ?? 0) ?></p>
        <span style="font-size: 12px; color: #64748B;">Belum diajukan</span>
    </div>
    <div style="background: #fff; padding: 20px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <h4 style="color: #64748B; font-size: 12px; text-transform: uppercase; font-weight: 600;">Menunggu Verifikasi</h4>
        <p style="font-size: 28px; font-weight: 700; color: #D28A00; margin-top: 5px;"><?= esc($stats['pendingCount'] ?? 0) ?></p>
        <span style="font-size: 12px; color: #64748B;">Antrean verifikator</span>
    </div>
    <div style="background: #fff; padding: 20px 24px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <h4 style="color: #64748B; font-size: 12px; text-transform: uppercase; font-weight: 600;">Disetujui</h4>
        <p style="font-size: 28px; font-weight: 700; color: #04723E; margin-top: 5px;"><?= esc($stats['disetujuiCount'] ?? 0) ?></p>
        <span style="font-size: 12px; color: #64748B;">Siap cetak / arsip</span>
    </div>
</div>
<?php endif; ?>

<div class="cards">
    <?php if (!empty($isAdmin)): ?>
        <article class="card blue" style="grid-column: span 3; padding: 40px; text-align: left; display: block;">
            <h3 style="font-size: 24px; color: #16264A; margin-bottom: 10px;">Panel Kendali <?= ucfirst($role) ?></h3>
            <p style="color: #64748B; font-size: 15px; margin-bottom: 20px;">Anda memiliki hak akses penuh untuk mengelola, mengawasi, serta memverifikasi seluruh surat yang masuk dari berbagai bidang di lingkungan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur.</p>
            <div style="display: flex; gap: 15px;">
                <a href="<?= site_url('riwayat') ?>" class="card-btn" style="display:inline-block; width: auto; padding: 12px 24px;">Kelola Semua Surat &rarr;</a>
                <?php if ($role === 'superadmin'): ?>
                    <a href="<?= site_url('admin/users') ?>" class="card-btn" style="display:inline-block; width: auto; padding: 12px 24px; background: #6D2FD0; box-shadow: 0 8px 18px rgba(109,47,208,.3);">Manajemen User &rarr;</a>
                <?php endif; ?>
            </div>
        </article>
    <?php else: ?>
        <article class="card blue">
            <div class="card-icon">
                <svg viewBox="0 0 48 48" fill="none">
                    <path d="M12 7h16l9 9v19a4 4 0 0 1-4 4H12a4 4 0 0 1-4-4V11a4 4 0 0 1 4-4z" stroke="#0561B9" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M28 7v9h9" stroke="#0561B9" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M15 22h14M15 28h10" stroke="#0561B9" stroke-width="3.4" stroke-linecap="round"/>
                    <circle cx="36" cy="36" r="9.5" fill="#0561B9"/>
                    <path d="M36 31v5.2l3.4 2" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Surat Perintah<br>Tugas</h3>
            <span class="card-line"></span>
            <a class="card-btn" href="<?= site_url('surat/perintah-tugas') ?>">Buat Surat <span>&rarr;</span></a>
            <svg class="card-wave" viewBox="0 0 400 70" preserveAspectRatio="none">
                <path fill="#EFF6FF" d="M0,36 C72,66 148,10 228,28 C306,46 352,60 400,38 L400,70 L0,70 Z"/>
            </svg>
        </article>

        <article class="card green">
            <div class="card-icon">
                <svg viewBox="0 0 48 48" fill="none">
                    <path d="M12 7h16l9 9v19a4 4 0 0 1-4 4H12a4 4 0 0 1-4-4V11a4 4 0 0 1 4-4z" stroke="#0C7B4C" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M28 7v9h9" stroke="#0C7B4C" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M15 22h14M15 28h10" stroke="#0C7B4C" stroke-width="3.4" stroke-linecap="round"/>
                    <circle cx="36" cy="36" r="9.5" fill="#0C7B4C"/>
                    <path d="m33 40.4.8-3 6.1-6.1a1.5 1.5 0 0 1 2.1 0l.6.6a1.5 1.5 0 0 1 0 2.1l-6.1 6.1z" fill="#fff"/>
                </svg>
            </div>
            <h3>Surat Keputusan<br>Kepala Dinas</h3>
            <span class="card-line"></span>
            <a class="card-btn" href="<?= site_url('surat/keputusan') ?>">Buat Surat <span>&rarr;</span></a>
            <svg class="card-wave" viewBox="0 0 400 70" preserveAspectRatio="none">
                <path fill="#ECFDF5" d="M0,36 C72,66 148,10 228,28 C306,46 352,60 400,38 L400,70 L0,70 Z"/>
            </svg>
        </article>

        <article class="card purple">
            <div class="card-icon">
                <svg viewBox="0 0 48 48" fill="none">
                    <path d="M12 7h16l9 9v19a4 4 0 0 1-4 4H12a4 4 0 0 1-4-4V11a4 4 0 0 1 4-4z" stroke="#6D2FD0" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M28 7v9h9" stroke="#6D2FD0" stroke-width="3.4" stroke-linejoin="round"/>
                    <path d="M15 22h14M15 28h10" stroke="#6D2FD0" stroke-width="3.4" stroke-linecap="round"/>
                    <circle cx="36" cy="36" r="9.5" fill="#6D2FD0"/>
                    <path d="m31.6 36.2 3 3 6-6.2" stroke="#fff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Nota Dinas</h3>
            <span class="card-line"></span>
            <a class="card-btn" href="<?= site_url('surat/nota-dinas') ?>">Buat Surat <span>&rarr;</span></a>
            <svg class="card-wave" viewBox="0 0 400 70" preserveAspectRatio="none">
                <path fill="#F5F3FF" d="M0,36 C72,66 148,10 228,28 C306,46 352,60 400,38 L400,70 L0,70 Z"/>
            </svg>
        </article>
    <?php endif; ?>
</div>

<svg class="page-waves" viewBox="0 0 1440 210" preserveAspectRatio="none">
    <path fill="#DCE8FC" opacity=".85" d="M0,96 C250,164 520,36 790,78 C1045,118 1240,176 1440,104 L1440,210 L0,210 Z"/>
    <path fill="#E9F1FF" d="M0,132 C270,70 540,172 820,130 C1075,92 1260,130 1440,164 L1440,210 L0,210 Z"/>
</svg>

<?= $this->endSection() ?>