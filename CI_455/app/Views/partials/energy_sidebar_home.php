<div class="card border-dark">
	<div class="card-header text-white bg-success"><strong>Energy Data (MWh):</strong></div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Total Generation</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="generation_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Energy Import from India</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="energy_import_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Energy Export to India</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="energy_export_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Import from IEX</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="iex_import_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Export through IEX</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="iex_export_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Daily Energy Met</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="energy_met_mwh"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
	</ul>
</div><br>
<div class="card border-dark">
	<div class="card-header text-white bg-success"><strong>Power Data (MW):</strong></div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Peak Demand Met</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="peak_demand_mw"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Demand Met at 09:00hrs (Today)</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="demand_0900hrs_mw"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Demand Met at 19:00hrs (Yesterday)</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="demand_1900hrs_mw"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-7">Peak Exchange with India</div>
				<div class="col-md-5"><button type="button" class="btn btn-outline-primary" value="peak_exchange_mw"><i class="bi bi-graph-up"></i> View</button></div>
			</div>
		</li>
	</ul>
</div>
<script>
$(document).ready(function(){
	$("button").click(function(){
		var d_type = $(this).val();
		$("#d_type").val(d_type);
		get_data();
	});
	$("#r_month").change(function(){
		get_data();
	});
});
</script>