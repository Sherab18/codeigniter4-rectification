
<?= $this->section('content') ?>
<div class="container mt-4">
    <article>
        <h1><?= esc($news['title'] ?? 'News Article') ?></h1>
        <div class="text-muted mb-4">
            Posted: <?= esc(date('F j, Y \a\t g:i a', strtotime($news['created_at'] ?? time()))) ?>
            <?php if (isset($news['updated_at']) && $news['updated_at'] != $news['created_at']): ?>
                <br><em>Updated: <?= esc(date('F j, Y \a\t g:i a', strtotime($news['updated_at']))) ?></em>
            <?php endif ?>
        </div>
        
        <div class="news-content mb-5">
            <?= nl2br(esc($news['content'] ?? 'Content not available')) ?>
        </div>
        
        <a href="<?= base_url('news') ?>" class="btn btn-outline-secondary">
            &laquo; Back to News
        </a>
    </article>
</div>
<?= $this->endSection() ?>