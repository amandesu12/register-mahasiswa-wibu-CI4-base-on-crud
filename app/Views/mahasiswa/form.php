<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
<?= isset($mahasiswa) ? 'Edit' : 'Tambah' ?> Pendaftar
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2 class="my-3">Formulir Pendaftaran Mahasiswa</h2>

            <?= \Config\Services::validation()->listErrors() ?>

            <form action="<?= isset($mahasiswa) ? '/mahasiswa/' . $mahasiswa['id'] : '/mahasiswa' ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <?php if (isset($mahasiswa)) : ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?= old('nim', $mahasiswa['nim'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $mahasiswa['nama'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $mahasiswa['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-select" id="jurusan" name="jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Teknik Informatika" <?= (old('jurusan', $mahasiswa['jurusan'] ?? '') == 'Teknik Informatika') ? 'selected' : '' ?>>Teknik Informatika</option>
                        <option value="Sistem Informasi" <?= (old('jurusan', $mahasiswa['jurusan'] ?? '') == 'Sistem Informasi') ? 'selected' : '' ?>>Sistem Informasi</option>
                        <option value="Sastra Jepang" <?= (old('jurusan', $mahasiswa['jurusan'] ?? '') == 'Sastra Jepang') ? 'selected' : '' ?>>Sastra Jepang</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="berkas" class="form-label">Upload Berkas (PDF, DOCX, JPG, PNG)</label>
                    <input class="form-control" type="file" id="berkas" name="berkas">
                    <?php if (isset($mahasiswa['berkas'])) : ?>
                        <small class="form-text text-muted">Berkas saat ini: <?= esc($mahasiswa['berkas']) ?></small>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>