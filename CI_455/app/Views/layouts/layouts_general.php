<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Official web application for Bhutan Power System Operator">
    <meta name="keywords" content="BPSO, Bhutan Power, Energy, Power System, Bhutan">
    <meta name="author" content="Bhutan Power System Operator">
    <title><?= $this->renderSection('title') ?></title>

    <link rel="icon" href="<?= base_url('assets/img/bpso_logo.png') ?>" sizes="32x32">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" 
          rel="stylesheet"
          crossorigin="anonymous">

    <!-- Bootstrap Icons 1.10.5 -->
    <link rel="stylesheet" 
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
          integrity="sha384-yB2CbdA8P/GneUjE76aX4B304/Lp4e5K4N1Z7mU/XW8n7E6fQ1B" 
          crossorigin="anonymous">

    <!-- DataTables 2.2.1 CSS -->
    <link rel="stylesheet" 
          href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css"
          integrity="sha384-934X1pU0G+O13jH89Y9e4q21O/U8I3c" 
          crossorigin="anonymous">

    <!-- FontAwesome 6.4.0 -->
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- jQuery 3.7.1 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <!-- DataTables 2.2.1 JS -->
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"
            integrity="sha384-297u41N103P/K9U/jZ8c+8S6b0A" 
            crossorigin="anonymous"></script>

    <style>
        :root {
            --bpso-primary: #0d6efd;
            --bpso-secondary: #6c757d;
            --bpso-success: #198754;
            --bpso-light: #f8f9fa;
            --bpso-dark: #212529;
        }

        body {
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }

        .bpso-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
        }

        .bpso-footer {
            background-color: #f8f9fa;
            padding-top: 2rem;
            padding-bottom: 1rem;
        }

        .card-header-bpso {
            background-color: rgb(243, 247, 245);
            font-weight: 600;
        }

        .contact-icon {
            width: 24px;
            text-align: center;
            margin-right: 10px;
            color: var(--bpso-primary);
        }

        .responsive-iframe {
            width: 100%;
            height: 300px;
            border: 0;
        }

        .list-group-item-action:hover {
            background-color: #e9ecef;
        }

        .copyright {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .bpso-divider {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin: 1.5rem 0;
        }
    </style>
</head>

<body>
    <?= $this->renderSection('navbar') ?>

    <main class="container py-4">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bpso-footer mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header card-header-bpso text-center py-3">
                            <strong>Site Map</strong>
                        </div>
                        <div class="card-body p-0">
                            <iframe
                                title="Bhutan Power System Operator Location Map"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17097.917722060833!2d89.62898612022404!3d27.428251880615115!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39e1930028378699%3A0xfbc08e28bfd8355c!2sBhutan%20Power%20System%20Operator!5e1!3m2!1sen!2sbt!4v1773029977688!5m2!1sen!2sbt"
                                width="100%"
                                height="300"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header card-header-bpso text-center py-3">
                            <strong>Contact Us</strong>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-geo-alt-fill contact-icon" aria-hidden="true"></i>
                                <div>Wangchu Taba Junction, Babesa, Thimphu, Bhutan.</div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-telephone-fill contact-icon" aria-hidden="true"></i>
                                <div>+975-02335631 (Control Room)<br>+975-02335632 (Office)</div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-phone-fill contact-icon" aria-hidden="true"></i>
                                <div>+975 17129094<br>+975 77119094 (Control Room)</div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="bi bi-envelope-fill contact-icon" aria-hidden="true"></i>
                                <div>controlroom@bpso.bt<br>office@bpso.bt</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header card-header-bpso text-center py-3">
                            <strong>Useful Links</strong>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="https://www.bpc.bt/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Bhutan Power Corporation Limited
                            </a>
                            <a href="https://www.drukgreen.bt/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Druk Green Power Corporation Limited
                            </a>
                            <a href="https://www.moenr.gov.bt/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Ministry of Energy and Natural Resources
                            </a>
                            <a href="https://era.gov.bt/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Electricity Regulatory Authority
                            </a>
                            <a href="https://posoco.in/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Grid Controller of India Limited
                            </a>
                            <a href="https://erpc.gov.in/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Eastern Regional Power Committee
                            </a>
                            <a href="https://www.iexindia.com/" class="list-group-item list-group-item-action d-flex align-items-center" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-link-45deg me-2" aria-hidden="true"></i>
                                Indian Energy Exchange Limited
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bpso-divider"></div>

            <div class="text-center py-3">
                <p class="copyright mb-0">Bhutan Power System Operator &copy; <?= date('Y') ?>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>