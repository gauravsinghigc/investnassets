<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "ADD New team Member";
$PageDescription = "Manage all team";

$GetLatestEmpID = _DB_COMMAND_("SELECT * FROM user_employment_details GROUP BY UserEmpJoinedId ORDER BY UserEmpJoinedId DESC", true);
if ($GetLatestEmpID != null) {
  $EmpCodeArray = [];
  foreach ($GetLatestEmpID as $EmpCode) {
    $EmpCodes = $EmpCode->UserEmpJoinedId;
    $EmpNumbers = preg_replace('/[^0-9]/', '', $EmpCodes);
    if ($EmpNumbers != null) {
      if ($EmpNumbers != 0) {
        array_push($EmpCodeArray, $EmpNumbers);
      }
    }
  }
  $SortedArray = sort($EmpCodeArray);
  foreach ($EmpCodeArray as $Key => $Code) {
    $Code = $Code;
  }
} else {
  $Code = 0;
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
  <?php include $Dir . "/assets/HeaderFiles.php"; ?> <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper"> <?php  ?> <?php
                                  include $Dir . "/include/app/Header.php";
                                  include $Dir . "/include/sidebar/get-side-menus.php"; ?>
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
                    <div class="col-md-12">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                      <a href="index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to ALL Users</a>
                    </div>
                  </div>
                  <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='UserEmpJoinedId' value='NEW'>
                    <?php echo FormPrimaryInputs(true); ?> <div class="row">
                      <div class='col-md-4'>
                        <div class="shadow-sm b-r-1 p-2">
                          <h4 class='app-sub-heading'>Fill Require details for new users</h4>
                          <div class='app-setting-menus'>
                            <a class="active" onclick="GetRequiredForm('PrimaryForm', 'AForm')" id='AForm'><b class="text-success">(A)</b> Primary Information <i class="fa fa-angle-right"></i> <i class="fa fa-star text-danger fa-spin mr-3"></i></a>
                            <a onclick="GetRequiredForm('AddressForm', 'BForm')" id='BForm'><b class="text-success">(B)</b> Address Details<i class="fa fa-angle-right"></i></a>
                            <a onclick="GetRequiredForm('EmploymentForm', 'CForm')" id='CForm'><b class="text-success">(C)</b> Employement Information<i class="fa fa-angle-right"></i></a>
                            <a onclick="GetRequiredForm('BankAccountForm', 'DForm')" id='DForm'><b class="text-success">(D)</b> Bank Account Details <i class="fa fa-angle-right"></i></a>
                            <a onclick="GetRequiredForm('DocumentsForm', 'EForm')" id='EForm'><b class="text-success">(E)</b> Upload Documents <i class="fa fa-angle-right"></i></a>
                          </div>
                          <p class="mb-2 mt-3">All fileds with <b><i class="fa fa-star text-danger"></i></b> are mandatory fields, you have to fill it, can't empty.</p>
                          <ul>
                            <li>Only <b>Step A</b> is primary and required for HR. The rest of the document collection and other information submission will be done by the users/registered persons themselves.</li>
                            <li>The user will receive a unique URL for documentation and other required details submission.</li>
                            <li>HR or Admin will verify and approve the latest submitted details. If there are any missing or unverified details, HR/Admin may reject the application.</li>
                            <li>All new users will receive an onboarding form via their primary email ID, so be sure to fill in the correct email ID.</li>
                            <li><b>EMP CODE</b> will be generated after the verification of submitted details and documents. If any user skips the onboarding process, the EMP CODE will not be generated. Only verified users will get an employee code.</li>
                          </ul>
                        </div>
                      </div>
                      <div class='col-md-8'>
                        <div class='shadow-sm b-r-1 p-2'>
                          <div id='PrimaryForm'>
                            <h5 class="app-sub-heading">Primary Information</h5>
                            <div class="row">
                              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                                <label>Sal <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserSalutation" required="">
                                  <?php echo InputOptions(SALUTATION, "Select Sal *"); ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-9 col-md-9 col-sm-6 col-12">
                                <?php echo LABEL("User Full Name", TRUE); ?>
                                <input type="text" name="UserFullName" class="form-control" required="" placeholder="Full Name">
                              </div>
                              <div class="form-group col-lg-7 col-md-7 col-sm-6 col-12">
                                <?php echo LABEL("Primary Phone No <span id='phonemsg'></span>", TRUE); ?>
                                <input type="phone" Id='PhoneNumberCheck' oninput="CheckExistingPhoneNumbers()" name="UserPhoneNumber" class="form-control" value="" placeholder="without +91">
                              </div>
                              <div class="form-group col-lg-5 col-md-5 col-sm-12">
                                <label>Date of Birth</label>
                                <input type="date" pattern="\d{2}-\d{2}-\d{4}" name="UserDateOfBirth" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Blood Groups</label>
                                <select name="UserEmpBloodGroup" class="form-control">
                                  <?php echo InputOptions(
                                    [
                                      "Select Blood Group",
                                      "A+",
                                      "B+",
                                      "AB+",
                                      "0+",
                                      "A-",
                                      "B-",
                                      "O-"
                                    ],
                                    "Select Blood Group"
                                  ); ?>
                                </select>
                              </div>
                              <div class="col-md-12">
                                <hr>
                                <h5 class="app-sub-heading">Reporting Manager & Employement Details</h5>
                              </div>

                              <div class="form-group col-md-7">
                                <label>Reporting Manager <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserEmpReportingMember" required>
                                  <option value="0">Select Manager</option>
                                  <?php
                                  $Users = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
                                  foreach ($Users as $User) {
                                    if ($User->UserId == LOGIN_UserId) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                    $UserEmpSql = "SELECT UserEmpGroupName, UserEmpType from user_employment_details where UserMainUserId='" . $User->UserId . "'";
                                    echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH($UserEmpSql, "UserEmpGroupName") . " - " . FETCH($UserEmpSql, "UserEmpType")  . "</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="col-md-5 form-group">
                                <label>Employee Group <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserEmpGroupName">
                                  <?php echo CONFIG_VALUES("WORK_GROUP"); ?>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Employement Type <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserEmpType" required>
                                  <?php echo CONFIG_VALUES("EMP_TYPE"); ?>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Work Location <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserEmpLocations" required>
                                  <?php $GetOfficeLocations = _DB_COMMAND_("SELECT config_location_id, config_location_name FROM config_locations where config_location_status='1'", true);
                                  if ($GetOfficeLocations != null) {
                                    foreach ($GetOfficeLocations as $Locations) {
                                  ?>
                                      <option value='<?php echo $Locations->config_location_id; ?>'><?php echo $Locations->config_location_name; ?></option>
                                  <?php
                                    }
                                  } else {
                                    echo "<option value='0'>No Location!</option>";
                                  } ?>
                                </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label>(OnRole/OffRole) Status <?php echo REQUIRED; ?></label>
                                <select class="form-control" name="UserEmpRoleStatus" required>
                                  <?php echo InputOptions(["On Role" => "On Role", "Off Role" => "Off Role"], "On Role"); ?>
                                </select>
                              </div>
                              <div class="col-md-12">
                                <hr>
                                <h5 class="app-sub-heading">Login & Access Level</h5>
                              </div>

                              <div class="form-group col-md-3 col-lg-3">
                                <label>Login Password <?php echo REQUIRED; ?></label>
                                <input type="text" name="UserPassword" value="<?php echo rand(1111111, 99999999); ?>" class="form-control">
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                                <?php echo LABEL("Email-id <span id='emailmsg'></span>", TRUE); ?>
                                <input type="email" id='LoginMailIdCheck' oninput="CheckExistingMailId()" name="UserEmailId" class="form-control" required="">
                              </div>
                              <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                <label>User Status</label>
                                <select class="form-control" name="UserStatus">
                                  <option value="1" selected="">Active</option>
                                  <option value="0">Inactive</option>
                                </select>
                              </div>
                              <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label>User Login Access <?php echo REQUIRED; ?></label><br>
                                <p class="w-100">
                                  <?php foreach (USER_ROLES as $user_roles) { ?>
                                    <label class="btn btn-xs btn-default m-1">
                                      <input type="checkbox" name="UserType[]" class="p-1 fs-14" value='<?php echo $user_roles; ?>'>
                                      <span class="fs-17"><?php echo UpperCase($user_roles); ?></span>
                                    </label>
                                  <?php } ?>
                                </p>
                              </div>

                              <div class="col-md-12">
                                <p class="pt-1"><b class="text-danger">Note:</b> Login details and password will be sent to user's login email-id after click on <b>CREATE USER</b> button.</p>
                                <hr>
                              </div>
                            </div>
                          </div>
                          <div id='AddressForm' class="hidden">
                            <h5 class="app-sub-heading"><b class="text-success">(B)</b> Permanent Address Details</h5>
                            <div class='row'>
                              <div class="form-group col-lg-12 col-md-12 col-12">
                                <label>Street Address</label>
                                <input type='text' name='UserStreetAddress' class='form-control'>
                              </div>
                              <div class="form-group col-lg-5 col-md-5 col-12">
                                <label>Sector/Locality/Area/Landmark</label>
                                <input type="text" name="UserLocality" class="form-control">
                              </div>
                              <input type='hidden' name='UserCountry' value='India'>
                              <div class="form-group col-lg-7 col-md-7 col-12">
                                <label>State</label>
                                <select class="state form-control SelectedState" name="UserState" onchange='GetStateCities()'>
                                  <?php echo InputOptions([
                                    'Select State',
                                    'Andaman and Nicobar Islands',
                                    'Andhra Pradesh',
                                    'Arunachal Pradesh',
                                    'Assam',
                                    'Bihar',
                                    'Chandigarh',
                                    'Chhattisgarh',
                                    'Dadra and Nagar Haveli',
                                    'Daman and Diu',
                                    'Delhi',
                                    'Goa',
                                    'Gujarat',
                                    'Haryana',
                                    'Himachal Pradesh',
                                    'Jammu and Kashmir',
                                    'Jharkhand',
                                    'Karnataka',
                                    'Kerala',
                                    'Lakshadweep',
                                    'Madhya Pradesh',
                                    'Maharashtra',
                                    'Manipur',
                                    'Meghalaya',
                                    'Mizoram',
                                    'Nagaland',
                                    'Odisha',
                                    'Puducherry',
                                    'Punjab',
                                    'Rajasthan',
                                    'Sikkim',
                                    'Tamil Nadu',
                                    'Telangana',
                                    'Tripura',
                                    'Uttar Pradesh',
                                    'Uttarakhand',
                                    'West Bengal'
                                  ], "Select State"); ?>
                                </select>
                              </div>
                              <div class="form-group col-lg-6 col-md-6 col-12">
                                <label>City</label>
                                <input type="text" name="UserCity" class="form-control">
                              </div>
                              <div class="form-group col-lg-6 col-md-4 col-12">
                                <label>Pincode</label>
                                <input type="text" name="UserPincode" class="form-control">
                              </div>
                              <div class="form-group col-lg-4 col-md-4 col-12">
                                <label>Address Type</label>
                                <input type="text" value="PERMANENT" name="UserAddressType" readonly class="form-control">
                              </div>
                              <div class="form-group col-lg-8 col-md-8 col-12">
                                <label>Contact Person At Address</label>
                                <input type="text" name="UserAddressContactPerson" class="form-control">
                              </div>

                              <div class="form-group col-md-12">
                                <div class="flex-start" onclick="Databar('DifferentCurrentAddress')">
                                  <input type='checkbox' name='BOTH_SAME_ADDRESS' value='true'>
                                  <p class="ml-2"><b>Check this for add new current address else permanent and current address will be same.</b></p>
                                </div>
                              </div>
                            </div>

                            <div class="hidden" id='DifferentCurrentAddress'>
                              <h5 class="app-sub-heading">Current Address Details</h5>
                              <div class='row'>
                                <div class="form-group col-lg-12 col-md-12 col-12">
                                  <label>Street Address</label>
                                  <input type='text' name='UserStreetAddress1' class='form-control'>
                                </div>
                                <div class="form-group col-lg-5 col-md-5 col-12">
                                  <label>Sector/Locality/Area/Landmark</label>
                                  <input type="text" name="UserLocality1" class="form-control">
                                </div>
                                <input type='hidden' name='UserCountry1' value='India'>
                                <div class="form-group col-lg-7 col-md-7 col-12">
                                  <label>State</label>
                                  <select class="state form-control SelectedState" name="UserState1" onchange='GetStateCities()'>
                                    <?php echo InputOptions([
                                      'Select State',
                                      'Andaman and Nicobar Islands',
                                      'Andhra Pradesh',
                                      'Arunachal Pradesh',
                                      'Assam',
                                      'Bihar',
                                      'Chandigarh',
                                      'Chhattisgarh',
                                      'Dadra and Nagar Haveli',
                                      'Daman and Diu',
                                      'Delhi',
                                      'Goa',
                                      'Gujarat',
                                      'Haryana',
                                      'Himachal Pradesh',
                                      'Jammu and Kashmir',
                                      'Jharkhand',
                                      'Karnataka',
                                      'Kerala',
                                      'Lakshadweep',
                                      'Madhya Pradesh',
                                      'Maharashtra',
                                      'Manipur',
                                      'Meghalaya',
                                      'Mizoram',
                                      'Nagaland',
                                      'Odisha',
                                      'Puducherry',
                                      'Punjab',
                                      'Rajasthan',
                                      'Sikkim',
                                      'Tamil Nadu',
                                      'Telangana',
                                      'Tripura',
                                      'Uttar Pradesh',
                                      'Uttarakhand',
                                      'West Bengal'
                                    ], "Select State"); ?>
                                  </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                  <label>City</label>
                                  <input type="text" name="UserCity1" class="form-control">
                                </div>
                                <div class="form-group col-lg-6 col-md-4 col-12">
                                  <label>Pincode</label>
                                  <input type="text" name="UserPincode1" class="form-control">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-12">
                                  <label>Address Type</label>
                                  <input type="text" value="CURRENT" name="UserAddressType1" readonly class="form-control">
                                </div>
                                <div class="form-group col-lg-8 col-md-8 col-12">
                                  <label>Contact Person At Address</label>
                                  <input type="text" name="UserAddressContactPerson1" class="form-control">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id='EmploymentForm' class="hidden">
                            <h5 class="app-sub-heading"><b class="text-success">(C)</b> Employement Details</h5>
                            <div class="row">
                              <div class="col-md-4 form-group">
                                <label>Last Working Industry</label>
                                <input type="text" class="form-control" name="UserEmpBackGround">
                              </div>
                              <div class="col-md-5 form-group">
                                <label>Total Work Experience (in Years)</label>
                                <input type="text" class="form-control" name="UserEmpTotalWorkExperience">
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Previous Organisation Name</label>
                                <input type="text" class="form-control" name="UserEmpPreviousOrg">
                              </div>
                              <div class="col-md-6 form-group">
                                <label>Work Email-ID</label>
                                <input type="text" class="form-control" name="UserEmpWorkEmailId">
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Rera ID (If Have)</label>
                                <input type="text" class="form-control" name="UserEmpReraId">
                              </div>
                              <div class="col-md-4 form-group">
                                <label>CRM Status</label>
                                <select class="form-control" name="UserEmpCRMStatus">
                                  <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], "No"); ?> </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Visiting Card</label>
                                <select class="form-control" name="UserEmpVisitingCard">
                                  <?php echo  InputOptions(["Yes" => "Yes", "No" => "No"], "No"); ?> </select>
                              </div>
                              <div class="col-md-4 form-group">
                                <label>Joining date</label>
                                <input type="date" name="UserCreatedAt" class="form-control" value='<?php echo date("Y-m-d"); ?>'>
                              </div>
                            </div>
                          </div>
                          <div id='BankAccountForm' class="hidden">
                            <h5 class="app-sub-heading"><b class="text-success">(D)</b> Employement Details</h5>
                            <div class='row'>
                              <div class="form-group col-md-6">
                                <label>Bank Name</label>
                                <input type="text" name="UserBankName" class="form-control">
                              </div>
                              <div class="form-group col-md-6">
                                <label>Account No</label>
                                <input type="text" name="UserBankAccountNo" class="form-control">
                              </div>
                              <div class="form-group col-md-6">
                                <label>IFSC Code</label>
                                <input type="text" name="UserBankIFSC" class="form-control">
                              </div>
                              <div class="form-group col-md-6">
                                <label>Account Holder Name</label>
                                <input type="text" name="UserBankAccoundHolderName" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div id='DocumentsForm' class="hidden">
                            <h5 class="app-sub-heading"><b class="text-success">(E)</b> Upload Documents</h5>
                            <div class="row">
                              <div class="form-group col-lg-4">
                                <label>PAN CARD No</label>
                                <input type="text" name="PancardNo" class="form-control">
                              </div>
                              <div class="form-group col-lg-8">
                                <label>Attach PAN CARD</label>
                                <input type="FILE" value="null" name="PancardFile" class="form-control">
                              </div>
                              <div class="form-group col-lg-4">
                                <label>Adhaar CARD No</label>
                                <input type="text" name="AdhaarNo" class="form-control">
                              </div>
                              <div class="form-group col-lg-8">
                                <label>Attach Adhaar CARD</label>
                                <input type="FILE" value="null" name="AdhaarFile" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="shadow-sm p-2 b-r-1 mt-2">
                          <div class="flex-start pt-2 pb-2">
                            <input type='checkbox' checked name='ON_BOARDING_STATUS' value='true'>
                            <p class="pl-1 mb-0 text-danger font-weight-bold">Deselect this to turn off the automated onboarding process.</p>
                          </div>
                          <hr>
                          <div class="action-btn">
                            <button class="btn btn-md btn-success" id='subbtn' type="button" name="SaveCustomer"><i class="fa fa-check-circle"></i> Create User</button>
                            <button class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Reset</button><br>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <script>
    function GetRequiredForm(FormId, MenuId) {
      // Form and menu arrays
      var forms = ["PrimaryForm", "AddressForm", "EmploymentForm", "BankAccountForm", "DocumentsForm"];
      var menus = ["AForm", "BForm", "CForm", "DForm", "EForm"];

      // Handle form divs
      forms.forEach(function(form) {
        document.getElementById(form).classList.toggle("hidden", form !== FormId);
      });

      // Handle menu items
      menus.forEach(function(menu) {
        document.getElementById(menu).classList.toggle("active", menu === MenuId);
      });
    }
  </script>

  <script>
    function CheckExistingPhoneNumbers() {
      let SearchingFor = document.getElementById("PhoneNumberCheck");
      var phonemsg = document.getElementById("phonemsg");
      var pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
      var subbtn = document.getElementById("subbtn");
      let ExistingPhoneNumbers = [<?php
                                  $AllData = _DB_COMMAND_("SELECT UserPhoneNumber FROM users", true);
                                  if ($AllData != null) {
                                    foreach ($AllData as $Data) {
                                      echo "'" . $Data->UserPhoneNumber . "', ";
                                    }
                                  } ?>];

      if (ExistingPhoneNumbers.includes(SearchingFor.value)) {
        phonemsg.classList.add("text-danger");
        phonemsg.classList.remove("text-warning");
        phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number Already Exits";
        subbtn.type = "button";
      } else if (pattern.test(SearchingFor.value) == false) {
        phonemsg.classList.add("text-warning");
        phonemsg.classList.remove("text-danger");
        phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number is not valid";
        subbtn.type = "button";
      } else {
        phonemsg.classList.remove("text-danger");
        phonemsg.classList.remove("text-warning");
        phonemsg.classList.add("text-success");
        phonemsg.innerHTML = "<i class='fa fa-check'></i> Phone Number is Ok";
        subbtn.type = "submit";
      }
    }

    function CheckExistingMailId() {
      let SearchingFor = document.getElementById("LoginMailIdCheck");
      var emailmsg = document.getElementById("emailmsg");
      var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      var subbtn = document.getElementById("subbtn");
      let CheckExistingMailId = [<?php
                                  $AllData = _DB_COMMAND_("SELECT UserEmailId  FROM users", true);
                                  if ($AllData != null) {
                                    foreach ($AllData as $Data) {
                                      echo "'" . $Data->UserEmailId . "', ";
                                    }
                                  } ?>];

      if (CheckExistingMailId.includes(SearchingFor.value)) {
        emailmsg.classList.add("text-danger");
        emailmsg.classList.remove("text-warning");
        emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-Id Already Exits";
        subbtn.type = "button";
      } else if (pattern.test(SearchingFor.value) == false) {
        emailmsg.classList.add("text-warning");
        emailmsg.classList.remove("text-danger");
        emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-ID is not valid";
        subbtn.type = "button";
      } else {
        emailmsg.classList.remove("text-danger");
        emailmsg.classList.remove("text-warning");
        emailmsg.classList.add("text-success");
        emailmsg.innerHTML = "<i class='fa fa-check'></i> Email-ID is Ok";
        subbtn.type = "submit";
      }
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>