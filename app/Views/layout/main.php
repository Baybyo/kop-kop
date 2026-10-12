<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('css/tokens.css') ?>" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #16284A;
            --blue: #0561B9;
            --green: #0C7B4C;
            --purple: #6D2FD0;
            --ink: #16264A;
            --muted: #64748B;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #EFF5FF;
            color: var(--ink);
        }

        a { text-decoration: none; color: inherit; }

        .app { display: flex; min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 288px;
            flex-shrink: 0;
            background: var(--sidebar-bg);
            padding: 26px 20px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar .brand { padding: 4px 6px 32px; }

        .sidebar .brand img {
            width: 100%;
            max-width: 235px;
            display: block;
        }

        .menu { display: flex; flex-direction: column; gap: 6px; flex: 1; }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 9px;
            color: #C7D2E5;
            font-size: 15px;
            font-weight: 500;
            transition: background .2s, color .2s, box-shadow .2s;
        }

        .menu-item svg { width: 21px; height: 21px; flex-shrink: 0; }

        .menu-item:hover { background: rgba(255,255,255,.07); color: #fff; }

        .menu-item.active {
            background: var(--blue);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(5,97,185,.35);
        }

        .menu-sep {
            border: none;
            border-top: 1px solid rgba(255,255,255,.12);
            margin: 16px 8px;
        }

        .logout {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 9px;
            background: #223557;
            border: 1px solid rgba(255,255,255,.10);
            color: #C7D2E5;
            font-size: 15px;
            font-weight: 500;
            transition: background .2s, color .2s;
        }

        .logout:hover { background: #2B4270; color: #fff; }

        .logout svg { width: 21px; height: 21px; }

        /* ===== MAIN ===== */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        .topbar {
            height: 88px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            box-shadow: 0 1px 0 rgba(15,23,42,.07);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar-left { display: flex; align-items: center; gap: 15px; }

        .topbar-icon {
            width: 44px;
            height: 44px;
            background: var(--blue);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 6px 14px rgba(5,97,185,.30);
        }

        .topbar-icon svg { width: 24px; height: 24px; }

        .topbar-left h1 { font-size: 20px; font-weight: 700; color: var(--ink); line-height: 1.25; }

        .topbar-left p { font-size: 13.5px; color: var(--muted); margin-top: 2px; }

        .topbar-right { display: flex; align-items: center; gap: 20px; }

        .bell {
            position: relative;
            background: none;
            border: none;
            cursor: pointer;
            color: #475569;
            display: flex;
        }

        .bell svg { width: 23px; height: 23px; }

        .bell .dot {
            position: absolute;
            top: -1px;
            right: -1px;
            width: 9px;
            height: 9px;
            background: #EF4444;
            border: 2px solid #fff;
            border-radius: 50%;
        }

        .user{position:relative;display:flex;align-items:center;gap:10px}
        .user-btn{display:flex;align-items:center;gap:10px;background:none;border:none;cursor:pointer;padding:0}

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94A3B8;
        }

        .avatar svg { width: 27px; height: 27px; }

        .user .chev { color: #94A3B8; width: 18px; height: 18px; }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, #FFFFFF 0%, #FFFFFF 45%, #E9F1FF 100%);
            padding-bottom: 70px;
        }

        .menu-toggle{display:none;background:none;border:1px solid #E2E8F0;border-radius:8px;padding:8px;cursor:pointer;color:#475569}
        /* ===== RESPONSIVE ===== */
        @media (max-width: 1000px) {
            .sidebar{position:fixed;left:0;top:0;bottom:0;z-index:50;transform:translateX(-105%);transition:transform .25s ease}
            body.nav-open .sidebar{transform:none}
            body.nav-open .nav-scrim{display:block}
            .menu-toggle{display:inline-flex}
            .topbar { padding: 0 18px; }
            .topbar-left h1 { font-size: 16px; }
            .topbar-left p { display: none; }
        }
        .nav-scrim{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:40}
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <img src="<?= base_url('img/logo-disnakertrans.png') ?>" alt="Disnakertrans Provinsi Jawa Timur">
        </div>

        <nav class="menu">
            <a class="menu-item <?= ($active ?? '') === 'beranda' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3.4 3.5 11h2.3v8.6a1 1 0 0 0 1 1H9.5v-5.4h5v5.4h2.7a1 1 0 0 0 1-1V11h2.3z"/></svg>
                <span>Beranda</span>
            </a>

            <a class="menu-item <?= ($active ?? '') === 'riwayat' ? 'active' : '' ?>" href="<?= site_url('riwayat') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><rect x="5" y="3.5" width="14" height="17" rx="2.5"/><path d="M9 9h6M9 12.5h6M9 16h4"/></svg>
                <span>Riwayat Surat<?= !empty($notifCount) ? ' ('.$notifCount.')' : '' ?></span>
            </a>

            <a class="menu-item <?= ($active ?? '') === 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M3 3v18h18"/><path d="M7 15l4-5 3 3 5-7"/></svg>
                <span>Laporan</span>
            </a>

            <a class="menu-item <?= ($active ?? '') === 'notifikasi' ? 'active' : '' ?>" href="<?= site_url('notifikasi') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M6.5 9.5a5.5 5.5 0 0 1 11 0c0 4.5 1.8 5.8 1.8 5.8H4.7s1.8-1.3 1.8-5.8"/><path d="M10.2 19a2.2 2.2 0 0 0 3.6 0"/></svg>
                <span>Notifikasi<?= !empty($notifCount) ? ' ('.$notifCount.')' : '' ?></span>
            </a>
                <?php if (($role ?? '') === 'superadmin'): ?>
                    <a class="menu-item <?= ($active ?? '') === 'manajemen_user' ? 'active' : '' ?>" href="<?= site_url('admin/users') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>Kelola Pengguna & Role</span>
                    </a>
                    <a class="menu-item <?= ($active ?? '') === 'penomoran' ? 'active' : '' ?>" href="<?= site_url('admin/penomoran') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h10"/></svg>
                        <span>Penomoran</span>
                    </a>
                    <a class="menu-item <?= ($active ?? '') === 'kop' ? 'active' : '' ?>" href="<?= site_url('admin/kop') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
                        <span>Kop Surat</span>
                    </a>
                    <a class="menu-item <?= ($active ?? '') === 'arsip' ? 'active' : '' ?>" href="<?= site_url('admin/arsip') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><rect x="4" y="3" width="16" height="5" rx="1"/><path d="M4 10v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V10"/><path d="M9 15h6"/></svg>
                        <span>Arsip & Monitoring</span>
                    </a>
                    <a class="menu-item <?= ($active ?? '') === 'audit' ? 'active' : '' ?>" href="<?= site_url('audit') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6z"/><path d="M9.5 12l1.8 1.8 3.2-3.6"/></svg>
                        <span>Audit Log</span>
                    </a>
                    <a class="menu-item <?= ($active ?? '') === 'telemetri' ? 'active' : '' ?>" href="<?= site_url('telemetri') ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"><path d="M3 13h4l2-7 4 14 2-7h6"/></svg>
                        <span>Telemetri</span>
                    </a>
                <?php endif; ?>

            <a class="menu-item <?= ($active ?? '') === 'profil' ? 'active' : '' ?>" href="<?= site_url('profil') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                    <circle cx="12" cy="8.5" r="3.7"/>
                    <path d="M4.8 20c.7-3.6 3.8-5.6 7.2-5.6s6.5 2 7.2 5.6"/>
                </svg>
                <span>Profil</span>
            </a>

            <hr class="menu-sep">

            <a class="menu-item <?= ($active ?? '') === 'bantuan' ? 'active' : '' ?>" href="<?= site_url('bantuan') ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                    <circle cx="12" cy="12" r="8.6"/>
                    <path d="M9.6 9.6a2.5 2.5 0 1 1 3.7 2.1c-.8.5-1.3 1-1.3 1.9"/>
                    <circle cx="12" cy="16.8" r=".9" fill="currentColor" stroke="none"/>
                </svg>
                <span>Bantuan</span>
            </a>
        </nav>

        <a class="logout" href="<?= site_url('logout') ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14.5 4H18a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3.5"/>
                <path d="M10 8.5 6.5 12l3.5 3.5M6.8 12H15"/>
            </svg>
            <span>Keluar</span>
        </a>
    </aside>

    <div class="nav-scrim" onclick="document.body.classList.remove('nav-open')"></div>
    <div class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" type="button" aria-label="Menu" onclick="document.body.classList.toggle('nav-open')">☰</button>
                <div class="topbar-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 3.5h6.5L18 8v10.5a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2z"/>
                        <path d="M13.2 3.7V8H18"/>
                        <path d="M8.5 13h7M8.5 16.5h4.5"/>
                    </svg>
                </div>
                <div>
                    <h1>Sistem Pembuatan Kop Surat</h1>
                    <p>Perizinan Perjalanan Dinas</p>
                </div>
            </div>

            <div class="topbar-right">
                <div style="position:relative">
                <button class="bell" type="button" aria-label="Notifikasi" onclick="document.getElementById('notifDrop').style.display=document.getElementById('notifDrop').style.display==='block'?'none':'block'">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6.5 9.5a5.5 5.5 0 0 1 11 0c0 4.5 1.8 5.8 1.8 5.8H4.7s1.8-1.3 1.8-5.8"/>
                        <path d="M10.2 19a2.2 2.2 0 0 0 3.6 0"/>
                    </svg>
                    <?php if (!empty($notifCount)): ?><span style="position:absolute;top:-6px;right:-6px;background:#EF4444;color:#fff;font-size:11px;font-weight:700;min-width:19px;height:19px;border-radius:10px;display:flex;align-items:center;justify-content:center;padding:0 5px"><?= $notifCount > 9 ? '9+' : $notifCount ?></span><?php else: ?><span class="dot"></span><?php endif; ?>
                </button>
                <div id="notifDrop" style="display:none;position:absolute;right:0;top:34px;width:330px;background:#fff;border-radius:12px;box-shadow:0 18px 44px rgba(15,23,42,.18);z-index:60;overflow:hidden">
                    <div style="padding:13px 16px;font-weight:700;font-size:14px;border-bottom:1px solid #F1F5F9"><?= !empty($isAdmin) ? 'Menunggu verifikasi' : 'Status surat saya' ?><?= !empty($notifCount) ? ' ('.$notifCount.')' : '' ?></div>
                    <?php if (empty($notifItems)): ?><div style="padding:22px;text-align:center;color:#94A3B8;font-size:13.5px">Tidak ada notifikasi baru.</div>
                    <?php else: foreach (($notifItems ?? []) as $n): ?><a href="<?= site_url('surat/preview/'.$n['id']) ?>" style="display:block;padding:11px 16px;border-bottom:1px solid #F8FAFC;font-size:13.5px">
                        <div style="font-weight:600;color:#16264A">#<?= $n['id'] ?> · <?= esc($n['jenis_surat']) ?> · <?= strtoupper($n['status'] ?? 'DRAFT') ?></div>
                        <div style="color:#64748B;font-size:12.5px;margin-top:2px"><?= esc(mb_strimwidth($n['perihal'] ?? $n['nomor_surat'] ?? '', 0, 60, '...')) ?></div>
                    </a><?php endforeach; endif; ?>
                    <a href="<?= site_url('riwayat') ?>" style="display:block;padding:11px;text-align:center;font-weight:700;font-size:13.5px;color:#0561B9">Lihat riwayat &rarr;</a>
                </div>
                </div>

                <div class="user">
                    <button class="user-btn" type="button" aria-label="Menu pengguna" aria-haspopup="true" onclick="document.getElementById('userDrop').style.display=document.getElementById('userDrop').style.display==='block'?'none':'block'">
                        <span class="avatar">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="8.5" r="4"/>
                                <path d="M4.5 20.5c.9-4 4-6.2 7.5-6.2s6.6 2.2 7.5 6.2"/>
                            </svg>
                        </span>
                        <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m7 10 5 5 5-5"/>
                        </svg>
                    </button>
                    <div id="userDrop" style="display:none;position:absolute;right:0;top:50px;width:200px;background:#fff;border-radius:12px;box-shadow:0 18px 44px rgba(15,23,42,.18);z-index:60;overflow:hidden">
                        <div style="padding:13px 16px;border-bottom:1px solid #F1F5F9"><div style="font-weight:700;font-size:14px;color:#16264A"><?= esc(session()->get('name') ?? session()->get('username') ?? 'Pengguna') ?></div><div style="font-size:12.5px;color:#64748B"><?= esc(ucfirst(session()->get('role') ?? '')) ?></div></div>
                        <a href="<?= site_url('profil') ?>" style="display:block;padding:11px 16px;font-size:13.5px;font-weight:600;color:#16264A">Profil</a>
                        <a href="<?= site_url('logout') ?>" style="display:block;padding:11px 16px;font-size:13.5px;font-weight:600;color:#DC2626;border-top:1px solid #F1F5F9">Keluar</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>
</body>
</html>