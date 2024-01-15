<?php

session_start();

require "../connection.php";

$email = $_POST["email"];
$code = $_POST["code"];

if (empty($email)) {
    echo "Please enter email";
} elseif (empty($code)) {
    echo "Please enter password";
} else {

    $result = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "' AND `code`='" . $code . "'");

    if ($result->num_rows == 1) {
        $_SESSION["adminSession"] = $result->fetch_assoc();
        echo "1";
    } else {
        echo "Invalid details";
    }
}
