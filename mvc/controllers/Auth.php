<?php


require './mvc/helpers/helpers.php';
require './mvc/helpers/validation.php';

class Auth extends Controller
{

    private $authModel;

    function __construct()
    {
        $this->authModel = $this->model("AuthModel");
    }

    function index()
    {
        $this->view('public_layout');
    }

    function register()
    {
        $this->view('public_layout', [
            'Page' => 'auth/register'
        ]);
    }

    function authLogin()
    {
        $url_redirect = '';
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if(preg_match("/^[a-zA-Z0-9]+$/", $username) == 0) {
            $_SESSION['error_msg'] = "The username is invalid";
            $this->redirect('auth');
            die();
        }
        $vals = [
            'username' => $username,
            'password' => $password
        ];
        $rules = [
            'username' => 'required|max:20',
            'password'  => 'required|max:300',
        ];
        $result = Validation::validator($vals, $rules);
        if (!empty($result)) {
            $_SESSION['error_msg'] = $result;
            $url_redirect = 'auth/login';
        } else {
            // validation passes
            $user = $this->authModel->login($username, $password);
            if (!empty($user)) {
                $_SESSION['user_info'] = [
                 'user_id' => $user['id'],
                 'username' => $user['username'],
                 'role_id' => $user['role_id'],
                 'approver_id' => $user['approver_id'],
                 'supervisor_id' => $user['supervisor_id'],
                 'fullname' => $user['fullname'], 
                 'supervisor' => $user['supervisor'],
                 'approver' => $user['approver']
                 ];
                $url_redirect = 'request';
            } else {
                $url_redirect = 'auth/login';
                $_SESSION['error_msg'] = "The username or password is incorrect";
            }
        }
        $this->redirect($url_redirect);
    }

    function authRegister()
    {
        $msg = '';
        $msg_type = 'notify_msg';
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $vals = [
            'username' => $username,
            'password' => $password
        ];
        $rules = [
            'username' => 'required|max:8',
            'password'  => 'required|min:6',
        ];
        $result = Validation::validator($vals, $rules);
        if (!empty($result)) {
            $msg = $result;
            $msg_type = 'error_msg';
        } else {
            $result = $this->authModel->register($username, $password);
            $msg = $result ? 'REGISTER_SUCCESS' : 'REGISTER_ERR_USER_EXIST';
            $msg_type = $result ? $msg_type : 'error_msg';
        }
        Helpers::set_session_and_navigate($msg_type, $msg, 'auth/register');
    }

    function logout()
    {
        if (isset($_SESSION['user_info'])) {
            unset($_SESSION['user_info']);
            $this->redirect('auth');
        }
        $this->redirect('auth');
    }
}
