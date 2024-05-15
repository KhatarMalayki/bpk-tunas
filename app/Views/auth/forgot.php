<?= $this->extend('auth/template'); ?>

<?= $this->section('content'); ?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                    </div>
                    <div class="card-body">
                        <!-- alert notifikasi -->
                        <?= view('Myth\Auth\Views\_message_block') ?>

                        <p><?=lang('Auth.enterEmailForInstructions')?></p>

                        <!-- <div class="small mb-3 text-muted"><?=lang('Auth.enterEmailForInstructions')?></div> -->
                        <form action="<?= site_url('forgot') ?>" method="post">
                        <?= csrf_field() ?>

                            <div class="form-floating mb-3">
                                <input class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" id="inputEmail" type="email"
                                    placeholder="<?=lang('Auth.emailAddress')?>" name="email" />
                                <label for="inputEmail"><?=lang('Auth.emailAddress')?></label>
                                <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small" href="<?= site_url('login') ?>">Return to login</a>
                                <button type="submit" class="btn btn-primary"><?=lang('Auth.sendInstructions')?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection(); ?>