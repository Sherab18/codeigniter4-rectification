<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Energy Data | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
	<div class="container">
		<div class="row">
			<div class="col col-md-3">
				<?= $this->include('energydata/energy_sidebar') ?><br>
			</div>
			<div class="col col-md-9">
				<div class="card border-dark">
					<div class="card-header text-center text-white bg-primary">
						<strong><?= $title ?></strong>
					</div>
					<div class="card-body">
						<?php if (session()->getFlashdata('success')) : ?>
							<div class="alert alert-success" role="alert">
								<?= session()->getFlashdata('success') ?>
							</div>
						<?php endif; ?>
						<?php if (session()->getFlashdata('error')) : ?>
							<div class="alert alert-danger" role="alert">
								<?= session()->getFlashdata('error') ?>
							</div>
						<?php endif; ?>

						<?php if ($records) : ?>
							<div class="table-responsive">
								<table class="table table-striped" id="lgbr">
									<thead>
										<tr>
											<th scope="col">Date</th>
											<th scope="col">Created By</th>
											<th scope="col">Created At</th>
											<th scope="col">Updated At</th>
											<th scope="col">Version</th>
											<th scope="col">View Detail</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($records as $row) : ?>
											<tr>
												<td scope="row"><?= $row['r_date'] ?></td>
												<td><?= fullname($row['created_by']) ?></td>
												<td><?= $row['created_at'] ?></td>
												<td><?= $row['updated_at'] ?></td>
												<td><?= $row['version'] ?></td>
												<td>
													<a class="btn btn-outline-<?= $row['version'] < 100 ? 'warning' : 'success' ?>" href="<?= base_url() . 'powerdata/energy_edit/' . $row['id'] ?>" role="button">
														<i class="bi bi-binoculars"></i> Details
													</a>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else : ?>
							<div class="alert alert-warning" role="alert">Sorry! No record to display.</div>
						<?php endif; ?>
					</div>

					<script>
						$(document).ready(function() {
							$('#lgbr').DataTable();
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</main><br>
<?= $this->endSection() ?>