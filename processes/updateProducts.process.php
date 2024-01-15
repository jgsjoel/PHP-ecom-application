<?php

require "connection.php";

$product_id = (int)$_POST["proId"];
$name = $_POST["name"];
$price = (int)$_POST["price"];
$qty = (int)$_POST["qty"];
$shipping1 = (int)$_POST["shipping1"];
$shipping2 = (int)$_POST["shipping2"];
$description = $_POST["description"];

if (empty($product_id) || $product_id == 0) {
    echo "there was an error";
} elseif (empty($name)) {
    echo "Please enter product name";
} else if (empty($price)) {
    echo "Please enter product unit price";
}else if (empty($qty)) {
    echo "Please enter product quantity";
} else if (empty($shipping1)) {
    echo "Please enter shipping price 01";
} else if (empty($shipping2)) {
    echo "Please enter shipping price 02";
} else if (empty($description)) {
    echo "Please enter description";
} else {

    Database::iud("UPDATE `product` SET `name`='" . $name . "',`price`='" . $price . "',`qty`='" . $qty . "',`shipping_in_colombo`='" . $shipping1 . "',`shipping_outof_colombo`='" . $shipping2 . "',`description`='" . $description . "' WHERE `id`='" . $product_id . "' ");

    $img_arr = array("image/png", "image/svg", "image/jpg", "image/jpeg");

    $result = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $product_id . "'");

    if (!empty($_FILES["img1"]) && empty($_FILES["img2"]) && empty($_FILES["img3"]) || empty($_FILES["img1"]) && !empty($_FILES["img2"]) && empty($_FILES["img3"]) || empty($_FILES["img1"]) && empty($_FILES["img2"]) && !empty($_FILES["img3"])) {
        echo "Please select 3 images";
    } elseif (!empty($_FILES["img1"]) && !empty($_FILES["img2"]) && !empty($_FILES["img3"])) {

        for ($x = 1; $x <= $result->num_rows; $x++) {

            if (!in_array($_FILES["img" . $x]["type"], $img_arr)) {
                echo "The type selected for image " . $x . " is Invalid";
                break;
            } else {

                $image_arr = $result->fetch_assoc();

                $new_image_extention;
                if ($_FILES["img" . $x]["type"] == "image/jpeg") {
                    $new_image_extention = ".jpg";
                } elseif ($_FILES["img" . $x]["type"] == "image/png") {
                    $new_image_extention = ".png";
                } elseif ($_FILES["img" . $x]["type"] == "image/svg") {
                    $new_image_extention = ".svg";
                }

                $new_file_name = "productImages//" . uniqid() . $new_image_extention;

                move_uploaded_file($_FILES["img" . $x]["tmp_name"], $new_file_name);

                Database::iud("UPDATE `product_images` SET `code`='" . $new_file_name . "' WHERE `id'='" . $image_arr["id"] . "' ");
            }
        }
    }

    echo "1";
}
