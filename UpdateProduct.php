<?php

session_start();

require "processes/connection.php";


if (isset($_GET["id"]) && isset($_SESSION["adminSession"])) {

    $product = Database::search("SELECT * FROM `product` WHERE `id`='" . $_GET["id"] . "'");

    if ($product->num_rows != 1) {

        echo "there was an error";
    } else {

        $product_arr = $product->fetch_assoc();

        $model_has_brand = Database::search("SELECT * FROM `model_has_brand` WHERE `id`='" . $product_arr["model_has_brand_id"] . "'");

        $model_has_brand_arr = $model_has_brand->fetch_assoc();

        $image = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $product_arr["id"] . "'");
        
    }


?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Product Registration</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
    </head>

    <body>

    <input type="hidden" value="<?= $_GET["id"] ?>" id="prodId">

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 my-3 text-center">
                    <h2 class="text-secondary">Update Product</h2>
                </div>

                <div class="col-12 px-2 px-md-5">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" disabled>
                                <?php
                                $categories = Database::search("SELECT * FROM `category` WHERE `id`='" . $product_arr["category_id"] . "'");
                                $categories_arr = $categories->fetch_assoc();
                                ?>
                                <option><?= $categories_arr["name"] ?></option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Model</label>
                            <select class="form-select" disabled>
                                <?php
                                $model = Database::search("SELECT * FROM `model` WHERE `id`='" . $model_has_brand_arr["model_id"] . "'");
                                $model_arr = $model->fetch_assoc();
                                ?>
                                <option><?php echo $model_arr["name"] ?></option>

                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Brand</label>
                            <select  class="form-select" disabled>
                                <?php
                                $brand = Database::search("SELECT * FROM `brand` WHERE `id`='" . $model_has_brand_arr["brand_id"] . "'");
                                $brand_arr = $brand->fetch_assoc();
                                ?>
                                <option><?= $brand_arr["name"] ?></option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 px-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" value="<?= $product_arr["name"] ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Selling Price(Unit)</label>
                            <input type="text" class="form-control" id="price" value="<?= $product_arr["price"] ?>">
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 px-md-5">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit Quantity</label>
                            <input type="text" id="qty" class="form-control" value="<?= $product_arr["qty"] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping Price(Per unit within colombo)</label>
                            <input type="text" id="shipping1" class="form-control" value="<?= $product_arr["shipping_in_colombo"] ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Shipping Price(Per unit out of colombo)</label>
                            <input type="text" id="shipping2" class="form-control" value="<?= $product_arr["shipping_outof_colombo"] ?>">
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 px-md-5">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Color</label>
                            <select  class="form-select" disabled>
                                <?php
                                $color = Database::search("SELECT * FROM `color` WHERE `id`='" . $product_arr["color_id"] . "'");
                                $color_arr = $color->fetch_assoc();
                                ?>
                                <option><?= $color_arr["name"] ?></option>

                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Condition</label>
                            <select class="form-select" disabled>
                                <?php
                                $condition = Database::search("SELECT * FROM `condition` WHERE `id`='" . $product_arr["condition_id"] . "'");
                                $condition_arr = $condition->fetch_assoc();

                                ?>
                                <option><?= $condition_arr["name"] ?></option>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 px-md-5">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"><?= $product_arr["description"]?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-3 px-md-5">
                    <div class="row">

                        <?php

                        for ($x = 1; $x <=3; $x++) {

                            $image_arr = $image->fetch_assoc();

                        ?>
                            <div class="col-12 col-md-4 p-3">
                                <div class="row">
                                    <div class="col-12 text-center border border-1 border-secondary rounded-3">
                                        <img src="processes/<?= $image_arr["code"]?>" id="imgtag<?=$x?>" style="object-fit: contain;width: 200px;">
                                    </div>
                                    <div class="col-12 p-0 mt-2 d-grid">
                                        <label for="img<?=$x?>" class="btn btn-dark" id="change_img<?=$x?>">Select Image</label>
                                        <input type="file" id="img<?=$x?>" accept="image/*" class="d-none form-control">
                                    </div>
                                </div>
                            </div>
                        <?php

                        }

                        ?>

                    </div>
                </div>

                <div class="col-12 text-center mb-3">
                    <button class="btn btn-success w-25" id="update">Update Product</button>
                </div>

                <!-- <div class="col-12 mb-3 border border-1 border-secondary border-top-1 border-bottom-0 border-start-0 border-end-0">
                    <div class="row">
                        <div class="col-md-4 d-grid mt-3">
                            <button class="btn btn-outline-primary" id="mbBtn">Manage Brands</button>
                        </div>
                        <div class="col-md-4 d-grid mt-3">
                            <button class="btn btn-outline-primary" id="mcBtn">Manage Categories</button>
                        </div>
                        <div class="col-md-4 d-grid mt-3">
                            <button class="btn btn-outline-primary" id="mmBtn">Manage Models</button>
                        </div>
                        <div class="col-md-4 d-grid mt-3">
                            <button class="btn btn-outline-primary" id="mbtmBtn">Manage Brands To Models</button>
                        </div>
                        <div class="col-md-4 d-grid mt-3">
                            <button class="btn btn-outline-primary" id="mcolBtn">Manage Colors</button>
                        </div>
                    </div>
                </div> -->

                <?php require "footer.php" ?>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="testModel" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <input type="text" class="form-control" id="input">
                        </div>
                        <div class="col-12 table-responsive mt-3">
                            <table class="table table-striped table-bordered text-center col-12" id="table">
                                <!-- table -->
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" style="cursor: pointer;" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" style="cursor: pointer;">1</a></li>
                                    <li class="page-item"><a class="page-link" style="cursor: pointer;">2</a></li>
                                    <li class="page-item"><a class="page-link" style="cursor: pointer;">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" style="cursor: pointer;" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <div class="col-12 d-grid border border-2 border-bottom-0 border-top-1 border-start-0 border-end-0 pt-2">
                            <button type="button" class="btn btn-danger" id="saveBtn">Save</button>
                            <button type="button" class="btn btn-primary d-none" id="UpdateBtn">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="resources/ckeditor/ckeditor.js"></script>
        <script src="javascript/bootstrap.bundle.js"></script>
        <script src="javascript/updateProduct.js"></script>
        <script>
            CKEDITOR.replace("description");
        </script>
    </body>

    </html>

<?php

} else {
}

?>