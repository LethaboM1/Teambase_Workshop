<?php
if (isset($_POST['reviewed'])) {
    if ($_POST['job_id'] > 0) {
        $update_ = dbq("update jobcard_reports set reviewed=1 where job_id={$_POST['job_id']} and reviewed=0");
        if ($update_) {
            $hours = dbf(dbq("select sum(hours) as hours from jobcard_reports where job_id={$_POST['job_id']} and reviewed=1"));

            if (!is_numeric($hours['hours'])) {
                $hours['hours'] = 0;
            }

            $update_ = dbq("update jobcards set allocated_hours={$hours['hours']} where job_id={$_POST['job_id']}");
            if (!$update_) {
                sqlError();
                error_log("SQL Error: " . dbe());
            } else {
                msg("Job card defects have been reviewed.");
            }
        } else {
            sqlError();
        }
    }
}
