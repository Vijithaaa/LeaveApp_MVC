<?php
session_name("user");
session_start();
include './App/Includes/helperfunction.php';


$controller = isset($_GET['controller']) ? ($_GET['controller']) : 'auth';
$action = isset($_GET['action']) ? ($_GET['action']) : 'auth';

$controllerfile =  __DIR__ . '/App/Controller/' . $controller . 'Controller.php';
if (file_exists($controllerfile)) {

    require_once $controllerfile;

    $controller = $controller . 'Controller';

    if (class_exists($controller)) {

        if (method_exists($controller, $action)) {

            //controller response 
            $response = call_user_func([new $controller, $action]);

            if (is_array($response) && isset($response['path'])) {
                $data = $response['data'] ?? null;

                // echo "<pre>"; print_r($data); echo "</pre>";

                require_once __DIR__ . '/App/' . $response['path'];
            } else {
                echo "response not get properly check controller";
            }
        } else {
            echo  "no action exists";
        }
    } else {
        echo "no class exists";
    }
} else {
    echo "No Controller file found !";
}
