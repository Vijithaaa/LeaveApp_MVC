<?php
session_name("leavetrack");
session_start();
include './App/Includes/helperfunction.php';
require_once './App/Controller/mainController.php';


$controller = $_GET['controller'] ?? 'authentication';
$action = $_GET['action'] ?? 'homepage';


// call_user_func([new $mainController, $action]);

new MainController($controller, $action);
