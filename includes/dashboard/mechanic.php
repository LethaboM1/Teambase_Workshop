<?php

require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'mechanic') {
    go('index.php');
}

switch ($_GET['page']) {

    case 'add-job':
        $page_title = 'Request New Job Card';
        $page_name = 'mechanic/add-job-card';
        require "./includes/forms/mechanic/jobcards/add-job-card.php";
        break;

    case 'open-job':
        $page_title = 'Open Job Cards';
        $page_name = 'mechanic/open-job-cards';
        break;

    case 'daily-pre-task-mini':
        $page_title = 'Daily Pre-Task Mini Risk Assessment';
        $page_name = 'mechanic/daily-pre-task-mini';
        require "./includes/forms/mechanic/jobcards/daily-pre-task-mini.php";
        break;

    case 'plant-inspection':
        $page_title = 'Plant Inspection / Job Instruction Report';
        $page_name = 'mechanic/plant-inspection';
        break;

    case 'defect-report':
        $page_title = 'Defect Report';
        $page_name = 'mechanic/defect-report';
        break;

    case 'plant-schedule':
        $page_title = 'Plant Service Schedule';
        $page_name = 'mechanic/plant-schedule';
        require "./includes/forms/mechanic/jobcards/plant-schedule.php";
        break;

    case 'job-card-view':
        $page_title = 'View Job Card';
        $page_name = 'mechanic/job-card-view';
        require "./includes/forms/mechanic/jobcards/job-card-view.php";
        break;


    default:
        $page_title = 'Dashboard Overview';
        $page_name = 'dash_mechanic';
}
