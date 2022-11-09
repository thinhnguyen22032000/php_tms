<?php
define("DB_NAME",$_ENV['DATABASE_NAME']);
define("DB_USERNAME",$_ENV['DATABASE_USERNAME']);
define("DB_PASSWORD",$_ENV['DATABASE_PASSWORD']);

class DB{
    protected $db;

    function __construct(){
        $con = "mysql:host=localhost;dbname=". constant("DB_NAME");

        $this->db = \ParagonIE\EasyDB\Factory::fromArray([
            $con,
            constant('DB_USERNAME'),
            constant('DB_PASSWORD')
        ]);
    }


    // function __construct(){
    //     $this->con = mysqli_connect($this->servername, $this->username, $this->password);
    //     mysqli_select_db($this->con, $this->dbname);
    //     mysqli_query($this->con, "SET NAMES 'utf8'");
    // }
}

?>