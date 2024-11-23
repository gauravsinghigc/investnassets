<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Users";
$PageDescription = "Manage teams";

if (LOGIN_UserType == "Admin") {
  $location = "";
} else {
  $location = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-10 col-9 col-xs-9">
                      <div class="app-heading">
                        <h4 class="mb-0 text-white"><?php echo $PageName; ?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-md-2 col-3 col-xs-3">
                      <a href="add.php" class="btn btn-block btn-danger pull-right">
                        <i class="fa fa-plus"></i>
                        Add User
                      </a>
                    </div>
                  </div>
                  <?php echo ClearFilters(); ?>
                  <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                      <form action="" method="get" style="display:flex;justify-content:start;">
                        <div class="form-group w-pr-10 mb-0">
                          <input type="text" name="EMP_Code" value='<?php echo IfRequested("GET", "EMP_Code", "", false); ?>' list="empcodes" onchange="form.submit()" class="form-control mb-0" placeholder="EMP Code">
                          <datalist id="empcodes">
                            <?php
                            $Users = _DB_COMMAND_("SELECT UserId, UserEmpJoinedId FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserId'])) {
                                  if ($_GET['UserId'] == $User->UserId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserEmpJoinedId; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group w-pr-15 ml-2 mb-0">
                          <input type="text" name="Full_Name" value='<?php echo IfRequested("GET", "Full_Name", "", false); ?>' list="UserId" onchange="form.submit()" class="form-control mb-0" placeholder="Search full name...">
                          <datalist id="UserId">
                            <?php
                            $Users = _DB_COMMAND_("SELECT UserId, UserFullName FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserId'])) {
                                  if ($_GET['UserId'] == $User->UserId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserFullName; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group mb-0 w-pr-10 ml-2">
                          <select name="viewGroup" class="form-control  mb-0" onchange="form.submit()">
                            <option value="">All</option>
                            <?php
                            $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                            if ($leadStages != null) {
                              foreach ($leadStages as $g) {
                                if (isset($_GET['view'])) {
                                  if ($_GET['view'] == $g->ConfigValueDetails) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected = "";
                                } ?> <option value="<?php echo $g->ConfigValueDetails; ?>" <?php echo $selected; ?>>
                                  <?php echo $g->ConfigValueDetails; ?></option>
                            <?php }
                            } else {
                              echo "<option value='Null'>No Data Found!</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <?php
                        if (LOGIN_UserType == "Admin") {
                          $UserLocations = ""; ?>
                          <div class="form-group w-pr-10 ml-2 mb-0">
                            <select name="location" class="form-control mb-0 " onchange="form.submit()">
                              <option value="">All location</option>
                              <?php $GetOfficeLocations = _DB_COMMAND_("SELECT * FROM config_locations where config_location_status='1'", true);
                              if ($GetOfficeLocations != null) {
                                foreach ($GetOfficeLocations as $Locations) {
                                  if (isset($_GET['location'])) {
                                    if ($Locations->config_location_id == $_GET['location']) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option <?php echo $selected; ?> value='<?php echo $Locations->config_location_id; ?>'><?php echo $Locations->config_location_name; ?></option>
                              <?php
                                }
                              } else {
                                echo "<option value='0'>No Location!</option>";
                              } ?>
                            </select>
                          </div>
                        <?php } else {
                          $UserLocations = UserLocation(LOGIN_UserId); ?>
                        <?php } ?>

                        <div class="form-group w-pr-15 ml-2 mb-0">
                          <input type="text" name="Phone_Number" value='<?php echo IfRequested("GET", "Phone_Number", "", false); ?>' list="Phones" onchange="form.submit()" class="form-control mb-0" placeholder="Search phone number...">
                          <datalist id="Phones">
                            <?php
                            $Users = _DB_COMMAND_("SELECT UserId, UserPhoneNumber FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserId'])) {
                                  if ($_GET['UserId'] == $User->UserId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserPhoneNumber; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group w-pr-15 ml-2 mb-0">
                          <input type="text" name="Email_Ids" value='<?php echo IfRequested("GET", "Email_Ids", "", false); ?>' list="emails" onchange="form.submit()" class="form-control mb-0" placeholder="Search emails...">
                          <datalist id="emails">
                            <?php
                            $Users = _DB_COMMAND_("SELECT UserId, UserEmailId FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserId'])) {
                                  if ($_GET['UserId'] == $User->UserId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserEmailId; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>



                        <div class="form-group w-pr-10 ml-2 mb-0">
                          <input ype="text" name="UserEmpBloodGroup" list="UserEmpBloodGroup" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter Blood Group Name">
                          <datalist id="UserEmpBloodGroup">
                            <?php
                            $Users = _DB_COMMAND_("SELECT UserEmpBloodGroup FROM user_employment_details GROUP BY UserEmpBloodGroup", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserEmpBloodGroup'])) {
                                  if ($_GET['UserEmpBloodGroup'] == $User->UserEmpBloodGroup) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserEmpBloodGroup; ?>" <?php echo $selected; ?>>
                                  <?php echo $User->UserEmpBloodGroup; ?></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group w-pr-10 ml-2 mb-0">
                          <select name="UserStatus" onchange="form.submit()" class="form-control mb-0">
                            <?php echo InputOptionsWithKey([
                              "1" => "Active Users",
                              "0" => "Inactive Users",
                              "" => "All Users",
                            ], IfRequested("GET", "UserStatus", "", false)); ?>
                          </select>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-12">
                      <div class="data-list shadow-sm bg-primary text-white app-sub-heading">
                        <p class="flex-s-b">
                          <span class="w-pr-3 text-left text-white">Sno</span>
                          <span class="w-pr-8 text-left text-white">EMPCode</span>
                          <span class="w-pr-25 text-left text-white">Full Name</span>
                          <span class="w-pr-12 text-left text-white">Location</span>
                          <span class="w-pr-12 text-left text-white">PhoneNumber</span>
                          <span class="w-pr-25 text-left text-white">EmailId</span>
                          <span class="w-pr-5 text-left text-white">Blood</span>
                          <span class="w-pr-10 text-left text-white">AccessLevel</span>
                          <span class="w-pr-10 text-right text-white">Login</span>
                        </p>
                      </div>
                    </div>
                    <?php
                    $listcounts = 25;
                    $start = START_FROM;
                    if (isset($_GET['viewGroup'])) {
                      $UserEmpGroupName = $_GET['viewGroup'];
                      $location = IfRequested("GET", "location", FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations"), false);
                      $search_value = $_GET['Full_Name'];
                      $UserEmpBloodGroup = $_GET['UserEmpBloodGroup'];
                      $UserStatus = $_GET['UserStatus'];
                      $Phone_Number = $_GET['Phone_Number'];
                      $EMP_Code = $_GET['EMP_Code'];
                      $Email_Ids = $_GET['Email_Ids'];
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomersSql = "SELECT UserMainUserId, UserEmpBloodGroup, UserEmpGroupName, UserEmpJoinedId FROM users, user_employment_details where users.UserEmailid like '%$Email_Ids%' and user_employment_details.UserEmpJoinedId like '%$EMP_Code%' and users.UserPhoneNumber like '%$Phone_Number%' and users.UserStatus like '%$UserStatus%' and UserEmpBloodGroup like '%$UserEmpBloodGroup%' and users.UserId=user_employment_details.UserMainUserId and users.UserFullName like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserId DESC";
                      } else {
                        $AllCustomersSql = "SELECT UserMainUserId, UserEmpBloodGroup, UserEmpGroupName, UserEmpJoinedId FROM users, user_employment_details where users.UserEmailid like '%$Email_Ids%' and user_employment_details.UserEmpJoinedId like '%$EMP_Code%' and users.UserPhoneNumber like '%$Phone_Number%' and users.UserStatus like '%$UserStatus%' and UserEmpBloodGroup like '%$UserEmpBloodGroup%' and users.UserId=user_employment_details.UserMainUserId and users.UserFullName like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserId DESC";
                      }
                    } else {
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomersSql = "SELECT UserMainUserId, UserEmpBloodGroup, UserEmpGroupName, UserEmpJoinedId FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC";
                      } else {
                        $AllCustomersSql = "SELECT UserMainUserId, UserEmpBloodGroup, UserEmpGroupName, UserEmpJoinedId FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserId DESC";
                      }
                    }

                    $AllCustomers = _DB_COMMAND_($AllCustomersSql . " limit $start, $listcounts", true);
                    if ($AllCustomers != null) {
                      if (TOTAL($AllCustomersSql) == 0) {
                        $Sno = 1;
                      } else {
                        $Sno = TOTAL($AllCustomersSql) + 1;
                      }
                      foreach ($AllCustomers as $Customers) {
                        $Sno--;
                        $UserMainUserId = $Customers->UserMainUserId;
                        $REQ_UserId = $Customers->UserMainUserId;
                        $LOGIN_UserProfileImage1 = GetUserImage($REQ_UserId);
                        $UserStatus = FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus");
                        $Status = StatusViewWithText($UserStatus);
                        $Selection = ReturnSelectionStatus($UserStatus);
                        if ($UserStatus == 1) {
                          $DivView = "active";
                        } else {
                          $DivView = "inactive";
                        }
                    ?>
                        <div class="col-md-12">
                          <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list record-status <?php echo $DivView; ?>">
                            <p class="mb-0 flex-s-b">
                              <span class='w-pr-3 text-left'>
                                <?php echo $Sno; ?>
                              </span>
                              <span class="w-pr-8 text-left text-black">
                                <?php
                                if ($Customers->UserEmpJoinedId == "NEW") {
                                  $CheckIfOnboardingDone = CHECK("SELECT * FROM user_onboarding where users_main_id='$UserMainUserId' and user_verification_status='1' and user_verification_approval_status='1'");
                                  if ($CheckIfOnboardingDone == null) {
                                    echo "<i class='fa fa-star text-warning fa-spin'></i> NEW";
                                  } else {
                                    echo "<i class='fa fa-warning text-warning blink-data'></i> PENDING";
                                  }
                                } else {
                                  echo StatusView($UserStatus) . " " . EMP_CODE . "-" . $Customers->UserEmpJoinedId;
                                }
                                ?>
                              </span>
                              <span class='w-pr-25 text-left'>
                                <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                  <span class="text-primary bold">
                                    <img src="<?php echo $LOGIN_UserProfileImage1; ?>" class="img-fluid rounded list-img">
                                    <b><?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?></b>
                                  </span>
                                  <b><?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                </a>
                              </span>
                              <span class='w-pr-12 text-left'>
                                <span>
                                  <b><?php echo $Customers->UserEmpGroupName; ?></b> @ <i class="fa fa-map-marker text-success"></i> <?php echo UserLocation($Customers->UserMainUserId); ?>
                                </span>
                              </span>
                              <span class='w-pr-12 text-left'>
                                <a href="tel:<?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                  <i class="fa fa-phone text-success"></i>
                                  <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                </a>
                              </span>
                              <span class='w-pr-25 text-left'>
                                <a href="mailto:<?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>">
                                  <i class="fa fa-envelope text-warning"></i>
                                  <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>
                                </a>
                              </span>
                              <span class='w-pr-5 text-left'>
                                <i class="bi bi-droplet-fill text-danger"></i>
                                <?php
                                if ($Customers->UserEmpBloodGroup == "Select Bloog Group") {
                                  echo "NA";
                                } else {
                                  echo $Customers->UserEmpBloodGroup;
                                }
                                ?>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span class='members'>
                                  <span class='member-count'><i class='fa fa-shield'></i> View Access</span>
                                  <span class='record-list'>
                                    <?php echo UserAllAccessLevel($UserMainUserId); ?>
                                  </span>
                                </span>
                              </span>
                              <span class='w-pr-10 text-right'>
                                <form action="<?php echo CONTROLLER; ?>" method="POST" class="pull-right user-status">
                                  <?php echo FormPrimaryInputs(true, [
                                    "UserId" => $UserMainUserId,
                                    "UpdateUserStatus" => "true"
                                  ]); ?>
                                  <div class="custom-control custom-switch">
                                    <input onchange="form.submit()" value='1' name='UserStatus' <?php echo $Selection; ?> type="checkbox" class="custom-control-input" id="customSwitch<?php echo $UserMainUserId; ?>">
                                    <label class="custom-control-label" for="customSwitch<?php echo $UserMainUserId; ?>"></label>
                                  </div>
                                </form>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                      }
                    }
                    PaginationFooter(TOTAL($AllCustomersSql), "index.php");
                    ?>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </section>
  </div>

  <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>