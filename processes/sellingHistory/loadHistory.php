<?php
session_start();

require "../connection.php";
require "../public.class.php";

if (isset($_SESSION["admin"])) {

    // $from = $_POST["fromdate"];
    // $to = $_POST["todate"];
    // $invoice = $_POST["invoice"];


    $query = "SELECT `purchase_history`.`orderId` AS `oid`, COUNT(`purchase_history`.`qty`) AS `total`,`product`.`name` AS `name`,`purchase_history`.`user_email` AS `email`,
    `purchase_history`.`datetime` AS `datetime`,`purchase_history`.`order_status_id` AS `status`
     FROM `purchase_history` INNER JOIN `user` ON `user`.`email`=`purchase_history`.`user_email`
    INNER JOIN `product` ON `product`.`id`=`purchase_history`.`product_id` ";

    if (!empty($_POST["from"]) && empty($_POST["to"])) {
        $query = Common::checker($query);
        $query .= "`purchase_history`.`datetime` >= '" . $_POST["from"] . "'";
    }

    if (!empty($_POST["to"]) && empty($_POST["from"])) {
        $query = Common::checker($query);
        $query .= "`purchase_history`.`datetime` <= '" . $_POST["to"] . "'";
    }

    if (!empty($_POST["from"]) && !empty($_POST["to"])) {
        $query = Common::checker($query);
        $query .= "`purchase_history`.`datetime` BETWEEN '" . $_POST["from"] . "' AND '" . $_POST["to"] . "'";
    }

    if (!empty($_POST["invoice"])) {
        $query = Common::checker($query);
        $query .= "`purchase_history`.`orderId`='" . $_POST["invoice"] . "'";
    }

    $query .= " GROUP BY `purchase_history`.`orderId`"; 

    // echo $query;

    $offset;
    $page_id;
    if (!empty((int)@$_POST["page_id"])) {
        $offset = 8 * ((int)$_POST["page_id"] - 1);
        $page_id = (int)$_POST["page_id"];
    } else {
        $offset = 0;
        $page_id = 1;
    }

    // echo $query . " LIMIT 8 OFFSET $offset";

    $result = Database::search($query . " LIMIT 8 OFFSET $offset");
 

    if ($result->num_rows != 0) {

        for ($x = 0; $x < $result->num_rows; $x++) {
            $result_arr = $result->fetch_assoc();

            $exploded = explode(" ", $result_arr["datetime"]);
            $date = $exploded[0];

?>
            <div data-invoice="<?= $result_arr["oid"]?>" class="row border border-bottom-1 border-top-0 border-end-0 border-start-0" style="min-width: 768px;">
                <div class="col-1 col-md-1 p-2 text-center text-white bg-dark"><?= $offset += 1 ?></div>
                <div class="col-2 col-md-2 p-2 text-center text-white bg-secondary"><?= $result_arr["oid"] ?></div>
                <div class="col-2 col-md-2 p-2 text-center text-white bg-dark"><?= $date ?></div>
                <div class="col-2 col-md-2 p-2 text-center text-white bg-secondary"><button id="ItemDetails" class="btn btn-primary">Check Invoice</button></div>
                <div class="col-1 col-md-1 p-2 text-center text-white bg-dark"><?= $result_arr["total"] ?></div>
                <div class="col-2 col-md-2 p-2 text-center bg-secondary text-white"><?= $result_arr["email"] ?></div>
                <div class="col-2 col-md-2 p-2 d-grid">
                    <select id="status" class="form-control text-center">
                        <?php
                        $order_status = Database::search("SELECT * FROM `order_status`");
                        for ($y = 0; $y < $order_status->num_rows; $y++) {

                            $order_status_arr = $order_status->fetch_assoc();

                            if ((int)$result_arr["status"] == (int)$order_status_arr["id"]) {
                        ?>
                                <option value="<?= $order_status_arr["id"] ?>" selected><?= $order_status_arr["name"] ?></option>
                            <?php
                            } else {
                            ?>
                                <option value="<?= $order_status_arr["id"] ?>"><?= $order_status_arr["name"] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        <?php
        }

        // pagination
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
            <h1>No Matching Results Found:(</h1>
        </div>
<?php
    }
}
