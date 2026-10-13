
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <ul class="nav nav-tabs mb-4" id="careerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active d-flex align-items-center" id="tender-tab" data-bs-toggle="tab"
                        data-bs-target="#tender-pane" type="button" role="tab" aria-controls="tender-pane"
                        aria-selected="true">
                        <i class="bi bi-file-earmark-text me-2"></i> Tender Notices
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center" id="career-tab" data-bs-toggle="tab"
                        data-bs-target="#career-pane" type="button" role="tab" aria-controls="career-pane"
                        aria-selected="false">
                        <i class="bi bi-briefcase me-2"></i> Career Opportunities
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="careerTabsContent">
                <!-- Tender Pane -->
                <div class="tab-pane fade show active" id="tender-pane" role="tabpanel" aria-labelledby="tender-tab" tabindex="0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <i class="bi bi-megaphone me-2"></i>
                            <h5 class="mb-0">Active Tenders</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($latestTenders)) : ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($latestTenders as $tenderItem) : ?>
                                        <a href="<?= base_url() ?>publicdata/show/<?= $tenderItem['id'] ?>"
                                            class="list-group-item list-group-item-action py-3 px-4">
                                            <div class="d-flex w-100 justify-content-between align-items-start">
                                                <div class="me-3">
                                                    <h6 class="mb-1 fw-bold text-primary"><?= esc($tenderItem['title']) ?></h6>
                                                    <div class="d-flex flex-wrap text-muted small mb-1">
                                                        <span class="me-3">
                                                            <i class="bi bi-hash me-1"></i> Ref: <?= esc($tenderItem['reference'] ?? 'N/A') ?>
                                                        </span>
                                                        <span>
                                                            <i class="bi bi-person me-1"></i> Contact: <?= esc($tenderItem['contact_name'] ?? 'N/A') ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-calendar me-1"></i> <?= date('d M Y', strtotime($tenderItem['created_at'])) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-2">
                                                <span class="btn btn-sm btn-outline-success">
                                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="card-footer bg-light border-0 py-3">
                                    <a href="<?= base_url() ?>publicdata/tenders" class="btn btn-success w-100">
                                        <i class="bi bi-folder2-open me-1"></i> View All Tender Notices
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-file-earmark-x display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Active Tenders</h5>
                                    <p class="text-muted mb-4">There are currently no open tenders available</p>
                                    <a href="<?= base_url() ?>publicdata/tenders" class="btn btn-outline-success">
                                        Check Past Tenders
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Career Opportunities Pane -->
                <div class="tab-pane fade" id="career-pane" role="tabpanel" aria-labelledby="career-tab" tabindex="0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <i class="bi bi-briefcase me-2"></i>
                            <h5 class="mb-0">Current Career Opportunities</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($vacancies)) : ?>
                                <div class="list-group list-group-flush">
                                    <?php foreach ($vacancies as $vacancy) : ?>
                                        <a href="<?= site_url('publicdata/careers/vacancy/' . $vacancy['id']) ?>"
                                            class="list-group-item list-group-item-action py-3 px-4 vacancy-item">
                                            <div class="d-flex w-100 justify-content-between align-items-start">
                                                <div class="me-3 flex-grow-1">
                                                    <h6 class="mb-1 fw-bold text-primary"><?= esc($vacancy['title']) ?></h6>
                                                    <div class="d-flex flex-wrap text-muted small mb-1">
                                                        <span class="me-3 vacancy-dept">
                                                            <i class="bi bi-building me-1"></i> <?= esc($vacancy['department']) ?>
                                                        </span>
                                                        <span class="me-3">
                                                            <i class="bi bi-clock me-1"></i> <?= esc($vacancy['position_type']) ?>
                                                        </span>
                                                        <span>
                                                            <i class="bi bi-calendar me-1"></i> Closes: <?= date('d M Y', strtotime($vacancy['close_at'])) ?>
                                                        </span>
                                                    </div>
                                                    <p class="mb-0 small"><?= character_limiter(strip_tags($vacancy['description']), 120) ?>...</p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-success vacancy-badge">
                                                        <i class="bi bi-briefcase me-1"></i> <?= esc($vacancy['status']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end mt-2">
                                                <span class="btn btn-sm btn-outline-success">
                                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                                </span>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                <div class="card-footer bg-light border-0 py-3">
                                    <a href="<?= site_url('publicdata/careers') ?>" class="btn btn-success w-100">
                                        <i class="bi bi-folder2-open me-1"></i> View All Career Opportunities
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-briefcase display-4 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Current Openings</h5>
                                    <p class="text-muted mb-4">There are currently no job openings available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->section('styles') ?>
<style>
    .nav-tabs .nav-link {
        font-weight: 600;
        padding: 0.8rem 1.5rem;
        border: none;
        border-bottom: 3px solid transparent;
        color: #495057;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link.active,
    .nav-tabs .nav-link:hover {
        color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
        border-bottom: 3px solid #0d6efd;
    }

    .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
    }

    .list-group-item {
        transition: background-color 0.2s;
        border-left: 3px solid transparent;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        border-left: 3px solid #198754;
    }

    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    
    .vacancy-badge {
        font-size: 0.85rem;
    }
    
    .vacancy-item {
        border-left: 4px solid #198754;
    }
    
    .vacancy-dept {
        font-weight: 500;
        color: #6c757d;
    }
</style>
<?= $this->endSection() ?>