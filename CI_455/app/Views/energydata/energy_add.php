<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Energy Data | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
	<div class="container my-4">
		<div class="row">
			<div class="col-md-3">
				<?= $this->include('energydata/energy_sidebar') ?><br>
			</div>

			<div class="col-md-9">
				<div class="card shadow-lg border-0 rounded-3">
					<div class="card-header bg-primary text-white text-center">
						<h4 class="mb-0">Add New Energy Data</h4>
					</div>
					<div class="card-body px-4 py-5">
						<?php if (session()->getFlashdata('success')): ?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<?= session()->getFlashdata('success') ?>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>

						<?php if (session()->getFlashdata('error')): ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<?= session()->getFlashdata('error') ?>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>

						<form action="<?= base_url('/powerdata/energy_store') ?>" method="post">
							<?= csrf_field() ?>

							<div class="mb-4">
								<label for="r_date" class="form-label">Date:</label>
								<input type="date" class="form-control w-50 mx-auto" id="r_date" name="r_date" required>
							</div>

							<div class="section-header mb-3">
								<h5 class="text-primary">Energy Data (MWh)</h5>
								<hr class="mb-3" style="width: 50%; margin-left: 0;">
							</div>

							<div class="row">
								<?php
								$fields_first_section = [
									'generation_mwh' => 'Generation (MWh)',
									'iex_import_mwh' => 'IEX Import (MWh)',
									'iex_export_mwh' => 'IEX Export (MWh)',
									'energy_met_mwh' => 'Energy Met (MWh)',
									'energy_import_mwh' => 'Energy Import (MWh)',
									'energy_export_mwh' => 'Energy Export (MWh)',
								];

								foreach ($fields_first_section as $name => $label): ?>
									<div class="col-md-4 form-group mb-3">
										<label for="<?= $name ?>" class="form-label"><?= $label ?></label>
										<input type="number" class="form-control" id="<?= $name ?>" name="<?= $name ?>" step="0.001" required
											oninvalid="this.setCustomValidity('Please fill the form')"
											oninput="this.setCustomValidity('')">
									</div>
								<?php endforeach; ?>
							</div>

							<div class="section-header mt-4 mb-3">
								<h5 class="text-primary">Demand Data (MW)</h5>
								<hr class="mb-3" style="width: 50%; margin-left: 0;">
							</div>

							<div class="row">
								<?php
								$fields_second_section = [
									'peak_demand_mw' => 'Peak Demand (MW)',
									'demand_0900hrs_mw' => 'Demand at 09:00 hrs (MW)',
									'demand_1900hrs_mw' => 'Demand at 19:00 hrs (MW)',
									'peak_exchange_mw' => 'Peak Exchange (MW)',
								];

								foreach ($fields_second_section as $name => $label): ?>
									<div class="col-md-4 form-group mb-3">
										<label for="<?= $name ?>" class="form-label"><?= $label ?></label>
										<input type="number" class="form-control" id="<?= $name ?>" name="<?= $name ?>" step="0.001" required
											oninvalid="this.setCustomValidity('Please fill the form')"
											oninput="this.setCustomValidity('')">
									</div>
								<?php endforeach; ?>
							</div>

							<div class="d-flex mt-4">
								<button type="submit" class="btn btn-primary me-3 px-4">Submit</button>
								<a href="<?= base_url('powerdata/list_energy') ?>" class="btn btn-secondary px-4">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<br>
<?= $this->endSection() ?>