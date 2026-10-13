<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('navbar') ?><?= $this->include('partials/navbar_general') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('publicdata/results') ?>">Recruitment Results</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('publicdata/results/vacancy/' . $vacancy['id']) ?>"><?= esc($vacancy['title']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($candidate['full_name']) ?></li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-<?= $candidate['status'] === 'hired' ? 'success' : 'primary' ?> text-white">
                    <h2 class="h4 mb-0"><?= esc($candidate['full_name']) ?></h2>
                    <span class="badge bg-light text-<?= $candidate['status'] === 'hired' ? 'success' : 'primary' ?>">
                        <?= ucfirst($candidate['status']) ?> Candidate
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Position Applied</h5>
                            <p><?= esc($vacancy['title']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Department</h5>
                            <p><?= esc($vacancy['department']) ?></p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted">Application Date</h5>
                            <p><?= date('F j, Y', strtotime($candidate['created_at'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted">Status</h5>
                            <p><span class="badge bg-<?= $candidate['status'] === 'hired' ? 'success' : 'primary' ?>"><?= ucfirst($candidate['status']) ?></span></p>
                        </div>
                    </div>
                    
                    <?php if (!empty($candidate['cover_letter'])): ?>
                    <div class="mb-4">
                        <h5 class="text-muted">Cover Letter</h5>
                        <div class="border p-3 rounded bg-light">
                            <?= nl2br(esc($candidate['cover_letter'])) ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="<?= site_url('publicdata/results/vacancy/' . $vacancy['id']) ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Results
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>