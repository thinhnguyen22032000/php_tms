<?php


class RequestModel extends DB
{

    function create($data)
    {
        $flag = true;
        //check forenkey
        $check_request_type = $this->db->run("SELECT * FROM request_type WHERE id =?", $data['request_type_id']);
        if (empty($check_request_type)) {
            $flag = false;
        }
        if (!is_null($data['reason_id'])) {
            $check_reason = $this->db->run("SELECT * FROM reasons WHERE id =?", $data['reason_id']);
            if (empty($check_reason)) {
                $flag = false;
            }
        }
        if ($flag) {
            $user_info = $this->get_user_info($data['user_id']);
            if(!empty($user_info)){
                $result = $this->db->insert('requests', [
                    'start_date' => $data['start_date'],
                    'end_date' => $data['end_date'],
                    'detail_reason' => $data['detail_reason'],
                    'reason_id' => $data['reason_id'],
                    'duration' => $data['duration'],
                    'partial_day' => $data['partial_day'],
                    'request_type_id' => $data['request_type_id'],
                    'user_id' => $data['user_id'],
                    'expected_date' => $data['expected_date'],
                    'supervisor_id' => $user_info[0]['supervisor_id'],
                    'approver_id' => $user_info[0]['approver_id'],
                ]);
                if ($result < 0) {
                    $flag = false;
                } 
            }else{
                $flag = false;
            }
        }
        return $flag;
    }
    
    function get_user_info($user_id){
        return $this->db->run("SELECT id, role_id, supervisor_id, approver_id FROM users WHERE id =?", $user_id);
    }
    function update($data, $request_id, $user_id)
    {
        $flag = true;
        //check forenkey
        $check_request_type = $this->db->run("SELECT * FROM request_type WHERE id =?", $data['request_type_id']);
        if (empty($check_request_type)) {
            $flag = false;
        }
        if (!empty($data['reason_id'])) {
            $check_reason = $this->db->run("SELECT * FROM reasons WHERE id =?", $data['reason_id']);
            if (empty($check_reason)) {
                $flag = false;
            }
        }
        if (is_numeric($request_id)) {
            $request_existing = $this->db->run("SELECT * FROM requests WHERE id =? AND user_id =?", $request_id, $user_id);
            if (empty($request_existing)) {
                $flag = false;
            }
        } else {
            $flag = false;
        }
        if ($flag) {
            $result = $this->db->update('requests', [
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'detail_reason' => $data['detail_reason'],
                'reason_id' => $data['reason_id'],
                'duration' => $data['duration'],
                'partial_day' => $data['partidal_day'],
                'request_type_id' => $data['request_type_id'],
                'last_modify' => date('Y-m-d H:i:s')
            ], [
                'id' => $request_id
            ]);
            if ($result < 0) {
                $flag = false;
            }
        }
        return $flag;
    }


