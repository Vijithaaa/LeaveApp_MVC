<?php
require_once __DIR__ . '/../Model/employeeModel.php';
// require_once __DIR__ . '/../View/CommonView/navbar.php';
// require_once __DIR__.'/../View/EmployeeView/leavehistory.php';


class employeeController
{
    public $model;
    public function __construct()
    {
        $this->model = new employeeModel();
    }


    public function leavetypesCommon($reqdata = 'null')
    {
        $LeaveTypes = [];
        $LeaveTypeIdName = [];
        $getAllleaveTypes = $this->model->getAllLeaveTypes();
        // print_r($getAllleaveTypes);

        $storeLeaveTypes = $getAllleaveTypes['msg'];
        foreach ($storeLeaveTypes as $list) {
            $LeaveTypeIdName[$list['leave_type_id']] = $list['leave_name'];
        }
        $LeaveTypes['original'] = $storeLeaveTypes;
        $LeaveTypes['leaveIdName'] = $LeaveTypeIdName;
        return $LeaveTypes;
    }


    public function leavetrack($reqdata = 'null')
    {

        // if (isset($_SESSION['EMP']['emp_logged_in']) && $_SESSION['EMP']['emp_logged_in'] == true) {

        // Employee data
        $empName = ucfirst($_SESSION['EMP']['empName']);

        $empId = $_SESSION['EMP']['empId'];

        // // Get role information
        $SelectRoleId = $this->model->SelectRoleId($empId);
        $roleId = $SelectRoleId['msg']['role_id'];
        $SelectRoleName = $this->model->fetchRoleName($roleId);
        // print_r($SelectRoleName);
        $roleName = ucfirst($SelectRoleName['msg']['role_name']);

        $LeaveTypes = $this->leavetypesCommon();   //getAllLeaveTypes

        $leave = [];
        $total_leave = 0;
        $fetchLeaveTaken = $this->model->fetchLeaveTaken($empId);
        // print_r($fetchLeaveTaken);

        if (isset($fetchLeaveTaken['msg']) && is_array($fetchLeaveTaken['msg'])) {
            $LeaveTakenCount = $fetchLeaveTaken['msg'];
            foreach ($LeaveTakenCount as $takenCount) {
                $total_leave += $takenCount['leave_taken'];
            }
            $leave['leaveDetails'] = $LeaveTakenCount;
            $leave['totalCount'] = $total_leave;
        } else {
            $leave['leaveDetails'] = [];
            $leave['totalCount'] = 0;
        }

        $userData = [
            'empId' => $empId,
            'empName' => $empName,
            'roleId' => $roleId,
            'roleName' => $roleName,
            'total_leave' => $leave['totalCount'],
            'leaveType' => $LeaveTypes['leaveIdName'],
            'fetchLeaveTaken' => $leave['leaveDetails']
        ];

        // // Map leave types
        foreach ($userData['fetchLeaveTaken'] as $key => $value) {
            $userData['fetchLeaveTaken'][$key]['leave_type'] = $userData['leaveType'][$value['leave_type_id']] ?? null;
        }

        // // Add extra content for navbar
        $navbarExtraContent = "<span class='me-3 text-primary'>" . htmlspecialchars($userData['roleName']) . "</span>";

        $arr = [
            'data' => [
                'userData' => $userData,
                'navbar' => $navbarExtraContent
            ],
            'path' => 'View/EmployeeView/leavetracking.php'
        ];
        return $arr;
        // }
    }

    //======================================================================================================================//
    //action = leaveform

    public  function showleaveform($reqdata = 'null')
    {
    // Initialize to avoid undefined variable warnings
    $application_id = null;
    $leave_type_id = null;
    $start_date = null;
    $end_date = null;

        if (isset($reqdata['application_id'])) {
            $application_id = $reqdata['application_id'] ?? null;
        }

        $leaveType = $this->leavetypesCommon();

        // $empName = ucfirst($_SESSION['EMP']['empName']);
        $empId = $_SESSION['EMP']['empId'];
        // $application_id = $_POST['application_id'] ?? $_POST['application_id'] ?? null;

        if ($application_id !== null) {
            $SelectLeaveFormData = $this->model->SelectLeaveFormData($empId, $application_id);
            // print_r($SelectLeaveFormData);

            if ($SelectLeaveFormData) {
                $leave_type_id = $SelectLeaveFormData['msg']['leave_type_id'];
                $start_date = $SelectLeaveFormData['msg']['leave_start_date'];
                $end_date = $SelectLeaveFormData['msg']['leave_end_date'];
            }
        }

        $arr = [
            'data' => [
                'leaveType' => $leaveType,
                'leave_type_id' => $leave_type_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'application_id' => $application_id
            ],
            'path' => 'View/EmployeeView/leaveform.php'
        ];
        return $arr;
    }


