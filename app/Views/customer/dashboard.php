<?= $this->extend('customer/templates/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0"><i class="bi bi-journal-bookmark"></i> Daftar Buku</h3>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="get" action="<?= base_url('customer/buku') ?>" class="row g-2">
            <div class="col-md-7">
                <input type="text" name="q" class="form-control" placeholder="Cari judul, kode, atau pengarang..." value="<?= esc($_GET['q'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategoriList ?? [] as $k): ?>
                        <option value="<?= esc($k['kategori']) ?>" <?= ($kategoriAktif ?? '') === $k['kategori'] ? 'selected' : '' ?>>
                            <?= esc($k['kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    <?php if (empty($buku)): ?>
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada data buku.</div>
        </div>
    <?php else: ?>
        <?php foreach ($buku as $b): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($b['judul']) ?></h5>
                        <?php if (! empty($b['kategori'])): ?>
                            <span class="badge bg-info text-dark mb-2 align-self-start"><?= esc($b['kategori']) ?></span>
                        <?php endif; ?>
                        <p class="card-text text-muted mb-1">
                            <i class="bi bi-person"></i> <?= esc($b['pengarang']) ?>
                        </p>
                        <p class="card-text text-muted small mb-2">
                            Kode: <?= esc($b['kode_buku']) ?>
                            <?php if (! empty($b['penerbit'])): ?> &middot; <?= esc($b['penerbit']) ?><?php endif; ?>
                            <?php if (! empty($b['tahun_terbit'])): ?> (<?= esc($b['tahun_terbit']) ?>)<?php endif; ?>
                        </p>

                        <div class="mt-auto">
                            <?php if ($b['status'] === 'dipinjam'): ?>
                                <span class="badge bg-warning text-dark mb-2 d-inline-block">Sedang Dipinjam</span><br>
                                <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                            <?php elseif ($b['stok'] < 1): ?>
                                <span class="badge bg-danger mb-2 d-inline-block">Stok Habis</span><br>
                                <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                            <?php else: ?>
                                <span class="badge bg-success mb-2 d-inline-block">Tersedia (Stok: <?= esc($b['stok']) ?>)</span>
                                <form action="<?= base_url('customer/buku/pinjam/' . $b['id']) ?>" method="post"
                                      onsubmit="return confirm('Pinjam buku \'<?= esc($b['judul'], 'js') ?>\'?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="bi bi-bookmark-plus"></i> Pinjam Buku
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
