<?php

include '../public.class.php';

class Watchlist
{

    public static $Watchlist_Products;

    public static function validateInput($pid)
    {
        if ((int)$pid != 0) {
            return Watchlist::validateId($pid);
        } else {
            return "There was an error";
        }
    }

    public static function validateId($pid)
    {

        $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");

        if ($product->num_rows == 1) {
            return Watchlist::checkIfAdded($pid);
        } else {
            return "There was an error";
        }
    }

    public static function checkIfAdded($pid)
    {
        $Watchlist = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='" . $pid . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'   ");

        if ($Watchlist->num_rows == 0) {
            return Watchlist::add($pid);
        } else {
            return "This product has already been added.";
        }
    }

    public static function add($pid)
    {

        Database::iud("INSERT INTO `watchlist`(`product_id`,`user_email`) VALUES('" . $pid . "','" . $_SESSION["user"]["email"] . "')");
        return "1";
    }

    public static function loadWatchlist($offset)
    {

        $watchlist = Database::search("SELECT `product`.`id`,`product`.`name`,`product`.`price`,`product`.`qty`,`condition`.`name` AS `condition`
        FROM `watchlist` INNER JOIN `product` ON `product`.`id`=`watchlist`.`product_id` INNER JOIN 
       `condition` ON `condition`.`id`=`product`.`condition_id` WHERE `watchlist`.`user_email`='" . $_SESSION["user"]["email"] . "'
       LIMIT 3 OFFSET $offset");

        for ($x = 0; $x < $watchlist->num_rows; $x++) {
            $watchlist_arr = $watchlist->fetch_assoc();

            $image = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $watchlist_arr["id"] . "'");
            $image_arr = $image->fetch_assoc();

            $arr = array(
                "name" => $watchlist_arr["name"],
                "qty" => $watchlist_arr["qty"],
                "id" => $watchlist_arr["id"],
                "price" => $watchlist_arr["price"],
                "condition" => $watchlist_arr["condition"],
                "image_code" => $image_arr["code"]
            );

            Watchlist::$Watchlist_Products[$x] = $arr;
        }

        return json_encode(Watchlist::$Watchlist_Products);
    }

    public static function pagination()
    {

        $watchlist = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");

        return Common::getButtonCount($watchlist->num_rows, 3);
    }
}



?>