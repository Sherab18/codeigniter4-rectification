
<h2>Update Energy Data</h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?= \Config\Services::validation()->listErrors(); ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('powerdata/update_energy/' . esc($record['id'])); ?>" method="post">
    <?= csrf_field(); ?>

    <label for="r_date">Date (r_date):</label>
    <input type="date" name="r_date" id="r_date" value="<?= esc($record['r_date']); ?>" required><br>

    <label for="generation_mwh">Generation (MWh):</label>
    <input type="number" step="0.001" name="generation_mwh" id="generation_mwh" value="<?= esc($record['generation_mwh']); ?>" required><br>

    <label for="iex_import_mwh">IEX Import (MWh):</label>
    <input type="number" step="0.001" name="iex_import_mwh" id="iex_import_mwh" value="<?= esc($record['iex_import_mwh']); ?>" required><br>

    <label for="iex_export_mwh">IEX Export (MWh):</label>
    <input type="number" step="0.001" name="iex_export_mwh" id="iex_export_mwh" value="<?= esc($record['iex_export_mwh']); ?>" required><br>

    <label for="energy_met_mwh">Energy Met (MWh):</label>
    <input type="number" step="0.001" name="energy_met_mwh" id="energy_met_mwh" value="<?= esc($record['energy_met_mwh']); ?>" required><br>

    <label for="energy_import_mwh">Energy Import (MWh):</label>
    <input type="number" step="0.001" name="energy_import_mwh" id="energy_import_mwh" value="<?= esc($record['energy_import_mwh']); ?>" required><br>

    <label for="energy_export_mwh">Energy Export (MWh):</label>
    <input type="number" step="0.001" name="energy_export_mwh" id="energy_export_mwh" value="<?= esc($record['energy_export_mwh']); ?>" required><br>

    <label for="peak_demand_mw">Peak Demand (MW):</label>
    <input type="number" step="0.001" name="peak_demand_mw" id="peak_demand_mw" value="<?= esc($record['peak_demand_mw']); ?>" required><br>

    <label for="demand_0900hrs_mw">Demand at 09:00 (MW):</label>
    <input type="number" step="0.001" name="demand_0900hrs_mw" id="demand_0900hrs_mw" value="<?= esc($record['demand_0900hrs_mw']); ?>" required><br>

    <label for="demand_1900hrs_mw">Demand at 19:00 (MW):</label>
    <input type="number" step="0.001" name="demand_1900hrs_mw" id="demand_1900hrs_mw" value="<?= esc($record['demand_1900hrs_mw']); ?>" required><br>

    <label for="peak_exchange_mw">Peak Exchange (MW):</label>
    <input type="number" step="0.001" name="peak_exchange_mw" id="peak_exchange_mw" value="<?= esc($record['peak_exchange_mw']); ?>" required><br>

    <button type="submit">Update Energy Data</button>
</form>