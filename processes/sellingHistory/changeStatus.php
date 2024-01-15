<?php
session_start();

require "../connection.php";

if (isset($_POST["oid"]) && isset($_POST["status"]) && isset($_SESSION["adminSession"])) {
    if ((int)$_POST["status"] >= 1 && (int)$_POST["status"] <= 5) {
        Database::iud("UPDATE `purchase_history` SET `order_status_id`='".$_POST["status"]."' WHERE `orderId`='" . $_POST["oid"] . "'");
        echo "1";
    } else {
        echo "There was an error";
    }
}
