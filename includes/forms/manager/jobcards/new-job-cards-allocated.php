<?php

if (isset($_POST['allocate_jobcard'])) {
    if (
        strlen($_POST['jobnumber']) > 0
    ) {
        $get_jobcard = dbq("select job_id,jobcard_type, status from jobcards where job_id={$_POST['job_id']}");
        if ($get_jobcard) {
            if (dbr($get_jobcard) > 0) {
                $jobcard_ = dbf($get_jobcard);
                if ($jobcard_['status'] == 'allocated') {
                    $get_mechanic = dbq("select user_id, role from users_tbl where user_id={$_POST['mechanic']}");
                    if ($get_mechanic) {
                        if (dbr($get_mechanic) > 0) {
                            $mechanic_ = dbf($get_mechanic);
                            if ($mechanic_['role'] == 'mechanic') {
                                if ($jobcard_['jobcard_type'] == 'sundry') {
                                    $status = "status='busy'";
                                } else {
                                    $status = "status='open'";
                                }

                                $update_jobcard = dbq("update jobcards set 
                                                            authorized_by={$_SESSION['user']['user_id']},
                                                            jobcard_number='{$_POST['jobnumber']}',
                                                            site='{$_POST['site']}',
                                                            mechanic_id={$_POST['mechanic']},
                                                            {$status}
                                                            where job_id={$_POST['job_id']}
                                                            ");

                                if (mysqli_affected_rows($db) != -1) {
                                    msg("Mechanic allocated!");
                                    require_once "./includes/forms/sms.mechanic.allocated.php";
                                    go('dashboard.php?page=new-job-allocate');
                                } else {
                                    sqlError();
                                }
                            } else {
                                error("wrong role.");
                            }
                        } else {
                            error("No Mech.");
                        }
                    } else {
                        sqlError();
                    }
                } else {
                    error("wrong status.");
                }
            } else {
                error("No jc. {$_POST['job_id']}");
            }
        } else {
            sqlError();
        }
    } else {
        error("Type in the job card number and choose a mechanic.");
    }
}

if (isset($_POST['delete_jobcard'])) {
    if ($jobcard_ = get_jobcard($_POST['job_id'])) {
        $update_ = dbq("update jobcards set 
                            status='completed', 
                            complete_comment='Job card was deleted by {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}', 
                            complete_datetime='" . date('Y-m-d H:i') . "'
                            where job_id={$_POST['job_id']}");

        if ($update_) {
            if (update_plant_status($jobcard_['plant_id'], 'ready')) {
                msg("Job card deleted.");
            }
        } else {
            sqlError();
        }
    }
}
