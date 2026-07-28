<?= $this->extend('admin/templates/main') ?>

<?= $this->section('content') ?>

<h3 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Buku</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/buku/update/' . $buku['id']) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Kode Buku</label>
                <input type="text" name="kode_buku" class="form-control" value="<?= old('kode_buku', $buku['kode_buku']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control" value="<?= old('judul', $buku['judul']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="<?= old('pengarang', $buku['pengarang']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="<?= old('penerbit', $buku['penerbit']) ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="<?= old('tahun_terbit', $buku['tahun_terbit']) ?>" min="1900" max="2100">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= old('stok', $buku['stok']) ?>" min="0" required>
                </div>
            </div>

            <a href="<?= base_url('admin/buku') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
