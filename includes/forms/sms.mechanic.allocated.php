<?php

if (!isset($_POST['mechanic'])) {
	$_POST['mechanic'] = $_POST['mechanic_id'];
}

if (!isset($_POST['jobnumber'])) {
	$_POST['jobnumber'] = $_POST['jobcard_number'];
}

$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$_POST['mechanic']}"));

$message = "Job card no. {$_POST['jobnumber']} logged for you!";

sms_($mechanic_['contact_number'], $message);
