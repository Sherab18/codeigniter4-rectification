<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EnergyModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Powerdata extends Controller
{
    public $session;
    public $energyModel;

    public function __construct()
    {
        helper(['form', 'date', 'database']);
        $this->session = session();
        $this->energyModel = new EnergyModel();
    }

    public function energy_add()
    {
        $unit_id = $this->session->get('login_info')['unit_id'];
        if (user_right($unit_id) !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator.');
        }

        return view('energydata/energy_add');
    }

    public function energy_store()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userRights = user_right($unitId);
        
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator.');
        }

        if (!$this->validate($this->energyModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'r_date'            => $this->request->getPost('r_date'),
            'generation_mwh'    => $this->request->getPost('generation_mwh'),
            'iex_import_mwh'    => $this->request->getPost('iex_import_mwh'),
            'iex_export_mwh'    => $this->request->getPost('iex_export_mwh'),
            'energy_met_mwh'    => $this->request->getPost('energy_met_mwh'),
            'energy_import_mwh' => $this->request->getPost('energy_import_mwh'),
            'energy_export_mwh' => $this->request->getPost('energy_export_mwh'),
            'peak_demand_mw'    => $this->request->getPost('peak_demand_mw'),
            'demand_0900hrs_mw' => $this->request->getPost('demand_0900hrs_mw'),
            'demand_1900hrs_mw' => $this->request->getPost('demand_1900hrs_mw'),
            'peak_exchange_mw'  => $this->request->getPost('peak_exchange_mw'),
            'created_by'        => $this->session->get('login_info')['user_id'],
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
            'version'           => 1,
        ];

        $this->energyModel->insert($data);
		// --- Change the return line inside energy_store() to this: ---
return redirect()->to(base_url('powerdata/list_energy'))->with('success', 'Energy data added successfully.');
    }

    /**
     * CLEANED UP EDIT METHOD matching MWh naming conventions of your view form.
     */
    public function energy_edit($id = null)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator.');
        }

        $data['record'] = $this->energyModel->where('id', $id)->first();

        if (!$data['record']) {
            return redirect()->to('/powerdata/list_energy')->with('error', 'Record not found.');
        }

        // Block updating if record is finalized
        if ($data['record']['version'] >= 100) {
            return redirect()->to('/powerdata/list_energy')->with('error', 'This record is finalized (Version 100+) and cannot be edited.');
        }

        $data['not_post'] = true;
        $data['errors'] = [];

        // Using safe CI4 framework check for POST requests
        if ($this->request->is('post')) {
            $validationRules = [
                'generation_mwh'    => 'required|numeric',
                'iex_import_mwh'    => 'required|numeric',
                'iex_export_mwh'    => 'required|numeric',
                'energy_met_mwh'    => 'required|numeric',
                'energy_import_mwh' => 'required|numeric',
                'energy_export_mwh' => 'required|numeric',
                'peak_demand_mw'    => 'required|numeric',
                'demand_0900hrs_mw' => 'required|numeric',
                'demand_1900hrs_mw' => 'required|numeric',
                'peak_exchange_mw'  => 'required|numeric'
            ];

            if ($this->validate($validationRules)) {
                $updateData = [
                    'generation_mwh'    => trim($this->request->getPost('generation_mwh')),
                    'iex_import_mwh'    => trim($this->request->getPost('iex_import_mwh')),
                    'iex_export_mwh'    => trim($this->request->getPost('iex_export_mwh')),
                    'energy_met_mwh'    => trim($this->request->getPost('energy_met_mwh')),
                    'energy_import_mwh' => trim($this->request->getPost('energy_import_mwh')),
                    'energy_export_mwh' => trim($this->request->getPost('energy_export_mwh')),
                    'peak_demand_mw'    => trim($this->request->getPost('peak_demand_mw')),
                    'demand_0900hrs_mw' => trim($this->request->getPost('demand_0900hrs_mw')),
                    'demand_1900hrs_mw' => trim($this->request->getPost('demand_1900hrs_mw')),
                    'peak_exchange_mw'  => trim($this->request->getPost('peak_exchange_mw')),
                    'updated_by'        => $userId,
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'version'           => $data['record']['version'] + 1,
                ];

                if ($this->energyModel->update($id, $updateData)) {
                    return redirect()->to('/powerdata/list_energy')->with('success', 'Energy data updated successfully');
                } else {
                    $data['errors'] = $this->energyModel->errors();
                    $this->session->setFlashdata('error', 'Database layer rejection: Failed to update entry.');
                    $data['not_post'] = false;
                }
            } else {
                $data['errors'] = $this->validator->getErrors();
                $data['not_post'] = false;
            }
        }

        return view('energydata/energy_edit', $data);
    }

    public function energy_list($param1 = null)
    {
        if ($param1 == 'incomplete') {
            $data['records'] = $this->energyModel->where('version <', 100)->orderBy('created_at', 'DESC')->findAll();
            $data['title'] = 'List of Incomplete Energy Data';
        } else {
            $data['records'] = $this->energyModel->orderBy('created_at', 'DESC')->findAll();
            $data['title'] = 'List of All Energy Data';
        }
        return view('energydata/energy_list', $data);
    }

    // REMAP to handle routing checks elegantly
    public function _remap($method, $param1 = null, $param2 = null)
    {
        // Route alternative update methods straight to energy_edit to prevent errors
        if ($method === 'energy_update') {
            $method = 'energy_edit';
        }

        if (method_exists($this, $method)) {
            return $this->$method($param1, $param2);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
}