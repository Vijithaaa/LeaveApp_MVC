<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home-index-page.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">

    <title>home</title>
   
    
</head>

<body>


    <nav class="navbar custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="assets/images/common/infiniti_logo.png" alt="Logo" style="width:80px;" class="rounded-pill me-3">
            </a>
            <span class="h3">Employee Leave Tracking Management</span>
            <div class="d-flex">
                <ul class="navbar-nav flex-row">
                    <li class="nav-item me-3">
                        <!-- <a class="nav-link" href="index.php?controller=Authentication&amp;action=showform_emp_admin&amp;type=employee"> -->
                            <!-- <i class="bi bi-box-arrow-in-right"></i> Login -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="index.php?controller=Authentication&amp;action=showform_emp_admin&amp;type=admin"> -->
                            <!-- <i class="bi bi-person-circle"></i> Admin -->
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=Authenticate&amp;action=showform_emp_admin">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="blank"></div>
    <div class="container-index">

        <div class="container-fluid mt-3">

            <div class="container">
                <h4>Employee Leave Benefits</h4>
                <hr>

                <div class="row">
                    <!-- Maternity Leave Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Maternity Leave
                            </div>
                            <div class="card-body">
                                <p>Paid leave for mothers before and after childbirth.</p>
                                <p>Total leave: <span class="highlight">26 weeks</span> (first two children), <span class="highlight">12 weeks</span> (third child onwards)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Paternity Leave Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Paternity Leave
                            </div>
                            <div class="card-body">
                                <p>Leave for new fathers to care for their newborn.</p>
                                <p>Total leave: <span class="highlight">15 days</span> (govt sector), varies in private sector</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sick Leave Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Sick Leave
                            </div>
                            <div class="card-body">
                                <p>Leave for employees when unwell or injured.</p>
                                <p>Total leave: <span class="highlight">12 days</span> per year (minimum)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Casual Leave Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Casual Leave
                            </div>
                            <div class="card-body">
                                <p>Short planned leaves for personal reasons.</p>
                                <p>Total leave: Varies by company (typically <span class="highlight">7-12 days</span>)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Earned Leave Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Earned Leave
                            </div>
                            <div class="card-body">
                                <p>Accrued leave based on days worked.</p>
                                <p>Total leave: Varies by region (can be <span class="highlight">carried forward</span>)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Other Leaves Card -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Other Leaves
                            </div>
                            <div class="card-body">
                                <p>Special leaves offered by some companies.</p>
                                <p>Includes: <span class="highlight">Marriage leave</span> (3-14 days), <span class="highlight">Compensatory leave</span>, <span class="highlight">LOP leave</span></p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <footer class="app-footer">
        <div class="footer-content">
            <p>&copy; <?= date("Y")?> Employee Leave tracking Management. All rights reserved.</p>
        </div>
    </footer>
</body>
    
</html>