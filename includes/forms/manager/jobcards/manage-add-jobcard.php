<?php

if (isset($_POST['add_jobcard'])) {
    if (
        $_POST['mechanic_id'] != '0'
        && $_POST['plant_id'] != '0'
        && strlen($_POST['job_number']) > 0
        && strlen($_POST['job_date']) > 0
        && date_create($_POST['job_date'])
        && $_POST['hours'] > 0
        && (strlen($_POST['km_reading']) > 0 || strlen($_POST['hr_reading']) > 0)
    ) {
        if (strlen($_POST['km_reading']) > 0) {
            $query_ = "km_reading='" . esc($_POST['km_reading']) . "',";
        } else {
            $query_ = "hr_reading='" . esc($_POST['hr_reading']) . "',";
        }
        $add_jobcard = dbq("insert into jobcards set
                                jobcard_number='" . esc($_POST['job_number']) . "',
                                plant_id='" . esc($_POST['plant_id']) . "',
                                fleet_number='" . esc($_POST['fleet_number']) . "',
                                job_date='" . esc($_POST['job_date']) . "',
                                logged_by='" . esc($_SESSION['user']['user_id']) . "',
                                mechanic_id='" . esc($_POST['mechanic_id']) . "',
                                {$query_}
                                allocated_hours='" . esc($_POST['hours']) . "',
                                status='Allocated'
                                ");
        if ($add_jobcard) {
            $_SESSION['msg'][] = "Job card added.";
            go("dashboard.php?page=open-job");
        } else {
            sqlError();
        }
    } else {
        $error[] = "Please fill in all required fields.";
    }
}
