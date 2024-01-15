<?php

class Cart
{

    public static function qtyCheck($pid, $qty)
    {
        $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "' ");
        $product_qty = $product->fetch_assoc();
        if ((int)$product_qty <= $qty) {
            return "1";
        } else {
            return "There was an error";
        }
    }

    public static function qtyUpdate($pid, $qty)
    {
        $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");

        if ($product->num_rows == 0) {
            return "There was an error";
        } else {

            Database::iud("UPDATE `cart` SET `qty`='" . $qty . "' WHERE `product_id`='" . $pid . "' AND `user_email`='" . $_SESSION["user"]["email"] . "' ");

            return "1";
        }
    }

    public static function calculateSummery()
    {

        $products = Database::search("SELECT `product`.`price`,`cart`.`qty`,`product`.`shipping_in_colombo`,
        `product`.`shipping_outof_colombo` FROM `cart` INNER JOIN `product` ON `cart`.`product_id`=`product`.`id`
         WHERE `cart`.`user_email`='" . $_SESSION["user"]["email"] . "'");

        $subTotal = 0;
        $shipping = 0;

 
        if ($products->num_rows != 0) {

            $location = Database::search("SELECT * FROM `user_address` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
            $location_arr = $location->fetch_assoc();
            
            if ($location->num_rows == 1) {

                for ($x = 0; $x < $products->num_rows; $x++) {

                    $product_arr = $products->fetch_assoc();
                    $subTotal = $subTotal + (int)$product_arr["price"] * (int)$product_arr["qty"];

                    $district = Database::search("SELECT * FROM `location` INNER JOIN `district` ON
                `district`.`id`=`location`.`district_id` WHERE 
                `location`.`id`='" . $location_arr["location_id"] . "' AND `district`.`id`='1'
                ");

                    if ($district->num_rows == 1) {
                        $shipping = $shipping + (int)$product_arr["shipping_in_colombo"] * (int)$product_arr["qty"];
                    } else {
                        $shipping = $shipping + (int)$product_arr["shipping_outof_colombo"] * (int)$product_arr["qty"];
                    }
                }

                $arr = array("status" => "1", "EstmTotal" => number_format($subTotal + $shipping,2), "subtotal" => number_format($subTotal,2), "shipping" => number_format($shipping,2));
                return json_encode($arr);
            } else {
                $arr = array("status" => "2", "EstmTotal" => "N/A", "subtotal" => "N/A", "shipping" => "N/A");
                return json_encode($arr);
            }
        } else {

            $arr = array("status" => "3", "EstmTotal" => "N/A", "subtotal" => "N/A", "shipping" => "N/A");
            return json_encode($arr);
        }
    }

    public static function deleteFromCart($pid)
    {

        $result = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["user"]["email"] . "' AND `product_id`='" . $pid . "'");

        if ($result->num_rows != 1) {
            return "There was an error";
        } else {
            Database::iud("DELETE FROM `cart` WHERE `user_email`='" . $_SESSION["user"]["email"] . "' AND `product_id`='" . $pid . "'");
            return "1";
        }
    }
}
