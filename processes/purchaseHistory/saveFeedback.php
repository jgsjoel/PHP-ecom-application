<?php

session_start();
require "../connection.php";

$arr = array("email" => "joel@gmail.com");
$_SESSION["user"] = $arr;

if (isset($_SESSION["user"]) && isset($_POST["feedback"]) && isset($_POST["pid"])) {

    $message = $_POST["feedback"];

    if (empty($message)) {
        echo "Please enter your message.";
    } else {


        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone('Asia/Colombo'));
        $dt->setTimestamp($timestamp);
        $dateTime = $dt->format('Y-m-d H:i:s');

        Database::iud("INSERT INTO `product_feedback`(`product_id`,`datetime`,`user_email`,`message`) VALUES('" . $_POST["pid"] . "','" . $dateTime . "','" . $_SESSION["user"]["email"] . "','" . $message . "')");
        echo "1";
    }
} else {
    header('Location: ../../singleProductView.php');
}
