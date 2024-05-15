<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Request</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .status-card {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .status-icon {
            font-size: 30px;
            margin-right: 10px;
        }

        .status-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .status-text {
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .status-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            /* Menambahkan properti ini agar tombol sejajar */
            flex-wrap: wrap;
            /* Menambahkan wrap agar item bisa terpisah ke bawah */
        }

        .action-btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
            /* Menambahkan margin bawah pada tombol */
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        .action-btn.view {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .action-btn.back {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }

        .status-approved {
            color: green;
        }

        /* CSS untuk perubahan layout di layar yang cukup lebar */
        @media screen and (min-width: 576px) {
            .action-btn {
                margin-bottom: 0;
                /* Menghapus margin bawah pada tombol */
            }
        }
    </style>
</head>

<body>

    <div class="status-card">
        <div class="status-icon"><i class="fas fa-user"></i></div>
        <div class="status-title">Tahap Status Request Kamu</div>
        <!-- <div class="status-text"> -->
        <p><strong>Nama:</strong> <?= $data_bpk->nama_user ?></p>
        <p><strong>Tanggal Request:</strong> <?= $data_bpk->created_at ?></p>
        <!-- </div> -->
        <div class="status-actions">

            <a href="<?= base_url('bpk-detail/' . base64_encode($data_bpk->no_bpk)) ?>" class="btn btn-primary action-btn view"><i class="fas fa-eye"></i> Lihat</a>
            <!-- <div> -->
            <a href="<?= base_url('/') ?>" class="action-btn back"><i class="fas fa-arrow-left"></i> Kembali</a>
            <!-- </div> -->
        </div>
        <div class="status-text">
            <p><strong>Status: </strong> In-Process</span></p>
            <!-- Untuk status "In-Process", icon proses ditampilkan -->
            <i class="fas fa-spinner fa-spin status-icon"></i>
            <p>Mohon di tunggu request form anda, sedang di cek oleh<strong> Admin</strong>.</p>
        </div>
    </div>
    <!-- Konten HTML Anda yang sudah ada -->
    <!-- Konten HTML Anda yang sudah ada -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JavaScript untuk memperbarui status -->
    <script>
        // Fungsi untuk memperbarui status form secara asinkron
        function updateStatus() {
            // Ambil status saat ini dari variabel data_bpk
            var currentBpk = '<?= $data_bpk->no_bpk ?>'; // Ambil Bpk dari PHP dan simpan dalam variabel JavaScript

            $.ajax({
                url: '/update-status',
                type: 'POST', // Menggunakan metode POST karena kita ingin mengirim data
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>',
                    'currentBpk': currentBpk
                }, // Kirim data status ke backend
                success: function(response) {
                    // Update tampilan berdasarkan respons dari server
                    if (response.status === 'Approved') {
                        $('.status-actions').html(`
                        <a href="#" class="action-btn print" onclick="generatePDF('<?= $data_bpk->no_bpk ?>')"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                        <a href="<?= base_url('/') ?>" class="action-btn back"><i class="fas fa-arrow-left"></i> Kembali</a>
                    `);
                        $('.status-text').html(`
                        <p><strong>Status:</strong> <span class="status-approved"><i class="fas fa-check-circle"></i> Approved</span></p>
                        <i class="fas fa-check-circle status-icon"></i>
                        <p>Selamat Request anda telah di <strong>Approved</strong>.</p>
                    `);
                    }
                    if (response.status === 'Rejected') {
                        $('.status-actions').html(`
                        <a href="#" class="action-btn back"><i class="fas fa-eye"></i> Lihat</a>
                        <a href="<?= base_url('/') ?>" class="action-btn back"><i class="fas fa-arrow-left"></i> Kembali</a>
                    `);
                        $('.status-text').html(`
                    <p><strong>Status:</strong> Rejected</p>
                     <i class="fas fa-times-circle status-icon"></i>
                    <p>Periksa kembali file <strong>PDF</strong> Anda.</p>
                    `);
                    }
                    // Anda bisa menambahkan logika untuk kasus lainnya seperti 'In-Process', 'Rejected', dll.
                },
                error: function(xhr, status, error) {
                    // Handle error jika terjadi
                    console.error(error);
                }
            });
        }

        // Panggil fungsi updateStatus secara berkala misalnya setiap 5 detik
        setInterval(updateStatus, 1000); // Ubah angka 5000 menjadi interval yang sesuai dengan kebutuhan Anda
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- Fungsi untuk mencetak PDF -->
    <script>
        function generatePDF(no_bpk) {
            // Kirim permintaan AJAX untuk mendapatkan konten HTML
            $.ajax({
                url: '/pdf/generate-pdf/' + no_bpk,
                method: 'GET',
                success: function(response) {
                    // Gunakan library html2pdf.js untuk membuat PDF dari konten HTML
                    html2pdf().from(response).save();
                },
                error: function(xhr, status, error) {
                    console.error('Kesalahan saat memuat konten HTML:', error);
                }
            });
        }
    </script>




</body>

</html>

<!-- Konten HTML Anda yang sudah ada -->