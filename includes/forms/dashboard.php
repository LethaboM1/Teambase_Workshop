<?php
if ($_POST['outofoffice'] == 'true') {
    msg("Out of office is true");
    $update = dbq("update users_tbl set out_of_office=1 where user_id={$_SESSION['user']['user_id']}");
    $_SESSION['user']['out_of_office'] = 0;
    go('dashboard.php');
}


if ($_POST['outofoffice'] == 'false') {
    msg("Out of office is true");
    $update = dbq("update users_tbl set out_of_office=0 where user_id={$_SESSION['user']['user_id']}");
    $_SESSION['user']['out_of_office'] = 0;
    go('dashboard.php');
}
