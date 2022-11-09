<?php
function alert_msg($check_msg_err, $lang)
{
    if ($check_msg_err) {
        if (is_array($_SESSION['error_msg'])) {
            foreach ($_SESSION['error_msg'] as $key => $value) {
                echo $value . ' <br />';
            }
        } else {
            echo $lang[$_SESSION['error_msg']];
        }
    } else {
        echo isset($_SESSION['notify_msg']) ? $lang[$_SESSION['notify_msg']] : $lang['WELCOME'];
    }
}
