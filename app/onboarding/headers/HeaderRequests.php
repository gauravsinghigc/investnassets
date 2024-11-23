<?php

//initiate onboarding process!
if (isset($_GET['for'])) {
    $OnBoardingRequestedBy = SECURE($_GET["for"], "d");
    $_SESSION['ONBOARDING_REQUEST_FOR']  = $OnBoardingRequestedBy;
} else {
    if (isset($_SESSION['ONBOARDING_REQUEST_FOR'])) {
        $OnBoardingRequestedBy = $_SESSION['ONBOARDING_REQUEST_FOR'];
    } else {
        $OnBoardingRequestedBy = null;
    }
}

//update and mail verified automatically
UPDATE("UPDATE user_onboarding SET user_email_status='1' where user_onboarding_id='$OnBoardingRequestedBy'");

//process onboarding sessions
if ($OnBoardingRequestedBy != null) {
    $OnBoardSQL = "SELECT * FROM user_onboarding where user_onboarding_id='$OnBoardingRequestedBy'";
    $UserId = FETCH($OnBoardSQL, "users_main_id");
    $UserSQL = "SELECT * FROM users where UserId='$UserId'";
    $AddressSQL = "SELECT * FROM user_addresses where UserAddressUserId='$UserId' ORDER BY UserAddressId DESC";
    $UserDocumentSQL = "SELECT * FROM user_documents where UserMainId='$UserId'";
} else {
    $access_url = APP_URL;
    RESPONSE(false, "", "Unable to retrieve onboarding request identifier or please contact the administrator or hr admin for the same. You can also request them for generate new one!");
}


//check active form status
if (isset($_GET['back_to'])) {
    $NextForm = $_GET['back_to'];
    $_SESSION['NEXT_FORM_STATUS'] = $NextForm;
    header("location: " . APP_URL . "/onboarding/process");
} else {
    if (isset($_SESSION['NEXT_FORM_STATUS'])) {
        $NextForm = $_SESSION['NEXT_FORM_STATUS'];
    } else {
        $NextForm = 1;
    }
}
