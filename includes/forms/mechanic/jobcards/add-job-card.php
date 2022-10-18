<?php

if (isset($_POST['request_jobcard'])) {
    if (
        strlen($_POST['plant_id']) > 0
        && strlen($_POST['site']) > 0
        && $_POST['clerk_id'] > 0
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
                                    fault_description='" . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                    safety_audit='{$safety_stuff}',
                                    {$_POST['reading_type']}_reading={$_POST['reading']},
                                    priority='{$_POST['priority']}'
                                    ");
        if ($add_jobcard) {
            msg("Job card added.");
            require_once "../../mail.clerk.new_job.php";
            go('dashboard.php');
        } else {
            sqlError('Adding job card', 'adding job card');
        }
    } else {
        error("You must choose a plant. Site is required field.");
    }
}
