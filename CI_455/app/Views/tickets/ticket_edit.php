<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Tickets | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col col-md-3">
                <?= $this->include('tickets/tickets_sidebar') ?><br>
                <?= $this->include('tickets/tickets_emp_sidebar') ?><br>
            </div>

            <div class="col col-md-9">
                <div class="card border-dark">
                    <div class="card-header text-center text-white bg-primary"><strong>Update Ticket</strong></div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>

                        <?= form_open('/tickets/update_ticket/' . $record['id']) ?>
                        <div class="row g-2">
                            <div class="col-md-2 mb-3">
                                <label for="ticket_id" class="form-label"><strong>Ticket Id:</strong></label>
                                <input type="text" id="ticket_id" class="form-control" value="<?= esc($record['id']) ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ticket_station" class="form-label">Station:</label>
                                <input type="text" id="ticket_station" class="form-control" value="<?= esc($record['station'] ? ucwords(station_details($record['station'])['capacity'] . ' ' . station_details($record['station'])['station']) : 'Not available') ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ticket_severity" class="form-label">Problem Severity:</label>
                                <input type="text" id="ticket_severity" class="form-control" value="<?= esc(ucwords($record['severity'])) ?>" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4 offset-md-2 mb-3">
                                <label for="ticket_target" class="form-label">Issued To:</label>
                                <input type="text" id="ticket_target" class="form-control" value="<?= esc(ucwords($record['target'])) ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ticket_issue_by" class="form-label">Issued By:</label>
                                <input type="text" id="ticket_issue_by" class="form-control" value="<?= esc(fullname($record['issue_by'])) ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ticket_issue_date" class="form-label">Issued Date:</label>
                                <input type="text" id="ticket_issue_date" class="form-control" value="<?= esc($record['issue_date']) ?>" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-10 offset-md-2 mb-3">
                                <label for="prob_desc" class="form-label">Problem Description:</label>
                                <textarea id="prob_desc" class="form-control" rows="2" readonly><?= esc($record['prob_desc']) ?></textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-10 offset-md-2 mb-3">
                                <label for="serv_affected" class="form-label">Service Affected:</label>
                                <textarea id="serv_affected" class="form-control" rows="2" readonly><?= esc($record['serv_affected']) ?></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row g-2">
                            <span class="form-label"><strong>Ticket History Logs (Chronological Timeline):</strong></span>
                        </div>

                        <?php
                        // 1. Combine historical logs from all action fields safely
                        $rawLogs = "";
                        if (!empty($record['pen_reason'])) $rawLogs .= trim($record['pen_reason']);
                        if (!empty($record['passed_reason'])) $rawLogs .= (empty(trim($rawLogs)) ? "" : "|||") . trim($record['passed_reason']);
                        if (!empty($record['sol_procedure'])) $rawLogs .= (empty(trim($rawLogs)) ? "" : "|||") . trim($record['sol_procedure']);

                        if (empty(trim($rawLogs))):
                        ?>
                            <div class="row g-2">
                                <div class="col-md-3 offset-md-1 mb-3">
                                    <label for="processed_by_nil" class="form-label">Processed By:</label>
                                    <input type="text" id="processed_by_nil" class="form-control" value="Nil" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="latest_status_nil" class="form-label">Latest Reason Status:</label>
                                    <textarea id="latest_status_nil" class="form-control" rows="2" readonly>No historical update logs registered yet.</textarea>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php
                            // 2. Split securely using lookahead arrays to slice combined database strings cleanly
                            $logEntries = preg_split('/\|\|\||(?=\[\d{4}-\d{2}-\d{2})/', $rawLogs);
                            $counter = 1;

                            foreach ($logEntries as $entry):
                                $entry = trim($entry);
                                if (empty($entry)) continue;

                                $fallbackUser = "Unknown Officer";
                                if (!empty($record['pen_eng'])) {
                                    $fallbackUser = fullname($record['pen_eng']);
                                } elseif (!empty($record['sol_eng'])) {
                                    $fallbackUser = fullname($record['sol_eng']);
                                }

                                $fallbackDate = !empty($record['pen_date']) ? $record['pen_date'] : "Legacy Record";

                                $headerText = $fallbackDate . " | " . $fallbackUser;
                                $cleanBody = $entry;

                                if (preg_match('/^\[(.*?)\]:\s*(.*)/s', $entry, $matches)) {
                                    $headerText = $matches[1];
                                    $cleanBody = trim($matches[2]);
                                } elseif (preg_match('/^(.*?)\s*\[(\d{4}-\d{2}-\d{2}.*?)\]:?\s*$/s', $entry, $matches)) {
                                    $headerText = trim($matches[2]);
                                    $cleanBody = trim($matches[1]);
                                } elseif (preg_match('/\[(\d{4}-\d{2}-\d{2}.*?)\]/', $entry, $matches)) {
                                    $headerText = $matches[1];
                                    $cleanBody = trim(str_replace($matches[0], '', $entry));
                                }
                            ?>
                                <div class="row g-3 mb-2 align-items-start">
                                    <div class="col-md-3 offset-md-1">
                                        <span class="form-label text-muted small"><strong>Logged Action:</strong></span>
                                        <div class="p-2 border rounded bg-light text-center small font-monospace shadow-sm" style="font-size: 0.82rem; line-height: 1.4; word-break: break-word;">
                                            <i class="bi bi-clock-history me-1" aria-hidden="true"></i> <?= esc($headerText) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="log_desc_<?= $counter ?>" class="form-label text-dark">Logged Description:</label>
                                        <textarea id="log_desc_<?= $counter ?>" class="form-control bg-white shadow-sm" rows="3" style="resize: none;" readonly><?= esc($cleanBody) ?></textarea>
                                    </div>
                                </div>
                            <?php
                                $counter++;
                            endforeach;
                            ?>
                        <?php endif; ?>

                        <?php if (!empty($record['ver_eng'])): ?>
                            <hr>
                            <div class="row g-3 align-items-start">
                                <div class="col-md-3 offset-md-1 mb-3">
                                    <label for="ver_eng" class="form-label text-success"><strong>Verified By:</strong></label>
                                    <input type="text" id="ver_eng" class="form-control form-control-sm" value="<?= esc(fullname($record['ver_eng'])) ?>" readonly>
                                    <label for="ver_date" class="visually-hidden">Verification Date</label>
                                    <input type="text" id="ver_date" class="form-control form-control-sm mt-1" value="<?= esc($record['ver_date']) ?>" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="ver_remarks" class="form-label">System Operator Verification Remarks:</label>
                                    <textarea id="ver_remarks" class="form-control bg-white mb-2" rows="2" readonly><?= esc($record['ver_remarks']) ?></textarea>
                                    <label for="ver_status_display" class="visually-hidden">Overall Verification Status</label>
                                    <input type="text" id="ver_status_display" class="form-control <?= ($record['ver_status'] == 'not-satisfied') ? 'is-invalid' : 'is-valid' ?>" value="<?= esc(ucwords('Overall Verification Status: ' . $record['ver_status'])) ?>" readonly>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <div class="row g-3">
                            <span class="form-label"><strong>Update Ticket Status:</strong></span>
                        </div>

                        <?php
                        $unitId = session()->get('login_info')['unit_id'] ?? null;
                        $userRole = user_right($unitId);

                        if ($record['status'] !== 'solved' && $userRole === 'scada_expertise'):
                        ?>
                            <div class="row g-3">
                                <div class="col-md-3 offset-md-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="orb_pending" name="orb_ticket" value="pending" <?= $record['status'] == 'pending' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="orb_pending">Keep Pending</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="orb_solved" name="orb_ticket" value="solved" <?= $record['status'] == 'solved' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="orb_solved">Ticket Solved</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="orb_passed" name="orb_ticket" value="passed" <?= $record['status'] == 'passed' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="orb_passed">Ticket Passed</label>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="update_desc" id="lbl_update_desc" class="form-label"><?= $record['status'] == 'solved' ? 'Enter Solved Procedure:' : ($record['status'] == 'passed' ? 'Enter Passed Reason:' : 'Enter Pending Reason:') ?></label>
                                    <textarea class="form-control" id="update_desc" name="update_desc" rows="3" required></textarea>
                                </div>
                            </div><br>

                            <div class="row g-3">
                                <div class="col-md-4 offset-md-1">
                                    <button class="btn btn-primary" type="submit" id="btn_submit">Update Ticket</button>
                                </div>
                                <div class="col-md-4 offset-md-2">
                                    <a href="<?= base_url('/tickets/list_tickets/all/all') ?>" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-light text-muted border ps-4 mb-3">
                                <i class="bi bi-lock-fill me-1" aria-hidden="true"></i>
                                <?php if ($record['status'] === 'solved'): ?>
                                    This ticket has been marked as <strong>Solved</strong>. Engineering updates are locked for SCADA Experts.
                                <?php else: ?>
                                    Review Mode: Only assigned <strong>SCADA Experts</strong> are authorized to update operational tickets.
                                <?php endif; ?>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4 offset-md-1">
                                    <a href="<?= base_url('/tickets/list_tickets/all/all') ?>" class="btn btn-secondary">Back to List</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?= form_close(); ?>

                        <?php if ($record['status'] === 'solved' && empty($record['ver_eng'])): ?>
                            <hr>
                            <?php if ($userRole === 'system_operator'): ?>
                                <form action="<?= base_url('/tickets/verify_ticket/' . $record['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-12">
                                            <h5 class="text-primary"><i class="fas fa-check-double me-1" aria-hidden="true"></i> System Operator Verification Assessment</h5>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <span class="form-label d-block fw-bold mb-2">Verification Decision:</span>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ver_status" value="satisfied" id="ver_satisfied" required>
                                                            <label class="form-check-label text-success" for="ver_satisfied"><strong>Satisfied (Approve & Close)</strong></label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ver_status" value="not-satisfied" id="ver_not_satisfied">
                                                            <label class="form-check-label text-danger" for="ver_not_satisfied"><strong>Not Satisfied (Reject)</strong></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ver_remarks_input" class="form-label">Review Operational Remarks:</label>
                                                        <textarea id="ver_remarks_input" class="form-control" name="ver_remarks" rows="3" required placeholder="Provide evaluation statements here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <button type="submit" class="btn btn-success">Submit Official Verification</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-info border-0 bg-primary bg-opacity-10 text-dark small mt-3">
                                    <i class="bi bi-info-circle-fill me-1" aria-hidden="true"></i> Awaiting audit step. This resolved ticket is pending verification review exclusively by a <strong>System Operator</strong>.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        <?php if ($record['ver_status'] === 'satisfied' && $record['ver_eng']): ?>
            $(".card").addClass("bg-success bg-opacity-10");
        <?php elseif ($record['ver_status'] === 'not-satisfied' && $record['ver_eng']): ?>
            $(".card").addClass("bg-danger bg-opacity-10");
        <?php endif; ?>

        $('input[name="ver_status"]').change(function() {
            if ($(this).val() === 'satisfied') {
                $(".card").removeClass("bg-danger bg-opacity-10").addClass("bg-success bg-opacity-10");
            } else {
                $(".card").removeClass("bg-success bg-opacity-10").addClass("bg-danger bg-opacity-10");
            }
        });

        $('input[name="orb_ticket"]').change(function() {
            let selectedStatus = $(this).val();
            if (selectedStatus === 'solved') {
                $('#lbl_update_desc').text('Enter Solved Procedure:');
            } else if (selectedStatus === 'passed') {
                $('#lbl_update_desc').text('Enter Passed Reason:');
            } else {
                $('#lbl_update_desc').text('Enter Pending Reason:');
            }
        });
    });
</script>
<?= $this->endSection() ?>