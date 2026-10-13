<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php helper('text'); ?>
<main class="py-4">
    <div class="container">
        <style>
            :root {
                --primary-color: #0d6efd;
                --danger-color: #dc3545;
                --success-color: #198754;
                --warning-color: #ffc107;
                --light-bg: #f8f9fa;
            }

            .dashboard-container {
                max-width: 1200px;
                margin: 30px auto;
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            }

            .dashboard-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid #e9ecef;
            }

            .stats-container {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }

            .stat-card {
                background: white;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: all 0.3s;
                border-left: 4px solid var(--primary-color);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            }

            .stat-card.total-news {
                border-left-color: var(--primary-color);
            }

            .stat-card.with-attachments {
                border-left-color: var(--warning-color);
            }

            .stat-card.no-attachments {
                border-left-color: var(--success-color);
            }

            .stat-card .stat-value {
                font-size: 2.5rem;
                font-weight: 700;
                line-height: 1;
            }

            .stat-card .stat-label {
                color: #6c757d;
                font-size: 0.9rem;
                margin-top: 5px;
            }

            .news-card {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: all 0.3s;
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .news-card .card-img-top {
                height: 160px;
                object-fit: cover;
            }

            .news-card .card-body {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .news-card .card-footer {
                background: white;
                border-top: 1px solid rgba(0, 0, 0, 0.05);
                padding: 15px;
            }

            .attachment-badge {
                display: inline-flex;
                align-items: center;
                padding: 4px 8px;
                border-radius: 4px;
                background: var(--light-bg);
                font-size: 0.8rem;
                margin: 0 5px 5px 0;
            }

            .date-badge {
                background: rgba(13, 110, 253, 0.1);
                color: var(--primary-color);
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.8rem;
            }

            .view-toggle {
                background: var(--light-bg);
                padding: 5px;
                border-radius: 6px;
                display: inline-flex;
            }

            .view-toggle .btn.active {
                background: var(--primary-color);
                color: white;
            }

            .news-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 25px;
            }

            .news-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            .news-table th {
                background-color: #f8f9fa;
                padding: 15px;
                border-bottom: 2px solid #e9ecef;
            }

            .news-table td {
                padding: 15px;
                border-bottom: 1px solid #e9ecef;
            }

            .attachment-thumb {
                width: 40px;
                height: 40px;
                border-radius: 4px;
                object-fit: cover;
                border: 1px solid #e9ecef;
            }

            .pagination-container {
                display: flex;
                justify-content: center;
                margin-top: 40px;
            }

            .pagination-info {
                text-align: center;
                margin-top: 15px;
                color: #6c757d;
                font-size: 0.9rem;
            }

            @media (max-width: 768px) {
                .dashboard-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .header-actions {
                    margin-top: 20px;
                    width: 100%;
                }
            }
        </style>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="dashboard-container">
            <div class="dashboard-header">
                <div>
                    <h1><?= esc($title) ?></h1>
                    <p class="text-muted">Manage all news & announcements</p>
                </div>
                
                <div class="header-actions">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="view-toggle">
                            <button id="grid-view" class="btn btn-sm">
                                <i class="bi bi-grid"></i> Grid
                            </button>
                            <button id="list-view" class="btn btn-sm">
                                <i class="bi bi-list"></i> List
                            </button>
                        </div>
                        <a href="<?= base_url('bpso/news/new') ?>" class="btn btn-primary ms-3">
                            <i class="bi bi-plus-circle me-1"></i> Create News
                        </a>
                    </div>
                </div>
            </div>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= esc(session('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php
            $withAttachments = count(array_filter($news, fn($item) => !empty($item['attachments'])));
            $noAttachments = count($news) - $withAttachments;
            ?>

            <div class="stats-container">
                <div class="stat-card total-news">
                    <div class="stat-value"><?= count($news) ?></div>
                    <div class="stat-label">Total News</div>
                </div>
                <div class="stat-card with-attachments">
                    <div class="stat-value"><?= $withAttachments ?></div>
                    <div class="stat-label">With Attachments</div>
                </div>
                <div class="stat-card no-attachments">
                    <div class="stat-value"><?= $noAttachments ?></div>
                    <div class="stat-label">Without Attachments</div>
                </div>
            </div>

            <?php if (empty($news)): ?>
                <div class="empty-state text-center py-5">
                    <i class="bi bi-newspaper" style="font-size: 4rem; color: #dee2e6;"></i>
                    <h3 class="mt-3">No News Found</h3>
                    <a href="<?= base_url('bpso/news/new') ?>" class="btn btn-primary mt-2">Create First News</a>
                </div>
            <?php else: ?>
                <div id="grid-view-container">
                    <div class="news-grid" id="news-grid-items">
                        <?php foreach ($news as $item): ?>
                            <div class="news-item-wrapper">
                                <div class="news-card">
                                    <?php
                                    $firstImage = null;
                                    foreach ($item['attachments'] as $at) {
                                        if ($at['file_type'] === 'image') {
                                            $firstImage = $at;
                                            break;
                                        }
                                    }
                                    ?>
                                    <?php if ($firstImage): ?>
                                        <img src="<?= base_url('bpso/attachments/' . $firstImage['saved_name']) ?>" class="card-img-top">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-newspaper" style="font-size: 3rem; color: #adb5bd;"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-body">
                                        <h5 class="card-title"><?= esc($item['title']) ?></h5>
                                        <span class="date-badge mb-2 d-inline-block">
                                            <?= date('M d, Y', strtotime($item['created_at'])) ?>
                                        </span>
                                        <p class="card-text text-muted">
                                            <?= character_limiter(strip_tags($item['content']), 100) ?>
                                        </p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <a href="<?= base_url('bpso/news/edit/' . esc($item['id'])) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="pagination-container" id="grid-pagination"></div>
                    <div class="pagination-info" id="grid-pagination-info"></div>
                </div>

                <div id="list-view-container" class="d-none">
                    <div class="table-responsive">
                        <table class="news-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Created</th>
                                    <th>Attachments</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="news-list-items">
                                <?php foreach ($news as $item): ?>
                                    <tr>
                                        <td><strong><?= esc($item['title']) ?></strong></td>
                                        <td><?= date('M d, Y', strtotime($item['created_at'])) ?></td>
                                        <td><?= count($item['attachments']) ?> files</td>
                                        <td>
                                            <a href="<?= base_url('bpso/news/edit/' . esc($item['id'])) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $item['id'] ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-container" id="list-pagination"></div>
                    <div class="pagination-info" id="list-pagination-info"></div>
                </div>
            <?php endif; ?>

            <?php foreach ($news as $item): ?>
                <div class="modal fade" id="deleteModal<?= $item['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Confirmation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete <strong>"<?= esc($item['title']) ?>"</strong>?
                            </div>
                            <div class="modal-footer">
                                <form action="<?= base_url('bpso/news/delete/' . $item['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridBtn = document.getElementById('grid-view');
        const listBtn = document.getElementById('list-view');
        const gridContainer = document.getElementById('grid-view-container');
        const listContainer = document.getElementById('list-view-container');

        const itemsPerPage = 6; // Set items per page
        let currentPage = 1;
        let currentView = localStorage.getItem('newsView') || 'grid';

        const gridItems = document.querySelectorAll('.news-item-wrapper');
        const listItems = document.querySelectorAll('#news-list-items tr');
        const totalItems = gridItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        function updateView(view) {
            currentView = view;
            localStorage.setItem('newsView', view);

            if (view === 'grid') {
                gridContainer.classList.remove('d-none');
                listContainer.classList.add('d-none');
                gridBtn.classList.add('active');
                listBtn.classList.remove('active');
            } else {
                gridContainer.classList.add('d-none');
                listContainer.classList.remove('d-none');
                gridBtn.classList.remove('active');
                listBtn.classList.add('active');
            }
            renderPage();
        }

        function renderPage() {
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            gridItems.forEach((el, i) => el.style.display = (i >= start && i < end) ? 'block' : 'none');
            listItems.forEach((el, i) => el.style.display = (i >= start && i < end) ? '' : 'none');

            const info = `Showing ${Math.min(start + 1, totalItems)} to ${Math.min(end, totalItems)} of ${totalItems}`;
            document.getElementById('grid-pagination-info').textContent = info;
            document.getElementById('list-pagination-info').textContent = info;

            renderPaginationControls();
        }

        function renderPaginationControls() {
            if (totalItems <= itemsPerPage) return;

            let html = `<ul class="pagination">
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage-1}">Prev</a></li>`;

            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item ${i === currentPage ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }

            html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage+1}">Next</a></li></ul>`;

            document.getElementById('grid-pagination').innerHTML = html;
            document.getElementById('list-pagination').innerHTML = html;
        }

        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('page-link')) {
                e.preventDefault();
                const p = parseInt(e.target.dataset.page);
                if (p > 0 && p <= totalPages) {
                    currentPage = p;
                    renderPage();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        });

        gridBtn.addEventListener('click', () => updateView('grid'));
        listBtn.addEventListener('click', () => updateView('list'));

        updateView(currentView);
    });
</script>
<?= $this->endSection() ?>