<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <meta http-equiv="refresh" content="5; index.php" />
</head>

<body class="hold-transition m-0">

  <div class="container-fluid p-2">
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="<?php echo APP_LOGO; ?>" class="recep-logo p-4 no-shadow mt-2">

        <h1 class="display-5 bold mt-5 pt-5">Thanking you</h1>
        <h4 class="mt-4 display-5 mb-3">
          Thank you for your visit! We appreciate your time with us.
        </h4>
        <span class="fixed-bottom pb-5" style="margin-bottom: 7rem;">Redirecting to Welcome Page in ....<span class="count">5</span>sec <i class="fa fa-spinner fa-spin"></i></span>
        <img src="<?php echo STORAGE_URL_D; ?>/bg/recep-bottom-banner.png" class="rece-bottom-img no-shadow">
      </div>
    </div>
  </div>

  <?php
  include $Dir . "/include/app/Footer.php";
  include $Dir . "/include/forms/VisitorAddPopWindow.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>