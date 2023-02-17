<?php
require_once "includes/check.php";

$get_assessment = dbq("select * from jobcards where risk_assessment is not null");

if ($get_assessment) {
    if (dbr($get_assessment) > 0) {
        while ($assessment = dbf($get_assessment)) {
            $add = dbq("insert into jobcard_risk_assessments set job_id={$assessment['job_id']}, results='" . $assessment['risk_assessment'] . "'");
            if ($add) {
                $update_jobcard = dbq("update jobcards set
                                            risk_assessment=null
                                            where job_id={$assessment['job_id']}");
                if (!$update_jobcard) error_log('SQL error: ' . dbe());
            }
        }
    }
}

/*
$get_requisitions = dbq("select * from jobcard_requisitions where part_number is not NULL and (status!='completed' && status!='canceled' && status!='rejected') order by datetime");
if ($get_requisitions) {
    if (dbr($get_requisitions) > 0) {
        while ($request = dbf($get_requisitions)) {
            $add_part = dbq("insert into jobcard_requisition_parts set
                                    request_id={$request['request_id']},
                                    part_number='{$request['part_number']}',
                                    part_description='{$request['part_description']}',
                                    qty={$request['qty']},
                                    comment='" . esc($request['comment']) . "'
                                    ");
            if ($add_part) {
                $update_ = dbq("update jobcard_requisitions set
                                        part_number=NULL,
                                        part_description=NULL,
                                        qty=NULL
                                        ");
                if (!$update_) {
                    $json_['status'] = 'error';
                    $json_['message'][] = "SQL error: " . dbe();
                }
            } else {
                $json_['status'] = 'error';
                $json_['message'][] = "SQL error: " . dbe();
            }
        }
    } else {
        $json_['status'] = 'ok';
        $json_['message'][] = "There are no requisitions.";
    }
} else {
    $json_['status'] = 'error';
    $json_['message'][] = "SQL error: " . dbe();
}

if (isset($json_)) {
    echo json_encode($json_);
}
*/