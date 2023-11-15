<?php

if (!$testserver) {
    if (!isset($_POST['mechanic'])) {
        $_POST['mechanic'] = $_POST['mechanic_id'];
    }



    $mechanic_ = dbf(dbq("select * from users_tbl where user_id={$_POST['mechanic']}"));
    $jobcard_ = dbf(dbq("select * from jobcards where job_id={$_POST['jobnumber']}"));

    if (strlen($mechanic_['contact_number']) > 0) {
        $message = "Requisition {$job_request_['request_id']} receieved,#{$jobcard_['jobcard_number']},{$job_request_['received_by_comment']}";
        sms_($mechanic_['contact_number'], $message);
    } else {
        error("Mechanic does not have a cell number.");
    }
}
