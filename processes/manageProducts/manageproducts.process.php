<?php

require "../connection.php";
require "../public.class.php";

$price = (int)$_POST["price"];
$status = (int)$_POST["status"];
$condition = (int)$_POST["condition"];
$availability = (int)$_POST["availability"];
$input = $_POST["input"];

$query = "SELECT * FROM `product` ";

if (!empty($input)) {
    $query = Common::checker($query);
    $query .= "LOWER(`name`) LIKE LOWER('%" . $input . "%')";
}

if ($status == 1) {
    $query = Common::checker($query);
    $query .= "`status_id`='1'";
} else if ($status == 2) {
    $query = Common::checker($query);
    $query .= "`status_id`='2'";
}

if ($condition == 1) {
    $query = Common::checker($query);
    $query .= "`condition_id`='1'";
} else if ($condition == 2) {
    $query = Common::checker($query);
    $query = $query .= "`condition_id`='2'";
}

if ($availability == 1) {
    $query = Common::checker($query);
    $query .= "`qty`='0'";
} else if ($availability == 2) {
    $query = Common::checker($query);
    $query .= "`qty`!='0'";
}

if (!empty($price) && $price == 1) {
    $query .= " ORDER BY `price` DESC";
} else if (!empty($price) && $price == 2) {
    $query .= " ORDER BY `price` ASC";
}

$limit = 6;

$offset;
$page_id;
if ($_POST["page_id"] != "undefined") {
    $offset = $limit * ((int)$_POST["page_id"] - 1);
    $page_id = (int)$_POST["page_id"];
} else {
    $offset = 0;
    $page_id = 1;
}

$product_results = Database::search($query . " LIMIT " . $limit . " OFFSET " . $offset);

if ($product_results->num_rows != 0) {

?>

    <div class="col-12">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
            <?php

            for ($x = 0; $x < $product_results->num_rows; $x++) {

                $product_arr = $product_results->fetch_assoc();

                $image = Database::search("SELECT * FROM `product_images` WHERE `product_id`='" . $product_arr["id"] . "'");

                $img_arr = $image->fetch_assoc();

                $condition_name;
                if ((int)$product_arr["condition_id"] == 1) {
                    $condition_name = "New";
                } else {
                    $condition_name = "Used";
                }

            ?>
                <div class="col mb-3">
                    <div class="card h-100">
                        <div class="col-12 d-flex justify-content-between text-sm-start py-2 px-2">
                            <small class="text-black-50 fw-bold"><?= $condition_name; ?></small>
                            <small class="text-black-50" style="cursor: pointer;"><a class="text-decoration-none" href="UpdateProduct.php?id=<?= $product_arr["id"] ?>">Update</a></small>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="#" title="View item"><img src="processes//<?= $img_arr["code"]; ?>" style="object-fit: contain;width: 150px;" class="card-img-top"></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fs-5"><?= $product_arr["name"]; ?></h5>
                            <p class="fw-bold text-danger m-0 fs-6">Rs. <?= number_format($product_arr["price"], 2); ?></p>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <?php
                                    if ((int)$product_arr["status_id"] == 1) {
                                    ?>
                                        <input class="form-check-input" onclick="deactivate('<?= $product_arr['id'] ?>')" type="checkbox" id="switch<?= $product_arr["id"] ?>" checked>
                                        <label class="form-check-label fw-bold" id="statuslable<?= $product_arr['id'] ?>" for="switch<?= $product_arr["id"] ?>">Active</label>
                                    <?php
                                    } else {
                                    ?>
                                        <input class="form-check-input" onclick="deactivate('<?= $product_arr['id'] ?>')" type="checkbox" id="switch<?= $product_arr["id"] ?>">
                                        <label class="form-check-label fw-bold" id="statuslable<?= $product_arr['id'] ?>" for="switch<?= $product_arr["id"] ?>">Deactive</label>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php

            }

            ?>
        </div>
    </div>

    <?php

    $product_count = Database::search($query)->num_rows;

    $button_count = Common::getButtonCount($product_count, $limit);

    ?>

    <div class="col-12 d-flex justify-content-end">
        <nav>
            <ul class="pagination">
                <?php

                if ($page_id - 1 <= 0) {
                ?>
                    <li class="page-item disabled"><a class="page-link pointer">Previous</a></li>
                <?php
                } else {
                ?>
                    <li class="page-item"><a data-pageId="<?= $page_id - 1 ?>" class="page-link pointer">Previous</a></li>
                <?php
                }

                ?>

                <?php

                for ($x = 1; $x <= $button_count; $x++) {

                    if ($page_id == $x) {
                ?>
                        <li class="page-item"><a data-pageId="<?= $x ?>" class="page-link pointer active"><?= $x; ?></a></li>
                    <?php
                    } else {
                    ?>
                        <li class="page-item"><a data-pageId="<?= $x ?>" class="page-link pointer"><?= $x; ?></a></li>
                    <?php
                    }
                }

                if ($page_id + 1 > $button_count) {
                    ?>
                    <li class="page-item disabled"><a class="page-link pointer">Next</a></li>
                <?php
                } else {
                ?>
                    <li class="page-item"><a data-pageId="<?= $page_id + 1 ?>" class="page-link pointer">Next</a></li>
                <?php
                }

                ?>

            </ul>
        </nav>
    </div>

<?php


} else {
?>
    <div class="col-12 mt-5 text-center">
        <h1>No Matching Items Found:(</h1>
    </div>
<?php
}
