<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Web Application for BPSO">
    <title><?= $this->renderSection('title') ?></title>

    <link rel="icon" href="<?= base_url('assets/img/bpso_logo.png') ?>" sizes="32x32">

    <!-- Bootstrap 5.3.3 CSS with Subresource Integrity (SRI) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

    <!-- Bootstrap Icons 1.10.5 CSS with Subresource Integrity (SRI) -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        integrity="sha384-yB2CbdA8P/GneUjE76aX4B304/Lp4e5K4N1Z7mU/XW8n7E6fQ1B"
        crossorigin="anonymous">

    <!-- Bootstrap 5.3.3 JS Bundle with Subresource Integrity (SRI) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body style="background:#ffffff;">
    <?= $this->renderSection('navbar') ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>
</body>

</html>