<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('navbar') ?>
    <?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="container-fluid py-4">
        
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Vacancy Management</h1>
                <p class="mb-0 text-muted">Manage and monitor all job vacancies</p>
            </div>
            <a href="<?= site_url('career/vacancies/create') ?>" class="btn btn-primary d-none d-sm-inline-block">
                <i class="bi bi-plus-circle me-2"></i> Create New Vacancy
            </a>
        </div>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Vacancies</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($vacancies) ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-briefcase text-gray-300" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Open Positions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= count(array_filter($vacancies, fn($v) => $v['status'] === 'open')) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-door-open text-gray-300" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Closed Positions</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= count(array_filter($vacancies, fn($v) => $v['status'] === 'closed')) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-door-closed text-gray-300" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow-sm h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Expiring Soon</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?= count(array_filter($vacancies, function ($v) {
                                        if ($v['status'] !== 'open' || empty($v['close_at'])) return false;
                                        try {
                                            $closeDate = new \DateTime($v['close_at']);
                                            $now = new \DateTime();
                                            $interval = $now->diff($closeDate);
                                            return $interval->days <= 3 && $interval->invert === 0;
                                        } catch (\Exception $e) {
                                            return false;
                                        }
                                    })) ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-clock text-gray-300" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Current Vacancies</h6>
            </div>
            <div class="card-body">
                <?php if (empty($vacancies)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox display-4 text-muted"></i>
                        <h5 class="text-muted mt-3">No Vacancies Found</h5>
                        <a href="<?= site_url('career/vacancies/create') ?>" class="btn btn-primary mt-2">Create Vacancy</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="vacanciesTable">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Closing Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vacancies as $vacancy): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"><?= esc($vacancy['title']) ?></h6>
                                                    <small class="text-muted"><?= character_limiter(strip_tags($vacancy['description']), 50) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= esc($vacancy['department']) ?></td>
                                        <td><span class="badge bg-light text-dark border"><?= esc($vacancy['position_type']) ?></span></td>
                                        <td>
                                            <span class="badge bg-<?= $vacancy['status'] === 'open' ? 'success' : 'secondary' ?>">
                                                <?= ucfirst(esc($vacancy['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (!empty($vacancy['close_at'])): ?>
                                                <?= date('M j, Y', strtotime($vacancy['close_at'])) ?>
                                            <?php else: ?>
                                                <span class="text-muted">Not set</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?= site_url('career/vacancies/view/' . $vacancy['id']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                                <?php if ($vacancy['status'] === 'open'): ?>
                                                    <a href="<?= site_url('career/vacancies/close/' . $vacancy['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Close this vacancy?')"><i class="bi bi-x-circle"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-secondary { border-left: 0.25rem solid #858796 !important; }
    .card { border-radius: 0.5rem; }
    .table td { vertical-align: middle; }
</style>
<?= $this->endSection() ?>