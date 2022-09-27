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
