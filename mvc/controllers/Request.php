<?php
require './mvc/helpers/validation.php';
require './mvc/untils/date.php';

class Request extends Controller
{

    private $requestModel;
    private $user_id;
    private $role_id;
    function __construct()
    {
        $this->requestModel = $this->model("RequestModel");
        $this->user_id = $_SESSION['user_info']['user_id'];
        $this->role_id = $_SESSION['user_info']['role_id'];
    }

    function index()
    {    
        if(isset($this->role_id) && $this->role_id == 1 ) {
            $this->view('master_layout', [
                'Page' => 'request/index',
            ]);     
        }else{
            $this->redirect('auth');
        }
    }

    function edit($request_id)
    {
        if(isset($this->role_id) && $this->role_id == 1 ) {
            $request = $this->requestModel->get_request($request_id, $this->user_id, true);
            if (empty($request)) {
                $this->redirect('request', ['notify' => "Request is invalid"]);
            }
            $time_off_data = $this->requestModel->get_time_off($this->user_id);
            $this->view('master_layout', [
                'Page' => 'request/edit',
                'request' => $request,
                'time_off_data' =>  $time_off_data,
    
            ]);
        }else{
            $this->redirect('auth');
        }
    }

    function user_request()
    {
        if ($this->role_id == 1) {
            echo json_encode($this->requestModel->get_request_by_id($this->user_id));
        } elseif ($this->role_id == 2) {
            echo json_encode($this->requestModel->get_request_of_supervisor($this->user_id));
        }
    }

    function create()
    {
        if($this->role_id == 1){
            $user_id = $_SESSION['user_info']['user_id'];
            $time_off_data = $this->requestModel->get_time_off($user_id);
            $user_fullname = $_SESSION['user_info']['fullname'];
            $this->view('master_layout', [
                'Page' => 'request/create',
                'time_off_data' =>  $time_off_data,
                'user_fullname' => $user_fullname
            ]);
        }else{
            $this->redirect('request/confirm_management');
        }
    }

    function store()
    {
        if (!isset($_POST)) {
            $this->redirect('request');
        }
        $data = [];
        $data['user_id'] = $this->user_id;
        $data['start_date'] = $_POST['start_date'];
        $data['end_date'] = $_POST['end_date'];
        $data['detail_reason'] = trim($_POST['detail_reason']);
        $data['reason_id'] = !empty($_POST['reason_id']) ? $_POST['reason_id'] : null;
        $data['request_type_id'] = $_POST['request_type_id'];
        $data['user_id'] = $_SESSION['user_info']['user_id'];
        $data['partial_day'] = $_POST['partial_day'];
        $data['expected_date'] = $_POST['expected_date'];
        $data['duration'] =  DateLib::duration($data['start_date'], $data['end_date'], $data['partial_day']);
        $vals = [
            'start_date' =>  $data['start_date'],
            'end_date' => $data['end_date'],
            'detail_reason' => $data['detail_reason'],
            'request_type_id' =>  $data['request_type_id'],
            'user_id' => $data['user_id'],
        ];
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'detail_reason' => 'max:50',
            'request_type_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ];
        $result = Validation::validator($vals, $rules);
        $redirect_data = [];
        if (!empty($result)) {
            $redirect_data = ['error' => 'Error on during create Request please go away'];
        } else {
            $result = $this->requestModel->create($data);
            if ($result) {
                $redirect_data = ['notify' => 'Created request success!'];
            } else {
                $redirect_data = ['notify' => 'Error when create request!'];
            }
        }
        $this->redirect('request', $redirect_data);
    }

    function update($request_id)
    {
        if (!isset($_POST)) {
            $this->redirect('request');
        }
        $data = [];
        $data['start_date'] = $_POST['start_date'];
        $data['end_date'] = $_POST['end_date'];
        $data['detail_reason'] = trim($_POST['detail_reason']);
        $data['reason_id'] = $_POST['reason_id'];
        $data['request_type_id'] = $_POST['request_type_id'];
        $data['user_id'] = $_SESSION['user_info']['user_id'];
        $data['partidal_day'] = $_POST['partial_day'];
        $data['expected_date'] = $_POST['expected_date'];

        $data['duration'] =  DateLib::duration($data['start_date'], $data['end_date'], $data['partidal_day']);
        $vals = [
            'start_date' =>  $data['start_date'],
            'end_date' => $data['end_date'],
            'detail_reason' => $data['detail_reason'],
            'request_type_id' =>  $data['request_type_id'],
            'user_id' => $data['user_id'],
        ];
        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
            'detail_reason' => 'max:50',
            'request_type_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ];
        $result = Validation::validator($vals, $rules);
        $redirect_data = [];
        if (!empty($result)) {
            $redirect_data = ['error' => 'Error on during update Request please go away'];
        } else {
            $result = $this->requestModel->update($data, $request_id, $this->user_id);
            if ($result) {
                $redirect_data = ['notify' => 'Update request success!'];
            } else {
                $redirect_data = ['notify' => 'Error when update request!'];
            }
        }
        $this->redirect('request', $redirect_data);
    }

    function time_off($user_id)
    {
        echo json_encode($this->requestModel->get_time_off($user_id));
    }

    function time_off_valid(){
        echo json_encode($this->requestModel->handle_time_off_valid($this->user_id, $this->role_id));
    }

    function get($request_id)
    {
        echo json_encode($this->requestModel->get_request($request_id, $this->user_id));
    }

    function request_search()
    {
        $request_type = explode(',', $_POST['request_type']);
        // $request_type = $_POST['request_type'];
        $request_status = explode(',', $_POST['request_status']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        echo json_encode($this->requestModel->search($this->user_id, $request_type, $request_status, $start_date, $end_date));
    }

    function request_search_supervisor()
    {
        $request_type = explode(',', $_POST['request_type']);
        $request_status = explode(',', $_POST['request_status']);
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        echo json_encode($this->requestModel->search_supervisor($this->user_id, $request_type, $request_status, $start_date, $end_date));
    }

    function request_stutus_change($request_id, $request_status)
    {
        // $data_redirect = '';
        // $request_status_array = ['submitted', 'confirmed', 'approved', 'rejected', 'cancelled'];
        // if (!in_array($request_status, $request_status_array)) {
        //     $data_redirect = ['notify' => 'Request status is not valid'];
        // } else {
        //     $result = $this->requestModel->handle_request_stutus($this->user_id, $request_id, $request_status, $this->role_id);
        //     if ($result) {
        //         $data_redirect = ['notify' => 'Update request status success!'];
        //     } else {
        //         $data_redirect = ['notify' => 'Update request status faild!'];
        //     }
        // }
        // $this->redirect('request', $data_redirect);

        $data = [];
        $request_status_array = ['submitted', 'confirmed', 'approved', 'rejected', 'cancelled'];
        if (!in_array($request_status, $request_status_array)) {
            $data = ['error' => 'Request status is not valid'];
        } else {
            $result = $this->requestModel->handle_request_stutus($this->user_id, $request_id, $request_status, $this->role_id);
            if (!empty($result)) {
                $data = ['data' => $result];
            } else {
                $data = ['error' => 'Update request status faild!'];
            }
        }
        echo json_encode($data);
    }

    function confirm_management()
    {
        if(isset($this->role_id) && $this->role_id == 2 ) {
            $this->view('master_layout', [
                'Page' => 'request/confirm_management',
                // 'requests' => $requests
            ]);
        }else{
            $this->redirect('auth');
        }
    }
}
