<?php

//employee's navbar
if (isset($_SESSION['EMP']['emp_logged_in']) || $_SESSION['EMP']['emp_logged_in']  == true) {

  $empName = ucfirst($_SESSION['EMP']['empName']);
  $empImage = $_SESSION['EMP']['empImage'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- fontawesome -->
  <script src="https://kit.fontawesome.com/272114282e.js" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <title>Document</title>
</head>

<body>


  <nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container-fluid">

      <?= getEmployeeProfileHtml($empImage) ?>
      <a class="navbar-brand text-dark">
        <h2><?= $empName ?></h2>
      </a>

      <?php if (isset($data['navbar'])) : ?>
        <div class="d-flex align-items-center">
          <?= $data['navbar'] ?>
        </div>
      <?php endif; ?>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link text-dark" href="index.php?controller=employee&action=emp_leavetrack"><i class="bi bi-activity"></i> Leave Tracking</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="index.php?controller=employee&action=showleaveform"><i class="bi bi-pencil-square"></i> Leave Application</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-dark" href="index.php?controller=employee&action=leavehistory"><i class="bi bi-chat-right-dots-fill"></i> Leave History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="index.php?controller=Authentication&action=logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <footer class="app-footer">
    <div class="footer-content">
      <p>&copy; <?= date("Y") ?> Employee Leave tracking Management. All rights reserved.</p>
    </div>
  </footer>

</body>

</html>