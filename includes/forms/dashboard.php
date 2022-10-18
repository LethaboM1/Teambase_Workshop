<?php
if ($_GET['outofoffice'] == true) {
    $update = dbq("update users_tbl set out_of_office=1 where user_id={$_SESSION['user']['user_id']}");
}


if ($_GET['outofoffice'] == false) {
    $update = dbq("update users_tbl set out_of_office=0 where user_id={$_SESSION['user']['user_id']}");
}
