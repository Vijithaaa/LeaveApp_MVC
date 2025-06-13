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


    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
//approve 

    public function SelectAllApplication()
    {
        $stmt = $this->pdo->prepare("SELECT * from leave_application WHERE status='pending'");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($value) {
                return (['status' => 'success', 'msg' => $value]);
            }
        } else {
            return (['status' => 'error', 'msg' => 'no leave record in db']);
        }
    

}



   public function selectEmployeeName()
    {

        $stmt = $this->pdo->prepare("SELECT employee_id,employee_name from employee_detail");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($value) {
                return (['status' => 'success', 'msg' => $value]);
            }
        } else {
            return (['status' => 'error', 'msg' => 'no name record in db']);
        }
    }

        public function updateLeaveApp($status, $application_id)
    {
        $stmt = $this->pdo->prepare("UPDATE leave_application 
                        SET 
                        status =:status,
                        response_date = CURRENT_TIMESTAMP() 
                        WHERE 
                        application_id = :appId");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':appId', $application_id);
        if ($stmt->execute()) {
            // Check if any rows were actually affected
            if ($stmt->rowCount() > 0) {
                return (['status' => 'success', 'msg' => 'Application updated successfully']);
            } else {
                return (['status' => 'error', 'msg' => 'No application found with that ID']);
            }
        } else {
            return (['status' => 'error', 'msg' => 'Database update failed']);
        }
    }


      public function Selecting_appIds($application_id)
    {
        $stmt = $this->pdo->prepare("SELECT * from leave_application where application_id=:application_id");
        $stmt->bindParam(':application_id', $application_id);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($value) {
                return (['status' => 'success', 'msg' => $value]);
            }
        } else {
            return (['status' => 'error', 'msg' => 'no application details in db']);
        }
    }


        public function Insertdata_to_LeaveTrack($total_days, $leave_id, $emp_id)
    {
        $stmt = $this->pdo->prepare("INSERT into leave_tracking(employee_id,leave_type_id,leave_taken) 
                                  values (:emp_id,:leave_id,:total_days)");
        $stmt->bindParam(':emp_id', $emp_id);
        $stmt->bindParam(':leave_id', $leave_id);
        $stmt->bindParam(':total_days', $total_days);

        if ($stmt->execute()) {
            return (['status' => 'success', 'msg' => true]);
        } else {
            return (['status' => 'error', 'msg' => 'data not inserted']);
        }
    }

}
