<?php
 
session_start();

require "../connection.php";
require "cart.class.php";

// quantity update

if(isset($_POST["pid"]) && isset($_POST["qty"])){

    $msg = Cart::qtyCheck($_POST["pid"],$_POST["qty"]);

    if($msg == "1"){
        $status = Cart::qtyUpdate($_POST["pid"],$_POST["qty"]);
        if($status == "1"){
            // Cart::calculateSummery();
            echo "1";
        }else{
            echo $status;
        }
    }else{
        echo $msg;
    }

}else if(isset($_GET["pid"])){//delete from cart

    echo Cart::deleteFromCart($_GET["pid"]);

}else{
    echo "There was an error";
}

 






?>