<?php

require "../connection.php";

$email = $_GET["email"];

if (empty($email)) {
    echo "Please enter your Email";
} else {

    $res = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

    if ($res->num_rows == 1) {

        $arr = $res->fetch_assoc();

        require '../email/Exception.php';
        require '../email/PHPMailer.php';
        require '../email/SMTP.php';

        $code = uniqid();

        Database::iud("UPDATE `user` SET `code`='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('', '');
        $mail->addReplyTo($email, $arr["fname"]);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Varification Code';
        $bodyContent = '<h1>Please use this code: '.$code.' </h1>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo '1';
        }
    } else {
        echo "Invalid User";
    }
}
