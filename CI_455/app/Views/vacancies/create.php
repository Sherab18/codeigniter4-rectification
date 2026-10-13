<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-primary"><i class="bi bi-briefcase me-2"></i>Create New Vacancy</h2>
                <a href="<?= site_url('career/vacancies') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Validation Errors</h5>
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="<?= site_url('career/vacancies/store') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label fw-semibold">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title"
                                    value="<?= old('title') ?>" required placeholder="e.g., Senior Web Developer">
                                <div class="invalid-feedback">Please provide a job title.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="department" name="department"
                                    value="<?= old('department') ?>" required placeholder="e.g., Engineering, Marketing">
                                <div class="invalid-feedback">Please specify the department.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="position_type" class="form-label fw-semibold">Position Type <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg" id="position_type" name="position_type" required>
                                    <option value="">Select Position Type</option>
                                    <?php $pTypes = ['Full-time', 'Part-time', 'Contract', 'Temporary', 'Internship']; ?>
                                    <?php foreach ($pTypes as $type): ?>
                                        <option value="<?= $type ?>" <?= old('position_type') == $type ? 'selected' : '' ?>><?= $type ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Please select a position type.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="close_at" class="form-label fw-semibold">Closing Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control form-control-lg" id="close_at" name="close_at"
                                    value="<?= old('close_at') ?>" required min="<?= date('Y-m-d\TH:i') ?>">
                                <div class="invalid-feedback">Please select a valid closing date.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Job Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="6" required
                                placeholder="Describe the role..."><?= old('description') ?></textarea>
                            <div class="invalid-feedback">Please provide a job description.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Job Description PDF (Optional)</label>
                            <div class="file-upload-area border rounded p-4 text-center" id="drop-zone">
                                <input type="file" class="form-control d-none" id="attachment" name="attachment" accept="application/pdf">
                                <div class="mb-2">
                                    <i class="bi bi-cloud-upload display-4 text-muted"></i>
                                </div>
                                <p class="mb-2">Drag & drop your file here or</p>
                                <label for="attachment" class="btn btn-outline-primary">Browse Files</label>
                                <div class="form-text mt-2">Max file size: 5MB (PDF only)</div>
                                <div id="file-name" class="mt-2 fw-semibold text-success"></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end pt-3">
                            <a href="<?= site_url('career/vacancies') ?>" class="btn btn-lg btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="bi bi-plus-circle me-2"></i> Create Vacancy
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .file-upload-area {
        transition: all 0.3s ease;
        border: 2px dashed #dee2e6;
        cursor: pointer;
    }

    .file-upload-area:hover,
    .file-upload-area.drag-over {
        border-color: #0d6efd;
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 12px;
    }

    .form-control,
    .form-select,
    .btn {
        border-radius: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('attachment');
        const fileNameDisp = document.getElementById('file-name');
        const dropZone = document.getElementById('drop-zone');

        // Handle Browse button
        fileInput.addEventListener('change', function() {
            if (this.files.length) fileNameDisp.textContent = this.files[0].name;
        });

        // Drag and Drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                dropZone.classList.remove('drag-over');
            });
        });

        dropZone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                fileNameDisp.textContent = files[0].name;
            }
        });

        // Bootstrap Validation
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
</script>
<?= $this->endSection() ?>