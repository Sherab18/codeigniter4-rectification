<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('navbar') ?><?= $this->include('partials/navbar_general') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('results') ?>">Recruitment Results</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($vacancy['title']) ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h2 class="h4 mb-0"><?= esc($vacancy['title']) ?></h2>
                    <small>Department: <?= esc($vacancy['department']) ?> | Position Type: <?= esc($vacancy['position_type']) ?></small>
                </div>
                <div class="card-body">
                    <p class="lead">Recruitment process results for the position of <?= esc($vacancy['title']) ?>.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <h3 class="text-success"><?= count(array_filter($candidates, function($c) { return $c['status'] === 'hired'; })) ?></h3>
                                    <p class="mb-0">Selected Candidates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <h3 class="text-primary"><?= count(array_filter($candidates, function($c) { return $c['status'] === 'shortlisted'; })) ?></h3>
                                    <p class="mb-0">Shortlisted Candidates</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <h3 class="text-info"><?= count($candidates) ?></h3>
                                    <p class="mb-0">Total Candidates</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($candidates)): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-people display-1 text-muted"></i>
                        </div>
                        <h3 class="h4 text-muted mb-3">No Results Available</h3>
                        <p class="text-muted">No candidate information is available for this recruitment process.</p>
                    </div>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h3 class="h5 mb-0">Candidate Results</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($candidates as $candidate): ?>
                                <a href="<?= site_url('publicdata/results/candidate/' . $candidate['id']) ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1"><?= esc($candidate['full_name']) ?></h5>
                                            <small class="text-muted">Applied: <?= date('F j, Y', strtotime($candidate['created_at'])) ?></small>
                                        </div>
                                        <span class="badge bg-<?= $candidate['status'] === 'hired' ? 'success' : 'primary' ?> rounded-pill">
                                            <?= ucfirst($candidate['status']) ?>
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4 text-center">
                <a href="<?= site_url('publicdata/results') ?>" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to All Results
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
        transition: all 0.2s;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
<?= $this->endSection() ?>