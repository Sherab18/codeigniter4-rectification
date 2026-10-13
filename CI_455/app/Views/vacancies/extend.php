<?= $this->extend('layouts/layouts_user') ?>
<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Extend Closing Time for: <?= esc($vacancy['title']) ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('career/vacancies/extend/' . $vacancy['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="close_at" class="form-label">New Closing Date & Time</label>
            <input type="datetime-local" class="form-control" id="close_at" name="close_at" required
                value="<?= date('Y-m-d\TH:i', strtotime($vacancy['close_at'])) ?>"
                min="<?= date('Y-m-d\TH:i') ?>">
        </div>

        <button type="submit" class="btn btn-primary">Extend Closing Time</button>
        <a href="<?= site_url('career/vacancies') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>