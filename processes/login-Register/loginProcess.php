<?php

session_start();

require "../connection.php";

if (empty($_POST["email"])) {
    echo "Please enter email.";
} else if (empty($_POST["password"])) {
    echo "Please enter password";
} else {
 
    $email = $_POST["email"];
    $password = $_POST["password"];
    $ischecked = $_POST["ischecked"];

    $result = Database::search("SELECT * FROM user WHERE email='" . $email . "' AND password='" . $password . "' ");
    if ($result->num_rows == 0) {
        echo "Invalid User";
    } else {

        if ($ischecked == "true") {
            setcookie("email", $email, time() + (60 * 60 * 24 * 365),"/");
            setcookie("password", $password, time() + (60 * 60 * 24 * 365), "/");
        } else {
            setcookie("email", "", time() - 1,"/");
            setcookie("password", "", time() - 1,"/");
        }

        $array = $result->fetch_assoc();

        $_SESSION["user"] = $array;
        echo "1";
    }
}
