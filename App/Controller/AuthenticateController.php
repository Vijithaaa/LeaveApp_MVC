<?php

require_once './App/Model/AuthenticateModel.php';



// AuthenticationController to authenticate admin or employee
class AuthenticateController
{
    public $model;
    public function __construct()
    {
        $this->model = new AuthenticationModel();
    }

    // show landing page
    public function homepage()
    {

        $arr = ['path' => 'View/CommonView/homeView.php'];
        return $arr;
    }

    // Determine login_type (admin or employee)
    public function showform_emp_admin($reqdata = 'null')  //form
    {


        // $login_type = isset($reqdata['type']) ? $reqdata['type'] : 'employee';

        // $page_title = ucfirst($login_type) . " Login";

        $arr = [
            // 'data' => ['login_type' => $login_type, 'page_title' => $page_title],
            'path' => 'View/AuthView/Login_View.php'

        ];
        return $arr;
    }





    // submit form either employee or admin based on type

    public function  submitform_emp_admin($reqdata = 'null')
    {

        if(isset($reqdata['login'])){
            
        }


        // $login_type = isset($reqdata['type']) ? $reqdata['type'] : 'employee';


        if (isset($reqdata['login'])) {

            $username = $reqdata['username'];
            $password = $reqdata['password'];


            // if ($login_type == "admin") {

                $userData = $this->model->adminAuth($username, $password);


                if (
                    $userData &&  $userData['msg'] != false && $userData['msg']['name'] === $username
                    && $userData['msg']['pass'] == $password
                ) {
                    
                    $_SESSION['ADMIN'] = [
                        'admin_logged_in' => true
                    ];

                   
                    include 'adminController.php';
                    $obj = new AdminController();
                    return $obj->approve();



                // } else {
                //     $errorMsg = "Invalid admin credentials";

                //     setcookie('errorMsg', $errorMsg, time() + 2);
                //     header("Location: index.php?controller=authenticate&action=showform_emp_admin");
                // }
            } else {

                $userData = $this->model->empAuthenticate($username, $password);

                if (
                    $userData &&  $userData['msg'] != false && $userData['msg']['employee_name'] === $username
                    && $userData['msg']['employee_id'] == $password
                ) {
                    
                    $_SESSION['EMP'] = [
                        'empId' => $userData['msg']['employee_id'],
                        'empName' => ucfirst($userData['msg']['employee_name']),
                        'role_id' => $userData['msg']['role_id'],
                        'empImage' => $userData['msg']['employee_image'],
                        'emp_logged_in' => true
                   
                   
                    ];
                    session_regenerate_id(true); // Destroys old session



                    include 'EmployeeController.php';
                    $obj = new EmployeeController();
                    return $obj->emp_leavetrack();

                } else {

                    $errorMsg = "Invalid employee credentials";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=authenticate&action=showform_emp_admin");
                }
            }
        }
    // }
    }







    // logout session
    public function logout($reqdata = 'null')
    {
        session_unset();
        session_destroy();
        $arr = ['path' => 'View/CommonView/homeView.php'];
        return $arr;
    }


}
