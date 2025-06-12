<?php
require_once __DIR__ . '/../Model/adminModel.php';


// require_once __DIR__.'/../View/AdminView/registerView.php';

class adminController
{
    public $model;
    public function __construct()
    {
        $this->model = new adminModel();
    }



    // -----------------------------------------------------------------------------------------------

    public function form()
    {
        $SelectRoleName = $this->model->SelectRoleName();

        $role = [];
        foreach ($SelectRoleName['msg'] as $list) {
            $role[$list['role_id']] = $list['role_name'];
        }
        $arr = ['data' => $role, 'path' => 'View/AdminView/registerView.php'];
        return $arr;
    }



    public function submitform()
    {


        $uploadFolder = "assets/images/employees/";
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB


        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register_employee_details'])) {

            $empName = $empEmail = $empGender = $empDateOfJoin = $empRoleId = $photoPath = '';
            // Get form data directly from $_POST
            $empName = $_POST['employee_name'];
            $empEmail = $_POST['emp_email_id'];
            $empGender = $_POST['gender'];
            $empDateOfJoin = $_POST['date_of_joining'];
            $empRoleId = $_POST['role_id'];

            // Handle photo upload
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
                    // $newFilename = 'emp_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

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
            // echo "<pre>"; print_r($insert); echo "</pre>";

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
                    $file = fopen($csvFilePath, 'a'); // append mode
                }

                if ($file) {

                    $empId = $insert['msg']['employee_id']; // assumes you return ID from DB
                    $status = 'active'; //default

                    fputcsv($file, [$empId, $empName, $empEmail, $empGender, $empDateOfJoin, $status, $empRoleId, $photoPath]);

                    fclose($file);
                }

                $arr = ['data'=>$insert,'path'=>'View/AdminView/registerView.php'];
                return $arr;
            }  //insert status = success


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





    // public function approve(){

    // }


}
