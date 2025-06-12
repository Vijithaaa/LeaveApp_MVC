<?php
include './App/View/CommonView/navbar.php';
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/leavetrack.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">

       <style>
        .blank {
            background-color: transparent;
            height: 15vh;
        }
    </style>
</head>

<body>
    <div class="blank"></div>
    <div class="container">

        <h3><span>Total Leave:</span> <?= $userData['total_leave'] ?></h3>

        <div class="leave-panels">
            
            <?php foreach ($userData['fetchLeaveTaken'] as $leave): ?>
                <div class="leave-panel">
                    <div class="leave-name"><?= htmlspecialchars(ucwords(str_replace('_',' ',$leave['leave_type']))) ?></div>
                    <div class="leave-taken">Taken: <?= $leave['leave_taken'] ?> days</div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

</body>

</html>