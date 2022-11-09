<?php 

class User extends Controller{
    private $userModel;

    function __construct()
    {
        $this->userModel = $this->model("UserModel");
        $this->roleModel = $this->model("RoleModel");
    }

    function index(){
        $data = $this->userModel->get();
        $this->view("master_layout", [
           "Page" => "user/index",
           "data" => $data
        ]);
    }

    function create(){
        $this->view("master_layout", [
           "Page" => "user/create",
        ]);
    }

    function store(){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $data = $this->userModel->Create($username, $password);
        if($data){
            header('Location: http://localhost/php/user/index');
        }
    }

    function detail($id){
        $result = $this->userModel->detail($id);
        $roles = $this->roleModel->get();
        $data = array();
        while ($obj = $result->fetch_object()) {
            $data['username'] = $obj->username;
            $data['password'] = $obj->password;
            $data['id'] = $obj->id;
            $data['id_role'] = $obj->id_role;
        }
        $this->view("master_layout", [
            "Page" => "user/detail",
            "data" => $data,
            "roles" => $roles
         ]);
    }

    function update($id){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $id_role = $_POST['id_role'];

        $data = $this->userModel->update($id, $username, $password, $id_role);
        if($data){
            header('Location: http://localhost/php/user/index');
        }
    }

    function delete($id){
        $data = $this->userModel->delete($id);
        if($data){
            header('Location: http://localhost/php/user/index');
        }
    }
}