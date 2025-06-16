<?php
include './App/View/CommonView/navbar.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Leave Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/leaveform.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">



</head>

<body>
    <div class="blank"></div>

    <div class="container-image">
        <img src="assets/images/common/form-3.jpg" alt="bg">

        
        <div class="leaveform">
            <?= displayAlertMessages() ?>
            <form id="formId" action="index.php?controller=employee&action=submitform" method="post">
                <h3 class="form-heading">
                    <?= isset($data['application_id']) ? 'Update Your Leave' : 'Apply for Leave' ?>
                </h3>

                <div class="form-detail">


                    <?php if ($data['application_id']): ?>
                        <input type="hidden" name="application_id" value="<?= htmlspecialchars($data['application_id']) ?? null ?>">
                    <?php endif; ?>

                    <label for="leave_type_id">Leave Type :</label>
                    <select name="leave_type_id" id="leave_type_id" required>
                        <option value="">Select Leave Type</option>
                        <?php foreach ($data['leaveType']['leaveIdName'] as $key => $value): ?>
                            <option value="<?= $key ?>" <?= ($data['leave_type_id'] == $key) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(ucwords(str_replace("_", " ", $value))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-detail">
                    <label>Leave Start Date:</label>
                    <input type="date" name="start_date" value="<?= $data['start_date'] ?? null ?>" required>
                </div>

                <div class="form-detail">
                    <label>Leave End Date:</label>
                    <input type="date" name="end_date" value="<?= $data['end_date'] ?? null ?>" required>
                </div>

                <div class="form-group button-container">
                    <button type="submit" form="formId" class="my-custom-button" name="<?= isset($data['application_id']) ? 'edit_form' : 'submit_form' ?>"
                        onclick="return confirm('Are you sure you want to <?= isset($data['application_id']) ? 'update' : 'submit' ?> this leave application?');">
                        <?= isset($data['application_id']) ? 'Update' : 'Submit' ?>
                    </button>

                </div>
            </form>
        </div>
    </div>
</body>

</html>