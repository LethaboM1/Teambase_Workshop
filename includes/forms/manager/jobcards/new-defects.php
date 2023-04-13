<?php
if (isset($_POST['report_id'])) {
    if (isset($_POST['reviewed'])) {
        $update_ = dbq("update ws_defect_reports set status='R', comment='{$_POST['comment']}' where id={$_POST['report_id']}");
        ($update_) ? msg('Report has been reviewed.') : sqlError();
    } else if (isset($_POST['create_jobcard'])) {
        $update_ = dbq("update ws_defect_reports set comment='{$_POST['comment']}' where id={$_POST['report_id']}");
        ($update_) ? go("dashboard.php?page=add-job&defect={$_POST['report_id']}") : sqlError();
    }
}
