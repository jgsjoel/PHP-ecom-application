<?php

session_start();

require "processes/connection.php";

if (isset($_SESSION["user"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchase History</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css">
        <link rel="stylesheet" href="resources/css/style.css">
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php require "header.php" ?>

                <div class="col-12 text-center">
                    <label class="form-label fw-bold fs-2">Purchase History</label>
                </div>

                <div class="col-12">
                    <div class="row">

                        <div class="search-filter">
                            <div class="row">
                                <div class="col-12 d-md-none">
                                    <i class="bi bi-x-lg float-end" id="closeFilter" style="font-size: large;font-weight: bolder;"></i>
                                </div>
                                <div class="col-12 text-center">
                                    <label class="form-label fw-bold fs-3">Filter By</label><br>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Date</label>
                                    <select class="form-select" id="date">
                                        <option value="0">All</option>
                                        <?php
                                        $purchase_history = Database::search("SELECT * FROM `purchase_history` WHERE `user_email`='" . $_SESSION["user"]["email"] . "'");
                                        $dt = 0;
                                        for ($x = 0; $x < $purchase_history->num_rows; $x++) {
                                            $ph_arr = $purchase_history->fetch_assoc();

                                            $dateTime = explode(" ", $ph_arr["datetime"]);
                                            $date = $dateTime[0];

                                            if ($date != $dt) {

                                                $dt = $date;
                                        ?>
                                                <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <label class="from-label fw-bold mt-3">Invoice Id</label>
                                <div class="col-12 mt-2 mb-3">
                                    <input type="text" class="form-control" id="invoice" placeholder="Invoice Number" aria-describedby="button-addon2">
                                </div>
                                <div class="col-12 d-grid">
                                    <button class="btn btn-primary" type="button" id="search">Search</button>
                                </div>
                                <div class="col-12 d-grid mt-3">
                                    <a class="text-decoration-underline" style="cursor: pointer;" id="clear">clear</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-md-none">
                            <i class="bi bi-funnel-fill" id="openFilter">Filter</i>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12" id="History">
                                    <!-- product history -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php require "footer.php" ?>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="FeedbaclModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fw-bold fs-5" id="exampleModalLabel">Your Feedback</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <textarea class="form-control" id="feedbackMsg" cols="30" rows="5" placeholder="Enter Feedback"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveFeedback" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/purchaseHistory.js"></script>
        <script src="javascript/navigation.js"></script>
    </body>

    </html>
<?php

} else {
    header("Location: Login.php");
}

?>