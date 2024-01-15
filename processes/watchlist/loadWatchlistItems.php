<?php

session_start();

require "../connection.php";
require "watchlist.class.php";

if (isset($_SESSION["user"])) {

    $offset;
    $page_id;
    if ($_GET["page_id"] != "undefined") {
        $offset = 3 * ((int)$_GET["page_id"] - 1);
        $page_id = $_GET["page_id"];
    } else {
        $offset = 0;
        $page_id = 1;
    } 

    $json_encoded = Watchlist::loadWatchlist($offset);
    $json_decoded = json_decode($json_encoded);

    try {
        for ($x = 0; $x < count($json_decoded); $x++) {
?>
            <div class="card mb-3 p-0" data-prodId="<?= $json_decoded[$x]->id ?>" style="min-width: 818px;">
                <div class="row g-0">
                    <div class="col-3">
                        <img src="<?= "processes/" . $json_decoded[$x]->image_code ?>" class="img-fluid" width="150px" alt="...">
                    </div>
                    <div class="col-9">
                        <div class="d-flex align-items-center" style="height: 100%;">
                            <div class="col-8">
                                <h5 class="card-title p-0 m-0"><?= $json_decoded[$x]->name ?></h5><br>
                                <span class="fs-5">Item Price: <b class="text-danger">Rs. <?= number_format($json_decoded[$x]->price, 2) ?></b></span>
                                <p class="p-0 m-0">Condition: <b><?= $json_decoded[$x]->condition ?></b></p>
                                <p class="p-0 m-0">Available: <?= $json_decoded[$x]->qty ?> Items.</p>
                            </div>
                            <div class="col-4 p-3">
                                <div class="row g-1">
                                    <a href="singleProductView.php?pid=<?= $json_decoded[$x]->id?>" class="btn btn-primary">Buy Now</a>
                                    <button class="btn btn-outline-primary addTc">Add to cart</button>
                                    <button class="btn btn-outline-primary RemBtn">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }

        $count = Watchlist::pagination();

        ?>
        <div class="col-12 d-flex justify-content-end">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    if ($page_id != 1) {
                    ?>
                        <li class="page-item"><a class="page-link" data-pageID="<?= $page_id - 1 ?>" href="#">Previous</a></li>
                        <?php
                    }
                    for ($x = 1; $x <= $count; $x++) {
                        if ($page_id == $x) {
                        ?>
                            <li class="page-item"><a class="page-link active" data-pageID="<?= $x ?>" href="#"><?= $x ?></a></li>
                        <?php
                        } else {
                        ?>
                            <li class="page-item"><a class="page-link" data-pageID="<?= $x ?>" href="#"><?= $x ?></a></li>
                        <?php
                        }
                    }
                    if ($page_id + 1 <= $count) {
                        ?>
                        <li class="page-item"><a class="page-link" data-pageID="<?= $page_id + 1 ?>" href="#">Next</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
<?php
    } catch (Throwable $th) {
        ?>
            <div class="col-12 text-center pt-5 pb-5 mt-2">
                <h1 class="text-black-50 fw-bold">Watch List Empty :(</h1>
            </div>
        <?php
    }
}

?>