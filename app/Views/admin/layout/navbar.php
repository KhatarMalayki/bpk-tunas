<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard

                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                    Bukti Pengeluaran Kas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?= base_url('request-form') ?>">User Request</a>
                        <a class="nav-link" href="<?= base_url('bukti-pengeluaran-kas') ?>">Data Bpk</a>
                    </nav>
                </div>

                <!-- <a class="nav-link" href="<?= base_url('slider') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                    Manage Slider
                </a> -->
                <!-- <a class="nav-link" href="<?= base_url('bukti-pengeluaran-kas') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-money-check-alt"></i></div>
                    Bukti Pengeluaran Kas
                </a> -->
                <!-- <a class="nav-link" href="<?= base_url('request-form') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Request Form
                </a> -->
                    <!-- <a class="nav-link" href="<?= base_url('team') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-users-circle"></i></div>
                        Manage Team
                    </a> -->


                    <a class="nav-link" href="<?= base_url('akun') ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Akun
                    </a>

                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php if (logged_in()) : ?>
                <?= user()->fullname ?>
            <?php else : ?>
                Guest
            <?php endif; ?>
        </div>
    </nav>
</div>