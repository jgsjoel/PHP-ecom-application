<?php

session_start();
require "../connection.php";

if (isset($_GET["pid"])) {

    $result = Database::search("SELECT * FROM `product_feedback` WHERE `product_id`='" . $_GET["pid"] . "'");

    if ($result->num_rows != 0) {

        for ($x = 0; $x < $result->num_rows; $x++) {

            $arr = $result->fetch_assoc();

?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-12 border border-bottom-1 border-start-0 border-end-0 border-top-0 border-secondary">
                        <div class="row">
                            <div class="col-6"><span class="text-black-50">Posted On: <?= $arr["datetime"] ?></span></div>
                            <div class="col-6 text-end"><span class="text-danger"><?= $arr["user_email"] ?></span></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <p class="card-text"><?= $arr["message"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
<?php

        }
    }else{
        ?>
        <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-12">
                        <div class="card-body text-center">
                            <h2 class="text-black-50">No Feedback Yet</h2>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
} else {
    header('Location: ../../singleProductView.php');
}





















?>