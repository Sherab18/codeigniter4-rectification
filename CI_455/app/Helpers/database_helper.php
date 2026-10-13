<?php

/*------------------------------------------------------------------------------------------------------------------------
*   User
*/
//  Get Fullname from User Id
function fullname($user_id = 'no_Id')
{
    $db = \Config\Database::connect();
    $builder = $db->table('b_users');
    $user = $builder->where('id', $user_id)->get()->getRowArray();


    if ($user) {
        $givenName = $user['given_name'] ?? 'N/A'; // Safely access given_name
        $lastName = $user['last_name'] ?? 'N/A';   // Safely access last_name
        return ucwords($givenName . ' ' . $lastName);
    } else {
        return null; // Return null if user is not found
    }
}



//  Get Unit details from User Id
function user_details($user_id = 'no_id')
{
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($user_id);
    if ($user) {
        return $user;
    } else {
        return Null;
    }
}


/*------------------------------------------------------------------------------------------------------------------------
*   Office
*/
//  Get User Rights from Unit Id
function user_right($unit_id = 'no_id')
{
    $officeModel = new \App\Models\OfficeModel();
    $rights = $officeModel->find($unit_id);

    // Check if $rights exists and has the key 'unit_right'
    if ($rights && isset($rights['unit_right'])) {
        return $rights['unit_right'];  // return the user rights
    } else {
        return null;  // No rights found
    }
}

/*------------------------------------------------------------------------------------------------------------------------
*   Ticket
*/
//  Count Tickets based on Field Value
function num_ticket($field_name, $field_val)
{
    $ticketModel = new \App\Models\TicketModel();
    $num_ticket = $ticketModel->where($field_name, $field_val)->countAllResults();
    if ($num_ticket) {
        return $num_ticket;
    } else {
        return Null;
    }
}

//	Find top Employee
function emp_ticket($emp_type = 'issuer')
{
    helper('date');
    $ref_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', now('Asia/Thimphu')) . ' - 1 month'));
    $ticketModel = new \App\Models\TicketModel();
    if ($emp_type == 'issuer') {
        $records = $ticketModel->where('issue_date >', $ref_date)->findAll();
        if ($records) {
            return top_emp($records, 'issue_by');
        } else {
            return Null;
        }
    } elseif ($emp_type = 'solver') {
        $records = $ticketModel->where('sol_date >', $ref_date)->findAll();
        if ($records) {
            return top_emp($records, 'sol_eng');
        } else {
            return Null;
        }
    }
}

//  Function find top employee
function top_emp($records, $field_name)
{
    $emp_list = [];
    foreach ($records as $row) {
        array_push($emp_list, $row[$field_name]);
    }
    $emp_count = array_count_values($emp_list);
    $max_count = 0;
    foreach ($emp_count as $id => $count) {
        if ($count > $max_count) {
            $max_count = $count;
            $top_emp = $id;
        }
    }
    return $top_emp;
}


/*------------------------------------------------------------------------------------------------------------------------
*   Station
*/
//  Get Station details station Id
function station_details($stn_id = 'no_id')
{
    $stationModel = new \App\Models\StationModel();
    $station = $stationModel->find($stn_id);
    if ($station) {
        return $station;
    } else {
        return Null;
    }
}
