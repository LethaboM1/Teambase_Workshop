<?php

if (isset($_POST['request_jobcard'])) {
    if (
        $_POST['clerk_id'] > 0
        && (($_POST['plant_id'] > 0 && $_POST['jobcard_type'] != 'sundry' && strlen($_POST['site']) > 0) || ($_POST['jobcard_type'] == 'sundry'))
    ) {
        $create_jobcard = true;

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

        $query = '';
        if ($_POST['jobcard_type'] == 'sundry') {
            $chk_sundry_jobcard = dbq("select * from jobcards where status='open' and jobcard_type='sundry' and mechanic_id={$_SESSION['user']['user_id']}");
            if (dbr($chk_sundry_jobcard) > 0) {
                error("There is an open sundry job card for you. Close the job card before you can create a new one.");
                $create_jobcard = false;
            } else {
                $_POST['plant_id'] = 0;
                $_POST['priority'] = 9999;
                $_POST['allocated_hours'] = 0;
                $query .= "status='allocated',allocated_hours=0,";
            }
        } else if ($_POST['jobcard_type'] == 'service') {
            $query .= "service_type='{$_POST['service_type']}',";
            $query .= "{$_POST['reading_type']}_reading={$_POST['reading']},";
        } else {
            $query .= "{$_POST['reading_type']}_reading={$_POST['reading']},";
        }



        if ($create_jobcard) {
            $add_jobcard = dbq("insert into jobcards set
                                    plant_id={$_POST['plant_id']},
                                    job_date='" . date('Y-m-d') . "',
                                    clerk_id={$_POST['clerk_id']},
                                    mechanic_id={$_SESSION['user']['user_id']},
                                    logged_by='{$_SESSION['user']['user_id']}',
                                    site='" . esc($_POST['site']) . "',
                                    fault_description='" . htmlentities($_POST['comment'], ENT_QUOTES) . "',
                                    safety_audit='{$safety_stuff}',
                                    {$query}
                                    jobcard_type='{$_POST['jobcard_type']}',
                                    priority='{$_POST['priority']}'
                                    ");
            if ($add_jobcard) {
                $job_id = mysqli_insert_id($db);

                if ($_POST['jobcard_type'] == 'service' && $_SESSION['settings']["jobcard_service_" . strtolower($_POST['service_type']) . "_hours"] > 0) {
                    $add_service = dbq("insert into jobcard_reports set
                                            job_id={$job_id},
                                            component='service',
                                            severity='Medium',
                                            hours='{$_SESSION['settings']["jobcard_service_" . strtolower($_POST['service_type']) . "_hours"]}',
                                            comment='Type " . strtoupper($_POST['service_type']) . " service.'
                                            ");
                    if (!$add_service)  error_log("Error adding service to report: " . dbe());
                }

                if (is_array($_SESSION['fault_reports'])) {
                    if (count($_SESSION['fault_reports']) > 0) {
                        foreach ($_SESSION['fault_reports'] as $report) {
                            $insert_report = dbq("insert into jobcard_reports set
                                                    job_id={$job_id},
                                                    component='{$report['component']}',
                                                    severity='{$report['severity']}',
                                                    hours='{$report['hours']}',
                                                    comment='" . htmlentities($report['comment']) . "'
                                                    ");
                            if (!$insert_report) {
                                error_log("Error adding report: job={$job_id}:" . dbe());
                            }
                        }
                        unset($_SESSION['fault_reports']);
                    }
                }
                update_plant_status($_POST['plant_id'], $_POST['jobcard_type'], "operator_id=0");
                msg("Job card added.");
                require_once "./includes/forms/mail.clerk.new_job.php";
                go('dashboard.php');
            } else {
                sqlError('Adding job card', 'adding job card');
            }
        }
    } else {
        error("Required filed missing: Plant, Site and clerk");
    }
}
