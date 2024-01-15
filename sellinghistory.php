<?php

session_start();

require "processes/connection.php";

if (isset($_SESSION["adminSession"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Selling History</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css">
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <div class="col-12 text-center text-white pb-3 pt-3 bg-dark">
                    <label class="form-label fw-bold fs-2">Selling History</label>
                </div>

                <div class="col-12">
                    <div class="row"> 

                        <div class="sh-search-filter">
                            <div class="row">
                                <div class="col-12 d-md-none">
                                    <i class="bi bi-x-lg float-end" id="closeFilter" style="font-size: large;font-weight: bolder;"></i>
                                </div>
                                <div class="col-12 text-center">
                                    <label class="form-label fw-bold fs-3">Filter By</label><br>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Date From</label>
                                    <input type="date" id="fromDate" class="form-control">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">Date To</label>
                                    <input type="date" id="toDate" class="form-control">
                                </div>

                                <label class="from-label fw-bold mt-3">Invoice Id</label>
                                <div class="col-12 mt-2 mb-3">
                                    <input type="text" class="form-control" id="invoice" placeholder="Invoice Number" aria-describedby="button-addon2">
                                </div>
                                <div class="col-12 d-grid">
                                    <button class="btn btn-primary" type="button" id="search">Search</button>
                                </div>
                                <div class="col-12 mt-3">
                                    <a class="text-decoration-underline" style="cursor: pointer;" id="clear">clear</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-md-none">
                            <i class="bi bi-funnel-fill" id="openFilter">Filter</i>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12 p-3 table-responsive-md">

                                    <div class="col-12">
                                        <div class="row border border-bottom-1 border-top-0 border-end-0 border-start-0" style="min-width: 800px;">
                                            <div class="col-1 p-2 text-center fw-bold">#</div>
                                            <div class="col-2 p-2 text-center fw-bold">Order ID</div>
                                            <div class="col-2 p-2 text-center fw-bold">Ordered On</div>
                                            <div class="col-2 p-2 text-center fw-bold">Items</div>
                                            <div class="col-1 p-2 text-center fw-bold">Quantity</div>
                                            <div class="col-2 p-2 text-center fw-bold">Email</div>
                                            <div class="col-2 p-2 text-center fw-bold">Status</div>
                                        </div>
                                    </div>

                                    <div class="col-12" id="History">
                                        <!-- selling history -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <?php require "footer.php" ?>
        </div>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/sellinhistory.js"></script>
    </body>

    </html>
<?php

} else {
    header("Location: adminLogin.php");
}

?>