<?php

session_start();

require "processes/connection.php";
$delivery = 0;
$total = 0;

if (isset($_SESSION["user"]) && isset($_GET["oid"])) {

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
                            <div class="col-6 text-start">
                                <button class="btn btn-dark me-2" onclick="printDiv();">Print <i class="bi bi-printer"></i></button>
                            </div>
                            <div class="col-6 text-end">
                                <?php
                                $d = new DateTime();
                                $tz = new DateTimeZone("Asia/Colombo");
                                $d->setTimezone($tz);
                                $date = $d->format("Y-m-d H:i:s");
                                $dateandtime = explode(" ", $date);

                                $code = $_GET["oid"];

                                ?>
                                <h2>Invoive</h2>
                                <label class="form-label">Date : <?php echo $dateandtime[0]; ?></label><br>
                                <label class="form-label">Time : <?php echo $dateandtime[1]; ?></label><br>
                                <label class="form-label">Order ID : <?php echo $code; ?></label>
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
                                        <h5>The logo company</h5>
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
                                                <h5><?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?></h5>
                                                <?php
                                                $address = Database::search("SELECT * FROM `user_address` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
                                                $address_row = $address->fetch_assoc();

                                                $location = Database::search("SELECT * FROM `location` WHERE `id`='" . $address_row["location_id"] . "'");
                                                $location_row = $location->fetch_assoc();

                                                $district = Database::search("SELECT * FROM district WHERE id='" . $location_row["district_id"] . "'");
                                                $district_row = $district->fetch_assoc();
                                                $district_name = $district_row["name"];
                                                ?>
                                                <label class="form-label"><?php echo $address_row["address_line1"] . " " . $address_row["address_line2"]; ?></label><br>
                                                <label class="form-label"><?php echo $_SESSION["user"]["mobile"]; ?></label><br>
                                                <label class="form-label">email : <?php echo $_SESSION["user"]["email"]; ?></label>
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

                                    $purchase_history = Database::search("SELECT * FROM `purchase_history` WHERE orderId='" . $code . "' AND user_email='" . $_SESSION["user"]["email"] . "'");
                                    $purchase_history_num = $purchase_history->num_rows;

                                    for ($x = 0; $x < $purchase_history_num; $x++) {
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
                                            <td><?php echo $x+1; ?></td>
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
                                        <td class="fs-5 text-end"><?php echo number_format($total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0"></td>
                                        <td colspan="2" class="fs-5 text-end">Delivery</td>
                                        <td class="fs-5 text-end">Rs. <?php echo number_format($delivery, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-0"></td>
                                        <td colspan="2" class="fs-5 text-end">GRAND TOTAL</td>
                                        <td class="fs-5 text-end">Rs. <?php echo number_format($total + $delivery, 2); ?></td>
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

        <script>
            function printDiv() {
                var restorepage = document.body.innerHTML;
                var page = document.getElementById("GFG").innerHTML;
                document.body.innerHTML = page;
                window.print();
                document.body.innerHTML = restorepage;
            }
        </script>
    </body>

    </html>
<?php
} else {
header("Location: Login.php");
}
