<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Energy Data | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?><br>
<main>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-3 mb-3">
				<?= $this->include('partials/energy_sidebar_home') ?><br>
			</div>

			<div class="col-12 col-md-9">
				<div class="card border-dark">
					<div class="card-header text-center bg-info">
						<div class="row">
							<div class="col-12 col-md-9 text-md-start text-center">
								<!-- FIX: Changed <label> to <span> to prevent orphaned label rule violation -->
								<span class="h5 mb-0 fw-bold" id="chart_title">Energy Data</span>
								<input type="hidden" id="d_type" value="generation_mwh">
							</div>
							<div class="col-12 col-md-3">
								<div class="input-group mb-2">
									<label for="r_year" class="input-group-text">Year</label>
									<select class="form-select" id="r_year" onchange="updateMonthOptions()">
										<option value="2026" selected>2026</option>
										<option value="2025">2025</option>
										<option value="2024">2024</option>
										<option value="2023">2023</option>
									</select>
								</div>
								<div class="input-group mb-2">
									<label for="r_month" class="input-group-text">Month</label>
									<select class="form-select" id="r_month" onchange="get_data()">
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div id="chart_div"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main><br>

<script src="https://www.gstatic.com/charts/loader.js"
	crossorigin="anonymous"></script>
<script>
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(updateMonthOptions);

	function updateMonthOptions() {
		var yearSelect = document.getElementById("r_year");
		var monthSelect = document.getElementById("r_month");
		var selectedYear = yearSelect.value;
		monthSelect.innerHTML = "";

		if (selectedYear === "2026" || selectedYear === "2025" || selectedYear === "2024") {
			addOption(monthSelect, "01", "January");
			addOption(monthSelect, "02", "February");
			addOption(monthSelect, "03", "March");
			addOption(monthSelect, "04", "April");
			addOption(monthSelect, "05", "May");
			addOption(monthSelect, "06", "June");
			addOption(monthSelect, "07", "July");
			addOption(monthSelect, "08", "August");
			addOption(monthSelect, "09", "September");
			addOption(monthSelect, "10", "October");
			addOption(monthSelect, "11", "November");
			addOption(monthSelect, "12", "December");
		} else if (selectedYear === "2023") {
			addOption(monthSelect, "04", "April");
			addOption(monthSelect, "05", "May");
			addOption(monthSelect, "06", "June");
			addOption(monthSelect, "07", "July");
			addOption(monthSelect, "08", "August");
			addOption(monthSelect, "09", "September");
			addOption(monthSelect, "10", "October");
			addOption(monthSelect, "11", "November");
			addOption(monthSelect, "12", "December");
		}

		get_data();
	}

	function get_data() {
		var d_type = $("#d_type").val();
		var year = $("#r_year").val();
		var month = $("#r_month").val();
		var f_date = year + "-" + month + "-01";

		$.ajax({
			url: "<?= base_url('publicdata/energy_data'); ?>/" + d_type + "/" + f_date,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			type: "GET",
			dataType: "JSON",
			success: function(data) {
				console.log(data);
				$("#chart_title").text(data['title']);
				drawChart(data['data']);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("Unexpected Error: " + errorThrown);
			}
		});
	}

	function drawChart(chart_data) {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Date');
		data.addColumn('number', 'Energy');
		$.each(chart_data, function(i, jsonData) {
			var r_date = jsonData.r_date;
			var r_data = parseFloat($.trim(jsonData.r_data));
			data.addRows([
				[r_date, r_data]
			]);
		});
		var options = {
			legend: 'none',
			series: {
				0: {
					color: '#6f9654'
				}
			},
			hAxis: {
				title: 'Date'
			},
			vAxis: {
				title: 'Energy/Power Data'
			},
		};
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}

	function addOption(selectElement, value, text) {
		var option = document.createElement("option");
		option.value = value;
		option.text = text;
		selectElement.add(option);
	}
</script>

<?= $this->endSection() ?>