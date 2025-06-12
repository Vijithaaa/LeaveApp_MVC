<?php
include './App/Includes/helperfunction.php';

//  displayAlertMessages() 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Leave Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../asset/css/style.css">
    <link rel="stylesheet" href="../../asset/css/leaveform.css">
    <style>
        .blank {
            background-color: transparent;
            height: 55px;
        }
    </style>

</head>

<body>
    <div class="blank"></div>

    <div class="container-image">
        <img src="assets/images/common/illu-2.jpeg" alt="bg">
        <?= displayAlertMessages() ?>
        <div class="image-side"></div>

        <div class="leaveform">
            <form method="post" onsubmit="return confirm('Are you sure you want to <?= $application_id ? 'update' : 'submit' ?> this leave application?');">
                <?php if ($application_id): ?>
                    <input type="hidden" name="application_id" value="<?= htmlspecialchars($application_id) ?>">
                <?php endif; ?>

                <div class="form-detail">
                    <label for="leave_type_id">Leave Type :</label>
                    <select name="leave_type_id" id="leave_type_id" required>
                        <option value="">Select Leave Type</option>
                        <?php foreach ($leaveType['leaveIdName'] as $key => $value): ?>
                            <option value="<?= $key ?>" <?= ($leave_type_id == $key) ? 'selected' : '' ?>>
                                <?= htmlspecialchars(ucwords(str_replace("_", " ", $value))) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-detail">
                    <label>Leave Start Date:</label>
                    <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
                </div>

                <div class="form-detail">
                    <label>Leave End Date:</label>
                    <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
                </div>

                <div class="form-group button-container">
                    <button type="submit" class="my-custom-button" name="<?= $application_id ? 'edit_form' : 'submit_form' ?>">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>