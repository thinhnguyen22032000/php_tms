<?php
class Helpers {
    static function set_session_and_navigate($key_msg = 'error_msg', $values,  $navigation= 'https//google.com'){
        // unset($_SESSION['error_msg']);
        $url = Domain::get();
        $_SESSION[$key_msg] = $values;
        $location = 'location: '.$url.'/'.$navigation;
        header($location);
    }
}