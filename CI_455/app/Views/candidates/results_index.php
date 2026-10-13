<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>Recruitment Results - <?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('navbar') ?><?= $this->include('partials/navbar_general') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary mb-3">Recruitment Results</h1>
        <p class="lead text-muted">View the results of our recruitment processes</p>
    </div>

    <?php if (empty($vacancies)): ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-folder-x display-1 text-muted"></i>
                        </div>
                        <h3 class="h4 text-muted mb-3">No Results Available</h3>
                        <p class="text-muted mb-4">There are no published recruitment results at this time.</p>
                        <a href="<?= site_url() ?>" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i> Return Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($vacancies as $vacancy): ?>
                <div class="col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><?= esc($vacancy['title']) ?></h5>
                            <small>Department: <?= esc($vacancy['department']) ?></small>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View results for the position of <?= esc($vacancy['title']) ?> in our <?= esc($vacancy['department']) ?> department.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Closed: <?= date('F j, Y', strtotime($vacancy['close_at'])) ?>
                                </small>
                                <a href="<?= site_url('publicdata/results/vacancy/' . $vacancy['id']) ?>" class="btn btn-primary btn-sm">
                                    View Results <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>