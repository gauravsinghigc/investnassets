<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");

if (isset($_POST['2ndScreen'])) {
  $VisitorPersonName = $_POST['VisitorPersonName'];
  $VisitorPersonPhone = $_POST['VisitorPersonPhone'];
  $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
  $VISITOR_TYPES = $_POST['VISITOR_TYPES'];
  $VisitPeronsDescription = $_POST['VisitPeronsDescription'];
} else {
  LOCATION("warning", "Please Enter visitor details first!", "add.php");
}
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
        <h5 class="app-heading">2</h5>
        <p class="text-primary">Select Meeting Person</p>
      </div>
    </div>
    <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
      <?php FormPrimaryInputs(true, [
        "VisitorPersonName" => $VisitorPersonName,
        "VisitorPersonPhone" => $VisitorPersonPhone,
        "VisitorPersonEmailId" => $VisitorPersonEmailId,
        "VISITOR_TYPES" => $VISITOR_TYPES,
        "VisitPeronsDescription" => $VisitPeronsDescription,
        "VisitPurpose" => $_POST['VisitPurpose'],
      ]); ?>
      <div class="col-md-4 col-12 col-lg-6">
        <label class="fs-16">Enter Person Name</label>
        <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control form-control-lg fs-20' placeholder="Start Type Employee Name...">
        <hr>
        <div class='data-display no-shadow height-limit'>
          <?php
          $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
          if ($AllUsers == null) {
            NoData("No Users found!");
          } else {
            foreach ($AllUsers as $User) {
          ?>
              <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data-list bg-primary rounded m-b-3 hidden'>
                <div class="flex-s-b">
                  <div class="w-pr-20">
                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                  </div>
                  <div class="text-left w-pr-80 pl-2">
                    <label class="w-100 lh-0-0-1">
                      <span class="h6 fs-18 bold mt-0"><?php echo $User->UserFullName; ?></span><br>
                      <small class="text-gray small">
                        <span class="fs-12 text-white"><?php echo $User->UserPhoneNumber; ?></span><br>
                        <span class="fs-12 text-white"><?php echo $User->UserEmailId; ?></span><br>
                        <span class="fs-12 text-white">
                          <span>#<?php echo EMP_CODE; ?><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                          (<span><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                          @
                          <span><?php echo FETCH("SELECT * FROM user_access where UserAccessUserId='" . $User->UserId . "' ORDER BY UserAccessId DESC limit 1", "UserAccessName"); ?></span> -
                          <span><?php echo UserLocation($User->UserId); ?></span>
                        </span>
                      </small>
                      <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                    </label>
                  </div>
                </div>
              </label>
          <?php
            }
          } ?>
        </div>
      </div>
      <div class="col-md-12 text-center">
        <button class="btn btn-lg btn-success fixed-bottom fs-25" name="CreateVisit">Save Visit Details <i class='fa fa-check'></i></button>
      </div>
    </form>
  </div>

  <?php
  include $Dir . "/include/app/Footer.php";
  include $Dir . "/include/forms/VisitorAddPopWindow.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>