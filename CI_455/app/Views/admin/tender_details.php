<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?>Tender: <?= esc($tender['title']) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="py-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?= site_url('publicdata/tenders') ?>" class="btn btn-outline-primary d-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Back to Tenders
            </a>
            <h1 class="h3 mb-0 text-end">Tender Details</h1>
        </div>

        <div class="card border-0 shadow rounded-3 overflow-hidden">
            <div class="card-header bg-primary text-white py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0"><?= esc($tender['title']) ?></h2>
                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 fs-6">
                        Ref: <?= esc($tender['reference']) ?>
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="border rounded-3 p-4 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-person-lines-fill fs-2 text-primary"></i>
                                </div>
                                <h3 class="h5 mb-0">Contact Information</h3>
                            </div>

                            <div class="ms-2">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person me-3 fs-5 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Contact Person</small>
                                        <span class="fw-medium"><?= esc($tender['contact_name']) ?></span>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-envelope me-3 fs-5 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Email</small>
                                        <a href="mailto:<?= esc($tender['contact_email']) ?>" class="fw-medium text-decoration-none">
                                            <?= esc($tender['contact_email']) ?>
                                        </a>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone me-3 fs-5 text-primary"></i>
                                    <div>
                                        <small class="text-muted d-block">Phone</small>
                                        <a href="tel:<?= esc($tender['contact_phone']) ?>" class="fw-medium text-decoration-none">
                                            <?= esc($tender['contact_phone']) ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="border rounded-3 p-4 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-clock-history fs-2 text-primary"></i>
                                </div>
                                <h3 class="h5 mb-0">Timeline</h3>
                            </div>

                            <div class="ms-2">
                                <div class="d-flex mb-4 position-relative">
                                    <div class="position-absolute top-0 start-0 h-100 ms-3 border-start border-2 border-dashed opacity-25"></div>

                                    <div class="z-1">
                                        <i class="bi bi-calendar-check fs-4 text-primary bg-white p-1"></i>
                                    </div>
                                    <div class="ms-4">
                                        <small class="text-muted d-block">Published</small>
                                        <span class="fw-medium"><?= date('M d, Y H:i', strtotime($tender['created_at'])) ?></span>
                                    </div>
                                </div>

                                <div class="d-flex">
                                    <div class="z-1">
                                        <i class="bi bi-arrow-repeat fs-4 text-primary bg-white p-1"></i>
                                    </div>
                                    <div class="ms-4">
                                        <small class="text-muted d-block">Last Updated</small>
                                        <span class="fw-medium"><?= date('M d, Y H:i', strtotime($tender['updated_at'])) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="border rounded-3 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-file-text fs-2 text-primary"></i>
                                </div>
                                <h3 class="h5 mb-0">Tender Description</h3>
                            </div>

                            <div class="bg-light rounded-3 p-4 mt-3">
                                <?= nl2br(esc($tender['content'])) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="border rounded-3 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-paperclip fs-2 text-primary"></i>
                                </div>
                                <h3 class="h5 mb-0">Attachments</h3>
                            </div>

                            <?php if (!empty($tender['files'])) : ?>
                                <div class="row g-3 mt-3">
                                    <?php foreach ($tender['files'] as $index => $file) : ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="border rounded-3 p-3 d-flex align-items-center h-100">
                                                <div class="bg-primary bg-opacity-10 rounded-2 p-2 me-3">
                                                    <i class="bi bi-file-earmark-text fs-2 text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h4 class="h6 mb-1 text-truncate" style="max-width: 200px;">
                                                        <?= esc($file['name']) ?>
                                                    </h4>
                                                    <small class="text-muted d-block"><?= pathinfo($file['name'], PATHINFO_EXTENSION) ?> file</small>
                                                    <a href="<?= site_url('publicdata/download/file/' . $tender['id'] . '/' . $index) ?>"
                                                        download="<?= esc($file['name']) ?>"
                                                        class="btn btn-sm btn-outline-primary mt-2 d-flex align-items-center">
                                                        <i class="bi bi-download me-2"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else : ?>
                                <div class="text-center py-5 border rounded-3 mt-3 bg-light">
                                    <i class="bi bi-file-earmark-x fs-1 text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No files attached to this tender</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
    .card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    .card-header {
        border-radius: 0 !important;
    }

    .bg-primary-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .border-dashed {
        border-style: dashed !important;
    }

    .z-1 {
        z-index: 1;
        position: relative;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
<?php $this->endSection(); ?>