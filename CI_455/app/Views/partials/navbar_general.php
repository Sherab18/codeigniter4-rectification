<header style="background-color: #f8fafcff;">
	<div class="container">
		<nav class="navbar navbar-expand-lg  rounded">
			<div class="container-fluid">
				<a class="navbar-brand d-flex align-items-center" href="<?= base_url() ?>">
					<img src="<?= base_url() ?>/assets/img/bpso_logo.png" alt="logo" width="120" height="120" class="me-2">
				</a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse justify-content-between" id="navbar">
					<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
						<li class="nav-item dropdown" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="#" data-bs-toggle="dropdown">
								<i class="bi bi-buildings-fill me-2"></i>ABOUT
							</a>
							<ul class="dropdown-menu shadow-lg">
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>home/about">
										<i class="bi bi-building-gear me-2"></i>ABOUT US
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>home/governance">
										<i class="bi bi-people me-2"></i>GOVERNANCE COMMITTEE
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>home/management">
										<i class="bi bi-people me-2"></i>MANAGEMENT TEAM
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>home/organogram">
										<i class="bi bi-diagram-3 me-2"></i>ORGANOGRAM
									</a></li>
							</ul>
						</li>
						<li class="nav-item dropdown" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="#" data-bs-toggle="dropdown">
								<i class="fas fa-bullhorn fa-fw me-2"></i>ANNOUNCEMENTS
							</a>
							<ul class="dropdown-menu shadow-lg">
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>publicdata/news">
										<i class="fas fa-newspaper fa-fw me-2"></i>NEWS | ANNOUNCEMENTS
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>publicdata/careers">
										<i class="fas fa-bullhorn fa-fw me-2"></i>CAREERS
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>publicdata/tenders">
										<i class="fas fa-file-contract fa-fw me-2"></i>TENDERS
									</a></li>

							</ul>
						</li>

						<li class="nav-item dropdown" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="#" data-bs-toggle="dropdown">
								<i class="bi bi-lightning-charge me-1"></i>POWER SUPPLY POSITION
							</a>
							<ul class="dropdown-menu shadow-lg">
								<li><a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url() ?>home/energy">
										<i class="bi bi-graph-up me-2"></i>DAILY ENERGY DATA
									</a></li>
							</ul>
						</li>
						<li class="nav-item dropdown" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="#" data-bs-toggle="dropdown">
								<i class="bi bi-globe me-1"></i> WEB PORTAL
							</a>
							<ul class="dropdown-menu shadow-lg">
								<li><a class="dropdown-item d-flex align-items-center py-2" href="https://forms.gle/jdiUCzRcY3o9X4227">
										<i class="bi bi-envelope"></i>GRIEVANCE FORM
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="https://loadforecast-mcc.bpso.bt/bhutan_fs/">
										<i class="bi bi-bar-chart-line-fill"></i>LOAD FORECAST
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="https://webapp-mcc.bpso.bt:8088/">
										<i class="bi bi-file-earmark-minus-fill"></i>WEB REPORTS
									</a></li>
								<li><a class="dropdown-item d-flex align-items-center py-2" href="https://webapp-mcc.bpso.bt:1223/">
										<i class="bi bi-book"></i>E-LOGBOOK
									</a></li>
							</ul>

						</li>
						<li class="nav-item">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="https://bpsoerp.frappe.cloud/login/">
								<i class="bi bi-file-earmark-text me-1"></i>ERP PORTAL
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-primary fw-medium d-flex align-items-center" href="<?= base_url() ?>home/tech_paper">
								<i class="bi bi-journal-text me-1"></i>PUBLICATION
							</a>
						</li>
					</ul>

					<div class="d-flex">
						<a class="btn btn-outline-primary fw-medium d-flex align-items-center" href="<?= base_url() ?>users/login" target="_blank">
							<i class="bi bi-person me-1"></i>Employee Login
						</a>
					</div>
				</div>
			</div>
		</nav>
	</div>
</header>

<script>
	function showDropdown(element) {
		const dropdown = element.querySelector('.dropdown-menu');
		dropdown.classList.add('show');
	}

	function hideDropdown(element) {
		const dropdown = element.querySelector('.dropdown-menu');
		dropdown.classList.remove('show');
	}
</script>

<style>
	.dropdown-menu {
		border: none;
		box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
		border-radius: 8px;
		padding: 8px 0;
		min-width: 220px;
		background-color: white;
	}

	.dropdown-item {
		padding: 8px 16px;
		color: #333;
		transition: all 0.3s ease;
		position: relative;
		border-left: 3px solid transparent;
	}

	.dropdown-item:hover {
		background-color: #f8f9fa;
		color: #0d6efd;
		border-left-color: #0d6efd;
	}

	.dropdown-item i {
		color: #6c757d;
		transition: color 0.3s ease;
		width: 20px;
		text-align: center;
		margin-right: 10px;
	}

	.dropdown-item:hover i {
		color: #0d6efd;
	}

	.dropdown-item::after {
		content: '';
		position: absolute;
		left: 16px;
		bottom: 10px;
		width: calc(100% - 32px);
		height: 1px;
		background-color: #0d6efd;
		transform: scaleX(0);
		transform-origin: left;
		transition: transform 0.3s ease;
	}

	.dropdown-item:hover::after {
		transform: scaleX(1);
	}

	.dropdown-item.active,
	.dropdown-item:active {
		background-color: #e9f5ff;
		color: #0a58ca;
	}

	.nav-link {
		position: relative;
	}

	.nav-link::after {
		content: '';
		position: absolute;
		left: 0;
		bottom: 0;
		width: 0;
		height: 2px;
		background-color: #0d6efd;
		transition: width 0.25s ease;
	}

	.nav-link:hover::after {
		width: 100%;
	}
</style>