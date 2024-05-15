<?php echo $this->extend('admin/layout/template'); ?>
<?= $this->section('style') ?>

<?= $this->endSection() ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Detail Bpk</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href=<?= base_url('dashboard') ?>>Dashboard</a></li>
                <li class="breadcrumb-item active">Data Bpk</li>
            </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Bpk : <?= $data_bpk->no_bpk; ?>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid" style="max-width: 100%;">
                                <?php if (session('success')) : ?>
                                    <div class="swal" data-swal="<?= session('success') ?>"></div>
                                <?php endif; ?>
                                <div class="table-responsive" style="overflow-x:auto">
                                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                        <tr>
                                            <th>Nomor Bukti Pengeluaran Kas</th>
                                            <td><?= $data_bpk->no_bpk; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama User</th>
                                            <td><?= $data_bpk->nama_user ?></td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td><?= $data_bpk->nik ?></td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah Uang</th>
                                            <td>Rp. <?= number_format($data_bpk->jmlh_uang, 0, ',', '.') ?>,-</td>
                                        </tr>
                                        <tr>
                                            <th>Keperluan</th>
                                            <td><?= $data_bpk->for_kprln ?></td>
                                        </tr>
                                        <tr>
                                            <th width="50%">File PDF</th>
                                            <td>
                                                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                                    <iframe src="https://docs.google.com/viewer?url=<?= urlencode($signedUrl) ?>&embedded=true" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" frameborder="0"></iframe>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if ($data_bpk->status == 'Approved') : ?>
                                            <tr>
                                                <th width="50%">QR CODE</th>
                                                <td>
                                                    <img src="<?= $qrUrl ?>" width="200px" alt="QR Code" class="preview-img<?= $data_bpk->no_bpk; ?>">
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>Status</th>
                                            <td><?= $data_bpk->status ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <td><?= date('d/m/Y | H:i:s', strtotime($data_bpk->created_at)); ?></td>
                                        </tr>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <?php if (logged_in() && in_groups('admin')) : ?>
                                            <!-- tambahkan button approved dan reject -->
                                            <?php if ($data_bpk->status == 'In-Process') : ?>
                                                <button type="button" onclick="approve('<?= $data_bpk->no_bpk ?>')" class="btn btn-success btn-sm mt-2 me-2"> Approve </button>
                                                <button type="button" onclick="reject('<?= $data_bpk->no_bpk ?>')" class="btn btn-danger btn-sm mt-2 me-2"> Reject </button>
                                                <button type="button" class="btn btn-warning btn-sm mt-2 me-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $data_bpk->no_bpk ?>"> Edit </button>
                                            <?php elseif ($data_bpk->status == 'Approved') : ?>
                                                <span class="text-success mt-2 me-2">Approved</span>
                                            <?php elseif ($data_bpk->status == 'Rejected') : ?>
                                                <span class="text-danger mt-2 me-2">Rejected</span>
                                            <?php endif; ?>
                                            <!-- tambahkan button modal edit -->
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-secondary btn-sm mt-2 me-2" onclick="goBack()"> Kembali</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
    </main>
    <!-- </div> -->

    <!-- modal edit -->
    <div class="modal fade" id="editModal<?= $data_bpk->no_bpk ?>" tabindex="-1">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit"></i>Ubah Bukti Pengeluaran Kas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= form_open_multipart('bukti-pengeluaran-kas/edit/' . $data_bpk->no_bpk) ?>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="jmlh_uang">Jumlah Uang</label>
                        <input type="text" class="form-control" id="jmlh_uang" name="jmlh_uang" value="<?= $data_bpk->jmlh_uang ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Save changes</button>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection(); ?>
    <?= $this->section('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swal = $('.swal').data('swal');

        if (swal) {

            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: swal,
                showConfirmButton: false,
                timer: 3000
            });
        }
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script>
        function reject(no_bpk) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menolak data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('bukti-pengeluaran-kas/reject') ?>",
                        data: {
                            _method: 'PUT',
                            <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                            no_bpk: no_bpk
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.success,
                                }).then((result) => {
                                    if (result.value) {
                                        const currentUrl = window.location.href;
                                        window.location.href = currentUrl;
                                    }
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        }
    </script>
    <!-- ajax confirm approved swwetalert -->
    <script>
        function approve(no_bpk) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menyetujui data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Setuju!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('bukti-pengeluaran-kas/approve') ?>",
                        data: {
                            _method: 'PUT',
                            <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                            no_bpk: no_bpk
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.success,
                                }).then((result) => {
                                    if (result.value) {
                                        const currentUrl = window.location.href;
                                        window.location.href = currentUrl;
                                    }
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);

                        }
                    });
                }
            })
        }
    </script>
    <!-- preview image -->
    <script>
        $(document).ready(function() {
            $('.preview-img<?= $data_bpk->no_bpk; ?>').attr('src', '<?= $qrUrl ?>');
        });
    </script>
    <?= $this->endSection(); ?>