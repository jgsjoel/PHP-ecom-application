<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-start p-1 bg-dark d-lg-none d-block">
                <button class="btn text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    Menue
                </button>
            </div>

            <div class="offcanvas offcanvas-start bg-dark" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white" id="offcanvasExampleLabel">Menue</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="col-12">
                        <div class="row">
                        <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="productregistration.php" class="adm-button">Add Product</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="ManageUsers.php" class="adm-button">Manage users</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="ManageProducts.php" class="adm-button">Manage products</a>
                            </div>
                            <div class="col-12 d-grid pe-0 ps-2 mb-3">
                                <a href="sellinghistory.php" class="adm-button">Selling History</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="bootstrap.min.js"></script>
</body>

</html>