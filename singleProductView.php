<?php
 
session_start();

require "processes/connection.php"; 

if (isset($_GET["pid"])) {

    $product_res = Database::search("SELECT * FROM `product` WHERE `id`='" . $_GET["pid"] . "'");

    if ($product_res->num_rows == 1) {

        $product_arr = $product_res->fetch_assoc();

        $image_res = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $_GET["pid"] . "'");
        $product_pic;
        for ($x = 0; $x < $image_res->num_rows; $x++) {
            $image_arr = $image_res->fetch_assoc();
            $product_pic[$x] = $image_arr['code'];
        }

        $condition;
        if ($product_arr['condition_id'] == 1) {
            $condition = "New";
        } else {
            $condition = "Used";
        }
    } else {
        header('Location: home.php');
    }

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product View</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
        <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.5.3/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous">
    </head>

    <body onload="loadmessages(<?= $_GET['pid']?>);">

        <div class="container-fluid">
            <div class="row">
                <?php require "header.php" ?>
                <div class="col-12 text-center py-4">
                    <span class="fw-bold fs-3">Showing: Apple iPhone 13</span>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 col-md-4 order-last order-md-first">
                                    <div class="row">
                                        <div class="col-4 col-md-12 text-center mt-3 prodPic">
                                            <img id="img1" src="processes/<?= $product_pic[0] ?>" width="120px" class="img-fluid border border-1" style="cursor: pointer;">
                                        </div>
                                        <div class="col-4 col-md-12 text-center mt-3 prodPic">
                                            <img id="img2" src="processes/<?= $product_pic[1] ?>" width="120px" class="img-fluid border border-1" style="cursor: pointer;">
                                        </div>
                                        <div class="col-4 col-md-12 text-center mt-3 prodPic">
                                            <img id="img3" src="processes/<?= $product_pic[2] ?>" width="120px" class="img-fluid border border-1" style="cursor: pointer;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 px-3 p-md-0 col-md-8 text-center mt-3 order-first order-md-last">
                                    <img id="mainImg" src="processes/<?= $product_pic[0] ?>" width="400px" class="img-fluid border border-1 shadow-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 px-4">
                            <div class="row gy-2">
                                <div class="col-12 text-start">
                                    <span class="fw-bold fs-4"><?= $product_arr["name"] ?></span>
                                </div>
                                <div class="col-12">
                                    <span class="text-black-50">Condition: </span>
                                    <span class="badge bg-success"><i class="bi bi-fill"><?= $condition ?></i></span>
                                </div>
                                <div class="col-12 text-start">
                                    <span class="fw-bold text-danger fs-2">Rs. <?= number_format($product_arr["price"], 2) ?></span>
                                </div>
                                <div class="col-12 mt-3 mb-1">
                                    <hr style="margin: 0%;">
                                </div>
                                <div class="col-12 text-start">
                                    <span class="text-black-50">Shipping(Colombo): <?= $product_arr["shipping_in_colombo"] ?></span><br>
                                    <span class="text-black-50">Shipping(Else): <?= $product_arr["shipping_outof_colombo"] ?></span><br>
                                    <span class="text-black-50">In Stock: <?= $product_arr["qty"] ?></span>
                                </div>
                                <div class="col-12">
                                    <span class="fw-bold">Select Quantity</span>
                                    <input type="text" value="1" id="qty" style="width: 80px;padding: 5px;">
                                </div> 
                                <div class="col-12">
                                    <button data-id="<?= $product_arr["id"] ?>" id="buyNow" class="btn btn-primary">Buy Now</button>
                                    <button data-id="<?= $product_arr["id"] ?>" class="btn btn-outline-primary atcrt">Add To Cart</button>
                                    <button data-id="<?= $product_arr["id"] ?>" class="btn btn-outline-primary atwl">Add To Watch List</button>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 my-4">
                            <hr style="margin: 0%;">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 text-start px-4">
                            <span class="fs-2 fw-bold text-black-50">Description</span>
                        </div>
                        <div class="col-12 px-4">
                            <?= $product_arr["description"] ?>
                        </div>
                    </div>
                </div>
                <div class="px-4 my-4">
                    <hr style="margin: 0%;">
                </div>
                <div class="col-12 p">
                    <div class="row">
                        <div class="col-12 text-start px-4">
                            <span class="fs-2 fw-bold text-black-50">Feedback</span>
                        </div>
                        <div class="col-12 mt-3">

                            <div class="col-12" id="messageBox">
                                
                            </div>

                        </div>
                    </div>
                </div>

                <?php require "footer.php" ?>
            </div>
        </div>

        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        <script src="javascript/navigation.js"></script>
        <script src="javascript/singleProduct.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.5.3/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
    </body>

    </html>
<?php

} else {
    header('Location: index.php');
}



?>