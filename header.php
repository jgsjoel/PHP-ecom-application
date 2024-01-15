<div class="col-12 nav-header-wrapper p-0">
    <!-- header -->
    <div class="col-12 text-start py-1 nav-header">
        <label class="form-label ps-3">Welcome <?php

                                                if (isset($_SESSION["user"])) {
                                                ?>
                <span><?= $_SESSION["user"]["fname"]; ?></span>
                <a href="processes/Logout.php">LogOut</a>
            <?php
                                                } else {
            ?>
                <span>user</span>
                <a href="Login.php">Login</a>
            <?php
                                                }

            ?></label>

    </div>
    <!-- navigation -->
    <div class="col-12 navigation">
        <a href="Home.php"><img src="resources/images/Logo.png" width="175px"></a>

        <div class="navigation-elements">
            <i class="bi bi-search pe-4" style="cursor: pointer; font-size: 1.5rem;" id="openSearch"></i>

            <div>
                <div class="navgation-options">
                    <div class="col-12 text-end p-3 closebtnCont"><i class="bi bi-x-lg" style="color: white;font-size: 1.4rem;cursor: pointer;" id="closeNav"></i></div>
                    <a href="index.php" class="text-decoration-none">Home</a>
                    <a href="AdvancedSearch.php" class="text-decoration-none">Advanced</a>
                    <a href="account.php" class="text-decoration-none">Account</a>
                    <a href="cart.php" class="text-decoration-none">Cart</a>
                    <a href="watchlist.php" class="text-decoration-none">Watchlist</a>
                    <a href="purchaseHistory.php" class="text-decoration-none">History</a>
                </div>
            </div>

            <i class="bi bi-list me-2" style="color: black;font-size: 2rem;cursor: pointer;" id="openNav"></i>
        </div>
    </div>

    <div class="col-12 dropdown-search-container">
        <div class="col-12 col-md-7">
            <form action="search.php" method="GET">
                <div class="input-group mb-3">
                    <select name="category" class="custom-selectTag d-none d-sm-block d-md-block">
                        <option value="0">All</option>
                        <?php
                        $ctae_res = Database::search("SELECT * FROM `category`");
                        for ($x = 0; $x < $ctae_res->num_rows; $x++) {
                            $cate_arr = $ctae_res->fetch_assoc();
                        ?>
                            <option value="<?= $cate_arr["id"] ?>"><?= $cate_arr["name"] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <input type="text" name="input" class="form-control" style="box-shadow: none;" placeholder="Search For Items...">
                    <button type="submit" class="btn btn-warning">Search</button>
                </div>
            </form>
        </div>
    </div>
    
</div>