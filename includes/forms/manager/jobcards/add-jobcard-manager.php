<?php

if (isset($_POST['add_jobcard'])) {
    if (
        strlen($_POST['jobcard_number']) > 0
        && strlen($_POST['site']) > 0
        && $_POST['mechanic_id'] != '0'
        && $_POST['allocated_hours'] > 0
    ) {
        switch ($_POST['reading_type']) {
            case "hr":
                $reading = "hr_reading='{$_POST['reading']}',";
                break;

            case "km":
                $reading = "km_reading='{$_POST['reading']}',";
                break;
        }

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
                                mechanic_id='{$_POST['mechanic_id']}',
                                {$reading}
                                {$job_type}
                                allocated_hours={$_POST['allocated_hours']},
                                priority={$_POST['priority']},
                                jobcard_type='{$_POST['jobcard_type']}',
                                status='open'
                                ");
        if ($add_jobcard) {
            msg("Job card logged!");
            go('dashboard.php');
        } else {
            sqlError();
        }
    } else {
        error("Fill in all the required fields.");
    }
}
