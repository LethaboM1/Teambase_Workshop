<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mechanic_ = dbf(dbq("select * from users_tbl where user_id={$_POST['mechanic']}"));

$mail = new PHPMailer(true);
try {
	$mail->addAddress($mechanic_['contact_number'] . "@e-mail2sms.co.za");     //Add a recipient                    
	//$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
	$mail->addCC($_SESSION['settings']['requisition_mail']);
	$mail->isHTML(false);
	$mail->Subject = "#duncanm@digitalextreme.co.za,dx0392781#";
	$mail->Body = "Job card no. {$_POST['jobnumber']} logged for you!";
	$mail->send();
} catch (Exception $e) {
	error("SMS could not be sent. Mailer Error: {$mail->ErrorInfo}");
}
