<?php

session_start();

require "../connection.php";
require "../public.class.php";

if (isset($_SESSION["admin"])) {

    $query = "SELECT * FROM `user` ";

    if (!empty($_GET["input"])) {
        $query .= "WHERE `email` LIKE '" . $_GET["input"] . "%'";
    }

    $offset;
    $page_id;
    if ($_GET["page_id"] != "undefined" && (int)$_GET["page_id"] > 0) {
        $offset = 10 * ((int)$_GET["page_id"] - 1);
        $page_id = $_GET["page_id"];
    } else {
        $offset = 0;
        $page_id = 1;
    }

    $result = Database::search($query . " LIMIT 10 OFFSET $offset");

    if ($result->num_rows != 0) {

        for ($x = 0; $x < $result->num_rows; $x++) {

            $arr = $result->fetch_assoc();

            $images = Database::search("SELECT * FROM `profile_images` WHERE `user_email`='" . $arr["email"] . "'");

            $image;
            if ($images->num_rows != 0) {
                $image_arr = $images->fetch_assoc();
                $image = "processes/profile/" . $image_arr["code"];
            } else {
                $image = "processes/profile/profilePics/172626_user_male_icon.png";
            }

?>
            <tr data-email="<?= $arr["email"] ?>">
                <th scope="row"><?= $offset += 1 ?></th>
                <td><img src="<?= $image ?>" style="width: 75px;height: 75px;object-fit: cover;" class="rounded-circle" alt=""></td>
                <td><?= $arr["fname"] . " " . $arr["lname"] ?></th>
                <td><?= $arr["email"] ?></td>
                <td><?= $arr["mobile"] ?></td>
                <td><?= $arr["register_datetime"] ?></td>
                <td>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <?php
                                if ($arr["status_id"] == "1") {
                                ?>
                                    <button class="btn btn-primary block-unblock" id="blockBtn">Block</button>
                                <?php
                                } elseif ($arr["status_id"] == "2") {
                                ?>
                                    <button class="btn btn-success block-unblock" id="blockBtn">Unblock</button>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-danger " id="chatbtn">Chat</button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
        }

        $BtnCount = Common::getButtonCount(Database::search($query)->num_rows, 10);
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
        <tr>
            <td colspan="7">
                <div class="col-12 d-flex justify-content-center align-items-center" style="height: 400px; background-color: whitesmoke;">
                    <label class="form-label mt-4 mb-5 fs-3">No Matching Users:(</label>
                </div>
            </td>

        </tr>
<?php

    }
} else {
}

?>