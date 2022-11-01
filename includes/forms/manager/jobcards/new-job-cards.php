<?php

if (isset($_POST['allocate_mechanic'])) {
    if (
        $_POST['mechanic'] != '0'
        && strlen($_POST['jobnumber']) > 0
        && (($_POST['jobcard_type'] != 'sundry' && $_POST['allocated_hours'] > 0) || ($_POST['jobcard_type'] == 'sundry'))
    ) {
        $get_jobcard = dbq("select job_id,jobcard_type, status from jobcards where job_id={$_POST['job_id']}");
        if ($get_jobcard) {
            if (dbr($get_jobcard) > 0) {
                $jobcard_ = dbf($get_jobcard);
                if ($jobcard_['status'] == 'logged') {
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

                                if (!isset($_POST['allocated_hours'])) {
                                    $_POST['allocated_hours'] = 0;
                                }

                                $update_jobcard = dbq("update jobcards set 
                                                            authorized_by={$_SESSION['user']['user_id']},
                                                            jobcard_number='{$_POST['jobnumber']}',
                                                            site='{$_POST['site']}',
                                                            mechanic_id={$_POST['mechanic']},
                                                            allocated_hours={$_POST['allocated_hours']},
                                                            {$status}
                                                            where job_id={$_POST['job_id']}
                                                            ");

                                if (mysqli_affected_rows($db) != -1) {
                                    msg("Mechanic allocated!");
                                    require_once "./includes/forms/sms.mechanic.allocated.php";
                                    go('dashboard.php?page=new-job');
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
    if ($_POST['job_id'] > 0) {
        $update_ = dbq("update jobcards set 
                            status='completed', 
                            complete_comment='Job card was deleted by {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}', 
                            complete_datetime='" . date('Y-m-d H:i') . "'
                            where job_id={$_POST['job_id']}");

        if ($update_) {
            msg("Job card deleted.");
        } else {
            sqlError();
        }
    }
}
