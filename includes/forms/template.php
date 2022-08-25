<?php
$roles = array('system', 'manager');
if (!in_array($_SESSION['user']['role'], $roles)) {
    exit();
}

if (isset($_POST['add_user'])) {
}
