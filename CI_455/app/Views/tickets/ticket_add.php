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
			<div class="col col-md-3">
				<?= $this->include('tickets/tickets_sidebar') ?><br>
				<?= $this->include('tickets/tickets_emp_sidebar') ?><br>
			</div>

			<div class="col col-md-9">
				<div class="card border-dark">
					<div class="card-header text-center text-white bg-primary"><strong>Issue a New Ticket</strong></div>
					<div class="card-body">
						<?= form_open('tickets/create') ?>

						<div class="row g-2">
							<div class="col-md-2">
								<label class="form-label">Ticket Id:</label>
								<input type="text" class="form-control" value="<?= $id ?>" readonly>
							</div>

							<div class="col-md-4">
								<label class="form-label">Issued To:</label>
								<select class="form-select <?= $not_post ? '' : (empty($errors['target']) ? 'is-valid' : 'is-invalid') ?>" name="target">
									<option selected disabled>Select service unit</option>
									<option value="scada and telemetry section" <?= set_select('target', 'scada and telemetry section') ?>>SCADA & Telemetry Section</option>
									<option value="communication section" <?= set_select('target', 'communication section') ?>>Communication Section</option>
									<option value="core system engineering section" <?= set_select('target', 'core system engineering section') ?>>Core System Engineering Section</option>
									<option value="system analyst section" <?= set_select('target', 'system analyst section') ?>>System Analyst Section</option>
									<option value="system analyst section" <?= set_select('target', 'Others') ?>>Others</option>

								</select>
								<div class="invalid-feedback"><?= isset($errors['target']) ? $errors['target'] : '' ?></div>
							</div>

							<div class="col-md-4">
								<label class="form-label">Problem Severity:</label>
								<select class="form-select <?= $not_post ? '' : (empty($errors['severity']) ? 'is-valid' : 'is-invalid') ?>" name="severity">
									<option selected disabled>Select severity</option>
									<option value="minor" <?= set_select('severity', 'minor') ?>>Minor</option>
									<option value="major" <?= set_select('severity', 'major') ?>>Major</option>
									<option value="severe" <?= set_select('severity', 'severe') ?>>Severe</option>
								</select>
								<div class="invalid-feedback"><?= isset($errors['severity']) ? $errors['severity'] : '' ?></div>
							</div>
						</div><br>

						<div class="row g-2">
							<div class="col-md-4 offset-md-2">
								<label class="form-label">Voltage Level:</label>
								<select class="form-select" id="voltage">
									<option selected disabled>Select voltage level</option>
									<option value="400" <?= set_select('voltage', '400') ?>>400kV</option>
									<option value="220" <?= set_select('voltage', '220') ?>>220kV</option>
									<option value="132" <?= set_select('voltage', '132') ?>>132kV</option>
									<option value="66" <?= set_select('voltage', '66') ?>>66kV</option>
									<option value="no_voltage" <?= set_select('voltage', 'no_voltage') ?>>No Voltage Level</option>
								</select>
							</div>

							<div class="col-md-4">
								<label class="form-label">Station Name</label>
								<select class="form-select <?= $not_post ? '' : (empty($errors['station']) ? 'is-valid' : 'is-invalid') ?>" name="station">
									<option selected disabled>Select station</option>
								</select>
								<div class="invalid-feedback"><?= isset($errors['station']) ? $errors['station'] : '' ?></div>
							</div>
						</div><br>

						<div class="row g-2">
							<div class="col-md-8 offset-md-2">
								<label class="form-label">Problem Description:</label>
								<textarea class="form-control <?= $not_post ? '' : (empty($errors['prob_desc']) ? 'is-valid' : 'is-invalid') ?>" name="prob_desc" rows="3" placeholder="Enter problem description..."><?= set_value('prob_desc') ?></textarea>
								<div class="invalid-feedback"><?= isset($errors['prob_desc']) ? $errors['prob_desc'] : '' ?></div>
							</div>
						</div><br>

						<div class="row g-2">
							<div class="col-md-8 offset-md-2">
								<label class="form-label">Service Affected:</label>
								<textarea class="form-control <?= $not_post ? '' : (empty($errors['serv_affected']) ? 'is-valid' : 'is-invalid') ?>" name="serv_affected" rows="3" placeholder="Enter service affected..."><?= set_value('serv_affected') ?></textarea>
								<div class="invalid-feedback"><?= isset($errors['serv_affected']) ? $errors['serv_affected'] : '' ?></div>
							</div>
						</div><br>

						<div class="row g-2">
							<div class="col-md-3 offset-md-2">
								<button class="btn btn-primary" type="submit">Issue Ticket</button>
							</div>
							<div class="col-md-3 offset-md-2">
								<a href="<?= base_url() ?>tickets/list_tickets" class="btn btn-primary">Cancel</a>
							</div>
						</div>

						<?= form_close(); ?>
					</div>

					<script>
						$(document).ready(function() {
							$("#voltage").change(function() {
								var kv = $("#voltage").val();

								if (kv) {
									$.ajax({
										url: "<?= base_url('stations/list_stations'); ?>/" + kv,
										type: "GET",
										dataType: "JSON",
										success: function(records) {
											let options = '<option selected disabled>Select station</option>';
											for (let i = 0; i < records.length; i++) {
												options += '<option value="' + records[i].id + '">' + records[i].station + ' (' + records[i].capacity + ')</option>';
											}
											$("[name='station']").html(options);
										},
										error: function(jqXHR, textStatus, errorThrown) {
											alert("Unexpected Error: " + errorThrown);
										}
									});
								} else {
									$("[name='station']").html('<option selected disabled>Select station</option>');
								}
							});
						});
					</script>
				</div>
			</div>
		</div>
	</div>
</main><br>

<?= $this->endSection() ?>