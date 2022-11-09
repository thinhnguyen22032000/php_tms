<?php

class ReasonModel extends DB{
    // check username
    // check password
    function getById($id){
        return $this->db->run('SELECT * FROM reasons WHERE request_type_id = ?',$id);
    }

}