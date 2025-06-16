<?php

class mainController
{
    public function __construct($controller, $action)
    {

        $controller = $controller . 'Controller';
        if (file_exists("./App/Controller/$controller.php")) {
            // print "./App/Controller/$controller.php";
            require_once "./App/Controller/$controller.php";

            if (class_exists($controller)) {

                $controllerobj = new $controller();

                if (method_exists($controllerobj, $action)) {

                    $response = $controllerobj->$action($_REQUEST);

                    if (is_array($response) && isset($response['path'])) {

                        $data = $response['data'] ?? null;

                        // echo "<pre>"; print_r($data); echo "</pre>";
                        
                        require_once   "./App/".$response['path'];
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
    }
}
