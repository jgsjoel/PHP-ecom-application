<?php

// require "connection.php";

require '../email/Exception.php';
require '../email/PHPMailer.php';
require '../email/SMTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->IsSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '';
$mail->Password = '';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom('', '');
$mail->addReplyTo('', '');
$mail->addAddress('');
$mail->isHTML(true);
$mail->Subject = 'Your Varifivcation Code';
$bodyContent = '<h1>Code : </h1>';
$mail->Body    = "body";

if (!$mail->send()) {
    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo '1';
}
