<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (isset($_POST['request_jobcard'])) {
    $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$_POST['plant_id']}"));

    if ($plant_['status'] == 'ready') {
        /* Log Job card */
        switch ($_POST['reading_type']) {
            case "hr":
                $reading = "hr_reading='{$_POST['reading']}',";
                break;

            case "km":
                $reading = "km_reading='{$_POST['reading']}',";
                break;
        }

        $get_safety_equipment = dbq("select * from safety_equipment");
        if ($get_safety_equipment) {
            if (dbr($get_safety_equipment) > 0) {
                while ($equipment = dbf($get_safety_equipment)) {
                    if ($_POST[$equipment['code']] == 'on') {
                        $answer = 'Yes';
                    } else {
                        $answer = 'No';
                    }

                    $safety_stuff[] = [
                        'name' => $equipment['name'],
                        'answer' => $answer
                    ];
                }
            }
        }

        if (isset($safety_stuff)) {
            $safety_stuff = base64_encode(json_encode($safety_stuff));
        } else {
            $safety_stuff = '';
        }

        $add_jobcard = dbq("insert into jobcards set
                                plant_id={$_POST['plant_id']},
                                job_date='" . date('Y-m-d') . "',
                                fault_description='" . $_POST['fault_area'] . " - " . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                logged_by='{$_SESSION['user']['user_id']}',
                                log_id={$_POST['log_id']},
                                safety_audit='{$safety_stuff}',
                                {$reading}
                                priority=1
                                ");
        if ($add_jobcard) {
            $job_id = mysqli_insert_id($db);
            require_once "../../mail.clerk.new_job.php";
            $update_plant = dbq("update plants_tbl set
                                {$reading},
                                status='breakdown'
                                where plant_id={$_POST['plant_id']}
        ");
            if ($update_plant) {
                msg("Breakdown started, Job ref: {$job_id}.");
                go('dashboard.php?page=plants');
            } else {
                sqlError();
            }
        } else {
            sqlError('Adding job card.', 'Adding job card.');
        }
    } else {
        switch ($plant_['status']) {
            case "breakdown":
                error("This plant is already on breakdown and job card has been logged.");
                break;

            default:
                error("This is plant is active. The operator must log a breakdown.");
                break;
        }
    }
}

if (isset($_POST['start_break'])) {
    if (date_create($_POST['start_datetime'])) {
        $add_event = dbq("insert into operator_events set
                                operator_log={$_POST['log_id']},
                                start_datetime='{$_POST['start_datetime']}',
                                type='break',
                                start_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                ");
        if ($add_event) {
            $event_id = mysqli_insert_id($db);

            $update_log = dbq("update operator_log set
                                    status='break',
                                    status_id={$event_id}
                                    where log_id={$_POST['log_id']}");
            if ($update_log) {

                $update_plant = dbq("update plants_tbl set
                                        status='break'
                                        where plant_id={$_POST['plant_id']}
                                        ");
                if ($update_plant) {
                    msg("Break started!");
                    go('dashboard.php?page=plants');
                } else {
                    sqlError();
                }
            } else {
                sqlError('');
            }
        } else {
            sqlError('Adding event', 'Adding event');
        }
    } else {
        error("Invalid date/time");
    }
}

if (isset($_POST['end_break'])) {
    if (date_create($_POST['end_datetime'])) {
        $operator_log = dbf(dbq("select * from operator_log where log_id={$_POST['log_id']}"));

        $update_log = dbq("update operator_events set
                            end_datetime='{$_POST['end_datetime']}',
                            end_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                            where event_id={$operator_log['status_id']}
                            ");
        if ($update_log) {
            $update_log = dbq("update operator_log set
                                status='S',
                                status_id=0
                                where log_id={$_POST['log_id']}");

            if ($update_log) {
                $update_plant = dbq("update plants_tbl set
                                    status='busy'
                                    where plant_id={$_POST['plant_id']}
                                    ");
                if ($update_plant) {
                    msg("Break ended.");
                    go('dashboard.php?page=plants');
                } else {
                    sqlError('update plants_tbl', 'update plants_tbl');
                }
            } else {
                sqlError('event update', 'event update');
            }
        } else {
            sqlError('update operator_log', 'update operator_log');
        }
    } else {
        error("Invalid date/time");
    }
}

if (isset($_POST['start_refuel'])) {

    if (date_create($_POST['start_datetime']) && is_numeric($_POST['reading']) && isset($_POST['plant_id'])) {
        if (check_reading($_POST['plant_id'], $_POST['reading'])) {
            if ($plant_ = get_plant($_POST['plant_id'])) {
                $add_refuel = dbq("insert into operator_refuel set
                                    operator_log={$_POST['log_id']},
                                    plant_id={$_POST['plant_id']},
                                    reading={$_POST['reading']},
                                    start_datetime='{$_POST['start_datetime']}'
                                    ");
                if ($add_refuel) {
                    $refuel_id = mysqli_insert_id($db);
                    if (upload_images('start_refuel', $_SESSION['user']['user_id'], $_POST['plant_id'], $_SESSION['upload_images'], $refuel_id)) {
                        $update_log = dbq("update operator_log set
                                            status='refuel',
                                            status_id={$refuel_id}
                                            where log_id={$_POST['log_id']}");

                        if ($update_log) {
                            if (update_plant_reading($_POST['plant_id'], $_POST['reading'], 'refuel')) {
                                msg('Refuel started!');
                                go('dashboard.php?page=plants');
                            }
                        } else {
                            sqlError('update log', 'update log');
                        }
                    } else {
                        error("Error uploading images.");
                    }
                } else {
                    sqlError('refuel event', 'refuel event');
                }
            }
        }
    } else {
        error('Invalid date/time.');
    }
}

if (isset($_POST['end_refuel'])) {
    if (date_create($_POST['end_datetime'])) {
        if (strlen($_POST['liters'] > 0 && is_numeric($_POST['liters']))) {
            $operator_log = dbf(dbq("select * from operator_log where log_id={$_POST['log_id']}"));

            if (!upload_images('end_refuel', $_SESSION['user']['user_id'], $_POST['plant_id'], $_SESSION['upload_images'], $operator_log['status_id'])) {
                error("There was an error uploading the photos.");
            }

            $update_refuel = dbq("update operator_refuel set
                                    end_datetime='{$_POST['end_datetime']}',
                                    liters={$_POST['liters']},
                                    comments='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                    where refuel_id={$operator_log['status_id']}
                                    ");
            if ($update_refuel) {
                if (upload_images('end_refuel', $_SESSION['user']['user_id'], $_POST['plant_id'], $_SESSION['upload_images'], $operator_log['status_id'])) {
                    $update_log = dbq("update operator_log set
                                        status='S',
                                        status_id=0
                                        where log_id={$_POST['log_id']}");

                    if ($update_log) {
                        $update_plant = dbq("update plants_tbl set
                                        status='busy'
                                        where plant_id={$_POST['plant_id']}");
                        if ($update_plant) {
                            msg('Refuel ended!');
                            go('dashboard.php?page=plants');
                        } else {
                            sqlError('update plant', 'update plant');
                        }
                    } else {
                        sqlError('update log', 'update log');
                    }
                } else {
                    error("Error uploading images.");
                }
            } else {
                sqlError('refuel event', 'refuel event');
            }
        } else {
            error("invalid liters entered.");
        }
    } else {
        error('Invalid date/time.');
    }
}

if (isset($_POST['submit_checklist'])) {
    /* Preset Status to 'G' = Good */
    $status = 'G';
    $faulty = false;
    if ($_POST['submit_checklist'] > 0) {
        $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$_POST['submit_checklist']}"));
        if ($plant_ = get_plant($_POST['submit_checklist'])) {
            $get_checklist = dbq("select * from plant_checklist order by item_order");
            if ($get_checklist) {
                if (dbr($get_checklist) > 1) {
                    $json_checklist = [];
                    while ($checkitem = dbf($get_checklist)) {
                        $result =  (!isset($_POST[$checkitem['checklist_id']])) ? "No" : "Yes";

                        $json_checklist[] = ['Question' => $checkitem['check_item'], 'Result' => $result];
                        if ($result == 'No') {
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
                    }
                } else {
                    error("No check list.");
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

            $results = base64_encode(json_encode($json_checklist));

            if ($faulty) {
                switch ($status) {
                    case "L":
                        $priority = 3;
                        $job_status = 'repair';
                        break;

                    case "M":
                        $priority = 2;
                        $job_status = 'repair';
                        break;

                    case "H":
                        $priority = 1;
                        $job_status = 'breakdown';
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
                                            jobcard_type='{$job_status}',
                                            priority='{$priority}'
                                            ");

                if ($add_jobcard) {
                    $job_id = mysqli_insert_id($db);
                    msg("Job card created.");
                } else {
                    sqlError();
                }

                /* Make plant status faulty if High */
                if ($status == 'H') {
                    $insp_status = 'Fault';
                    $update_plant = dbq("update plants_tbl set
                                                operator_id=0,
                                                status='breakdown'
                                                where plant_id={$_POST['submit_checklist']}
                                                ");
                    if ($update_plant) {
                        msg("Plant is made faulty.");
                    } else {
                        sqlError();
                    }
                } else {
                    $insp_status = 'Fault';
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
            } else {
                $insp_status = 'Good';
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

            $query_ = "insert into checklist_results set
                            datetime='" . date('Y-m-d H:i:s') . "',
                            user_id={$_SESSION['user']['user_id']},
                            plant_id={$_POST['submit_checklist']},
                            results='{$results}',
                            comments='" . htmlentities($_POST['comments'], ENT_QUOTES) . "',
                            status='{$insp_status}'
                            ";

            $save_checklist = dbq($query_);
            error_log("SQL : {$query_}");
            if ($save_checklist) {
                if (isset($job_id)) {
                    $list_id = mysqli_insert_id($db);
                    $update_ = dbq("update jobcards set list_id={$list_id} where job_id={$job_id}");
                    if ($update_) sqlError();
                } else {
                    $msg[] = "No job_id";
                }

                msg("Check list saved.");
                go('dashboard.php?page=plants');
            } else {
                sqlError();
                $error[] = "SQL Error: " . dbe();
            }

            go("dashboard.php?page=plants");
        }
    }
}

if (isset($_POST['end_breakdown'])) {
    if (date($_POST['totime'])) {
        if ($_POST['reading'] > 0) {
            if (isset($_SESSION['upload_images']) && count($_SESSION['upload_images']) > 0) {
                $operator_log = dbf(dbq("select * from operator_log where log_id={$_POST['log_id']}"));

                if (!upload_images('breakdown_end', $_SESSION['user']['user_id'], $_POST['plant_id'], $_SESSION['upload_images'], $operator_log['status_id'])) {
                    error("There was an error uploading the photos.");
                }

                $update_log = dbq("update operator_events set
                                        end_datetime='{$_POST['totime']}',
                                        end_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                        where event_id={$operator_log['status_id']}
                                        ");
                if ($update_log) {
                    $update_log = dbq("update operator_log set
                                            status='S',
                                            status_id=0
                                            where log_id={$_POST['log_id']}");

                    if ($update_log) {
                        $update_plant = dbq("update plants_tbl set
                                                {$_POST['reading_type']}_reading={$_POST['reading']},
                                                status='busy'
                                                where plant_id={$_POST['plant_id']}
                                                ");
                        if ($update_plant) {
                            msg("Breakdown ended.");
                            go('dashboard.php?page=plants');
                        } else {
                            sqlError('update plants_tbl', 'update plants_tbl');
                        }
                    } else {
                        sqlError('event update', 'event update');
                    }
                } else {
                    sqlError('update operator_log', 'update operator_log');
                }
            } else {
                error("Please submit photos.");
            }
        } else {
            error("fill in the reading.");
        }
    } else {
        error("Invalid date / time.");
    }
}

if (isset($_POST['start_breakdown'])) {
    if ($_POST['clerk_id'] > 0) {
        if (isset($_SESSION['upload_images']) && count($_SESSION['upload_images']) > 0) {
            if (is_numeric($_POST['reading']) && $_POST['reading'] > 0) {
                /* Log Job card */
                switch ($_POST['reading_type']) {
                    case "hr":
                        $reading = "hr_reading='{$_POST['reading']}',";
                        break;

                    case "km":
                        $reading = "km_reading='{$_POST['reading']}',";
                        break;
                }

                $get_safety_equipment = dbq("select * from safety_equipment");
                if ($get_safety_equipment) {
                    if (dbr($get_safety_equipment) > 0) {
                        while ($equipment = dbf($get_safety_equipment)) {
                            if ($_POST[$equipment['code']] == 'on') {
                                $answer = 'Yes';
                            } else {
                                $answer = 'No';
                            }

                            $safety_stuff[] = [
                                'name' => $equipment['name'],
                                'answer' => $answer
                            ];
                        }
                    }
                }

                if (isset($safety_stuff)) {
                    $safety_stuff = base64_encode(json_encode($safety_stuff));
                } else {
                    $safety_stuff = '';
                }

                $add_jobcard = dbq("insert into jobcards set
                                            plant_id={$_POST['plant_id']},
                                            job_date='" . date('Y-m-d') . "',
                                            fault_description='" . $_POST['fault_area'] . " - " . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                            logged_by='{$_SESSION['user']['user_id']}',
                                            clerk_id={$_POST['clerk_id']},
                                            log_id={$_POST['log_id']},
                                            safety_audit='{$safety_stuff}',
                                            {$reading}
                                            priority=1
                                            ");
                if ($add_jobcard) {
                    $job_id = mysqli_insert_id($db);

                    $clerk_ = dbf(dbq("select * from users_tbl where clerk_id={$_POST['clerk_id']}"));
                    if (strlen($clerk_['email']) > 0) {
                        $job_id = mysqli_insert_id($db);
                        $jobcard_ = dbf(dbq("select * from jobcards wher job_id={$job_id}"));
                        $mechanic_ = dbf(dbq("select * from users_tbl where user_id-{$jobcard_['mechanic_id']}"));
                        $mail = new PHPMailer(true);


                        try {
                            $mail->addAddress($clerk_['email'], $clerk_['name'] . ' ' . $clerk_['last_name']);     //Add a recipient                    
                            //$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
                            $mail->addCC($_SESSION['settings']['requisition_mail']);

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = "#{$jobcard_['job_id']} - Job card requested";
                            $mail->Body    = "
                                <b>Job Card request</b><br>
                                <p>
                                    <b>Date time.</b>&nbsp;" . date("Y-m-d H:i") . "<br>
                                    <b>Job ID.</b>&nbsp;{$jobcard_['job_id']}<br>
                                    <b>Mechanic.</b>&nbsp;{$mechanic_['name']} {$mechanic_['last_name']}<br>
                                    <b>Description.</b>&nbsp;{$jobcard_['fault_description']}<br>
                                    <b>Priority.</b>&nbsp;{$jobcard_['priority']}<br><br>
                                </p>
                                Kind Regards,<br>
                                <b>{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}</b><br>
                                E-mail: {$_SESSION['user']['email']}
                                ";
                            $mail->AltBody = "
                                    Job Card request\n\r\n\r
                                    Date time. : " . date("Y-m-d H:i") . "\n\r
                                    Job ID. : {$jobcard_['jobcard_id']}\n\r
                                    Mechanic. : {$mechanic_['name']} {$mechanic_['last_name']}\n\r
                                    Description. : {$jobcard_['fault_description']}\n\r
                                    Priority. : {$jobcard_['priority']}\n\r                                    
                                    \n\r\n\r
                                    Kind Regards,\n\r
                                    {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}\n\r
                                    E-mail: {$_SESSION['user']['email']}
                                    ";

                            $mail->send();
                            msg('Mail was send to clerk.');
                        } catch (Exception $e) {
                            error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
                        }
                    }

                    $add_event = dbq("insert into operator_events set
                                                operator_log={$_POST['log_id']},
                                                start_datetime='{$_POST['start_datetime']}',
                                                type='breakdown',
                                                start_comment='" . htmlentities($_POST['comment'], ENT_QUOTES) . "'
                                                ");
                    if ($add_event) {
                        $event_id = mysqli_insert_id($db);
                        if (!upload_images('breakdown_start', $_SESSION['user']['user_id'], $_POST['plant_id'], $_SESSION['upload_images'], $event_id)) {
                            error("There was an error uploading the photos.");
                        }
                        $update_log = dbq("update operator_log set
                                                    status='breakdown',
                                                    status_id={$event_id}
                                                    where log_id={$_POST['log_id']}");
                        if ($update_log) {

                            $update_plant = dbq("update plants_tbl set
                                                        {$_POST['reading_type']}_reading={$_POST['reading']},
                                                        status='breakdown'
                                                        where plant_id={$_POST['plant_id']}
                                                        ");
                            if ($update_plant) {
                                msg("Breakdown started, Job ref: {$job_id}.");
                                go('dashboard.php?page=plants');
                            } else {
                                sqlError();
                            }
                        } else {
                            sqlError('');
                        }
                    } else {
                        sqlError('Adding event', 'Adding event');
                    }
                } else {
                    sqlError('Error adding job card', 'Error adding job card.');
                }
            } else {
                error("Must fill in the reading.");
            }
        } else {
            error("please submit photos.");
        }
    } else {
        error("Please select the clerk to request job card.");
    }
}

if (isset($_POST['end_log'])) {
    if (isset($_POST['log_id'])) {
        $get_log = dbq("select * from operator_log where log_id={$_POST['log_id']}");
        if ($get_log) {
            if (dbr($get_log) > 0) {
                $log_ = dbf($get_log);
                if (isset($_SESSION['upload_images']) && count($_SESSION['upload_images']) > 0) {
                    if ($log_['status'] == 'S') {
                        if ($log_['operator_id'] == $_SESSION['user']['user_id']) {
                            //$end_datetime = "{$_POST['enddate']} {$_POST['endtime']}";
                            if (date_create($_POST['end_datetime'])) {
                                // $hr_reading = get_hours($log_['start_datetime'],  $end_datetime);

                                // if ($log_['start_reading'] <= $_POST['reading']) {
                                $update_ = dbq("update operator_log set
                                                    end_datetime='{$_POST['end_datetime']}',
                                                    end_reading={$_POST['reading']},
                                                    status='E'
                                                    where log_id={$log_['log_id']}
                                                    ");
                                if (mysqli_affected_rows($db) != -1) {
                                    if (upload_images('operator_log_end', $log_['operator_id'], $log_['plant_id'], $_SESSION['upload_images'], $log_['log_id'])) {
                                        $last_log = mysqli_insert_id($db);
                                        $query = '';
                                        switch ($_POST['reading_type']) {
                                            case 'km':
                                                $query .= "km_reading={$_POST['reading']},";
                                                break;

                                            case 'hr':
                                                $query .= "hr_reading={$_POST['reading']},";
                                                break;
                                        }

                                        $query = "update plants_tbl set
                                                        {$query}                                                        
                                                        operator_id=0,
                                                        status='ready'
                                                        where plant_id={$log_['plant_id']}
                                                        ";
                                        $update_plant = dbq($query);
                                        if (mysqli_affected_rows($db) != -1) {
                                            msg("Operator log submitted.");
                                            go('dashboard.php?page=plants');
                                        } else {
                                            sqlError('Update plants_tbl', 'Update plants_tbl: ' . htmlentities($query, ENT_QUOTES));
                                        }
                                    }
                                } else {
                                    sqlError('Operator log', 'Operator log');
                                }
                                /*} else {
                                error("Invalid reading");
                            }*/
                            } else {
                                error("Invalid date/time.");
                            }
                        } else {
                            error("Invalid log.");
                            go('logout.php');
                        }
                    } else {
                        error("Invalid status.");
                    }
                } else {
                    error("You require a photo.");
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
        if ($plant_ = get_plant($_POST['plant_id'])) {
            if ($plant_['operator_id'] == $_SESSION['user']['user_id']) {
                if ($plant_['status'] == 'check') {
                    $insert_log = dbq("insert into operator_log set
                                                    start_datetime='" . esc($_POST['start_datetime']) . "',
                                                    operator_id={$plant_['operator_id']},
                                                    plant_id={$plant_['plant_id']},
                                                    site='{$_POST['site']}',
                                                    reading_type='{$_POST['reading_type']}',
                                                    start_reading='{$_POST['reading']}',
                                                    status='S'
                                                    ");
                    if ($insert_log) {
                        $log_key = mysqli_insert_id($db);
                        if (upload_images('operator_log_start', $plant_['operator_id'], $plant_['plant_id'], $_SESSION['upload_images'], $log_key)) {
                            $last_log = mysqli_insert_id($db);
                            $update_plant = dbq("update plants_tbl set
                                                        " . esc($_POST['reading_type']) . "_reading='{$_POST['reading']}',
                                                        operator_datetime='" . esc($_POST['start_datetime']) . "',
                                                        status='busy'
                                                        where plant_id={$plant_['plant_id']}
                                                        ");
                            if (mysqli_affected_rows($db) != -1) {
                                msg("Operator log submitted.");
                                go('dashboard.php?page=plants');
                            } else {
                                sqlError('updating plant', 'updating plant');
                            }
                        }
                    } else {
                        sqlError('adding log', 'adding log');
                    }
                } else {
                    error("Plant status violation.");
                }
            } else {
                error("Access violation.");
                go('logout.php');
            }
        }
    } else {
        error("You must take photo of your reading.");
    }
}
