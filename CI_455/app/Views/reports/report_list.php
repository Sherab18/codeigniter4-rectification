<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Report Management | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Column -->
            <div class="col-lg-3">
                <?= $this->include('reports/report_sidebar') ?>
            </div>

            <!-- Main Content Column -->
            <div class="col-lg-9">
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-semibold">Report Management</h5>
                        <a href="<?= base_url('reports/report_create') ?>" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> New Report
                        </a>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Flash Message -->
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?= session()->getFlashdata('message') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Reports Table -->
                        <?php if (!empty($reports)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="reportTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="w-25">Report Type</th>
                                            <th scope="col" class="w-30">File Name</th>
                                            <th scope="col" class="w-20">Upload Date</th>
                                            <th scope="col" class="w-25 text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reports as $report): ?>
                                            <tr>
                                                <td><?= esc(ucfirst($report['report_type'])) ?></td>
                                                <td><?= esc($report['file_name']) ?></td>
                                                <td><?= esc($report['upload_date']) ?></td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="<?= base_url('reports/report_download/' . $report['id']) ?>"
                                                            class="btn btn-outline-primary"
                                                            data-bs-toggle="tooltip" title="Download">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                        <a href="<?= base_url('reports/report_preview/' . $report['id']) ?>"
                                                            target="_blank"
                                                            class="btn btn-outline-success"
                                                            data-bs-toggle="tooltip" title="Preview">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('reports/report_delete/' . $report['id']) ?>"
                                                            class="btn btn-outline-danger"
                                                            data-bs-toggle="tooltip" title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this report?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>No reports found in the system.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#reportTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            info: false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search reports...",
            },
            columnDefs: [{
                    orderable: false,
                    targets: 3
                } // Disable sorting for actions column
            ]
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?= $this->endSection() ?>