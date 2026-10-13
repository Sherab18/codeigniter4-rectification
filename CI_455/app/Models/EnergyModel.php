<?php

namespace App\Models;

use CodeIgniter\Model;

class EnergyModel extends Model
{
	protected $table = 'd_energy';
	protected $primaryKey = 'id';

	protected $useAutoIncrement = true;

	protected $returnType = 'array';
	protected $useSoftDeletes = false;

	protected $allowedFields = [
		'id',
		'r_date',
		'generation_mwh',
		'iex_import_mwh',
		'iex_export_mwh',
		'energy_met_mwh',
		'energy_import_mwh',
		'energy_export_mwh',
		'peak_demand_mw',
		'demand_0900hrs_mw',
		'demand_1900hrs_mw',
		'peak_exchange_mw',
		'created_by',
		'created_at',
		'updated_by',
		'updated_at',
		'version',
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat = 'datetime';
	protected $createdField = 'created_at';
	protected $updatedField = 'updated_at';
	protected $deletedField = 'deleted_at';

	// Validation
	protected $validationRules = [
		'r_date' => 'required|is_unique[d_energy.r_date]',
		'iex_import_mwh' => 'required',
		'iex_export_mwh' => 'required',
		'energy_met_mwh' => 'required',
		'energy_import_mwh' => 'required',
		'energy_export_mwh' => 'required',
		'peak_demand_mw' => 'required',
		'demand_0900hrs_mw' => 'required',
		'demand_1900hrs_mw' => 'required',
		'peak_exchange_mw' => 'required',
	];
	protected $validationMessages = [
		'r_date' => [
			'required' => 'The Date field is required.',
			'is_unique' => 'Data exists in database with same date.',
		],
		'generation_mwh' => [
			'required' => 'The Generation field is required.',
		],
		'iex_import_mwh' => [
			'required' => 'The IEX Import field is required.',
		],
		'iex_export_mwh' => [
			'required' => 'The IEX Export field is required.',
		],
		'energy_met_mwh' => [
			'required' => 'The Energy Met field is required.',
		],
		'energy_import_mwh' => [
			'required' => 'The Energy Import field is required.',
		],
		'energy_export_mwh' => [
			'required' => 'The Energy Export field is required.',
		],
		'peak_demand_mw' => [
			'required' => 'The Peak Demand field is required.',
		],
		'demand_0900hrs_mw' => [
			'required' => 'The Demand Met at 09:00hrs field is required.',
		],
		'demand_1900hrs_mw' => [
			'required' => 'The Demand Met at 19:00hrs field is required.',
		],
		'peak_exchange_mw' => [
			'required' => 'The Peak exchange field is required.',
		],
	];
	protected $skipValidation = false;
	protected $cleanValidationRules = true;

	protected $allowCallbacks = true;
	protected $beforeInsert = [];
	protected $afterInsert = [];
	protected $beforeUpdate = [];
	protected $afterUpdate = [];
	protected $beforeFind = [];
	protected $afterFind = [];
	protected $beforeDelete = [];
	protected $afterDelete = [];


	public function getLatestEnergyData()
{
    return $this->select('r_date, generation_mwh, peak_demand_mw, energy_met_mwh, energy_export_mwh, created_at')
               ->orderBy('r_date', 'DESC')
               ->first();
}
}
