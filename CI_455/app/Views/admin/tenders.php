<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?>Manage Tender Documents<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 5;
$totalItems = count($tenders);
$totalPages = ceil($totalItems / $itemsPerPage);
$currentPage = max(1, min($currentPage, $totalPages));
$offset = ($currentPage - 1) * $itemsPerPage;
$paginatedTenders = array_slice($tenders, $offset, $itemsPerPage);
?>
<main>
    <div class="container">
        <div class="row">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Manage Tender Documents</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Tenders</li>
                </ol>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-table me-1"></i> All Tenders</span>
                            <a href="<?= base_url('admin/tenders/create') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Reference</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($paginatedTenders as $tender): ?>
                                    <tr>
                                        <td><?= $tender['id'] ?></td>
                                        <td><?= esc($tender['title']) ?></td>
                                        <td><?= esc($tender['reference']) ?></td>
                                        <td><?= date('d M Y', strtotime($tender['created_at'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/tenders/edit/' . $tender['id']) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('admin/tenders/delete/' . $tender['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $currentPage - 1 ?>"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $currentPage + 1 ?>"
                                            aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                            <div class="text-center text-muted mt-2">
                                Page <?= $currentPage ?> of <?= $totalPages ?> |
                                Showing <?= count($paginatedTenders) ?> of <?= $totalItems ?> items
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>