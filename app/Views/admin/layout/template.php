<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('asset-admin'); ?>/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Load jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- CSS -->
    <style>
        @media (max-width: 768px) and (pointer: fine) {
            body.sb-sidenav-toggled .sb-topnav {
                transform: translateX(0);
                /* Mengembalikan posisi navbar ke posisi semula */
            }

            body.sb-sidenav-toggled #layoutSidenav {
                transition: transform 0.3s ease;
                /* Animasi pengembalian layout sidenav ke posisi semula */
                transform: translateX(-250px);
                /* Mengembalikan posisi sidenav ke posisi semula */
            }
        }

        @media (max-width: 768px) {

            .sb-sidenav-collapse-arrow {
                margin-top: 0;
                /* Atur ulang margin */
            }
        }

        .sb-sidenav-collapse-arrow {
            margin-top: 3px;
            /* Sesuaikan dengan jarak yang Anda inginkan */
        }
    </style>
    <?= $this->renderSection('style') ?>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle-->
        <?php if (logged_in() && in_groups('admin')) : ?>
        <div style="flex-direction: row-reverse;">
            <button class=" btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        </div>
        <?php endif; ?>
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?= base_url('dashboard') ?>">Tunas</a>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('login') ?>">Login</a></li>
                    <!-- <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li> -->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?= base_url() ?>">Home</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <!-- include file navbar -->
        <?php if (logged_in() && in_groups('admin')) : ?>
        <?= $this->include('admin/layout/navbar') ?>
        <?php endif; ?>
        <!-- render halaman/section content -->
        <?php echo $this->renderSection('content'); ?>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between small">
                    <div class="mb-3 mb-sm-0">
                        <a href="#" class="d-block d-sm-inline-block">Privacy Policy</a>
                        &middot;
                        <a href="#" class="d-block d-sm-inline-block">Terms &amp; Conditions</a>
                    </div>
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="<?php echo base_url('asset-admin'); ?>/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('asset-admin'); ?>/assets/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url('asset-admin'); ?>/assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('asset-admin'); ?>/js/datatables-simple-demo.js"></script>
    <!-- JS -->
    <script>
        // Mendeteksi apakah pengguna mengakses dari perangkat Android atau tidak
        const isAndroid = navigator.userAgent.toLowerCase().indexOf("android") > -1;

        // Jika pengguna bukan dari perangkat Android, tambahkan kelas sb-sidenav-toggled
        if (!isAndroid) {
            document.body.classList.add("sb-sidenav-toggled");
        }
    </script>


    <?= $this->renderSection('script') ?>
</body>

</html>