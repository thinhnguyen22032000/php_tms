<?php 

class Log extends Controller{
    private $logModel;
    function __construct(){
        $this->logModel = $this->model("LogModel");
    } 
    function index(){

        $result = $this->logModel->get_request();
        $this->view('master_layout', [
            'Page' => 'logs/index',
            'log' =>  $result
        ]);    
    }
}