<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/272114282e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/approver.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">



    <title>Leave History</title>

</head>

<body>
    <div class="blank"></div>
    <nav class="navbar custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/images/common/infiniti_logo.png" alt="Logo" style="width:80px;" class="rounded-pill me-3">
            </a>
            <span class="h3">Leave Approval</span>
            <div class="d-flex">
                <ul class="navbar-nav flex-row">
                      <li class="nav-item me-3">
                        <a class="nav-link" href="index.php?controller=admin&action=form"><i class="bi bi-person-badge-fill"></i> Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="index.php?controller=Authentication&action=homepage"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-approve">
        <div class="container py-4">

                <?= displayAlertMessages() ?>

            <?php if (!empty($data)): ?>
                <table class="table table">
                    <thead class="table-info">
                        <tr>
                            <th>Employee Name</th>
                            <th>Leave Type </th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Days</th>
                            <th>Requested Date</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $app): ?>
                            <tr>

                                <td><?= htmlspecialchars(ucfirst($app['employee_id'])) ?></td>

                                <td><?= htmlspecialchars (ucfirst(str_replace('_',' ',$app['leave_type_id']))) ?></td>
                                <td><?= htmlspecialchars(formatDate($app['leave_start_date'])) ?></td>
                                <td><?= htmlspecialchars(formatDate($app['leave_end_date'])) ?></td>
                                <td class="days"><?= $app['days'] ?> day<?= $app['days'] != 1 ? 's' : '' ?></td>

                                <td><?= formatDateTime($app['reqested_date']) ?></td>

                               

                                <td class="text-center">
                                    <?php if ($app['status'] == 'pending'): ?>

                                        <form class="actions" action="index.php?controller=admin&action=status" method="post" style="display:inline;">
                                            <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                            <input type="hidden" name="actions" value="approved">
                                            <button type="submit" class="text-action approve">
                                                <i class="bi bi-check2-square"></i> Approve
                                            </button>
                                        </form>
                                        <form class="actions" action="index.php?controller=admin&action=status" method="post" style="display:inline;">
                                            <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                            <input type="hidden" name="actions" value="rejected">
                                            <button type="submit" class="text-action reject">
                                                <i class="bi bi-trash3"></i> Reject
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">No actions</span>
                                    <?php endif; ?>
                                </td>



                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No leave applications found.</p>
            <?php endif; ?>


        </div>
</body>
<footer class="app-footer">
  <div class="footer-content">
    <p>&copy; <?= date("Y")?> Employee Leave tracking Management. All rights reserved.</p>
    <!-- <p>A simple footer for your application</p> -->
     
  </div>
</footer>
</html>