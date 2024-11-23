<?php

//Get location name
function UserLocation($UserId, $type = null)
{
  $UserSql = "SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='$UserId'";
  $CheckUserlocation = CHECK($UserSql);

  if ($CheckUserlocation != null) {
    $GetLocationId = FETCH($UserSql, "UserEmpLocations");
    $GetLocationName = FETCH("SELECT config_location_name FROM config_locations where config_location_id='$GetLocationId'", "config_location_name");

    if ($type == null) {
      $return = $GetLocationName;
    } else {
      $return = $GetLocationId;
    }
  } else {
    $return = null;
  }

  return $return;
}
if (!isset($_SESSION['LOGIN_USER_ID'])) {
  define("ACCESS_LOCATION", $AccessLocation = "1");
} else {
  define("ACCESS_LOCATION", $AccessLocation = UserLocation($_SESSION['LOGIN_USER_ID'], "id"));
}


//get user empid 
function GetUserEmpid($UserId)
{

  $UserSql = "SELECT UserEmpJoinedId FROM user_employment_details where UserMainUserId='$UserId'";
  $CheckUserlocation = CHECK($UserSql);

  if ($CheckUserlocation != null) {
    $EmpCode = FETCH($UserSql, "UserEmpJoinedId");
    $return = $EmpCode;
  } else {
    $return = null;
  }

  return $return;
}

//function for get User Employement Details
function UserEmpDetails($UserIds, $column_name)
{
  if ($UserIds == null) {
    $FetchValue = FETCH("SELECT $column_name FROM user_employment_details where UserMainUserId='$UserIds'", "$column_name");
  } else {
    $FetchValue = null;
  }
  return $FetchValue;
}

//user details
function UserDetails($UserId)
{
  $response = "";
  $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
  if ($AllUsers == null) {
    $response = "";
  } else {
    foreach ($AllUsers as $User) {
      $response .= $User->UserFullName . "<br>";
      $response .= '<span class="text-gray fs-11">';
      $response .= '<span>' . $User->UserPhoneNumber . '</span><br>';
      $response .= '<span>' . $User->UserEmailId . '</span><br>';
      $response .= '<span><span class="text-gray">' . UserEmpDetails($User->UserId, "UserEmpJoinedId") . '</span></span<br>';
      $response .= '</span>';
    }
  }

  return $response;
}

//usercreated by 
function UserCreatedBy($UserId)
{
  $response = "";
  $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
  if ($AllUsers == null) {
    $response = "";
  } else {
    foreach ($AllUsers as $User) {
      $response .= "<span class='btn btn-xs btn-default'> <i class='fa fa-user text-primary'></i> ";
      $response .= $User->UserFullName . "-" . UserEmpDetails($User->UserId, "UserEmpJoinedId");
      $response .= '</span>';
    }
  }

  return $response;
}

//user details
function UserDetailsForExport($UserId)
{
  $responses = "";
  $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
  if ($AllUsers == null) {
    $responses = null;
  } else {
    foreach ($AllUsers as $User) {
      $responses .= $User->UserFullName;
      $responses .= "(" . UserEmpDetails($User->UserId, "UserEmpJoinedId") . ")";
    }
  }

  return $responses;
}


//user image
function GetUserImage($UserId, $default = false)
{
  $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
  if ($UserProfileImage == "default.png") {
    $UserProfileImg = STORAGE_URL_D . "/default.png";
  } else {
    $FilePath = DOMAIN . "/storage/<?php echo APP_URL;?>/users" . $UserId . "/img/" . $UserProfileImage;
    if (file_exists($FilePath)) {
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    } else {
      $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    }
  }

  //load default image
  if ($default == true) {
    $UserProfileImg = STORAGE_URL_D . "/default.png";
  }

  //return results
  return $UserProfileImg;
}

