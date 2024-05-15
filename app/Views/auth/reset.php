<?= $this->extend('auth/template'); ?>

<?= $this->section('content'); ?>
<main>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card shadow-lg border-0 rounded-lg mt-4">
                    <div class="card-header">
                <h3 class="card-header"><?=lang('Auth.resetYourPassword')?></h3>
                <div class="card-body">

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <p><?=lang('Auth.enterCodeEmailPassword')?></p>

                    <form action="<?= url_to('reset-password') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="token"><?=lang('Auth.token')?></label>
                            <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>"
                                   name="token" placeholder="<?=lang('Auth.token')?>" value="<?= old('token', $token ?? '') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.token') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email"><?=lang('Auth.email')?></label>
                            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                   name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        </div>

                        <br>

                        <div class="form-group">
                            <label for="password"><?=lang('Auth.newPassword')?></label>
                            <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                   name="password">
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pass_confirm"><?=lang('Auth.newPasswordRepeat')?></label>
                            <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                   name="pass_confirm">
                            <div class="invalid-feedback">
                                <?= session('errors.pass_confirm') ?>
                            </div>
                        </div>

                        <br>
                        <div class="d-flex align-items-center justify-content-between mt-3 mb-0">
                                <a class="small" href="<?= site_url('login') ?>">Return to login</a>
                        <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.resetPassword')?></button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
</div>
</main>
<?= $this->endSection(); ?>