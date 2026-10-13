<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Governance Committee | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .fade-in {
        animation: fadeIn 1s ease-in;
    }

    .slide-up {
        animation: slideUp 0.8s ease-out;
    }

    .hover-grow {
        transition: transform 0.3s ease;
    }

    .hover-grow:hover {
        transform: scale(1.03);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .profile-img {
        transition: all 0.3s ease;
        border: 3px solid #f8f9fa;
    }

    .profile-img:hover {
        border-color: #0d6efd;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
</style>

<main class="py-5">
    <div class="container">
        <section id="governance-committee" class="fade-in">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold title-underline">Governance Committee</h2>
            </div>

            <div class="row justify-content-center mb-5 slide-up">
                <div class="col-md-8 col-lg-6">
                    <div class="card border-0 shadow-sm hover-grow">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-4" style="width: 180px; height: 180px;">
                                <img src="<?= base_url('assets/board/1Karma-P-Dorji-PCD.png') ?>"
                                    class="profile-img img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                    alt="Chairperson, Mr. Karma P Dorji">
                            </div>
                            <h4 class="card-title fw-bold text-primary">Chairperson</h4>
                            <h5 class="mb-2">Mr. Karma P Dorji</h5>
                            <p class="card-text text-muted">Director General, Department of Energy<br>Ministry of Energy & Natural Resources</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center g-4">
                <div class="col-md-6 col-lg-3 slide-up" style="animation-delay: 0.2s">
                    <div class="card border-0 shadow-sm h-100 hover-grow">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-4" style="width: 150px; height: 175px;">
                                <img src="<?= base_url('assets/board/thuktenwangmo.png') ?>"
                                    class="profile-img img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                    alt="Ms. Thukten Wangmo">
                            </div>
                            <h5 class="card-title fw-bold text-primary">Member</h5>
                            <h6 class="mb-2">Mrs. Thukten Wangmo</h6>
                            <p class="card-text text-muted">Chief, Licensing & Technical Division<br>Electricity Regulatory Authority</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 slide-up" style="animation-delay: 0.4s">
                    <div class="card border-0 shadow-sm h-100 hover-grow">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-4" style="width: 150px; height: 175px;">
                                <img src="<?= base_url('assets/board/SujanRai.png') ?>"
                                    class="profile-img img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                    alt="Mr. Yeshi Tenzin">
                            </div>
                            <h5 class="card-title fw-bold text-primary">Member</h5>
                            <h6 class="mb-2">Mr. Sujan Rai</h6>
                            <p class="card-text text-muted">Director, Operation & Maintenance Department<br>Druk Green Power Corporation</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 slide-up" style="animation-delay: 0.6s">
                    <div class="card border-0 shadow-sm h-100 hover-grow">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-4" style="width: 150px; height: 175px;">
                                <img src="<?= base_url('assets/board/directorTS.png') ?>"
                                    class="profile-img img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                    alt="Mr. Thinley Gyeltshen">
                            </div>
                            <h5 class="card-title fw-bold text-primary">Member</h5>
                            <h6 class="mb-2">Mr. Thinley Gyeltshen</h6>
                            <p class="card-text text-muted">Director, Distribution Department<br>Bhutan Power Corporation</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 slide-up" style="animation-delay: 0.8s">
                    <div class="card border-0 shadow-sm h-100 hover-grow">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto mb-4" style="width: 150px; height: 175px;">
                                <img src="<?= base_url('assets/board/CEO.JPG') ?>"
                                    class="profile-img img-fluid rounded-circle w-100 h-100 object-fit-cover"
                                    alt="Member Secretary">
                            </div>
                            <h5 class="card-title fw-bold text-primary">Member Secretary</h5>
                            <h6 class="mb-2">Chief Executive Officer</h6>
                            <p class="card-text text-muted">Bhutan Power System Operator</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.slide-up').forEach(el => {
            observer.observe(el);
        });
    });
</script>
<?= $this->endSection() ?>