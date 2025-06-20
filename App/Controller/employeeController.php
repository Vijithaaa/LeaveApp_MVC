<?php
require_once './App/Model/EmployeeModel.php';

// this class show list of leaves taken,insert & edit & leave by the employee
class EmployeeController
{
    public $model;
    public function __construct()
    {
        $this->model = new EmployeeModel();
    }

    // get types of leave through database 
    public function getAll_leaveTypes($reqdata = 'null')
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

    // tracking leaves of the employee
    public function emp_leavetrack($reqdata = 'null')
    {
        // fetch Employee data
        $empName = ucfirst($_SESSION['EMP']['empName']);

        $empId = $_SESSION['EMP']['empId'];

        // Get role information
        $SelectRoleId = $this->model->SelectRoleId($empId);
        $roleId = $SelectRoleId['msg']['role_id'];

        $SelectRoleName = $this->model->fetchRoleName($roleId);
        $roleName = ucfirst($SelectRoleName['msg']['role_name']);

        $LeaveTypes = $this->getAll_leaveTypes();   //through getAll_leaveTypes fun()

        $leave = [];
        $total_leave = 0;
        $fetchLeaveTaken = $this->model->fetchLeaveTaken($empId);

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

    //======================================================================================================================


    //showleaveform  -> insert and update  leave based on appliction_id

    public  function showleaveform($reqdata = 'null')
    {
        $application_id = null;
        $leave_type_id = null;
        $start_date = null;
        $end_date = null;
        $leave_description = null;

        if (isset($reqdata['application_id'])) {
            $application_id = $reqdata['application_id'] ?? null;
        }

        $leaveType = $this->getAll_leaveTypes();

        $empId = $_SESSION['EMP']['empId'];
        // print_r($empId);

        // Check for previously submitted form data (from failed validation)
        if (isset($_SESSION['formData'])) {
            $leave_type_id = $_SESSION['formData']['leave_type_id'];
            $start_date = $_SESSION['formData']['start_date'];
            $end_date = $_SESSION['formData']['end_date'];
            $leave_description = $_SESSION['formData']['leave_description'];
        }
        if ($application_id !== null) {
            $SelectLeaveFormData = $this->model->SelectLeaveFormData($empId, $application_id);
            // print_r($SelectLeaveFormData);

            if ($SelectLeaveFormData) {
                $leave_type_id = $SelectLeaveFormData['msg']['leave_type_id'];
                $start_date = $SelectLeaveFormData['msg']['leave_start_date'];
                $end_date = $SelectLeaveFormData['msg']['leave_end_date'];
                $leave_description = $SelectLeaveFormData['msg']['leave_description'];
            }
        }

        $arr = [
            'data' => [
                'leaveType' => $leaveType,
                'leave_type_id' => $leave_type_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'application_id' => $application_id,
                'leave_description' => $leave_description
            ],
            'path' => 'View/EmployeeView/leaveform.php'
        ];
        return $arr;
    }


    //submitform  -> insert or update  leave based on appliction_id
    public function submitform($reqdata = 'null')
    {
        $application_id = $reqdata['application_id'] ?? null;
        $empId = $_SESSION['EMP']['empId'];

        if ($reqdata) {
            $formData = [
                'leave_type_id' => $reqdata['leave_type_id'],
                'start_date' => $reqdata['start_date'],
                'end_date' => $reqdata['end_date'],
                'leave_description' => $reqdata['leave_description']
            ];

            $leave_type_id = $formData['leave_type_id'];
            $start_date = $formData['start_date'];
            $end_date = $formData['end_date'];
            $leave_description = $formData['leave_description'];


            $today = date('Y-m-d');
            if ($start_date < $today) {
                $errorMsg = "Start date cannot be in the past.";

                $_SESSION['formData'] = $formData;
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=employee&action=showleaveform");
            }
            if ($end_date < $start_date) {
                $errorMsg = "End date cannot be before start date.";
                $_SESSION['formData'] = $formData;
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=employee&action=showleaveform");
            }
            // else {
            // if application_id get means update the leave
            if ($application_id) {
                $reqested_date = date('Y-m-d H:i:s');
                $UpdateLeaveData = $this->model->UpdateLeaveData($empId, $leave_type_id, $start_date, $end_date, $application_id, $reqested_date, $leave_description);
                if ($UpdateLeaveData) {

                    return $this->leavehistory();
                } else {
                    $errorMsg = "Update failed!";
                }
            }


            // Insert to leave application
            else {
                $InsertLeaveData = $this->model->InsertLeaveData($empId, $leave_type_id, $start_date, $end_date, $leave_description);
                if (isset($InsertLeaveData['status']) && $InsertLeaveData['status'] === 'success') {

                    // Clear session data only after successful insert
                    if (isset($_SESSION['formData'])) {
                        unset($_SESSION['formData']);
                    }

                    return $this->leavehistory();
                } else {
                    $errorMsg = "Insert failed!";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=employee&action=showleaveform");
                }
            }
            // }
        }
    }



    //=====================--------------------------------------================================================-----------------


    // history page->show leave application history of the employee 
    public function leavehistory($reqdata = 'null')
    {

        $empId = $_SESSION['EMP']['empId'];
        $orderby = "reqested_date desc";

        // $pending_status = $reqdata['filter'] ?? null;
        
        // $application = [];

        // $SelectApplication = $this->model->SelectApplication($empId, $orderby,$pending_status); // all status 



            $filter = $reqdata['filter'] ?? null;

    $application = [];

    // Prepare condition array - always filter by employee_id
    $conditions = ['employee_id' => $empId];
    
    // Only add status condition if filter is provided and not empty
    if (!empty($filter)) {
        $conditions['status'] = $filter;
    }

    $SelectApplication = $this->model->SelectApplication($empId, $orderby, $conditions);


        if (is_array($SelectApplication) && isset($SelectApplication['msg']) && is_array($SelectApplication['msg'])) {
            $SelectApplication = $SelectApplication['msg'];
        } else {
            $SelectApplication = [];
        }

        if (isset($SelectApplication)) {

            $leaveType = $this->getAll_leaveTypes();
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
            }


            $arr = [
                'data' => $application,
                'path' => 'View/EmployeeView/statusView.php'
            ];
            return $arr;
        }
    }


