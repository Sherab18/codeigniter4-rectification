<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Documents | Bhutan Power System Operator
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

    .animate-delay-8 {
        animation-delay: 1.6s;
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
        <div class="row">
            <div class="col-md-12">
                <div class="text-center mb-5 py-3 bg-gradient-primary rounded shadow parallelogram-container">
                    <h3 class="fw-bold">Documents</h3>
                    <p class="lead mb-0">Access and download important documents</p>
                </div>

                <div class="row">
                    <?php
                    $documents = [
                        [
                            'title' => 'Job Application Form',
                            'file' => 'Job_application_form.pdf',
                            'icon' => 'bi-file-earmark-text'
                        ],
                        [
                            'title' => 'Annual Outage Plan_2026(BPSO) Final(31-Dec-2025) Circulation',
                            'file' => 'Annual_Outage_Plan_2026(BPSO)_Final(31-Dec-2025)_Circulation.pdf',
                            'icon' => 'bi-calendar-event'
                        ],
                        [
                            'title' => 'Form Test Charging of New Elements (Amended Format - 2020)',
                            'file' => 'Form_test_charging_of_new_element.pdf',
                            'icon' => 'bi-file-earmark-text'
                        ],
                        [
                            'title' => 'Shutdown Form',
                            'file' => 'Shutdown-Form-NLDC-2.pdf',
                            'icon' => 'bi-file-earmark-pdf'
                        ],
                        [
                            'title' => 'Event Information Form',
                            'file' => 'Event-Information-Report-EIR.xlsx',
                            'icon' => 'bi-file-earmark-spreadsheet'
                        ],
                        [
                            'title' => 'Bhutan Power System Contingency Plan - Revision 2',
                            'file' => 'Bhutan_Power_System_Contingency_Plan_Revision.pdf',
                            'icon' => 'bi-file-earmark-richtext'
                        ],
                        [
                            'title' => 'Typical IO List',
                            'file' => 'Typical-IO-list.pdf',
                            'icon' => 'bi-list-task'
                        ],
                        [
                            'title' => 'SOP for New Connection to the Existing Grid - 54th OCC',
                            'file' => 'SOP_fornewconnectiontotheexistingGrid54th-OCC.pdf',
                            'icon' => 'bi-file-earmark-arrow-up'
                        ],
                        [
                            'title' => 'Operationalization of Grid Code Regulation',
                            'file' => 'OPERATIONALIZATION-OF-GRID-CODE-REGULATION.pdf',
                            'icon' => 'bi-file-earmark-ruled'
                        ]
                    ];

                    foreach ($documents as $index => $document) :
                        $delayClass = 'animate-delay-' . ($index + 1);
                    ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 hover-effect animate__animated animate__fadeInUp <?= $delayClass ?>">
                                <div class="card-body text-center">
                                    <i class="bi <?= $document['icon'] ?> display-4 text-primary mb-3"></i>
                                    <h5 class="card-title"><?= $document['title'] ?></h5>
                                    <a class="btn btn-outline-primary mt-3" href="<?= esc(base_url() . '/uploads/documents/' . $document['file']) ?>" role="button" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</main><br>

<?= $this->endSection() ?>