<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — KopSurat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(20, 0, 0, 0.62), rgba(20, 0, 0, 0.62)),
                        url('<?= base_url('img/gedung-disnaker.webp') ?>') center bottom / cover no-repeat fixed;
        }
        .login-wrapper { width: 100%; max-width: 420px; padding: 20px; }
        .login-card {
            background: #ffffff; border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(0,0,0,0.05);
            padding: 44px 38px 32px; animation: fadeIn 0.5s ease-out;
            border-top: 6px solid #B91C1C;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-icon {
            width: 80px; height: 80px;
            background: url('<?= base_url('img/logo-jatim.png') ?>') center / contain no-repeat;
            border-radius: 16px; display: block; margin: 0 auto 14px;
            background-color: #FEF2F2; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }
        .login-header h1 { font-size: 22px; font-weight: 700; color: #7F1D1D; margin-bottom: 4px; }
        .login-header p { font-size: 14px; color: #888; }
        .badge-admin {
            display: inline-block; margin-top: 10px; padding: 4px 14px; border-radius: 20px;
            background: #FEE2E2; color: #B91C1C; font-size: 12px; font-weight: 700; letter-spacing: .5px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; color: #333; font-size: 13px; font-weight: 600; letter-spacing: 0.3px; }
        .form-group input {
            width: 100%; padding: 13px 16px; border: 2px solid #e5e7eb; border-radius: 10px;
            font-size: 14px; font-family: 'Inter', sans-serif; color: #1a1a2e;
            outline: none; transition: all 0.25s ease; background: #f9fafb;
        }
        .form-group input:focus { border-color: #B91C1C; background: #fff; box-shadow: 0 0 0 4px rgba(185, 28, 28, 0.1); }
        .btn-login {
            width: 100%; padding: 14px; background: linear-gradient(135deg, #B91C1C, #7F1D1D);
            border: none; border-radius: 10px; color: #fff; font-size: 15px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(185, 28, 28, 0.35); margin-top: 8px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(185, 28, 28, 0.45); }
        .alert { padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 18px; background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .login-footer { text-align: center; margin-top: 24px; font-size: 13px; color: #aaa; }
        .login-footer a { color: #0561B9; text-decoration: none; font-weight: 600; }
        .login-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon"></div>
                <h1>Login Admin</h1>
                <p>Khusus admin &amp; superadmin</p>
                <span class="badge-admin">JALUR ADMIN</span>
            </div>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <form action="<?= base_url('login/authenticate') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="mode" value="admin">
                <div class="form-group">
                    <label for="username">Username Admin</label>
                    <input type="text" id="username" name="username"
                           value="<?= esc(old('username')) ?>"
                           placeholder="Masukkan username admin" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn-login">Masuk sebagai Admin</button>
            </form>
            <div class="login-footer">
                Bukan admin? <a href="<?= site_url('login') ?>">Login Pengguna</a>
            </div>
        </div>
    </div>
</body>
</html>
