<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['add_jobcard'])) {
    if (
        strlen($_POST['jobcard_number']) > 0
        && $_POST['clerk_id'] > 0
        && $_POST['mechanic_id'] != '0'
        && (($_POST['plant_id'] > 0 && $_POST['jobcard_type'] != 'sundry' &&  $_POST['allocated_hours'] > 0 && strlen($_POST['site']) > 0) || ($_POST['jobcard_type'] == 'sundry'))

    ) {
        $create_jobcard = true;

        if ($_POST['jobcard_type'] == 'sundry') {
            $chk_sundry_jobcard = dbq("select * from jobcards where status='open' and jobcard_type='sundry' and mechanic_id={$_POST['mechanic_id']}");
            if (dbr($chk_sundry_jobcard) > 0) {
                error("There is an open sundry job card for this mechanic.");
                $create_jobcard = false;
            } else {
                $_POST['plant_id'] = 0;
                $_POST['priority'] = 9999;
                $_POST['allocated_hours'] = 0;
                $reading = "";
                $status = "status='busy'";
            }
        } else {
            switch ($_POST['reading_type']) {
                case "hr":
                    $reading = "hr_reading='{$_POST['reading']}',";
                    break;

                case "km":
                    $reading = "km_reading='{$_POST['reading']}',";
                    break;
            }
            $status = "status='open'";
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
                                job_date='{$_POST['job_date']}',
                                logged_by='{$_SESSION['user']['user_id']}',
                                clerk_id={$_POST['clerk_id']},
                                mechanic_id='{$_POST['mechanic_id']}',
                                {$reading}
                                {$job_type}
                                allocated_hours={$_POST['allocated_hours']},
                                priority={$_POST['priority']},
                                jobcard_type='{$_POST['jobcard_type']}',
                                {$status}
                                ");
            if ($add_jobcard) {
                msg("Job card logged!");
                require_once "./includes/forms/sms.mechanic.allocated.php";
                go('dashboard.php?page=open-job');
            } else {
                sqlError();
            }
        }
    } else {
        error("Fill in all the required fields. Really");
    }
}
