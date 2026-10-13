<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?><?= $title ?? 'Public Documents Management' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Added integrity and crossorigin attributes for Subresource Integrity (SRI) security -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
    crossorigin="anonymous">

<div class="container py-4">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-upload me-2"></i>Publish Public Document</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('public-docs/upload') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="doc_title" class="form-label fw-bold">Document Title</label>
                            <input type="text" id="doc_title" name="title" class="form-control" placeholder="e.g., Grid Code 2026" required>
                        </div>

                        <div class="mb-3">
                            <label for="doc_category" class="form-label fw-bold">Category</label>
                            <select id="doc_category" name="category" class="form-select" required>
                                <option value="General">General</option>
                                <option value="Grid Code">Grid Code</option>
                                <option value="Annual Report">Annual Report</option>
                                <option value="Notification">Notification</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="doc_description" class="form-label fw-bold">Short Description</label>
                            <textarea id="doc_description" name="description" class="form-control" rows="2" placeholder="Brief details about the file..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="public_file" class="form-label fw-bold">Select PDF (Max 50MB)</label>
                            <input type="file" id="public_file" name="public_file" class="form-control" accept="application/pdf" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Publish to Public Site
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="fas fa-list me-2"></i>Published Public Documents</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Title & Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date Published</th>
                                <th scope="col" class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($public_documents)): ?>
                                <?php foreach ($public_documents as $doc): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?= esc($doc['title']) ?></div>
                                            <span class="badge bg-secondary opacity-75" style="font-size: 0.7rem;">
                                                <?= esc($doc['category']) ?>
                                            </span>
                                        </td>
                                        <td><small class="text-muted"><?= esc($doc['description']) ?></small></td>
                                        <td><?= date('d M Y', strtotime($doc['created_at'])) ?></td>
                                        <td class="text-end">
                                            <a href="<?= base_url('public-docs/download/' . $doc['id']) ?>"
                                                class="btn btn-sm btn-outline-success"
                                                aria-label="Download <?= esc($doc['title']) ?>">
                                                <i class="fas fa-download" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No public documents found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>