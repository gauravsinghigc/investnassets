<?php
require "../../acm/SysFileAutoLoader.php";
if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app/index.php");
}
$PageName = "Verify your account!";
$PageDecs = SHORT_DESCRIPTION;
$PageIcon = "fa-check-circle";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Forget</title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition login-page" style="background-image:url('<?php echo LOGIN_BG_IMAGE; ?>');background-size:cover;background-repeat:no-repeat;">
    <div class="login-box">
        <?php include "../../include/app/Loader.php"; ?>

        <div class="card">
            <?php include "../../include/common/auth-page-logo.php"; ?>
            <div class="card-body">
                <p class="mb-3 text-center fs-16"> Password Reset Link is sent successfully on submitted email id <b><?php echo $_SESSION['REQUESTED_EMAIL']; ?></b>. Change your password by following that link.</p>
                <a href="<?php echo DOMAIN; ?>/app" class="btn btn-primary p-2 d-block w-100 btn-lg fs-25"><i class="fa fa-angle-left app-text"></i> Back to Login</a>
                <hr class="bg-gray-600 opacity-2 mt-50px" />
                <?php include "../../include/auth/login-footer.php"; ?>
            </div>

        </div>

    </div>
    <?php include "../../assets/FooterFiles.php"; ?>
</body>

</html>