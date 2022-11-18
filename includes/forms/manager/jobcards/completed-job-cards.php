<?php

if (isset($_POST['close_jobcard'])) {
    if (isset($_POST['job_id'])) {
        $update_jobcard = dbq("update jobcards set 
                                    status='closed',
                                    complete_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                    where job_id={$_POST['job_id']}");
        if ($update_jobcard) {
            $jobcard_ = dbf(dbq("select * from jobcards where job_id={$_POST['job_id']}"));
            $mechanic_ = dbf(dbq("select * from users_tbl where user_id={$jobcard_['mechanic_id']}"));
            $message = "Job Card {$jobcard_['jobcard_number']} has been closed by {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}. {$_POST['comment']}";

            if (!$testserver) {
                sms_($mechanic_['contact_number'], $message);
            }

            msg("job card closed.");
        } else {
            sqlError();
        }
    }
}

if (isset($_POST['reopen_jobcard'])) {
    if (isset($_POST['job_id'])) {
        $update_jobcard = dbq("update jobcards set 
                                    status='busy',
                                    complete_comment='" . htmlentities($_POST['comment']) . "'
                                    where job_id={$_POST['job_id']}");
        if ($update_jobcard) {
            $jobcard_ = dbf(dbq("select jobcard_number, mechanic_id from jobcards where job_id={$_POST['job_id']}"));
            $mechanic_ = dbf(dbq("select contact_number from users_tbl where user_id={$jobcard_['mechanic_id']}"));
            $message = "Job Card {$jobcard_['jobcard_number']} has been re-opened by {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}. {$_POST['comment']}";

            if (!$testserver) {
                sms_($mechanic_['contact_number'], $message);
            }

            msg("job card re-opened.");
        } else {
            sqlError();
        }
    }
}
