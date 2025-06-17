<?php

require_once './App/Model/AdminModel.php';

require_once __DIR__ . '/EmployeeController.php';

//register new employee and give response for leave request
class AdminController
{
    public $model;
    public $emp;
    public function __construct()
    {
        $this->model = new AdminModel();
    }



// showing form for employee registration
    public function form($reqdata = 'null')
    {

        $SelectRoleName = $this->model->SelectRoleName();


        $role = [];
        foreach ($SelectRoleName['msg'] as $list) {
            $role[$list['role_id']] = $list['role_name'];
        }
        $arr = ['data' => $role, 'path' => 'View/AdminView/registerView.php'];
        return $arr;
    }


// inserting a employee data's to database
    public function submitform($reqdata = 'null')
    {


        $uploadFolder = "assets/images/employees/";
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif']; //web safe image formats
        $maxFileSize = 2 * 1024 * 1024; // 2MB


        if (isset($reqdata['register_employee_details'])) {

            $empName = $empEmail = $empGender = $empDateOfJoin = $empRoleId = $photoPath = '';
            $empName = $reqdata['employee_name'];
            $empEmail = $reqdata['emp_email_id'];
            $empGender = $reqdata['gender'];
            $empDateOfJoin = $reqdata['date_of_joining'];
            $empRoleId = $reqdata['role_id'];

            if (!empty($_FILES['employee_photo']['tmp_name'])) {

                $file = $_FILES['employee_photo'];

                // Check file type
                if (!in_array($file['type'], $allowedFileTypes)) {
                    $errorMsg = "Only JPG, PNG, or GIF images allowed.";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=admin&action=form");
                }
                // Check file size
                elseif ($file['size'] > $maxFileSize) {
                    $errorMsg = "Image too large (max 2MB).";
                    setcookie('errorMsg', $errorMsg, time() + 2);
                    header("Location: index.php?controller=admin&action=form");
                } else {
                    // Save the file

                    $newFilename = $file['name'];
                    if (move_uploaded_file($file['tmp_name'], $uploadFolder . $newFilename)) {
                        $photoPath = 'assets/images/employees/' . $newFilename;
                    } else {
                        $errorMsg = "Upload failed.";
                        setcookie('errorMsg', $errorMsg, time() + 2);
                        header("Location: index.php?controller=admin&action=form");
                    }
                }
            } else {
                $errorMsg = "Please choose a photo.";
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=admin&action=form");
            }




            $insert = $this->model->InsertEmployeeData($empName, $empEmail, $empGender, $empDateOfJoin, $empRoleId, $photoPath);

            if (isset($insert['status']) && $insert['status'] === 'success') {
                $successMsg = "Data inserted successfully";
                setcookie('successMsg', $successMsg, time() + 2);
                header("Location: index.php?controller=admin&action=form");

                // Write to CSV file
                $csvFilePath = "employee-data.csv";

                // Create the file with header if it doesn't exist
                if (!file_exists($csvFilePath)) {
                    $file = fopen($csvFilePath, 'w');
                    fputcsv($file, ['employee_id', 'employee_name', 'emp_email_id', 'gender', 'date_of_joining', 'status', 'role_id', 'employee_image']);
                } else {
                    $file = fopen($csvFilePath, 'a'); 
                }

                if ($file) {

                    $empId = $insert['msg']['last_id']; 
                    $status = 'active'; 

                    fputcsv($file, [$empId, $empName, $empEmail, $empGender, $empDateOfJoin, $status, $empRoleId, $photoPath]);

                    fclose($file);
                }

                $arr = ['data' => $insert, 'path' => 'View/AdminView/registerView.php'];
                return $arr;
            }  //endif  insert status = success


            else {
                $errorMsg = "Failed to insert data";
                setcookie('errorMsg', $errorMsg, time() + 2);
                header("Location: index.php?controller=admin&action=form");

                if ($photoPath && file_exists($uploadFolder . basename($photoPath))) {
                    unlink($uploadFolder . basename($photoPath));
                }
            }
        }
    }



    //=====================================================================================================================
    
    //approve -> list the pending leaves of employee and response for their request
    public function approve($reqdata = 'null')
    {

        $application = [];
        $status = 'pending';
        $orderby = "reqested_date desc"; 
        $SelectAllApplication = $this->model->SelectAllApplication($status,$orderby);
        if ($SelectAllApplication && $SelectAllApplication['status'] === 'success') {
            $applications = $SelectAllApplication['msg'];

            // get leave types and employee names
            $leaveTypeData = new employeeController();
            $leaveType = $leaveTypeData->getAll_leaveTypes();

            $leaveIdName = $leaveType['leaveIdName'];

            //employee name
            $selectEmployeeName = $this->model->selectEmployeeName();
            $empIdName = [];
            foreach ($selectEmployeeName['msg'] as $data) {
                $empIdName[$data['employee_id']] = $data['employee_name'];
            }

            foreach ($applications as $app) {
                $leaveTypeId = $app['leave_type_id'];
                $leaveTypeName = $leaveIdName[$leaveTypeId] ?? 'Unknown Leave Type';

                $EmpId = $app['employee_id'];
                $EmpName = $empIdName[$EmpId] ?? 'Unknown Employee Name';

                $application[] = [
                    'application_id' => $app['application_id'],
                    'employee_id' => $EmpName,
                    'leave_type_id' => $leaveTypeName,
                    'leave_start_date' => $app['leave_start_date'],
                    'leave_end_date' => $app['leave_end_date'],
                    'status' => $app['status'],
                    'reqested_date' => $app['reqested_date'],
                    'response_date' => $app['response_date'],
                    'days' => calculateLeaveDays($app['leave_start_date'], $app['leave_end_date']) // Calculate days here

                ];
            }
        }
        $arr =  ['data' => $application, 'path' => 'View/AdminView/approveView.php'];
        return $arr;
    }

// 
    public function status($reqdata){

           // getting the application_id from  form in same page
        if (isset($reqdata['actions']) && isset($reqdata['application_id'])) {
            $application_id = ($reqdata['application_id']);  //hidden input
            $status = ($reqdata['actions']); //hidden input

            $response_date = date('Y-m-d H:i:s');

            $updateLeaveApp = $this->model->updateLeaveApp($status, $application_id,$response_date);


            if (is_array($updateLeaveApp)) {
                $successMsg = "status updated";
                setcookie('successMsg', $successMsg, time() + 2);
                header("Location: index.php?controller=admin&action=approve");

            }

              //select leave application if status == 'approved'  for updating the leave_tracking page to show no.of leave count for  particular employeee
            if ($status == 'approved') {

                $Selecting_appIds = $this->model->Selecting_appIds($application_id);

                $emp_id = $Selecting_appIds['msg']['employee_id'];
                $leave_id = $Selecting_appIds['msg']['leave_type_id'];
                $start_date = date_create($Selecting_appIds['msg']['leave_start_date']);
                $end_date = date_create($Selecting_appIds['msg']['leave_end_date']);
                $interval = $start_date->diff($end_date);
                $total_days = $interval->days + 1;

                $Insertdata_to_LeaveTrack = $this->model->Insertdata_to_LeaveTrack($total_days, $leave_id, $emp_id);
            } //end if status == approved


        } // if post data
        return $this->approve();

    }


}
