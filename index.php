<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
require_once './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once "./mvc/Bridge.php";
$myApp = new App();
?>