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
</head>

<body class="hold-transition m-0">

  <div class="container-fluid p-2">
    <div class="row pb-4">
      <div class="col-md-12 text-center pb-4 pt-3">
        <img src="<?php echo APP_LOGO; ?>" class="img-fluid w-50 no-shadow">
      </div>
      <div class="col-md-6 col-6 text-center">
        <a href="">
          <h5 class="app-heading">1</h5>
          <p class="text-primary">Enter visitor details</p>
        </a>
      </div>
      <div class="col-md-6 col-6 text-center">
        <h5 class="app-sub-heading">2</h5>
        <p class="text-secondary">Select Meeting Person</p>
      </div>
    </div>
    <form class="row" action="meeting.php" method="POST">
      <div class="col-md-6">
        <div class="row">
          <div class='col-md-4 form-group mt-3'>
            <label class="fs-16">Full Name <?php echo $req; ?></label>
            <input type="text" name="VisitorPersonName" placeholder="Enter your full name" class="form-control bg-white form-control-lg fs-20" required="">
          </div>
          <div class='col-md-4 form-group mt-3'>
            <label class="fs-16">Phone Number <?php echo $req; ?></label>
            <input type="tel" name="VisitorPersonPhone" placeholder="+91" class="form-control form-control-lg fs-20" required="">
          </div>
          <div class='col-md-4 form-group mt-3'>
            <label class="fs-16">Email-ID</label>
            <input type="email" name="VisitorPersonEmailId" class="form-control form-control-lg fs-20" placeholder="email@domain.com">
          </div>
          <div class='col-md-6 form-group mt-3'>
            <label class="fs-16">Visit Type <?php echo $req; ?></label><br>
            <div class="row pl-2 pt-1">
              <?php echo CONFIG_VALUES_CHECKBOX("VISITOR_TYPES"); ?>
            </div>
          </div>
          <div class="col-md-12 col-12 form-group mt-3">
            <label class="fs-16">Address</label>
            <input type="text" name="VisitPurpose" class="form-control form-control-lg fs-20" placeholder="Office Address, city, state">
          </div>
          <div class="form-group col-md-12 mt-3">
            <label class="fs-16">Add Note & Remarks</label>
            <textarea name="VisitPeronsDescription" class="form-control form-control-lg fs-20" rows="3"></textarea>
          </div>
          <div class='col-md-12 text-right'>
            <a href="index.php" class="btn btn-lg btn-default mt-3 mr-3 pull-left"><i class="fa fa-angle-left"></i> Back</a>
            <button type="submit" name="2ndScreen" class='btn btn-lg btn-success fs-20 fixed-bottom'>Select Meeting Person <i class='fa fa-angle-right'></i></button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <br><br>
  <?php
  include $Dir . "/include/app/Footer.php";
  include $Dir . "/include/forms/VisitorAddPopWindow.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>