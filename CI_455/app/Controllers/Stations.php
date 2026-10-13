<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StationModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Stations extends Controller
{
    public $session;
    public $stationModel;
    public function __construct()
    {
        helper(['form', 'date', 'database']);
        $this->session = session();
        $this->stationModel = new StationModel();
    }

    /*------------------------------------------------------------------------------------------------------------------------
	*	STATIONS
	*/
    public function station_update($stn_id)
    {
        if ($this->request->isAJAX()) {
            if (user_right(user_details($this->session->get('login_info')['user_id'])['unit_id']) == 'system_analyst') {
                if (intval($stn_id) != 0) {
                    $post_data = [
                        'id' => intval($stn_id),
                        'station' => ucwords(trim($this->request->getPost('station'))),
                        'capacity' => trim($this->request->getPost('capacity')),
                        'voltage' => $this->request->getPost('voltage'),
                        'updated_by' => $this->session->get('login_info')['user_id'],
                        'updated_at' => date('Y-m-d H:i:s', now('Asia/Thimphu')),
                    ];
                } else {
                    $post_data = [
                        'id' => $this->stationModel->countAll() + 1,
                        'station' => ucwords(trim($this->request->getPost('station'))),
                        'capacity' => trim($this->request->getPost('capacity')),
                        'voltage' => $this->request->getPost('voltage'),
                        'created_by' => $this->session->get('login_info')['user_id'],
                        'created_at' => date('Y-m-d H:i:s', now('Asia/Thimphu')),
                    ];
                }

                if ($this->stationModel->save($post_data) == true) {
                    $correct_sentence = (intval($stn_id) != 0) ? ' station updated successfully!' : ' station created successfully!';
                    echo json_encode(array('status' => 'success', 'message' => ucwords($post_data['station']) . $correct_sentence));
                } else {
                    echo json_encode(array('status' => 'fail_1', 'errors' => $this->stationModel->errors()));
                }
            } else {
                echo json_encode(array('status' => 'fail_2', 'message' => 'You are not a System Analyst! You cannot Update Station record.'));
            }
        }
    }

    public function station_list($kv = null, $stn_id = null)
    {
        log_message('info', 'Station list called with kv: ' . $kv . ', stn_id: ' . $stn_id);

        if ($this->request->isAJAX()) {
            if (is_numeric($stn_id)) {
                $record = $this->stationModel->where('id', $stn_id)->first();
                echo json_encode($record);
            } else {
                $records = $this->stationModel->where('voltage', $kv)->orderBy('station', 'ASC')->findAll();
                echo json_encode($records);
            }
        } else {
            if (is_numeric($kv)) {
                $data['records'] = $this->stationModel->where('voltage', $kv)->orderBy('station', 'ASC')->findAll();
                $data['title'] = ucwords('List of ' . $kv . 'kV Stations');
            } else {
                $data['records'] = $this->stationModel->where('voltage', 'no_voltage')->orderBy('station', 'ASC')->findAll();
                $data['title'] = ucwords('List of Control Centers');
            }
            return view('stations/station_list', $data);
        }
    }
    /*------------------------------------------------------------------------------------------------------------------------
	* REMAP to prevent unauthorized method access
	*/
    public function _remap($method, $param1 = null, $param2 = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param1, $param2);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
}
