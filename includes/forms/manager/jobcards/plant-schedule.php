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


if (isset($_POST['complete_service'])) {
    if (isset($_POST['service_checklist'])) {
        $checklist = json_decode(base64_decode($_POST['service_checklist']), true);
        $get_service_checklist = dbq("select * from service_checklist");
        if ($get_service_checklist) {
            if (dbr($get_service_checklist) > 0) {
                $service_type = strtolower($_POST['service_type']) . '_service';
                while ($item = dbf($get_service_checklist)) {
                    if ($item[$service_type] == "0" || $item[$service_type] == "C") {
                        if ($checklist[$item['checklist_id']]['answer'] == '') {
                            error("Required service item: {$item['question']}, has not been done");
                        }
                    }
                }
            }
        } else {
            sqlError();
        }

        if (!is_error()) {
            $requests = dbr(dbq("select request_id from jobcard_requisitions where job_id={$_GET['id']} and (status!='canceled' && status!='completed' && status!='rejected')"));
            if ($requests == 0) {
                if ($_POST['next_service_reading'] > 0) {
                    $update_jobcard = dbq("update jobcards set
                                            status='completed',
                                            complete_datetime='{$_POST['compdate']}'
                                            where job_id={$_GET['id']}
                                            ");
                    if ($update_jobcard) {
                        msg("service completed.");
                        $update_plant = dbq("update plants_tbl set
                                                next_service_reading={$_POST['next_service_reading']}
                                                where plant_id={$plant_['plant_id']}
                                                ");
                        if ($update_plant) {
                            msg("Updated next service reading.");
                        } else {
                            sqlError();
                        }
                        go('dashboard.php?page=open-job');
                    } else {
                        sqlError();
                    }
                } else {
                    error("Invalid reading.");
                }
            } else {
                error("There are unresolved part requests for this job card. Management must resolve this request before you can close the job card.");
            }
        }
    }
}

if (isset($_POST['save_progress'])) {
    $get_service_checklist = dbq("select * from service_checklist");
    if ($get_service_checklist) {
        if (dbr($get_service_checklist) > 0) {
            $service_type = strtolower($_POST['service_type']) . '_service';
            while ($item = dbf($get_service_checklist)) {
                if ($item[$service_type] == "0" || $item[$service_type] == "C") {
                    $answer = $_POST['check_' . $item['checklist_id']];
                    $service_checklist[$item['checklist_id']] = ['question' => $item['question'], 'answer' => $answer];
                }
            }
        } else {
            error("There is no service check list.");
        }
    } else {
        sqlError();
    }

    if (isset($service_checklist)) {
        //error("<pre>" . print_r($service_checklist, true) . "</pre>");
        $service_checklist = base64_encode(json_encode($service_checklist));
        if ($_POST['job_id'] > 0) {
            $save_propgress = dbq("update jobcards set
                                        service_checklist='{$service_checklist}'
                                        where job_id={$_POST['job_id']}");
            if ($save_propgress) {
                msg("Service check list saved.");
                $jobcard_['service_checklist'] = $service_checklist;
            } else {
                sqlError();
            }
        } else {
        }
    } else {
        error("There are no items in service checklist table.");
    }
}


if (isset($_POST['delete_request'])) {
    $scroll_to = 'sr_section';
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


if (isset($_POST['add_event'])) {
    $_SESSION['scroll_to'] = 'evt_section';
    if (strlen($_POST['comment']) > 0) {
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
                go("dashboard.php?page=plant-schedule&id={$_GET['id']}");
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

    $_SESSION['scroll_to'] = 'evt_section';

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
                go("dashboard.php?page=plant-schedule&id={$_GET['id']}");
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
