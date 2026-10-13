<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?>Tender Documents<?= $this->endSection() ?>

<?= $this->section('head_meta') ?>
<?php
$baseUrl = site_url('publicdata/tenders');
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 3;
$totalItems = count($tenders);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = max(1, min($currentPage, $totalPages));

$canonicalUrl = $currentPage > 1 ? $baseUrl . '?page=' . $currentPage : $baseUrl;
?>
<link rel="canonical" href="<?= $canonicalUrl ?>" />

<?php if ($totalPages > 1) : ?>
    <?php if ($currentPage > 1) : ?>
        <link rel="prev" href="<?= $baseUrl ?>?page=<?= $currentPage - 1 ?>" />
    <?php endif; ?>

    <?php if ($currentPage < $totalPages) : ?>
        <link rel="next" href="<?= $baseUrl ?>?page=<?= $currentPage + 1 ?>" />
    <?php endif; ?>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 3; 
$totalItems = count($tenders);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = max(1, min($currentPage, $totalPages));
$offset = ($currentPage - 1) * $itemsPerPage;
$paginatedTenders = array_slice($tenders, $offset, $itemsPerPage);
?>
<main class="py-4">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-primary mb-3">Tender Documents</h1>
            <p class="lead text-muted">Browse and download all available tender documents</p>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($tenders)) : ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder-x display-1 text-muted mb-4"></i>
                    <h3 class="mb-3">No Tenders Available</h3>
                    <p class="text-muted mb-0">There are currently no tender documents to display.</p>
                </div>
            </div>
        <?php else : ?>
            <div class="row g-4">
                <?php foreach ($paginatedTenders as $tender) : ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden position-relative">

                            <div class="card-header bg-primary bg-opacity-10 border-0 py-4">
                                <h5 class="card-title mb-0 fw-bold text-primary"><?= esc($tender['title']) ?></h5>
                            </div>

                            <div class="card-body position-relative pb-1">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-calendar me-2 text-muted"></i>
                                    <small class="text-muted"><?= date('M d, Y', strtotime($tender['created_at'])) ?></small>
                                </div>

                                <div class="tender-info mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-person-circle me-2 text-primary"></i>
                                        <span><?= esc($tender['contact_name']) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-envelope me-2 text-primary"></i>
                                        <span><?= esc($tender['contact_email']) ?></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone me-2 text-primary"></i>
                                        <span><?= esc($tender['contact_phone']) ?></span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 fw-bold text-uppercase text-muted" style="font-size: 0.8rem;">Attachments</h6>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2">
                                            <?= count($tender['files'] ?? []) ?>
                                        </span>
                                    </div>

                                    <div class="border rounded-2 p-3 bg-light">
                                        <?php if (!empty($tender['files'])) : ?>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach ($tender['files'] as $index => $file) : ?>
                                                    <a href="<?= site_url('publicdata/download/file/' . $tender['id'] . '/' . $index) ?>"
                                                        download="<?= esc($file['name']) ?>"
                                                        class="btn btn-sm btn-outline-primary d-flex align-items-center text-start">
                                                        <i class="bi bi-file-earmark me-2"></i>
                                                        <span class="text-truncate flex-grow-1">
                                                            <?= esc($file['name']) ?>
                                                        </span>
                                                        <i class="bi bi-download ms-2"></i>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="text-center py-2">
                                                <small class="text-muted fst-italic">No files attached</small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-white border-0 pt-0 pb-4">
                                <a href="<?= site_url('publicdata/show/' . $tender['id']) ?>"
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-eye me-2"></i> View Full Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1) : ?>
                <nav class="mt-5" aria-label="Tender documents pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $currentPage - 1 ?>"
                                aria-label="Previous"
                                <?= $currentPage <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link"
                                href="?page=<?= $currentPage + 1 ?>"
                                aria-label="Next"
                                <?= $currentPage >= $totalPages ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
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

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: rgba(13, 110, 253, 0.2);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .tender-info div {
        padding: 4px 0;
    }

    .btn-outline-primary {
        transition: all 0.2s;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white !important;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
        max-width: 150px;
    }

    /* Pagination Styles */
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .page-link {
        color: #0d6efd;
        min-width: 40px;
        text-align: center;
    }

    .pagination {
        margin-top: 2rem;
    }
</style>
<?php $this->endSection(); ?>