<?php

session_start();

require "../connection.php";

if(isset($_SESSION["user"])){
    
    $productId = (int)$_GET["pid"];

    if(!empty($_GET["pid"])){

        $result = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='" . $productId . "' && `user_email`='".$_SESSION["user"]["email"]."'");

        if ($result->num_rows == 1) {
            Database::iud("DELETE FROM `watchlist` WHERE `product_id`='" . $productId . "' AND `user_email`='" . $_SESSION["user"]["email"] . "'");
            echo "1";
        } else {
            echo "There was an error";
        }

    }else{
        echo "2";
    }

}else{
    echo "2";
}
