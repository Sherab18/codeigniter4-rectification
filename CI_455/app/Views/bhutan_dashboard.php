<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
NVVN DATA | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
    .metric-card {
        border-left: 4px solid;
        transition: transform 0.2s;
    }

    .metric-card:hover {
        transform: translateY(-2px);
    }

    .table-sticky-header th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: #212529 !important;
        color: #fff;
    }

    .block-row:hover {
        background-color: rgba(13, 110, 253, 0.05) !important;
    }
</style>

<main>
    <div class="container">

        <div class="container-fluid px-4">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h3 class="mb-1 text-dark"><i class="fa-solid fa-bolt text-warning me-2"></i>Bhutan Power Utilities Dashboard</h3>
                    <span class="text-muted small">Grid-India / WBES Real-Time Scheduling Synchronization</span>
                </div>
                <div>
                    <span class="badge bg-success px-3 py-2"><i class="fa-solid fa-circle-check me-1"></i> System Online</span>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form id="filterForm" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="utilitySelect" class="form-label fw-bold">Select Utility / Generator</label>
                            <select id="utilitySelect" class="form-select">
                                <?php if (!empty($utilities)): ?>
                                    <?php foreach ($utilities as $code => $name): ?>
                                        <option value="<?= esc($code) ?>"><?= esc($name) ?> (<?= esc($code) ?>)</option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="TALA">Tala Hydro Power Plant (TALA)</option>
                                    <option value="MANGDECHU">Mangdechhu Hydro Power Plant (MANGDECHU)</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="fromDate" class="form-label fw-bold">From Date</label>
                            <input type="date" id="fromDate" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="toDate" class="form-label fw-bold">To Date</label>
                            <input type="date" id="toDate" class="form-control" value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" id="btnLoadData" class="btn btn-primary w-100">
                                <i class="fa-solid fa-arrows-rotate me-1"></i> Show Data
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="btnExportCsv" class="btn btn-outline-secondary w-100" disabled>
                                <i class="fa-solid fa-file-csv me-1"></i> Export CSV
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="alertContainer"></div>

            <div class="row g-3 mb-4" id="metricsRow" style="display: none;">
                <div class="col-md-4">
                    <div class="card shadow-sm metric-card border-primary">
                        <div class="card-body">
                            <div class="text-muted small fw-bold">TOTAL SCHEDULED ENERGY</div>
                            <div class="fs-4 fw-bold text-primary mt-1" id="valTotalEnergy">0.00 MWh</div>
                            <div class="text-muted extra-small" id="lblAvgMw">Avg: 0.00 MW</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm metric-card border-success">
                        <div class="card-body">
                            <div class="text-muted small fw-bold">PEAK GENERATION / SCHD</div>
                            <div class="fs-4 fw-bold text-success mt-1" id="valPeakMw">0.00 MW</div>
                            <div class="text-muted extra-small" id="lblPeakBlock">Block: -</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm metric-card border-warning">
                        <div class="card-body">
                            <div class="text-muted small fw-bold">REVISION NUMBER</div>
                            <div class="fs-4 fw-bold text-warning mt-1" id="valRevision">Rev -</div>
                            <div class="text-muted extra-small">Latest Published Revision</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-list-ol me-2"></i>15-Minute Time Block Breakdown</h6>
                    <span class="badge bg-light text-dark border" id="tableStatus">No Data Loaded</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 550px;">
                        <table class="table table-hover table-bordered mb-0 align-middle text-center table-sticky-header" id="scheduleTable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Block</th>
                                    <th>Time Interval</th>
                                    <th>Schedule Amount (MW)</th>
                                    <th>Net Delivered (MW)</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        Select a date range and click "Show Data" to fetch schedules.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        let currentParsedBlocks = [];

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            loadRangeUtilityData();
        });

        function getDateRange(startDate, endDate) {
            let dates = [];
            let currDate = new Date(startDate);
            let lastDate = new Date(endDate);

            while (currDate <= lastDate) {
                dates.push(currDate.toISOString().split('T')[0]);
                currDate.setDate(currDate.getDate() + 1);
            }
            return dates;
        }

        async function loadRangeUtilityData() {
            let utility = $('#utilitySelect').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            let btn = $('#btnLoadData');

            if (new Date(fromDate) > new Date(toDate)) {
                showError('"From Date" cannot be greater than "To Date".');
                return;
            }

            let dateList = getDateRange(fromDate, toDate);
            if (dateList.length > 31) {
                showError('Date range cannot exceed 31 days at a time.');
                return;
            }

            $('#alertContainer').empty();
            btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-1"></i> Fetching...');
            $('#tableStatus').text(`Fetching ${dateList.length} day(s) from Grid-India...`);

            currentParsedBlocks = [];
            let totalMwAll = 0;
            let maxMwAll = 0;
            let peakBlockAll = '-';
            let totalPocLossAll = 0;
            let totalStateLossAll = 0;
            let lastRevNo = 'N/A';
            let tableRows = '';

            for (let idx = 0; idx < dateList.length; idx++) {
                let dateStr = dateList[idx];
                $('#tableStatus').text(`Fetching (${idx + 1}/${dateList.length}): ${dateStr}...`);

                try {
                    let res = await $.ajax({
                        url: '<?= base_url('bhutan/getUtilityData') ?>',
                        type: 'GET',
                        data: {
                            utility: utility,
                            date: dateStr
                        },
                        dataType: 'json'
                    });

                    if (res.status === 'success' && res.utility_data && res.utility_data.transformed_data) {
                        let data = res.utility_data.transformed_data;

                        let schdArray = findBlockArray(data, ['SchdAmount', 'ScheduleAmount', 'SellerAmount', 'BuyerAmount', 'schdAmount']);
                        let pocLossArray = findBlockArray(data, ['POCLoss', 'PocLoss', 'pocLoss']);
                        let stateLossArray = findBlockArray(data, ['StateLoss', 'stateLoss']);
                        let revNo = findRevisionNumber(data);
                        if (revNo !== 'N/A') lastRevNo = revNo;

                        if (schdArray.length === 96) {
                            for (let i = 0; i < 96; i++) {
                                let blockNo = i + 1;
                                let startMin = i * 15;
                                let endMin = (i + 1) * 15;
                                let startTime = String(Math.floor(startMin / 60)).padStart(2, '0') + ':' + String(startMin % 60).padStart(2, '0');
                                let endTime = (endMin === 1440) ? '24:00' : String(Math.floor(endMin / 60)).padStart(2, '0') + ':' + String(endMin % 60).padStart(2, '0');
                                let timeInterval = startTime + ' - ' + endTime;

                                let schdVal = parseFloat(schdArray[i] || 0);
                                let pocLossVal = parseFloat(pocLossArray[i] || 0);
                                let stateLossVal = parseFloat(stateLossArray[i] || 0);
                                let netVal = schdVal - (pocLossVal + stateLossVal);

                                totalMwAll += schdVal;
                                totalPocLossAll += pocLossVal;
                                totalStateLossAll += stateLossVal;

                                if (schdVal > maxMwAll) {
                                    maxMwAll = schdVal;
                                    peakBlockAll = `${dateStr} (Block ${blockNo})`;
                                }

                                currentParsedBlocks.push({
                                    Date: dateStr,
                                    Block: blockNo,
                                    Time: timeInterval,
                                    ScheduleMW: schdVal.toFixed(2),
                                    NetDeliveredMW: netVal.toFixed(2)
                                });

                                tableRows += `<tr class="block-row">
                                    <td class="small fw-bold text-muted">${dateStr}</td>
                                    <td class="fw-bold">${blockNo}</td>
                                    <td class="text-muted small">${timeInterval}</td>
                                    <td class="fw-semibold text-primary">${schdVal.toFixed(2)}</td>
                                    <td class="fw-bold text-success">${netVal.toFixed(2)}</td>
                                </tr>`;
                            }
                        }
                    }
                } catch (e) {
                    console.warn(`Failed fetching date ${dateStr}:`, e);
                }
            }

            btn.prop('disabled', false).html('<i class="fa-solid fa-arrows-rotate me-1"></i> Show Data');

            if (!currentParsedBlocks.length) {
                showError('Failed to fetch schedule blocks for the selected range.');
                resetDashboard();
                return;
            }

            let totalMwh = totalMwAll / 4;
            let avgMw = totalMwAll / currentParsedBlocks.length;

            $('#valTotalEnergy').text(totalMwh.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + ' MWh');
            $('#lblAvgMw').text('Avg: ' + avgMw.toFixed(2) + ' MW');
            $('#valPeakMw').text(maxMwAll.toFixed(2) + ' MW');
            $('#lblPeakBlock').text('Peak: ' + peakBlockAll);
            $('#valRevision').text('Rev ' + lastRevNo);

            $('#metricsRow').slideDown();
            $('#tableBody').html(tableRows);
            $('#tableStatus').removeClass('bg-light text-dark').addClass('bg-success text-white').text(`Loaded: ${utility} (${fromDate} to ${toDate})`);
            $('#btnExportCsv').prop('disabled', false);
        }

        function findBlockArray(obj, possibleKeys) {
            if (!obj) return [];
            for (let key of possibleKeys) {
                if (obj[key] && Array.isArray(obj[key]) && obj[key].length === 96) return obj[key];
            }
            if (Array.isArray(obj)) {
                for (let item of obj) {
                    let found = findBlockArray(item, possibleKeys);
                    if (found.length === 96) return found;
                }
            }
            if (typeof obj === 'object') {
                for (let k in obj) {
                    if (obj[k] && typeof obj[k] === 'object') {
                        let found = findBlockArray(obj[k], possibleKeys);
                        if (found.length === 96) return found;
                    }
                }
            }
            return [];
        }

        function findRevisionNumber(obj) {
            if (!obj) return 'N/A';
            if (obj.FullSchdRevisionNo !== undefined) return obj.FullSchdRevisionNo;
            if (obj.SchdRevisionNo !== undefined) return obj.SchdRevisionNo;
            if (Array.isArray(obj) && obj.length > 0) return findRevisionNumber(obj[0]);
            if (typeof obj === 'object') {
                for (let k in obj) {
                    if (obj[k] && typeof obj[k] === 'object') {
                        let rev = findRevisionNumber(obj[k]);
                        if (rev !== 'N/A') return rev;
                    }
                }
            }
            return 'N/A';
        }

        function showError(message) {
            $('#alertContainer').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
        }

        function resetDashboard() {
            $('#metricsRow').slideUp();
            $('#tableBody').html(`
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        No schedule data loaded. Select date range above and click "Show Data".
                    </td>
                </tr>
            `);
            $('#tableStatus').removeClass('bg-success text-white').addClass('bg-light text-dark').text('No Data Loaded');
            $('#btnExportCsv').prop('disabled', true);
            currentParsedBlocks = [];
        }

        $('#btnExportCsv').on('click', function() {
            if (!currentParsedBlocks.length) return;

            let utility = $('#utilitySelect').val();
            let fromDate = $('#fromDate').val();
            let toDate = $('#toDate').val();
            let filename = `Bhutan_Schedule_${utility}_${fromDate}_to_${toDate}.csv`;

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Date,Block,Time Interval,Schedule MW,Net Delivered MW\n";

            currentParsedBlocks.forEach(function(row) {
                csvContent += `"${row.Date}",${row.Block},"${row.Time}",${row.ScheduleMW},${row.NetDeliveredMW}\n`;
            });

            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        loadRangeUtilityData();
    });
</script>

<?= $this->endSection() ?>