    // delete a row of employee data  only when status=="pending"
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

//     public function pendinghistory($reqdata = 'null')
//     {

//         $empId = $_SESSION['EMP']['empId'];
//         $orderby = "reqested_date desc";
//         // $pending_status="pending";

//         $pending_status = $reqdata['filter'];



//         $application = [];
//         $SelectApplication = $this->model->SelectPendingApplication($empId, $orderby, $pending_status);

//         if (is_array($SelectApplication) && isset($SelectApplication['msg']) && is_array($SelectApplication['msg'])) {
//             $SelectApplication = $SelectApplication['msg'];
//         } else {
//             $SelectApplication = [];
//         }

//         if (isset($SelectApplication)) {

//             $leaveType = $this->getAll_leaveTypes();
//             $leaveIdName = [];

//             if (isset($leaveType['leaveIdName']) && is_array($leaveType['leaveIdName'])) {
//                 foreach ($leaveType['leaveIdName'] as $id => $name) {
//                     $leaveIdName[$id] = $name;
//                 }
//             }


//             foreach ($SelectApplication as $app) {
//                 $leaveTypeId = $app['leave_type_id'];
//                 $leaveTypeName = $leaveIdName[$leaveTypeId] ?? 'Unknown Leave Type';

//                 $application[] = [
//                     'application_id' => $app['application_id'],
//                     'employee_id' => $app['employee_id'],
//                     'leave_type_id' => $leaveTypeName,
//                     'leave_start_date' => $app['leave_start_date'],
//                     'leave_end_date' => $app['leave_end_date'],
//                     'status' => $app['status'],
//                     'reqested_date' => $app['reqested_date'],
//                     'response_date' => $app['response_date'],
//                     'days' => calculateLeaveDays($app['leave_start_date'], $app['leave_end_date']) // Calculate days here

//                 ];
//             }


//             $arr = [
//                 'data' => $application,
//                 // 'pending'=>$pending_status,
//                 'path' => 'View/EmployeeView/pendingView.php'
//             ];
//             return $arr;
//         }
//     }
// }
