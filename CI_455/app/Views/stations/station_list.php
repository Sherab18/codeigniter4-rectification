<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Stations | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
<div class="container">
<div class="row">
<div class="col col-md-3">
<?= $this->include('stations/stations_sidebar') ?><br>
</div>

<div class="col col-md-9">
<div class="card border-dark">
	<div class="card-header text-center text-white bg-primary"><strong><?= $title ?></strong></div>
	<div class="card-body">
		<?php if($records): ?>
		<table class="table table-striped" id="stations">
		<thead>
		<tr>
			<th scope="col" class="align-top">Station</th>
			<th scope="col" class="align-top">Capacity</th>
			<th scope="col" class="align-top">Created By</th>
			<th scope="col" class="align-top">Created At</th>
			<th scope="col" class="align-top">Station Details</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($records as $row): ?>
		<tr>
			<td scope="row"><?= $row['station'] ?></td>
			<td><?= $row['capacity'] ?></td>
			<td><?= fullname($row['created_by']) ?></td>
			<td><?= $row['created_at'] ?></td>
			<td>
				<button type="button" class="btn btn-outline-primary" 
				onclick="edit_station(<?= $row['id'] ?>, <?= "'".fullname($row['created_by'])."'" ?>, <?= "'".fullname($row['updated_by'])."'" ?>)">
				<i class="bi bi-binoculars"></i> Details</button>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
		</table>
		<?php else: ?>
		<div class="alert alert-warning" role="alert">Sorry! No record to display.</div>
		<?php endif; ?>
	</div>
<script>
$(document).ready(function(){
	$('#stations').DataTable();
});

function edit_station(stn_id, created_by, updated_by){
$.ajax({
	url: "<?= base_url('stations/list stations/single'); ?>/" + stn_id,
	headers: {'X-Requested-With': 'XMLHttpRequest'},
	type: "GET",
	dataType: "JSON",
	success: function(response){
		console.log(response);
		$("[name='station']").val(response['station']);
		$("[name='capacity']").val(response['capacity']);
		$("[name='voltage']").val(response['voltage']);
		$("[name='created_by']").val(created_by);
		$("[name='created_at']").val(response['created_at']);
		$("[name='updated_by']").val(updated_by);
		$("[name='updated_at']").val(response['updated_at']);
		
		$("#heading").text("Update Station");
		$("#save_btn").html("Update");
		$('#save_btn').attr("data-stn_id", stn_id);
		$('#station_edit').modal('show');
	},
	error: function(jqXHR, textStatus, errorThrown){
		alert("Unexpected Error: " + errorThrown);
	}
});
}
</script>
</div>
</div>

</div>
</div>
</main><br>
<?= $this->endSection() ?>