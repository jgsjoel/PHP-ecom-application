<?php

session_start();


require "../connection.php";

$result = Database::search("SELECT * FROM `messages` WHERE `user_email`='".$_GET["email"]."'");

if ($result->num_rows != 0) {

    

    for ($x = 0; $x < $result->num_rows; $x++) {

        $msg_arr = $result->fetch_assoc();

        $datetime = explode(" ", $msg_arr["datetime"]);

        if ($msg_arr["sender_id"] == "2") {

            // admin div area
?>
            <div class="col-12">
                <div class="row">
                    <div class="col-6  bg-primary border rounded-3">
                        <div class="row">
                            <div class="col-12 text-start">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <small class="text-white-50">Time: <?= $datetime[1] ?></small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <small class="text-white-50">Date: <?= $datetime[0] ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-white"><?= $msg_arr["message"] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php

        } else {

            // costomer div area
        ?>
            <div class="col-12">
                <div class="row">
                    <div class="col-6 offset-6 bg-success border rounded-3">
                        <div class="row">
                            <div class="col-12 text-start">
                                <div class="row">
                                    <div class="col-6 text-start">
                                        <small class="text-white-50">Time: <?= $datetime[1] ?></small>
                                    </div>
                                    <div class="col-6 text-end">
                                        <small class="text-white-50">Date: <?= $datetime[0] ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-white"><?= $msg_arr["message"] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php

        }
    }
} else {
}


















?>