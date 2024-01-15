<?php

session_start();

require "processes/connection.php";

if (isset($_SESSION["user"])) {

    $user = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["user"]["email"] . "'");
    $user_arr = $user->fetch_assoc();

    $location = Database::search("SELECT `user_address`.`address_line1`,`user_address`.`address_line2`,`district`.`name` AS `district`,`province`.`name`
    AS `province`,`city`.`name` AS `city` FROM `location` INNER JOIN `user_address` ON 
    `user_address`.`location_id`=`location`.`id` INNER JOIN `province` ON 
    `province`.`id`=`location`.`province_id` INNER JOIN `district` ON 
    `district`.`id`=`location`.`district_id` INNER JOIN `city` ON `city`.`id`=`location`.`city_id` WHERE `user_address`.`user_email`='" . $_SESSION["user"]["email"] . "'");

    $location_arr;
    if ($location->num_rows != 0) {
        $location_arr = $location->fetch_assoc();
    } else {
        $location_arr = array("province" => "", "district" => "", "address_line1" => "", "address_line2" => "");
    }

    $provinces = Database::search("SELECT * FROM `province`");

    $cities = Database::search("SELECT * FROM `city`");

    $districts = Database::search("SELECT * FROM `district`");

    $profiePic = Database::search("SELECT * FROM `profile_images` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");

    $img;
    if ($profiePic->num_rows == 1) {
        $img_arr = $profiePic->fetch_assoc();
        $img = $img_arr["code"];
    } else {
        $img = "profilePics/172626_user_male_icon.png";
    }

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Account</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php require "header.php" ?>

                <div class="col-12 text-center p-4">
                    <h2 class="fw-bold">My Account</h2>
                    <div class="float-end">
                        <button class="btn" id="openChat" >Chat</button>
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 col-md-4 border border-bottom-0 border-end-1 border-start-0 border-top-0">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="processes/profile/<?= $img ?>" id="img" width="200px" height="200px" class="border border-1 border-dark rounded-circle" style="object-fit: cover;">
                                </div>
                                <div class="col-12 text-center mt-2">
                                    <label id="changeBtn" for="profilePic" class="btn btn-dark">Change</label>
                                    <input type="file" id="profilePic" class="d-none" type="text">
                                    <button id="saveBtn" class="btn btn-secondary d-none">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">First Name</label>
                                    <input id="fname" class="form-control" type="text" value="<?= $user_arr["fname"] ?>" disabled>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">Last Name</label>
                                    <input id="lname" class="form-control" type="text" value="<?= $user_arr["lname"] ?>" disabled>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">Email</label>
                                    <input id="email" class="form-control" type="text" value="<?= $user_arr["email"] ?>" disabled>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">Password</label>
                                    <input id="password" class="form-control" type="text" value="<?= $user_arr["password"] ?>" disabled>
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <label class="fw-bold form-label">Mobile</label>
                                    <input id="mobile" class="form-control" type="text" value="<?= $user_arr["mobile"] ?>" disabled>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">Province</label>
                                    <select id="province" class="form-select" disabled>
                                        <option value="0">Please select province</option>
                                        <?php
                                        for ($x = 0; $x < $provinces->num_rows; $x++) {
                                            $province_arr = $provinces->fetch_assoc();
                                            if ($location_arr["province"] == $province_arr["name"]) {
                                        ?>
                                                <option value="<?= $province_arr["id"] ?>" selected><?= $province_arr["name"] ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?= $province_arr["id"] ?>"><?= $province_arr["name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">District</label>
                                    <select id="district" class="form-select" disabled>
                                        <option value="0">Please select district</option>
                                        <?php
                                        for ($x = 0; $x < $districts->num_rows; $x++) {
                                            $district_arr = $districts->fetch_assoc();

                                            if ($location_arr["district"] == $district_arr["name"]) {

                                        ?>
                                                <option value="<?= $district_arr["id"] ?>" selected><?= $district_arr["name"] ?></option>
                                            <?php

                                            } else {
                                            ?>
                                                <option value="<?= $district_arr["id"] ?>"><?= $district_arr["name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="fw-bold form-label">City</label>
                                    <select id="city" class="form-select" disabled>
                                        <option value="0">Please select City</option>
                                        <?php
                                        for ($x = 0; $x < $cities->num_rows; $x++) {
                                            $city_arr = $cities->fetch_assoc();

                                            if ($location_arr["city"] == $city_arr["name"]) {

                                        ?>
                                                <option value="<?= $city_arr["id"] ?>" selected><?= $city_arr["name"] ?></option>
                                            <?php

                                            } else {
                                            ?>
                                                <option value="<?= $city_arr["id"] ?>"><?= $city_arr["name"] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="fw-bold form-label">Address Line 1</label>
                                    <input id="address1" class="form-control" type="text" value="<?= $location_arr["address_line1"] ?>" disabled>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="fw-bold form-label">Address Line 2</label>
                                    <input id="address2" class="form-control" type="text" value="<?= $location_arr["address_line2"] ?>" disabled>
                                </div>
                                <div class="col-12 text-center mb-3">
                                    <button id="saveDBtn" class="btn btn-success w-25 d-none">Save</button>
                                    <button id="editBtn" class="btn btn-danger w-25">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php require "footer.php" ?>

            </div>
        </div>

        <div class="modal fade" id="clientChatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Chat With Us</h1>
                        <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: whitesmoke;height: 400px;overflow-y: auto;">
                        <div class="col-12">
                            <div class="row g-2" id="chatSection">
                                <!-- messages -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: black;">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control w-100" id="msgInput" placeholder="Type Your Message Here...">
                                </div>
                                <div class="col-2 text-center">
                                    <button type="button" id="msgSend" class="btn btn-danger">Send <i class="bi bi-send-fill"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/message.js"></script>
        <script src="javascript/account.js"></script>
    </body>

    </html>

<?php

} else {
    header('location: Login.php');
}

?>