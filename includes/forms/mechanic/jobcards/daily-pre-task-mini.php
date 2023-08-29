<?php
if (isset($_GET['id'])) {
    $get_jobcard = dbq("select * from jobcards where job_id={$_GET['id']} and mechanic_id={$_SESSION['user']['user_id']}");
    if ($get_jobcard) {
        if (dbr($get_jobcard) > 0) {
            $jobcard_ = dbf($get_jobcard);

            if ($jobcard_['jobcard_type'] == 'contract') {
                $site_ = get_site($jobcard_['site_id']);
                if (!$site_) {
                    go('dashboard.php?page=open-job');
                }
            } else {

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


if (isset($_POST['add_job_checklist'])) {
    if ($_POST['agree_to_statements'] == 'agree') {
        $check_list = dbq("select * from job_checklist order by item_order");
        if ($check_list) {
            while ($row = dbf($check_list)) {
                if ($_POST['q_' . $row['checklist_id']] == 'Yes') {
                    $answer = 'Yes';
                } else {
                    $answer = "No";
                }

                $job_check_list[] = [
                    'job_id' => $_GET['id'],
                    'question' => $row['question'],
                    'answer' => $answer,
                    'comment' => $_POST['comment_' . $row['checklist_id']]
                ];
            }
        } else {
            sqlError();
        }

        if (!is_error()) {
            if (isset($job_check_list)) {
                $_SESSION['pre-task']['team'][] = [
                    'name' => "{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}",
                    'company_number' => $_SESSION['user']['company_number']
                ];

                $job_check_list = base64_encode(json_encode($job_check_list));
                $add_assessment = dbq("insert into jobcard_risk_assessments set
                                                job_id={$_GET['id']},
                                                date_time='" . date('Y-m-d H:i') . "',
                                                note='" . htmlentities($_POST['note'], ENT_QUOTES) . "',
                                                results='" . esc($job_check_list) . "',
                                                team_members='" . base64_encode(json_encode($_SESSION['pre-task']['team'])) . "'
                                                ");
                if ($add_assessment) {
                    $update_jobcard = dbq("update jobcards set status='busy' where job_id={$_GET['id']}");

                    if ($update_jobcard) {
                        msg("Job assessment done.");
                        switch ($jobcard_['jobcard_type']) {
                            case "service":
                                go("dashboard.php?page=plant-schedule&id={$_GET['id']}");
                                break;

                            default:
                                go("dashboard.php?page=job-card-view&id={$_GET['id']}");
                                break;
                        }
                    } else {
                        sqlError();
                    }
                } else {
                    sqlError();
                }
            }
        }
    } else {
        error("You must agree to the statements to continue.");
    }
}


if (!isset($_POST['add_job_checklist'])) {
    unset($_SESSION['pre-task']['team']);
    error_log("Unset pre-task");
}
