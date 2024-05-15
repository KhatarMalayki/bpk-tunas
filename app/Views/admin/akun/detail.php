<?php echo $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
<main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Akun</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href=<?= base_url('dashboard') ?>>Dashboard</a></li>
                <li class="breadcrumb-item active">Data Akun</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Detail Akun : <?= $data_user->id; ?>
                        </div>
                        <div class="card-body">
                          

                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                    <th>Fullname</th>
                                    <td><?= $data_user->fullname; ?></td>
                                </tr>
                            <tr>
                                    <th>Email</th>
                                    <td><?= $data_user->email; ?></td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td><?= $data_user->username; ?></td>
                                </tr>
                                <?php if (!empty($data_group)) : ?>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        <?php foreach ($data_group as $group) : ?>
                                            <?= $group['name']; ?>
                                        <?php endforeach; ?> 
                                        </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Tanggal Registrasi</th>
                                    <td><?= date('d/m/Y | H:i:s', strtotime($data_user->created_at)); ?></td>
                                </tr>
                                
                            </table>
                            <div class="d-flex justify-content-end">
                                <a href="<?= base_url('akun') ?>" class="btn btn-secondary btn-sm mt-2"> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
   
<?= $this->endSection(); ?>