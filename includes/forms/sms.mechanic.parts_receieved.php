<?php

if (!isset($_POST['mechanic'])) {
    $_POST['mechanic'] = $_POST['mechanic_id'];
}


$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$_POST['mechanic']}"));
$jobcard_ = dbf(dbq("select * from jobcards where job_id={$_POST['jobnumber']}"));
//$mail = new PHPMailer(true);
//try {
$to = $mechanic_['contact_number'] . "@e-mail2sms.co.za";
$subject = "#duncanm@digitalextreme.co.za,dx0392781#";
$body = "Part {$job_request_['part_number']} receieved,#{$jobcard_['jobcard_number']},{$job_request_['received_by_comment']}";
@mail($to, $subject, $body);
/*} catch (Exception $e) {
	error("SMS could not be sent. Mailer Error: {$mail->ErrorInfo}");
}*/
