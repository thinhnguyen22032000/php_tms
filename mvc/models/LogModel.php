<?php

class logModel extends DB{
    // check username
    // check password
    function get_request(){
        return $this->db->run('SELECT * FROM log_request_search ORDER BY created_at DESC');
    }

}