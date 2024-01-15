<?php

session_start();

$_SESSION["admin"] = array("email" => "jgsjoelsmith@gmail.com");

if (isset($_SESSION["admin"])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin | Manage Users</title>
        <link rel="icon" href="resources/images/Logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.css" />
        <link rel="stylesheet" href="resources/css/style.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center bg-dark">
                    <!-- <a href="adminPannel.php" class="float-start text-decoration-none text-white">&lt &lt Admin Pannel</a> -->
                    <label class="form-label mt-3 mb-3 fs-3 text-white">Manage Users</label>
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 text-center mt-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 d-flex">
                                            <input type="text" class="form-control" id="input" placeholder="Search For User...">
                                            <button class="btn btn-dark ms-0 ms-md-2" id="search">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Registered Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userDetails">
                                    <!-- users  -->
                                </tbody>
                            </table>
                            <div class="col-12 text-end">

                            </div>
                        </div>

                    </div>
                </div>

                <?php require "footer.php" ?>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: black;">
                        <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close-white " data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: whitesmoke;height: 400px;overflow-y: auto;">
                        <div class="col-12">
                            <div class="row g-2" id="messageArea">
                                <!-- messages -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color: black;">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control w-100" id="msgInput" placeholder="Type Your Message Here...">
                                </div>
                                <div class="col-2 text-center">
                                    <button type="button" id="msgSend" class="btn btn-danger">Send <i class="bi bi-send-fill"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/manageusers.js"></script>
    </body>

    </html>
<?php

} else {
    header("Location: adminLogin.php");
}














?>