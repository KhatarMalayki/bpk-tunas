<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $title ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Roboto:100,300,400,500,700|Philosopher:400,400i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">

    <!-- =======================================================
  * Template Name: eStartup
  * Template URL: https://bootstrapmade.com/estartup-bootstrap-landing-page-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    <style>
        fieldset {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
    <style>
        .small-search {
            width: 200px;
            /* Sesuaikan ukuran kotak pencarian sesuai kebutuhan Anda */
        }
    </style>

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <div id="logo">
                <h1><a href="<?= base_url('/') ?>"><span>Request</span>Bukti Pengeluaran Kas</a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" title="" /></a>-->
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <!-- <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about-us">About</a></li>
                    <li><a class="nav-link scrollto" href="#features">Features</a></li>
                    <li><a class="nav-link scrollto" href="#screenshots">Screenshots</a></li>
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>
                    <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li> -->
                    <li class="dropdown"><a href="#"><span><?php if (logged_in()) : ?>
                                    <?= user()->fullname ?>
                                <?php else : ?>
                                    Guest
                                <?php endif; ?></span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="<?= base_url('dashboard') ?>">Login</a></li>
                            <!-- <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li> -->
                            <li><a href="<?= base_url('logout') ?>">Logout</a></li>
                            <!-- <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li> -->
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="hero-container" data-aos="fade-in">
            <h1>Check Request Status</h1>
            <div class="input-container">
                <?= form_open() ?>
                <div class="form-floating mb-3">
                    <input type="text" id="request_id" name="request_id" placeholder="Enter request ID" class="form-control rounded-3" required>
                    <label for="request_id" class="ms-3">Request ID</label>
                </div>
                <a href="#" id="check" class="btn btn-primary rounded-pill"><i class="bi bi-search"></i> Check
                    Status</a>
                <?= form_close() ?>
            </div>
        </div>
    </section><!-- End Hero Section -->

    <main id="main">

        <!-- ======= Request Form Ticketing Section ======= -->
        <section id="request-form" class="padd-section text-center">

            <div class="container" data-aos="fade-up">
                <div class="section-title text-center">

                    <h2>Request Form BPK</h2>
                    <p class="separator">Fill out the form below to request your ticket.</p>

                </div>
            </div>
            <?php if (session()->has('success')) : ?>
                <script>
                    // Gunakan SweetAlert untuk menampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '<?= session('success') ?>',
                    });
                </script>
            <?php endif; ?>

            <!-- Display validation errors -->
            <?php if (session()->has('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach (session('error') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <script>
                    window.location.hash = '#request-form';
                </script>
            <?php endif; ?>

            <!-- Akhir form pencarian -->
            <div class="container">
                <div class="row">
                    <form id="requestForm">
                        <input type="hidden" name="status" id="status" value="In-Process">
                        <!-- <input type="hidden" name="created_at" id="created_at" value="<?= date('Y-m-d H:i:s') ?>"> -->
                        <div class="col-md-6 offset-md-3" data-aos="zoom-in" data-aos-delay="100">
                            <fieldset>
                                <!-- Tambahkan form pencarian di sini -->
                                <strong>Masukkan NIK Anda lalu tekan Enter untuk pengisian otomatis</strong>
                                <div class="search-container d-flex justify-content-center align-items-center">
                                    <input type="text" id="search" name="search" placeholder="Search..." class="form-control rounded-3 small-search">
                                </div>
                                <!-- <legend style="text-align: left;">Informasi Pribadi</legend> -->
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Nama</h4>
                                    <input type="text" class="form-control <?= session('error')['nama'] ?? '' ? 'is-invalid' : '' ?>" id="nama" name="nama" placeholder="isi nik di atas" readonly>
                                </div>
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Email</h4>
                                    <input type="email" class="form-control <?= session('error')['nik'] ?? '' ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="isi nik pada kolom search" readonly>
                                </div>
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Jumlah Uang</h4>
                                    <input type="text" class="form-control <?= session('error')['jmlh_uang'] ?? '' ? 'is-invalid' : '' ?>" id="jmlh_uang" name="jmlh_uang" placeholder="Masukkan jumlah uang sesuai data pengajuan anda">
                                </div>
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Untuk Keperluan</h4>
                                    <input type="text" class="form-control <?= session('error')['for_kprln'] ?? '' ? 'is-invalid' : '' ?>" id="for_kprln" name="for_kprln" placeholder="info keperluaan nya apa">
                                </div>
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Upload File</h4>
                                    <input type="file" class="form-control-file <?= session('error')['file'] ?? '' ? 'is-invalid' : '' ?>" id="file" name="file">
                                </div>
                                <div class="feature-block">

                                    <button id="submitForm" name="submitForm" class="btn btn-primary">Submit</button>

                                </div>
                            </fieldset>
                        </div>
                        <!-- <div class="container">
                        <div class="row"> -->
                        <!-- <div class="col-md-6 offset-md-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="feature-block">
                                    <h4 style="text-align: left;">Nama Kategori</h4>
                                    <select name="kategori" id="kategori" class="form-control form-control-sm">
                                        <option value="" selected disabled>---- Pilih Kategori ----</option>
                                        
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                    </div> -->
                        <!-- </div>
                    </div> -->
                        <!-- Container for additional photo uploads -->
                        <!-- <div id="additionalPhotos&Inputs"></div>

                    <div class="col-md-6 mt-3" data-aos="zoom-in" data-aos-delay="500">
                        <div class="feature-block">
                            <button type="button" class="btn btn-info rounded-circle" id="addPhotoBtn">Tambah Foto</button>
                        </div>
                    </div> -->
                    </form>
                </div>
            </div>

        </section><!-- End Request Form Ticketing Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer class="footer">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-4">
                    <div class="footer-logo">

                        <a class="navbar-brand" href="#">requestForm Ticketing</a>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the.</p>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="list-menu">

                        <h4>Abou Us</h4>

                        <ul class="list-unstyled">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Features item</a></li>
                            <li><a href="#">Live streaming</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="list-menu">

                        <h4>Abou Us</h4>

                        <ul class="list-unstyled">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Features item</a></li>
                            <li><a href="#">Live streaming</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="list-menu">

                        <h4>Support</h4>

                        <ul class="list-unstyled">
                            <li><a href="#">faq</a></li>
                            <li><a href="#">Editor help</a></li>
                            <li><a href="#">Contact us</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <div class="list-menu">

                        <h4>Abou Us</h4>

                        <ul class="list-unstyled">
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Features item</a></li>
                            <li><a href="#">Live streaming</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <div class="copyrights">
            <div class="container">
                <p>&copy; Copyrights mKhatar. All rights reserved.</p>
                <div class="credits">
                    <!--
          All the links in the footer should remain intact.
          You can delete the links only if you purchased the pro version.
          Licensing information: https://bootstrapmade.com/license/
          Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eStartup
        -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>
        </div>

    </footer><!-- End  Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Pastikan jQuery dimuat sebelum script Anda -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Ketika tombol ditekan, ambil nilai dari input dan perbarui href atribut anchor tag -->
    <!-- Include CryptoJS library -->
    <!-- New JavaScript/jQuery code for form submission with SweetAlert -->
    <script>
        $(document).ready(function() {
            $('#submitForm').click(function() {
                // Menampilkan pesan loading dengan ikon animasi
                Swal.fire({
                    title: 'Loading...',
                    html: '<img src="assets/img/load-142_128.gif" alt="Loading..." style="width: 50px;">', // Ganti path sesuai dengan lokasi gambar loading Anda
                    showConfirmButton: false, // Sembunyikan tombol OK selama loading
                    allowOutsideClick: false, // Mencegah pengguna menutup SweetAlert selama loading
                });

                // Serialize the form data
                event.preventDefault(); // Mencegah pengiriman formulir melalui URL
                // Get form values
                // var nama = $('#nama').val();
                // var jmlh_uang = $('#jmlh_uang').val();
                // var for_kprln = $('#for_kprln').val();
                // var fileInput = document.getElementById('file');
                // var file = fileInput.files[0]; // Get the first file from the input field
                // Get form values
                var formData = new FormData($('#requestForm')[0]);
                // Append CSRF token to FormData
                formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'request-bpk', // URL to handle form submission
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Set content type to false, jQuery will automatically set it to multipart/form-data
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Jika request sukses, hilangkan pesan loading dan tampilkan pesan sukses
                            Swal.close(); // Tutup pesan loading
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                html: response.message,
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = '<?= base_url('/'); ?>'
                                }
                            });
                        } else {
                            // Jika request gagal, hilangkan pesan loading dan tampilkan pesan error
                            Swal.close(); // Tutup pesan loading
                            var errorMessage = Object.values(response.message).join('<br>');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                html: errorMessage,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Jika terjadi kesalahan dalam request AJAX, tampilkan pesan error
                        Swal.close(); // Tutup pesan loading
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to submit the form. Please try again later.',
                        });
                    }
                });
            });
        });
    </script>
    <!-- Pastikan Anda memasukkan dependensi CryptoJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <!-- check request ID -->
    <script>
        document.getElementById('check').addEventListener('click', function() {
            var requestId = document.getElementById('request_id').value;
            // Lakukan enkripsi di sini, misalnya dengan menggunakan fungsi bawaan JavaScript seperti btoa()
            // var encryptedRequestId = btoa(requestId); // Contoh sederhana, sebaiknya gunakan metode enkripsi yang lebih aman
            var baseUrl = '<?= base_url() ?>'; // Ambil base URL dari PHP
            var newUrl = baseUrl + 'status/' + requestId;
            // var newUrl = baseUrl + 'status/' + encodeURIComponent(encryptedRequestId);
            document.getElementById('check').setAttribute('href', newUrl);
        });
    </script>
    <!-- event listener search -->
    <script>
        document.getElementById('search').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                var searchInput = document.getElementById('search').value;
                // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch('/search', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
                        },
                        body: JSON.stringify({
                            'searchInput': searchInput
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        document.getElementById("nama").value = data.fullname;
                        document.getElementById("email").value = data.email;
                    })
                    .catch(error => console.error(error));
            }
        })
    </script>
    <!-- script untuk memberikan name pada id upload -->
    <!-- <script>
        $(document).on('change', 'select[name^="kategori"]', function() {
            var uploadId = $(this).attr('id').replace('kategori', ''); // Mendapatkan nomor ID upload dari ID kategori
            var uploadInput = $('#upload' + uploadId); // Memilih input upload yang sesuai dengan nomor ID
            // var selectedKategori = $(this).val(); // Memilih kategori yang dipilih
            // var nameKategori = $('#kategori')

            var slugKategori = $(this).val();
            if (slugKategori.trim() !== '') {
                uploadInput.attr("name", slugKategori); // Memberikan nama kategori pada atribut "name" input upload yang sesuai
                // $(this).attr("name", slugKategori);
            } else {
                uploadInput.attr("name", "default"); // Atau nama default jika kategori kosong
            }
        });
    </script> -->
    <!-- script untuk menambah form upload & form kategori -->
    <!-- <script>
        var lastUploadId = 1; // Nomor ID terakhir untuk elemen upload
        var lastKategoriId = 1; // Nomor ID terakhir untuk elemen kategori
        document.getElementById('addPhotoBtn').addEventListener('click', function() {
            var additionalPhotosContainer = document.getElementById('additionalPhotos&Inputs');
            var additionalPhotoInput = document.createElement('div');
            additionalPhotoInput.innerHTML =
                '<div class="container">' +
                '<div class="row">' +
                '<div class="col-md-6 offset-md-3" data-aos="zoom-in" data-aos-delay="100">' +
                '<div class="row">' +
                '<div class="col-md-6">' +
                '<div class="feature-block">' +
                '<h4 style="text-align: left;">Nama Kategori</h4>' +
                '<select id="kategori' + lastKategoriId + '" class="form-control form-control-sm" name="kategori">' +
                '<option value="" selected disabled>---- Pilih Kategori ----</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<div class="feature-block">' +
                '<h4 style="text-align: left;">Upload Foto</h4>' +
                '<input type="file" class="form-control-file" id="upload' + lastUploadId + '">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            additionalPhotosContainer.appendChild(additionalPhotoInput);
            lastKategoriId++;
            lastUploadId++;
        });
    </script> -->
    <!-- menentapkan aturan select -->
    <!-- <script>
        // Objek untuk menyimpan kategori yang sudah dipilih
        var selectedCategories = {};
        // const swal = $('.swal').data('swal');
        // Memantau perubahan pada semua elemen select dengan nama yang dimulai dengan 'kategori'
        $(document).on('change', 'select[name^="kategori"]', function() {
            // Mendapatkan nomor ID kategori dari ID elemen select
            var categoryId = $(this).attr('id').replace('kategori', '');
            // Mendapatkan nilai (value) kategori yang dipilih
            var selectedCategory = $(this).val();

            // Memeriksa apakah kategori sudah dipilih pada form lain
            if (selectedCategories[selectedCategory] && selectedCategories[selectedCategory] !== categoryId) {
                // Jika kategori sudah dipilih pada form lain, set kembali opsi select menjadi default
                $(this).val('');
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Kategori ini sudah dipilih pada form lain. Silakan pilih kategori lain.',
                });
            } else {
                // Jika kategori belum dipilih pada form lain, simpan kategori yang dipilih pada objek selectedCategories
                selectedCategories[selectedCategory] = categoryId;
            }
        });
    </script> -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>