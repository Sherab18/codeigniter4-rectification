<?php echo $this->extend('layouts/layouts_user') ?>

<?php echo $this->section('navbar') ?>
<?php echo $this->include('partials/navbar_user') ?>
<?php echo $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Select Candidate</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h4><?= esc($candidate['first_name'] . ' ' . $candidate['last_name']) ?></h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Email:</strong> <?= esc($candidate['email']) ?>
                </div>
                <div class="col-md-6">
                    <strong>Phone:</strong> <?= esc($candidate['phone']) ?>
                </div>
            </div>
            <div class="mb-3">
                <strong>Current Status:</strong>
                <span class="badge bg-warning"><?= ucfirst($candidate['status']) ?></span>
            </div>
        </div>
    </div>

    <form action="<?= site_url('career/candidates/store-selection') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="candidate_id" value="<?= $candidate['id'] ?>">

        <div class="mb-3">
            <label for="notes" class="form-label">Hiring Notes (Optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            <div class="form-text">Add any notes about this hiring decision.</div>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle"></i> Select Candidate
        </button>
        <a href="<?= site_url('career/vacancies/view/' . $candidate['vacancy_id']) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>