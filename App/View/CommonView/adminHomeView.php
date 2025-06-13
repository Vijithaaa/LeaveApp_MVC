<?php
// session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin-page.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">



    <title>admin</title>
</head>

<body>

    <nav class="navbar custom-navbar">
        <!-- <nav class="nav-wrapper custom-navbar"> -->
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="assets/images/common/infiniti_logo.png" alt="Logo" style="width:80px;" class="rounded-pill me-3">
            </a>
            <span class="h3">Admin</span>
            <div class="d-flex">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.php?controller=admin&action=form"><i class="bi bi-person-badge-fill"></i> Register</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" href="index.php?controller=admin&action=approve"><i class="bi bi-caret-right-fill"></i> Approve Applications</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-danger" href="index.php?controller=auth&action=logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="admin-container">
    </div>

</body>
<footer class="app-footer">
  <div class="footer-content">
    <p>&copy; <?= date("Y")?> Employee Leave tracking Management. All rights reserved.</p>
    <!-- <p>A simple footer for your application</p> -->
  </div>
</footer>
</html>