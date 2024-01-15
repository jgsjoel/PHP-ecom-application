<?php

require "../connection.php";

$id = (int)$_GET["id"];

if (is_int($id) && $id != 0) {

    $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $id . "'");

    if ($product->num_rows == 1) {

        $product_arr = $product->fetch_assoc();

        if ((int)$product_arr["status_id"] == 1) {
            Database::iud("UPDATE `product` SET `status_id`='2' WHERE `id`='" . $id . "' ");
            echo "2";
        } else {
            Database::iud("UPDATE `product` SET `status_id`='1' WHERE `id`='" . $id . "' ");
            echo "1";
        }
    }
}
