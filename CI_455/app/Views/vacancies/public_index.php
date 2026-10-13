<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Career Opportunities & Results - <?= esc($title) ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="text-center mb-5 <?= $animation ?>">
        <h1 class="display-5 fw-bold text-primary mb-3">Career Opportunities</h1>
        <p class="lead text-muted">Join our team and track recruitment progress</p>
        <div class="border-bottom mx-auto" style="width: 80px; height: 3px; background-color: #0d6efd;"></div>
    </div>

    <!-- Tab Navigation -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-12">
            <ul class="nav nav-tabs nav-justified" id="careerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="open-positions-tab" data-bs-toggle="tab" data-bs-target="#open-positions" type="button" role="tab" aria-controls="open-positions" aria-selected="true">
                        <i class="bi bi-briefcase me-2"></i>Open Positions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="results-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab" aria-controls="results" aria-selected="false">
                        <i class="bi bi-clipboard-check me-2"></i>Recruitment Results
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="careerTabsContent">
        <!-- Open Positions Tab -->
        <div class="tab-pane fade show active" id="open-positions" role="tabpanel" aria-labelledby="open-positions-tab">
            <?php if (empty($vacancies)): ?>
                <!-- Empty State -->
                <div class="row justify-content-center <?= $animation ?>">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-briefcase display-1 text-muted"></i>
                                </div>
                                <h3 class="h4 text-muted mb-3">No Open Positions</h3>
                                <p class="text-muted mb-4">There are currently no open positions. Please check back later for new opportunities.</p>
                                <a href="<?= site_url() ?>" class="btn btn-primary">
                                    <i class="bi bi-house me-2"></i> Return Home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Vacancies Grid -->
                <div class="row g-4">
                    <?php foreach ($vacancies as $vacancy): ?>
                        <div class="col-lg-6 <?= $animation ?>">
                            <div class="card h-100 vacancy-card border-0 shadow-sm hover-shadow">
                                <div class="card-header bg-primary bg-opacity-10 py-3 border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0 text-primary fw-bold"><?= esc($vacancy['title']) ?></h5>
                                        <span class="badge bg-success rounded-pill">Open</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-muted">
                                            <i class="bi bi-building me-1"></i> <?= esc($vacancy['department']) ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <p class="card-text text-dark mb-3"><?= esc(substr($vacancy['description'], 0, 200)) ?>...</p>

                                    <?php if (!empty($vacancy['attachment_path'])): ?>
                                        <div class="mb-3">
                                            <a href="<?= site_url('publicdata/careers/download/' . $vacancy['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                                <i class="bi bi-file-earmark-pdf me-1"></i> Download Job Details
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="d-flex align-items-center text-muted small mt-3">
                                        <small class="d-block mt-1">Posted on: <?= date('F j, Y', strtotime($vacancy['created_at'])) ?></small>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent border-0 pt-0">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="<?= site_url('publicdata/careers/vacancy/' . $vacancy['id']) ?>" class="btn btn-outline-primary rounded-pill me-md-2">
                                            <i class="bi bi-eye me-1"></i> View Details
                                        </a>
                                        <!-- <a href="<?= site_url('publicdata/careers/apply/' . $vacancy['id']) ?>" class="btn btn-success rounded-pill">
                                            <i class="bi bi-send me-1"></i> Apply Now
                                        </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recruitment Results Tab -->
        <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
            <?php if (isset($results_vacancy) && isset($results_candidates)): ?>
                <!-- Specific Vacancy Results -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="#" onclick="switchToResultsTab()">Recruitment Results</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($results_vacancy['title']) ?></li>
                    </ol>
                </nav>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-success text-white">
                                <h2 class="h4 mb-0"><?= esc($results_vacancy['title']) ?></h2>
                                <small>Department: <?= esc($results_vacancy['department']) ?> | Position Type: <?= esc($results_vacancy['position_type']) ?></small>
                            </div>
                            <div class="card-body">
                                <p class="lead">Recruitment process results for the position of <?= esc($results_vacancy['title']) ?>.</p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center">
                                                <h3 class="text-success"><?= count(array_filter($results_candidates, function ($c) {
                                                                                return $c['status'] === 'hired';
                                                                            })) ?></h3>
                                                <p class="mb-0">Selected Candidates</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center">
                                                <h3 class="text-primary"><?= count(array_filter($results_candidates, function ($c) {
                                                                                return $c['status'] === 'shortlisted';
                                                                            })) ?></h3>
                                                <p class="mb-0">Shortlisted Candidates</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light border-0">
                                            <div class="card-body text-center">
                                                <h3 class="text-info"><?= count($results_candidates) ?></h3>
                                                <p class="mb-0">Total Candidates</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (empty($results_candidates)): ?>
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
                                        <?php foreach ($results_candidates as $candidate): ?>
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
                            <button type="button" class="btn btn-outline-primary" onclick="switchToResultsTab()">
                                <i class="bi bi-arrow-left me-1"></i> Back to All Results
                            </button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- General Results Overview -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-clipboard-check display-1 text-primary"></i>
                                </div>
                                <h3 class="h4 text-primary mb-3">Recruitment Results</h3>
                                <p class="text-muted mb-4">View the results of our recruitment processes and candidate selections.</p>
                                <p class="text-muted">Please select a specific recruitment process from the available results to view detailed candidate information.</p>
                                <a href="<?= site_url('publicdata/results') ?>" class="btn btn-primary">
                                    <i class="bi bi-list-ul me-2"></i> View All Results
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add subtle animation to cards on hover
        const cards = document.querySelectorAll('.vacancy-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Check if we should show results tab by default (when coming from a specific results page)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'results') {
            const resultsTab = new bootstrap.Tab(document.getElementById('results-tab'));
            resultsTab.show();
        }
    });

    function switchToResultsTab() {
        const resultsTab = new bootstrap.Tab(document.getElementById('results-tab'));
        resultsTab.show();
    }
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }

    .vacancy-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }

    .rounded-pill {
        border-radius: 50rem !important;
    }

    .bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .display-5 {
        font-size: 2.5rem;
    }

    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        border: none;
        color: #495057;
        background-color: rgba(13, 110, 253, 0.05);
    }

    .nav-tabs .nav-link.active {
        border: none;
        border-bottom: 3px solid #0d6efd;
        color: #0d6efd;
        background-color: transparent;
        font-weight: 600;
    }

    .tab-content {
        padding-top: 1.5rem;
    }

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

    @media (max-width: 768px) {
        .display-5 {
            font-size: 2rem;
        }

        .nav-tabs .nav-link {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
<?= $this->endSection() ?>