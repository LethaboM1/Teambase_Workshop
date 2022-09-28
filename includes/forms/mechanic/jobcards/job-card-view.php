<?php
if (isset($_GET['id'])) {
    $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']} and mechanic_id={$_SESSION['user']['user_id']}");
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

if (isset($_POST['complete_jobcard'])) {
    if (
        strlen($_POST['reading']) > 0
        && is_numeric($_POST['reading'])
    ) {
        if ($_POST['reading'] >= $plant_[$plant_['reading_type'] . '_reading']) {
            $events = dbr(dbq("select event_id from jobcard_events where job_id={$_GET['id']}"));
            if ($events == 0) {
                error("There were no events for this job card.");
            }

            $requests = dbr(dbq("select request_id from jobcard_requisitions where job_id={$_GET['id']} and (status!='canceled' && status!='completed' && status!='denied')"));
            if ($requests == 0) {
                $update_jobcard = dbq("update jobcards set
                                            status='completed',
                                            complete_datetime='{$_POST['compdate']}'
                                            where job_id={$_GET['id']}
                                            ");
                if ($update_jobcard) {
                    $update_plant = dbq("update plants_tbl set
                                                {$plant_['reading_type']}_reading={$_POST['reading']},
                                                where plant_id={$plant_['plant_id']}");
                    if ($update_plant) {
                    }
                } else {
                    sqlError();
                }
            } else {
                error("There are unresolved part requests for this job card. Management must resolve this request before you can close the job card.");
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

if (isset($_POST['add_part'])) {
    if ($_POST['qty'] > 0) {
        if (
            strlen($_POST['part_number'])
            && strlen($_POST['part_description']) > 0
        ) {
            $add_part_request = dbq("insert into jobcard_requisitions set
                                                datetime='" . $_POST['request_date'] . "',
                                                job_id='{$_GET['id']}',
                                                plant_id='{$plant_['plant_id']}',
                                                requested_by={$_SESSION['user']['user_id']},
                                                requested_by={$_SESSION['user']['user_id']},
                                                requested_by_datetime='" . date("Y-m-d\TH:i:s") . "',
                                                part_number='{$_POST['part_number']}',
                                                part_description='{$_POST['part_description']}',
                                                qty={$_POST['qty']},
                                                comment='{$_POST['comment']}'
                                                ");
            if ($add_part_request) {
                msg("Part request send.");
                go("dashboard.php?page=job-card-view&id={$_GET['id']}");
            } else {
                sqlError('', "date: {$_POST['request_date']}");
            }
        } else {
            error("You must type in a part number and description.");
        }
    } else {
        error("Qty cant be 0");
    }
}

if (isset($_POST['add_event'])) {
    if (strlen($_POST['comment']) > 0) {
        if ($_POST['event'] != '0') {
            $total_hours = calc_hours($_POST['start_date'], $_POST['end_date']);
            if (date_create($_POST['start_date']) && date_create($_POST['end_date'])) {
                $add_event = dbq("insert into jobcard_events set
                                            job_id={$_GET['id']},
                                            start_datetime='{$_POST['start_date']}',
                                            end_datetime='{$_POST['end_date']}',
                                            total_hours={$total_hours},
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
                error('Invalid date/time');
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
        if ($delete_event) {
            msg("event deleted!");
            go("dashboard.php?page=job-card-view&id={$_GET['id']}");
        }
    }
}
