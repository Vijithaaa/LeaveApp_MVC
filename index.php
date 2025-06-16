<?php
session_name("user");
session_start();
include './App/Includes/helperfunction.php';

require_once './App/Controller/mainController.php';

// $controller = isset($_GET['controller']) ? ($_GET['controller']) : 'auth';
// $action = isset($_GET['action']) ? ($_GET['action']) : 'auth';


$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'auth';


// call_user_func([new $mainController, $action]);

new mainController($controller, $action);
