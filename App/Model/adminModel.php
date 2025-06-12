<?php

require_once __DIR__ . '/../Includes/database.php';
// require_once __DIR__ . '/../Model/authModel.php';

class adminModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }


    public function SelectRoleName()
    {
        $stmt = $this->pdo->prepare("SELECT * from role_detail");
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($value) {
                return (['status' => 'success', 'msg' => $value]);
            }
        } else {
            return (['status' => 'error', 'msg' => 'no role_detail in db']);
        }
    }
    public function InsertEmployeeData($empName, $empEmail, $empGender, $empDateOfJoin, $empRoleId, $photoPath)
    {

        $stmt = $this->pdo->prepare("INSERT into employee_detail(employee_name,emp_email_id,gender,date_of_joining,role_id,employee_image) 
                                  values (:employee_name,:emp_email_id,:gender,:date_of_joining,:role_id,:employee_image)");
        $stmt->bindParam(':employee_name', $empName);
        $stmt->bindParam(':emp_email_id', $empEmail);
        $stmt->bindParam(':gender', $empGender);
        $stmt->bindParam(':date_of_joining', $empDateOfJoin);
        $stmt->bindParam(':role_id', $empRoleId);
        $stmt->bindParam(':employee_image', $photoPath);

        if ($stmt->execute()) {
            $lastId = $this->pdo->lastInsertId();
            return (['status' => 'success', 'msg' => ['employee_id' => $lastId]]);
        } else {
            return (['status' => 'error', 'msg' => 'dberror']);
        }
    }
}
