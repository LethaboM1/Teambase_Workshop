
<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'system' && $_SESSION['user']['role'] != 'clerk') {
    go('index.php');
}

switch ($_GET['page']) {
    case "profile":
        $page_title = 'Your Profile';
        $page_name = 'profile';
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

    case "job-requisitions":
        $page_title = 'Job Card Requisitions';
        $page_name = 'manager/jobcards/job-requisitions';
        include "./includes/forms/manager/jobcards/job-requisitions.php";
        break;

    default:
        $page_title = 'Dashboard Overview';
        switch ($_SESSION['user']['role']) {
            case "clerk":
                $page_name = 'dash_clerk';
                break;

            default:
                $page_name = 'dash_manager';
        }
}
