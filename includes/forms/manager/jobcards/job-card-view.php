<?php

if (isset($_GET['id'])) {
    $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']}");
    if ($get_jobcard) {
        if (dbr($get_jobcard) > 0) {
            $jobcard_ = dbf($get_jobcard);
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

if (isset($_POST['allocate_hours'])) {
    if ($_POST['allocated_hours'] > 0) {
        $update_jobcard = dbq("update jobcards set allocated_hours={$_POST['allocated_hours']} where job_id={$_GET['id']}");
        if (mysqli_affected_rows($db) != -1) {
            msg("Allocated hours has been saved.");
            $jobcard_['allocated_hours'] = $_POST['allocated_hours'];
        } else {
            sqlError();
        }
    } else {
        error("You must more than 0 hours.");
    }
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

if (isset($_POST['delete_event'])) {
    if ($_POST['event_id'] > 0) {
        $delete_event = dbq("delete from jobcard_events where event_id={$_POST['event_id']}");
        if ($delete_event) {
            msg("event deleted!");
            go("dashboard.php?page=job-card-view&id={$_GET['id']}");
        }
    }
}


if (isset($_POST['add_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event'] != '0') {
            $add_event = dbq("insert into jobcard_events set
                                            job_id={$_GET['id']},
                                            start_datetime='" . date('Y-m-d H:i') . "',
                                            total_hours={$_POST['total_hours']},
                                            event='{$_POST['event']}',
                                            comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                            ");
            if ($add_event) {
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


if (isset($_POST['save_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event'] != '0' && $_POST['event_id'] > 0) {
            $add_event = dbq("update jobcard_events set                                            
                                            total_hours={$_POST['total_hours']},
                                            event='{$_POST['event']}',
                                            comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                            where event_id={$_POST['event_id']}
                                            ");
            if ($add_event) {
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
