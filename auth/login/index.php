<?php
require "../../acm/SysFileAutoLoader.php";

$PageName = "Login to Account";
$PageDecs = SHORT_DESCRIPTION;
$PageIcon = "fa-lock";

if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app/index.php");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Login</title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition login-page app-bg" style="background-size:cover;background-repeat:no-repeat;">
    <div class="login-box">
        <?php
        include "../../include/app/Loader.php"; ?>
        <div class="card border-0">
            <?php include "../../include/common/auth-page-logo.php"; ?>
            <div class="card-body">
                <form action="<?php echo CONTROLLER("AuthController/AuthController.php"); ?>" method="POST" class="fs-13px">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="form-group mb-20px">
                        <label for="emailAddress" class="text-gray-600 fs-17">Email Address</label>
                        <input type="email" class="form-control form-control-lg h-40px fs-20" name="UserEmailId" placeholder="Email Address" />
                    </div>
                    <div class="form-group mb-15px m-t-15">
                        <label for="password" class="fs-17 text-gray-600">Password</label>
                        <input type="password" Id='PasswordControl' name="UserPassword" class="form-control form-control-lg h-40px fs-20" placeholder="*******" />
                        <span onclick="PasswordControl()" id='ViewIcon' class="PassControl"><i class="fa fa-eye-slash"></i></span>
                    </div>
                    <div class="text-dark p-2 pl-0 mt-2 mb-2 text-right fs-16">
                        Forget Password? <a href="<?php echo DOMAIN; ?>/auth/forget/" class="text-primary">Recover Password</a>
                    </div>
                    <div class="mb-15px">
                        <button type="submit" name="LoginRequest" class="btn btn-primary btn-block w-100 p-2 btn-lg fs-25"><i class="fa fa-lock app-text"></i> Secured Login</button>
                    </div>
                    <hr class="bg-gray-600 opacity-2 mt-50px" />
                    <?php include "../../include/auth/login-footer.php"; ?>
                </form>
            </div>
        </div>

    </div>

    <script>
        function PasswordControl() {
            var x = document.getElementById("PasswordControl");
            if (x.type === "password") {
                x.type = "text";
                document.getElementById('ViewIcon').innerHTML = '<i class="fa fa-eye"></i>';
            } else {
                x.type = "password";
                document.getElementById('ViewIcon').innerHTML = '<i class="fa fa-eye-slash"></i>';
            }
        }
    </script>


    <?php include "../../assets/FooterFiles.php"; ?>
</body>

</html>