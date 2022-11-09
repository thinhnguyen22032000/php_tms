<?php 
function d_session($session_arr){
    if(is_array($session_arr)){
        foreach($session_arr as $session){
         unset($_SESSION[$session]);
        }
    }
}
?>