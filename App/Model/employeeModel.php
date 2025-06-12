<?php

require_once __DIR__ . '/../Includes/database.php';
// require_once __DIR__ . '/../Model/authModel.php';

class employeeModel extends Database
{
  public function __construct()
    {
        parent::__construct();
    }

}