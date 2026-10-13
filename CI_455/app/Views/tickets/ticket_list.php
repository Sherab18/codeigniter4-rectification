<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Tickets | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?= $this->include('tickets/tickets_sidebar') ?><br>
				<?= $this->include('tickets/tickets_emp_sidebar') ?><br>
			</div>

			<div class="col-md-9">
				<div class="card border-dark">
					<div class="card-header text-center text-white bg-primary">
						<strong><?= $title ?></strong>
					</div>
					<div class="card-body">
						<?php if (session()->getFlashdata('success')): ?>
							<div class="alert alert-success" role="alert"><?= session()->getFlashdata('success') ?></div>
						<?php endif; ?>
						<?php if (session()->getFlashdata('error')): ?>
							<div class="alert alert-danger" role="alert"><?= session()->getFlashdata('error') ?></div>
						<?php endif; ?>
						<?php if ($records): ?>
							<div class="table-responsive">
								<table class="table table-striped" id="tickets">
									<thead>
										<tr>
											<th>Index</th>
											<th>Station</th>
											<th>Severity</th>
											<th>Problem Description</th>
											<th>Issued To</th>
											<th>Issued By</th>
											<th>Issued Date</th>
											<th>Problem Details</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($records as $row): ?>
											<tr>
												<td><?= esc($row['id']) ?></td>
												<td><?= esc($row['station'] ? ucwords(station_details($row['station'])['station']) : 'Not available') ?></td>
												<td><?= esc(ucwords($row['severity'])) ?></td>
												<td><?= esc(strlen($row['prob_desc']) > 15 ? substr($row['prob_desc'], 0, 15) . '...' : $row['prob_desc']) ?></td>
												<td><?= esc(ucwords($row['target'])) ?></td>
												<td><?= esc(fullname($row['issue_by'])) ?></td>
												<td><?= esc($row['issue_date']) ?></td>
												<td>
													<a class="btn btn-outline-<?=
																				$row['status'] == 'new' ? 'warning' : ($row['status'] == 'passed' ? 'primary' : ($row['status'] == 'solved' ? 'success' : ($row['status'] == 'pending' ? 'danger' : ($row['ver_eng'] ? 'success' : 'secondary')))) ?>"
														href="<?= base_url('tickets/update_ticket/' . $row['id']) ?>" role="button">
														<i class="bi bi-binoculars"></i> Details
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="alert alert-warning" role="alert">Sorry! No record to display.</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<script>
	$(document).ready(function() {
		if (typeof $.fn.DataTable === 'function') {
			$('#tickets').DataTable();
		}
	});
</script>
<br>
<?= $this->endSection() ?>