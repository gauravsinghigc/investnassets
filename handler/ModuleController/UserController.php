<?php


//update profile image 
if (isset($_POST['updateprofileimage'])) {
  $UserId  = $_POST['updateprofileimage'];
  $UserProfileImage = UPLOAD_FILES("../storage/users/$UserId/img", "null", "Profile_Photo_" . "_UID_" . $UserId, "UserProfileImage");
  $Update = UPDATE("UPDATE users SET UserProfileImage='$UserProfileImage' where UserId='$UserId'");
  RESPONSE($Update, "Profile Image Updated!", "Unable to update profile image!");

  //remove employee
} else if (isset($_GET['remove_team_member'])) {
  $access_url = SECURE($_GET['access_url'], "d");
  $remove_team_member = SECURE($_GET['remove_team_member'], "d");

  if ($remove_team_member == true) {
    $access_url = APP_URL . "/users";
    $control_id = SECURE($_GET['control_id'], "d");
    $delete = DELETE_FROM("users", "UserId='$control_id'");
    $delete = DELETE_FROM("user_addresses", "UserAddressUserId='$control_id'");
    $delete = DELETE_FROM("user_bank_details", "UserMainId='$control_id'");
    $delete = DELETE_FROM("user_documents", "UserMainId='$control_id'");
    $delete = DELETE_FROM("user_employment_details", "UserMainUserId='$control_id'");
    $delete = DELETE_FROM("user_access", "UserAccessUserId='$control_id'");
    $delete = DELETE_FROM("user_allowed_leaves", "UserALMainUserId='$control_id'");
    $delete = DELETE_FROM("user_appraisals", "UserAppraisalMainUserId='$control_id'");
    $delete = DELETE_FROM("user_attandance_check_in", "check_in_main_user_id='$control_id'");
    $delete = DELETE_FROM("user_attandance_check_out", "check_out_main_user_id='$control_id'");
    $delete = DELETE_FROM("user_day_breaks", "day_break_main_user_id='$control_id'");
    $delete = DELETE_FROM("user_family_members", "UserFMMainUserId='$control_id'");
    $delete = DELETE_FROM("user_leaves", "UserMainId='$control_id'");
    $delete = DELETE_FROM("user_leave_attachments", "UserLeaveMainId='$control_id'");
    $delete = DELETE_FROM("user_leave_contact_nos", "UserLeaveMainId='$control_id'");
    $delete = DELETE_FROM("user_leave_status", "UserLeaveMainId='$control_id'");
    $delete = DELETE_FROM("user_meetings", "user_main_user_id='$control_id'");
    $delete = DELETE_FROM("user_onboarding", "users_main_id='$control_id'");
    $delete = DELETE_FROM("user_permissions", "UserPermissionUserId='$control_id'");
    $delete = DELETE_FROM("user_pips", "UserPIPMainUserId='$control_id'");
    $delete = DELETE_FROM("user_rewards", "RewardMainUserId='$control_id'");
    unset($_SESSION['USER_DASHBOARD']);
  } else {
    $delete = false;
  }

  RESPONSE($delete, "Team member is removed successfully!", "Unable to remove team member!");

  //update primary data
} elseif (isset($_POST['UpdatePrimaryData'])) {
  $UserId = SECURE($_POST['UserId'], "d");

  $primarydata = array(
    "UserSalutation" => $_POST['UserSalutation'],
    "UserFullName" => $_POST['UserFullName'],
    "UserPhoneNumber" => $_POST['UserPhoneNumber'],
    "UserEmailId" => $_POST['UserEmailId'],
    "UserUpdatedAt" => CURRENT_DATE_TIME,
    "UserStatus" => $_POST['UserStatus'],
    "UserNotes" => POST("UserNotes"),
    "UserType" => $_POST['UserType'],
    "UserDateOfBirth" => $_POST['UserDateOfBirth'],
  );

  $Update = UPDATE_DATA("users", $primarydata, "UserId='$UserId'");
  RESPONSE($Update, $_POST['UserFullName'] . " profile is updated successfully!", "Unable to update profile at the moment!");

  //update address
} elseif (isset($_POST['UpdateUserAddress'])) {
  $UserId = SECURE($_POST['UserId'], "d");
  $UserAddressId = SECURE($_POST['UserAddressId'], "d");

  $Address = array(
    "UserStreetAddress" => SECURE($_POST["UserStreetAddress"], "e"),
    "UserLocality" => $_POST['UserLocality'],
    "UserCity" => $_POST['UserCity'],
    "UserState" => $_POST['UserState'],
    "UserCountry" => $_POST['UserCountry'],
    "UserPincode" => $_POST['UserPincode'],
    "UserAddressType" => $_POST['UserAddressType'],
    "UserAddressContactPerson" => $_POST['UserAddressContactPerson'],
  );

  $Update = UPDATE_DATA("user_addresses", $Address, "UserAddressId='$UserAddressId'");
  RESPONSE($Update, "Address details are updated successfully!", "Unable to update address details at the moment!");

  //update employment details
} elseif (isset($_POST['UpdateEmployement'])) {
  $UserId = SECURE($_POST['UserId'], "d");

  $EmpDetails = array(
    "UserMainUserId" => $UserId,
    "UserEmpBackGround" => $_POST['UserEmpBackGround'],
    "UserEmpTotalWorkExperience" => $_POST['UserEmpTotalWorkExperience'],
    "UserEmpPreviousOrg" => $_POST['UserEmpPreviousOrg'],
    "UserEmpBloodGroup" => $_POST['UserEmpBloodGroup'],
    "UserEmpReraId" => $_POST['UserEmpReraId'],
    "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
    "UserEmpJoinedId" => $_POST['UserEmpJoinedId'],
    "UserEmpCRMStatus" => $_POST['UserEmpCRMStatus'],
    "UserEmpVisitingCard" => $_POST['UserEmpVisitingCard'],
    "UserEmpWorkEmailId" => $_POST['UserEmpWorkEmailId'],
    "UserEmpGroupName" => $_POST['UserEmpGroupName'],
    "UserEmpType" => $_POST['UserEmpType'],
    "UserEmpLocations" => $_POST['UserEmpLocations'],
    "UserEmpRoleStatus" => $_POST['UserEmpRoleStatus'],
  );

  $UserCreatedAt = $_POST['UserCreatedAt'];
  $Response = UPDATE("UPDATE users SET UserCreatedAt='$UserCreatedAt' where UserId='$UserId'");

  $CheckEMp = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$UserId'");
  if ($CheckEMp == null) {
    $Update = INSERT("user_employment_details", $EmpDetails);
  } else {
    $Update = UPDATE_DATA("user_employment_details", $EmpDetails, "UserMainUserId='$UserId'");
  }

  $BANKDETAILS = array(
    "UserMainId" => $UserId,
    "UserBankName" => $_POST['UserBankName'],
    "UserBankAccountNo" => $_POST['UserBankAccountNo'],
    "UserBankIFSC" => $_POST['UserBankIFSC'],
    "UserBankAccoundHolderName" => $_POST['UserBankAccoundHolderName'],
  );

  $CheckEMp = CHECK("SELECT * FROM user_bank_details where UserMainId='$UserId'");
  if ($CheckEMp == null) {
    $Update = INSERT("user_bank_details", $BANKDETAILS);
  } else {
    $Update = UPDATE_DATA("user_bank_details", $BANKDETAILS, "UserMainId='$UserId'");
  }

  RESPONSE($Update, "Employement details are updated successfully!", "Unable to update Employement details at the moment!");

  //update bank details
} else if (isset($_POST['UpdateBankDetails'])) {
  $UserId = SECURE($_POST['UserId'], "d");

  $BANKDETAILS = array(
    "UserMainId" => $UserId,
    "UserBankName" => $_POST['UserBankName'],
    "UserBankAccountNo" => $_POST['UserBankAccountNo'],
    "UserBankIFSC" => $_POST['UserBankIFSC'],
    "UserBankAccoundHolderName" => $_POST['UserBankAccoundHolderName'],
  );

  $CheckEMp = CHECK("SELECT * FROM user_bank_details where UserMainId='$UserId'");
  if ($CheckEMp == null) {
    $Update = INSERT("user_bank_details", $BANKDETAILS);
  } else {
    $Update = UPDATE_DATA("user_bank_details", $BANKDETAILS, "UserMainId='$UserId'");
  }

  RESPONSE($Update, "Bank Account details are updated successfully!", "Unable to update Bank Account details at the moment!");

  //upload documents
} elseif (isset($_POST['UploadDocuments'])) {
  $UserId = SECURE($_POST['UserId'], "d");

  $documents = array(
    "UserMainId" => $UserId,
    "UserDocumentNo" => $_POST['UserDocumentNo'],
    "UserDocumentName" => $_POST['UserDocumentName'],
    "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "PanCard", "UserDocumentFile"),
  );

  $Update = INSERT("user_documents", $documents);
  RESPONSE($Update, "Documents are uploaded successfully!", "Unable to upload documents at the moment!");

  //remove documents
} elseif (isset($_GET['remove_user_documents'])) {
  $access_url = SECURE($_GET['access_url'], "d");
  $remove_user_documents = SECURE($_GET['remove_user_documents'], "d");

  if ($remove_user_documents == true) {
    $control_id = SECURE($_GET['control_id'], "d");
    $delete = DELETE_FROM("user_documents", "UserDocsId='$control_id'");
  } else {
    $delete = false;
  }

  RESPONSE($delete, "Document is removed successfully!", "Unable to remove documents at the moment!");

  //update password
} elseif (isset($_POST['UpdatePassword'])) {
  $UserId = $_SESSION['REQ_UserId'];

  $data = array(
    "UserPassword" => $_POST['UserPassword'],
  );

  $Update = UPDATE_DATA("users", $data, "UserId='$UserId'");
  RESPONSE($Update, "Password is updated successfully!", "Unable to update password at the moment!");

  //create users
} elseif (isset($_POST['SaveCustomer'])) {
  $UserSalutation = $_POST['UserSalutation'];
  $UserFullName = $_POST["UserFullName"];
  $UserPhoneNumber = $_POST['UserPhoneNumber'];
  $UserEmailId = $_POST['UserEmailId'];
  $UserNotes = POST("UserNotes");
  $UserStatus = $_POST["UserStatus"];
  $UserCreatedAt = $_POST['UserCreatedAt'];
  $UserPassword = $_POST['UserPassword'];
  $UserDateOfBirth = $_POST['UserDateOfBirth'];

  //address requests 
  $UserStreetAddress = SECURE($_POST['UserStreetAddress'], "e");
  $UserLocality =  $_POST['UserLocality'];
  $UserCity =  $_POST['UserCity'];
  $UserState =  $_POST['UserState'];
  $UserCountry = $_POST['UserCountry'];
  $UserPincode = $_POST['UserPincode'];
  $UserAddressType = $_POST['UserAddressType'];
  $UserAddressContactPerson = $_POST['UserAddressContactPerson'];
  $UserAddressNotes = "";
  $UserAddressMapUrl = "";

  //check if phone or email-id is already registered or not
  $CheckifPhone = CHECK("SELECT * FROM users where UserPhoneNumber='$UserPhoneNumber'");
  $CheckifMail = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
  if ($CheckifPhone != null) {;
    LOCATION("warning", "Phone Number is already registered!", $access_url);
  } elseif ($CheckifMail != null) {
    LOCATION("warning", "Email-id is already registered", $access_url);
  } else {
    $Save = SAVE("users", ["UserFullName", "UserDateOfBirth", "UserSalutation", "UserPassword", "UserPhoneNumber", "UserEmailId", "UserCompanyName", "UserWorkFeilds", "UserDepartment", "UserDesignation", "UserNotes", "UserStatus", "UserCreatedAt"]);
  }

  //GET registered customer id 
  $UserAddressUserId = FETCH("SELECT * FROM users where UserPhoneNumber='$UserPhoneNumber' AND UserEmailId='$UserEmailId' ORDER BY UserId DESC limit 0, 1", "UserId");

  if (isset($_POST['BOTH_SAME_ADDRESS'])) {
    if ($_POST['BOTH_SAME_ADDRESS'] == "true") {
      $NewAddress = true;
    } else {
      $NewAddress = false;
    }
  } else {
    $NewAddress = false;
  }

  if ($NewAddress == true) {
    $NewAddress = [
      "UserStreetAddress" => SECURE($_POST['UserStreetAddress1'], "e"),
      "UserLocality" =>  $_POST['UserLocality1'],
      "UserCity" =>  $_POST['UserCity1'],
      "UserState" =>  $_POST['UserState1'],
      "UserCountry" => $_POST['UserCountry1'],
      "UserPincode" => $_POST['UserPincode1'],
      "UserAddressType" => $_POST['UserAddressType1'],
      "UserAddressContactPerson" => $_POST['UserAddressContactPerson1'],
      "UserAddressUserId" => $UserAddressUserId
    ];
  } else {
    $NewAddress = [
      "UserStreetAddress" => SECURE($_POST['UserStreetAddress'], "e"),
      "UserLocality" =>  $_POST['UserLocality'],
      "UserCity" =>  $_POST['UserCity'],
      "UserState" =>  $_POST['UserState'],
      "UserCountry" => $_POST['UserCountry'],
      "UserPincode" => $_POST['UserPincode'],
      "UserAddressType" => $_POST['UserAddressType'],
      "UserAddressContactPerson" => $_POST['UserAddressContactPerson'],
      "UserAddressUserId" => $UserAddressUserId
    ];
  }

  //save new address
  $Save = INSERT("user_addresses", $NewAddress);

  //save user types
  foreach ($_POST['UserType'] as $UserType) {
    $user_access = [
      "UserAccessUserId" => $UserAddressUserId,
      "UserAccessName" => $UserType,
      "UserAccessCreatedAt" => CURRENT_DATE_TIME,
      "UserAccessStatus" => 1
    ];
    $Response = INSERT("user_access", $user_access);
  }

  //save customer address
  $Save = SAVE("user_addresses", ["UserAddressUserId", "UserStreetAddress", "UserLocality", "UserCity", "UserState", "UserCountry", "UserPincode", "UserAddressType", "UserAddressContactPerson", "UserAddressNotes", "UserAddressMapUrl"], false);

  //save other details
  $UserId = $UserAddressUserId;

  $EmpDetails = array(
    "UserMainUserId" => $UserId,
    "UserEmpBackGround" => $_POST['UserEmpBackGround'],
    "UserEmpTotalWorkExperience" => $_POST['UserEmpTotalWorkExperience'],
    "UserEmpPreviousOrg" => $_POST['UserEmpPreviousOrg'],
    "UserEmpBloodGroup" => $_POST['UserEmpBloodGroup'],
    "UserEmpReraId" => $_POST['UserEmpReraId'],
    "UserEmpReportingMember" => $_POST['UserEmpReportingMember'],
    "UserEmpJoinedId" => $_POST['UserEmpJoinedId'],
    "UserEmpCRMStatus" => $_POST['UserEmpCRMStatus'],
    "UserEmpVisitingCard" => $_POST['UserEmpVisitingCard'],
    "UserEmpWorkEmailId" => $_POST['UserEmpWorkEmailId'],
    "UserEmpGroupName" => $_POST['UserEmpGroupName'],
    "UserEmpLocations" => $_POST['UserEmpLocations']
  );
  $Check = CHECK("SELECT * FROM user_employment_details where UserMainUserId='$UserId'");
  if ($Check == null) {
    $SaveEmp = INSERT("user_employment_details", $EmpDetails);
  }

  $BANKDETAILS = array(
    "UserMainId" => $UserId,
    "UserBankName" => $_POST['UserBankName'],
    "UserBankAccountNo" => $_POST['UserBankAccountNo'],
    "UserBankIFSC" => $_POST['UserBankIFSC'],
    "UserBankAccoundHolderName" => $_POST['UserBankAccoundHolderName'],
  );
  $SaveBank = INSERT("user_bank_details", $BANKDETAILS);

  $PanCard = array(
    "UserMainId" => $UserId,
    "UserDocumentNo" => $_POST['PancardNo'],
    "UserDocumentName" => "PAN CARD",
    "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "PanCard", "PancardFile"),
  );
  $SAVEPAN = INSERT("user_documents", $PanCard);

  $ADHAAR = array(
    "UserMainId" => $UserId,
    "UserDocumentNo" => $_POST['AdhaarNo'],
    "UserDocumentName" => "ADHAAR CARD",
    "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "AdhaarCard", "AdhaarFile"),
  );
  $SAVEADDAHR = INSERT("user_documents", $ADHAAR);

  //onboarding proces enabling
  $OnBoardingEmailContent = "";
  if (isset($_POST['ON_BOARDING_STATUS'])) {
    if ($_POST['ON_BOARDING_STATUS'] == "true") {

      //save primary details in the records for further processing
      $user_onboarding = [
        "users_main_id" => $UserId,
        "users_step_a" => null,
        "users_step_b" => null,
        "users_step_c" => null,
        "users_step_d" => null,
        "users_step_e" => null,
        "user_email_status" => null,
        "user_phone_status" => null,
        "user_verification_status" => 0,
        "user_verification_approval_status" => 0,
        "user_onboarding_requested_at" => CURRENT_DATE_TIME,
        "user_verification_last_updated_at" => CURRENT_DATE_TIME
      ];

      //check for any existing onboarding process
      $Onboardingexists = CHECK("SELECT user_onboarding_id FROM user_onboarding where users_main_id='$UserId'");
      if ($Onboardingexists == null) {
        $SaveOnboarding = INSERT("user_onboarding", $user_onboarding);
      } else {
        $SaveOnboarding = true;
      }

      //generate onboarding template;
      if ($SaveOnboarding == true) {
        $user_onboarding_id = FETCH("SELECT user_onboarding_id FROM user_onboarding where users_main_id='$UserId' ORDER BY user_onboarding_id DESC LIMIT 1", "user_onboarding_id");
        $BoardingId = SECURE($user_onboarding_id, "e");
        $OnBoardingEmailContent .= "<h3>Please complete your profile.</h3>";
        $OnBoardingEmailContent .= "<p>Your account's initial set up is completed. We will review your profile and activate your account as soon as possible. for this please complete your profile via our simple onboarding process, which take 5-7 min in completion.</p>";
        $OnBoardingEmailContent .= "<h4>Here is the unique onboarding process URL which is active for next 48 hours only.</h4>";
        $OnBoardingEmailContent .= "<a href='" . APP_URL . "/onboarding/?for=$BoardingId' style='font-size:1rem;padding:0.5rem 1rem;background-color: #322a7d !important;color:white;border-radius:0.35rem;text-decoration:none !important;'>Complete Profile <i class='fa fa-angle-right'></i></a>";
      }
    } else {
      $OnBoardingEmailContent = "";
    }
  } else {
    $OnBoardingEmailContent = "";
  }
  //send mail to created account
  SENDMAILS("Welcome to " . APP_NAME, "Dear " . $UserFullName . ",", $UserEmailId, "<br>
 <p>
 Welcome to " . APP_NAME . "!<br>.<br>
 Your Login details are as follows:<br>
 <br>
 <b>Username:</b> " . $UserEmailId . "<br>
 <b>Password:</b> " . $UserPassword . "<br>
 <b>Login URL: </b> " . DOMAIN . "<br>
</p>
 <br>
 $OnBoardingEmailContent
 <p>
 <b>Note:</b> Please change your password after login.<br>
</p>");

  //generate response
  RESPONSE($Save, "New User Details saved successfully!", "Unable to save user details at the moment!");

  //update access level for users
} elseif (isset($_POST['UpdateAccessLevel'])) {
  $UserAccessUserId = SECURE($_POST['UserAccessUserId'], "d");

  //remove all access levels
  DELETE_FROM("user_access", "UserAccessUserId='$UserAccessUserId'");

  //save user types
  foreach ($_POST['UserType'] as $UserType) {
    $user_access = [
      "UserAccessUserId" => $UserAccessUserId,
      "UserAccessName" => $UserType,
      "UserAccessCreatedAt" => CURRENT_DATE_TIME,
      "UserAccessStatus" => 1
    ];
    $Response = INSERT("user_access", $user_access);
  }

  RESPONSE($Response, "User Access level updated successfully!", "Unable to update user access level!");

  //update user status
} elseif (isset($_POST['UpdateUserStatus'])) {
  $UserId = SECURE($_POST['UserId'], "d");
  $UserStatus = $_POST['UserStatus'];

  if (isset($_POST['UserStatus'])) {
    $UserStatus = 1;
  } else {
    $UserStatus = 0;
  }

  $users = [
    "UserStatus" => $UserStatus,
    "UserUpdatedAt" => CURRENT_DATE_TIME
  ];

  $UserStatus = StatusViewWithText($UserStatus);
  $UserFullName = GET_DATA("users", "UserFullName", "UserId='$UserId'");
  $UserPhoneNumber = GET_DATA("users", "UserPhoneNumber", "UserId='$UserId'");
  $Update = UPDATE_DATA("users", $users, "UserId='$UserId'");
  RESPONSE($Update, "<b class='text-danger'>Status Updated Successfully!</b><br> [-- <b>$UserFullName - ($UserPhoneNumber)</b> --]<br>@ ( Now <b>$UserStatus</b>)", "Unable to update user status!");
}
