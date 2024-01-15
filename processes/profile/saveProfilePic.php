<?php

session_start();

require "../connection.php";

$image = $_FILES["img"];

if (empty($image)) {
    echo "Please select an image";
} else {

    $img_arr = array("image/png", "image/svg", "image/jpg", "image/jpeg");

    if (!in_array($_FILES["img"]["type"], $img_arr)) {
        echo "The type selected is Invalid";
        exit;
    } else {

        $new_image_extention;
        if ($_FILES["img"]["type"] == "image/jpeg") {
            $new_image_extention = ".jpg";
        } elseif ($_FILES["img"]["type"] == "image/png") {
            $new_image_extention = ".png";
        } elseif ($_FILES["img"]["type"] == "image/svg") {
            $new_image_extention = ".svg";
        }

        $new_file_name = "profilePics//" . uniqid() . $new_image_extention;

        move_uploaded_file($_FILES["img"]["tmp_name"], $new_file_name);

        $profile_image = Database::search("SELECT * FROM `profile_images` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");

        if ($profile_image->num_rows == 0) {
            Database::iud("INSERT INTO `profile_images`(`code`,`user_email`) VALUES('" . $new_file_name . "','" . $_SESSION["user"]["email"] . "')");
            echo "1";
        } else {
            Database::iud("UPDATE `profile_images` SET `code`='" . $new_file_name . "' WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
            echo "1";
        }
    }
}
