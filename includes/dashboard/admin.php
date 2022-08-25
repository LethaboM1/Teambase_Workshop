
<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'manager' && $_SESSION['user']['role'] != 'system') {
    go('index.php');
}

switch ($_GET['page']) {
    case 'add-user':
        $page_title = 'Add/Manage Users';
        $page_name = 'add-manage-users';
        include "includes/forms/manage-users-form.php";
        break;

    case 'add-plant':
        $page_title = 'Add/Manage Plant';
        $page_name = 'add-manage-plant';
        include "includes/forms/manage-plants-form.php";
        break;

    case 'view-plant':
        $back_page = "dashboard.php?page=add-plant";
        $page_title = 'Plant: HG564365';
        $page_name = 'plant-view';

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

        include "includes/forms/view-plant-form.php";

        break;

    case 'add-job':
        $page_title = 'Add New Job Card';
        $page_name = 'add-job-card';
        break;

    case 'new-job':
        $page_title = 'New Job Cards';
        $page_name = 'new-job-cards';
        break;

    case 'open-job':
        $page_title = 'Open Job Cards';
        $page_name = 'open-job-cards';
        break;

    case 'arch-job':
        $page_title = 'Job Cards Archives';
        $page_name = 'archive-job-cards';
        break;

    default:
        $page_title = 'Dashboard Overview';
        $page_name = 'dash_manager';
}
