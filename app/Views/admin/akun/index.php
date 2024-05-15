<?php

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

echo $this->extend('admin/layout/template'); ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"> Akun</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>"></a> Dashboard</li>
                <li class="breadcrumb-item active">Data Akun</li>
            </ol>


            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    DataTable Example
                </div>
                <div class="card-body">
                    <a href="<?= base_url('register') ?>" class="btn btn-primary btn-sm mb-3"><i class="fa fa-user-plus"></i> Register</a>
                    <?php if (session('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (session('warning')) : ?>
                        <div class="alert alert-warning" role="alert">
                            <?= session('warning') ?>
                        </div>
                    <?php endif; ?>
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Tanggal Registrasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_user as $akun) : ?>
                                <?php if ($akun->deleted_at === null) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $akun->email; ?></td>
                                        <td><?= $akun->username; ?></td>
                                        <td><?= date('d/m/Y | H:i:s', strtotime($akun->created_at)); ?></td>
                                        <td style="text-align: center;">
                                            <div style="display: flex; justify-content: center;">
                                                <a href="<?= base_url('akun/detail/' . $akun->id) ?>" class="btn btn-primary btn-sm me-2">Detail</a>
                                                <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit<?= $akun->id; ?>">Edit</button>
                                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete<?= $akun->id; ?>">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </main>

    <!-- modal edit -->
    <?php foreach ($data_user as $akun) : ?>
        <!-- modal edit -->
        <div class="modal fade" id="edit<?= $akun->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?= form_open('akun/edit/' . $akun->id); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $akun->email; ?>" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $akun->username; ?>" placeholder="Username" required>
                        </div>

                        <div class="mb-3">
                            <label for="group" class="form-label">Select Group:</label>
                            <select class="form-select" id="group" name="group">
                                <option value="" hidden>-- Pilih Grup --</option> <!-- Tambahkan Opsi Kosong / null -->
                                <?php foreach ($data_group as $group) : ?> <!-- Menggunakan $data_group untuk opsi grup -->
                                <option value="<?= $group->id ?>" <?php if (in_array($group->id, array_column($akun->groups, 'group_id'))) echo 'selected'; ?>>
                                    <?= $group->name ?>
                                </option>
                            <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="mb-3"></div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
</div>
<?php endforeach; ?>
<!-- modal hapus -->
<?php foreach ($data_user as $akun) : ?>
    <div class="modal fade" id="delete<?= $akun->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open('akun/delete/' . $akun->id); ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <p>Apakah anda yakin ingin menghapus akun ini : <?= $akun->username; ?>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class=" btn btn-danger">Hapus</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>