<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utility Block Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom JS -->
    <script src="<?= base_url('js/utility_block.js') ?>"></script>

    <style>
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container py-4">

        <h3 class="mb-4 fw-bold text-primary">Utility Schedule Dashboard</h3>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Utility</label>
                <select id="utilitySelect" class="form-select"></select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" id="scheduleDate" class="form-control">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button id="fetchBtn" class="btn btn-primary w-100">Fetch</button>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <table id="blockTable" class="table table-striped table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Time Block</th>
                        <th>Time Desc</th>
                        <th>DC Amount</th>
                        <th>DC for Schedule Amount</th>
                        <th>Schedule Amount</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <hr class="my-4">

        <h5 class="fw-bold">Schedule Amount Chart</h5>
        <canvas id="scheduleChart" height="100"></canvas>

    </div>

    <!-- Bootstrap + DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>
