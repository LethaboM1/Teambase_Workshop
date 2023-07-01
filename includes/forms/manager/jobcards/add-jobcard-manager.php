<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



if (isset($_POST['add_jobcard'])) {
    if (
        $_POST['clerk_id'] > 0
        && $_POST['mechanic_id'] != '0'
        && (
            ($_POST['plant_id'] > 0 && $_POST['jobcard_type'] != 'sundry' && strlen($_POST['site']) > 0) ||
            ($_POST['jobcard_type'] == 'sundry') ||
            ($_POST['jobcard_type'] == 'contract' && $_POST['site_id'] > 0)
        )

    ) {
        $create_jobcard = true;

        if ($_POST['jobcard_type'] == 'sundry') {
            $chk_sundry_jobcard = dbq("select * from jobcards where status='open' and jobcard_type='sundry' and mechanic_id={$_POST['mechanic_id']}");
            if (dbr($chk_sundry_jobcard) > 0) {
                error("There is an open sundry job card for this mechanic.");
                $create_jobcard = false;
            } else {
                $_POST['plant_id'] = 0;
                $_POST['site_id'] = 0;
                $_POST['priority'] = 9999;
                $_POST['allocated_hours'] = 0;
                $reading = "";
                $status = "status='busy'";
            }
        } else {
            if ($_POST['jobcard_type'] == 'contract') {
                $_POST['plant_id'] = 0;
                $reading = '';
            } else {
                $_POST['site_id'] = 0;
                switch ($_POST['reading_type']) {
                    case "hr":
                        $reading = "hr_reading='{$_POST['reading']}',";
                        break;

                    case "km":
                        $reading = "km_reading='{$_POST['reading']}',";
                        break;
                }
            }

            if (strlen($_POST['jobcard_number']) > 0) {
                $status = "status='open'";
            } else {
                $status = "status='allocated'";
            }
        }

        if ($create_jobcard) {

            if ($_POST['jobcard_type'] == 'service') {
                $job_type = "service_type='{$_POST['service_type']}',";
            } else {
                $job_type = '';
            }

            $add_jobcard = dbq("insert into jobcards set
                                jobcard_number='{$_POST['jobcard_number']}',
                                plant_id={$_POST['plant_id']},
                                site_id={$_POST['site_id']},
                                job_date='{$_POST['job_date']}',
                                logged_by='{$_SESSION['user']['user_id']}',
                                clerk_id={$_POST['clerk_id']},
                                mechanic_id='{$_POST['mechanic_id']}',
                                {$reading}
                                {$job_type}
                                priority={$_POST['priority']},
                                jobcard_type='{$_POST['jobcard_type']}',
                                {$status}
                                ");
            if ($add_jobcard) {
                $job_id = mysqli_insert_id($db);
                msg("Job card logged!");
                if (isset($_GET['defect'])) {
                    $update_ = dbq("update ws_defect_reports set status='J', job_id={$job_id} where id={$_GET['defect']}");
                }
                require_once "./includes/forms/sms.mechanic.allocated.php";
                go('dashboard.php?page=open-job');
            } else {
                sqlError();
            }
        }
    } else {
        error("Fill in all the required fields.");
    }
}

if (isset($_GET['defect'])) {
    $defect_report_ = dbq("select plant_id, site from ws_defect_reports where id={$_GET['defect']}");
    if (!$defect_report_)  go("dashboard.php?page=add-job");

    $defect_report_ = dbf($defect_report_);

    $plant_ = get_plant($defect_report_['plant_id']);
}
