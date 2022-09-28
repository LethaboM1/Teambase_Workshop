<?php

if (isset($_POST['close_jobcard'])) {
    if (isset($_POST['job_id'])) {
        $update_jobcard = dbq("update jobcards set 
                                    status='closed'
                                    where job_id={$_POST['job_id']}");
        if (mysqli_affected_rows($db) != -1) {
            msg("job card closed.");
        } else {
            sqlError();
        }
    }
}
