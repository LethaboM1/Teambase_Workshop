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


if (isset($_POST['complete_service'])) {
    if (isset($_POST['service_checklist'])) {
        $checklist = json_decode(base64_decode($_POST['service_checklist']), true);
        $get_service_checklist = dbq("select * from service_checklist");
        if ($get_service_checklist) {
            if (dbr($get_service_checklist) > 0) {
                $service_type = strtolower($_POST['service_type']) . '_service';
                while ($item = dbf($get_service_checklist)) {
                    if ($item[$service_type] == "0" || $item[$service_type] == "C") {
                        if ($checklist[$item['checklist_id']]['answer'] !== 'Yes') {
                            error("Required service item: {$item['question']}, has not been done");
                        }
                    }
                }
            }
        } else {
            sqlError();
        }

        if (!is_error()) {
            $requests = dbr(dbq("select request_id from jobcard_requisitions where job_id={$_GET['id']} and (status!='canceled' && status!='completed' && status!='denied')"));
            if ($requests == 0) {
                $update_jobcard = dbq("update jobcards set
                                            status='completed',
                                            complete_datetime='{$_POST['compdate']}'
                                            where job_id={$_GET['id']}
                                            ");
                if ($update_jobcard) {
                    msg("service completed.");
                    go('dashboard.php?page=open-job');
                } else {
                    sqlError();
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
                    if ($_POST['check_' . $item['checklist_id']] == 'Yes') {
                        $answer = 'Yes';
                    } else {
                        $answer = 'No';
                    }

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
        error("There are no items in service checlist table.");
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
                                                part_number='{$_POST['part_number']}',
                                                part_description='{$_POST['part_description']}',
                                                qty={$_POST['qty']},
                                                comment='{$_POST['comment']}'
                                                ");
            if ($add_part_request) {
                msg("Part request send.");
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

if (isset($_POST['save_progress'])) {
}
