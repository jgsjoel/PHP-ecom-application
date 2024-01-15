<?php

session_start();

require "../connection.php";
require "../public.class.php";

// if (isset($_SESSION["user"])) {

    $priceHTL = (int)$_POST["priceHTL"];
    $from = (int)$_POST["from"];
    $to = (int)$_POST["to"];
    $input = $_POST["input"];
    $category = (int)$_POST["category"];

    $query = "SELECT * FROM `product` ";

    if (!empty($input)) {
        $query = Common::checker($query);
        $query .= "LOWER(`name`) LIKE LOWER('%" . $input . "%')";
    }

    if (!empty($category)) {
        $query = Common::checker($query);
        $query .= "`category_id`='" . $category . "'";
    }

    if (!empty($from) && empty($to)) {
        $query = Common::checker($query);
        $query .= "`price` >= '" . $from . "'";
    }

    if (!empty($to) && empty($from)) {
        $query = Common::checker($query);
        $query .= "`price` <= '" . $to . "'";
    }

    if (!empty($from) && !empty($to)) {
        $query = Common::checker($query);
        $query .= "`price` BETWEEN '" . $from . "' AND '" . $to . "'";
    }

    $query .= " AND `status_id`='1' ";

    if (!empty($priceHTL)) {
        if ($priceHTL == 1) {
            $query .= " ORDER BY `price` ASC";
        } elseif ($priceHTL == 2) {
            $query .= " ORDER BY `price` DESC";
        }
    }

    $offset;
    $page_id;
    if ($_POST["page_id"] != "undefined") {
        $offset = 8 * ((int)$_POST["page_id"] - 1);
        $page_id = $_POST["page_id"];
    } else {
        $offset = 0;
        $page_id = 1;
    }

    $result = Database::search($query . " LIMIT 8 OFFSET $offset");

    if ($result->num_rows != 0) {

?>
        <div class="row row-cols-1 row-cols-md-4 g-3" id="products">
            <?php

            for ($x = 0; $x < $result->num_rows; $x++) {

                $arr = $result->fetch_assoc();

                $condition;
                if ($arr["condition_id"] == 1) {
                    $condition = "New";
                } else {
                    $condition = "Used";
                }

                $img = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $arr["id"] . "'");
                $img_arr = $img->fetch_assoc();

            ?>

                <div class="col ">
                    <div class="card h-100" data-prodId="<?= $arr["id"] ?>">
                        <div class="col-12 d-flex justify-content-between text-sm-start py-2 px-2">
                            <small class="text-black-50 fw-bold"><?= $condition ?></small>
                            <a title="Add to watchlist">
                                <i class="bi bi-heart-fill custom-card-btn1 atwl" style="cursor: pointer;"></i>
                            </a>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="singleProductView.php?pid=<?= $arr["id"] ?>" title="View item"><img src="processes/<?= $img_arr["code"] ?>" style="object-fit: contain;width: 150px;" class="card-img-top"></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-5"><?= $arr["name"] ?></h5>
                            <p class="fw-bold text-danger m-0 fs-6">Rs. <?= number_format($arr["price"], 2) ?></p>
                            <div class="col-12 text-end">
                                <a title="Add to cart" class="custom-card-btn2" style="cursor: pointer;"><i class="bi bi-cart-fill atcrt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
        <?php

        // pagination code
        $BtnCount = Common::getButtonCount(Database::search($query)->num_rows, 8);
        ?>
        <div class="col-12 mt-3">
            <div class="col-12 px-4 d-flex justify-content-end">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        if ($page_id != 1) {
                        ?>
                            <li class="page-item"><a class="page-link" style="cursor:pointer;" data-pageID="<?= $page_id - 1 ?>">Previous</a></li>
                            <?php
                        }
                        for ($x = 1; $x <= $BtnCount; $x++) {
                            if ($page_id == $x) {
                            ?>
                                <li class="page-item"><a class="page-link active" style="cursor:pointer;" data-pageID="<?= $x ?>"><?= $x ?></a></li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item"><a class="page-link" style="cursor:pointer;" data-pageID="<?= $x ?>"><?= $x ?></a></li>
                            <?php
                            }
                        }
                        if ($page_id + 1 <= $BtnCount) {
                            ?>
                            <li class="page-item"><a class="page-link" style="cursor:pointer;" data-pageID="<?= $page_id + 1 ?>">Next</a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php


    } else {

    ?>
        <div class="col-12 h-75 d-flex justify-content-center align-items-center">
            <h1>No Matching Items Found:(</h1>
        </div>
<?php
    }
// } else {
//     header("Location: ../../Login.php");
// }
