<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

if (isset($_POST['change_status'])) {
    if (strlen($_POST['status']) > 0) {
        $query = "";
        $request_ = dbf(dbq("select * from jobcard_requisitions where request_id={$_POST['request_id']}"));
        switch ($_POST['status']) {
            case 'approved':
                $query = "
                        approved_by={$_SESSION['user']['user_id']},
                        approved_by_time='" . date("Y-m-d\TH:i:s") . "',
                        approved_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'ordered':
                $query = "
                        ordered_by={$_SESSION['user']['user_id']},
                        ordered_by_time='" . date("Y-m-d\TH:i:s") . "',
                        ordered_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'received':
                $query = "
                        received_by={$_SESSION['user']['user_id']},
                        received_by_time='" . date("Y-m-d\TH:i:s") . "',
                        received_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'completed':
                $query = "
                        completed_by={$_SESSION['user']['user_id']},
                        completed_by_time='" . date("Y-m-d\TH:i:s") . "',
                        completed_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'canceled':
                $query = "
                        canceled_by={$_SESSION['user']['user_id']},
                        canceled_by_time='" . date("Y-m-d\TH:i:s") . "',
                        canceled_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;

            case 'denied':
                $query = "
                        denied_by={$_SESSION['user']['user_id']},
                        denied_by_time='" . date("Y-m-d\TH:i:s") . "',
                        denied_by_comment='" . htmlentities($_POST['status_comment']) . "',
                        ";
                break;
        }



        $update_status = dbq("update jobcard_requisitions set
                                    {$query}
                                    status='{$_POST['status']}'
                                    where request_id={$_POST['request_id']}
                                    ");
        if ($update_status) {
            msg("Status changed!");

            $mail = new PHPMailer(true);


            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                //$mail->isSMTP();                                            //Send using SMTP
                //$mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                //$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                //$mail->Username   = 'user@example.com';                     //SMTP username
                //$mail->Password   = 'secret';                               //SMTP password
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                //$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
                $mail->addAddress($_SESSION['settings']['requisition_mail']);     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
                $mail->addCC($_SESSION['user']['email'], $_SESSION['name'] . ' ' . $_SESSION['user']['last_name']);
                // $mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Part Requisition';
                $mail->Body    = "
                                <b>Part Requisition</b><br>
                                <p>
                                    <b>Request ID.</b>&nbsp;{$request_['request_id']}<br>
                                    <b>Part No.</b>&nbsp;{$request_['part_number']}<br>
                                    <b>Part Description.</b>&nbsp;{$request_['part_number']}<br>
                                    <b>Qty.</b>&nbsp;{$request_['part_number']}<br>
                                    <b>Comment</b><br>
                                    {$request_['approved_by_comment']}
                                </p>
                                Kind Regards,<br>
                                <b>{$_SESSION['user']['name']} {$_SESSION['user']['last_name']}</b><br>
                                E-mail: {$_SESSION['user']['email']}
                                ";
                $mail->AltBody = "
                                    Part Requisition\n\r\n\r
                                    Request ID. : {$request_['request_id']}\n\r
                                    Part No. : {$request_['part_number']}\n\r
                                    Part Description. : {$request_['part_number']}\n\r
                                    Qty. : {$request_['part_number']}\n\r
                                    Comment</b>\n\r
                                        {$request_['approved_by_comment']}
                                    \n\r\n\r
                                    Kind Regards,\n\r
                                    {$_SESSION['user']['name']} {$_SESSION['user']['last_name']}\n\r
                                    E-mail: {$_SESSION['user']['email']}
                                    ";

                $mail->send();
                msg('Mail was send to buyer.');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            go('dashboard.php?page=job-requisitions');
        } else {
            sqlError('', '');
        }
    }
}
