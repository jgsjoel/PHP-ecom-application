<?php

session_start();

require "processes/connection.php";

$brand = Database::search("SELECT * FROM `brand`");
$condition = Database::search("SELECT * FROM `condition`");
$model = Database::search("SELECT * FROM `model`");
$category = Database::search("SELECT * FROM `category`");
$color = Database::search("SELECT * FROM `color`");

if (isset($_SESSION["user"])) {

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Advanced Search</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
        <link rel="icon" href="resources/head2logo.png">
    </head>

    <body style="background-color: rgb(245, 253, 253);">

        <div class="container">
            <div class="row">
                <div class="col-12 text-center p-3">
                    <span class="fw-bold fs-3">Advanced Search</span>
                </div>
                <div class="col-12 mt-2 shadow-lg p-3">
                    <div class="row">
                        <div class="col-12 px-3">
                            <div class="col-12 d-flex align-items-center">
                                <input type="text" id="input" class="form-control" placeholder="Enter Keyword.....">
                            </div>
                        </div>
                        <div class="col-12 px-3">
                            <hr class="border border-1 border-primary">
                        </div>
                        <div class="col-12 px-3">
                            <span class="fs-4 fw-bold">FIlter By</span>
                        </div>
                        <div class="col-6 px-3 mt-3">
                            <label for="category" class="form-label fw-bold">Category</label>
                            <select class="form-select" id="category">
                                <option value="0">Select Category</option>
                                <?php
                                for ($x = 0; $x < $category->num_rows; $x++) {
                                    $category_arr = $category->fetch_assoc()
                                ?>
                                    <option value="<?= $category_arr["id"] ?>"><?= $category_arr["name"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6 px-3 mt-3">
                            <label for="brand" class="form-label fw-bold">Brand</label>
                            <select class="form-select" id="brand">
                            <option value="0">Select Brand</option>
                                <?php
                                for ($x = 0; $x < $brand->num_rows; $x++) {
                                    $brand_arr = $brand->fetch_assoc()
                                ?>
                                    <option value="<?= $brand_arr["id"] ?>"><?= $brand_arr["name"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6 px-3 mt-3">
                            <label for="model" class="form-label fw-bold">Model</label>
                            <select class="form-select" id="model">
                            <option value="0">Select Model</option>
                            <?php
                                for ($x = 0; $x < $model->num_rows; $x++) {
                                    $model_arr = $model->fetch_assoc()
                                ?>
                                    <option value="<?= $model_arr["id"] ?>"><?= $model_arr["name"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6 px-3 mt-3">
                            <label for="condition" class="form-label fw-bold">Condition</label>
                            <select class="form-select" id="condition">
                            <option value="0">Select Condition</option>
                            <?php
                                for ($x = 0; $x < $condition->num_rows; $x++) {
                                    $condition_arr = $condition->fetch_assoc()
                                ?>
                                    <option value="<?= $condition_arr["id"] ?>"><?= $condition_arr["name"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-6 px-3 mt-3">
                            <label for="color" class="form-label fw-bold">Color</label>
                            <select class="form-select" id="color">
                            <option value="0">Select Color</option>
                            <?php
                                for ($x = 0; $x < $color->num_rows; $x++) {
                                    $color_arr = $color->fetch_assoc()
                                ?>
                                    <option value="<?= $color_arr["id"] ?>"><?= $color_arr["name"]?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-12 px-3">
                            <hr>
                        </div>
                        <div class="col-6 text-start px-3">
                            <label for="sort">Sort By</label>
                            <select id="sort" class="form-select-sm">
                                <option value="1">Price: Heigh To Low</option>
                                <option value="2">Price: Low To High</option>
                            </select>
                        </div>
                        <div class="col-6 text-end px-3">
                            <button class="reset me-3" id="reset">Reset</button>
                            <button class="btn btn-primary" id="search">Search</button>
                        </div>
                    </div>
                </div>
                <!-- prodcts will show here -->
                <div class="col-12 shadow-lg mt-4 p-3" id="products">
                    
                        
                </div>
                <div class="col-12 text-center my-3">
                    <span class="text-black-50">&copy; 2022 SMART ESSENTIALS (Pvt) Ltd All Rights Reserved.</span>
                </div>
            </div>
        </div>

        <script src="javascript/advancedSearcj.js"></script>
    </body>

    </html>
<?php

} else {
    header('Location: Login.php');
}
















?>