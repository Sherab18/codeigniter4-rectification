<div class="card border-dark">
	<div class="card-header text-white bg-success"><strong>Stations:</strong></div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item"><a href="#" class="card-link" id="create_stn">
			<i class="bi bi-file-earmark-plus"></i> Create New Station</a>
		</li>
		<li class="list-group-item"><a href="<?= base_url() ?>stations/list stations/400/all" class="card-link">
			<i class="bi bi-card-list"></i> 400kV Voltage Level</a>
		</li>
		<li class="list-group-item"><a href="<?= base_url() ?>stations/list stations/220/all" class="card-link">
			<i class="bi bi-card-list"></i> 220kV Voltage Level</a>
		</li>
		<li class="list-group-item"><a href="<?= base_url() ?>stations/list stations/132/all" class="card-link">
			<i class="bi bi-card-list"></i> 132kV Voltage Level</a>
		</li>
		<li class="list-group-item"><a href="<?= base_url() ?>stations/list stations/66/all" class="card-link">
			<i class="bi bi-card-list"></i> 66kV Voltage Level</a>
		</li>
		<li class="list-group-item"><a href="<?= base_url() ?>stations/list stations/cc/all" class="card-link">
			<i class="bi bi-card-list"></i> Control Centers</a>
		</li>
	</ul>
</div>

<script>
$(document).ready(function(){
$("#create_stn").click(function(){
	$("form")[0].reset();
	$("#updated_div").empty();
	$("#station_edit").modal('show');
});

$("#save_btn").click(function(){
var stn_id = $("#save_btn").data('stn_id');
$.ajax({
	url: "<?= base_url('stations/update station'); ?>/" + stn_id,
	headers: {'X-Requested-With': 'XMLHttpRequest'},
	type: "POST",
	data: $('form').serialize(),
	dataType: "JSON",
	success: function(response){
		if(response['status'] == 'success'){
			$("#message").prepend('<div class="alert alert-success" role="alert">' + response['message'] + '</div>');
		}
		else if(response['status'] == 'fail_1'){
			if(response['errors']['station']){
				$("input[name='station']").addClass("form-control is-invalid");
				$("div[name='station']").text(response['errors']['station']);
			}
			if(response['errors']['capacity']){
				$("input[name='capacity']").addClass("form-control is-invalid");
				$("div[name='capacity']").text(response['errors']['capacity']);
			}
			if(response['errors']['voltage']){
				$("#voltage").addClass("form-select is-invalid");
				$("div[name='voltage']").text(response['errors']['voltage']);
			}
		}
		else{
			$("#message").prepend('<div class="alert alert-danger" role="alert">' + response['message'] + '</div>');
		}
		$("#save_btn").attr("disabled", "disabled");
	},
	error: function(jqXHR, textStatus, errorThrown){
		alert("Unexpected Error: " + errorThrown);
	}
});
});
});

function reload_station(){
	location.reload();
}
</script>

<!-- Modal -->
<div class="modal fade" id="station_edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="heading"><strong>Create New Station</strong></h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reload_station()"></button>
	</div>
	<?= form_open(); ?>
	<div class="modal-body">
	<div class="row g-3" id="message">
	<div class="col-md-6">
		<label class="form-label">Station Name:</label>
		<input type="text" class="form-control" name="station" placeholder="Enter station name">
		<div class="invalid-feedback" name="station"></div>
	</div>
	<div class="col-md-6">
		<label class="form-label">Station Capacity:</label>
		<input type="text" class="form-control" name="capacity" placeholder="Enter station capacity">
		<div class="invalid-feedback" name="capacity"></div>
	</div>
	<div class="col-md-6">
		<label class="form-label">Voltage Level:</label>
		<select class="form-select" name="voltage" id="voltage">
			<option selected disabled value="">Select voltage level</option>
			<option value="400">400 kV</option>
			<option value="220">220 kV</option>
			<option value="132">132 kV</option>
			<option value="66">66 kV</option>
			<option value="no_voltage">Control Centers</option>
		</select>
		<div class="invalid-feedback" name="voltage"></div>
	</div>
	</div><br>
	<div class="row g-3" id="updated_div">
	<div class="col-md-6">
		<label class="form-label">Created By:</label>
		<input type="text" class="form-control" name="created_by" readonly>
	</div>
	<div class="col-md-6">
		<label class="form-label">Create Date:</label>
		<input type="text" class="form-control" name="created_at" readonly>
	</div>
	<div class="col-md-6">
		<label class="form-label">Last Update By:</label>
		<input type="text" class="form-control" name="updated_by" readonly>
	</div>
	<div class="col-md-6">
		<label class="form-label">Last Update Date:</label>
		<input type="text" class="form-control" name="updated_at" readonly>
	</div>
	</div><br>
	</div>
	<?= form_close(); ?>
	<div class="modal-footer">
	<div class="col-md-5">
		<button type="button" class="btn btn-primary" id="save_btn" data-stn_id="new">Create</button>
	</div>
	<div class="col-md-4 offset-md-1">
		<button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="reload_station()">Cancel</button>
	</div>
	</div>
</div>
</div>
</div>