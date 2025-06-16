<?php
// session_start();
include './App/View/CommonView/navbar.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracking</title>

    <link rel="stylesheet" href="assets/css/leavetrack.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">


</head>

<body>
    <div class="blank"></div>
    <div class="container">

        <h3><span>Total Leave:</span> <?= isset($data['userData']['total_leave']) ? htmlspecialchars($data['userData']['total_leave']) : '' ?></h3>

        <div class="leave-panels">

            <?php if (!empty($data['userData']['fetchLeaveTaken'])): ?>
                <?php foreach ($data['userData']['fetchLeaveTaken'] as $leave): ?>
                    <div class="leave-panel">
                        <div class="leave-name"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $leave['leave_type']))) ?></div>
                        <div class="leave-taken">Taken: <?= $leave['leave_taken'] ?> days</div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                <?= "<tr><td colspan='X'>No leave records found.</td></tr>"  ?>
            <?php endif; ?>
        </div>

    </div>


   

</body>

</html> 