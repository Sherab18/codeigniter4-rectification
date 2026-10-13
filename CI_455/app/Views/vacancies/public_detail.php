<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
<?= esc($vacancy['title']) ?> - Career Opportunities
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5 <?= $animation ?>">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('publicdata/careers') ?>">Careers</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($vacancy['title']) ?></li>
        </ol>
    </nav>

    <!-- Main Card -->
    <div class="card shadow-lg border-0">
        <!-- Header Section -->
        <div class="card-header bg-primary text-white py-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="h2 mb-2"><?= esc($vacancy['title']) ?></h1>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-light text-primary fs-6">
                            <i class="bi bi-building me-1"></i><?= esc($vacancy['department']) ?>
                        </span>
                        <span class="badge bg-light text-primary fs-6">
                            <i class="bi bi-briefcase me-1"></i><?= esc($vacancy['position_type']) ?>
                        </span>
                    </div>
                </div>
                <?php if (!empty($vacancy['attachment_path'])): ?>
                <div class="d-none d-md-block">
                    <a href="<?= site_url('publicdata/careers/download/' . $vacancy['id']) ?>" 
                       class="btn btn-light btn-sm">
                        <i class="bi bi-download me-1"></i>Download Full Job Description
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body p-4">
            <!-- Meta Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center text-muted mb-2">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span>Posted: <?= date('F j, Y', strtotime($vacancy['created_at'])) ?></span>
                    </div>
                    <?php if (!empty($vacancy['close_at'])): ?>
                    <div class="d-flex align-items-center text-muted">
                        <i class="bi bi-clock me-2"></i>
                        <span>Closes: <?= date('F j, Y', strtotime($vacancy['close_at'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                
            </div>

            <hr>

            <!-- Job Description -->
            <div class="mb-5">
                <h3 class="h4 text-primary mb-3">
                    <i class="bi bi-file-text me-2"></i>Job Description
                </h3>
                <div class="bg-light p-4 rounded-3">
                    <?= nl2br(esc($vacancy['description'])) ?>
                </div>
            </div>

            <!-- Requirements Section (Optional - you can add this field to your database if needed) -->
            

            <!-- Benefits Section (Optional) -->

            <!-- Download Section for Mobile -->
            <?php if (!empty($vacancy['attachment_path'])): ?>
            <div class="d-md-none mb-4">
                <a href="<?= site_url('publicdata/careers/download//' . $vacancy['id']) ?>" 
                   class="btn btn-primary w-100">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Download Full Job Description
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Card Footer -->
        <!-- <div class="card-footer bg-light py-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5 class="mb-1">Ready to apply?</h5>
                    <p class="mb-0 text-muted">Join our team and grow your career with us</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end">
                        <a href="<?= site_url('publicdata/careers') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Positions
                        </a>
                        <a href="<?= site_url('publicdata/candidates/apply/' . $vacancy['id']) ?>" 
                           class="btn btn-success btn-lg">
                            <i class="bi bi-send me-2"></i>Apply Now
                        </a>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.card {
    border-radius: 1rem;
    overflow: hidden;
}
.card-header {
    border-radius: 1rem 1rem 0 0 !important;
}
.breadcrumb {
    background-color: transparent;
    padding: 0;
}
.breadcrumb-item a {
    text-decoration: none;
    color: #6c757d;
}
.breadcrumb-item.active {
    color: #0d6efd;
}
.badge {
    font-size: 0.85em;
    padding: 0.5em 0.75em;
}
.btn-lg {
    padding: 0.75rem 1.5rem;
    font-weight: 600;
}
.bg-light {
    background-color: #f8f9fa !important;
}
.rounded-3 {
    border-radius: 0.75rem !important;
}
</style>
<?= $this->endSection() ?>