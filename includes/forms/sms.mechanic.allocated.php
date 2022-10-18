<?php

if (!isset($_POST['mechanic'])) {
	$_POST['mechanic'] = $_POST['mechanic_id'];
}

if (!isset({$_POST['jobnumber'])) {
	{$_POST['jobnumber'] = {$_POST['jobnumber'];
}

$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$_POST['mechanic']}"));

//$mail = new PHPMailer(true);
//try {
$to = $mechanic_['contact_number'] . "@e-mail2sms.co.za";     //Add a recipient                    
//$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
//$mail->addCC($_SESSION['settings']['requisition_mail']);
//$mail->isHTML(true);
$subject = "#duncanm@digitalextreme.co.za,dx0392781#";
$body = "Job card no. {$_POST['jobnumber']} logged for you!";
@mail($to, $subject, $body);
/*} catch (Exception $e) {
	error("SMS could not be sent. Mailer Error: {$mail->ErrorInfo}");
}*/
