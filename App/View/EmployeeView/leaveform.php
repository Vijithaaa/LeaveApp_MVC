<?php
include './App/View/CommonView/navbar.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Leave Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/leaveform.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">

    

</head>

<body>
    <div class="blank"></div>

    <div class="container-image">
        <img src="assets/images/common/form-3.jpg" alt="bg">
    
        <?= displayAlertMessages() ?>

        <div class="leaveform">
            <form id="formId" action="index.php?controller=employee&action=submitform" method="post">
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
                    <button type="submit" form="formId" class="my-custom-button" name="<?php $data['application_id'] ? 'edit_form' : 'submit_form'; ?>" >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>