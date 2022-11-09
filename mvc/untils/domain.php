<?php

class Domain {
    public $domain;

    function __construct(){
        return $GLOBALS['url'] = 'http://' . $_SERVER['SERVER_NAME'] .'/'. 'mini_project_2';
    }

    static function get(){
        return 'http://' . $_SERVER['SERVER_NAME'] .'/'. 'mini_project_2';
    }

}