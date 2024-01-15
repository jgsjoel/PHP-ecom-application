<?php

session_start();

require "../connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$district = (int)$_POST["district"];
$province = (int)$_POST["province"];
$city = (int)$_POST["city"];
$mobile = $_POST["mobile"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];

if (empty($fname)) {
    echo "Please enter first name";
} else if (empty($lname)) {
    echo "Please enter last name";
} else if (empty($mobile)) {
    echo "Please enter mobile";
} else if ($province == 0) {
    echo "Please select Province";
} else if ($district == 0) {
    echo "Please select district";
}else if ($city == 0) {
    echo "Please select city";
} else if (empty($address1)) {
    echo "Please enter address 01";
} else if (empty($address2)) {
    echo "Please enter address 02";
} else {

    Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $fname . "',`mobile`='" . $mobile . "' WHERE `email`='" . $_SESSION["user"]["email"] . "'");

    $user_address = Database::search("SELECT * FROM `user_address` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");

    $location = Database::search("SELECT * FROM `location` WHERE `province_id`='" . $province . "' AND `district_id`='" . $district . "' AND `city_id`='".$city."'");

    if ($location->num_rows != 1) {
        echo "Invalid district or city for selected province.";
    } else {
        
        $location_arr = $location->fetch_assoc();

        if ($user_address->num_rows == 1) {


            Database::iud("UPDATE `user_address` SET `location_id`='" . $location_arr["id"] . "',`address_line1`='" . $address1 . "',`address_line2`='" . $address2 . "' WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
            
            $user_result = Database::search("SELECT * FROM `user` WHERE `email`='".$_SESSION["user"]["email"]."'");
            $_SESSION["user"] = $user_result->fetch_assoc();

            echo "1";

        } else {
            Database::iud("INSERT INTO `user_address`(`location_id`,`address_line1`,`address_line2`,`user_email`) VALUES('" . $location_arr["id"] . "','" . $address1 . "','" . $address2 . "','" . $_SESSION["user"]["email"] . "')");
            
            $user_result = Database::search("SELECT * FROM `user` WHERE `email`='".$_SESSION["user"]["email"]."'");
            $_SESSION["user"] = $user_result->fetch_assoc();

            echo "1";

        }
    }
}
