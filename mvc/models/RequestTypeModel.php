<?php

class RequestTypeModel extends DB{
    // check username
    // check password
    function get(){
        return $this->db->run('SELECT * FROM request_type');
    }

}