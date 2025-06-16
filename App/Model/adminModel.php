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
        $querydata = [
            'column_name' => "*",
            'table_name' => "role_detail",
            'condition' => []
        ];
        $data =  $this->select_queryfun($querydata, $multiple = true);
        return $data;
    }
    public function InsertEmployeeData($empName, $empEmail, $empGender, $empDateOfJoin, $empRoleId, $photoPath)
    {

        $querydata = [
            'table_name'=>"employee_detail",
            'data'=>[
                'employee_name'=>$empName,
                'emp_email_id'=>$empEmail,
                'gender'=>$empGender,
                'date_of_joining'=>$empDateOfJoin,
                'role_id'=>$empRoleId,
                'employee_image'=>$photoPath
            ]
            
        ];

        $data = $this->insert_queryfun($querydata,$returnId=true);
        // print_r($data);
        return $data;

    }


    //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    //approve 

    public function SelectAllApplication($status,$orderby)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_application",
            'orderby'=>$orderby,
            'condition' => [
                'status' => $status
            ]
        ];
        $data =  $this->select_queryfun($querydata, $multiple = true);
        return $data;

        
    }



    public function selectEmployeeName()
    {

        $querydata = [
            'column_name' => ["employee_id","employee_name"],
            'table_name' => "employee_detail",
            'condition' => []
        ];
        $data =  $this->select_queryfun($querydata, $multiple = true);
        return $data;
   
    }

    public function updateLeaveApp($status, $application_id,$response_date)
    {
        $querydata =  [
            'table_name'=>"leave_application",
            'data'=>[
                'status'=>$status,
                'response_date'=>$response_date
            ],
            'condition'=>[
                'application_id'=>$application_id
            ]
        ];

        $data = $this->update_queryfun($querydata);
        return $data;

    }


    public function Selecting_appIds($application_id)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_application",
            'condition' => [
                'application_id' => $application_id
            ]
        ];
        $data =  $this->select_queryfun($querydata, $multiple = false);
        return $data;

    }


    public function Insertdata_to_LeaveTrack($total_days, $leave_id, $emp_id)
    {

          $querydata = [
            'table_name'=>"leave_tracking",
            'data'=>[
                'employee_id'=>$emp_id,
                'leave_type_id'=>$leave_id,
                'leave_taken'=>$total_days
            ]
        ];

        $data = $this->insert_queryfun($querydata,$returnId=false);
        return $data;


    }
}
