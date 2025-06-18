<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">

    <title> Login</title>
</head>

<body>
    <img src="assets/images/common/illu-2.jpeg" alt="background">
    <div class="page-wrapper">
        <div class="loginpage-container">
            <h2 class="login-title"></h2>
            <div class="loginform">
                <?= displayAlertMessages() ?>
                <form method="post" action="index.php?controller=Authenticate&action=submitform_emp_admin">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" required>
                    </div>
                    <div class="form-group-pass">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group button-container">
                        <!-- back -->
                        <a href="index.php?controller=Authenticate&action=homepage" class="my-custom-button" style="text-decoration:none;">Back</a>
                       <!-- login -->
                        <button type="submit" class="my-custom-button" name="login">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>