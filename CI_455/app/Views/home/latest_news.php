<div class="latest-news-section mb-5">
    <div class="section-header d-flex justify-content-between align-items-center mb-4 sticky-top bg-white py-3 px-3 border-bottom">
        <h2 class="h5 font-weight-semibold text-uppercase letter-spacing-1 text-primary">Latest News & Announcements</h2>
        <a href="<?= base_url('publicdata/news') ?>" class="btn btn-outline-primary fw-medium">
            View All <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>

    <div class="news-container">
        <?php if (empty($latestNews)) : ?>
            <div class="col-12">
                <div class="alert alert-light border mb-0 text-center py-4">
                    <i class="far fa-newspaper fa-2x text-muted mb-3"></i>
                    <p class="mb-0 text-muted">No news available at the moment</p>
                </div>
            </div>
        <?php else : ?>
            <div class="row g-4">
                <?php foreach ($latestNews as $news) : ?>
                    <?php 
                    // Safely get all values with fallbacks
                    $newsId = $news['id'] ?? '';
                    $title = esc($news['title'] ?? 'Untitled News');
                    $content = strip_tags($news['content'] ?? '');
                    $date = $news['created_at'] ?? $news['date'] ?? null;
                    $truncatedContent = strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                    ?>
                    
                    <div class="col-md-6 col-lg-12">
                        <div class="card news-card h-100 border-0 shadow-xs-hover shadow-sm">
                            <div class="card-body p-4">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-3">
                                        <?php if ($date) : ?>
                                            <span class="badge bg-light text-primary mb-2">
                                                <?= date('M d, Y', strtotime($date)) ?>
                                            </span>
                                        <?php endif; ?>
                                        <h3 class="h5 card-title mb-2 line-clamp-2"><?= $title ?></h3>
                                        <p class="card-text text-muted line-clamp-2 mb-3">
                                            <?= $truncatedContent ?>
                                        </p>
                                    </div>
                                    <div class="mt-auto">
                                        <a href="<?= base_url('publicdata/news/' . $newsId) ?>" class="btn btn-link text-primary px-0">
                                            Read More <i class="fas fa-chevron-right ms-2 small"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .latest-news-section {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        background: white;
        padding: 1rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.025);
    }
    
    .news-container {
        max-height: 600px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    
    .letter-spacing-1 {
        letter-spacing: 0.5px;
    }
    
    .shadow-xs-hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04);
    }
    
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .news-card {
        transition: all 0.25s ease;
        border-radius: 0.375rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .news-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(0, 0, 0, 0.1);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .news-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .news-container::-webkit-scrollbar-track {
        background: #f8f9fa;
        border-radius: 10px;
    }
    
    .news-container::-webkit-scrollbar-thumb {
        background-color: #ced4da;
        border-radius: 10px;
    }
    
    .font-weight-semibold {
        font-weight: 600;
    }
    
    .text-primary {
        color: #3b7ddd !important;
    }
    
    .btn-primary {
        background-color: #3b7ddd;
        border-color: #3b7ddd;
    }
    
    .bg-light {
        background-color: #f8fafc !important;
    }
</style>