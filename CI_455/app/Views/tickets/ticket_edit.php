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
                                <label class="form-label"><strong>Ticket Id:</strong></label>
                                <input type="text" class="form-control" value="<?= $record['id'] ?>" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Station:</label>
                                <input type="text" class="form-control" value="<?= $record['station'] ? ucwords(station_details($record['station'])['capacity'] . ' ' . station_details($record['station'])['station']) : 'Not available' ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Problem Severity:</label>
                                <input type="text" class="form-control" value="<?= ucwords($record['severity']) ?>" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-4 offset-md-2 mb-3">
                                <label class="form-label">Issued To:</label>
                                <input type="text" class="form-control" value="<?= ucwords($record['target']) ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Issued By:</label>
                                <input type="text" class="form-control" value="<?= fullname($record['issue_by']) ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Issued Date:</label>
                                <input type="text" class="form-control" value="<?= $record['issue_date'] ?>" readonly>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-10 offset-md-2 mb-3">
                                <label class="form-label">Problem Description:</label>
                                <textarea class="form-control" rows="2" readonly><?= esc($record['prob_desc']) ?></textarea>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-10 offset-md-2 mb-3">
                                <label class="form-label">Service Affected:</label>
                                <textarea class="form-control" rows="2" readonly><?= esc($record['serv_affected']) ?></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row g-2">
                            <label class="form-label"><strong>Ticket History Logs (Chronological Timeline):</strong></label>
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
                                    <label class="form-label">Processed By:</label>
                                    <input type="text" class="form-control" value="Nil" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Latest Reason Status:</label>
                                    <textarea class="form-control" rows="2" readonly>No historical update logs registered yet.</textarea>
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

                                // DETERMINE DYNAMIC FALLBACK METADATA FOR LEGACY LINES LIKE TICKET 211
                                $fallbackUser = "Unknown Officer";
                                if (!empty($record['pen_eng'])) {
                                    $fallbackUser = fullname($record['pen_eng']); // Resolves User 41 to Karma Dema
                                } elseif (!empty($record['sol_eng'])) {
                                    $fallbackUser = fullname($record['sol_eng']);
                                }

                                $fallbackDate = !empty($record['pen_date']) ? $record['pen_date'] : "Legacy Record";

                                // Default template variables if formatting tags are completely missing
                                $headerText = $fallbackDate . " | " . $fallbackUser;
                                $cleanBody = $entry;

                                // Regex Case A: Entry starts with metadata tag -> [2026-05-27 | Name]: Text
                                if (preg_match('/^\[(.*?)\]:\s*(.*)/s', $entry, $matches)) {
                                    $headerText = $matches[1];
                                    $cleanBody = trim($matches[2]);
                                }
                                // Regex Case B: Entry has trailing meta -> Text [2026-05-27 | Name]
                                elseif (preg_match('/^(.*?)\s*\[(\d{4}-\d{2}-\d{2}.*?)\]:?\s*$/s', $entry, $matches)) {
                                    $headerText = trim($matches[2]);
                                    $cleanBody = trim($matches[1]);
                                }
                                // Regex Case C: Bracket tag is buried anywhere inside the text
                                elseif (preg_match('/\[(\d{4}-\d{2}-\d{2}.*?)\]/', $entry, $matches)) {
                                    $headerText = $matches[1];
                                    $cleanBody = trim(str_replace($matches[0], '', $entry));
                                }
                            ?>
                                <div class="row g-3 mb-2 align-items-start">
                                    <div class="col-md-3 offset-md-1">
                                        <label class="form-label text-muted small"><strong>Logged Action:</strong></label>
                                        <div class="p-2 border rounded bg-light text-center small font-monospace shadow-sm" style="font-size: 0.82rem; line-height: 1.4; word-break: break-word;">
                                            <i class="bi bi-clock-history me-1"></i> <?= esc($headerText) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label text-dark">Logged Description:</label>
                                        <textarea class="form-control bg-white shadow-sm" rows="3" style="resize: none;" readonly><?= esc($cleanBody) ?></textarea>
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
                                    <label class="form-label text-success"><strong>Verified By:</strong></label>
                                    <input type="text" class="form-control form-control-sm" value="<?= fullname($record['ver_eng']) ?>" readonly>
                                    <input type="text" class="form-control form-control-sm mt-1" value="<?= $record['ver_date'] ?>" readonly>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">System Operator Verification Remarks:</label>
                                    <textarea class="form-control bg-white mb-2" rows="2" readonly><?= esc($record['ver_remarks']) ?></textarea>
                                    <input type="text" class="form-control <?= ($record['ver_status'] == 'not-satisfied') ? 'is-invalid' : 'is-valid' ?>" value="<?= ucwords('Overall Verification Status: ' . $record['ver_status']) ?>" readonly>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>
                        <div class="row g-3">
                            <label class="form-label"><strong>Update Ticket Status:</strong></label>
                        </div>

                        <?php
                        $unitId = session()->get('login_info')['unit_id'] ?? null;
                        $userRole = user_right($unitId);

                        if ($record['status'] !== 'solved' && $userRole === 'scada_expertise'):
                        ?>
                            <div class="row g-3">
                                <div class="col-md-3 offset-md-1 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="orb_ticket" value="pending" <?= $record['status'] == 'pending' ? 'checked' : '' ?>>
                                        <label class="form-check-label">Keep Pending</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="orb_ticket" value="solved" <?= $record['status'] == 'solved' ? 'checked' : '' ?>>
                                        <label class="form-check-label">Ticket Solved</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="orb_ticket" value="passed" <?= $record['status'] == 'passed' ? 'checked' : '' ?>>
                                        <label class="form-check-label">Ticket Passed</label>
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label id="update_desc"><?= $record['status'] == 'solved' ? 'Enter Solved Procedure:' : ($record['status'] == 'passed' ? 'Enter Passed Reason:' : 'Enter Pending Reason:') ?></label>
                                    <textarea class="form-control" name="update_desc" rows="3" required></textarea>
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
                                <i class="bi bi-lock-fill me-1"></i>
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
                        <?= form_close(); ?> <?php if ($record['status'] === 'solved' && empty($record['ver_eng'])): ?>
                            <hr>
                            <?php if ($userRole === 'system_operator'): ?>
                                <form action="<?= base_url('/tickets/verify_ticket/' . $record['id']) ?>" method="post">
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-12">
                                            <h5 class="text-primary"><i class="fas fa-check-double"></i> System Operator Verification Assessment</h5>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Verification Decision:</label>
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
                                                        <label class="form-label">Review Operational Remarks:</label>
                                                        <textarea class="form-control" name="ver_remarks" rows="3" required placeholder="Provide evaluation statements here..."></textarea>
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
                                    <i class="bi bi-info-circle-fill me-1"></i> Awaiting audit step. This resolved ticket is pending verification review exclusively by a <strong>System Operator</strong>.
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
        // Highlight card conditionally if verified and satisfied
        <?php if ($record['ver_status'] === 'satisfied' && $record['ver_eng']): ?>
            $(".card").addClass("bg-success bg-opacity-10");
        <?php elseif ($record['ver_status'] === 'not-satisfied' && $record['ver_eng']): ?>
            $(".card").addClass("bg-danger bg-opacity-10");
        <?php endif; ?>

        // Real-time verification click feedback response adjustments
        $('input[name="ver_status"]').change(function() {
            if ($(this).val() === 'satisfied') {
                $(".card").removeClass("bg-danger bg-opacity-10").addClass("bg-success bg-opacity-10");
            } else {
                $(".card").removeClass("bg-success bg-opacity-10").addClass("bg-danger bg-opacity-10");
            }
        });

        // Interactive Label Swapping based on chosen radio update value
        $('input[name="orb_ticket"]').change(function() {
            let selectedStatus = $(this).val();
            if (selectedStatus === 'solved') {
                $('#update_desc').text('Enter Solved Procedure:');
            } else if (selectedStatus === 'passed') {
                $('#update_desc').text('Enter Passed Reason:');
            } else {
                $('#update_desc').text('Enter Pending Reason:');
            }
        });
    });
</script>
<?= $this->endSection() ?>