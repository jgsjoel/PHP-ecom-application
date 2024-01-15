<?php

session_start();

if (isset($_SESSION["user"])) {
require "processes/connection.php";
?>
    <!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Watch List</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
    </head>

    <body>

        <div class="container-fluid vh-100">
            <div class="row">

                <?php require "header.php"; ?>

                <div class="col-12 mt-4 text-center">
                    <label class="ms-2 fs-3 fw-bold">MY WATCH LIST</label>
                </div>
                <div class="col-md-3 d-none d-md-block p-4">
                    <div class="row">
                        <div class="col-12 p-3 rounded-3" style="background-color: rgb(173, 179, 176)">
                            <div class="row">
                                <div class="col-12 d-grid my-1">
                                    <a href="index.php" class="custom-nav-links">Home</a>
                                </div>
                                <div class="col-12 d-grid my-1">
                                    <a href="#" class="custom-nav-links custom-active-link">Watchlist</a>
                                </div>
                                <div class="col-12 d-grid my-1">
                                    <a href="cart.php" class="custom-nav-links">My Cart</a>
                                </div>
                                <div class="col-12 d-grid my-1">
                                    <a href="purchaseHistory.php" class="custom-nav-links">Purchase history</a>
                                </div>
                                <div class="col-12 d-grid my-1">
                                    <a href="account.php" class="custom-nav-links">My Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 px-5 mt-4">
                    <div class="row">
                        <div class="col-12 card-cont">
                            <div class="row" id="items">
                                <!-- items will load here -->
                            </div>
                        </div>
                    </div>
                </div>

                <?php require "footer.php" ?>
            </div>
        </div>
        <script src="javascript/navigation.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="javascript/watchlist.js"></script>
    </body>

</html>
<?php
} else {
    header("Location: Login.php");
}


?>