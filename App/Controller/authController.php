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

    public function form($reqdata = 'null')
    {

        // Determine login type (admin or employee)

        $login_type = isset($reqdata['type']) ? $reqdata['type'] : 'employee';

        $page_title = ucfirst($login_type) . " Login";

        $arr = [
            'data' => ['login_type' => $login_type, 'page_title' => $page_title],
            // 'path' => 'View/AuthView/loginView.php'
            'path' => 'View/AuthView/loginView.php'

        ];
        
        return $arr;
    }

    public function  submitform($reqdata = 'null')
    {

        // Common variables
        $errorMsg = '';
        $successMsg = '';


        $login_type = isset($reqdata['type']) ? $reqdata['type'] : 'employee';


        // Handle form submission
        if (isset($reqdata['login'])) {

            $username = trim($reqdata['username']);
            $password = trim($reqdata['password']);


            if ($login_type == "admin") {

                $userData = $this->model->adminAuth($username, $password);


                if (
                    $userData &&  $userData['msg'] != false && $userData['msg']['name'] === $username
                    && $userData['msg']['pass'] == $password
                ) {
                    
                    $_SESSION['ADMIN'] = [
                        'admin_logged_in' => true
                    ];

                    include 'adminController.php';
                    $obj = new adminController();
                    return $obj->approve();



                } else {
                    $errorMsg = "Invalid admin credentials";

                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=auth&action=form");
                }
            } else {

                $userData = $this->model->empAuthenticate($username, $password);

                if (
                    $userData &&  $userData['msg'] != false && $userData['msg']['employee_name'] === $username
                    && $userData['msg']['employee_id'] == $password
                ) {
                    // session_start();
                    $_SESSION['EMP'] = [
                        'empId' => $userData['msg']['employee_id'],
                        'empName' => ucfirst($userData['msg']['employee_name']),
                        'role_id' => $userData['msg']['role_id'],
                        'empImage' => $userData['msg']['employee_image'],
                        'emp_logged_in' => true
                    ];
                    session_regenerate_id(true); // Destroys old session



                    include 'employeeController.php';
                    $obj = new employeeController();
                    return $obj->leavetrack();

                    // return $arr;
                } else {
                    // echo "muruga";

                    $errorMsg = "Invalid employee credentials";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=auth&action=form");
                }
            }
        }
    }

    public function logout($reqdata = 'null')
    {
        // session_start();
        session_unset();
        session_destroy();
        // header("Location: index.php");
        // exit;
        $arr = ['path' => 'View/CommonView/homeView.php'];
        return $arr;
    }



    public function adminpage($reqdata = 'null')
    {
        $arr = ['path' => 'View/CommonView/adminHomeView.php'];
        return $arr;
    }
}
