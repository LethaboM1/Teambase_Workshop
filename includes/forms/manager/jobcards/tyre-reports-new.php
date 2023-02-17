<?php

if (isset($_POST['confirm'])) {
    if (isset($_POST['id'])) {
        $update_report = dbq("update jobcard_tyre_reports set checked_by={$_SESSION['user']['user_id']}, checked='" . date('Y-m-d H:i') . "' where id={$_POST['id']}");
        if ($update_report) {
            $msg[] = "Report checked!";
        } else {
            sqlError();
        }
    } else {
        $error[] = "No id.";
    }
}
