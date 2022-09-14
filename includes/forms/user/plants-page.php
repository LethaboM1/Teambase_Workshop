<?php

if (isset($_POST['submit_checklist'])) {
    /* Preset Status to 'G' = Good */
    $status = 'G';

    if ($_POST['submit_checklist'] > 0) {
        $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$_POST['submit_checklist']}"));

        /* Check if KM HR reading is correct */
        if (check_reading($_POST['submit_checklist'], $_POST['reading'])) {
            if (!is_error()) {
                $get_checklist = dbq("select * from plant_checklist order by item_order");
                if ($get_checklist) {
                    if (dbr($get_checklist) > 1) {
                        $json_checklist = [];
                        while ($checkitem = dbf($get_checklist)) {
                            if (isset($_POST[$checkitem['checklist_id']])) {
                                $json_checklist[] = ['Question' => $checkitem['check_item'], 'Result' => $_POST[$checkitem['checklist_id']]];
                                if ($_POST[$checkitem['checklist_id']] == 'no') {
                                    $faulty = true;
                                    switch ($checkitem['severity']) {
                                        case "H":
                                            $status = 'H';
                                            break;

                                        case "M":
                                            if ($status != 'H') {
                                                $status = 'M';
                                            }
                                            break;

                                        case "L":
                                            if ($status != 'H' && $status != 'M') {
                                                $status = 'L';
                                            }
                                            break;
                                    }
                                }
                            } else {
                                if (!isset($_SESSION['error'])) {
                                    error("Not all questions on the check list were answered.");
                                }
                            }
                        }
                    }
                } else {
                    sqlError();
                }

                /* check if checklist already exists */
                $chk_checklist = dbq("select * from checklist_results where datetime>'" . date('Y-m-d 00:00') . "' and user_id={$_SESSION['user']['user_id']} and plant_id={$_SESSION['user']['user_id']}");
                if ($chk_checklist) {
                    if (dbr($chk_checklist) > 0) {
                        error('There is a check list for this plant already.');
                    }
                } else {
                    sqlError();
                }
            }




            if (!is_error()) {

                $results = json_encode($json_checklist);

                if ($fault) {
                    switch ($status) {
                        case "L":
                            $priority = 3;
                            break;

                        case "M":
                            $priority = 2;
                            break;

                        case "H":
                            $priority = 1;
                            break;
                    }

                    /* Log Job card */
                    switch ($_POST['reading_type']) {
                        case "hr":
                            $reading = "hr_reading='{$_POST['reading']}',";
                            break;

                        case "km":
                            $reading = "km_reading='{$_POST['reading']}',";
                            break;
                    }

                    $add_jobcard = dbq("insert into jobcards set
                                            plant_id={$_POST['submit_checklist']},
                                            job_date='" . date('Y-m-d') . "',
                                            logged_by='{$_SESSION['user']['user_id']}',
                                            {$reading}
                                            priority='{$priority}'
                                            ");

                    if ($add_jobcard) {
                        msg("Job card created.");
                    } else {
                        sqlError();
                    }
                    /* Make plant status faulty if High */
                    if ($status == 'H') {
                        $update_plant = dbq("update plants_tbl set
                                                operator_id=0,
                                                status='faulty'
                                                where plant_id={$_POST['submit_checklist']}
                                                ");
                        if ($update_plant) {
                            msg("Plant is made faulty.");
                        } else {
                            sqlError();
                        }
                    }
                } else {
                    $status = 'Good';
                    $allocate_plant = dbq("update plants_tbl set 
                                                operator_id={$_SESSION['user']['user_id']},
                                                status='check'
                                                where plant_id={$_POST['submit_checklist']}");
                    if (mysqli_affected_rows($db) != -1) {
                        msg("Plant has been allocated to you.");
                    } else {
                        sqlError('', 'UpdatePlant:');
                    }
                }

                if (!is_error()) {
                    $save_checklist = dbq("insert into checklist_results set
                                                start_datetime='" . date('Y-m-d H:i:s') . "',
                                                user_id={$_SESSION['user']['user_id']},
                                                plant_id={$_POST['submit_checklist']},
                                                results='{$results}',
                                                comments='" . htmlentities($_POST['comments'], ENT_QUOTES) . "',
                                                reading_type='{$_POST['reading_type']}',
                                                start_reading='{$_POST['reading']}',
                                                status='{$status}'
                                                ");
                    if ($save_checklist) {
                        msg("Check list saved.");
                    } else {
                        sqlError();
                    }
                }
                go("dashboard.php?page=plants");
            }
        }
    }
}

if (isset($_POST['start_breakdown'])) {
    if (date_create($_POST['fromtime'])) {
        /* Log Job card */
        switch ($_POST['reading_type']) {
            case "hr":
                $reading = "hr_reading='{$_POST['reading']}',";
                break;

            case "km":
                $reading = "km_reading='{$_POST['reading']}',";
                break;
        }
        $add_jobcard = dbq("insert into jobcards set
                                plant_id={$_POST['submit_checklist']},
                                job_date='" . date('Y-m-d') . "',
                                logged_by='{$_SESSION['user']['user_id']}',
                                log_id={$_POST['log_id']},
                                {$reading}
                                priority=1
                                ");
        if ($add_jobcard) {
            $job_id = mysqli_insert_id($db);
            $update_log = dbq("update operator_log set
                                    breakdown_start='{$_POST['fromtime']}',
                                    breakdown_start_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                    where log_id={$_POST['log_id']}");
            if ($update_log) {
                $update_plant = dbq("update plants_tbl set
                                            {$_POST['reading_type']}_reading={$_POST['reading']},
                                            operator_id=0,
                                            status='breakdown'
                                            where plant_id={$_POST['plant_id']}
                                            ");
                if ($update_plant) {
                    msg("Breakdown started, Job ref: {$job_id}.");
                } else {
                    sqlError();
                }
            } else {
                sqlError();
            }
        } else {
            sqlError('Error adding job card', 'Error adding job card.');
        }
    } else {
        error("Invalid date/time.");
    }
}

if (isset($_POST['end_log'])) {
    if (isset($_POST['log_id'])) {
        $get_log = dbq("select * from operator_log where log_id={$_POST['log_id']}");
        if ($get_log) {
            if (dbr($get_log) > 0) {
                $log_ = dbf($get_log);
                if ($log_['status'] == 'S') {
                    if ($log_['operator_id'] == $_SESSION['user']['user_id']) {
                        $end_datetime = "{$_POST['enddate']} {$_POST['endtime']}";
                        if ($log_['start_datetime'] < $end_datetime) {
                            $hr_reading = get_hours($log_['start_datetime'],  $end_datetime);

                            if ($log_['start_reading'] <= $_POST['reading']) {
                                $update_ = dbq("update operator_log set
                                                    end_datetime='{$end_datetime}',
                                                    end_reading={$_POST['reading']},
                                                    hr_reading={$hr_reading},
                                                    status='E'
                                                    where log_id={$log_['log_id']}
                                                    ");
                                if (mysqli_affected_rows($db) != -1) {
                                    if (upload_images('operator_log_end', $log_['operator_id'], $log_['plant_id'], $_SESSION['upload_images'], $log_key)) {
                                        $last_log = mysqli_insert_id($db);
                                        $query = "update plants_tbl set
                                                        hr_reading=hr_reading+{$hr_reading},
                                                        km_reading={$_POST['reading']},
                                                        operator_id=0,
                                                        status='ready'
                                                        where plant_id={$log_['plant_id']}
                                                        ";
                                        $update_plant = dbq($query);
                                        if (mysqli_affected_rows($db) != -1) {
                                            msg("Operator log submitted.");
                                        } else {
                                            sqlError('Update plants_tbl', 'Update plants_tbl: ' . htmlentities($query, ENT_QUOTES));
                                        }
                                    }
                                } else {
                                    sqlError('Operator log', 'Operator log');
                                }
                            } else {
                                error("Invalid reading");
                            }
                        } else {
                            error("Invalid date/time.");
                        }
                    } else {
                        error("Invalid log.");
                    }
                } else {
                    error("Invalid status.");
                }
            } else {
                error("No log found.");
            }
        } else {
            sqlError('Get log id.', 'Get log id.');
        }
    } else {
        error("No log id.");
    }
}

if (isset($_POST['add_log'])) {
    if (isset($_SESSION['upload_images']) && count($_SESSION['upload_images']) > 0) {
        $get_plant = dbq("select * from plants_tbl where plant_id={$_POST['plant_id']}");
        if ($get_plant) {
            if (dbr($get_plant) == 1) {
                $plant_ = dbf($get_plant);
                if ($plant_['operator_id'] == $_SESSION['user']['user_id']) {
                    if ($plant_['status'] == 'check') {
                        $insert_log = dbq("insert into operator_log set
                                                    start_datetime='" . esc($_POST['date']) . " " . esc($_POST['starttime']) . "',
                                                    operator_id={$plant_['operator_id']},
                                                    plant_id={$plant_['plant_id']},
                                                    company_number='{$_POST['company']}',
                                                    site_number='{$_POST['sitenumber']}',
                                                    reading_type='{$_POST['reading_type']}',
                                                    start_reading='{$_POST['reading']}',
                                                    fuel_issued='{$_POST['fuel']}'
                                                    ");
                        if ($insert_log) {
                            $log_key = mysqli_insert_id($db);
                            if (upload_images('operator_log_start', $plant_['operator_id'], $plant_['plant_id'], $_SESSION['upload_images'], $log_key)) {
                                $last_log = mysqli_insert_id($db);
                                $update_plant = dbq("update plants_tbl set
                                                        " . esc($_POST['reading_type']) . "_reading='{$_POST['reading']}',
                                                        operator_datetime='" . esc($_POST['date']) . " " . esc($_POST['starttime']) . "',
                                                        status='busy'
                                                        where plant_id={$plant_['plant_id']}
                                                        ");
                                if (mysqli_affected_rows($db) != -1) {
                                    msg("Operator log submitted.");
                                } else {
                                    sqlError();
                                }
                            }
                        } else {
                            sqlError();
                        }
                    } else {
                        error("Plant status violation.");
                    }
                } else {
                    error("Access violation.");
                    go('logout.php');
                }
            } else {
                error("Could not find plant: {$_POST['plant_id']}");
                go('logout.php');
            }
        } else {
            sqlError();
        }
    } else {
        error("You must take photo of your reading.");
    }
}
