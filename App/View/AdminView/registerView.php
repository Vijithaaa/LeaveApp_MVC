<?php
// include './App/Includes/helperfunction.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">



    <title>Register Employee Details</title>
</head>

<body>

    <div class="page-wrapper">
        <div class="image">
            <img src="assets/images/common/register-2.avif" alt="">
        </div>
        <div class="insertEmployeeDetailContainer">
            
            
            <div class="loginform">
                <?= displayAlertMessages() ?>
                <form method="post" enctype="multipart/form-data" action="index.php?controller=admin&action=submitform">
                    <div class="form-group">
                        <label>employee Name:</label>
                        <input type="text" name="employee_name" required>
                    </div>
                    <div class="form-group">
                        <label>employee Email:</label>
                        <input type="email" name="emp_email_id" required>
                    </div>
                    <div class="form-group">
                        <div class="radio-group">
                            <label class="radio-option">Gender:
                                <input type="radio" name="gender" value="male" required>
                                <span class="radio-label">Male</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="gender" value="female">
                                <span class="radio-label">Female</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date of Joining:</label>
                        <input type="date" name="date_of_joining" required>
                    </div>
                    <div class="form-group">
                        <label for="role_name">Role:</label>
                        <select name="role_id" id="role_name" required>
                            <option value="">Select Role Name</option>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $key => $val): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($val) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="emp_image">Employee Image : </label>
                        <input type="file" id="emp_image" name="employee_photo" accept="image/png, image/jpeg ,image/gif" required>
                    </div>

                    <div class="form-group button-container">
                        <button type="submit" class="my-custom-button" name="register_employee_details"
                            onclick="return confirm('Are you sure you want to register this employee Detailss?');">Register</button>

                        <a href="index.php?controller=auth&action=adminpage" class="my-custom-button" style="text-decoration:none;">Back</a>
                    </div>


                </form>
            </div>
        </div>

</body>
<footer class="app-footer">
  <div class="footer-content">
    <p>&copy; <?= date("Y")?> Employee Leave tracking Management. All rights reserved.</p>
    <!-- <p>A simple footer for your application</p> -->
     
  </div>
</footer>

</html>