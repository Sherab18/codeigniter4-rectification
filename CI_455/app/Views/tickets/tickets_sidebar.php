<div class="card border-dark">
    <div class="card-header text-white bg-success"><strong>Tickets Log:</strong></div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <a href="<?= base_url() ?>tickets/add/" class="card-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Create a new ticket">
                <i class="bi bi-pencil-square"></i> Issue New Ticket
            </a>
        </li>
        <?php 
        $statuses = ['new' => 'New Tickets Raised', 'pending' => 'Pending Tickets', 'solved' => 'Solved Tickets', 'passed' => 'Passed Tickets'];
        foreach ($statuses as $status => $label): 
        ?>
        <li class="list-group-item">
            <a href="<?= base_url() ?>tickets/list_tickets/status/<?= $status ?>" class="card-link" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $label ?>">
                <i class="bi bi-card-list"></i> <?= $label ?>
                <?php if(num_ticket('status', $status)): ?>
                    <span class="badge rounded-pill <?= $status === 'new' ? 'bg-warning text-dark' : ($status === 'pending' ? 'bg-danger text-white' : ($status === 'passed' ? 'bg-primary text-white' : 'bg-success text-white')) ?>">
                        <?= num_ticket('status', $status) ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>
        <?php endforeach; ?>
        <li class="list-group-item">
            <a href="<?= base_url() ?>tickets/list_tickets/all/all" class="card-link" data-bs-toggle="tooltip" data-bs-placement="top" title="View all issued tickets">
                <i class="bi bi-card-list"></i> All Issued Tickets
            </a>
        </li>
    </ul>
</div>

<script>
    var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
