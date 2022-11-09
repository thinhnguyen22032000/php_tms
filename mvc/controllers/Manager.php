<?php 

class Manager extends Controller{
    
    function index(){
        $this->view('master_layout', [
            'Page' => 'manager/index'
        ]);
    }
}