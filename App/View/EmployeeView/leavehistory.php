<?php
include './App/View/CommonView/navbar.php';

// include './App/Includes/helperfunction.php';

                // displayAlertMessages()

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/leave-history.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">

    <title>Leave History</title>

</head>

<body>
    <div class="blank"></div>

<div class="filter-dropdown">
  <select class="form-select" onchange="window.location.href=this.value">
    <option>Status</option>
    <option value="index.php?controller=employee&action=leavehistory">All</option>
    <option value="index.php?controller=employee&action=leavehistory&filter=pending">Pending</option>
    <option value="index.php?controller=employee&action=leavehistory&filter=approved">Approved</option>
    <option value="index.php?controller=employee&action=leavehistory&filter=rejected">Rejected</option>
  </select>
</div>

    <!-- <div  class="filter-options">
    <a class="btn btn-primary" href="index.php?controller=employee&action=leavehistory">All</a>
    <a class="btn btn-primary" href="index.php?controller=employee&action=leavehistory&filter=pending">Pending</a>
    <a class="btn btn-primary" href="index.php?controller=employee&action=leavehistory&filter=approved">Approved</a>
    <a class="btn btn-primary" href="index.php?controller=employee&action=leavehistory&filter=rejected">Rejected</a>
</div> -->


    <div class="container leave-history-wrapper py-4">

        <div class="card leave-history-card mx-auto my-4">

            <div class="card-body p-0">

        <?= displayAlertMessages() ?>

                <?php if (!empty($data)): ?>
                    <table class="table leave-history-table mb-0">
                        <thead>
                            <tr>
                                <!-- <th>Application ID</th> -->
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Requested Date</th>
                                <th>Response Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $app): ?>
                                <tr>
                                    <td><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $app['leave_type_id']))) ?></td>
                                    <td><?= htmlspecialchars(formatDate($app['leave_start_date'])) ?></td>
                                    <td><?= htmlspecialchars(formatDate($app['leave_end_date'])) ?></td>
                                    <td class="days"><?= $app['days'] ?> day<?= $app['days'] != 1 ? 's' : '' ?></td>

                                    <td>
                                        <span class="badge status-<?= $app['status'] ?>">
                                            <?= ucfirst(htmlspecialchars($app['status'])) ?>
                                        </span>
                                    </td>


                                    <td><?= formatDateTime($app['reqested_date']) ?></td>
                                    <td> <?= !empty($app['response_date']) ? formatDateTime($app['response_date']) : 'N/A' ?> </td>
                                    <td class="text-center">
                                        <?php if ($app['status'] == 'pending'): ?>

                                            <form action="index.php?controller=employee&action=showleaveform" method="post" style="display:inline;">
                                                <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                                <button type="submit" class="text-button edit">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                            </form>

                                            
                                            <form action="index.php?controller=employee&action=deleteRow" method="post" style="display:inline;">
                                                <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                                <button type="submit" class="text-button delete"  onclick="return confirm('Are you sure you want to delete this application?');" >
                                                    <i class="bi bi-trash3"></i> Delete
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

        </div>
    </div>
</body>

</html>