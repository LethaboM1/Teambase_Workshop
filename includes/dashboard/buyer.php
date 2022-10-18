
<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'system' && $_SESSION['user']['role'] != 'clerk' && $_SESSION['user']['role'] != 'buyer') {
    go('index.php');
}

switch ($_GET['page']) {
    case "profile":
        $page_title = 'Your Profile';
        $page_name = 'profile';
        require "includes/forms/profile.php";
        break;

    case "job-requisitions":
        $page_title = 'Job Card Requisitions';
        $page_name = 'manager/jobcards/job-requisitions';
        include "./includes/forms/manager/jobcards/job-requisitions.php";
        break;

    default:
        $page_title = 'Dashboard Overview';
        $page_name = 'dash_buyer';
}
