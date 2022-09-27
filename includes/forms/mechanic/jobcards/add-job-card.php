<?php

if (isset($_POST['request_jobcard'])) {
    if (
        strlen($_POST['plant_id']) > 0
        && strlen($_POST['site']) > 0
    ) {
        $add_jobcard = dbq("insert into jobcards set
                                    plant_id={$_POST['plant_id']},
                                    job_date='" . date('Y-m-d') . "',
                                    logged_by='{$_SESSION['user']['user_id']}',
                                    fault_description='" . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                    {$_POST['reading_type']}_reading={$_POST['reading']},
                                    priority='{$_POST['priority']}'
                                    ");
        if ($add_jobcard) {
            msg("Job card added.");
        } else {
            sqlError('Adding job card', 'adding job card');
        }
    } else {
        error("You must choose a plant. Site is required field.");
    }
}
