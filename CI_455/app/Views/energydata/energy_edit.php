<?= $this->extend('layouts/layouts_user') ?>

<?= $this->section('title') ?>
Energy Data | Bhutan Power System Operator
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $this->include('partials/navbar_user') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col col-md-3">
                <?= $this->include('energydata/energy_sidebar') ?><br>
            </div>

            <div class="col col-md-9">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <div class="card border-dark">
                    <div class="card-header text-center text-white bg-primary"><strong>Update Energy Data</strong></div>
                    <div class="card-body">
                        <?= form_open(); ?>
                        <div class="row g-2">
                            <label class="form-label"><strong>Report Date:</strong></label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3 offset-md-1">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Date</span>
                                    <input type="text" class="form-control" value="<?= esc($record['r_date']) ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Version</span>
                                    <input type="text" class="form-control" value="<?= esc($record['version'] ? $record['version'] : 0) ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <label class="form-label"><strong>Data Entry:</strong></label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3 offset-md-1">
                                <label class="form-label">Created By:</label>
                                <input type="text" class="form-control" value="<?= esc(fullname($record['created_by'])) ?>" readonly>
                                <label class="form-label">Created Time:</label>
                                <input type="text" class="form-control" value="<?= esc($record['created_at']) ?>" readonly>
                            </div>
                            <?php if (!empty($record['updated_by'])): ?>
                                <div class="col-md-3">
                                    <label class="form-label">Updated By:</label>
                                    <input type="text" class="form-control" value="<?= esc(fullname($record['updated_by'])) ?>" readonly>
                                    <label class="form-label">Updated Time:</label>
                                    <input type="text" class="form-control" value="<?= esc($record['updated_at']) ?>" readonly>
                                </div>
                            <?php endif; ?>
                        </div><br>
                        
                        <div class="row g-2 border-top pt-2">
                            <label class="form-label"><strong>Daily Energy Data (MWh):</strong></label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3 offset-md-1">
                                <label class="form-label">Total Generation</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['generation_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="generation_mwh" step="0.001" value="<?= esc(old('generation_mwh', $record['generation_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['generation_mwh'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Import from IEX Exchange</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['iex_import_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="iex_import_mwh" step="0.001" value="<?= esc(old('iex_import_mwh', $record['iex_import_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['iex_import_mwh'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Export through IEX Exchange</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['iex_export_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="iex_export_mwh" step="0.001" value="<?= esc(old('iex_export_mwh', $record['iex_export_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['iex_export_mwh'] ?? '' ?></div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-3 offset-md-1">
                                <label class="form-label">Daily Energy Met</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['energy_met_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="energy_met_mwh" step="0.001" value="<?= esc(old('energy_met_mwh', $record['energy_met_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['energy_met_mwh'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Energy Import from India</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['energy_import_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="energy_import_mwh" step="0.001" value="<?= esc(old('energy_import_mwh', $record['energy_import_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['energy_import_mwh'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Energy Export to India</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['energy_export_mwh']) ? 'is-valid' : 'is-invalid') ?>" name="energy_export_mwh" step="0.001" value="<?= esc(old('energy_export_mwh', $record['energy_export_mwh'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['energy_export_mwh'] ?? '' ?></div>
                            </div>
                        </div><br>
                        
                        <div class="row g-2 border-top pt-2">
                            <label class="form-label"><strong>Daily Power Data (MW):</strong></label>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-3 offset-md-1">
                                <label class="form-label">Peak Demand Met</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['peak_demand_mw']) ? 'is-valid' : 'is-invalid') ?>" name="peak_demand_mw" step="0.01" value="<?= esc(old('peak_demand_mw', $record['peak_demand_mw'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['peak_demand_mw'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Demand Met at 09:00 hrs</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['demand_0900hrs_mw']) ? 'is-valid' : 'is-invalid') ?>" name="demand_0900hrs_mw" step="0.01" value="<?= esc(old('demand_0900hrs_mw', $record['demand_0900hrs_mw'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['demand_0900hrs_mw'] ?? '' ?></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Demand Met at 19:00 hrs</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['demand_1900hrs_mw']) ? 'is-valid' : 'is-invalid') ?>" name="demand_1900hrs_mw" step="0.01" value="<?= esc(old('demand_1900hrs_mw', $record['demand_1900hrs_mw'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['demand_1900hrs_mw'] ?? '' ?></div>
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-md-3 offset-md-1">
                                <label class="form-label">Peak Exchange</label>
                                <input type="number" class="form-control <?= $not_post ? '' : (empty($errors['peak_exchange_mw']) ? 'is-valid' : 'is-invalid') ?>" name="peak_exchange_mw" step="0.01" value="<?= esc(old('peak_exchange_mw', $record['peak_exchange_mw'])) ?>" <?= ($record['version'] < 100) ? '' : 'readonly' ?>>
                                <div class="invalid-feedback"><?= $errors['peak_exchange_mw'] ?? '' ?></div>
                            </div>
                        </div><br>
                        
                        <?php if ($record['version'] < 100): ?>
                            <div class="row g-2 border-top pt-3">
                                <div class="col-md-4 offset-md-1">
                                    <button class="btn btn-outline-primary" type="submit" id="btn_submit">Update Record</button>
                                </div>
                                <div class="col-md-4 offset-md-2">
                                    <a href="<?= base_url('powerdata/list_energy/') ?>" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>