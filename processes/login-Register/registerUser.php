<?php

require "../connection.php";

if (empty($_POST["fname"])) {
    echo "Please enter first name";
}else if(!preg_match('/^[A-Za-z]+$/', $_POST["fname"])){
    echo "First name can only contain alphabets";
} else if (empty($_POST["lname"])) {
    echo "Please enter last name";
}else if(!preg_match('/^[A-Za-z]+$/', $_POST["lname"])){
    echo "Last name can only contain alphabets";
} else if (empty($_POST["email"])) {
    echo "Please enter email";
} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
} else if (empty($_POST["password1"])) {
    echo "Please enter first password";
} else if (empty($_POST["password2"])) {
    echo "Please enter second password";
} else if (strlen($_POST["password2"]) < 8 || strlen($_POST["password2"]) > 25) {
    echo "Password should be between 8 and 25 characters.";
} else if (strlen($_POST["password1"]) < 8 || strlen($_POST["password1"]) > 25) {
    echo "Password should be between 8 and 25 characters.";
} else if ($_POST["password1"] != $_POST["password2"]) {
    echo "Password 01 and 02 dos not match.";
} else {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $password1 = $_POST["password1"];
    $password2 = $_POST["password2"];

    $result = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('Asia/Colombo'));
    $dt->setTimestamp($timestamp);
    $dateTime = $dt->format('Y-m-d H:i:s');

    if ($result->num_rows == 1) {
        echo "Enail is already taken.";
    } else {
        Database::iud("INSERT INTO `user`(`email`,`fname`,`lname`,`password`,`register_datetime`) VALUES('" . $email . "','" . $fname . "','" . $lname . "','" . $password1 . "','".$dateTime."')");
        echo "1";
    }
}
