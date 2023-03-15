<?php


if (!isset($_GET['id']) || $_GET == '') go('dashboard.php');

$jobcard_ = get_jobcard($_GET['id']); // dbf(dbq("select * from jobcards where job_id={$_GET['id']}"));
$plant_ = get_plant($jobcard_['plant_id']); // dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));

if (isset($_POST['cancel'])) {
    unset($_SESSION['request_parts']);
    go('dashboard.php?page=job-card-view&id=' . $_GET['id']);
}

if (isset($_POST['request_parts'])) {
    if (is_array($_SESSION['request_parts']) && count($_SESSION['request_parts']) > 0) {
        $add_request = dbq("insert into jobcard_requisitions set
                                                datetime='" . $_POST['request_date'] . "',
                                                job_id='{$_GET['id']}',
                                                plant_id='{$plant_['plant_id']}',
                                                requested_by={$_SESSION['user']['user_id']},
                                                comment='" . htmlentities($_POST['request_comment'], ENT_QUOTES) . "',
                                                requested_by_time='" . date("Y-m-d\TH:i:s") . "'
                                                ");
        if ($add_request) {
            $request_id = mysqli_insert_id($db);

            $err = false;
            foreach ($_SESSION['request_parts'] as $part) {
                if ($err) {
                    break;
                }
                $add_part = dbq("insert into jobcard_requisition_parts set
                                        request_id={$request_id},
                                        part_number='" . htmlentities($part['part_no'], ENT_QUOTES) . "',
                                        part_description='" . htmlentities($part['description'], ENT_QUOTES) . "',
                                        qty={$part['qty']},
                                        comment='" . htmlentities($part['comment'], ENT_QUOTES) . "'
                                        ");
                if (!$add_part) {
                    $err = true;
                    $error[] = '# ' . $request_id . 'Error adding part to requisition:' . dbe();
                    error_log('# ' . $request_id . 'Error adding part to requisition:' . dbe());
                }
            }

            if (!isset($error)) {
                saveRequisition($request_id);
                if ($jobcard['jobcard_type'] == 'service') {
                    go('dashboard.php?page=plant-schedule&id=' . $_GET['id']);
                } else {
                    go('dashboard.php?page=job-card-view&id=' . $_GET['id']);
                }
            }
        } else {
            $error[] = "Error adding requisition: " . dbe();
        }
    } else {
        $error[] = "You must add parts!";
    }
}
