<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('title') ?><?= $title ?? 'Commercial Operation Date Documents' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">
    <div class="row">
        <div class="col-12">
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
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="mb-0"><i class="fas fa-upload me-2"></i>Upload COD Document</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('documents/upload') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Generation Plant</label>
                            <select name="station_id" class="form-select" required>
                                <option value="">Select Plant...</option>
                                <?php foreach ($stations as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= esc($s['station']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Unit Designation</label>
                            <input type="text" name="unit_name" class="form-control" placeholder="e.g. Unit-I & II" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PDF File (Max 50MB)</label>
                            <input type="file" name="plant_pdf" class="form-control" accept="application/pdf" required>
                        </div>
                        <div class="pt-2">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm" id="uploadBtn">
                                Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-list me-2"></i>Recent Declarations</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 150px;">Plant</th>
                                <th style="min-width: 100px;">Unit</th>
                                <th style="min-width: 120px;">Uploaded On</th>
                                <th class="text-end" style="min-width: 100px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($documents)): ?>
                                <?php foreach ($documents as $d): ?>
                                    <tr>
                                        <td class="fw-medium"><?= esc($d['station_name']) ?></td>
                                        <td><span class="badge bg-info text-dark px-3"><?= esc($d['unit_name']) ?></span></td>
                                        <td class="text-muted small"><?= date('d M Y', strtotime($d['created_at'])) ?></td>
                                        <td class="text-end">
                                            <a href="<?= base_url('documents/download/' . $d['id']) ?>" class="btn btn-sm btn-outline-primary px-3">
                                                <i class="fas fa-download me-1"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No documents uploaded yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
document.getElementById('uploadBtn').addEventListener('click', function() {
    this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Uploading...';
    this.classList.add('disabled');
});
</script>

<style>
    /* Prevent table from squishing content too much on tiny screens */
    .table-responsive {
        border-radius: 0 0 12px 12px;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    /* Smooth scaling for font sizes on mobile */
    @media (max-width: 576px) {
        .card-header h6 {
            font-size: 0.9rem;
        }

        .table {
            font-size: 0.85rem;
        }
    }
</style>
<?= $this->endSection() ?>