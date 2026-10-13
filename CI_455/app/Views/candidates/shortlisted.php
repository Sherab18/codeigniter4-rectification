<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Shortlisted Candidates</h2>

    <?php if (empty($candidates)): ?>
        <div class="alert alert-info">No candidates have been shortlisted yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Position</th>
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
                                <?php if (isset($candidate['vacancy_title'])): ?>
                                    <a href="<?= base_url('career/vacancies/view/' . $candidate['vacancy_id']) ?>">
                                        <?= esc($candidate['vacancy_title']) ?>
                                    </a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-warning"><?= ucfirst($candidate['status']) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('career/candidates/resume/' . $candidate['id']) ?>" class="btn btn-sm btn-outline-primary" title="View Resume">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>