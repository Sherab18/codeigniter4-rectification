<?php echo $this->extend('layouts/layouts_general') ?>

<?php echo $this->section('navbar') ?>
<?php echo $this->include('partials/navbar_general') ?>
<?php echo $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Apply for: <?= esc($vacancy['title']) ?></h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('publicdata/careers/store-application') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="vacancy_id" value="<?= $vacancy['id'] ?>">

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name"
                    value="<?= old('first_name') ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name"
                    value="<?= old('last_name') ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= old('email') ?>" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone"
                    value="<?= old('phone') ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="cover_letter" class="form-label">Cover Letter</label>
            <textarea class="form-control" id="cover_letter" name="cover_letter" rows="5" required><?= old('cover_letter') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="resume" class="form-label">Resume (PDF, DOC, DOCX)</label>
            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx" required>
            <div class="form-text">Max file size: 2MB, Check the Job description details and upload the required Documents.</div>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
        <a href="<?= site_url('publicdata/careers/vacancy/' . $vacancy['id']) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>