<?php

session_start();

if(!isset($_SESSION["user"])){
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link rel="icon" href="resources/images/Logo.png">
    <link rel="stylesheet" href="resources/css/bootstrap.css" />
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

    <div class="container-fluid ">

        <div class="row align-items-center">
            <div class="d-none col-6 d-md-block background-img vh-100"></div>

            <div class="col-12 col-md-6">
                <div class="row align-items-center vh-100">

                    <!-- login section -->

                    <?php

                    $email;
                    $password;
                    if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
                        $email = $_COOKIE["email"];
                        $password = $_COOKIE["password"];
                    } else {
                        $email = "";
                        $password = "";
                    }

                    ?>

                    <div class="col-12 mt-3 p-4" id="signinbox">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="resources/Logo.png" style="width: 250px;" />
                                <label class="form-lable"></label>
                            </div>
                            <div class="col-12">
                                <h2 class="col-12 text-start">Login</h2>
                            </div>
                            <div class="col-12 mt-3 fw-bold">
                                <label class="form-label fs-5">Enter Email</label>
                                <input type="email" class="form-control fs-5" id="email1" value="<?php echo $email ?>">
                            </div>
                            <div class="col-12 mt-3 fw-bold">
                                <label class="form-label fs-5">Enter Password</label>
                                <input type="password" class="form-control fs-5" id="password1" value="<?php echo $password ?>">
                            </div>
                            <div class="col-12 mt-3 d-flex align-items-center">
                                <span class="fw-light fs-5">Remember Me</span>
                                <?php
                                if (isset($_COOKIE["email"]) && isset($_COOKIE["password"])) {
                                ?>
                                    <input type="checkbox" style="height: 20px;width: 30px;" id="remember" checked>
                                <?php
                                } else {
                                ?>
                                    <input type="checkbox" style="height: 20px;width: 30px;" id="remember">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-12 mt-3 d-grid">
                                <button class="btn btn-primary" id="login">Login</button>
                            </div>
                            <div class="col-6 text-start mt-3">
                                <a class="text-decoration-none" style="cursor: pointer;" id="change1">Sign Up?</a>
                            </div>
                            <div class="col-6 text-end mt-3">
                                <a class="text-decoration-none" style="cursor: pointer;" id="frgtPassBtn">Forgot Password?</a>
                            </div>
                        </div>
                    </div>

                    <!-- sign up -->
                    <div class="col-12 mt-3 p-4 d-none" id="signupbox">
                        <div class="row">
                            <div class="col-12 text-center">
                                <img src="resources/Logo.png" style="width: 250px;" />
                                <label class="form-lable"></label>
                            </div>
                            <div class="col-12 ">
                                <h2 class="col-12 text-start">Sign Up</h2>
                            </div>
                            <div class="col-6 mt-3 fw-bold">
                                <label class="form-label">Enter First Name</label>
                                <input type="text" class="form-control" id="fname">
                            </div>
                            <div class="col-6 mt-3 fw-bold">
                                <label class="form-label">Enter Last Name</label>
                                <input type="text" class="form-control" id="lname">
                            </div>
                            <div class="col-12 mt-3 fw-bold">
                                <label class="form-label">Enter Email</label>
                                <input type="email" class="form-control" id="email2">
                            </div>
                            <div class="col-6 mt-3 fw-bold">
                                <label class="form-label">Enter Password</label>
                                <input type="password" class="form-control" id="spassword1">
                            </div>
                            <div class="col-6 mt-3 fw-bold">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="spassword2">
                            </div>
                            <div class="col-12 mt-3 d-grid">
                                <button class="btn btn-warning" id="signUp">Sign Up</button>
                            </div>
                            <div class="col-12 text-start mt-3">
                                <a class="text-decoration-none" style="cursor: pointer;" id="change2">Already have an account?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mb-3 fixed-bottom">
                <label class="form-label text-black-50 m-0 p-0">Copywright &copy; 2022 Smart Essentials</label>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="forgotPasswordModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Change Password</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12">
                                <label class="form-label fw-bold fs-5">Enter Varification Number</label>
                                <input type="text" class="form-control" id="variNum" placeholder="Enter Varification">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-5">Enter New Password</label>
                                <div class="d-flex align-items-center">
                                    <input type="password" id="newPass1" class="form-control" placeholder="Password">
                                    <a class="text-decoration-none ms-2" style="cursor: pointer;" id="showPas1">Show</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold fs-5">Re-enter New Password</label>
                                <div class="d-flex align-items-center">
                                    <input type="password" id="newPass2" class="form-control" placeholder="Password">
                                    <a class="text-decoration-none ms-2" style="cursor: pointer;" id="showPas2">Show</a>
                                </div>
                            </div>  
                            <div class="col-12 mt-3 d-grid">
                                <button type="button" class="btn btn-warning d-block" id="changepassword">Change</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="javascript/bootstrap.min.js"></script>
    <script src="javascript/login.js"></script>
</body>

</html>
<?php
}else{
    header('Location: index.php');
}

?>