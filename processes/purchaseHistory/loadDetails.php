<?php

session_start();

require "../connection.php";
require "../public.class.php";

if (isset($_SESSION["user"])) {

    $query = "SELECT `purchase_history`.`orderId` AS `oid`,`purchase_history`.`datetime` AS `datetime`,`product`.`name` AS 
            `name`,`product`.`price`,`product`.`status_id`,`product`.`id`
            FROM purchase_history INNER JOIN product ON product.id=purchase_history.product_id WHERE `user_email`='".$_SESSION["user"]["email"]."' ";


    if (!empty($_POST["date"])) {
        $query = Common::checker($query);
        $query .= " `datetime` LIKE '%" . $_POST["date"] . "%'";
    }

    if (!empty($_POST["oid"])) {
        $query = Common::checker($query);
        $query .= " `orderId` = '" . $_POST["oid"] . "'";
    }

    $offset;
    $page_id;
    if (isset($_POST["page_id"])) {
        $offset = 8 * ((int)$_POST["page_id"] - 1);
        $page_id = $_POST["page_id"];
    } else {
        $offset = 0;
        $page_id = 1;
    }

    $result = Database::search($query . " LIMIT 8 OFFSET $offset");

    // echo $query;

    if ($result->num_rows != 0) {

?>
        <div class="row row-cols-1 row-cols-md-4 g-3" id="products">
            <?php
            for ($x = 0; $x < $result->num_rows; $x++) {

                $arr = $result->fetch_assoc();

                $status;
                if ($arr["status_id"] == 1) {
                    $status = "Buy Now";
                } else {
                    $status = "Sold Out";
                }

                $img = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $arr["id"] . "'");
                $img_arr = $img->fetch_assoc();

            ?>
                <div class="col ">
                    <div class="card h-100" data-prodId="<?= $arr["id"] ?>">
                        <div class="col-12 d-flex justify-content-between text-sm-start py-2 px-2">
                            <a <?php
                                if ($status != "Sold Out") {
                                ?> href="singleProductView.php?pid=<?= $arr["id"] ?>" ; <?php
                                                                                    }
                                                                                        ?>><small class="text-black-50 fw-bold"><?= $status ?></small></a>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <a title="View item"><img src="processes/<?= $img_arr["code"] ?>" style="object-fit: contain;width: 150px;" class="card-img-top"></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-5"><?= $arr["name"] ?></h5>
                            <p class="fw-bold text-danger m-0 fs-6">Rs. <?= number_format($arr["price"], 2) ?></p>
                            <div class="col-12 text-end">
                                <a title="Send Feedback" class="custom-card-btn2"><i class="bi bi-chat-dots feedback" style="cursor: pointer;"></i></a>
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
        <div class="col-12 text-center">
            <h1>No Matching Items Found:(</h1>
        </div>
<?php

    }
}
