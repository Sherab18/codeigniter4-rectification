<?= $this->extend('layouts/layouts_login') ?>

<?= $this->section('title') ?>
Register | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?><br>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-lg border-0 mt-5">
					<div class="card-header bg-primary text-white text-center">
						<h3>Register User</h3>
					</div>
					<div class="card-body p-4">
						<form action="<?= base_url('users/register') ?>" method="post">
							<?= csrf_field(); ?>

							<?php if (isset($validation)): ?>
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?= $validation->listErrors(); ?>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							<?php endif; ?>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="firstName" class="form-label">First Name</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-person"></i></span>
										<input type="text" class="form-control" id="firstName" name="given_name" value="<?= old('given_name'); ?>" required placeholder="Enter your first name">
									</div>
								</div>
								<div class="col-md-6">
									<label for="lastName" class="form-label">Last Name</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-person"></i></span>
										<input type="text" class="form-control" id="lastName" name="last_name" value="<?= old('last_name'); ?>" required placeholder="Enter your last name">
									</div>
								</div>
							</div>

							<div class="mb-3">
								<label for="sex" class="form-label">Sex</label>
								<select class="form-select" id="sex" name="sex" required>
									<option value="" disabled <?= old('sex') === '' ? 'selected' : ''; ?>>Select your option</option>
									<option value="male" <?= old('sex') === 'male' ? 'selected' : ''; ?>>Male</option>
									<option value="female" <?= old('sex') === 'female' ? 'selected' : ''; ?>>Female</option>
									<option value="other" <?= old('sex') === 'other' ? 'selected' : ''; ?>>Other</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="mobile" class="form-label">Mobile Number</label>
								<div class="input-group">
									<span class="input-group-text"><i class="bi bi-phone"></i></span>
									<input type="text" class="form-control" id="mobile" name="mobile" value="<?= old('mobile'); ?>" required placeholder="Enter your mobile number">
								</div>
							</div>

							<div class="mb-3">
								<label for="email" class="form-label">Email</label>
								<div class="input-group">
									<span class="input-group-text"><i class="bi bi-envelope"></i></span>
									<input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>" required placeholder="Enter your email">
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="password" class="form-label">Password</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-lock"></i></span>
										<input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
									</div>
								</div>
								<div class="col-md-6">
									<label for="confirmPassword" class="form-label">Confirm Password</label>
									<div class="input-group">
										<span class="input-group-text"><i class="bi bi-lock"></i></span>
										<input type="password" class="form-control" id="confirmPassword" name="confirm_pass" required placeholder="Confirm your password">
									</div>
								</div>
							</div>

							<div class="d-grid justify-content-start">
								<button type="submit" class="btn btn-outline-primary">Signup</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main><br>
<?= $this->endSection() ?>