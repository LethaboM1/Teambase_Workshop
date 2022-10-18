<?php


if (isset($_POST['change_status'])) {
    if (strlen($_POST['status']) > 0) {
        $query = "";

        switch ($_POST['status']) {
            case 'approved':
                $query = "
                        approved_by={$_SESSION['user']['user_id']},                        
                        approved_by_time='" . date("Y-m-d\TH:i:s") . "',
                        approved_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        buyer_id='" . $_POST['buyer_id'] . "',
                        ";
                break;

            case 'ordered':
                $query = "
                        ordered_by={$_SESSION['user']['user_id']},
                        ordered_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ordered_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'received':
                $query = "
                        received_by={$_SESSION['user']['user_id']},
                        received_by_time='" . date("Y-m-d\TH:i:s") . "',
                        received_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'completed':
                $query = "
                        completed_by={$_SESSION['user']['user_id']},
                        completed_by_time='" . date("Y-m-d\TH:i:s") . "',
                        completed_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'canceled':
                $query = "
                        canceled_by={$_SESSION['user']['user_id']},
                        canceled_by_time='" . date("Y-m-d\TH:i:s") . "',
                        canceled_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'denied':
                $query = "
                        denied_by={$_SESSION['user']['user_id']},
                        denied_by_time='" . date("Y-m-d\TH:i:s") . "',
                        denied_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;
        }



        $update_status = dbq("update jobcard_requisitions set
                                    {$query}
                                    status='{$_POST['status']}'
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
            }

            go('dashboard.php?page=job-requisitions');
        } else {
            sqlError('', '');
        }
    }
}
