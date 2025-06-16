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
   
        $data =  $this->select_queryfun($querydata,$multiple=false);

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
   
        $data =  $this->select_queryfun($querydata,$multiple=false);

        return $data;

    }

    public function getAllLeaveTypes()
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_types",
            'condition' => []
        ];
        $data =  $this->select_queryfun($querydata,$multiple=true);
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
        $data =  $this->select_queryfun($querydata,$multiple=true);
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
        $data =  $this->select_queryfun($querydata,$multiple=false);
        return $data;

    }



    public function UpdateLeaveData($empId, $leave_type_id, $start_date, $end_date, $application_id,$reqested_date)
    {

        $querydata =  [
            'table_name'=>"leave_application",
            'data'=>[
                'leave_type_id'=>$leave_type_id,
                'leave_start_date'=>$start_date,
                'leave_end_date'=>$end_date,
                'reqested_date'=>$reqested_date

            ],
            'condition'=>[
                'application_id'=>$application_id,
                'employee_id'=>$empId

            ]
        ];

        $data = $this->update_queryfun($querydata);
        return $data;

    }



    public function InsertLeaveData($empId, $leave_type_id, $start_date, $end_date)
    {
         $querydata = [
            'table_name'=>"leave_application",
            'data'=>[
                'employee_id'=>$empId,
                'leave_type_id'=>$leave_type_id,
                'leave_start_date'=>$start_date,
                'leave_end_date'=>$end_date
            ]
        ];

        $data = $this->insert_queryfun($querydata,$returnId=false);
        return $data;

    }

    // ----------------------------------------------------------------------------------------
    //history


       public function SelectApplication($empId,$orderby)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "leave_application",
            'orderby'=>$orderby,
            'condition' => [
                'employee_id'=>$empId

            ]
        ];
        $data =  $this->select_queryfun($querydata,$multiple=true);
        return $data;

    
    }


        public function deleteApplication($empId, $application_id,$status)
    {

         $querydata = [
            'table_name' => "leave_application",
            'condition' => [
                'application_id'=>$application_id,
                'employee_id'=>$empId,
                'status'=>$status
            ]
        ];
        $data =  $this->delete_queryfun($querydata,$multiple=true);
        return $data;

    
    }
        

}
