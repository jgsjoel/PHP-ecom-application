<?php

session_start();

require "processes/connection.php";

if(isset($_SESSION["adminSession"])){

    ?>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="resources/images/Logo.png">
    <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body onload="dashboard();">
    <div class="container-fluid">
        <div class="row">

        <?php require "adminheader.php"; ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-2 min-vh-100 bg-dark d-none d-lg-block">
                        <div class="row justify-content-between">
                            <div class="col-12 d-grid text-start fs-3 mb-5" style="background-color: #ff66ff">
                                <label class="form-label fw-bold text-white">Menue</label>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="productregistration.php" class="adm-button">Add Product</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="ManageUsers.php" class="adm-button">Manage users</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="ManageProducts.php" class="adm-button">Manage products</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="sellinghistory.php" class="adm-button">Selling History</a>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-12 col-lg-10" style="background-color: rgba(0, 0, 0, 0.100);">
                        <div class="row">
                            <?php

                            $thisYear = date("Y");
                            $thisMonth = date("m");
                            $thisDay = date("d");

                            $invoice = Database::search("SELECT * FROM `purchase_history`");
                            $invoice_num = $invoice->num_rows;

                            $thisYear_qty = 0;
                            $thisMonth_qty = 0;
                            $thisDay_qty = 0;
                            $thisYear_ernings = 0;
                            $thisMonth_ernings = 0;
                            $thisDay_ernings = 0;

                            for ($x = 0; $x < $invoice_num; $x++) {
                                $invoice_row = $invoice->fetch_assoc();

                                $product = Database::search("SELECT * FROM `product` WHERE id='" . $invoice_row["product_id"] . "'");
                                $product_row = $product->fetch_assoc();

                                $explode = explode("-", $invoice_row["datetime"]);
                                $date = $explode[2];
                                $month = $explode[1];
                                $year = $explode[0];

                                if ($year == $thisYear) {
                                    $thisYear_qty = $thisYear_qty + $invoice_row["qty"];

                                    $thisYear_ernings = $thisYear_ernings + (int)$invoice_row["qty"] * (int)$product_row["price"];
                                }

                                if ($month == $thisMonth) {
                                    $thisMonth_qty = $thisMonth_qty + $invoice_row["qty"];

                                    $thisMonth_ernings = $thisMonth_ernings + (int)$invoice_row["qty"] * (int)$product_row["price"];
                                }

                                if ($date == $thisDay) {
                                    $thisDay_qty = $thisDay_qty + $invoice_row["qty"];

                                    $thisDay_ernings = $thisDay_ernings + (int)$invoice_row["qty"] * (int)$product_row["price"];
                                }
                            }

                            ?>
                            <div class="col-12 text-start">
                                <h4>Dashboard</h4>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12  rounded-3 text-white text-center p-2" style="background-color: #ff0000;">
                                            <h5>Annual Sellings</h5>
                                            <span><?php echo number_format($thisYear_qty); ?> Items</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12 rounded-3 text-white text-center p-2" style="background-color: #0000ff;">
                                            <h5>Monthly Sellings</h5>
                                            <span><?php echo number_format($thisMonth_qty); ?> Items.</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12  rounded-3 text-white text-center p-2" style="background-color: #003300;">
                                            <h5>Daily Sellings</h5>
                                            <span><?php echo number_format($thisDay_qty); ?> Items</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12  rounded-3 text-white text-center p-2" style="background-color: #ff6600;">
                                            <h5>Annual Earnings</h5>
                                            <span>Rs. <?php echo number_format($thisYear_ernings, 2); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12  rounded-3 text-white text-center p-2" style="background-color: #3399ff;">
                                            <h5>Monthly Earnings</h5>
                                            <span>Rs. <?php echo number_format($thisMonth_ernings, 2); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 p-2">
                                        <div class="col-12  rounded-3 text-white text-center p-2" style="background-color: #33cc33;">
                                            <h5>Daily Earnings</h5>
                                            <span>Rs. <?php echo number_format($thisDay_ernings, 2); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 bg-dark d-none d-lg-block">
                                <div class="row">
                                    <div class="col-12 text-center mt-2 mb-1">
                                        <label class="form-label fs-4 fw-bold text-white">Total Active Time</label>
                                    </div>
                                    
                                    <div class="col-12 text-center mt-1 mb-1">
                                        <label class="form-label fs-4 fw-bold text-success" id="timer">
                                            <!-- timer goes here -->
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="offset-1 col-10 col-lg-4 mt-3 mb-3 rounded bg-light">
                                <div class="row g-1">
                                    <?php
                                    $invoice = Database::search("SELECT `product_id`,SUM(`qty`) AS `sum` FROM purchase_history GROUP BY product_id ORDER BY sum(`qty`) DESC");
                                    $invoice_row = $invoice->fetch_assoc();

                                    $image1 = Database::search("SELECT * FROM product_images WHERE product_id='" . $invoice_row["product_id"] . "'");
                                    $image1_row = $image1->fetch_assoc();

                                    $pro = Database::search("SELECT * FROM product WHERE id='" . $invoice_row["product_id"] . "'");
                                    $pro_row = $pro->fetch_assoc();

                                    ?>
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold">Mostly Sold Item</label>
                                    </div>
                                    <div class="col-12 text-center">
                                        <img src="<?php echo "processes/".$image1_row["code"]; ?>" class="img-fluid rounded-top" style="object-fit: contain; width: 200px;" />
                                        <hr>
                                    </div>
                                    <div class="col-12 text-center">
                                        <span class="fw-bold fs-5"><?php echo $pro_row["name"]; ?></span><br>

                                        <span class="fs-6"><?php echo $invoice_row["sum"]; ?>-Items sold</span><br>
                                        <span class="fs-6">Unit Price = Rs. <?php echo $pro_row["price"]; ?></span>
                                    </div>
                                    <div class="col-12">
                                        <div class="firstplace"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="offset-1 offset-lg-2 col-10 col-lg-4 mt-3 mb-3 rounded bg-light">
                                <div class="row g-1">
                                    <?php
                                    $invoice = Database::search("SELECT `user_email`,SUM(`qty`) AS `sum` FROM purchase_history GROUP BY user_email ORDER BY count(`user_email`) DESC");
                                    $invoice_row = $invoice->fetch_assoc();

                                    $image2 = Database::search("SELECT * FROM profile_images WHERE user_email='" . $invoice_row["user_email"] . "'");
                                    $image2_row = $image2->fetch_assoc();

                                    $user = Database::search("SELECT * FROM user WHERE email='" . $invoice_row["user_email"] . "'");
                                    $user_row = $user->fetch_assoc();

                                    ?>
                                    <div class="col-12 text-center">
                                        <label class="form-label fs-4 fw-bold">Top Customer</label>
                                    </div>
                                    <div class="col-12 text-center">
                                        <img src="<?php echo "processes/profile/".$image2_row["code"]; ?>" class="img-fluid rounded-top" style="object-fit: contain; width: 200px;"/>
                                        <hr>
                                    </div>
                                    <div class="col-12 text-center">
                                        <span class="fw-bold fs-5">Name : <?php echo $user_row["fname"] . " " . $user_row["lname"]; ?></span><br>

                                        <span class="fs-6">Email : <?php echo $user_row["email"]; ?></span><br>
                                        <span class="fs-6"><?php echo $invoice_row["sum"]; ?>-Items Purchased</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="firstplace"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- model -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <span id="alert" class="text-danger"></span>
                                <input type="text" class="form-control" id="category">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="savecategory();">Save Category</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="javascript/admindashboard.js"></script>
    <script src="javascript/bootstrap.bundle.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>

</html>
    <?php

}else{
    header("Location: adminLogin.php");
}

?>
