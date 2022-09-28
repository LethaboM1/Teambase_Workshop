<?php

if (isset($_POST['change_status'])) {
    if (strlen($_POST['status']) > 0) {
        $query = "";

        switch ($_POST['status']) {
            case 'approved':
                $query = "
                        approved_by={$_SESSION['user']['user_id']},
                        approved_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ";
                break;

            case 'ordered':
                $query = "
                        ordered_by={$_SESSION['user']['user_id']},
                        ordered_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ";
                break;

            case 'received':
                $query = "
                        received_by={$_SESSION['user']['user_id']},
                        received_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ";
                break;

            case 'completed':
                $query = "
                        completed_by={$_SESSION['user']['user_id']},
                        completed_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ";
                break;
        }
        $update_status = dbq("update jobcard_requisitions set
                                    {$query}
                                    status='{$_POST['status']}',
                                    status_comment='" . htmlentities($_POST['status_comment']) . "'
                                    where request_id={$_POST['request_id']}
                                    ");
        if ($update_status) {
            msg("Status changed!");
            go('dashboard.php?page=job-requisitions');
        } else {
            sqlError('', '');
        }
    }
}