//user details
function GetUserDetails($UserId)
{
  $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "'", true);
  if ($AllUsers == null) {
    NoData("No Users found!");
  } else {
    foreach ($AllUsers as $User) {
      $responses = '<label for="UserId34_' . $User->UserId . '" class=\'record-data-65 m-b-3\'>
        <div class="flex-s-b">
          <div class="w-pr-25">
            <img src="' . GetUserImage($User->UserId) . '" class="img-fluid">
          </div>
          <div class="text-left w-pr-75 pl-2">
            <p class="mt-0">
              <b class="h5 mt-0 m-t-0" style=\'font-weight:600 !important;\'>' . $User->UserFullName . '</b><br>
              <span class="text-gray" style=\'font-weight:400 !important;\'>
                <span>' . $User->UserPhoneNumber . '</span><br>
                <span>' . $User->UserEmailId . '</span><br>
                <span>
                  <span class="text-gray">' . GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'") . '</span>
                  (<span class="text-gray">' . GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'") . '</span>)
                  @
                  <span class="text-gray">' . GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'") . '</span>
                  <span class="text-gray">
                    <br> <span class="text-gray">' . UserLocation($User->UserId) . '</span>
                  </span>
                </span>
              </span>
            </p>
          </div>
        </div>
      </label>';
    }
  }
  return $responses;
}

//app users
function GetUserData($UserId, $require)
{
  if (empty($UserId)) {
    return null;
  } else {
    $CheckUsers = CHECK("SELECT $require FROM users where UserId='$UserId'");
    if ($CheckUsers == null) {
      return null;
    } else {
      $GetData = FETCH("SELECT $require FROM users where UserId='$UserId'", "$require");
      if ($require == "UserProfileImage") {
        if ($GetData == "user.png") {
          return STORAGE_URL_D . "/default.png";
        } else {
          return STORAGE_URL_U . "/$UserId/img/$GetData";
        }
      } else {
        return $GetData;
      }
    }
  }
}


//select users
function SelectUserOptions($SelectInputName, $default = LOGIN_UserId)
{
  $SelectOptions = "";
  $SelectOptions .= '<select class="form-control" name="' . $SelectInputName . '">';

  $Users = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
  foreach ($Users as $User) {
    if ($User->UserId == IfRequested("GET", "$SelectInputName", $default, false)) {
      $selected = "selected";
    } else {
      $selected = "";
    }
    $SelectOptions .= "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
  }
  $SelectOptions .= '</select>';
  return $SelectOptions;
}

//function get user latest access type
function UserAccessType($UserId)
{
  return FETCH("SELECT UserAccessName FROM user_access WHERE UserAccessUserId='$UserId' ORDER BY UserAccessId DESC limit 1", "UserAccessName");
}

//function for user all access level inreturn via array
function UserAllAccessLevel($UserId)
{
  $UserAccessLevel = "";
  $AllAccess = _DB_COMMAND_("SELECT UserAccessName FROM user_access WHERE UserAccessUserId='$UserId' GROUP BY UserAccessName ORDER BY UserAccessId DESC", true);
  foreach ($AllAccess as $Access) {
    $UserAccessLevel .=   "<span class='list text-black'><i class='fa fa-check-circle text-success'></i> " . $Access->UserAccessName . "</span> ";
  }
  return $UserAccessLevel;
}

//humen relations with each other
define("HUMAN_RELATIONS", [
  "" => "Select Relation",
  "Brother" => "Brother",
  "Sister" => "Sister",
  "Son" => "Son",
  "Daughter" => "Daughter",
  "Wife" => "Wife",
  "Father" => "Father",
  "Grandfather" => "Grandfather",
  "Grandmother" => "Grandmother",
  "Uncle" => "Uncle",
  "Aunty" => "Aunty",
  "Cousin" => "Cousin",
  "Nephew" => "Nephew",
  "Niece" => "Niece",
  "Father-in-law" => "Father-in-law",
  "Mother-in-law" => "Mother-in-law",
  "Friend" => "Friend",
  "Other" => "Other"
]);
