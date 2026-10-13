<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhutan API Integration Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
            --light-bg: #f8f9fa;
            --dark-bg: #212529;
        }

        body {
            background-color: #f5f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background-color: white;
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }

        .utility-card {
            transition: transform 0.3s;
        }

        .utility-card:hover {
            transform: translateY(-5px);
        }

        .status-badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .api-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }

        .response-container {
            max-height: 400px;
            overflow-y: auto;
            background-color: #2d2d2d;
            color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .test-btn {
            width: 100%;
            padding: 10px;
            font-weight: 600;
        }

        .param-mapping {
            font-size: 0.9rem;
        }

        .mapping-item {
            border-left: 3px solid var(--primary-color);
            padding-left: 10px;
            margin-bottom: 8px;
        }

        .footer {
            background-color: var(--dark-bg);
            color: white;
            padding: 15px 0;
            margin-top: 30px;
        }

        .tab-pane {
            padding: 20px 0;
        }

        .response-key {
            color: #9cdcfe;
        }

        .response-string {
            color: #ce9178;
        }

        .response-number {
            color: #b5cea8;
        }

        .response-boolean {
            color: #569cd6;
        }

        .utility-selector {
            cursor: pointer;
            transition: all 0.3s;
        }

        .utility-selector:hover {
            background-color: #e8f4ff;
        }

        .utility-selector.active {
            background-color: #cfe2ff;
            border-left: 4px solid var(--primary-color);
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
        }

        .test-history {
            max-height: 300px;
            overflow-y: auto;
        }

        .rate-limit-warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bolt me-2"></i>Bhutan Energy API Integration
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-code me-1"></i> API Docs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cog me-1"></i> Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="spinner-border text-primary spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3" id="loadingText">Initializing API connection...</p>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>API Response Data</span>
                        <button class="btn btn-sm btn-outline-primary" id="refreshBtn">
                            <i class="fas fa-sync-alt me-1"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="responseTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="structured-tab" data-bs-toggle="tab" data-bs-target="#structured" type="button" role="tab">Structured View</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="raw-tab" data-bs-toggle="tab" data-bs-target="#raw" type="button" role="tab">Raw JSON</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="mapping-tab" data-bs-toggle="tab" data-bs-target="#mapping" type="button" role="tab">Field Mapping</button>
                            </li>
                        </ul>

                        <div class="tab-content mt-3" id="responseTabsContent">
                            <div class="tab-pane fade show active" id="structured" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="structuredData">
                                            <!-- Data will be populated by JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="raw" role="tabpanel">
                                <div class="response-container" id="rawJsonData">
                                    <!-- Raw JSON will be populated by JavaScript -->
                                </div>
                            </div>

                            <div class="tab-pane fade" id="mapping" role="tabpanel">
                                <h5>Field Mappings (Old → New)</h5>
                                <div class="param-mapping">
                                    <div class="mapping-item">
                                        <strong>Date (DateTime)</strong> → <strong>Date (String)</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>fullschdRevisionNo</strong> → <strong>FullSchdRevisionNo</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>scheduleRemarks</strong> → <strong>ScheduleRemarks</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>apiRemarks</strong> → <strong>ApiRemarks</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>schedulePublished</strong> → <strong>SchedulePublishedTime</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>BuyerAcr</strong> → <strong>BuyerAcronym</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>SellerAcr</strong> → <strong>SellerAcronym</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>SellerAmount</strong> → <strong>FullScheduleData.ISGSFullScheduleJsonData.ISGSThermalFullScheduleJsonData.TotalInjBoundarySchdAmount</strong>
                                    </div>
                                    <div class="mapping-item">
                                        <strong>entReqList</strong> → <strong>EntitlementList & RequisitionList</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Group Wise Data Details
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="groupAccordion">
                            <!-- Data will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card api-info">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-2"></i>API Information
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Base URL:</strong><br>
                            <code>https://gateway.grid-india.in/POSOCO/</code>
                        </div>
                        <div class="mb-3">
                            <strong>API Key:</strong><br>
                            <code>*********************</code>
                        </div>
                        <div class="mb-3">
                            <strong>Username:</strong> usr_bhutan_api
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <span class="badge bg-success status-badge" id="apiStatus">Connected</span>
                        </div>
                        <div class="mb-3">
                            <strong>Last Updated:</strong> <span id="lastUpdated">-</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-plug me-2"></i>API Connection
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" id="connectApiBtn">
                                <i class="fas fa-plug me-2"></i>Connect to API
                            </button>
                            <button class="btn btn-outline-danger" id="disconnectApiBtn">
                                <i class="fas fa-power-off me-2"></i>Disconnect
                            </button>
                        </div>

                        <div class="mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="autoRefreshSwitch" checked>
                                <label class="form-check-label" for="autoRefreshSwitch">Auto-refresh data (every 5 min)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-bolt me-2"></i>Bhutan Utilities</span>
                        <span class="badge bg-primary" id="utilitiesCount">0</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush" id="utilitiesList">
                            <!-- Utilities will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-list-alt me-2"></i>Response Status
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>IP Restriction:</strong> Bhutan-whitelisted only
                        </div>
                        <div class="mb-3">
                            <strong>Total Utilities Tested:</strong> <span id="totalUtilities">0</span>
                        </div>
                        <div class="mb-3">
                            <strong>Working Utilities:</strong> <span id="workingUtilities">0</span>
                        </div>
                        <div class="mb-3">
                            <strong>Last Response Code:</strong> <span id="lastResponseCode">-</span>
                        </div>
                        <div class="alert alert-success" id="statusAlert">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="statusMessage">API integration successful with Bhutan utilities</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-history me-2"></i>Test History
                    </div>
                    <div class="card-body p-0">
                        <div class="test-history" id="testHistory">
                            <!-- Test history will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Bhutan Energy API Integration</h5>
                    <p>Dashboard for monitoring and testing API integration with Bhutan Energy Scheduling Platform</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>Bhutan Power System Operator <strong>(BPSO)</strong></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configuration - matches your PHP controller
        const API_CONFIG = {
            BASE_URL: 'https://gateway.grid-india.in/POSOCO/',
            API_KEY: '9708bed8-f1a1-4c3b-bc68-3ef3456327ab',
            USERNAME: 'usr_bhutan_api',
            PASSWORD: 'WbesInte@170325'
        };

        // Bhutan utilities to test - matches your PHP controller
        const BHUTAN_UTILITIES = [
            "Bhutan State",
            "CHUKHA",
            "TALA",
            "MANGDECHU",
            "KURICHU",
            "NVVN_Basochu",
            "TPTCL_DHPPB",
            "Nikachu_Bhutan",
            ""
        ];

        // State management
        let appState = {
            connected: false,
            currentUtility: null,
            utilityData: {},
            autoRefresh: true,
            refreshInterval: null,
            testHistory: [],
            rateLimited: false
        };

        // DOM Elements
        const loadingOverlay = document.getElementById('loadingOverlay');
        const loadingText = document.getElementById('loadingText');
        const apiStatus = document.getElementById('apiStatus');
        const lastUpdated = document.getElementById('lastUpdated');
        const connectApiBtn = document.getElementById('connectApiBtn');
        const disconnectApiBtn = document.getElementById('disconnectApiBtn');
        const autoRefreshSwitch = document.getElementById('autoRefreshSwitch');
        const utilitiesList = document.getElementById('utilitiesList');
        const utilitiesCount = document.getElementById('utilitiesCount');
        const totalUtilities = document.getElementById('totalUtilities');
        const workingUtilities = document.getElementById('workingUtilities');
        const lastResponseCode = document.getElementById('lastResponseCode');
        const statusAlert = document.getElementById('statusAlert');
        const statusMessage = document.getElementById('statusMessage');
        const structuredData = document.getElementById('structuredData');
        const rawJsonData = document.getElementById('rawJsonData');
        const groupAccordion = document.getElementById('groupAccordion');
        const refreshBtn = document.getElementById('refreshBtn');
        const testHistory = document.getElementById('testHistory');

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
            setupEventListeners();
        });

        // Initialize the application
        function initializeApp() {
            showLoading('Initializing application...');

            // Load test history from localStorage if available
            const savedHistory = localStorage.getItem('bhutanTestHistory');
            if (savedHistory) {
                appState.testHistory = JSON.parse(savedHistory);
                updateTestHistory();
            }

            // Simulate initialization process
            setTimeout(() => {
                hideLoading();
                updateStatus('Application ready. Connect to API to begin.', 'info');
            }, 1500);
        }

        // Set up event listeners
        function setupEventListeners() {
            connectApiBtn.addEventListener('click', connectToAPI);
            disconnectApiBtn.addEventListener('click', disconnectFromAPI);
            autoRefreshSwitch.addEventListener('change', toggleAutoRefresh);
            refreshBtn.addEventListener('click', manualRefresh);
        }

        // Connect to the API
        function connectToAPI() {
            showLoading('Connecting to API...');
            appState.connected = true;

            // Simulate API connection
            setTimeout(() => {
                updateApiStatus('Connected', 'success');
                hideLoading();
                updateStatus('Successfully connected to API', 'success');

                // Load utilities
                loadUtilities();

                // Start auto-refresh if enabled
                if (appState.autoRefresh) {
                    startAutoRefresh();
                }
            }, 2000);
        }

        // Disconnect from the API
        function disconnectFromAPI() {
            showLoading('Disconnecting from API...');
            appState.connected = false;

            // Stop auto-refresh
            stopAutoRefresh();

            // Simulate API disconnection
            setTimeout(() => {
                updateApiStatus('Disconnected', 'danger');
                hideLoading();
                updateStatus('Disconnected from API', 'warning');
                clearUtilities();
            }, 1000);
        }

        // Toggle auto-refresh
        function toggleAutoRefresh() {
            appState.autoRefresh = autoRefreshSwitch.checked;

            if (appState.autoRefresh && appState.connected) {
                startAutoRefresh();
                updateStatus('Auto-refresh enabled', 'info');
            } else {
                stopAutoRefresh();
                updateStatus('Auto-refresh disabled', 'info');
            }
        }

        // Start auto-refresh interval
        function startAutoRefresh() {
            // Clear any existing interval
            stopAutoRefresh();

            // Set new interval (5 minutes)
            appState.refreshInterval = setInterval(() => {
                if (appState.currentUtility) {
                    fetchUtilityData(appState.currentUtility);
                }
            }, 300000); // 5 minutes

            updateStatus('Auto-refresh enabled (every 5 min)', 'info');
        }

        // Stop auto-refresh interval
        function stopAutoRefresh() {
            if (appState.refreshInterval) {
                clearInterval(appState.refreshInterval);
                appState.refreshInterval = null;
            }
        }

        // Manual refresh
        function manualRefresh() {
            if (appState.currentUtility) {
                fetchUtilityData(appState.currentUtility);
                updateStatus('Manually refreshing data...', 'info');
            } else {
                updateStatus('Please select a utility first', 'warning');
            }
        }

        // Load utilities list
        function loadUtilities() {
            showLoading('Loading utilities...');

            // Clear existing utilities
            utilitiesList.innerHTML = '';

            // Add each utility to the list
            BHUTAN_UTILITIES.forEach((utility, index) => {
                const utilityElement = document.createElement('div');
                utilityElement.className = 'list-group-item utility-selector';
                utilityElement.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">${utility || '(Empty)'}</h6>
                            <small class="text-muted">Utility code: ${utility || 'None'}</small>
                        </div>
                        <span class="badge bg-secondary">Not tested</span>
                    </div>
                `;

                utilityElement.addEventListener('click', () => {
                    // Check if we're rate limited
                    if (appState.rateLimited) {
                        updateStatus('Rate limited. Please wait before testing another utility.', 'warning');
                        return;
                    }

                    // Remove active class from all utilities
                    document.querySelectorAll('.utility-selector').forEach(el => {
                        el.classList.remove('active');
                    });

                    // Add active class to clicked utility
                    utilityElement.classList.add('active');

                    // Fetch data for this utility
                    appState.currentUtility = utility;
                    fetchUtilityData(utility);
                });

                utilitiesList.appendChild(utilityElement);
            });

            utilitiesCount.textContent = BHUTAN_UTILITIES.length;
            totalUtilities.textContent = BHUTAN_UTILITIES.length;

            hideLoading();
        }

        // Clear utilities list
        function clearUtilities() {
            utilitiesList.innerHTML = '';
            utilitiesCount.textContent = '0';
            totalUtilities.textContent = '0';
            workingUtilities.textContent = '0';
            lastResponseCode.textContent = '-';

            // Clear displayed data
            structuredData.innerHTML = '';
            rawJsonData.innerHTML = '';
            groupAccordion.innerHTML = '';
        }

        // Fetch data for a specific utility
        function fetchUtilityData(utility) {
            if (!appState.connected) {
                updateStatus('Please connect to API first', 'warning');
                return;
            }

            showLoading(`Fetching data for ${utility || '(Empty)'}...`);

            // Make API call to your PHP backend
            fetch('/api/bhutan-test/' + encodeURIComponent(utility))
                .then(response => response.json())
                .then(data => {
                    hideLoading();

                    // Add to test history
                    addToTestHistory(utility, data);

                    if (data.success) {
                        processUtilityData(utility, data.test_result.response);
                    } else {
                        updateStatus(`Error fetching data: ${data.test_result.error_message || 'Unknown error'}`, 'danger');
                        updateUtilityStatus(utility, 'Error', 'danger');

                        // Check if rate limited
                        if (data.test_result.status_code === 429) {
                            appState.rateLimited = true;
                            updateStatus('Rate limited. Please wait 3-5 minutes before next test.', 'warning');

                            // Auto-clear rate limit after 5 minutes
                            setTimeout(() => {
                                appState.rateLimited = false;
                                updateStatus('Rate limit cleared. You can test utilities again.', 'success');
                            }, 300000);
                        }
                    }
                })
                .catch(error => {
                    hideLoading();
                    updateStatus(`Error fetching data: ${error.message}`, 'danger');
                    updateUtilityStatus(utility, 'Error', 'danger');
                    addToTestHistory(utility, {
                        error: error.message
                    });
                });
        }

        // Add test to history
        function addToTestHistory(utility, data) {
            const historyEntry = {
                utility: utility,
                timestamp: new Date().toISOString(),
                data: data
            };

            appState.testHistory.unshift(historyEntry);

            // Keep only the last 10 history entries
            if (appState.testHistory.length > 10) {
                appState.testHistory.pop();
            }

            // Save to localStorage
            localStorage.setItem('bhutanTestHistory', JSON.stringify(appState.testHistory));

            // Update UI
            updateTestHistory();
        }

        // Update test history display
        function updateTestHistory() {
            testHistory.innerHTML = '';

            if (appState.testHistory.length === 0) {
                testHistory.innerHTML = '<div class="p-3 text-center text-muted">No tests yet</div>';
                return;
            }

            appState.testHistory.forEach(entry => {
                const historyItem = document.createElement('div');
                historyItem.className = 'list-group-item';

                const success = entry.data && entry.data.success;
                const statusCode = entry.data && entry.data.test_result ? entry.data.test_result.status_code : 'N/A';

                historyItem.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">${entry.utility || '(Empty)'}</h6>
                            <small class="text-muted">${new Date(entry.timestamp).toLocaleString()}</small>
                        </div>
                        <span class="badge ${success ? 'bg-success' : 'bg-danger'}">${statusCode}</span>
                    </div>
                `;

                testHistory.appendChild(historyItem);
            });
        }

        // Process utility data after fetching
        function processUtilityData(utility, data) {
            // Store the data
            appState.utilityData[utility] = data;

            // Update utility status
            updateUtilityStatus(utility, 'Success', 'success');

            // Update working utilities count
            updateWorkingUtilitiesCount();

            // Update last response code
            if (data.ResponseStatus && data.ResponseStatus.Code) {
                lastResponseCode.textContent = data.ResponseStatus.Code;
            } else {
                lastResponseCode.textContent = '200';
            }

            // Update last updated timestamp
            lastUpdated.textContent = new Date().toLocaleString();

            // Update displayed data
            updateStructuredData(data);
            updateRawJsonData(data);
            updateGroupWiseData(data);

            // Update status message
            updateStatus(`Successfully fetched data for ${utility || '(Empty)'}`, 'success');
        }

        // Update utility status in the list
        function updateUtilityStatus(utility, status, type) {
            const utilities = document.querySelectorAll('.utility-selector');
            utilities.forEach(el => {
                if (el.textContent.includes(utility || '(Empty)')) {
                    const badge = el.querySelector('.badge');
                    badge.textContent = status;
                    badge.className = `badge bg-${type}`;
                }
            });
        }

        // Update working utilities count
        function updateWorkingUtilitiesCount() {
            const working = Object.keys(appState.utilityData).length;
            workingUtilities.textContent = working;
        }

        // Update structured data display
        function updateStructuredData(data) {
            structuredData.innerHTML = '';

            if (!data) return;

            const rows = [{
                    field: 'Date',
                    value: data.Date || '-',
                    status: 'success'
                },
                {
                    field: 'FullSchdRevisionNo',
                    value: data.FullSchdRevisionNo || '-',
                    status: 'success'
                },
                {
                    field: 'ScheduleRemarks',
                    value: data.ScheduleRemarks || '-',
                    status: 'success'
                },
                {
                    field: 'ApiRemarks',
                    value: data.ApiRemarks || '-',
                    status: 'success'
                },
                {
                    field: 'SchedulePublishedTime',
                    value: data.SchedulePublishedTime || '-',
                    status: 'success'
                },
                {
                    field: 'GroupWiseDataList',
                    value: data.GroupWiseDataList ? `${data.GroupWiseDataList.length} items` : '0 items',
                    status: data.GroupWiseDataList ? 'info' : 'warning'
                }
            ];

            rows.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.field}</td>
                    <td>${row.value}</td>
                    <td><span class="badge bg-${row.status}">${row.status.toUpperCase()}</span></td>
                `;
                structuredData.appendChild(tr);
            });
        }
        // API endpoints from your PHP controller
        const API_ENDPOINTS = {
            testUtility: '/api/bhutan-test/',
            getUtilities: '/api/bhutan-utilities',
            getApiStatus: '/api/bhutan-status',
            testAll: '/api/bhutan-test-all',
            getApiInfo: '/api/bhutan-info'
        };

        // Update raw JSON data display
        function updateRawJsonData(data) {
            if (!data) {
                rawJsonData.innerHTML = 'No data available';
                return;
            }

            // Format the JSON with syntax highlighting
            const jsonString = JSON.stringify(data, null, 2);
            rawJsonData.innerHTML = syntaxHighlightJson(jsonString);
        }

        // Update group-wise data display
        function updateGroupWiseData(data) {
            groupAccordion.innerHTML = '';

            if (!data || !data.GroupWiseDataList || data.GroupWiseDataList.length === 0) {
                groupAccordion.innerHTML = '<div class="text-center p-3">No group data available</div>';
                return;
            }

            data.GroupWiseDataList.forEach((group, index) => {
                const accordionItem = document.createElement('div');
                accordionItem.className = 'accordion-item';
                accordionItem.innerHTML = `
                    <h2 class="accordion-header">
                        <button class="accordion-button ${index === 0 ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" data-bs-target="#group${index}">
                            ${group.Acronym} (${group.FullschdList ? group.FullschdList.length : 0} Schedules)
                        </button>
                    </h2>
                    <div id="group${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" data-bs-parent="#groupAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Seller</th>
                                            <th>Buyer</th>
                                            <th>Amount (MW)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${group.FullschdList ? group.FullschdList.map(schedule => `
                                            <tr>
                                                <td>${schedule.EnergyScheduleTypeName || '-'}</td>
                                                <td>${schedule.SellerAcronym || '-'}</td>
                                                <td>${schedule.BuyerAcronym || '-'}</td>
                                                <td>${schedule.TotalInjBoundarySchdAmount || '0.00'}</td>
                                                <td><span class="badge bg-success">Active</span></td>
                                            </tr>
                                        `).join('') : '<tr><td colspan="5" class="text-center">No schedule data</td></tr>'}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
                groupAccordion.appendChild(accordionItem);
            });
        }

        // Syntax highlight JSON
        function syntaxHighlightJson(json) {
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function(match) {
                let cls = 'response-number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'response-key';
                    } else {
                        cls = 'response-string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'response-boolean';
                } else if (/null/.test(match)) {
                    cls = 'response-null';
                }
                return '<span class="' + cls + '">' + match + '</span>';
            });
        }

        // Show loading overlay
        function showLoading(message) {
            loadingText.textContent = message;
            loadingOverlay.style.display = 'flex';
        }

        // Hide loading overlay
        function hideLoading() {
            loadingOverlay.style.display = 'none';
        }

        // Update API status
        function updateApiStatus(status, type) {
            apiStatus.textContent = status;
            apiStatus.className = `badge bg-${type} status-badge`;
        }

        // Update status message
        function updateStatus(message, type) {
            statusMessage.textContent = message;
            statusAlert.className = `alert alert-${type}`;

            // Update icon based on type
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            if (type === 'warning') icon = 'exclamation-circle';
            if (type === 'danger') icon = 'exclamation-triangle';

            statusAlert.innerHTML = `<i class="fas fa-${icon} me-2"></i> ${message}`;
        }
    </script>
</body>

</html>