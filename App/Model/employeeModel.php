<?php

require_once __DIR__ . '/../Includes/database.php';

class employeeModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function SelectRoleId($empId)
    {
        $stmt = $this->pdo->prepare('SELECT role_id FROM employee_detail where employee_id = :employee_id');
        $stmt->bindParam(':employee_id', $empId);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($value) {

                return (['status' => 'success', 'msg' => $value]);
            } else {
                return (['status' => 'error', 'msg' => 'no such user in db']);
            }
        }
    }


    //leave track
    public function fetchRoleName($roleId)
    {
        $stmt = $this->pdo->prepare("SELECT role_name FROM role_detail WHERE role_id = :role_id");
        $stmt->bindParam(':role_id', $roleId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $value = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($value) {
                return ((['status' => 'success', 'msg' => $value]));
            } else {
                return ((['status' => 'error', 'msg' => 'no such role_id in db']));
            }
        }
    }

    public function getAllLeaveTypes()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM leave_types");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($value) {
                return (['status' => 'success', 'msg' => $value]);
            } else {
                return (['status' => 'error', 'msg' => 'no such leavetype in db']);
            }
        }
    }

    public function fetchLeaveTaken($empId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM leave_tracking WHERE employee_id =:employee_id ");
        $stmt->bindParam(':employee_id', $empId);
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




    //======================================================================================================================//
    // leave form

    public function SelectLeaveFormData($empId, $application_id)
    {

        $stmt = $this->pdo->prepare("SELECT * FROM leave_application 
                                        WHERE application_id = :appId AND employee_id = :empId");
        $stmt->bindParam(':empId', $empId);
        $stmt->bindParam(':appId', $application_id);
        $stmt->execute();
        $existingData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingData) {
            if ($stmt->rowCount() > 0) {
                return (['status' => 'success', 'msg' => $existingData]);
            } else {
                return (['status' => 'error', 'msg' => 'No matching pending record found to update']);
            }
        }
    }



    public function UpdateLeaveData($empId, $leave_type_id, $start_date, $end_date, $application_id)
    {
        $stmt = $this->pdo->prepare("UPDATE leave_application 
                        SET leave_type_id = :leave_type_id, 
                            leave_start_date = :start_date, 
                            leave_end_date = :end_date,
                            reqested_date = CURRENT_TIMESTAMP
                        WHERE application_id = :appId 
                        AND employee_id = :empId
                        AND status = 'pending'");

        $stmt->bindParam(':empId', $empId);
        $stmt->bindParam(':appId', $application_id);
        $stmt->bindParam(':leave_type_id', $leave_type_id);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return (['status' => 'success', 'msg' => true]);
            } else {
                return (['status' => 'error', 'msg' => 'No matching pending record found to update']);
            }
        }
    }



    public function InsertLeaveData($empId, $leave_type_id, $start_date, $end_date)

    {
        $stmt = $this->pdo->prepare("INSERT INTO leave_application(employee_id, leave_type_id, leave_start_date, leave_end_date)
                              VALUES
                              (:employee_id,:leave_type_id,:leave_start_date,:leave_end_date)
                              ");
        $stmt->bindParam(':employee_id', $empId);
        $stmt->bindParam(':leave_type_id', $leave_type_id);
        $stmt->bindParam(':leave_start_date', $start_date);
        $stmt->bindParam(':leave_end_date', $end_date);
        // $stmt->execute();
        // print_r(json_encode($result));
        // $lastInsertId = $this->pdo->lastInsertId();
        if ($stmt->execute()) {
            return (['status' => 'success', 'msg' => true]);
        } else {
            return (['status' => 'error', 'msg' => 'no leave record in db']);
        }
    }

    // ----------------------------------------------------------------------------------------
    //history


       public function SelectApplication($empId)
    {

        $stmt = $this->pdo->prepare("SELECT * from leave_application WHERE employee_id=:employee_id");
        $stmt->bindParam(':employee_id', $empId);
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


        public function deleteApplication($empId, $application_id)
    {

        $stmt = $this->pdo->prepare("DELETE FROM leave_application 
                                where application_id = :application_id 
                                AND employee_id = :empId
                                AND status = 'pending'");
        $stmt->bindParam(':empId', $empId);
        $stmt->bindParam(':application_id', $application_id);
        if ($stmt->execute()) {
            return (['status' => 'success', 'msg' => true]);
        } else {
            return (['status' => 'error', 'msg' => 'no record in db']);
        }
    }

}
