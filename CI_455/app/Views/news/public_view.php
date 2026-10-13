<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
<?= esc($news['title']) ?> | News & Announcements | BPSO
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="news-detail-container">
        <div class="mb-4">
            <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Back to Home
            </a>
        </div>

        <article class="news-article">
            <h1 class="news-title mb-3"><?= esc($news['title']) ?></h1>

            <div class="d-flex align-items-center text-muted mb-4">
                <i class="far fa-calendar-alt me-2"></i>
                <span>Published: <?= date('F j, Y \a\t g:i a', strtotime($news['created_at'])) ?></span>
                <?php if ($news['created_at'] != $news['updated_at']) : ?>
                    <span class="mx-2">•</span>
                    <i class="fas fa-sync-alt me-2"></i>
                    <span>Updated: <?= date('F j, Y \a\t g:i a', strtotime($news['updated_at'])) ?></span>
                <?php endif ?>
            </div>

            <div class="news-content mb-5">
                <?= $news['content'] ?>
            </div>
        </article>

        <?php if (!empty($news['attachments'])) : ?>
            <section class="attachments-section mt-5 pt-4 border-top">
                <h2 class="h5 mb-3 d-flex align-items-center">
                    <i class="fas fa-paperclip me-2"></i> Attachments
                </h2>

                <div class="row g-3">
                    <?php foreach ($news['attachments'] as $attachment) : ?>
                        <?php
                        $fileExt = strtolower(pathinfo($attachment['original_name'], PATHINFO_EXTENSION));
                        $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif']);
                        ?>

                        <?php if ($isImage) : ?>
                            <div class="col-md-12">
                                <div class="card border-0 shadow-sm h-100">
                                    <img src="<?= base_url('publicdata/news/attachment/' . $attachment['saved_name']) ?>"
                                        class="card-img-top"
                                        alt="<?= esc($attachment['original_name']) ?>"
                                        style="max-height: 300px; object-fit: contain; background: #f8f9fa;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mt-3">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col-md-6">
                                <div class="attachment-card card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <?php
                                        $icon = 'fa-file';
                                        $color = 'text-primary';

                                        if ($fileExt === 'pdf') {
                                            $icon = 'fa-file-pdf';
                                            $color = 'text-danger';
                                        } elseif (in_array($fileExt, ['doc', 'docx'])) {
                                            $icon = 'fa-file-word';
                                            $color = 'text-info';
                                        } elseif (in_array($fileExt, ['xls', 'xlsx'])) {
                                            $icon = 'fa-file-excel';
                                            $color = 'text-success';
                                        }
                                        ?>

                                        <div class="attachment-icon me-3 <?= $color ?>">
                                            <i class="fas <?= $icon ?> fa-3x"></i>
                                        </div>

                                        <div class="flex-grow-1">
                                            <h3 class="h6 mb-1 text-truncate"><?= esc($attachment['original_name']) ?></h3>
                                            <small class="text-muted"><?= strtoupper($fileExt) ?></small>
                                        </div>

                                        <a href="<?= base_url('publicdata/news/attachment/' . $attachment['saved_name']) ?>"
                                            class="btn btn-sm btn-outline-primary ms-3"
                                            target="_blank"
                                            download="<?= esc($attachment['original_name']) ?>">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </section>
        <?php endif ?>
    </div>
</div>

<style>
    .news-detail-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .news-title {
        font-weight: 700;
        color: #2c3e50;
        line-height: 1.3;
    }

    .news-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #495057;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .news-content p {
        margin-bottom: 1.5rem;
    }

    .attachment-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .attachment-card:hover,
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }

    .attachment-icon {
        min-width: 48px;
        text-align: center;
    }

    .card-img-top {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
<?= $this->endSection() ?>