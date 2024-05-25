<?php echo $this->extend('admin/layout/template'); ?>
<?= $this->section('style') ?>
<style>
    .swal2-html-container {
        width: auto;
        /* Atau lebar yang sesuai dengan kebutuhan Anda */
    }

    .swal2-input {
        overflow-x: hidden;
        /* Menghilangkan gulir horizontal pada input */
    }
</style>
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
                                <?php if ($data_bpk->status == 1) : ?>
                                    <tr>
                                        <th width="50%">QR CODE</th>
                                        <td>
                                            <img src="<?= $qrUrl ?>" width="200px" alt="QR Code" class="preview-img<?= $data_bpk->no_bpk; ?>">
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php
                                        if ($data_bpk->status == 1) {
                                            echo 'Approved';
                                        } elseif ($data_bpk->status == 0) {
                                            echo 'In-Process';
                                        } elseif ($data_bpk->status == -1) {
                                            echo 'Rejected';
                                        } else {
                                            echo $data_bpk->status;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Input</th>
                                    <td><?= date('d/m/Y | H:i:s', strtotime($data_bpk->created_at)); ?></td>
                                </tr>
                            </table>
                            <div class="d-flex justify-content-end">
                                <?php if (logged_in() && in_groups('admin')) : ?>
                                    <!-- tambahkan button approved dan reject -->
                                    <?php if ($data_bpk->status == 0) : ?>
                                        <button type="button" onclick="approve('<?= $data_bpk->encrypted_id ?>')" class="btn btn-success btn-sm mt-2 me-2"> Approve </button>
                                        <button type="button" onclick="reject('<?= $data_bpk->encrypted_id ?>')" class="btn btn-danger btn-sm mt-2 me-2"> Reject </button>
                                        <button type="button" onclick="edit('<?= $data_bpk->encrypted_id ?>')" class="btn btn-warning btn-sm mt-2 me-2"> Edit </button>
                                    <?php elseif ($data_bpk->status == 1) : ?>
                                        <span class="text-success mt-2 me-2">Approved</span>
                                    <?php elseif ($data_bpk->status == -1) : ?>
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

    <?= $this->endSection(); ?>
    <?= $this->section('script'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- swal edit -->
    <script>
        function formatRibuan(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function edit(encrypted_id) {
            Swal.fire({
                title: '<span style="font-size: 18px;">Edit Jumlah Uang dan Sertakan ALasannya?</span>',
                html: `<h5 style="display: inline-block;">Jumlah Uang :</h5>
                         <input type="number" id="editJumlah" name="editJumlah" value="<?= $data_bpk->jmlh_uang ?>" placeholder="Enter Jumlah Uang" style="display: inline-block; width: 50%;" class="swal2-input">
                         <div class="form-floating mb-3">
                        <input type="text" id="editAlasan" class="form-control rounded-3" placeholder="Masukan alasan perubahan">
                        <label for="editAlasan">Masukan Alasan Perubahan :</label>
                        </div>
                        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Edit!',
                allowOutsideClick: false // Mencegah pengguna menutup SweetAlert selama loading
            }).then((result) => {
                if (result.isConfirmed) {
                    var editJumlah = document.getElementById('editJumlah').value.replace(/\./g, '');
                    var editAlasan = document.getElementById('editAlasan').value;
                    if (!editJumlah.trim() || !editAlasan.trim()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Anda harus mengisi semua kolom!',
                        });
                    } else {
                        fetch("<?= base_url('bukti-pengeluaran-kas/edit/' . $data_bpk->encrypted_id) ?>", {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "<?= csrf_hash() ?>"
                                },
                                body: JSON.stringify({
                                    jmlh_uang: editJumlah,
                                    rsn_edit: editAlasan
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.success
                                    }).then(() => {
                                        window.location.reload();
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.error || 'Terjadi kesalahan. Silakan coba lagi.',
                                    });
                                }

                            }).catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                                });
                            });
                    }
                }
            });
            // Event listener untuk memformat angka saat pengguna mengetik
            document.getElementById('editJumlah').addEventListener('input', function(e) {
                var value = e.target.value.replace(/\D/g, '');
                e.target.value = formatRibuan(value);
            });

        }
    </script>
    <!-- swal notif succes -->
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
    <!-- function kembali -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <!-- swall reject -->
    <script>
        function reject(encrypted_id) {
            Swal.fire({
                title: 'Berikan Alasan Penolakan?',
                html: `<div class="form-floating mb-3">
                        <input type="text" id="rejectReason" class="form-control rounded-3" placeholder="Masukan alasan perubahan">
                        <label for="rejectReason">Masukan Alasan Penolakan :</label>
                        </div>`, // Menambahkan gaya CSS untuk mengatur lebar input                
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tolak!',
                allowOutsideClick: false // Mencegah pengguna menutup SweetAlert 
            }).then((result) => {
                if (result.isConfirmed) {
                    var rejectReason = document.getElementById('rejectReason').value; // Mengambil nilai alasan penolakan dari input
                    if (!rejectReason.trim()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Anda harus mengisi alasan penolakan!',
                        });
                    } else {
                        fetch("<?= base_url('bukti-pengeluaran-kas/reject/' . $data_bpk->encrypted_id) ?>", {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "<?= csrf_hash() ?>"
                                },
                                body: JSON.stringify({
                                    reject_reason: rejectReason
                                })
                            })
                            .then(response => response.json())
                            .then(response => {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.success,
                                    }).then((result) => {
                                        if (result.value) {
                                            window.location.reload(); // Menggunakan reload untuk menyegarkan halaman
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: response.error || 'Terjadi kesalahan. Silakan coba lagi.',
                                    });
                                }
                            }).catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan. Silakan coba lagi.',
                                });
                            });
                    }
                }
            });
        }
    </script>
    <!-- fetch confirm approved sweetalert -->
    <script>
        function approve($encrypted_id) {
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
                    fetch("<?= base_url('bukti-pengeluaran-kas/approve/'.$data_bpk->encrypted_id) ?>", {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "<?= csrf_hash() ?>"
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.success,
                                }).then((result) => {
                                    if (result.value) {
                                        const currentUrl = window.location.href;
                                        window.location.href = currentUrl;
                                    }
                                })
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert("Terjadi kesalahan. Silakan coba lagi.");
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