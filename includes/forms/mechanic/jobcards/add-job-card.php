<?php

if (isset($_POST['request_jobcard'])) {
    if (
        $_POST['clerk_id'] > 0
        && (($_POST['plant_id'] > 0 && $_POST['jobcard_type'] != 'sundry' && strlen($_POST['site']) > 0) || ($_POST['jobcard_type'] == 'sundry'))
    ) {
        $create_jobcard = true;

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


        if ($_POST['jobcard_type'] == 'sundry') {
            $chk_sundry_jobcard = dbq("select * from jobcards where status='open' and jobcard_type='sundry' and mechanic_id={$_SESSION['user']['user_id']}");
            if (dbr($chk_sundry_jobcard) > 0) {
                error("There is an open sundry job card for you. Close the job card before you can create a new one.");
                $create_jobcard = false;
            } else {
                $_POST['plant_id'] = 0;
                $_POST['priority'] = 9999;
                $_POST['allocated_hours'] = 0;
                $query = "status='allocated',allocated_hours=0,";
            }
        } else {
            $query = "{$_POST['reading_type']}_reading={$_POST['reading']},";
        }

        if ($create_jobcard) {
            $add_jobcard = dbq("insert into jobcards set
                                    plant_id={$_POST['plant_id']},
                                    job_date='" . date('Y-m-d') . "',
                                    clerk_id={$_POST['clerk_id']},
                                    mechanic_id={$_SESSION['user']['user_id']},
                                    logged_by='{$_SESSION['user']['user_id']}',
                                    fault_description='" . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                    safety_audit='{$safety_stuff}',
                                    {$query}
                                    jobcard_type='{$_POST['jobcard_type']}',
                                    priority='{$_POST['priority']}'
                                    ");
            if ($add_jobcard) {
                msg("Job card added.");
                require_once "./includes/forms/mail.clerk.new_job.php";
                go('dashboard.php');
            } else {
                sqlError('Adding job card', 'adding job card');
            }
        }
    } else {
        error("You must choose a plant. Site is required field.");
    }
}
