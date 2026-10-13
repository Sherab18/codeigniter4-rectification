<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?><?= $title ?? 'Tender Form' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row">
            <div class="container-fluid px-4">
                <h1 class="mt-4"><?= $title ?></h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/tenders') ?>">Tenders</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>

                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session('errors') as $error): ?>
                            <p><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/tenders/save') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if (isset($tender['id'])): ?>
                        <input type="hidden" name="id" value="<?= $tender['id'] ?>">
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-info-circle me-1"></i>
                            Tender Information
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Title *</label>
                                <input type="text" class="form-control" name="title"
                                    value="<?= old('title', $tender['title'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Reference *</label>
                                <input type="text" class="form-control" name="reference"
                                    value="<?= old('reference', $tender['reference'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Content *</label>
                                <textarea class="form-control" name="content" rows="6" required><?=
                                                                                                old('content', $tender['content'] ?? '') ?></textarea>
                                <small class="text">HTML content is allowed</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-file me-1"></i>
                            Tender Documents
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Upload Files</label>
                                <input class="form-control" type="file" name="files[]" multiple>
                                <small class="form-text">Allowed: PDF, DOC, DOCX, XLS, XLSX, ZIP (Max 10MB each)</small>
                            </div>

                            <?php if (isset($tender['files']) && !empty($tender['files'])): ?>
                                <div class="mt-4">
                                    <h5>Current Files:</h5>
                                    <div class="list-group">
                                        <?php foreach ($tender['files'] as $file): ?>
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="bi <?= getFileIcon($file['path']) ?> me-2"></i>
                                                    <?= esc($file['name']) ?>
                                                </div>
                                                <a href="<?= base_url($file['path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="delete_files" id="deleteFiles">
                                        <label class="form-check-label text-danger" for="deleteFiles">
                                            Delete all existing files?
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-user me-1"></i>
                            Contact Information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name"
                                        value="<?= old('contact_name', $tender['contact_name'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" name="contact_phone"
                                        value="<?= old('contact_phone', $tender['contact_phone'] ?? '') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" name="contact_email"
                                        value="<?= old('contact_email', $tender['contact_email'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('admin/tenders') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Tender
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>