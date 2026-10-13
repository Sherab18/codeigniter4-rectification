<?= $this->extend('layouts/layouts_login') ?>

<?= $this->section('title') ?>
Login | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?><br>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 mt-5">
                    <div class="card-header bg-primary text-white text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= base_url('users/loginProcess') ?>" method="post">
                            <?= csrf_field(); ?>
                            <?php if (isset($validation)): ?>
                                <div class="alert alert-danger">
                                    <?= $validation->listErrors(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>" required placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6Ld_y2wqAAAAAL6LLNi9qkmFgmxs1La9w3YajQir"></div>
                            </div>

                            <div class="d-grid justify-content-start">
                                <button type="submit" class="btn btn-outline-primary">Login</button>
                            </div>

                        </form>

                        <div class="text-center mt-4">
                            <p>Don't have an account? <a href="<?= base_url('users/register') ?>" class="text-primary">Sign up here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><br>
<?= $this->endSection() ?>