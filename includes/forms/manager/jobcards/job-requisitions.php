<?php

if (isset($_POST['change_status'])) {
    if (strlen($_POST['status']) > 0) {
        $update_status = dbq("update jobcard_requisitions set
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
