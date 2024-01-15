<?php

session_start();

require "../connection.php";

if (isset($_SESSION["user"])) {

    $user_details = Database::search("SELECT `city`.`name` AS `city`,`user_address`.`address_line1` AS 
    `address1`,`user_address`.`address_line2` AS `address2`,`district`.`name` AS `district`
    FROM `location` INNER JOIN user_address ON location.id=user_address.location_id INNER JOIN 
    province ON province.id=location.province_id INNER JOIN district ON district.id=location.district_id 
    INNER JOIN city ON city.id=location.city_id 
    WHERE `user_address`.`user_email`='" . $_SESSION["user"]["email"] . "'");

    if ($user_details->num_rows != 0) {

        $user_arr = $user_details->fetch_assoc();

        $code = uniqid();

        $product = Database::search("SELECT `product`.`price` AS `price`,`product`.`name` AS `name`,
        `product`.`id` AS `id`,`cart`.`qty` AS `qty`,`product`.`shipping_in_colombo` AS `sic`,`product`.`shipping_outof_colombo` AS `soc`
     FROM `cart` INNER JOIN `product` ON `product`.`id` =`cart`.`product_id` 
    INNER JOIN `user` ON `user`.`email`=`cart`.`user_email` WHERE `cart`.`user_email`='" . $_SESSION["user"]["email"] . "' AND `product`.`qty` > '0'");

        if ($product->num_rows != 0) {

            $price = 0;
            $items = "";
            $item_count = 0;
            for ($x = 0; $x < $product->num_rows; $x++) {
                $product_arr = $product->fetch_assoc();

                if($user_arr["district"] == "Colombo"){
                    $price = $price + ((int)$product_arr["price"]*(int)$product_arr["qty"])+((int)$product_arr["qty"]* (int)$product_arr["sic"]);
                }else{
                    $price = $price + ((int)$product_arr["price"]*(int)$product_arr["qty"])+((int)$product_arr["qty"]* (int)$product_arr["soc"]);
                }

                $items = $items.", ".$product_arr["name"];
                $item_count = $item_count + 1;
            }

            $order_details_arr = [
                "order_id" => $code,
                "items" => $items,
                "item_count" => $item_count,
                "price" => $price,
                // "first_name" => $_SESSION["user"]["fname"],
                // "last_name" => $_SESSION["user"]["lname"],
                "email" => $_SESSION["user"]["email"],
                // "phone" => $_SESSION["user"]["mobile"],
                // "address" => $user_arr["address1"] . " " . $user_arr["address2"],
                // "city" => $user_arr["city"],
            ];

            echo json_encode($order_details_arr);
        } else {
            echo "There was an error";
        }
    } else {
        echo "There was an error";
    }
} else {

    header("Location: Login.php");
}
