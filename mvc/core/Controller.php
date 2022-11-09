<?php
class Controller{

    public function model($model){
        require_once "./mvc/models/".$model.".php";
        return new $model;
    }

    public function view($view, $data=[]){
        require_once "./mvc/views/".$view.".php";
    }

    public function redirect($uri, $msg = []){
        if(!empty($msg )){
            foreach($msg as $item => $value){
               $_SESSION[$item] = $value;
            }
        }
        $url = 'location: ' .Domain::get().'/'.$uri;
        header($url);
    }

}
?>