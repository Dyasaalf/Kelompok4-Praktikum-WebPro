<?= $this->extend('customer/templates/main') ?>

<?= $this->section('content') ?>

<h3 class="mb-3"><i class="bi bi-bookmark-check"></i> Pinjaman Saya</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tanggal Pinjam</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pinjaman)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Kamu belum meminjam buku apa pun.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pinjaman as $p): ?>
                            <tr>
                                <td><?= esc($p['kode_buku']) ?></td>
                                <td><?= esc($p['judul']) ?></td>
                                <td><?= esc($p['pengarang']) ?></td>
                                <td><?= esc(date('d-m-Y H:i', strtotime($p['tanggal_pinjam']))) ?></td>
                                <td class="text-center">
                                    <form action="<?= base_url('customer/buku/kembalikan/' . $p['id']) ?>" method="post" class="d-inline"
                                          onsubmit="return confirm('Kembalikan buku ini?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-arrow-return-left"></i> Kembalikan
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
