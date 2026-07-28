<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Perpustakaan' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center text-white mb-4">
        <i class="bi bi-book-half display-3"></i>
        <h1 class="mt-2">Sistem Informasi Perpustakaan</h1>
        <p class="lead">Silakan masuk sesuai peran kamu</p>
    </div>

    <div class="row justify-content-center g-4">
        <div class="col-md-4">
            <a href="<?= base_url('login/admin') ?>" class="text-decoration-none">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-shield-lock display-4 text-primary"></i>
                        <h4 class="mt-3">Admin</h4>
                        <p class="text-muted">Kelola data buku &amp; anggota</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="<?= base_url('login/anggota') ?>" class="text-decoration-none">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-person-badge display-4 text-success"></i>
                        <h4 class="mt-3">Anggota</h4>
                        <p class="text-muted">Lihat &amp; pinjam buku</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

</body>
</html>
