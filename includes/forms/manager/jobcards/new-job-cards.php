<?php

if (isset($_POST['allocate_mechanic'])) {
    if (
        $_POST['mechanic'] != '0'
        && strlen($_POST['jobnumber']) > 0
        && $_POST['allocated_hours'] > 0
    ) {
        $get_jobcard = dbq("select job_id, status from jobcards where job_id={$_POST['job_id']}");
        if ($get_jobcard) {
            if (dbr($get_jobcard) > 0) {
                $jobcard_ = dbf($get_jobcard);
                if ($jobcard_['status'] == 'logged') {
                    $get_mechanic = dbq("select user_id, role from users_tbl where user_id={$_POST['mechanic']}");
                    if ($get_mechanic) {
                        if (dbr($get_mechanic) > 0) {
                            $mechanic_ = dbf($get_mechanic);
                            if ($mechanic_['role'] == 'mechanic') {
                                $update_jobcard = dbq("update jobcards set 
                                                            authorized_by={$_SESSION['user']['user_id']},
                                                            jobcard_number='{$_POST['jobnumber']}',
                                                            site='{$_POST['site']}',
                                                            mechanic_id={$_POST['mechanic']},
                                                            allocated_hours={$_POST['allocated_hours']},
                                                            status='open'
                                                            where job_id={$_POST['job_id']}
                                                            ");

                                if (mysqli_affected_rows($db) != -1) {
                                    msg("Mechanic allocated!");
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
