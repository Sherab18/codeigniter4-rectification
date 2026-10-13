<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Public Reports | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* Professional styling enhancements */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header-report {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border-bottom: none;
        padding: 1.2rem 1.5rem;
    }
    
    .table th {
        font-weight: 600;
        color: #2c3e50;
        border-top: none;
        padding: 1rem 0.75rem;
        background-color: #f8f9fa;
    }
    
    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: #edf2f7;
    }
    
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
        border-radius: 6px;
    }
    
    .btn {
        border-radius: 6px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background: linear-gradient(to right, #3498db, #2980b9);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
    }
    
    .btn-outline-primary, .btn-outline-success {
        border-width: 1.5px;
        font-weight: 500;
    }
    
    .btn-outline-primary:hover, .btn-outline-success:hover {
        transform: translateY(-2px);
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
    }
    
    .form-select, .form-control {
        border-radius: 6px;
        padding: 0.75rem 1rem;
        border: 1.5px solid #e2e8f0;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.15);
    }
    
    /* Animation for table rows */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    tbody tr {
        animation: fadeIn 0.5s ease forwards;
    }
    
    tbody tr:nth-child(1) { animation-delay: 0.05s; }
    tbody tr:nth-child(2) { animation-delay: 0.1s; }
    tbody tr:nth-child(3) { animation-delay: 0.15s; }
    tbody tr:nth-child(4) { animation-delay: 0.2s; }
    tbody tr:nth-child(5) { animation-delay: 0.25s; }
    
    /* Action buttons with clear separation */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
    
    .action-buttons .btn {
        min-width: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

<main class="py-4">
    <div class="container">
        <div class="row g-4">
            <!-- Main Content Column -->
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header-report text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            Public Reports
                        </h5>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Filter Form -->
                        <form method="GET" class="row g-3 mb-4">
                            <input type="hidden" name="page" value="1"> <!-- Reset to page 1 when filtering -->
                            <div class="col-md-5">
                                <select name="report_type" class="form-select">
                                    <option value="">All Report Types</option>
                                    <option value="daily" <?= ($reportType ?? '') === 'daily' ? 'selected' : '' ?>>Daily</option>
                                    <option value="quarterly" <?= ($reportType ?? '') === 'quarterly' ? 'selected' : '' ?>>Quarterly</option>
                                    <option value="annual" <?= ($reportType ?? '') === 'annual' ? 'selected' : '' ?>>Annual</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="upload_date" class="form-control"
                                    value="<?= esc($uploadDate ?? '') ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </form>

                        <!-- Reports Table -->
                        <?php if (!empty($reports)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="publicReportTable">
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
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        <?= esc(ucfirst($report['report_type'])) ?>
                                                    </span>
                                                </td>
                                                <td><?= esc($report['file_name']) ?></td>
                                                <td><?= date('d M Y', strtotime($report['upload_date'])) ?></td>
                                                <td class="text-end">
                                                    <div class="action-buttons">
                                                        <a href="<?= base_url('reports/report_download/' . $report['id']) ?>"
                                                            class="btn btn-outline-primary"
                                                            data-bs-toggle="tooltip" title="Download">
                                                            <i class="bi bi-download"></i> Download
                                                        </a>
                                                        <a href="<?= base_url('reports/report_preview/' . $report['id']) ?>"
                                                            target="_blank"
                                                            class="btn btn-outline-success"
                                                            data-bs-toggle="tooltip" title="Preview">
                                                            <i class="bi bi-eye"></i> View
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
                                <div>No reports found matching your criteria.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#publicReportTable').DataTable({
                                language: {
                                    search: "_INPUT_",
                                    searchPlaceholder: "Search reports...",
                                    lengthMenu: "Show _MENU_ entries",
                                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                    paginate: {
                                        previous: "<i class='bi bi-chevron-left'></i>",
                                        next: "<i class='bi bi-chevron-right'></i>"
                                    }
                                },
                                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                                drawCallback: function() {
                                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                                }
                            });
                            
                            // Initialize tooltips
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl)
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>