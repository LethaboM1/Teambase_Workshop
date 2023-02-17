<?php
require_once "includes/check.php";

$get_assessment = dbq("select * from jobcard_risk_assessments where note is null");

if ($get_assessment) {
    if (dbr($get_assessment) > 0) {
        while ($assessment = dbf($get_assessment)) {
            $jobcard_ = dbf(dbq("select * from jobcards where job_id={$assessment['job_id']}"));
            $update_ = dbq("update jobcard_risk_assessments set
                                date_time='{$jobcard_['job_date']}',
                                note='Initial Assessment.'
                                where id={$assessment['id']}");
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