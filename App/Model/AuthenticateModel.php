<?php

require_once __DIR__ . '/../Includes/database.php';
    
class AuthenticationModel extends Database
{
    
    public function __construct()
    {
        parent::__construct();
    }


    public function adminAuth($username, $password)
    {
        $querydata = [
            'column_name' => "*",
            'table_name' => "admin",
            'condition' => [
                'name' => $username,
                'pass' => $password
            ]
        ];

        $data =  $this->select_queryfun($querydata,$multiple=false);
        return $data;

    }
    

    public function empAuthenticate($username, $password)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "employee_detail",
            'condition' => [
                'employee_name' => $username,
                'employee_pass' => $password
            ]
        ];

        $data =  $this->select_queryfun($querydata,$multiple=false);

        return $data;
        
    }
}
