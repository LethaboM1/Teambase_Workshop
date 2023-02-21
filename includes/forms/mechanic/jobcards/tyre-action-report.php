<?php

$jobcard_ = dbf(dbq("select * from jobcards where job_id={$_GET['id']}"));
$plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));

if (isset($_POST['cancel'])) {
    go('dashboard.php?page=job-card-view&id=' . $_GET['id']);
}


if (isset($_POST['add_tyre_report'])) {
    for ($pos = 1; $pos <= 12; $pos++) {
        if (
            strlen($_POST["{$pos}_size"]) > 0
            || strlen($_POST["{$pos}_make"]) > 0
            || strlen($_POST["{$pos}_tread"]) > 0
            || strlen($_POST["{$pos}_pressure"]) > 0
            || strlen($_POST["{$pos}_tyre_type"]) > 0
        ) {
            if (
                strlen($_POST["{$pos}_size"]) == 0
                || strlen($_POST["{$pos}_make"]) == 0
                || strlen($_POST["{$pos}_tread"]) == 0
                || strlen($_POST["{$pos}_pressure"]) == 0
                || strlen($_POST["{$pos}_tyre_type"]) == 0
            ) {
                $error[] = "You have not filled in all the required fields for tyre position {$pos}.";
            } else {
                $tyres[] = $pos;
            }
        }
    }

    if (!isset($error)) {
        if (is_array($tyres) && count($tyres) > 0) {
            $add_report = dbq("insert into jobcard_tyre_reports set
                                    date_time='" . date('Y-m-d H:i') . "',
                                    job_id={$_GET['id']},
                                    note='" . htmlentities($_POST['notes'], ENT_QUOTES) . "'
                                    ");

            if ($add_report) {
                $tyre_rep_id = mysqli_insert_id($db);

                foreach ($tyres as $pos) {
                    ($_POST["{$pos}_valve_cap"] == 'yes') ? $valve_cap = 1 : $valve_cap = 0;
                    ($_POST["{$pos}_valve_ext"] == 'yes') ? $valve_ext = 1 : $valve_ext = 0;

                    $add_tyre = dbq("insert into jobcard_tyre_report_lines set
                                            tyre_rep_id={$tyre_rep_id},
                                            position={$pos},
                                            tread='{$_POST["{$pos}_tread"]}',
                                            pressure='{$_POST["{$pos}_pressure"]}',
                                            size='{$_POST["{$pos}_size"]}',
                                            make='{$_POST["{$pos}_make"]}',
                                            valve_cap={$valve_cap},
                                            valve_ext={$valve_ext},
                                            tyre_type='{$_POST["{$pos}_tyre_type"]}'
                                            ");
                    if (!$add_tyre) $error[] = "Error adding tyre {$pos} : " . dbe();
                }

                go("dashboard.php?page=job-card-view&id={$_GET['id']}");
            } else {
                $error[] = "SQL error adding report: " . dbe();
            }
        } else {
            $error[] = "You must fill in details.";
        }
    }
}
