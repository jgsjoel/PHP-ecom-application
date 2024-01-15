<?php

session_start();

require "../connection.php";

if (isset($_SESSION["user"])) {

    $pid = $_GET["pid"];
    $qty = (int)$_GET["qty"];

    $result = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "' ");

    if ($result->num_rows != 0) {

        $product = $result->fetch_assoc();

        if ((int)$qty <= (int)$product["qty"] && $qty > 0) {

            $user_details = Database::search("SELECT `city`.`name` AS `city`,`user_address`.`address_line1` AS 
            `address1`,`user_address`.`address_line2` AS `address2`,`district`.`name` AS `district`
             FROM location INNER JOIN user_address ON location.id=user_address.location_id INNER JOIN 
            province ON province.id=location.province_id INNER JOIN district ON district.id=location.district_id 
            INNER JOIN city ON city.id=location.city_id 
              WHERE `user_address`.`user_email`='" . $_SESSION["user"]["email"] . "'");

            if ($user_details->num_rows != 0) {

                $user_arr = $user_details->fetch_assoc();

                $code = uniqid();

                $price = 0;
                if ($user_arr["district"] == "Colombo") {
                    $price = $price + ((int)$product["price"]) +((int)$product["shipping_in_colombo"]);
                } else {
                    $price = $price + ((int)$product["price"]) +((int)$product["shipping_outof_colombo"]);
                }
                $order = base64_encode($_SESSION["user"]["email"] . "_" . $code . "_" . $product["id"]);
                
                $order_details_arr = [
                    "order_id" => $code,
                    "name" => $product["name"],
                    "price" => $price,
                    "email" => $_SESSION["user"]["email"],
                    "product_id"=>$product["id"],
                    "qty"=>$qty,
                    // "order_id" => $code,
                    // "name" => $product["name"],
                    // "price" => $price,
                    // "first_name" => $_SESSION["user"]["fname"],
                    // "last_name" => $_SESSION["user"]["lname"],
                    // "phone" => $_SESSION["user"]["mobile"],
                    // "address" => $user_arr["address1"] . " " . $user_arr["address2"],
                    // "city" => $user_arr["city"],
                    // "hash"=> strtoupper(md5("1221542".$order.$price.'LKR'.strtoupper(md5('MjkzMjY1NDU0NzM4NTQ2NTg2ODg3NTk1MjcwODA0MDUzNjY5MDIw'))))

                ];

                echo json_encode($order_details_arr);
            } else {
                echo "Please update your location details";
            }
        } else {
            echo "Please select a less quantity";
        }
    } else {
        echo "There was an error";
    }
} else {
    echo "3";
}
