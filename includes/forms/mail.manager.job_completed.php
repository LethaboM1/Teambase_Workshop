<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

if (!$testserver) {
    if (!isset($job_id)) {
        $job_id = mysqli_insert_id($db);
    }
    $get_managers = dbq("select * from users_tbl where role='manager' and depart='workshop");
    if ($get_managers) {
        if (dbr($get_managers) > 0) {

            $mail = new PHPMailer(true);
            while ($manager = dbf($get_managers)) {
                $mail->addAddress($manager['email'], $manager['name'] . ' ' . $manager['last_name']);
            }

            $jobcard_ = dbf(dbq("select * from jobcards where job_id={$job_id}"));
            $mechanic_ = dbf(dbq("select * from users_tbl where user_id={$mechanic_id}"));

            //$mail->addAddress($clerk_['email'], $clerk_['name'] . ' ' . $clerk_['last_name']);     //Add a recipient                    
            //$mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
            if (strlen($_SESSION['settings']['requisition_mail']) > 0) {
                $mail->addCC($_SESSION['settings']['requisition_mail']);
            }

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = "#{$jobcard_['jobcard_number']} - Job Card Completed";
            $mail->Body    = "
                                <b>Job Card Completed</b><br>
                                <p>
                                    <b>Job Number.</b>&nbsp;{$jobcard_['jobcard_number']}<br>
                                    <b>Date time.</b>&nbsp;" . $jobcard_['complete_datetime'] . "<br>
                                    <b>Mechanic.</b>&nbsp;{$mechanic_['name']} {$mechanic_['last_name']}<br>
                                    <b>Description</b>&nbsp;{$jobcard_['fault_description']}<br>
                                </p>
                                Kind Regards,<br>
                                <b>{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}</b><br>
                                E-mail: {$_SESSION['user']['email']}
                                ";
            $mail->AltBody = "
                                    Job Card request\n\r\n\r
                                    Job Number.: {$jobcard_['jobcard_number']}\n\r
                                    Date time.: " . $jobcard_['complete_datetime'] . "\n\r
                                    Mechanic.: {$mechanic_['name']} {$mechanic_['last_name']}\n\r
                                    Description: {$jobcard_['fault_description']}\n\r       
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
            /* No Managers */
        }
    } else {
        sqlError();
    }
}
