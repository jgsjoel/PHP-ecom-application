<?php

session_start();

require "processes/connection.php";
require "processes//cart/cart.class.php";

if (isset($_SESSION["user"])) {

    $result = Database::search("SELECT `product`.`id`,`product`.`name`,`product`.`price`,`product`.`qty`,`cart`.`qty` AS `cqty`,`condition`.`name` AS `condition`,
    `product`.`description`, `product`.`shipping_in_colombo`,`product`.`shipping_outof_colombo`,
    `status`.`name` AS `status` FROM `cart` INNER JOIN `product` ON `product`.`id`=`cart`.`product_id` INNER JOIN `condition` ON
      `condition`.`id`=`product`.`condition_id` INNER JOIN `status` ON `status`.`id`=`product`.`status_id` WHERE `cart`.`user_email`='" . $_SESSION["user"]["email"] . "' ");

    $summery_json = Cart::calculateSummery();
    $summery_str = json_decode($summery_json);

?>
    <!DOCTYPE html>
    <html>
 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Cart</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php require "header.php"; ?>

                <div class="col-12">
                    <div class="row">

                        <div class="col-12 mt-5 text-start">
                            <label class="ms-2 fs-3 fw-bold">MY SHOPPING CART</label>
                        </div>
                        <div class="col-12 col-md-8 pt-3 px-4">
                            <div class="row">
                                <div class="col-12 card-cont">
                                    <div class="row">

                                        <?php

                                        if ($result->num_rows != 0) {
                                            for ($x = 0; $x < $result->num_rows; $x++) {

                                                $result_arr = $result->fetch_assoc();

                                                $image = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $result_arr["id"] . "'");

                                                $img_arr = $image->fetch_assoc();



                                        ?>

                                                <div class="card mb-3 p-0" data-productId="<?= $result_arr["id"] ?>" style="min-width: 818px;">
                                                    <div class="row g-0">
                                                        <div class="col-3">
                                                            <img src="processes/<?= $img_arr["code"] ?>" class="img-fluid" width="150px" alt="...">
                                                        </div>
                                                        <div class="col-9">
                                                            <div class="d-flex align-items-center" style="height: 100%;">
                                                                <div class="col-6">
                                                                    <a href="#" class="text-dark" title="visit"><b><?= $result_arr["name"] ?> <i class="bi bi-box-arrow-up-right"></i></b></a>
                                                                </div>
                                                                <div class="col-3">
                                                                    <span class="fw-bold fs-5">QTY: </span>
                                                                    <select class="qty-select" style="border: 1px solid black;border-radius: 5px;width: 60px;height: 40px;background-color: whitesmoke;">
                                                                        <?php

                                                                        for ($y = 1; $y <= (int)$result_arr["qty"]; $y++) {

                                                                            if ((int)$result_arr["cqty"] == $y) {
                                                                        ?>
                                                                                <option value="<?= $y ?>" selected><?= $y ?></option>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <option value="<?= $y ?>"><?= $y ?></option>
                                                                        <?php
                                                                            }
                                                                        }

                                                                        ?>
                                                                    </select><br>
                                                                    <small class="text-black-50"><?= $result_arr["qty"] ?> Available.</small>
                                                                </div>
                                                                <div class="col-3 text-start">
                                                                    <h5 class="pe-2"><b>RS. <?= number_format($result_arr["price"], 2) ?></b></h5>
                                                                    <small class="text-black-50">+ Rs. Shipping per item.</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex p-2 border border-1 border-top-1 border-bottom-0 border-start-0 border-end-0">
                                                            <div class="col-6 text-start">
                                                                <span class="text-black-50">Condition: <?= $result_arr["condition"] ?></span>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <a class="atwl" style="cursor: pointer;">Add to Watch list</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                                <a class="remfwl" style="cursor: pointer;">Remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php

                                            }
                                        } else {
                                            ?>
                                            <div class="card mb-3 p-0 border-0" data-productId="<?= $result_arr["id"] ?>" style="min-width: 818px;">
                                                <div class="row g-0">
                                                    <div class="col-12 mt-5 text-center">
                                                        <h1 class="text-black-50">No items in cart :(</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summery -->

                        <div class="col-12  px-3 col-md-4 my-3 col-lg-4">
                            <div class="row">
                                <div class="col-12 bg-light">
                                    <div class="row">
                                        <div class="col-12 my-3 text-center">
                                            <h4 class="fw-bold">Summery</h4>
                                        </div>
                                        <div class="px-3">
                                            <hr style="border-bottom: 2px solid black;margin: 0%;">
                                        </div>
                                        <div class="col-5 mt-3 text-start">
                                            <h4>SUBTOTAL:</h4>
                                        </div>
                                        <div class="col-7 mt-3 text-end">
                                            <h5>RS. <?= $summery_str->subtotal ?></h5>
                                        </div>
                                        <div class="col-5 mt-3 text-start">
                                            <label class="form-label">Shipping</label>
                                        </div>
                                        <div class="col-7 mt-3 text-end">
                                            <label>RS. <?= $summery_str->shipping ?></label>
                                        </div>
                                        <div class="px-3 mt-3">
                                            <hr style="border-bottom: 2px solid black;margin: 0%;">
                                        </div>
                                        <div class="col-5 mt-3 text-start">
                                            <label class="form-label">ESTM TOTAL:</label>
                                        </div>
                                        <div class="col-7 mt-3 text-end">
                                            <label class="form-label">Rs. <?= $summery_str->EstmTotal ?></label>
                                        </div>
                                        <div class="px-3 mt-2">
                                            <hr style="border-bottom: 2px solid black;margin: 0%;">
                                        </div>
                                        <?php

                                        if ($summery_str->status == 1) {
                                        ?>
                                            <div class="col-12 my-3 d-grid">
                                                <button id="checkout" class="btn btn-dark">Check Out</button>
                                            </div>
                                        <?php
                                        } else if ($summery_str->status == 2) {
                                        ?>
                                            <div class="col-12 my-3 d-grid">
                                                <a href="account.php">Update location to view Summery.</a>
                                            </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php require "footer.php" ?>

            </div>
        </div>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="javascript/navigation.js"></script>
        <script src="javascript/cart.js"></script>
    </body>

    </html>
<?php

} else {
    header('location: Login.php');
}

?>