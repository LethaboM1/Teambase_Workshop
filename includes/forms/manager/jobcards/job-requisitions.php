<?php


if (isset($_POST['change_status'])) {
    $the_request = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
    if (($_POST['status'] != 0) || ($_POST['buyer_id'] > 0)) {
        $query = "";

        switch ($_POST['status']) {
            case '0':
                $query = "
                        buyer_id='" . $_POST['buyer_id'] . "'
                        ";
                break;

            case 'approved':
                $query = "
                        approved_by={$_SESSION['user']['user_id']},                        
                        approved_by_time='" . date("Y-m-d\TH:i:s") . "',
                        approved_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        buyer_id='" . $_POST['buyer_id'] . "',
                        status='{$_POST['status']}'
                        ";
                break;

            case 'ordered':
                $query = "
                        ordered_by={$_SESSION['user']['user_id']},
                        ordered_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ordered_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        status='{$_POST['status']}'
                        ";
                break;

            case 'received':
                $query = "
                        received_by={$_SESSION['user']['user_id']},
                        received_by_time='" . date("Y-m-d\TH:i:s") . "',
                        received_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        status='{$_POST['status']}'
                        ";
                break;

            case 'completed':
                $query = "
                        completed_by={$_SESSION['user']['user_id']},
                        completed_by_time='" . date("Y-m-d\TH:i:s") . "',
                        completed_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        status='{$_POST['status']}'
                        ";
                break;

            case 'canceled':
                $query = "
                        canceled_by={$_SESSION['user']['user_id']},
                        canceled_by_time='" . date("Y-m-d\TH:i:s") . "',
                        canceled_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        status='{$_POST['status']}'
                        ";
                break;

            case 'rejected':
                $query = "
                        rejected_by={$_SESSION['user']['user_id']},
                        rejected_by_time='" . date("Y-m-d\TH:i:s") . "',
                        rejected_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        status='{$_POST['status']}'
                        ";
                break;
        }



        $update_status = dbq("update jobcard_requisitions set
                                    {$query}
                                    where request_id={$_POST['request_id']}
                                    ");
        if ($update_status) {
            $request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
            msg("Status changed!");

            switch ($_POST['status']) {
                case "received":
                    $job_request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
                    $_POST['mechanic'] = $job_request_['requested_by'];
                    $_POST['jobnumber'] = $job_request_['job_id'];

                    require_once "./includes/forms/sms.mechanic.parts_receieved.php";
                    break;
                case "approved":
                    if ($_POST['buyer_id'] > 0) {
                        $job_request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
                        $job_id = $job_request_['job_id'];
                        $mechanic_id = $job_request_['requested_by'];
                        $request_id = $job_request_['request_id'];
                        require_once "./includes/forms/mail.buyer.request.php";
                    }
                    break;
            }

            if ($_POST['buyer_id'] != $the_request['buyer_id']) {
                $job_request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
                $job_id = $job_request_['job_id'];
                $mechanic_id = $job_request_['requested_by'];
                $request_id = $job_request_['request_id'];
                require_once "./includes/forms/mail.buyer.request.php";
            }

            go('dashboard.php?page=job-requisitions');
        } else {
            sqlError('', '');
        }
    } else {
        error("you must choose a status and buyer.");
    }
}
