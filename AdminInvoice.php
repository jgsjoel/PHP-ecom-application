<?php

session_start();

require "processes/connection.php";
$delivery = 0;
$total = 0;

if (isset($_SESSION["admin"]) && isset($_GET["oid"])) {

    $purchase_history = Database::search("SELECT `purchase_history`.`orderId` AS `oid`, `purchase_history`.`qty`,`purchase_history`.`datetime`,
    `purchase_history`.`user_email`,`product`.`name`,`product`.`price`,`purchase_history`.`product_id` FROM `purchase_history` INNER JOIN 
    product ON product.id=purchase_history.product_id WHERE `purchase_history`.`orderId`='".$_GET["oid"]."'");

    if ($purchase_history->num_rows != 0) {

        $user_address = Database::search("SELECT `user_address`.`location_id`,`user_address`.`address_line1`,`user_address`.`address_line2`,`purchase_history`.`datetime`,
        `user`.`fname`,`user`.`lname`,`user`.`mobile`,`user`.`email`
         FROM `user_address` INNER JOIN `purchase_history` ON 
        `purchase_history`.`user_email`=`user_address`.`user_email` INNER JOIN `user` ON 
        `user`.`email`=`purchase_history`.`user_email` WHERE
          `purchase_history`.`orderId`='" . $_GET["oid"] . "' GROUP BY `purchase_history`.`orderId`");
        $address_row = $user_address->fetch_assoc();

        $location = Database::search("SELECT * FROM `location` WHERE `id`='" . $address_row["location_id"] . "'");
        $location_row = $location->fetch_assoc();

        $district = Database::search("SELECT * FROM district WHERE id='" . $location_row["district_id"] . "'");
        $district_row = $district->fetch_assoc();
        $district_name = $district_row["name"];

        $exploded = explode(" ",$address_row["datetime"]);

?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link rel="icon" href="resources/images/Logo.png">
            <link rel="stylesheet" href="resources/css/bootstrap.css" />
            <link rel="stylesheet" href="resources/css/style.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
        </head>

        <body>

            <div class="container-fluid">
                <div class="row">


                    <div class="col-12 btn-toolbar bg-light text-start mt-2">

                    </div>
                    <div id="GFG">

                        <div class="col-12 text-end">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <h2>Invoive</h2>
                                    <label class="form-label">Date : <?= $exploded[0]?></label><br>
                                    <label class="form-label">Time : <?= $exploded[1] ?></label><br>
                                    <label class="form-label">Order ID : <?= $_GET["oid"] ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="12">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6 bg-light">
                                                    <h3>From</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 text-start">
                                            <h5><img src="resources/images/Logo.png" width="180px"></h5>
                                            <label class="form-label">133/53 st bernadett mw, rillaulla kandana</label><br>
                                            <label class="form-label">0762134986</label><br>
                                            <label class="form-label">email : jgsjoelsmith@gmail.com</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="offset-6 col-6 bg-light">
                                                    <h3>To</h3>
                                                </div>
                                                <div class=" offset-6 col-6 text-start">
                                                    <h5><?= $address_row["fname"] . " " . $address_row["lname"]; ?></h5>

                                                    <label class="form-label"><?= $address_row["address_line1"] . " " . $address_row["address_line2"]; ?></label><br>
                                                    <label class="form-label"><?=$address_row["mobile"]; ?></label><br>
                                                    <label class="form-label">email : <?= $address_row["email"]; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <table class="table">
                                    <thead>
                                        <tr class="bg-light">
                                            <th>#</th>
                                            <th>Order Id & Product</th>
                                            <th class="text-end">Unit Price</th>
                                            <th class="text-end">Quantity</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        for ($x = 0; $x < $purchase_history->num_rows; $x++) {
                                            $purchase_history_row = $purchase_history->fetch_assoc();

                                            $product = Database::search("SELECT * FROM product WHERE id='" . $purchase_history_row["product_id"] . "'");
                                            $product_row = $product->fetch_assoc();

                                            if ($district_name == "Colombo") {
                                                $delivery = $delivery + (int)$product_row["shipping_in_colombo"] * (int)$purchase_history_row["qty"];
                                            } else {
                                                $delivery = $delivery + (int)$product_row["shipping_outof_colombo"] * (int)$purchase_history_row["qty"];
                                            }

                                            $total = $total + (int)$purchase_history_row["qty"] * (int)$product_row["price"];

                                        ?>
                                            <tr>
                                                <td><?php echo $x + 1; ?></td>
                                                <td><?php echo $product_row["name"]; ?></td>
                                                <td class="fs-6 text-end"><?php echo $product_row["price"]; ?></td>
                                                <td class="fs-6 text-end"><?php echo $purchase_history_row["qty"]; ?></td>
                                                <td class="fs-6 text-end">Rs. <?php echo (int)$purchase_history_row["qty"] * (int)$product_row["price"]; ?></td>
                                            </tr>
                                        <?php

                                        }

                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td colspan="2" class="fs-5 text-end">SUBTOTAL</td>
                                            <td class="fs-5 text-end"><?=number_format($total, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td colspan="2" class="fs-5 text-end">Delivery</td>
                                            <td class="fs-5 text-end">Rs. <?= number_format($delivery, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td colspan="2" class="fs-5 text-end">GRAND TOTAL</td>
                                            <td class="fs-5 text-end">Rs. <?= number_format($total + $delivery, 2); ?></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="col-4" style="margin-top: -100px; margin-bottom: 50px;">
                                    <span class="fs-1">THANK YOU!</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php require "footer.php"; ?>
                </div>
            </div>

        </body>

        </html>
<?php


    } else {
        // error
    }
} else {
    header("Location: adminLogin.php");
}
