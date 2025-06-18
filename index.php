<?php
session_name("leavetracking");
session_start();



include './App/Includes/helperfunction.php';
require_once './App/Controller/mainController.php';


$controller = $_GET['controller'] ?? 'authenticate';
$action = $_GET['action'] ?? 'homepage';

new MainController($controller, $action);


