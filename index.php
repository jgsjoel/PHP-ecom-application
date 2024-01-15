<?php

session_start();

require "processes/connection.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="resources/images/Logo.png">
    <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php require "header.php" ?>

            <div class="col-12 px-3">
                <div class="col-12 text-center border border-1 border-top-0 border-bottom-1 border-start-0 border-end-0">
                    <span class="fs-3 fw-bold border-primary border border-2 border-top-0 border-bottom-1 border-start-0 border-end-0">Categories</span>
                </div>
            </div>

            <!-- categories start -->
            <div class="col-12 mt-3 px-3">
                <div class="row">
                    <?php

                    $categories = Database::search("SELECT * FROM `category`");

                    for ($x = 0; $x < $categories->num_rows; $x++) {

                        $category_arr = $categories->fetch_assoc();

                        $products = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $category_arr["id"] . "' AND `status_id`='1' LIMIT 4");

                    ?>
                        <div class="col-12 text-start mt-4">
                            <span class="fs-4 fw-bold" style="color: rgb(146, 146, 250);"><?= $category_arr["name"] ?></span>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="row row-cols-1 row-cols-md-4">

                                <?php
                                for ($y = 0; $y < $products->num_rows; $y++) {

                                    $product_arr = $products->fetch_assoc();

                                    $condition;
                                    if ((int)$product_arr["condition_id"] == 1) {
                                        $condition = "New";
                                    } else {
                                        $condition = "Used";
                                    }

                                    $images = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $product_arr["id"] . "'");

                                    $image_arr = $images->fetch_assoc();


                                ?>

                                    <div class="col mb-3">
                                        <div class="card h-100" data-prodId="<?= $product_arr["id"] ?>">
                                            <div class="col-12 d-flex justify-content-between text-sm-start py-2 px-2">
                                                <small class="text-black-50 fw-bold"><?= $condition; ?></small>
                                                <a href="#" title="Add to watchlist">
                                                    <i class="bi bi-heart-fill atwl custom-card-btn1"></i>
                                                </a>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center">
                                                <a href="singleProductView.php?pid=<?= $product_arr["id"] ?>" title="View item"><img src="processes/<?= $image_arr["code"] ?>" style="object-fit: contain;width: 150px;" class="card-img-top"></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title fs-5"><?= $product_arr["name"] ?></h5>
                                                <p class="fw-bold text-danger m-0 fs-6">Rs. <?= $product_arr["price"] ?></p>
                                                <div class="col-12 text-end">
                                                    <a href="#" title="Add to cart" class="custom-card-btn2 atcrt"><i class="bi bi-cart-fill"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                            </div>
                        </div>

                    <?php

                    }

                    ?>

                </div>
            </div>
            <!-- categories end -->

            <!-- footer area -->
            <?php require "footer.php" ?>


        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="javascript/navigation.js"></script>
    <script src="javascript/index.js"></script>
</body>

</html>