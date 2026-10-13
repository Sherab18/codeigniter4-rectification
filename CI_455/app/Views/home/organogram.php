<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Organogram | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="py-5">
                    <div class="text-center mb-5">
                        <h2 class="display-5 fw-bold title-underline">Organization Structure</h2>
                    </div>
                    <div class="org-chart animate__animated animate__fadeIn">
                        <div class="org-level">
                            <div class="d-flex flex-column align-items-center">
                                <div class="org-node card bg-danger text-dark shadow-lg" style="max-width: 20rem;">
                                    <div class="card-body text-center">
                                        <i class="material-icons md-36">groups</i>
                                        <h5 class="mt-2 mb-0 text-dark">Governance Committee</h5>
                                    </div>
                                </div>
                                <div class="org-connector"></div>
                            </div>
                        </div>

                        <div class="org-level">
                            <div class="d-flex flex-column align-items-center">
                                <div class="org-node card bg-info text-dark shadow-lg" style="max-width: 20rem;">
                                    <div class="card-body text-center">
                                        <i class="material-icons md-36">person</i>
                                        <h5 class="mt-2 mb-0 text-dark">Chief Executive Officer</h5>
                                    </div>
                                </div>
                                <div class="org-connector"></div>
                            </div>
                        </div>

                        <div class="org-level d-flex justify-content-center align-items-start">
                            <div class="org-unit animate__animated animate__fadeInLeft">
                                <div class="org-node card bg-success text-dark shadow-lg">
                                    <div class="card-body text-center">
                                        <i class="material-icons md-36">engineering</i>
                                        <h5 class="mt-2">Chief Engineer</h5>
                                        <p class="mb-0">Power System Operator Division (PSOD)</p>
                                    </div>
                                </div>
                                <div class="org-connector"></div>
                                <div class="org-subunits">
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-1s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;">System Analyst Unit (SA)</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-2s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;" >System Operation Unit (SO)</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-3s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;">Market Operation Unit (MO)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="org-unit animate__animated animate__fadeInUp">
                                <div class="org-node card bg-success text-dark shadow-lg">
                                    <div class="card-body text-center">
                                        <i class="material-icons md-36">engineering</i>
                                        <h5 class="mt-2">Chief Engineer</h5>
                                        <p class="mb-0">Engineering & Communication Division (E&CD)</p>
                                    </div>
                                </div>
                                <div class="org-connector"></div>
                                <div class="org-subunits">
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-1s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;">SCADA & Telemetry Unit (S&T)</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-2s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;">Communication Unit (COM)</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-3s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #CBC1AE;">Core System Engineering Unit (CSE)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="org-unit animate__animated animate__fadeInRight" style="margin-top: 30px;">
                                <div class="org-node card shadow-lg" style="background-color: #CBC1AE;">
                                    <div class="card-body text-center">
                                        <i class="material-icons md-36">person</i>
                                        <h5 class="mt-2">Manager</h5>
                                        <p class="mb-0">Support Service Unit</p>
                                    </div>
                                </div>
                                <div class="org-connector"></div>
                                <div class="org-subunits">
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-1s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #708090;">Finance Service</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-2s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #708090;">Human Resource Service</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-3s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #708090;">IT Service</div>
                                        </div>
                                    </div>
                                    <div class="org-subunit animate__animated animate__fadeInUp animate__delay-4s">
                                        <div class="card shadow-sm">
                                            <div class="card-body" style="background-color: #708090;">Procurement & Asset Management</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .org-chart {
        position: relative;
        transition: all 0.3s ease;
    }

    .org-level {
        margin-bottom: 30px;
        position: relative;
        display: flex;
        justify-content: center;
    }

    .org-node {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px !important;
        margin: 0 auto;
    }

    .org-node:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .org-connector {
        width: 2px;
        height: 20px;
        background-color: #6c757d;
        margin: 0 auto;
    }

    .org-unit {
        padding: 0 15px;
        position: relative;
        flex: 1;
        max-width: 350px;
    }

    .org-subunits {
        margin-top: 20px;
    }

    .org-subunit {
        margin-bottom: 10px;
    }

    .org-subunit .card {
        border-radius: 6px !important;
        transition: all 0.3s ease;
    }

    .org-subunit .card:hover {
        transform: translateX(5px);
        background-color: #f8f9fa !important;
    }

    .title-underline {
        position: relative;
        display: inline-block;
    }

    .title-underline::after {
        content: '';
        position: absolute;
        width: 50%;
        height: 3px;
        bottom: -10px;
        left: 25%;
        background: #0d6efd;
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .title-underline:hover::after {
        transform: scaleX(1);
    }

    @media (max-width: 992px) {
        .org-level.d-flex {
            flex-direction: column;
            align-items: center;
        }

        .org-unit {
            margin-bottom: 30px;
            max-width: 100%;
        }

        .org-unit:last-child {
            margin-top: 0 !important;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<script>
    $(document).ready(function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    if (element.classList.contains('org-node')) {
                        element.classList.add('animate__pulse');
                    }
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.org-node, .org-subunit').forEach(el => {
            observer.observe(el);
        });
    });
</script>
<?= $this->endSection() ?>