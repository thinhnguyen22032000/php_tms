<?php

class PageError extends Controller {

    function index(){
        $this->view('master_layout', [
            'Page' => 'error/404'
        ]);
    }
}