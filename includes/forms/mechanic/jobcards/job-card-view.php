<?php
if (isset($_GET['id'])) {
    $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']} and mechanic_id={$_SESSION['user']['user_id']}");
    if ($get_jobcard) {
        if (dbr($get_jobcard) > 0) {
            $jobcard_ = dbf($get_jobcard);
            if ($jobcard_['jobcard_type'] != 'sundry') {
                if ($jobcard_['jobcard_type'] == 'service') {
                    go('dashboard.php?page=plant-schedule&id=' . $_GET['id']);
                }
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



if (isset($_POST['allocate_clerk'])) {
    if ($_POST['clerk_id'] > 0) {
        $update_jobcard = dbq("update jobcards set clerk_id={$_POST['clerk_id']} where job_id={$_GET['id']}");
        if (mysqli_affected_rows($db) != -1) {
            msg("Clerk has been allocated.");
            $jobcard_['clerk_id'] = $_POST['clerk_id'];
        } else {
            sqlError();
        }
    } else {
        error("You must choose a clerk.");
    }
}

if (isset($_POST['complete_jobcard'])) {
    if (
        strlen($_POST['compdate'] > 0)
        && (strlen($_POST['reading']) > 0 && is_numeric($_POST['reading']) && $jobcard_['jobcard_type'] != 'sundry') || ($jobcard_['jobcard_type'] == 'sundry')
    ) {
        if (($_POST['reading'] >= $plant_[$plant_['reading_type'] . '_reading']) || ($jobcard_['jobcard_type'] == 'sundry')) {
            $events = dbr(dbq("select event_id from jobcard_events where job_id={$_GET['id']}"));
            if ($events == 0) {
                error("There were no events for this job card.");
            }

            $requests = dbr(dbq("select request_id from jobcard_requisitions where job_id={$_GET['id']} and (status!='canceled' && status!='completed' && status!='rejected')"));
            if ($requests == 0) {
                $update_jobcard = dbq("update jobcards set
                                            status='completed',
                                            complete_datetime='{$_POST['compdate']}'
                                            where job_id={$_GET['id']}
                                            ");
                if (mysqli_affected_rows($db) > 0) {
                    if ($jobcard_['jobcard_type'] == 'sundry') {
                        msg("job card completed!");

                        $job_id = $_GET['id'];
                        $mechanic_id = $jobcard_['mechanic_id'];
                        require_once "./includes/forms/mail.manager.job_completed.php";
                        go('dashboard.php?page=open-job');
                    } else {
                        $update_plant = dbq("update plants_tbl set
                                                    {$plant_['reading_type']}_reading={$_POST['reading']}
                                                    where plant_id={$plant_['plant_id']}");
                        if (mysqli_affected_rows($db) != -1) {
                            msg("job card completed!");

                            $job_id = $_GET['id'];
                            $mechanic_id = $jobcard_['mechanic_id'];
                            require_once "./includes/forms/mail.manager.job_completed.php";
                            go('dashboard.php?page=open-job');
                        } else {
                            sqlError();
                        }
                    }
                } else {
                    sqlError();
                }
            } else {
                error("There are unresolved requisition(s) for this job card. Management must resolve this before you can close the job card.");
            }
        } else {
            error("reading must be higher or equal to last reading");
        }
    } else {
        error('Must fill in a reading.');
    }
}

if (isset($_POST['delete_request'])) {
    $get_request = dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}");
    if ($get_request) {
        if (dbr($get_request) > 0) {
            $request_ = dbf($get_request);
            if ($request_['status'] == 'requested') {
                $update_request = dbq("update jobcard_requisitions set 
                                            status='canceled', 
                                            canceled_by_comment='Canceled by mechanic before being approved.',
                                            canceled_by={$_SESSION['user']['user_id']},
                                            canceled_by_time='" . date("Y-m-d\TH:i:s") . "'  
                                            where request_id={$_POST['request_id']}");
                if ($update_request) {
                    msg("Request has been canceled.");
                } else {
                    sqlError();
                }
            } else {
                $person_ = dbf(dbq("select concat(name,' ',last_name) as name from users_tbl where user_id={$request_[$request_['status'] . '_by']}"));
                error("This part request has already neen approved by {$person_['name']}. Contact them to cancel request.");
            }
        } else {
            error("Request not found.");
        }
    } else {
        sqlError();
    }
}

if (isset($_POST['add_insp'])) {
    if (
        strlen($_POST['component']) > 0
        && strlen($_POST['report_comment']) > 0
        && strlen($_POST['severity']) > 0
        && is_numeric($_POST['hours'])
    ) {
        $add_report = dbq("insert into jobcard_reports set
                                job_id={$_GET['id']},
                                component='{$_POST['component']}',
                                severity='{$_POST['severity']}',
                                hours='{$_POST['hours']}',
                                comment='{$_POST['report_comment']}'
                                ");
        if ($add_report) {
            msg("Fault report added.");
            go("dashboard.php?page=job-card-view&id={$_GET['id']}");
        } else {
            sqlError();
        }
    } else {
        error("Fill in all required fields. Must be valid hours.");
    }
}

if (isset($_POST['add_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event_date'] <= date('Y-m-d')) {
            if (($_POST['event'] != '0') || ($jobcard_['jobcard_type'] == 'sundry')) {
                $add_event = dbq("insert into jobcard_events set
                                            job_id={$_GET['id']},
                                            start_datetime='" . $_POST['event_date'] . " 00:00:00',
                                            total_hours={$_POST['total_hours']},
                                            event='{$_POST['event']}',
                                            comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                            ");
                if ($add_event) {
                    unset($_POST);
                    msg("Event added.");
                    go("dashboard.php?page=job-card-view&id={$_GET['id']}");
                } else {
                    sqlError('', '');
                }
            } else {
                error("You must allocate an event type.");
            }
        } else {
            error('Invalid date!');
        }
    } else {
        error("fill in a comment.");
    }
}

if (isset($_POST['save_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event'] != '0' && $_POST['event_id'] > 0) {
            $add_event = dbq("update jobcard_events set
                                            start_datetime='" . $_POST['event_date'] . " 00:00:00',
                                            total_hours={$_POST['total_hours']},
                                            event='{$_POST['event']}',
                                            comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                            where event_id={$_POST['event_id']}
                                            ");
            if ($add_event) {
                unset($_POST);
                msg("Event added.");
                go("dashboard.php?page=job-card-view&id={$_GET['id']}");
            } else {
                sqlError('', '');
            }
        } else {
            error("You must allocate an event type.");
        }
    } else {
        error("fill in a comment.");
    }
}

if (isset($_POST['delete_event'])) {
    if ($_POST['event_id'] > 0) {
        $delete_event = dbq("delete from jobcard_events where event_id={$_POST['event_id']}");
        ($delete_event) ? $msg[] = "Event was deleted!" : $error[] = "Error deleting event.";
    }
}
