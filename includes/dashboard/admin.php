<?php
require_once "includes/check.php";

if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'system' && $_SESSION['user']['role'] != 'clerk') {
    go('index.php');
}

switch ($_GET['page']) {
    case 'plant-checklists':
        $page_title = 'Plant Check Lists';
        $page_name = 'manager/plants/plant-checklists';

        break;

    case 'operator-logs':
        $page_title = 'Operator Logs';
        $page_name = 'manager/operator_logs/operator-logs';

        break;

    case 'job-card-view':
        $page_title = 'View Job Card';
        $page_name = 'mechanic/job-card-view';

        $get_mechanic = dbq("select concat(name,' ',last_name) as name, user_id as value from users_tbl where role='mechanic' and depart='workshop'");
        while ($row = dbf($get_mechanic))  $mechanic_list = [];

        require "./includes/forms/manager/jobcards/job-card-view.php";
        break;


    case 'daily-pre-task-mini-view':
        $page_title = 'View Daily Pre-Task Mini Risk Assessment';
        $page_name = 'mechanic/daily-pre-task-mini-view';
        require "./includes/forms/mechanic/jobcards/daily-pre-task-mini-view.php";

        break;

    case 'add-job-requisition':
        $page_title = 'Add Requisition Job Card';
        $page_name = 'manager/jobcards/add-job-requisition';
        if (!isset($_GET['id'])) go('dashboard.php');
        $jobcard_ = dbf(dbq("select * from jobcards where job_id={$_GET['id']}"));
        $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));

        require "./includes/forms/manager/jobcards/add-job-requisition.php";
        break;

    case "profile":
        $page_title = 'Your Profile';
        $page_name = 'profile';
        require "includes/forms/profile.php";
        break;

    case 'add-user':

        if ($_SESSION['user']['role'] == 'clerk') {
            $page_title = 'Dashboard Overview';
            switch ($_SESSION['user']['role']) {
                case "clerk":
                    $page_name = 'dash_clerk';
                    break;

                default:
                    $page_name = 'dash_manager';
            }
        } else {
            $page_title = 'Add/Manage Users';
            $page_name = 'manager/users/add-manage-users';
            require "includes/forms/manager/users/manage-users-form.php";
        }
        break;

    case 'add-plant':
        if ($_SESSION['user']['role'] == 'clerk') {
            $page_title = 'Dashboard Overview';
            switch ($_SESSION['user']['role']) {
                case "clerk":
                    $page_name = 'dash_clerk';
                    break;

                default:
                    $page_name = 'dash_manager';
            }
        } else {
            $page_title = 'Add/Manage Plant';
            $page_name = 'manager/plants/add-manage-plant';
            require "includes/forms/manager/plants/manage-plants-form.php";
        }

        break;

    case 'view-plant':

        if ($_SESSION['user']['role'] == 'clerk') {
            $page_title = 'Dashboard Overview';
            switch ($_SESSION['user']['role']) {
                case "clerk":
                    $page_name = 'dash_clerk';
                    break;

                default:
                    $page_name = 'dash_manager';
            }
        } else {
            $back_page = "dashboard.php?page=add-plant";
            $page_title = 'Plant';
            $page_name = 'manager/plants/plant-view';

            if (!isset($_GET['id'])) {
                go($back_page);
            }

            $get_plant = dbq("select * from plants_tbl where plant_id='{$_GET['id']}'");
            if ($get_plant) {
                if (dbr($get_plant) == 1) {
                    $plant_ = dbf($get_plant);
                } else {
                    go($back_page);
                }
            } else {
                go($back_page);
            }

            require "includes/forms/manager/plants/view-plant-form.php";
        }
        break;

    case 'add-job':
        $page_title = 'Add New Job Card';
        $page_name = 'manager/jobcards/add-job-card-manager';
        require "./includes/forms/manager/jobcards/add-jobcard-manager.php";
        break;

    case 'new-job':
        $page_title = 'New Job Cards';
        $page_name = 'manager/jobcards/new-job-cards';
        require "./includes/forms/manager/jobcards/new-job-cards.php";
        break;

    case 'new-job-allocate':
        $page_title = 'New Job Cards - Allocate Job Card Number';
        $page_name = 'manager/jobcards/new-job-cards-allocated';

        require "./includes/forms/manager/jobcards/new-job-cards-allocated.php";
        break;

    case 'new-defects':
        $page_title = 'New Defect reports';
        $page_name = 'manager/jobcards/new-defects';
        require "./includes/forms/manager/jobcards/new-defects.php";
        break;

    case 'list-defects':
        $page_title = 'New Defect reports';
        $page_name = 'manager/jobcards/list-defects';
        // require "./includes/forms/manager/jobcards/new-defects.php";
        break;

    case 'additional-defects':
        $page_title = 'Additional Defect reports';
        $page_name = 'manager/jobcards/additional-defects';
        require "./includes/forms/manager/jobcards/additional-defects.php";
        break;

    case 'open-job':
        $page_title = 'Open Job Cards';
        $page_name = 'manager/jobcards/open-job-cards';
        break;

    case 'completed-job':
        $page_title = 'Completed Job Cards';
        $page_name = 'manager/jobcards/completed-job-cards';
        require "./includes/forms/manager/jobcards/completed-job-cards.php";
        break;

    case 'arch-job':
        $page_title = 'Closed Job Cards';
        $page_name = 'manager/jobcards/archive-job-cards';
        break;

    case "job-requisitions-new":
        $page_title = 'New Job Card Requisitions';
        $page_name = 'manager/jobcards/job-requisitions-new';
        include "./includes/forms/manager/jobcards/job-requisitions.php";
        break;

    case "job-requisitions-open":
        $page_title = 'Open Job Card Requisitions';
        $page_name = 'manager/jobcards/job-requisitions-open';
        include "./includes/forms/manager/jobcards/job-requisitions.php";
        break;

    case "job-requisitions-completed":
        $page_title = 'Completed Job Card Requisitions';
        $page_name = 'manager/jobcards/job-requisitions-completed';
        //include "./includes/forms/manager/jobcards/job-requisitions.php";
        break;

    case 'tyre-reports-new':
        $page_title = 'New Tyre Reports';
        $page_name = 'manager/jobcards/tyre-reports-new';
        require "./includes/forms/manager/jobcards/tyre-reports-new.php";
        break;

    case 'tyre-reports-list':
        $page_title = 'Tyre Reports';
        $page_name = 'manager/jobcards/tyre-reports-list';
        //require "./includes/forms/manager/jobcards/tyre-reports-list.php";
        break;

    case 'rep-operator-log':
        $page_title  = "Plant Operator Log Report";
        $page_name = 'manager/reports/rep-operator-log';
        break;

    case 'rep-jobcard-events':
        $page_title  = "Job Card Events Report";
        $page_name = 'manager/reports/rep-jobcard-events';

        break;


    default:
        $page_title = 'Dashboard Overview';
        include "./includes/forms/dashboard.php";
        switch ($_SESSION['user']['role']) {
            case "clerk":
                $page_name = 'dash_clerk';
                break;

            default:
                $page_name = 'dash_manager';
        }
}
