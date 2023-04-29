<?php

if (isset($_POST['submit'])) {
    if (
        $_POST['clerk_id'] > 0
        && $_POST['plant_id'] > 0
        && is_numeric($_POST['reading'])
        && strlen($_POST['reading_type']) > 0
    ) {

        $get_safety_equipment = dbq("select * from safety_equipment");
        if ($get_safety_equipment) {
            if (dbr($get_safety_equipment) > 0) {
                while ($equipment = dbf($get_safety_equipment)) {
                    if ($_POST[$equipment['code']] == 'on') {
                        $answer = 'Yes';
                    } else {
                        $answer = 'No';
                    }

                    $safety_stuff[] = [
                        'name' => $equipment['name'],
                        'answer' => $answer
                    ];
                }
            }
        }

        if (isset($safety_stuff)) {
            $safety_stuff = base64_encode(json_encode($safety_stuff));
        } else {
            $safety_stuff = '';
        }


        $add_jobcard = dbq("insert into jobcards set
                                    plant_id={$_POST['plant_id']},
                                    job_date='" . date('Y-m-d') . "',
                                    clerk_id={$_POST['clerk_id']},
                                    mechanic_id={$_SESSION['user']['user_id']},
                                    logged_by='{$_SESSION['user']['user_id']}',
                                    site='" . esc($_POST['site']) . "',
                                    fault_description='" . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                    safety_audit='{$safety_stuff}',
                                    {$_POST['reading_type']}_reading={$_POST['reading']},
                                    jobcard_type='{$_POST['jobcard_type']}',
                                    status='defect-logged'
                                    ");
        if ($add_jobcard) {
            $job_id = mysqli_insert_id($db);

            if (is_array($_SESSION['fault_reports'])) {
                if (count($_SESSION['fault_reports']) > 0) {
                    foreach ($_SESSION['fault_reports'] as $report) {
                        $insert_report = dbq("insert into jobcard_reports set
                                                    job_id={$job_id},
                                                    component='{$report['component']}',
                                                    severity='{$report['severity']}',
                                                    hours='0',
                                                    comment='" . htmlentities($report['comment']) . "'
                                                    ");
                        if (!$insert_report) {
                            error_log("Error adding report: job={$job_id}:" . dbe());
                        }
                    }
                    unset($_SESSION['fault_reports']);
                }
            }

            if ($_POST['plant_id'] > 0) update_plant_status($_POST['plant_id'], $_POST['jobcard_type'], "");

            msg("Job card added.");
            require_once "./includes/forms/mail.clerk.new_job.php";
            $_SESSION['scroll_to'] = 'evt_reps_section';
            go('dashboard.php');
        } else {
            sqlError('Adding job card', 'adding job card');
        }
    } else {
        error("Required filed missing: Plant, Site and clerk");
    }
}
