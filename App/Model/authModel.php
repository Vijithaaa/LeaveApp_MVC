<?php

require_once __DIR__ . '/../Includes/database.php';
// require_once __DIR__ . '/../Model/authModel.php';

class authModel extends Database
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

        $data =  $this->select($querydata,$multiple=false);
        return $data;

    }
    

    public function empAuthenticate($username, $password)
    {

        $querydata = [
            'column_name' => "*",
            'table_name' => "employee_detail",
            'condition' => [
                'employee_name' => $username,
                'employee_id' => $password
            ]
        ];
        // print_r($querydata);

        $data =  $this->select($querydata,$multiple=false);

        return $data;
        
    }
}
