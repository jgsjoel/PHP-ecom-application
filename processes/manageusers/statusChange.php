<?php

session_start();

require "../connection.php";

if(isset($_SESSION["admin"])){

$result = Database::search("SELECT * FROM `user` WHERE `email`='".$_GET["email"]."'");

if($result->num_rows !=0){

    $user = $result->fetch_assoc();
    if($user["status_id"] == "1"){
        Database::iud("UPDATE `user` SET `status_id`='2' WHERE `email`='".$_GET["email"]."'");
        echo "1";
    }else{
        Database::iud("UPDATE `user` SET `status_id`='1'  WHERE `email`='".$_GET["email"]."'");
        echo "2";
    }

}

}else{
    header("Location: adminLogin.php");
}









?>