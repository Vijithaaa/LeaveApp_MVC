<?php
require_once __DIR__ . '/../Model/employeeModel.php';


// require_once __DIR__.'/../View/CommonView/adminHomeView.php';

class employeeController
{
    public $model;
    public function __construct()
    {
        $this->model = new employeeModel();
    }

}