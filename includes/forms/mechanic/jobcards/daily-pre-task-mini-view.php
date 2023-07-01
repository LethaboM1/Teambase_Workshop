<?php
if (isset($_GET['jobid'])) {
    if ($_SESSION['user']['role'] == 'mechanic') {
        $get_jobcard = dbq("select * from jobcards where job_id={$_GET['jobid']} and mechanic_id={$_SESSION['user']['user_id']}");
    } else {
        $get_jobcard = dbq("select * from jobcards where job_id={$_GET['jobid']}");
    }

    if ($get_jobcard) {
        if (dbr($get_jobcard) > 0) {
            $jobcard_ = dbf($get_jobcard);
            if ($jobcard_['jobcard_type'] == 'contract') {
                $site_ = get_site($jobcard_['site_id']);
                if (!$site_) {
                    go('dashboard.php?page=open-job');
                }
            } else {
                $get_plant = dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}");
                if ($get_plant) {
                    if (dbr($get_plant)) {
                        $plant_ = dbf($get_plant);
                    } else {
                        error("invalid plant.");
                        go('dashboard.php?page=open-job');
                    }
                } else {
                    sqlError();
                    go('dashboard.php?page=open-job');
                }
            }
        } else {
            error("invalid job card.");
            go('dashboard.php?page=open-job');
        }
    } else {
        sqlError();
        go('dashboard.php?page=open-job');
    }
} else {
    go('dashboard.php?page=open-job');
}

$get_assessment = dbq("select * from jobcard_risk_assessments where id={$_GET['id']} and job_id={$_GET['jobid']}");
if ($get_assessment) {
    if (dbr($get_assessment) > 0) {
        $assessment_ = dbf($get_assessment);
    } else {
        go('dashboard.php');
    }
} else {
    go('dashboard.php');
}
