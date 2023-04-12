<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'ws_inspector') {
    go('index.php');
}

switch ($_GET['page']) {
    case "profile":
        $page_title = 'Your Profile';
        $page_name = 'profile';
        require "includes/forms/profile.php";
        break;

    case 'add-defect-report':
        $page_title = 'Submit Defect Report';
        $page_name = 'ws_inspector/add-defect-report';
        require "./includes/forms/ws_inspector/add-defect-report.php";
        break;

    case 'defects':
        $page_title = 'Defect Reports';
        $page_name = 'ws_inspector/defects';
        require "./includes/forms/ws_inspector/defects.php";

        break;

    case 'defect-report':
        $page_title = 'Defect Report';
        $page_name = 'ws_inspector/defect-report';
        break;


    default:
        $page_title = 'Dashboard Overview';
        $page_name = 'ws_inspector/defects';
        require "./includes/forms/ws_inspector/defects.php";
}
