<?php echo $this->extend('layouts/layouts_user') ?>

<?php echo $this->section('navbar') ?>
<?php echo $this->include('partials/navbar_user') ?>
<?php echo $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Shortlist Candidate</h2>

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
                <strong>Cover Letter:</strong>
                <p><?= nl2br(esc($candidate['cover_letter'])) ?></p>
            </div>
            <div>
                <a href="<?= site_url('career/candidates/resume/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-file-earmark-pdf"></i> View Resume
                </a>
            </div>
        </div>
    </div>

    <form action="<?= site_url('career/candidates/store-shortlist') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="candidate_id" value="<?= $candidate['id'] ?>">

        <div class="mb-3">
            <label for="notes" class="form-label">Shortlist Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
            <div class="form-text">Add any notes about why this candidate is being shortlisted.</div>
        </div>

        <button type="submit" class="btn btn-warning">
            <i class="bi bi-person-check"></i> Shortlist Candidate
        </button>
        <a href="<?= base_url('career/vacancies/view/' . $candidate['vacancy_id']) ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>