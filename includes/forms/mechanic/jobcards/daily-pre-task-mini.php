<?php

if (isset($_POST['add_job_checklist'])) {
    if ($_POST['agree_to_statements'] == 'agree') {
        $check_list = dbq("select * from job_checklist order by item_order");
        if ($check_list) {
            while ($row = dbf($check_list)) {
                if (!isset($_POST['q_' . $row['checklist_id']])) {
                    if (!is_error()) {
                        error("You must answer all the questions.");
                    }
                } else {
                    $job_check_list[] = [
                        'job_id' => $_GET['id'],
                        'question' => $row['question'],
                        'answer' => $_POST['q_' . $row['checklist_id']],
                        'comment' => $_POST['comment_' . $row['checklist_id']]
                    ];
                }
            }
        } else {
            sqlError();
        }

        if (!is_error()) {
            if (isset($job_check_list)) {
                $job_check_list = json_encode($job_check_list);
                $update_jobcard = dbq("update jobcards set
                                            status='busy',
                                            risk_assessment='" . esc($job_check_list) . "'
                                            where job_id={$_GET['id']}");
                if ($update_jobcard) {
                    msg("Job assessment done.");
                } else {
                    sqlError();
                }
            }
        }
    } else {
        error("You must agree to the statements to continue.");
    }
}
