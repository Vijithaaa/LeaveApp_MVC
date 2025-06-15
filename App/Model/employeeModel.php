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

              $querydata = [
            'column_name' => "role_id",
            'table_name' => "employee_detail",
            'condition' => [
                'employee_id'=>$empId
            ]
        ];
   
        $data =  $this->select($querydata,$multiple=false);

        return $data;

    }


    //leave track
    public function fetchRoleName($roleId)
    {

           $querydata = [
            'column_name' => "role_name",
            'table_name' => "role_detail",
            'condition' => [
                'role_id'=>$roleId
            ]
        ];
   
        $data =  $this->select($querydata,$multiple=false);

        return $data;

    }

    public function getAllLeaveTypes()
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_types",
            'condition' => []
        ];
        $data =  $this->select($querydata,$multiple=true);
        return $data;

    }

    public function fetchLeaveTaken($empId)
    {
        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_tracking",
            'condition' => [
                'employee_id'=>$empId
            ]
        ];
        $data =  $this->select($querydata,$multiple=true);
        return $data;


    
    }




    //======================================================================================================================//
    // leave form

    public function SelectLeaveFormData($empId, $application_id)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_application",
            'condition' => [
                'application_id'=>$application_id,
                'employee_id'=>$empId

            ]
        ];
        $data =  $this->select($querydata,$multiple=false);
        return $data;

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

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_application",
            'condition' => [
                'employee_id'=>$empId

            ]
        ];
        $data =  $this->select($querydata,$multiple=true);
        return $data;

    
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
