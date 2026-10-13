<?php
$loginInfo  = session()->get('login_info');
$userAvatar = $loginInfo['avatar'] ?? null;

if (!empty($userAvatar) && file_exists(FCPATH . 'assets/uploads/avatars/' . $userAvatar)) {
	// Appending time() forces the browser to fetch the newly uploaded image file
	$headerAvatarUrl = base_url('assets/uploads/avatars/' . $userAvatar) . '?v=' . time();
} else {
	$headerAvatarUrl = base_url('assets/img/avatar_0.jpg');
}
?>

<header style="background-color: #f5f7f6;">
	<div class="container px-0">
		<nav class="navbar navbar-expand-lg" style="background-color: #f5f7f6;">
			<div class="container-fluid px-3">
				<div class="d-flex align-items-center">
					<a class="navbar-brand d-flex align-items-center fw-medium">
						<img src="<?= base_url() ?>assets/img/bpso_logo.png"
							alt="BPSO System Logo"
							width="120"
							height="120"
							class="me-2">
					</a>
				</div>

				<button class="navbar-toggler"
					type="button"
					data-bs-toggle="collapse"
					data-bs-target="#mainNavigation"
					aria-controls="mainNavigation"
					aria-expanded="false"
					aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse justify-content-md-center mt-2 mt-lg-0" id="mainNavigation">
					<ul class="navbar-nav nav-pills">

						<!-- Uploads Dropdown -->
						<li class="nav-item dropdown mx-1">
							<a class="nav-link dropdown-toggle text-primary d-flex align-items-center py-2 px-3"
								id="uploadsDropdown"
								href="#"
								role="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
								<i class="fas fa-folder-plus fa-fw me-2"></i>
								<span>UPLOADs</span>
							</a>
							<ul class="dropdown-menu shadow border-0" aria-labelledby="uploadsDropdown">
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>bpso/news/">
										<i class="fas fa-newspaper fa-fw me-2 text-secondary"></i>
										Annnouncement
									</a>
								</li>
								<li>
									<hr class="dropdown-divider my-1">
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>reports/report_list">
										<i class="fas fa-file-alt fa-fw me-2"></i>
										Reports
									</a>
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>documents">
										<i class="fas fa-file-contract fa-fw me-2"></i>
										CODs
									</a>
								</li>
								<li>
									<hr class="dropdown-divider my-1">
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>admin/tenders">
										<i class="fas fa-file-contract fa-fw me-2"></i>
										Tender
									</a>
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>career/vacancies">
										<i class="fas fa-file-contract fa-fw me-2"></i>
										Career | Vacancy
									</a>
								</li>
							</ul>
						</li>

						<!-- Power System Records Dropdown -->
						<li class="nav-item dropdown mx-1">
							<a class="nav-link dropdown-toggle text-primary d-flex align-items-center py-2 px-3"
								id="powerSystemDropdown"
								href="#"
								role="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
								<i class="fas fa-bolt fa-fw me-2"></i>
								<span>Power System Records</span>
							</a>
							<ul class="dropdown-menu shadow border-0" aria-labelledby="powerSystemDropdown">
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>powerdata/list_energy">
										<i class="fas fa-chart-line fa-fw me-2 text-secondary"></i>
										Energy Data
									</a>
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>bhutan">
										<i class="fas fa-chart-line fa-fw me-2 text-secondary"></i>
										Power Utilities Data
									</a>
								</li>
								<li>
									<hr class="dropdown-divider my-1">
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>stations/list stations">
										<i class="fas fa-industry fa-fw me-2 text-secondary"></i>
										Stations
									</a>
								</li>
							</ul>
						</li>

						<!-- Operator Records Dropdown -->
						<li class="nav-item dropdown mx-1">
							<a class="nav-link dropdown-toggle text-primary d-flex align-items-center py-2 px-3"
								id="operatorRecordsDropdown"
								href="#"
								role="button"
								data-bs-toggle="dropdown"
								aria-expanded="false">
								<i class="fas fa-clipboard-list fa-fw me-2"></i>
								<span>Shift Operator Records</span>
							</a>
							<ul class="dropdown-menu shadow border-0" aria-labelledby="operatorRecordsDropdown">
								<li>
									<a class="dropdown-item d-flex align-items-center py-2"
										href="<?= base_url() ?>tickets/list_tickets/all/all">
										<i class="fas fa-ticket-alt fa-fw me-2 text-secondary"></i>
										Tickets
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>

				<!-- User Profile Dropdown -->
				<div class="dropdown ms-auto">
					<a class="d-flex align-items-center text-decoration-none dropdown-toggle"
						id="userMenuDropdown"
						href="#"
						role="button"
						data-bs-toggle="dropdown"
						aria-expanded="false">
						<div class="position-relative">
							<!-- Dynamic Avatar Image -->
							<img src="<?= $headerAvatarUrl ?>"
								alt="User profile"
								width="40"
								height="40"
								class="rounded-circle border border-2 border-primary object-fit-cover">
							<span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle">
								<span class="visually-hidden">Online status</span>
							</span>
						</div>
					</a>
					<ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userMenuDropdown">
						<li>
							<a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url('auth/change-password') ?>">
								<i class="fas fa-key fa-fw me-2 text-muted"></i>
								<span>Reset Password</span>
							</a>
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center py-2" href="<?= base_url('auth/edit-profile') ?>">
								<i class="fas fa-user-edit fa-fw me-2 text-muted"></i>
								<span>Edit Profile</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider my-1">
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center py-2 text-danger" href="<?= base_url('users/logout') ?>">
								<i class="fas fa-sign-out-alt fa-fw me-2"></i>
								<span>Sign Out</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>
</header>