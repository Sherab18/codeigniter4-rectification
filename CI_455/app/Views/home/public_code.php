<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Commercial Operation Declaration | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0">Recent Commercial Operation Dates(CODs)</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Generation Plant</th>
                                <th>Unit Designation</th>
                                <th>Date Published</th>
                                <th class="text-center">Official Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($documents)): ?>
                                <?php foreach ($documents as $d): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary"><?= esc($d['station_name']) ?></td>
                                        <td><span class="badge bg-info text-dark"><?= esc($d['unit_name']) ?></span></td>
                                        <td><?= date('d M Y', strtotime($d['created_at'])) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('publicdata/view_cod/' . $d['id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i> View COD
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        No COD declarations are currently available for public view.
                                    </td>
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