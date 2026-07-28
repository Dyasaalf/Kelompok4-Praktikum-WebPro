<?= $this->extend('admin/templates/main') ?>

<?= $this->section('content') ?>

<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard Admin</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-6">Total Buku</div>
                    <div class="fs-3 fw-bold"><?= esc($total_buku) ?></div>
                </div>
                <i class="bi bi-journal-bookmark display-5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-success text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-6">Total Anggota</div>
                    <div class="fs-3 fw-bold"><?= esc($total_anggota) ?></div>
                </div>
                <i class="bi bi-people display-5"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-warning text-dark">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-6">Buku Sedang Dipinjam</div>
                    <div class="fs-3 fw-bold"><?= esc($total_dipinjam) ?></div>
                </div>
                <i class="bi bi-bookmark-check display-5"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <strong>Buku Terbaru Ditambahkan</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($buku_terbaru)): ?>
                        <tr><td colspan="4" class="text-center text-muted">Belum ada data buku.</td></tr>
                    <?php else: ?>
                        <?php foreach ($buku_terbaru as $b): ?>
                            <tr>
                                <td><?= esc($b['kode_buku']) ?></td>
                                <td><?= esc($b['judul']) ?></td>
                                <td><?= esc($b['pengarang']) ?></td>
                                <td>
                                    <?php if ($b['status'] === 'dipinjam'): ?>
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tersedia</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
