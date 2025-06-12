<?php


$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'auth';

if (file_exists(__DIR__ .'/App/Controller/' . $controller. 'Controller.php')) {
    require_once __DIR__ . '/App/Controller/' . $controller . 'Controller.php';

    $controller = $controller . 'Controller';

    if (class_exists($controller)) {

        if (method_exists($controller, $action)) {

            //controller response 
            $response = call_user_func([new $controller, $action]);

            if (is_array($response) && isset($response['path'])) {

                $data = $response['data'] ?? null;
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
