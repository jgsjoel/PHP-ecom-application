<?php

require "../connection.php";

session_start();

if (isset($_SESSION["user"])) {

    $product_id = (int)$_GET["pid"];

    $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $product_id . "'");

    if ($product->num_rows == 1) {

        $cart = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_id . "' AND `user_email`='".$_SESSION['user']['email']."'");

        if ($cart->num_rows == 0) {

            Database::iud("INSERT INTO `cart` (`product_id`,`user_email`) VALUES('" . $product_id . "','" . $_SESSION["user"]["email"] . "')");

            echo "1";
        }else{
            echo "This product has already been added.";
        }
    } else {
        echo "2";
    }
} else {
echo "3";
}






















?>