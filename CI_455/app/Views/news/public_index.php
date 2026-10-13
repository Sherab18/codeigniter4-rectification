<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
News & Announcements | BPSO
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 font-weight-bold text-primary"><?= $title ?></h1>
        <div class="text-muted small">
            <i class="far fa-calendar-alt mr-1"></i> <?= date('F j, Y') ?>
        </div>
    </div>

    <?php if (empty($news)) : ?>
        <div class="alert alert-info rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle mr-3"></i>
                <span>No news available at the moment. Please check back later.</span>
            </div>
        </div>
    <?php else : ?>
        <div class="row" id="news-container">
            <?php foreach ($news as $item) : ?>
                <div class="col-lg-6 mb-4 news-item">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h2 class="card-title h5 font-weight-bold mb-0"><?= esc($item['title']) ?></h2>
                                <span class="badge badge-light text-muted small">
                                    <?= date('M j, Y', strtotime($item['created_at'])) ?>
                                </span>
                            </div>
                            <hr class="my-2">
                            <p class="card-text text-muted mb-3"><?= $item['excerpt'] ?>...</p>
                            <a href="<?= base_url('publicdata/news/' . $item['id']) ?>" class="btn btn-outline-primary btn-sm">
                                Read More <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="pagination-container">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </div>
        <div class="pagination-info">
            Showing 1 to 6 of 12 items
        </div>
    <?php endif ?>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .transition {
        transition: all 0.3s ease;
    }

    /* Pagination Styles */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .page-item {
        border-right: 1px solid #e9ecef;
    }

    .page-item:last-child {
        border-right: none;
    }

    .page-link {
        display: block;
        padding: 10px 18px;
        background-color: white;
        color: #0d6efd;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        font-weight: 500;
    }

    .page-link:hover {
        background-color: #f1f5ff;
    }

    .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
    }

    .pagination-info {
        text-align: center;
        margin-top: 15px;
        color: #6c757d;
        font-size: 0.9rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 4;
        const newsItems = document.querySelectorAll('.news-item');
        const totalItems = newsItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

            newsItems.forEach(item => item.style.display = 'none');

            for (let i = startIndex; i < endIndex; i++) {
                if (newsItems[i]) newsItems[i].style.display = 'block';
            }

            document.querySelector('.pagination-info').textContent =
                `Showing ${startIndex + 1} to ${endIndex} of ${totalItems} items`;
        }

        showPage(currentPage);

        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageText = this.textContent.trim();

                if (pageText === 'Previous' && currentPage > 1) {
                    currentPage--;
                } else if (pageText === 'Next' && currentPage < totalPages) {
                    currentPage++;
                } else if (!isNaN(pageText)) {
                    currentPage = parseInt(pageText);
                }

                showPage(currentPage);

                document.querySelectorAll('.page-item').forEach(item => {
                    item.classList.remove('active');
                });

                document.querySelectorAll('.page-link').forEach(item => {
                    if (item.textContent.trim() === currentPage.toString()) {
                        item.parentElement.classList.add('active');
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>