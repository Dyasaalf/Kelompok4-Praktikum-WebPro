<?= $this->extend('admin/templates/main') ?>

<?= $this->section('content') ?>

<h3 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah Anggota</h3>

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

        <form action="<?= base_url('admin/anggota/save') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">NIS/NIM</label>
                <input type="text" name="nis_nim" class="form-control" value="<?= old('nis_nim') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password (untuk login anggota)</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
                <div class="form-text">Minimal 6 karakter. Anggota akan memakai NIS/NIM + password ini untuk login.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= old('alamat') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= old('no_hp') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>">
                </div>
            </div>

            <a href="<?= base_url('admin/anggota') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
