<?php echo $this->extend('admin/layout/template'); ?>
<?= $this->section('style') ?>
<style>
    .btn-generate-report {
    padding: 0.25rem 0.5rem; /* Atur padding tombol */
    font-size: 0.75rem; /* Atur ukuran font */
    line-height: 1; /* Sesuaikan ketinggian baris */
}

</style>
<?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Approve Or Reject : <?= $totalApv_Rjt ?></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?= base_url('/bukti-pengeluaran-kas') ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Outstanding : <?= $totalOutstanding ?></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?= base_url('request-form') ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Total Form : <?= $totalForm ?></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-success btn-generate-report" data-bs-toggle="modal" data-bs-target="#dateRangeModal">
                                <i class="fa fa-file-excel"></i> Generate report
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Total User : <?= $totalUser ?></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white" href="<?= base_url('akun') ?>">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Bukti Pengeluaran Kas
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Bpk</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Tanggal Approved/Reject</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_Bpk as $row) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row->no_bpk; ?></td>
                                    <td><?= $row->nama_user; ?></td>
                                    <td><?= $row->nik; ?></td>
                                    <td><?= $row->created_at; ?></td>
                                    <td>
                                        <span style="<?= ($row->status === 'Approved' ? 'color:green;' : 'color:red;') ?>">
                                            <?= $row->status ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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