<?= $this->extend('layouts/layouts_general') ?>

<?= $this->section('title') ?>
Public Reports | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_general') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* ---------- One shared look for every block on this page ---------- */
    .rp-stack   { display: grid; gap: 1.5rem; }              /* equal spacing between dashboard and table */
    .rp-panel   { background: #fff; border-radius: 16px; overflow: hidden;
                  box-shadow: 0 8px 30px rgba(10, 40, 90, .12); min-width: 0; }

    /* ---------- Tabs ---------- */
    .rp-tabs     { display: flex; gap: .4rem; padding: .35rem; margin-bottom: 1.25rem; width: max-content; max-width: 100%;
                   background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(10, 40, 90, .08); }
    .rp-tab      { display: flex; align-items: center; gap: .5rem; border: 0; background: transparent; cursor: pointer;
                   padding: .65rem 1.25rem; border-radius: 10px; font-weight: 700; font-size: .95rem; color: #14306b; white-space: nowrap; }
    .rp-tab:hover { background: #eef4fb; }
    .rp-tab[aria-selected="true"] { color: #fff; background: linear-gradient(180deg, #245aa3, #173f78); box-shadow: 0 2px 8px rgba(23, 63, 120, .35); }
    .rp-tab:focus-visible { outline: 3px solid rgba(29, 75, 140, .45); outline-offset: 2px; }
    .rp-tab .rp-pill { font-size: .72rem; font-weight: 700; padding: .1em .55em; border-radius: 999px; background: rgba(20, 48, 107, .12); }
    .rp-tab[aria-selected="true"] .rp-pill { background: rgba(255, 255, 255, .25); }
    .rp-tabpanel[hidden] { display: none !important; }
    @media (max-width: 480px) { .rp-tabs { width: 100%; } .rp-tab { flex: 1; justify-content: center; padding: .65rem .5rem; } }

    /* ---------- Date toolbar above the dashboard ---------- */
    .rp-toolbar  { display: flex; flex-wrap: wrap; align-items: center; gap: .6rem .9rem; padding: .85rem 1.1rem;
                   background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(10, 40, 90, .08); }
    .rp-toolbar .rp-tl { font-weight: 700; color: #14306b; display: flex; align-items: center; gap: .45rem; }
    .rp-toolbar form  { display: flex; align-items: center; gap: .4rem; margin: 0; }
    .rp-toolbar input[type=date] { height: 2.4rem; border: 1.5px solid #cfe0f1; border-radius: 8px; padding: 0 .6rem; font: inherit; color: #14306b; background: #fff; }
    .rp-toolbar input[type=date]:focus { outline: 0; border-color: #1d4b8c; box-shadow: 0 0 0 .2rem rgba(29, 75, 140, .15); }
    .rp-nav      { display: inline-flex; align-items: center; justify-content: center; gap: .35rem; height: 2.4rem; padding: 0 .9rem; border-radius: 8px;
                   font-weight: 600; font-size: .9rem; text-decoration: none; white-space: nowrap;
                   color: #1d4b8c; background: #eef4fb; border: 1.5px solid #cfe0f1; }
    .rp-nav:hover { background: #dfeaf7; color: #14306b; }
    .rp-nav.is-disabled { opacity: .45; pointer-events: none; }
    .rp-nav.is-primary  { color: #fff; background: #1d4b8c; border-color: #1d4b8c; }
    .rp-nav.is-primary:hover { background: #173f78; }
    .rp-toolbar .rp-spacer { flex: 1 1 auto; }
    .rp-toolbar .rp-hint   { font-size: .85rem; color: #4a5b6c; }

    /* ---------- Reports panel ---------- */
    .rp-head    { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
                  padding: .95rem 1.4rem; color: #fff;
                  background: linear-gradient(180deg, #245aa3, #173f78); }
    .rp-head h5 { margin: 0; font-weight: 700; font-size: 1.1rem; }
    .rp-head .rp-count { font-size: .85rem; opacity: .85; }
    .rp-body    { padding: 1.25rem 1.4rem 1.4rem; }

    .rp-filter  { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto; gap: .75rem; margin-bottom: 1.25rem; }
    .rp-filter .form-select, .rp-filter .form-control { height: 2.6rem; border: 1.5px solid #cfe0f1; border-radius: 8px; }
    .rp-filter .form-select:focus, .rp-filter .form-control:focus { border-color: #1d4b8c; box-shadow: 0 0 0 .2rem rgba(29, 75, 140, .15); }
    .rp-filter .btn { height: 2.6rem; padding: 0 1.4rem; border-radius: 8px; font-weight: 600; white-space: nowrap;
                      color: #fff; background: #1d4b8c; border: 0; }
    .rp-filter .btn:hover { background: #173f78; color: #fff; }
    @media (max-width: 640px) { .rp-filter { grid-template-columns: 1fr; } }

    /* table */
    .rp-table              { width: 100% !important; margin: 0; border-collapse: separate; border-spacing: 0; }
    .rp-table thead th     { background: #eef4fb; color: #14306b; font-weight: 700; font-size: .9rem; white-space: nowrap;
                             padding: .8rem .9rem; border-bottom: 2px solid #cfe0f1; }
    .rp-table tbody td     { padding: .75rem .9rem; vertical-align: middle; border-bottom: 1px solid #e8eff7; }
    .rp-table tbody tr:hover td { background: #f6faff; }
    .rp-table .col-type    { width: 1%;  white-space: nowrap; }
    .rp-table .col-date    { width: 1%;  white-space: nowrap; }
    .rp-table .col-actions { width: 1%;  white-space: nowrap; text-align: right; }
    .rp-file               { max-width: 0; width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }  /* long names get "…" instead of widening the table */

    .rp-badge          { display: inline-block; padding: .3em .8em; border-radius: 999px; font-size: .78rem; font-weight: 700; }
    .rp-badge.daily     { background: #e3eefb; color: #1d4b8c; }
    .rp-badge.quarterly { background: #e2f3e7; color: #0f7a3a; }
    .rp-badge.annual    { background: #efe6fb; color: #5b2aa8; }

    .rp-actions        { display: inline-flex; gap: .4rem; flex-wrap: nowrap; }
    .rp-actions .btn   { padding: .32rem .75rem; font-size: .85rem; font-weight: 600; border-radius: 8px; white-space: nowrap; }

    /* DataTables controls: line them up with the table edges */
    .rp-body .dataTables_wrapper .row    { margin-left: 0; margin-right: 0; align-items: center; }
    .rp-body .dataTables_wrapper .row > * { padding-left: 0; padding-right: 0; }
    .rp-body .dataTables_length          { margin-bottom: .9rem; }
    .rp-body .dataTables_filter          { margin-bottom: .9rem; text-align: right; }
    .rp-body .dataTables_filter input    { width: min(100%, 260px); margin-left: 0; border: 1.5px solid #cfe0f1; border-radius: 8px; padding: .35rem .7rem; }
    .rp-body .dataTables_length select  { border: 1.5px solid #cfe0f1; border-radius: 8px; padding: .25rem .5rem; }
    .rp-body .dataTables_info            { padding-top: 1rem; color: #4a5b6c; font-size: .88rem; }
    .rp-body .dataTables_paginate        { padding-top: .75rem; }
    .rp-body .dataTables_paginate .pagination { justify-content: flex-end; margin: 0; }

    .rp-empty { display: flex; gap: .6rem; align-items: center; padding: 1rem 1.2rem; border-radius: 10px; background: #fff7e6; color: #7a5200; }

    @media (max-width: 640px) {
        .rp-head, .rp-body { padding-left: 1rem; padding-right: 1rem; }
        .rp-actions .lbl { display: none; }          /* icons only on phones so the table does not scroll sideways */
        .rp-table .col-date { display: none; }
    }
</style>

<?php
    // Defaults keep the page working even if a controller does not pass the new variables.
    $tab            = $tab            ?? 'glance';
    $availableDates = $availableDates ?? [];
    $selectedDate   = $selectedDate   ?? ($summary['report_date'] ?? null);
    $glanceMissing  = $glanceMissing  ?? false;
    $olderDate      = $olderDate      ?? null;
    $newerDate      = $newerDate      ?? null;
    $latestDate     = $latestDate     ?? ($availableDates[0] ?? null);
    $requestedDate  = $requestedDate  ?? '';   // the date the visitor typed, even if no report exists for it

    $pageUrl   = base_url('publicdata/report_public');
    $glanceUrl = fn($d) => $pageUrl . '?tab=glance&glance_date=' . urlencode((string) $d);
    $fmtDate   = fn($d) => $d ? date('d M Y', strtotime($d)) : '';
    $minDate   = $availableDates ? end($availableDates) : '';
    $maxDate   = $availableDates ? $availableDates[0] : '';
?>
<main class="py-4">
    <div class="container">

        <!-- Tab buttons -->
        <div class="rp-tabs" role="tablist" aria-label="Public reports sections">
            <button type="button" class="rp-tab" role="tab" id="tab-glance" aria-controls="panel-glance"
                    aria-selected="<?= $tab === 'glance' ? 'true' : 'false' ?>" data-tab="glance">
                <i class="bi bi-speedometer2"></i> System at a Glance
            </button>
            <button type="button" class="rp-tab" role="tab" id="tab-reports" aria-controls="panel-reports"
                    aria-selected="<?= $tab === 'reports' ? 'true' : 'false' ?>" data-tab="reports">
                <i class="bi bi-file-earmark-text"></i> Reports <span class="rp-pill"><?= count($reports ?? []) ?></span>
            </button>
        </div>

        <!-- Tab 1: BPSO Daily System at a Glance (filter by date) -->
        <div class="rp-tabpanel" id="panel-glance" role="tabpanel" aria-labelledby="tab-glance" <?= $tab === 'glance' ? '' : 'hidden' ?>>
            <div class="rp-stack">

                <?php if ($availableDates): ?>
                    <div class="rp-toolbar">
                        <span class="rp-tl"><i class="bi bi-calendar3"></i> Report date</span>

                        <a class="rp-nav <?= $olderDate ? '' : 'is-disabled' ?>" <?= $olderDate ? 'href="' . esc($glanceUrl($olderDate), 'attr') . '"' : 'aria-disabled="true"' ?>
                           title="<?= $olderDate ? 'Go to ' . esc($fmtDate($olderDate)) : 'No earlier report' ?>">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>

                        <form method="GET" action="<?= esc($pageUrl, 'attr') ?>" id="glanceDateForm">
                            <input type="hidden" name="tab" value="glance">
                            <input type="date" name="glance_date" id="glanceDate" aria-label="Report date"
                                   value="<?= esc($glanceMissing ? $requestedDate : (string) $selectedDate, 'attr') ?>"
                                   min="<?= esc($minDate, 'attr') ?>" max="<?= esc($maxDate, 'attr') ?>">
                            <noscript><button type="submit" class="rp-nav is-primary">Show</button></noscript>
                        </form>

                        <a class="rp-nav <?= $newerDate ? '' : 'is-disabled' ?>" <?= $newerDate ? 'href="' . esc($glanceUrl($newerDate), 'attr') . '"' : 'aria-disabled="true"' ?>
                           title="<?= $newerDate ? 'Go to ' . esc($fmtDate($newerDate)) : 'No later report' ?>">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>

                        <?php if ($latestDate && $selectedDate !== $latestDate): ?>
                            <a class="rp-nav is-primary" href="<?= esc($pageUrl . '?tab=glance', 'attr') ?>">Latest (<?= esc($fmtDate($latestDate)) ?>)</a>
                        <?php endif; ?>

                        <span class="rp-spacer"></span>
                        <span class="rp-hint"><?= count($availableDates) ?> day<?= count($availableDates) === 1 ? '' : 's' ?> available
                            (<?= esc($fmtDate($minDate)) ?> – <?= esc($fmtDate($maxDate)) ?>)</span>
                    </div>
                <?php endif; ?>

                <?php if ($glanceMissing): ?>
                    <div class="rp-empty" role="status">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            No daily report with figures was uploaded for <strong><?= esc($fmtDate($requestedDate)) ?></strong>.
                            <?php if ($olderDate): ?> <a href="<?= esc($glanceUrl($olderDate), 'attr') ?>">Go to <?= esc($fmtDate($olderDate)) ?></a><?php endif; ?>
                            <?php if ($olderDate && $newerDate): ?> or <?php endif; ?>
                            <?php if ($newerDate): ?> <a href="<?= esc($glanceUrl($newerDate), 'attr') ?>">go to <?= esc($fmtDate($newerDate)) ?></a><?php endif; ?>.
                        </div>
                    </div>
                <?php elseif (!empty($summary)): ?>
                    <?= $this->include('reports/_daily_glance') ?>
                <?php else: ?>
                    <div class="rp-empty" role="status">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>No daily report with extracted figures has been uploaded yet.</div>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Tab 2: Reports table -->
        <div class="rp-tabpanel" id="panel-reports" role="tabpanel" aria-labelledby="tab-reports" <?= $tab === 'reports' ? '' : 'hidden' ?>>
            <div class="rp-stack">
<section class="rp-panel" aria-label="Public reports">
                <div class="rp-head">
                    <h5><i class="bi bi-file-earmark-text me-2"></i>Public Reports</h5>
                    <span class="rp-count"><?= count($reports ?? []) ?> report<?= count($reports ?? []) === 1 ? '' : 's' ?></span>
                </div>

                <div class="rp-body">
                    <!-- Filter -->
                    <form method="GET" class="rp-filter">
                        <input type="hidden" name="tab" value="reports">
                        <input type="hidden" name="page" value="1">
                        <select name="report_type" class="form-select" aria-label="Report type">
                            <option value="">All Report Types</option>
                            <option value="daily" <?= ($reportType ?? '') === 'daily' ? 'selected' : '' ?>>Daily</option>
                            <option value="quarterly" <?= ($reportType ?? '') === 'quarterly' ? 'selected' : '' ?>>Quarterly</option>
                            <option value="annual" <?= ($reportType ?? '') === 'annual' ? 'selected' : '' ?>>Annual</option>
                        </select>
                        <input type="date" name="upload_date" class="form-control" aria-label="Upload date"
                            value="<?= esc($uploadDate ?? '') ?>">
                        <button type="submit" class="btn"><i class="bi bi-funnel me-1"></i> Filter</button>
                    </form>

                    <?php if (!empty($reports)): ?>
                        <div class="table-responsive">
                            <table class="table rp-table align-middle" id="publicReportTable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-type">Report Type</th>
                                        <th scope="col">File Name</th>
                                        <th scope="col" class="col-date">Upload Date</th>
                                        <th scope="col" class="col-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reports as $report):
                                        $type = strtolower($report['report_type']);
                                        $ts   = strtotime($report['upload_date']); ?>
                                        <tr>
                                            <td class="col-type"><span class="rp-badge <?= esc($type, 'attr') ?>"><?= esc(ucfirst($type)) ?></span></td>
                                            <td class="rp-file" title="<?= esc($report['file_name'], 'attr') ?>"><?= esc($report['file_name']) ?></td>
                                            <!-- data-order makes "04 Aug 2025" sort by real date, not alphabetically -->
                                            <td class="col-date" data-order="<?= date('Y-m-d H:i:s', $ts) ?>"><?= date('d M Y', $ts) ?></td>
                                            <td class="col-actions">
                                                <div class="rp-actions">
                                                    <a href="<?= base_url('reports/report_download/' . $report['id']) ?>" class="btn btn-outline-primary" title="Download">
                                                        <i class="bi bi-download"></i><span class="lbl"> Download</span>
                                                    </a>
                                                    <a href="<?= base_url('reports/report_preview/' . $report['id']) ?>" target="_blank" rel="noopener" class="btn btn-outline-success" title="View">
                                                        <i class="bi bi-eye"></i><span class="lbl"> View</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="rp-empty"><i class="bi bi-exclamation-triangle-fill"></i> No reports found matching your criteria.</div>
                    <?php endif; ?>
                </div>
            </section>
            </div>
        </div>

    </div>
</main>

<script>
    $(document).ready(function() {
        if ($('#publicReportTable').length && $.fn.DataTable) {
            $('#publicReportTable').DataTable({
                autoWidth: false,
                order: [[2, 'desc']],                       // newest first
                columnDefs: [{ orderable: false, targets: 3 }],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search reports...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "<i class='bi bi-chevron-left'></i>",
                        next: "<i class='bi bi-chevron-right'></i>"
                    }
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
            });
        }

        // ---- Tabs (no reload; the chosen tab is kept in the URL so refresh / sharing keeps it) ----
        var tabs = Array.prototype.slice.call(document.querySelectorAll('.rp-tab'));
        function showTab(name, focus) {
            tabs.forEach(function(t) {
                var on = t.getAttribute('data-tab') === name;
                t.setAttribute('aria-selected', on ? 'true' : 'false');
                t.tabIndex = on ? 0 : -1;
                if (on && focus) { t.focus(); }
                document.getElementById('panel-' + t.getAttribute('data-tab')).hidden = !on;
            });
            try {
                var u = new URL(window.location.href);
                u.searchParams.set('tab', name);
                history.replaceState(null, '', u.toString());
            } catch (e) {}
            // DataTables measured its columns while hidden - re-measure now that it is visible
            if (name === 'reports' && $.fn.DataTable) { $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust(); }
        }
        tabs.forEach(function(t, i) {
            t.addEventListener('click', function() { showTab(t.getAttribute('data-tab'), false); });
            t.addEventListener('keydown', function(e) {            // arrow keys move between tabs
                if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                    var n = tabs[(i + (e.key === 'ArrowRight' ? 1 : tabs.length - 1)) % tabs.length];
                    showTab(n.getAttribute('data-tab'), true);
                }
            });
        });

        // ---- Date picker: load the chosen day as soon as it changes ----
        var gd = document.getElementById('glanceDate');
        if (gd) { gd.addEventListener('change', function() { if (gd.value) { document.getElementById('glanceDateForm').submit(); } }); }

        if (window.bootstrap) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) { new bootstrap.Tooltip(el); });
        }
    });
</script>
<?= $this->endSection() ?>
