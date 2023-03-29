<?php

if (isset($_POST['request_jobcard'])) {
    if (
        $_POST['clerk_id'] != '0'
    ) {
        $get_jobcard = dbq("select job_id,jobcard_type, status from jobcards where job_id={$_POST['job_id']}");
        if ($get_jobcard) {
            if (dbr($get_jobcard) > 0) {
                $jobcard_ = dbf($get_jobcard);
                if ($jobcard_['status'] == 'defect-approved') {
                    $update_jobcard = dbq("update jobcards set                                                             
                                                clerk_id={$_POST['clerk_id']},
                                                jobcard_type='breakdown',
                                                status='logged'
                                                where job_id={$_POST['job_id']}
                                                ");

                    if (mysqli_affected_rows($db) != -1) {
                        msg("Job card requested!");
                        unset($_POST);
                        go('dashboard.php?page=new-defects');
                    } else {
                        sqlError('', 'Code:1');
                    }
                } else {
                    error("wrong status.");
                }
            } else {
                error("No jc. {$_POST['job_id']}");
            }
        } else {
            sqlError('', 'Code:3');
        }
    } else {
        error("Allocate hours, clerk and mechanic.");
    }
}

if (isset($_POST['delete_jobcard'])) {
    if ($jobcard_ = get_jobcard($_POST['job_id'])) {
        $update_ = dbq("update jobcards set 
                            status='completed', 
                            complete_comment='Defect Report was deleted by {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}', 
                            complete_datetime='" . date('Y-m-d H:i') . "'
                            where job_id={$_POST['job_id']}");

        if ($update_) {
            msg("Job card deleted.");
        } else {
            sqlError();
        }
    }
}
