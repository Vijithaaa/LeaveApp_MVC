<?php
require_once __DIR__ . '/../Model/authModel.php';


// require_once __DIR__.'/../View/CommonView/adminHomeView.php';

class authController
{
    public $model;
    public function __construct()
    {
        $this->model = new authModel();
    }

    public function auth()
    {

        $arr = ['path' => 'View/CommonView/homeView.php'];
        return $arr;
    }

    public function form()
    {

        // Determine login type (admin or employee)

        $login_type = isset($_GET['type']) ? $_GET['type'] : 'employee';

        $page_title = ucfirst($login_type) . " Login";


        $arr = [
            'data' => ['login_type' => $login_type, 'page_title' => $page_title],
            'path' => 'View/AuthView/loginView.php'
        ];
        return $arr;
    }

    public function  submitform()
    {

        // Common variables
        $errorMsg = '';
        $successMsg = '';


        $login_type = isset($_GET['type']) ? $_GET['type'] : 'employee';


        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login'])) {

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);


            if ($login_type == "admin") {

                $userData = $this->model->adminAuth($username, $password);

                if ($userData &&  $userData['msg'] != false && $userData['msg']['name'] === $username && $userData['msg']['pass'] == $password) {
                    // session_start();
                    // $_SESSION['admin_logged_in'] = true;
                    $_SESSION['ADMIN'] = [
                        'admin_logged_in' => true
                    ];

                    $arr = ['path' => 'View/CommonView/adminHomeView.php'];
                    return $arr;
                } else {
                    $errorMsg = "Invalid admin credentials";

                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=auth&action=form");
                }
            } else {

                $userData = $this->model->empAuthenticate($username, $password);
                // print_r($userData);

                if ($userData &&  $userData['msg'] != false && $userData['msg']['employee_name'] === $username && $userData['msg']['employee_id'] == $password) {
                    // session_start();
                    $_SESSION['EMP'] = [
                        'empId' => $userData['msg']['employee_id'],
                        'empName' => ucfirst($userData['msg']['employee_name']),
                        'role_id' => $userData['msg']['role_id'],
                        'empImage' => $userData['msg']['employee_image'],
                        'emp_logged_in' => true
                    ];
                    session_regenerate_id(true); // Destroys old session

                    // $arr = [
                    //     'path' => 'View/EmployeeView/leavetracking.php',
                    // ];

                    include 'employeeController.php';
                    $obj = new employeeController();
                    return $obj->leavetrack();

                    // return $arr;
                } else {

                    $errorMsg = "Invalid employee credentials";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=auth&action=form");
                }
            }
        }
    }

    public function logout()
    {
        // session_start();
        session_unset();
        session_destroy();
        // header("Location: index.php");
        // exit;
        $arr = ['path' => 'View/CommonView/homeView.php'];
        return $arr;
    }



    public function adminpage()
    {
        $arr = ['path' => 'View/CommonView/adminHomeView.php'];
        return $arr;
    }
}
