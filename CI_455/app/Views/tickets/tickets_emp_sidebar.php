<div class="card border-dark">
	<div class="card-header text-white bg-success"><strong>Top Employee Of Month:</strong></div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<a href="<?= base_url() ?>tickets/list_tickets/issue_by/<?= emp_ticket('issuer') ? emp_ticket('issuer') : 'no issuer' ?>" class="card-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Top Issuer of Tickets">
				<strong>Issuer:</strong>
				<?php if (emp_ticket('issuer')): ?>
					<?= ' ' . fullname(emp_ticket('issuer')) . ' ' ?><i class="bi bi-award"></i>
				<?php else: ?>
					<?= ' No Ticket Issued' ?>
				<?php endif; ?>
			</a>
		</li>
		<li class="list-group-item">
			<a href="<?= base_url() ?>tickets/list_tickets/sol_eng/<?= emp_ticket('solver') ? emp_ticket('solver') : 'no solver' ?>" class="card-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Top Solver of Tickets">
				<strong>Solver:</strong>
				<?php if (emp_ticket('solver')): ?>
					<?= ' ' . fullname(emp_ticket('solver')) . ' ' ?><i class="bi bi-award"></i>
				<?php else: ?>
					<?= ' No Ticket Solved' ?>
				<?php endif; ?>
			</a>
		</li>
	</ul>
</div>

<script>
	var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	tooltipTriggerList.forEach(function(tooltipTriggerEl) {
		new bootstrap.Tooltip(tooltipTriggerEl);
	});
</script>