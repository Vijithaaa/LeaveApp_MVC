<?php

require_once __DIR__ . '/../Includes/database.php';
// require_once __DIR__ . '/../Model/authModel.php';

class authModel extends Database
{
    public $name;
    public $pass;
    public $employee_id;
    public $employee_name;
    public $emp_email_id;
    public $date_of_joining;
    public $status;
    public $role_id;
    public $employee_image;

    public function __construct()
    {
        parent::__construct();
    }


    public function adminAuth($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * from admin WHERE name=:name AND pass=:pass");
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pass', $password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            return (['status' => 'success', 'msg' => $admin]);
        } 
        else {
            return (['status' => 'error', 'msg' => false]);
        }
    }

    public function empAuthenticate($username, $password){
                $stmt = $this->pdo->prepare("SELECT *  FROM employee_detail 
                          WHERE employee_id = :employee_id 
                          AND employee_name = :employee_name");
        $stmt->bindParam(':employee_id', $password, PDO::PARAM_INT);
        $stmt->bindParam(':employee_name',$username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
            return ([
                'status' => 'success',
                'msg' => $employee
                // 'employee_data' => $employee // Include full data,

            ]);
        } else {
            return (['status' => 'error', 'msg' => false]);
        }
    }
}
