<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>


<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!-- MUST include enctype="multipart/form-data" -->
                    <form action="<?= base_url('auth/update-profile') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- Current Avatar Preview -->
                        <div class="text-center mb-4">
                            <?php
                            $avatarUrl = !empty($user['avatar']) && file_exists(FCPATH . 'assets/uploads/avatars/' . $user['avatar'])
                                ? base_url('assets/uploads/avatars/' . $user['avatar']) . '?v=' . time()
                                : base_url('assets/img/avatar_0.jpg');
                            ?>
                            <img src="<?= $avatarUrl ?>" alt="Profile Picture" width="100" height="100" class="rounded-circle border border-3 border-primary object-fit-cover shadow-sm mb-2">
                            <div>
                                <label for="avatar_input" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fas fa-camera me-1"></i> Change Photo
                                    <input type="file" id="avatar_input" name="avatar" class="d-none" accept="image/*" onchange="this.form.submit()">
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="given_name" class="form-label">Given Name</label>
                                <input type="text" id="given_name" name="given_name" class="form-control" value="<?= esc(old('given_name', $user['given_name'])) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= esc(old('last_name', $user['last_name'])) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="sex" class="form-label">Sex / Gender</label>
                            <select id="sex" name="sex" class="form-select" required>
                                <option value="Male" <?= (old('sex', $user['sex']) === 'Male') ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= (old('sex', $user['sex']) === 'Female') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" value="<?= esc(old('mobile', $user['mobile'])) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= esc(old('email', $user['email'])) ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>