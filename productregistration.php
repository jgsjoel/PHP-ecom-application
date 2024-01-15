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
    <title>Product Registration</title>
    <link rel="icon" href="resources/images/Logo.png">
    <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 my-3 text-center">
                <h2 class="text-secondary">Register New Product</h2>
            </div>

            <div class="col-12 px-2 px-md-5">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Category</label>
                        <select id="category" class="form-select">
                            <option value="">Select Category</option>
                            <?php 
                            $categories = Database::search("SELECT * FROM `category`");
                            
                            for($x=0;$x<$categories->num_rows;$x++){
                                $categories_arr = $categories->fetch_assoc();
                                ?>
                                <option value="<?php echo $categories_arr["id"]?>"><?php echo $categories_arr["name"]?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Model</label>
                        <select id="model" class="form-select">
                            <option value="">Select Model</option>
                            <?php 
                            $model = Database::search("SELECT * FROM `model`");
                            
                            for($x=0;$x<$model->num_rows;$x++){
                                $model_arr = $model->fetch_assoc();
                                ?>
                                <option value="<?php echo $model_arr["id"]?>"><?php echo $model_arr["name"]?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Brand</label>
                        <select id="brand" class="form-select">
                            <option value="">Select Brand</option>
                            <?php 
                            $brand = Database::search("SELECT * FROM `brand`");
                            
                            for($x=0;$x<$brand->num_rows;$x++){
                                $brand_arr = $brand->fetch_assoc();
                                ?>
                                <option value="<?php echo $brand_arr["id"]?>"><?php echo $brand_arr["name"]?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 px-2 px-md-5">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Product Name...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selling Price(Unit)</label>
                        <input type="text" class="form-control" id="price" placeholder="Enter Unit Price...">
                    </div>
                </div>
            </div>

            <div class="col-12 px-2 px-md-5">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unit Quantity</label>
                        <input type="text" id="qty" class="form-control" placeholder="Enter Quantity...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Shipping Price(Per unit within colombo)</label>
                        <input type="text" id="shipping1" class="form-control" placeholder="Enter Shipping Price 01 ...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Shipping Price(Per unit out of colombo)</label>
                        <input type="text" id="shipping2" class="form-control" placeholder="Enter Shipping Price 02 ...">
                    </div>
                </div>
            </div>

            <div class="col-12 px-2 px-md-5">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Color</label>
                        <select id="color" class="form-select">
                            <option value="">Select Color</option>
                            <?php 
                            $color = Database::search("SELECT * FROM `color`");
                            
                            for($x=0;$x<$color->num_rows;$x++){
                                $color_arr = $color->fetch_assoc();
                                ?>
                                <option value="<?php echo $color_arr["id"]?>"><?php echo $color_arr["name"]?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Select Condition</label>
                        <select id="condition" class="form-select">
                            <option value="0">Select Condition</option>
                            <?php 
                            $condition = Database::search("SELECT * FROM `condition`");
                            
                            for($x=0;$x<$condition->num_rows;$x++){
                                $condition_arr = $condition->fetch_assoc();
                                ?>
                                <option value="<?php echo $condition_arr["id"]?>"><?php echo $condition_arr["name"]?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 px-2 px-md-5">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-12 px-3 px-md-5">
                <div class="row">

                    <div class="col-12 col-md-4 p-3">
                        <div class="row">
                            <div class="col-12 text-center border border-1 border-secondary rounded-3">
                                <img src="resources/empty-img.png" id="imgtag1" style="object-fit: contain;width: 200px;">
                            </div>
                            <div class="col-12 p-0 mt-2 d-grid">
                                <label for="img1" class="btn btn-dark" id="change_img1">Select Image</label>
                                <input type="file" id="img1" accept="image/*" class="d-none form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 p-3">
                        <div class="row">
                            <div class="col-12 text-center border border-1 border-secondary rounded-3">
                                <img src="resources/empty-img.png"id="imgtag2" style="object-fit: contain;width: 200px;">
                            </div>
                            <div class="col-12 p-0 mt-2 d-grid">
                                <label for="img2" class="btn btn-dark" id="change_img2">Select Image</label>
                                <input type="file" id="img2" accept="image/*" class="d-none form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 p-3">
                        <div class="row">
                            <div class="col-12 text-center border border-1 border-secondary rounded-3">
                                <img src="resources/empty-img.png" id="imgtag3" style="object-fit: contain;width: 200px;">
                            </div>
                            <div class="col-12 p-0 mt-2 d-grid">
                                <label for="img3" class="btn btn-dark" id="change_img3">Select Image</label>
                                <input type="file" id="img3" accept="image/*" class="d-none form-control">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-12 text-center mb-3">
                <button class="btn btn-success w-25" id="register">Register Product</button>
            </div>

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
    <script src="javascript/productRegistration.js"></script>
    <script>
        CKEDITOR.replace("description");
    </script>
</body>

</html>
    <?php

}else{
header("Location: adminLogin.php");

}

?>
