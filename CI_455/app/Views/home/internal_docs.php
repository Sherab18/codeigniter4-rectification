<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Internal Documents | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    .parallelogram-container {
        position: relative;
        transform: skew(-20deg);
        overflow: hidden;
        margin: 0 auto;
        width: 80%;
    }

    .parallelogram-container h3,
    .parallelogram-container p {
        transform: skew(20deg);
        display: inline-block;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #007bff, #00bcd4);
        color: white;
    }

    .hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .hover-effect:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .animate-delay-1 {
        animation-delay: 0.2s;
    }

    .animate-delay-2 {
        animation-delay: 0.4s;
    }

    .animate-delay-3 {
        animation-delay: 0.6s;
    }

    .animate-delay-4 {
        animation-delay: 0.8s;
    }

    .animate-delay-5 {
        animation-delay: 1s;
    }

    .animate-delay-6 {
        animation-delay: 1.2s;
    }

    .animate-delay-7 {
        animation-delay: 1.4s;
    }

    .btn-outline-primary {
        border-color: white;
    }

    .btn-outline-primary:hover {
        border: #007bff;
    }
</style>

<main>
    <div class="container">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="text-center mb-5 py-3 bg-gradient-primary rounded shadow parallelogram-container">
                    <h3 class="fw-bold">Internal Documents</h3>
                    <p class="lead mb-0">Access and download important internal documents</p>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $files = [
                'BPSO_SRR_2025_amendment_of_2023.pdf',
                'Laptop_Purchase_Agreement_Form.pdf',
                'Laptop_Co-Purchase_Guideline_signed.pdf',
                'DoP_2025_signed.pdf',
                'Vehicle_Requisition_Form.pdf',
                'Salary_Advance_Form.pdf',
                'Probation_Completion_Form.pdf',
                'Normal_Promotion_Form.pdf',
                'Leave_Form.pdf',
                'Leave_Encashment_Form.pdf',
                'Staff_Requisition_Form.pdf',
            ];

            $animationDelays = ['animate-delay-1', 'animate-delay-2', 'animate-delay-3', 'animate-delay-4', 'animate-delay-5', 'animate-delay-6', 'animate-delay-7'];

            foreach ($files as $index => $file): ?>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100 hover-effect animate__animated animate__fadeInUp <?= $animationDelays[$index] ?? '' ?>">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-pdf display-4 text-primary mb-3"></i>
                            <h6 class="card-title"><?= str_replace('_', ' ', pathinfo($file, PATHINFO_FILENAME)) ?></h6>
                            <button class="btn btn-outline-primary w-100" onclick="openModal('<?= $file ?>')">
                                <i class="bi bi-download me-2"></i>Download
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="passwordModalLabel">Enter Password</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="password" id="filePassword" class="form-control" placeholder="Enter password">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="downloadFile()">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><br>

<script>
    let selectedFile = '';

    function openModal(file) {
        selectedFile = file;
        const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
        passwordModal.show();
    }

    const togglePassword = document.querySelector('#togglePassword');
    const passwordField = document.querySelector('#filePassword');

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        if (type === 'text') {
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        } else {
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        }
    });

    function downloadFile() {
        const password = document.getElementById('filePassword').value;
        const staticPassword = 'BPSO@2024!';

        if (password === staticPassword) {
            window.location.href = `<?= base_url('forms/downloads/') ?>${selectedFile}?password=${staticPassword}`;
        } else {
            alert('Invalid password. Please try again.');
        }
    }
</script>

<?= $this->endSection() ?>