    public function submitform($reqdata = 'null')
    {
        $application_id = $reqdata['application_id'] ?? null;


        $empId = $_SESSION['EMP']['empId'];

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {

            // $leaveType = $this->leavetypesCommon();

            $leave_type_id = $reqdata['leave_type_id'];
            $start_date = $reqdata['start_date'];
            $end_date = $reqdata['end_date'];
            // $application_id = $_POST['application_id'] ?? null;

            $today = date('Y-m-d');
            if ($start_date < $today) {
                $errorMsg = "Start date cannot be in the past.";
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=employee&action=showleaveform");
            } elseif ($end_date < $start_date) {
                $errorMsg = "End date cannot be before start date.";
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=employee&action=showleaveform");
            } else {
                // Edit
                if ($application_id) {
                    $reqested_date = date('Y-m-d H:i:s');
                    $UpdateLeaveData = $this->model->UpdateLeaveData($empId, $leave_type_id, $start_date, $end_date, $application_id, $reqested_date);
                    if ($UpdateLeaveData) {

                        return $this->leavehistory();
                    } else {
                        $errorMsg = "Update failed!";
                    }
                }


                // Insert
                else {
                    $InsertLeaveData = $this->model->InsertLeaveData($empId, $leave_type_id, $start_date, $end_date);
                    if (isset($InsertLeaveData['status']) && $InsertLeaveData['status'] === 'success') {
                        // echo "Hello";
                        return $this->leavehistory();
                    } else {
                        $errorMsg = "Insert failed!";
                        setcookie('errorMsg', $errorMsg, time() + 2);
                        header("Location: index.php?controller=employee&action=showleaveform");
                    }
                }
            }  //else  ku application id update ku
            // $navbarExtraContent = "<span class='me-3 text-primary'>" . ($application_id ? 'Edit Application' : 'Leave Application') . "</span>";
        }
    }



    //=====================--------------------------------------================================================-----------------

    // history page

    public function leavehistory($reqdata = 'null')
    {
        // if (isset($_SESSION['EMP']['emp_logged_in']) || $_SESSION['EMMP']['emp_logged_in']  == true) {

        // $empName = $_SESSION['EMP']['empName'];
        $empId = $_SESSION['EMP']['empId'];

        $application = [];
        $SelectApplication = $this->model->SelectApplication($empId);
        // print_r($SelectApplication);

        if (is_array($SelectApplication) && isset($SelectApplication['msg']) && is_array($SelectApplication['msg'])) {
            $SelectApplication = $SelectApplication['msg'];
        } else {
            $SelectApplication = [];
        }

        if (isset($SelectApplication)) {

            $leaveType = $this->leavetypesCommon();
            $leaveIdName = [];

            if (isset($leaveType['leaveIdName']) && is_array($leaveType['leaveIdName'])) {
                foreach ($leaveType['leaveIdName'] as $id => $name) {
                    $leaveIdName[$id] = $name;
                }
            }


            foreach ($SelectApplication as $app) {
                $leaveTypeId = $app['leave_type_id'];
                $leaveTypeName = $leaveIdName[$leaveTypeId] ?? 'Unknown Leave Type';

                $application[] = [
                    'application_id' => $app['application_id'],
                    'employee_id' => $app['employee_id'],
                    'leave_type_id' => $leaveTypeName,
                    'leave_start_date' => $app['leave_start_date'],
                    'leave_end_date' => $app['leave_end_date'],
                    'status' => $app['status'],
                    'reqested_date' => $app['reqested_date'],
                    'response_date' => $app['response_date'],
                    'days' => calculateLeaveDays($app['leave_start_date'], $app['leave_end_date']) // Calculate days here

                ];
                // echo "<pre>";print_r($app);echo "</pre>";
            }
        }


        $arr = [
            'data' => $application,
            'path' => 'View/EmployeeView/leavehistory.php'
        ];
        return $arr;

        $navbarExtraContent = "<span class='me-3 text-primary'>" . "Leave History" . "</span>";
        // }
    }




    public function deleteRow($reqdata = 'null')
    {
        $status = "pending";

        if (isset($reqdata['application_id'])) {
            $application_id = $reqdata['application_id'] ?? null;
        }
        $empId = $_SESSION['EMP']['empId'];
        $deleteRow = $this->model->deleteApplication($empId, $application_id, $status);

        if ($deleteRow) {
            return $this->leavehistory();
        }
    }
}
