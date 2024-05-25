<?php echo $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">User Request</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href=<?= base_url('dashboard') ?>>Dashboard</a></li>
                <li class="breadcrumb-item active">User Request</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            User Request
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
                                        <th>Tanggal Request</th>
                                        <th>Fungsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_bpk as $bpk) : ?>
                                        <tr>
                                            <td><?= $bpk->no_bpk ?></td>
                                            <td><?= $bpk->nama_user ?></td>
                                            <td><?= $bpk->nik ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($bpk->created_at)) ?></td>
                                            <td width="15%" class="text-center">
                                                <div style="display: flex; justify-content: center;">
                                                    <a href="<?= base_url('bpk-detail/' . $bpk->encrypted_id) ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Lihat</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
        <?= $this->endSection(); ?>