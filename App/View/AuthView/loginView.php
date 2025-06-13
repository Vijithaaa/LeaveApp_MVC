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
    <link rel="stylesheet" href="assets/css/login.css">

    <title><?= $data['page_title'] ?></title>
</head>

<body>
    <img src="assets/images/common/illu-2.jpeg" alt="background">
    <div class="page-wrapper">
        <div class="loginpage-container">
            <h2 class="login-title"><?= $data['page_title'] ?></h2>
            <div class="loginform">
                <?= displayAlertMessages() ?>

                <form method="post" action="index.php?controller=auth&action=submitform&type=<?php echo $data["login_type"]; ?>">
                    <div class="form-group">
                        <label>Username:</label>
                        <input type="text" name="username" required>
                    </div>

                    <div class="form-group-pass">
                        <label><?= $data['login_type'] === 'admin' ? 'Password' : 'Employee ID' ?>:</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group button-container">
                        <button type="submit" class="my-custom-button" name="login">Login</button>
                    </div>
                </form>



            </div>
        </div>
    </div>
</body>

</html>