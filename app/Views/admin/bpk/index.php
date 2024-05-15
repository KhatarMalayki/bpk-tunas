<?php echo $this->extend('admin/layout/template'); ?>
<?= $this->section('style') ?>

<?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Bukti Pengeluaran Kas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href=<?= base_url('dashboard') ?>>Dashboard</a></li>
                <li class="breadcrumb-item active">Data Bpk</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Report Bpk
                </div>
                <div class="card-body">
                    <?= form_open('export-excel'), ['method' => 'GET'] ?>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="start_date" class="form-label">Tanggal Mulai:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col-md-4">
                                <label for="end_date" class="form-label">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                            <div class="col-md-4 mt-2">
                                <button type="submit" class="btn btn-success mt-4">Generate Report</button>
                            </div>
                    <?= form_close() ?>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Data Bpk
                    </div>
                    <div class="card-body">
                        <!-- notifikasi berhasil tambah kategori -->
                        <?php if (session('success')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?= session('success') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Display validation errors -->
                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No Bpk</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Tanggal Approved/Reject</th>
                                    <th>Status</th>
                                    <th>Fungsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_bpk as $bpk) : ?>
                                    <?php if ($bpk->status !== 'In-Process') : ?>
                                        <tr>
                                            <td><?= $bpk->no_bpk ?></td>
                                            <td><?= $bpk->nama_user ?></td>
                                            <td><?= $bpk->nik ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($bpk->updated_at)) ?></td>
                                            <td>
                                                <span style="<?= ($bpk->status === 'Approved' ? 'color:green;' : 'color:red;') ?>">
                                                    <?= $bpk->status ?>
                                                </span>
                                            </td>
                                            <td width="15%" class="text-center">
                                                <div style="display: flex; justify-content: center;">
                                                    <a href="<?= base_url('bpk-detail/' . base64_encode($bpk->no_bpk)) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
</main>

<!-- Modal -->
<div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateRangeModalLabel">Pilih Rentang Tanggal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('export-excel') ?>" method="get">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Akhir:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>