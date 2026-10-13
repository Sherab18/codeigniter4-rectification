<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Add Report | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <?= $this->include('reports/report_sidebar') ?>
            </div>
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Upload New Report</h5>
                    </div>

                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('reports/report_store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label">Report Type <span class="text-danger">*</span></label>
                                <select name="report_type" class="form-select" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="daily">Daily Report</option>
                                    <option value="quarterly">Quarterly Report</option>
                                    <option value="annual">Annual Report</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="upload_date" class="form-control"
                                    value="<?= date('Y-m-d\TH:i') ?>" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Report File <span class="text-danger">*</span></label>
                                <input type="file" name="uploaded_file" class="form-control" required>
                                <div class="form-text">
                                    Allowed formats: PDF, JPG, PNG, TXT (Max 5MB)
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('reports/report_list') ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Upload Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Client-side file validation
    document.querySelector('input[name="uploaded_file"]').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'text/plain'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                if (!allowedTypes.includes(file.type)) {
                        alert('Error: Only PDF, JPG, PNG, and TXT files are allowed.');
                        e.target.value = '';
                    }

                    if (file.size > maxSize) {
                        alert('Error: File size exceeds 5MB limit.');
                        e.target.value = '';
                    }
                });
</script>
<?= $this->endSection() ?>