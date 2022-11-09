<?php

class OrderModel extends DB{
    function create($food_name, $note='', $orderer){
        $flag = true;
        $result = $this->db->insert('tbl_order', [
            'order_id' => null,
            'food_name' => $food_name,
            'note' => $note,
            'orderer' => $orderer,
            'created_at' => date('Y-m-d H:i:s',time())
        ]);
        if(!$result){
            $flag = false;  
        }
        return $flag;
    }

    function get(){
        return $this->db->run('SELECT * FROM tbl_order');
    }

    function pagination($start, $itemOfPage){
        return $this->db->run("SELECT * FROM tbl_order LIMIT $start , $itemOfPage");
    }
}