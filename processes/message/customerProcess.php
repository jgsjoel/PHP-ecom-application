<?php

session_start();

require "../connection.php";

$message = $_POST["msg"];

if (!empty($message)) {

    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $dt->setTimestamp($timestamp);
    $dateTime = $dt->format('Y-m-d H:i:s');

    Database::iud("INSERT INTO `messages`(`user_email`,`admin_email`,`sender_id`,`message`,`datetime`) VALUES('" . $_SESSION["user"]["email"] . "','admin@gmail.com','2','" . $message . "','" . $dateTime . "')");
    echo "1";
}
