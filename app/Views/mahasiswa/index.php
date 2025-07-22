<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Data Pendaftar Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-2">Data Pendaftar Mahasiswa</h1>

            <div class="d-flex justify-content-between align-items-center my-3">
                <a href="/mahasiswa/new" class="btn btn-primary">Tambah Pendaftar Baru</a>
                <form action="" method="get" class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Cari pendaftar..." name="keyword" value="<?= $keyword ?? '' ?>">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </form>
            </div>
            
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Berkas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($mahasiswa as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= esc($m['nim']) ?></td>
                            <td><?= esc($m['nama']) ?></td>
                            <td><?= esc($m['jurusan']) ?></td>
                            <td><a href="/uploads/<?= esc($m['berkas']) ?>" target="_blank">Lihat Berkas</a></td>
                            <td>
                                <a href="/mahasiswa/<?= $m['id'] ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/mahasiswa/<?= $m['id'] ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
             <?= $pager->links() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>