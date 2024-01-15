<?php

session_start();

require "../connection.php";

if(isset($_SESSION['user'])){

    $pid = (int)$_GET["pid"];

    if(isset($pid) && $pid != 0){

        $result = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='".$pid."' AND `user_email`='".$_SESSION["user"]["email"]."' ");

        if($result->num_rows != 0){
            echo "Product already exist in watchlist";
        }else{

            Database::iud("INSERT INTO `watchlist`(`product_id`,`user_email`) VALUES('".$pid."','".$_SESSION["user"]["email"]."')");
            echo "1";
        }

    }else{
        echo "There was an error";
    }

}else{
    echo "3";
}

















?>