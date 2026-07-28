<?= $this->extend('admin/templates/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0"><i class="bi bi-journal-bookmark"></i> Data Buku</h3>
    <a href="<?= base_url('admin/buku/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Buku
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="get" action="<?= base_url('admin/buku') ?>" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari judul, kode, atau pengarang..." value="<?= esc($_GET['q'] ?? '') ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($buku)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data buku.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($buku as $b): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($b['kode_buku']) ?></td>
                                <td><?= esc($b['judul']) ?></td>
                                <td><?= esc($b['pengarang']) ?></td>
                                <td><?= esc($b['penerbit']) ?></td>
                                <td><?= esc($b['tahun_terbit']) ?></td>
                                <td>
                                    <span class="badge <?= $b['stok'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= esc($b['stok']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($b['status'] === 'dipinjam'): ?>
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Tersedia</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/buku/edit/' . $b['id']) ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="<?= base_url('admin/buku/delete/' . $b['id']) ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
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
