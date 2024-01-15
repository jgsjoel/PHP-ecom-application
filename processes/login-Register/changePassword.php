<?php

require "../connection.php";

$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$email = $_POST["email"];
$code = $_POST["code"];

if ($password1 != $password2) {
    echo "Passwords do not match.";
} elseif (strlen($password1) < 8 || strlen($password1) > 20) {
    echo "Password must have 8 - 20 characters";
} else {

    $res = Database::search("SELECT * FROM `user` WHERE email='" . $email . "' AND `code`='" . $code . "'");

    if ($res->num_rows == 1) {

        Database::iud("UPDATE `user` SET `password`='" . $password1 . "' WHERE `email`='" . $email . "'");
        echo "1";
    } else {
        echo "Invalid email or varification code.";
    }
}