    function handle_time_off_valid($user_id, $role_id)
    {
        $datetime = new DateTime();
        $y = $datetime->format('Y');
        $m = $datetime->format('m');

        $time_off_role = $this->db->run("SELECT
        users.username,
        time_offs.maximun_allowed ,
        time_offs.id
        FROM
            users
        JOIN roles ON users.role_id = roles.id
        JOIN time_offs ON time_offs.id = roles.time_off_id
        WHERE
        roles.id = ? AND users.id = ?", $role_id, $user_id);
        $time_off_valid = 0;
        $time_off_on_current_month = $this->db->run("SELECT   
            user_off.num_day_off,
            user_off.time
                FROM
                   user_off             
                WHERE
            YEAR(time) = ? AND MONTH(time) = ? AND 
             id_user = ?", $y, $m, $user_id);

        if (empty($time_off_on_current_month)) {
            //insert
            $this->db->insert('user_off', [
                'id_time_off' => $time_off_role[0]['id'],
                'id_user' => $user_id,
                'num_day_off' => 0
            ]);
            $time_off_valid = 0;
        } else {
            $time_off_valid = $time_off_on_current_month[0]['num_day_off'];
        }
        $arr['max_day_off'] = $time_off_role[0]['maximun_allowed'];
        $arr['num_day_off'] = $time_off_valid;

        return $arr;
    }


    function get_time_off($user_id)
    {
        $datetime = new DateTime();
        $y = $datetime->format('Y');
        $m = $datetime->format('m');
        $time_off_of_user = $this->db->run("SELECT
        user_off.num_day_off,
        time_offs.name_request,
        time_offs.maximun_allowed,
        time_offs.remainning_quotas,
        time_offs.pending_quotas,
        time_offs.unit
        FROM
            user_off
        JOIN time_offs ON user_off.id_time_off = time_offs.id
        WHERE
        YEAR(TIME) = ? AND MONTH(TIME) = ? AND id_user = ?", $y, $m, $user_id);

        return  $time_off_of_user;
    }

    function get_request_by_id($user_id)
    {
        $result = [];
        if (is_numeric($user_id)) {
            $result = $this->db->run("SELECT
            requests.id,
            request_type.name,
            a.username as 'approver',
            s.username as 'supervisor',
            requests.duration,
            reasons.content,
            requests.detail_reason,
            requests.created_at,
            requests.status,
            requests.start_date,
            requests.end_date,
            requests.created_at
        FROM
            requests
        INNER JOIN users u ON requests.user_id = u.id
        LEFT JOIN users a ON requests.approver_id = a.id
        LEFT JOIN users s ON requests.supervisor_id = s.id
        LEFT JOIN reasons ON requests.reason_id = reasons.id
        INNER JOIN request_type ON requests.request_type_id = request_type.id
        WHERE
            u.id = ?", $user_id);
        }
        return $result;
    }

    function get_request_of_supervisor($user_id)
    {
        return $this->db->run("SELECT
            u.fullname,
            requests.id,
            request_type.name,
            requests.duration,
            reasons.content,
            requests.detail_reason,
            requests.created_at,
            requests.status,
            requests.start_date,
            requests.end_date,
            requests.partial_day
            FROM
                users AS u
            INNER JOIN requests ON requests.user_id = u.id
            LEFT JOIN reasons ON requests.reason_id = reasons.id
            INNER JOIN request_type ON requests.request_type_id = request_type.id
            WHERE
                u.supervisor_id =? ORDER BY requests.created_at DESC", $user_id);
    }

    function get_request($request_id, $user_id, $is_edit = false)
    {
        $request = [];
        if ($user_id && $request_id) {
            $check_req_of_user = $this->db->row("SELECT * FROM requests WHERE id =? AND user_id =?", $request_id, $user_id);
            if (!empty($check_req_of_user)) {
                if ($is_edit) {
                    if ($check_req_of_user['status'] != 'submitted') {
                    } else {
                        $request = $this->db->run(
                            "SELECT
                        requests.id,
                        requests.request_type_id,
                        request_type.name,
                        requests.duration,
                        reasons.content,
                        requests.reason_id,
                        requests.partial_day,
                        requests.detail_reason,
                        users.approver_id,
                        requests.created_at,
                        requests.status,
                        users.fullname,
                        requests.start_date,
                        requests.end_date,
                        requests.expected_date,
                        requests.last_modify
                        FROM
                            users
                        INNER JOIN requests ON requests.user_id = users.id
                        LEFT JOIN reasons ON requests.reason_id = reasons.id
                        INNER JOIN request_type ON requests.request_type_id = request_type.id
                        WHERE
                        requests.id = ?",
                            $request_id
                        );
                    }
                } else {
                    $request = $this->db->run(
                        "SELECT
                    requests.id,
                    requests.request_type_id,
                    request_type.name,
                    requests.duration,
                    reasons.content,
                    requests.reason_id,
                    requests.partial_day,
                    requests.detail_reason,
                    users.approver_id,
                    requests.created_at,
                    requests.status,
                    users.fullname,
                    requests.start_date,
                    requests.end_date,
                    requests.expected_date,
                    requests.last_modify
                    FROM
                        users
                    INNER JOIN requests ON requests.user_id = users.id
                    LEFT JOIN reasons ON requests.reason_id = reasons.id
                    INNER JOIN request_type ON requests.request_type_id = request_type.id
                    WHERE
                    requests.id = ?",
                        $request_id
                    );
                }
            }
        }
        return $request;
    }

    function search($user_id, $request_type, $request_status, $start_date, $end_date)
    {
        $qr = "SELECT
        requests.id,
        request_type.name,
        a.username as 'approver',
        s.username as 'supervisor',
        requests.duration,
        reasons.content,
        requests.detail_reason,
        requests.created_at,
        requests.status,
        requests.start_date,
        requests.end_date,
        requests.created_at
        FROM
            requests
        INNER JOIN users u ON requests.user_id = u.id
        LEFT JOIN users a ON requests.approver_id = a.id
        LEFT JOIN users s ON requests.supervisor_id = s.id
        LEFT JOIN reasons ON requests.reason_id = reasons.id
        INNER JOIN request_type ON requests.request_type_id = request_type.id
        WHERE
        u.id = $user_id";
        if (!empty($start_date) && !empty($end_date)) {
            $qr = $qr . " AND(
                (
                    requests.start_date BETWEEN '$start_date' AND '$end_date'
                ) OR(
                    requests.end_date BETWEEN '$start_date' AND '$end_date'
                ) OR(
                    '$start_date' BETWEEN requests.start_date AND requests.end_date
                )
            )";
        }
        if (!empty($start_date) && empty($end_date)) {
            $qr .= " AND requests.start_date >=  '$start_date'";
        }
        if (empty($start_date) && !empty($end_date)) {
            $qr .= " AND requests.end_date >=  '$end_date'";
        }
        if ($request_type[0] != '') {
            $qr = $qr . " AND requests.request_type_id IN ('" . implode("','", $request_type) . "')";
        }
        if ($request_status[0] != '') {
            $qr = $qr . " AND requests.status IN ('" . implode("','", $request_status) . "')";
        }
        $qr .= " ORDER BY requests.created_at DESC";
        $result = $this->db->run($qr);
        $this->db->insert('log_request_search', [
            'user_id' => $user_id,
            'query' => $qr,
            'result' => json_encode($result)
        ]);
        return  $result;
    }

    function search_supervisor($user_id, $request_type, $request_status, $start_date, $end_date)
    {
        $requests = [];
        $requests = $this->db->run("SELECT
            u.fullname,
            requests.id,
            request_type.name,
            requests.duration,
            reasons.content,
            requests.detail_reason,
            requests.created_at,
            requests.status,
            requests.start_date,
            requests.end_date,
            requests.partial_day,
            request_type.id as 'request_type',
            requests.created_at
        FROM
            users AS u
        INNER JOIN requests ON requests.user_id = u.id
        LEFT JOIN reasons ON requests.reason_id = reasons.id
        INNER JOIN request_type ON requests.request_type_id = request_type.id
        WHERE
            u.supervisor_id =? ORDER BY requests.created_at DESC", $user_id);

        if (!empty($start_date) && !empty($end_date)) {
            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $result = [];
            foreach ($requests as $item) {
                $_start = new DateTime($item['start_date']);
                $_end = new DateTime($item['end_date']);
                if (($_start >= $start) && ($_end <= $end)) {
                    array_push($result, $item);
                }
            }
            $requests = $result;
        }
        if ($request_type[0] != '') {
            $result = [];
            foreach ($requests as $item) {
                if (in_array($item['request_type'], $request_type)) {
                    array_push($result, $item);
                }
            }
            $requests = $result;
        }
        if ($request_status[0] != '') {
            $result = [];
            foreach ($requests as $item) {
                if (in_array($item['status'], $request_status)) {
                    array_push($result, $item);
                }
            }
            $requests = $result;
        }
        return  $requests;
    }

    private function update_status_request($request_id, $request_status)
    {
        $result = $this->db->update('requests', [
            'status' => $request_status,
            'last_modify' => date('Y-m-d H:i:s')
        ], [
            'id' => $request_id
        ]);
        return $result > 0 ? true : false;
    }

    function handle_request_stutus($user_id, $request_id, $request_status, $role_id)
    {
        switch ($request_status) {
            case 'cancelled':
                if ($role_id == 1) {
                    if ($this->update_status_request($request_id,  $request_status)) {
                        return $this->db->run("SELECT * FROM requests WHERE id =? AND user_id =?", $request_id, $user_id);
                    }
                } else {
                    return array();
                }
                break;
            case 'confirmed':
                if ($role_id == 2) {
                    $request_existing = $this->db->run("SELECT * FROM requests WHERE id =?", $request_id);
                    if ($request_existing[0]['status'] == 'cancelled') {
                        return array();
                    } else {
                        return $this->update_status_request($request_id,  $request_status);
                    }
                } else {
                    return array();
                }
                break;
            default:
                break;
        }
    }
}
