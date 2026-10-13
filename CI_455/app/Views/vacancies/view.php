<?php echo $this->extend('layouts/layouts_user') ?>

<?php echo $this->section('navbar') ?>
<?php echo $this->include('partials/navbar_user') ?>
<?php echo $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3><?= esc($vacancy['title']) ?></h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Department:</strong> <?= esc($vacancy['department']) ?>
                </div>
                <div class="col-md-4">
                    <strong>Position Type:</strong> <?= esc($vacancy['position_type']) ?>
                </div>
                
            </div>
            <div class="mb-3">
                <strong>Description:</strong>
                <p><?= nl2br(esc($vacancy['description'])) ?></p>
            </div>

            <!-- Add this after the description section -->
            <?php if (!empty($vacancy['attachment_path'])): ?>
                <?php $fullPath = WRITEPATH . $vacancy['attachment_path']; ?>
                <?php if (file_exists($fullPath)): ?>
                    <div class="mb-3">
                        <strong>Job Description:</strong>
                        <a href="<?= base_url('career/vacancies/attachment/' . $vacancy['id']) ?>" class="btn btn-sm btn-outline-primary ms-2">
                            <i class="bi bi-file-earmark-pdf"></i> Download Job Description
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-danger">File missing: <?= htmlspecialchars($fullPath) ?></div>
                <?php endif; ?>
            <?php endif; ?>
            <div>
                <strong>Status:</strong>
                <span class="badge bg-<?= $vacancy['status'] === 'open' ? 'success' : 'secondary' ?>">
                    <?= ucfirst($vacancy['status']) ?>
                </span>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Candidates</h4>

    <?php if (empty($candidates)): ?>
        <div class="alert alert-info">No candidates have applied for this position yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidates as $candidate): ?>
                        <tr>
                            <td><?= esc($candidate['first_name'] . ' ' . $candidate['last_name']) ?></td>
                            <td><?= esc($candidate['email']) ?></td>
                            <td><?= esc($candidate['phone']) ?></td>
                            <td>
                                <span class="badge bg-<?=
                                                        $candidate['status'] === 'applied' ? 'info' : ($candidate['status'] === 'shortlisted' ? 'warning' : ($candidate['status'] === 'hired' ? 'success' : ($candidate['status'] === 'rejected' ? 'danger' : 'secondary')))
                                                        ?>">
                                    <?= ucfirst($candidate['status']) ?>
                                </span>

                            </td>
                            <td>
                                <a href="<?= base_url('career/candidates/resume/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-primary" title="View Resume">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                                <?php if ($candidate['status'] === 'applied'): ?>
                                    <a href="<?= site_url('career/candidates/shortlist/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-success" title="Shortlist">
                                        <i class="bi bi-person-check"></i>
                                    </a>
                                    <a href="<?= site_url('career/candidates/reject/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-danger" title="Reject">
                                        <i class="bi bi-person-x"></i>
                                    </a>
                                <?php elseif ($candidate['status'] === 'shortlisted'): ?>
                                    <a href="<?= site_url('career/candidates/select/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-success" title="Select/Hire">
                                        <i class="bi bi-check-circle"></i>
                                    </a>
                                    <a href="<?= site_url('career/candidates/reject/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-danger" title="Reject">
                                        <i class="bi bi-person-x"></i>
                                    </a>
                                <?php elseif ($candidate['status'] === 'hired'): ?>
                                    <button class="btn btn-sm btn-success disabled" title="Hired">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </button>
                                <?php elseif ($candidate['status'] === 'rejected'): ?>
                                    <button class="btn btn-sm btn-danger disabled" title="Rejected">
                                        <i class="bi bi-person-x"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>