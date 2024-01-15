<?php

require "connection.php";


$category = (int)$_POST["category"];
$brand = (int)$_POST["brand"];
$model = (int)$_POST["model"];
$name = $_POST["name"];
$price = $_POST["price"];
$qty = (int)$_POST["qty"];
$color = (int)$_POST["color"];
$shipping1 = $_POST["shipping1"];
$shipping2 = $_POST["shipping2"];
$description = $_POST["description"];
$condition  = (int)$_POST["condition"];

if ($category == 0) {
    echo "Please select a category";
} else if ($brand == 0) {
    echo "Please select a brand";
} else if ($model == 0) {
    echo "Please select a model";
} else if (empty($name)) {
    echo "Please enter product name";
} else if (empty($price)) {
    echo "Please enter product unit price";
} else if (empty($qty)) {
    echo "Please enter product quantity";
} else if ($color == 0) {
    echo "Please select a color";
} else if ($condition == 0) {
    echo "Please select a condition";
} else if (empty($shipping1)) {
    echo "Please enter shipping price 01";
} else if (empty($shipping2)) {
    echo "Please enter shipping price 02";
} else if (empty($description)) {
    echo "Please enter description";
} else if (empty($_FILES["img1"])) {
    echo "Please select picture 01";
} else if (empty($_FILES["img2"])) {
    echo "Please select picture 02";
} else if (empty($_FILES["img3"])) {
    echo "Please select picture 03";
} else {

    $category_result = Database::search("SELECT * FROM `category` WHERE `id`='" . $category . "'");
    $model_result = Database::search("SELECT * FROM `model` WHERE `id`='" . $model . "'");
    $brand_result = Database::search("SELECT * FROM `brand` WHERE `id`='" . $brand . "'");
    $condition_result = Database::search("SELECT * FROM `condition` WHERE `id`='" . $condition . "'");

    if ($category_result->num_rows != 1) {
        echo "Please select category";
    } else if ($model_result->num_rows != 1) {
        echo "Please select model";
    } else if ($brand_result->num_rows != 1) {
        echo "Please select brand";
    } else if ($condition_result->num_rows != 1) {
        echo "Please select condition";
    } else {

        $model_has_brand_result = Database::search("SELECT * FROM `model_has_brand` WHERE `model_id`='" . $model . "' AND `brand_id`='" . $brand . "'");

        if ($model_has_brand_result->num_rows != 1) {
            echo "The selected model doesn't match brand.";
        } else {
            $mhb_arr = $model_has_brand_result->fetch_assoc();

            $productCheck_result = Database::search("SELECT * FROM `product` WHERE `condition_id`='" . $condition . "' AND `color_id`='" . $color . "' AND `category_id`='" . $category . "' AND `model_has_brand_id`='" . $mhb_arr["id"] . "' AND `price`='" . $price . "' AND `name`='" . $name . "'  ");

            if ($productCheck_result->num_rows != 0) {
                echo "This product already exist.";
            } else {

                $uid = uniqid();

                // Database::iud("INSERT INTO `product`(`name`,`price`,`qty`,`condition_id`,`category_id`,`model_has_brand_id`,
                // `color_id`,`shipping_in_colombo`,`shipping_outof_colombo`,`description`,`uid`) VALUES('".$name."' ,
                //  '".$price."','".$qty."','".$condition."','".$category."','".$mhb_arr["id"]."','".$color."',
                //  '".$shipping1."','".$shipping2."','".$description."','".$uid."')");

                Database::iud("INSERT INTO `product`(`name`,`price`,`qty`,`condition_id`,`category_id`,`model_has_brand_id`,
                `color_id`,`shipping_in_colombo`,`shipping_outof_colombo`,`description`,`uid`) VALUES('".$name."' ,
                 '".$price."','".$qty."','".$condition."','".$category."','".$mhb_arr["id"]."','".$color."',
                 '".$shipping1."','".$shipping2."','".$description."','".$uid."')");

                $img_arr = array("image/png", "image/svg", "image/jpg", "image/jpeg");

                $product_result = Database::search("SELECT * FROM `product` WHERE `uid`='" . $uid . "'");
                $product_arr = $product_result->fetch_assoc();

                // echo $product_arr["id"];


                for ($x = 1; $x <= 3; $x++) {

                    if (!in_array($_FILES["img" . $x]["type"], $img_arr)) {
                        echo "The type selected for image " . $x . " is Invalid";
                        break;
                    } else {

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

                        Database::iud("INSERT INTO `product_images`(`code`,`product_id`) VALUES('" . $new_file_name . "','" . $product_arr["id"] . "')");
                    }
                }
                echo "1";
            }
        }
    }
}
