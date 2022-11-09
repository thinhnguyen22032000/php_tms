<?php
class UserModel extends DB{

    function get(){
        // $sql = "SELECT * FROM user";
        // return mysqli_query($this->con, $sql);
        $userData = $this->db->row(
            "SELECT * FROM tbl_user"
        );
       
    }

    
    
    public function detail($id){
        $sql = "SELECT * FROM user WHERE id = '$id' LIMIT 1";
        return mysqli_query($this->con, $sql);
    }

    function create($username, $password){
        $flag = false;    
        $sql =  "INSERT INTO user VALUES(null,'$username', '$password')";
        if(mysqli_query($this->con, $sql)){
           $flag = true;    
        }   
        return $flag;
    }

    function update($id, $username, $password, $id_role){
        $flag = false;    
        $sql =  "UPDATE user SET username = '$username', password = '$password', id_role = '$id_role' WHERE id = '$id'";
        if(mysqli_query($this->con, $sql)){
           $flag = true;    
        }   
        return $flag;
    }

    function delete($id){
        $flag = false;    
        $sql =  "DELETE FROM user WHERE id = '$id'";;
        if(mysqli_query($this->con, $sql)){
           $flag = true;    
        }   
        return $flag;
    }
}