<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin - Perpustakaan' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">
            <i class="bi bi-shield-lock me-1"></i> Admin Perpustakaan
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navAdmin">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/buku') ?>"><i class="bi bi-journal-bookmark"></i> Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/anggota') ?>"><i class="bi bi-people"></i> Data Anggota</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <span class="navbar-text text-light me-2">
                        <i class="bi bi-person-circle"></i> <?= esc(session()->get('admin_nama')) ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="<?= base_url('logout/admin') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
