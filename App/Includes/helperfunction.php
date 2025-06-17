<?php



function displayAlertMessages()
{
    if (isset($_COOKIE['errorMsg'])) {
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
        echo $_COOKIE['errorMsg'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo "</div>";
    }

    if (isset($_COOKIE['successMsg'])) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
        echo $_COOKIE['successMsg'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo "</div>";
    }
}


//22nd May 25
function formatDate($dateString)
{
    $date = new DateTime($dateString);
    $day = $date->format('jS M y');
    return $day;
}

//16th Jun ,11:08 AM
function formatDateTime($dateString)
{
    $date = new DateTime($dateString);
    $day = $date->format('jS M ,H:i A');
    return $day;
}

// Function to calculate days between two dates
function calculateLeaveDays($startDate, $endDate)
{
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    return $interval->days + 1; // +1 to include both start and end days
}

//fuction for employeeProfile
function getEmployeeProfileHtml($empImagePath = null, $baseImagePath = '/new/leaveTracking_oop/asset/images/employees/')
{
    $html = '<div class="employee-profile">';

    if (!empty($empImagePath)) {
        $imageFile = basename($empImagePath);
        $fullImagePath = $baseImagePath . $imageFile;
        $html .= '<img src="' . htmlspecialchars($fullImagePath) . '" alt="Employee Photo" class="profile-photo">';
    }
    $html .= '</div>';

    return $html;
}


