<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="bi bi-person-badge display-4 text-success"></i>
                <h4 class="mt-2">Login Anggota</h4>
                <p class="text-muted small">Sistem Informasi Perpustakaan</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('login/anggota') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">NIS / NIM</label>
                    <input type="text" name="nis_nim" class="form-control" value="<?= old('nis_nim') ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Login</button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Belum punya akun? Hubungi admin perpustakaan untuk didaftarkan.</small><br>
                <a href="<?= base_url('login/admin') ?>" class="small">Login sebagai Admin &raquo;</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
