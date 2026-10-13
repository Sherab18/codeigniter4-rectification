<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\StationModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;


class Tickets extends Controller
{
    protected $ticketModel;
    public $session;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        helper(['form', 'url', 'database']);
        $this->session = session();
    }

    public function add()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator!');
        }
        $data = [
            'title' => 'Add New Ticket',
            'errors' => [],
            'not_post' => true,
            'id' => $this->generateTicketId(),
        ];

        return view('tickets/ticket_add', $data);
    }

    public function create()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userRights = user_right($unitId);

        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: Only System Operators can verify tickets!');
        }
        $input = $this->request->getPost();

        $validation = \Config\Services::validation();

        if (!$this->validate([
            'target' => 'required',
            'severity' => 'required',
            'station' => 'required',
            'prob_desc' => 'required|min_length[10]',
            'serv_affected' => 'required|min_length[10]',
        ])) {
            $data = [
                'title' => 'Add New Ticket',
                'errors' => $validation->getErrors(),
                'not_post' => false,
                'id' => $this->generateTicketId(),
            ];
            return view('tickets/ticket_add', $data);
        }

        $ticketData = [
            'id' => $this->generateTicketId(),
            'target' => $input['target'],
            'severity' => $input['severity'],
            'station' => $input['station'],
            'prob_desc' => $input['prob_desc'],
            'serv_affected' => $input['serv_affected'],
            'issue_by' => $this->session->get('login_info')['user_id'],
            'issue_date' => date('Y-m-d H:i:s'),

        ];

        if ($this->ticketModel->insert($ticketData)) {
            $this->session->setFlashdata('success', 'New Ticket raised successfully.');

            return redirect()->to('/tickets/list_tickets/status/new');
        } else {
            return redirect()->back()->with('error', 'There was an issue adding the ticket.');
        }
    }

    private function generateTicketId()
    {
        return 'TICKET-' . strtoupper(uniqid());
    }

    public function ticket_list($field_name, $field_value)
    {
        $ref_date = date('Y-m-d H:i:s', strtotime('-1 month', time()));


        if ($field_name ==  'status') {
            $data['title'] = ucwords('list of ' . $field_value . ' tickets');
            $data['records'] = $this->ticketModel->where($field_name, $field_value)->findAll();
        } elseif ($field_name ==  'issue_by') {
            $data['title'] = is_numeric($field_value) ? ucwords('list of tickets issued by ' . fullname($field_value)) : ucwords('list of tickets issued');
            $data['records'] = $this->ticketModel->where($field_name, $field_value)->where('issue_date >', $ref_date)->findAll();
        } elseif ($field_name ==  'sol_eng') {
            $data['title'] = is_numeric($field_value) ? ucwords('list of tickets solved by ' . fullname($field_value)) : ucwords('list of tickets solved');
            $data['records'] = $this->ticketModel->where($field_name, $field_value)->where('sol_date >', $ref_date)->findAll();
        } else {
            $data['title'] = ucwords('list of all tickets');
            $data['records'] = $this->ticketModel->orderBy('issue_date', 'DESC')->findAll();
        }
        return view('tickets/ticket_list', $data);
    }

    public function ticket_update($id)
    {
        $record = $this->ticketModel->find($id);

        if (!$record) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ticket not found');
        }

        $data = [
            'title' => 'Update Ticket',
            'record' => $record,
            'errors' => [],
            'not_post' => true,
        ];

        return view('tickets/ticket_edit', $data);
    }
    public function save_update_ticket($id)
    {
        $record = $this->ticketModel->find($id);

        if (!$record) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ticket not found');
        }

        if ($record['status'] === 'solved') {
            $this->session->setFlashdata('error', 'This ticket is already solved and cannot be updated.');
            return redirect()->back();
        }

        $input = $this->request->getPost();

        // --- CHRONOLOGICAL LOGGING LOGIC ---
        // Get the current timestamp and username for structural delineation
        
        $currentTime = date('Y-m-d H:i:s');
        $currentUserId = $this->session->get('login_info')['user_id'];
        $currentUserRealName = fullname($currentUserId);

        // Format the new entry block cleanly with line breaks
        $newReasonEntry = "[{$currentTime} | {$currentUserRealName}]:\n" . $input['update_desc'];

        $updateData = [
            'orb_ticket' => $input['orb_ticket'],
            'update_desc' => $input['update_desc'],
            'updated_by' => $currentUserId,
            'updated_at' => $currentTime,
        ];

        if ($input['orb_ticket'] === 'solved') {
            $existingSol = !empty($record['sol_procedure']) ? $record['sol_procedure'] . "|||" : "";
            $updateData['sol_procedure'] = $existingSol . $newReasonEntry;
            
            $updateData['sol_eng'] = $currentUserId;
            $updateData['sol_date'] = $currentTime;
            $updateData['status'] = 'solved';
        } elseif ($input['orb_ticket'] === 'pending') {
            // Append using the explicit '|||' string delimiter
            $existingPen = !empty($record['pen_reason']) ? $record['pen_reason'] . "|||" : "";
            $updateData['pen_reason'] = $existingPen . $newReasonEntry;
            
            $updateData['pen_eng'] = $currentUserId;
            $updateData['pen_date'] = $currentTime;
            $updateData['status'] = 'pending';
        } elseif ($input['orb_ticket'] === 'passed') {
            // Append using the explicit '|||' string delimiter
            $existingPassed = !empty($record['passed_reason']) ? $record['passed_reason'] . "|||" : "";
            $updateData['passed_reason'] = $existingPassed . $newReasonEntry;
            
            $updateData['pen_eng'] = $currentUserId;
            $updateData['pen_date'] = $currentTime;
            $updateData['status'] = 'passed';
        }

        log_message('debug', 'Update Data: ' . json_encode($updateData));
        log_message('debug', 'Ticket ID: ' . $id);

        if ($this->ticketModel->update($id, $updateData)) {
            $this->session->setFlashdata('success', 'Ticket updated successfully.');
            return redirect()->to('/tickets/list_tickets/all/all');
        } else {
            $this->session->setFlashdata('error', 'There was an issue updating the ticket.');
            return redirect()->back();
        }
    }


    public function verify_ticket($id)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userRights = user_right($unitId);

        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: Only System Operators can verify tickets!');
        }

        $ticket = $this->ticketModel->find($id);
        if (!$ticket) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Ticket not found');
        }

        if ($ticket['status'] !== 'solved') {
            return redirect()->back()->with('error', 'Only solved tickets can be verified!');
        }

        $input = $this->request->getPost();

        $validation = \Config\Services::validation();
        if (!$this->validate([
            'ver_status' => 'required',
            'ver_remarks' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $updateData = [
            'ver_status' => $input['ver_status'],
            'ver_remarks' => $input['ver_remarks'],
            'ver_eng' => $this->session->get('login_info')['user_id'],
            'ver_date' => date('Y-m-d H:i:s'),
        ];

        if ($this->ticketModel->update($id, $updateData)) {
            $this->session->setFlashdata('success', 'Ticket verified successfully!');
        } else {
            $this->session->setFlashdata('error', 'Failed to verify ticket!');
        }

        return redirect()->back();
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
