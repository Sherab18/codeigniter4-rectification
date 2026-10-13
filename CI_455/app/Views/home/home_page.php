<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Home | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
        <div class="container">
                <div class="row">
                        <?php if (session()->getTempdata('many_attempts')): ?>
                                <div class="alert alert-danger">
                                        <?= esc(session()->getTempdata('many_attempts')) ?>
                                </div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                                <div class="alert alert-warning">
                                        <?= esc($error) ?>
                                </div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                                <div class="alert alert-success">
                                        <?= esc($success) ?>
                                </div>
                        <?php endif; ?>
                </div>
                <div class="col-12 mb-4">
                        <div class="card-body">
                                <?= $this->include('energydata/latestenergydata') ?>
                        </div>
                </div>
                <div class="col-md-12">
                        <?= $this->include('home/carousel') ?>
                </div>

                <div class="col-md-12">
                        <?= $this->include('home/resource') ?>
                </div>
                <hr>

                <div class="row mt-4">
                        <div class="col-md-8 mb-4 mb-md-0">
                                <?= $this->include('home/tab_bar') ?>
                        </div>

                        <div class="col-md-4">
                                <div class="sticky-top" style="top: 20px;">
                                        <?= $this->include('home/latest_news') ?>
                                </div>
                        </div>
                </div>
                
                <style>
                        .hover-effect {
                                transition: transform 0.3s ease, box-shadow 0.3s ease;
                        }

                        .hover-effect:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
                        }

                        .card {
                                border: none;
                                border-radius: 10px;
                        }

                        .card-title {
                                font-size: 1.25rem;
                                font-weight: 600;
                        }

                        .display-4 {
                                font-size: 2.5rem;
                                font-weight: bold;
                        }
                </style>
        </div>
</main>
<?= $this->endSection() ?>