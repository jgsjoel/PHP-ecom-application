<?php require "processes/connection.php"?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php require "header.php" ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 text-center text-black-50">
                        <h1>Results For: <?= $_GET["input"] ?></h1>
                    </div>
                    <div class="col-12 d-md-none">
                        <button id="openFilter" class="btn">Filter</button>
                    </div>
                    <div class="search-filter">
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <label class="form-label fs-4">Filter <i class="bi bi-funnel"></i></label>
                                <i class="bi bi-x-lg float-end d-md-none" id="closeFilter" style="width: 25px;height: 25px; font-size: medium;" ></i>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fs-5">Price</label>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="radio" style="cursor: pointer;" id="pricehigh" name="price">
                                <label for="pricehigh" style="cursor: pointer;">Low To High</label>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="radio" style="cursor: pointer;" id="pricelow" name="price">
                                <label for="pricelow" style="cursor: pointer;">High To Low</label>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fs-5">Price Range</label>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="from" placeholder="From">
                                    </div>
                                    <div class="col-1">_</div>
                                    <div class="col-5">
                                        <input type="text" class="form-control" id="to" placeholder="To">
                                    </div>
                                    <div class="col-11 d-grid mt-2">
                                        <button class="btn btn-outline-danger" id="filter">Apply Range</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <a class="text-decoration-underline" id="clear" style="cursor:pointer;">Clear</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9" id="products">
                        
                    </div>
                </div>
            </div>

            <?php require "footer.php" ?>

        </div>
    </div>

    <script src="javascript/search.js"></script>
    <script src="javascript/navigation.js"></script>
</body>

</html>