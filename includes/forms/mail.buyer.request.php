<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (!isset($job_id)) {
    $job_id = mysqli_insert_id($db);
}

$get_buyer = dbq("select * from users_tbl where user_id={$_POST['buyer_id']}");

if ($get_buyer) {
    if (dbr($get_buyer) > 0) {

        $mail = new PHPMailer(true);
        while ($buyer_ = dbf($get_buyer)) {
            $mail->addAddress($buyer_['email'], $buyer_['name'] . ' ' . $buyer_['last_name']);
        }

        $jobcard_ = dbf(dbq("select * from jobcards where job_id={$job_id}"));
        $plant_ = dbf(dbq("select * from plants_tbl where plant_id={$jobcard_['plant_id']}"));
        $mechanic_ = dbf(dbq("select * from users_tbl where user_id={$mechanic_id}"));
        $job_request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$request_id}"));

        //$mail->addAddress($clerk_['email'], $clerk_['name'] . ' ' . $clerk_['last_name']);     //Add a recipient                    
        //$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
        if (strlen($_SESSION['settings']['requisition_mail']) > 0) {
            $mail->addCC($_SESSION['settings']['requisition_mail']);
        }

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "#{$job_request_['request_id']} - Part requested";
        $mail->Body    = "
                                <b>Part Request</b><br>
                                <p>
                                    <b>Date time.</b>&nbsp;" . $job_request_['requested_by_time'] . "<br>
                                    <b>Job Number.</b>&nbsp;{$jobcard_['jobcard_number']}<br>
                                    <b>Plant No.</b>&nbsp;{$plant_['plant_number']}<br>
                                    <b>Fleet No.</b>&nbsp;{$plant_['fleet_number']}<br>
                                    <b>Request ID.</b>&nbsp;{$job_request_['request_id']}<br>
                                    <b>Mechanic.</b>&nbsp;{$mechanic_['name']} {$mechanic_['last_name']}<br>
                                    <b>Part no.</b>&nbsp;{$job_request_['part_number']}<br>
                                    <b>Description</b>&nbsp;{$job_request_['part_description']}<br>
                                    <b>Qty</b>&nbsp;{$job_request_['qty']}<br>
                                    <b>Comment</b>&nbsp;{$job_request_['comment']}<br>
                                </p>
                                Kind Regards,<br>
                                <b>{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}</b><br>
                                E-mail: {$_SESSION['user']['email']}
                                ";
        $mail->AltBody = "
                                    Job Card request\n\r\n\r
                                    Date time.: " . $job_request_['requested_by_time'] . "\n\r
                                    Job Number.: {$jobcard_['jobcard_number']}\n\r
                                    Plant No.:{$plant_['plant_number']}\n\r
                                    Fleet No.:{$plant_['fleet_number']}\n\r
                                    Request ID.: {$job_request_['request_id']}\n\r
                                    Mechanic.: {$mechanic_['name']} {$mechanic_['last_name']}\n\r
                                    Part no.: {$job_request_['part_number']}\n\r
                                    Description: {$job_request_['part_description']}\n\r
                                    Qty: {$job_request_['qty']}\n\r
                                    Comment: {$job_request_['comment']}\n\r                            
                                    \n\r\n\r
                                    Kind Regards,\n\r
                                    {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}\n\r
                                    E-mail: {$_SESSION['user']['email']}
                                    ";

        try {
            $mail->send();
            msg('Mail was send to manager.');
        } catch (Exception $e) {
            error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    } else {
        /* No Buyers */
    }
} else {
    sqlError();
}
