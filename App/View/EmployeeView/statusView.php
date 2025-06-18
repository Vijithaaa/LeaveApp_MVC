<?php
include './App/View/CommonView/navbar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave History</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/status.css">
    <link rel="stylesheet" href="assets/css/employee-navbar.css">
   
</head>
<body>
    <div class="blank"></div>
    <div class="page-container">
        <div class="filter-container">
            <div class="filter-dropdown">
                <select onchange="window.location.href=this.value">
                    <option>Status</option>
                    <option value="index.php?controller=employee&action=leavehistory">All</option>
                    <option value="index.php?controller=employee&action=leavehistory&filter=pending">Pending</option>
                    <option value="index.php?controller=employee&action=leavehistory&filter=approved">Approved</option>
                    <option value="index.php?controller=employee&action=leavehistory&filter=rejected">Rejected</option>
                </select>
            </div>
        </div>

        <div class="leave-cards">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $app): ?>
                    <div class="leave-card">
                        <div class="card-header">
                            <div class="leave-type"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $app['leave_type_id']))) ?></div>
                            <div class="leave-status status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></div>
                        </div>
                        
                        <div class="card-details">
                            <div class="detail-group">
                                <div class="detail-row">
                                    <div class="detail-label">Dates</div>
                                    <div><?= htmlspecialchars(formatDate($app['leave_start_date'])) ?> - <?= htmlspecialchars(formatDate($app['leave_end_date'])) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Days</div>
                                    <div><?= $app['days'] ?> day<?= $app['days'] != 1 ? 's' : '' ?></div>
                                </div>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-row">
                                    <div class="detail-label">Requested</div>
                                    <div><?= formatDateTime($app['reqested_date']) ?></div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Response</div>
                                    <div><?= !empty($app['response_date']) ? formatDateTime($app['response_date']) : 'N/A' ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <?php if ($app['status'] == 'pending'): ?>
                            <div class="card-footer">
                                <form action="index.php?controller=employee&action=showleaveform" method="post" style="display:inline;">
                                    <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                    <button type="submit" class="action-btn edit-btn"><i class="bi bi-pencil-square"></i> Edit</button>
                                </form>
                                <form action="index.php?controller=employee&action=deleteRow" method="post" style="display:inline;">
                                    <input type="hidden" name="application_id" value="<?= $app['application_id'] ?>">
                                    <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this application?');">
                                        <i class="bi bi-trash3"></i> Delete
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-leaves">No leave applications found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>