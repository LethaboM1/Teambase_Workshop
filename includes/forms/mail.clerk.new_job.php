<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$clerk_ = dbf(dbq("select * from users_tbl where clerk_id={$_POST['clerk_id']}"));
if (strlen($clerk_['email']) > 0) {
    if (!isset($job_id)) {
        $job_id = mysqli_insert_id($db);
    }

    $jobcard_ = dbf(dbq("select * from jobcards wher job_id={$job_id}"));
    $mechanic_ = dbf(dbq("select * from users_tbl where user_id-{$jobcard_['mechanic_id']}"));
    $mail = new PHPMailer(true);


    try {
        $mail->addAddress($clerk_['email'], $clerk_['name'] . ' ' . $clerk_['last_name']);     //Add a recipient                    
        //$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
        $mail->addCC($_SESSION['settings']['requisition_mail']);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "#{$jobcard_['job_id']} - Job card requested";
        $mail->Body    = "
                                <b>Job Card request</b><br>
                                <p>
                                    <b>Date time.</b>&nbsp;" . date("Y-m-d H:i") . "<br>
                                    <b>Job ID.</b>&nbsp;{$jobcard_['job_id']}<br>
                                    <b>Mechanic.</b>&nbsp;{$mechanic_['name']} {$mechanic_['last_name']}<br>
                                    <b>Description.</b>&nbsp;{$jobcard_['fault_description']}<br>
                                    <b>Priority.</b>&nbsp;{$jobcard_['priority']}<br><br>
                                </p>
                                Kind Regards,<br>
                                <b>{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}</b><br>
                                E-mail: {$_SESSION['user']['email']}
                                ";
        $mail->AltBody = "
                                    Job Card request\n\r\n\r
                                    Date time. : " . date("Y-m-d H:i") . "\n\r
                                    Job ID. : {$jobcard_['jobcard_id']}\n\r
                                    Mechanic. : {$mechanic_['name']} {$mechanic_['last_name']}\n\r
                                    Description. : {$jobcard_['fault_description']}\n\r
                                    Priority. : {$jobcard_['priority']}\n\r                                    
                                    \n\r\n\r
                                    Kind Regards,\n\r
                                    {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}\n\r
                                    E-mail: {$_SESSION['user']['email']}
                                    ";

        $mail->send();
        msg('Mail was send to buyer.');
    } catch (Exception $e) {
        error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
