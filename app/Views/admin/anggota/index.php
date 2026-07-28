<?= $this->extend('admin/templates/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0"><i class="bi bi-people"></i> Data Anggota</h3>
    <a href="<?= base_url('admin/anggota/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Anggota
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="get" action="<?= base_url('admin/anggota') ?>" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari nama atau NIS/NIM..." value="<?= esc($_GET['q'] ?? '') ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i> Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>NIS/NIM</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($anggota)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data anggota.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; ?>
                        <?php foreach ($anggota as $a): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($a['nis_nim']) ?></td>
                                <td><?= esc($a['nama']) ?></td>
                                <td><?= $a['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                                <td><?= esc($a['no_hp']) ?></td>
                                <td><?= esc($a['email']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('admin/anggota/edit/' . $a['id']) ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="<?= base_url('admin/anggota/delete/' . $a['id']) ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
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
