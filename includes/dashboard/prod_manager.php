<?php
require_once "includes/check.php";
if ($_SESSION['user']['role'] != 'production_manager') { // && $_SESSION['user']['role'] != 'system' && $_SESSION['user']['role'] != 'clerk'
    go('index.php');
}

switch ($_GET['page']) {
    case 'page-name':
        $page_title = 'Page Title';
        $page_name = 'production/manager/page-name';

        break;

    default:
        $page_title = 'Dashboard Overview';
        include "./includes/forms/dashboard.php";    //enables the Out of office feature    
        $page_name = 'dash_prod_manager';
}
