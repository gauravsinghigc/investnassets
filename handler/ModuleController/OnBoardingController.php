<?php

//re-send onboarding mail
if (isset($_POST['RE_SEND_ONBOARDING_LINK'])) {
    //onboarding proces enabling
    $OnBoardingEmailContent = "";
    $UserId = SECURE($_POST['UserId'], "d");
    $UserFullName = FETCH("SELECT UserFullName FROM users WHERE UserId='$UserId'", "UserFullName");
    $UserEmailId = FETCH("SELECT UserEmailId FROM users WHERE UserId='$UserId'", "UserEmailId");

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

    //remove any existing onboarding record
    DELETE_FROM("user_onboarding", "users_main_id='$UserId'");

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
        $OnBoardingEmailContent .= "<h4>Here is the unique onboarding process URL which is active for next 48 hours only. </h4>";
        $OnBoardingEmailContent .= "<a href='" . APP_URL . "/onboarding/?for=$BoardingId' style='font-size:1rem;padding:0.5rem 1rem;background-color: #322a7d !important;color:white;border-radius:0.35rem;text-decoration:none !important;'>Complete Profile <i class='fa fa-angle-right'></i></a>";
    }

    //send mail to created account
    SENDMAILS("Complete your onboarding process @ " . APP_NAME, "Dear " . $UserFullName . ",", $UserEmailId, "<br>
  <h2>Dear <b>$UserFullName</b></h2>
 $OnBoardingEmailContent
");

    //response to the user
    RESPONSE($SaveOnboarding, "Onboarding link sent successfully", "Unable to sent onboarding link, please try to complete it manually!");

    //add and update primary details
} elseif (isset($_POST['STEP_TWO_FOR_ADDRESS'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    //get user details
    $users = [
        "UserSalutation" => $_POST['UserSalutation'],
        "UserFullName" => $_POST['UserFullName'],
        "UserDateOfBirth" => $_POST['UserDateOfBirth'],
        "UserUpdatedAt" => CURRENT_DATE_TIME,
    ];
    $Update = UPDATE_DATA("users", $users, "UserId='$UserId'");

    //get alternate contact details in array post
    if (isset($_POST['uacd_person_name'])) {
        foreach ($_POST['uacd_person_name'] as $key => $value) {
            if ($_POST['uacd_person_name'][$key] != null && $_POST['uacd_phone_number'][$key] != null) {
                $user_alternate_contact_details = [
                    "uacd_main_user_id" => $UserId,
                    "uacd_person_name" => $_POST['uacd_person_name'][$key],
                    "uacd_phone_number" => $_POST['uacd_phone_number'][$key],
                    "uacd_relation" => $_POST['uacd_relation'][$key],
                ];
                // Save alternate contact details
                INSERT("user_alternate_contact_details", $user_alternate_contact_details);
            }
        }
    }

    if ($Update == true) {
        $_SESSION['NEXT_FORM_STATUS'] = 2;
        $OnboardingId = SECURE($_POST['OnboardingId'], "d");
        UPDATE("UPDATE user_onboarding SET users_step_a='1' where user_onboarding_id='$OnboardingId'");
    }
    //response to the user
    RESPONSE($Update, "Profile updated successfully", "Unable to update profile, please try again!");

    //add and update address
} else if (isset($_POST['ADD_MORE_ADDRESS'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    //save permanent address
    $PermanentAddress = [
        "UserStreetAddress" => SECURE($_POST['UserStreetAddress'], "e"),
        "UserLocality" =>  $_POST['UserLocality'],
        "UserCity" =>  $_POST['UserCity'],
        "UserState" =>  $_POST['UserState'],
        "UserCountry" => $_POST['UserCountry'],
        "UserPincode" => $_POST['UserPincode'],
        "UserAddressType" => $_POST['UserAddressType'],
        "UserAddressContactPerson" => $_POST['UserAddressContactPerson'],
        "UserAddressUserId" => $UserId
    ];
    $Save = INSERT("user_addresses", $PermanentAddress);

    //response to the user
    RESPONSE($Save, "Address updated successfully", "Unable to update address, please try again!");

    //remove address record
} elseif (isset($_GET['remove_address_record'])) {
    $UserId = SECURE($_GET['UserId'], "d");
    $AddressId = SECURE($_GET['UserAddressId'], "d");

    //delete address record
    $Delete = DELETE_FROM("user_addresses", "UserAddressId='$AddressId'");

    //response to the user
    RESPONSE($Delete, "Address deleted successfully", "Unable to delete address, please try again!");

    //continue for work experience
} elseif (isset($_POST['CONTINUE_FOR_WORK_EXPERIENCE'])) {
    $_SESSION['NEXT_FORM_STATUS'] = 3;
    $OnboardingId = SECURE($_POST['OnboardingId'], "d");

    UPDATE("UPDATE user_onboarding SET users_step_b='1' where user_onboarding_id='$OnboardingId'");

    //response to the user
    RESPONSE(true, "Address details saved successfully!<br>Please continue to fill education and work experience details!", "Unable to load next form, please try again!");

    //remove alternate contacts
} elseif (isset($_GET['remove_contact_records'])) {
    $uacd_id = SECURE($_GET['uacd_id'], "d");

    DeleteReqHandler("remove_contact_records", [
        "user_alternate_contact_details" => "uacd_id='$uacd_id'",
    ], [
        "true" => "Contact Details removed!",
        "false" => "Unable to remove contact details!"
    ]);

    //save education details!
} elseif (isset($_POST['ADD_EDUCATIONAL_DETAILS'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $OnboardingId = SECURE($_POST['OnboardingId'], "d");

    //prepare
    $user_educational_details = [
        "ued_main_user_id" => $UserId,
        "ued_title" => $_POST['ued_title'],
        "ued_qualification_type" => $_POST['ued_qualification_type'],
        "ued_athority" => $_POST['ued_athority'],
        "ued_passed_year" => $_POST['ued_passed_year'],
        "ued_remarks" => SECURE($_POST['ued_remarks'], "e"),
        "ued_created_at" => CURRENT_DATE_TIME,
        "ued_created_by" => $UserId
    ];
    //save education details
    $Save = INSERT("user_educational_details", $user_educational_details);

    //response to the user
    RESPONSE($Save, "Education details saved successfully", "Unable to save education details, please try again!");

    //continue for work experience
} elseif (isset($_POST['ADD_WORK_EXPERIENCES_DETAILS'])) {
    $UserId = SECURE($_POST['UserId'], "d");
    $OnboardingId = SECURE($_POST['OnboardingId'], "d");

    //prepare
    $user_work_experiences = [
        "uwe_main_user_id" => $UserId,
        "uwe_company_name" => $_POST['uwe_company_name'],
        "uwe_work_title" => $_POST['uwe_work_title'],
        "uwe_start_date" => $_POST['uwe_start_date'],
        "uwe_end_date" => $_POST['uwe_end_date'],
        "uwe_work_location" => $_POST['uwe_work_location'],
        "uwe_role_and_work_details" => SECURE($_POST['uwe_role_and_work_details'], "e"),
        "uwe_employement_type" => $_POST["uwe_employement_type"],
        "uwe_created_at" => CURRENT_DATE_TIME,
    ];
    //save work experience details
    $Save = INSERT("user_work_experiences", $user_work_experiences);

    //response to the user
    RESPONSE($Save, "Work experience details saved successfully", "Unable to save work experience details, please try again!");

    //update education details
} else if (isset($_POST['UPDATE_EDUCATIONAL_DETAILS'])) {
    $ued_id = SECURE($_POST['ued_id'], "d");

    //prepare
    $user_educational_details = [
        "ued_title" => $_POST['ued_title'],
        "ued_qualification_type" => $_POST['ued_qualification_type'],
        "ued_athority" => $_POST['ued_athority'],
        "ued_passed_year" => $_POST['ued_passed_year'],
        "ued_remarks" => SECURE($_POST['ued_remarks'], "e"),
        "ued_updated_at" => CURRENT_DATE_TIME,
        "ued_updated_by" => SECURE($_POST['UserId'], "d")
    ];
    //update education details
    $Update = UPDATE_DATA("user_educational_details", $user_educational_details, "ued_id='$ued_id'");

    //response to the user
    RESPONSE($Update, "Education details are updated successfully!", "Unable to update educational details at the moment!");

    //remove education details
} elseif (isset($_GET['remove_education_records'])) {
    $ued_id = SECURE($_GET['ued_id'], "d");

    DeleteReqHandler("remove_education_records", [
        "user_educational_details" => "ued_id='$ued_id'",
    ], [
        "true" => "Education Details removed!",
        "false" => "Unable to remove education details!"
    ]);

    //update work experience records
} elseif (isset($_POST['UPDATE_WORK_EXPERIENCES_DETAILS'])) {
    $uwe_id = SECURE($_POST['uwe_id'], "d");
    $UserId = SECURE($_POST['UserId'], "d");

    //update work experiences
    $user_work_experiences = [
        "uwe_company_name" => $_POST['uwe_company_name'],
        "uwe_work_title" => $_POST['uwe_work_title'],
        "uwe_start_date" => $_POST['uwe_start_date'],
        "uwe_end_date" => $_POST['uwe_end_date'],
        "uwe_work_location" => $_POST['uwe_work_location'],
        "uwe_role_and_work_details" => SECURE($_POST['uwe_role_and_work_details'], "e"),
        "uwe_employement_type" => $_POST["uwe_employement_type"],
        "uwe_updated_at" => CURRENT_DATE_TIME,
        "uwe_updated_by" => $UserId
    ];

    $Update = UPDATE_DATA("user_work_experiences", $user_work_experiences, "uwe_id='$uwe_id'");
    //response to the user
    RESPONSE($Update, "Work experience details are updated successfully!", "Unable to update work experience details at the moment!");

    //remove work experience records
} elseif (isset($_GET['remove_work_experience_records'])) {
    $uwe_id = SECURE($_GET['uwe_id'], "d");

    DeleteReqHandler("remove_work_experience_records", [
        "user_work_experiences" => "uwe_id='$uwe_id'",
    ], [
        "true" => "Work Experience Details removed!",
        "false" => "Unable to remove work experience details!"
    ]);

    //go for next step @Bank Details
} elseif (isset($_POST['CONTINUE_FOR_BANK_DETAILS'])) {
    $_SESSION['NEXT_FORM_STATUS'] = 4;
    $OnboardingId = SECURE($_POST['OnboardingId'], "d");

    UPDATE("UPDATE user_onboarding SET users_step_c='1' where user_onboarding_id='$OnboardingId'");

    //response to the user
    RESPONSE(true, "Education and Work Experience details saved successfully!<br>Please continue to fill bank details!", "Unable to load next form, please try again!");

    //add bank details
} elseif (isset($_POST['UPDATE_BANK_DETAILS'])) {
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

    //response to the user
    RESPONSE($Update, "Bank details saved successfully!", "Unable to save bank details, please try again!");

    //continue for next step which is bank details
} elseif (isset($_POST['CONTINUE_FOR_DOCUMENT_UPLOAD'])) {
    $_SESSION['NEXT_FORM_STATUS'] = 5;
    $OnboardingId = SECURE($_POST['OnboardingId'], "d");

    UPDATE("UPDATE user_onboarding SET users_step_d='1' where user_onboarding_id='$OnboardingId'");

    //response to the user
    RESPONSE(true, "Bank details saved successfully!<br>Please continue to upload documents!", "Unable to load next form, please try again!");

    //upload documents & continue for login and security
} elseif (isset($_POST['CONTINUE_FOR_LOGIN_AND_SECURITY'])) {
    $UserId = SECURE($_POST['UserId'], "d");

    //upload profile photo
    if (isset($_FILES['UserProfileImage']['name']) && $_FILES['UserProfileImage']['name'] != null) {
        $UserProfileImage = UPLOAD_FILES("../storage/users/$UserId/img", "null", "Profile_Photo_" . "_UID_" . $UserId, "UserProfileImage");
        $Update = UPDATE("UPDATE users SET UserProfileImage='$UserProfileImage' where UserId='$UserId'");
    }

    //upload pan card
    //save new uploaded
    if (isset($_FILES['PanCard']['name']) && $_FILES['PanCard']['name'] != null) {
        $PanCardUpload = array(
            "UserMainId" => $UserId,
            "UserDocumentNo" => "PANCARD",
            "UserDocumentName" => "PANCARD",
            "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", null, "Pancard", "PanCard",),
        );
        $Update = INSERT("user_documents", $PanCardUpload);
    }


    //adhaar card upload
    if (isset($_FILES['AdhaarCard']['name']) && $_FILES['AdhaarCard']['name'] != null) {
        $AdhaarCardUpload = array(
            "UserMainId" => $UserId,
            "UserDocumentNo" => "ADHAAR-CARD",
            "UserDocumentName" => "ADHAAR-CARD",
            "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "Null", "AdhaarCard", "AdhaarCard"),
        );
        $Update = INSERT("user_documents", $AdhaarCardUpload);
    }

    //check if SUBMITTED_RESUME is upload or not, if uploaded then upload and save
    if (isset($_FILES['SUBMITTED_RESUME'])) {
        if ($_FILES['SUBMITTED_RESUME']['name'] != null) {
            $ResumeUpload = array(
                "UserMainId" => $UserId,
                "UserDocumentNo" => "RESUME",
                "UserDocumentName" => "RESUME",
                "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "Resume", "SUBMITTED_RESUME"),
            );
            $Update = INSERT("user_documents", $ResumeUpload);
        }
    }

    //check if 10_TH_CERTIFICATE is uploaded or not
    if (isset($_FILES['10_TH_CERTIFICATE'])) {
        if ($_FILES['10_TH_CERTIFICATE']['name'] != null) {
            $TenthCertificate = array(
                "UserMainId" => $UserId,
                "UserDocumentNo" => "10-TH-MARKSHEET",
                "UserDocumentName" => "10-TH-MARKSHEET",
                "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "10th-Marksheet", "10_TH_CERTIFICATE"),
            );
            $Update = INSERT("user_documents", $TenthCertificate);
        }
    }

    //check if 12_TH_CERTIFICATE is uploaded or not
    if (isset($_FILES['12_TH_CERTIFICATE'])) {
        if ($_FILES['12_TH_CERTIFICATE']['name'] != null) {
            $TwelveCertificate = array(
                "UserMainId" => $UserId,
                "UserDocumentNo" => "12-TH-MARKSHEET",
                "UserDocumentName" => "12-TH-MARKSHEET",
                "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "12th-Marksheet", "12_TH_CERTIFICATE"),
            );
            $Update = INSERT("user_documents", $TwelveCertificate);
        }
    }

    //check if GRADUATION_CERTIFICATE is uploaded or not
    if (isset($_FILES['GRADUATION_CERTIFICATE'])) {
        if ($_FILES['GRADUATION_CERTIFICATE']['name'] != null) {
            $DiplomaDegree = array(
                "UserMainId" => $UserId,
                "UserDocumentNo" => "DIPLOMA-DEGREE-CERTIFICATE",
                "UserDocumentName" => "DIPLOMA-DEGREE-CERTIFICATE",
                "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "DIPLOMA-DEGREE", "GRADUATION_CERTIFICATE"),
            );
            $Update = INSERT("user_documents", $DiplomaDegree);
        }
    }

    //check if CANCEL_CHEQUE is uploaded or not
    if (isset($_FILES['CANCEL_CHEQUE'])) {
        if ($_FILES['CANCEL_CHEQUE']['name'] != null) {
            $CancelChequeUpload = array(
                "UserMainId" => $UserId,
                "UserDocumentNo" => "CANCEL-CHEQUE",
                "UserDocumentName" => "CANCEL-CHEQUE",
                "UserDocumentFile" => UPLOAD_FILES("../storage/teams/documents/$UserId", "null", "CancelCheque", "CANCEL_CHEQUE"),
            );
            $Update = INSERT("user_documents", $CancelChequeUpload);
        }
    }

    if (isset($_FILES['OTHER_DOCUMENTS'])) {
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'doc', 'docx', 'pdf'];
        $OtherDocumentsUpload = [];

        foreach ($_FILES['OTHER_DOCUMENTS']['name'] as $key => $value) {
            $fileTmpName = $_FILES['OTHER_DOCUMENTS']['tmp_name'][$key];
            $fileExtension = strtolower(pathinfo($value, PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedExtensions)) {
                $uploadDir = "../storage/teams/documents/$UserId"; // Define the directory where you want to save the files
                $filePath = $uploadDir . basename($value);

                if (move_uploaded_file($fileTmpName, $filePath)) {
                    $OtherDocumentsUpload[] = array(
                        "UserMainId" => $UserId,
                        "UserDocumentNo" => "OTHER-DOCUMENTS",
                        "UserDocumentName" => $value,
                        "UserDocumentFile" => $filePath,
                    );
                } else {
                    // Handle error during file upload
                    echo "Failed to upload file: $value";
                }
            } else {
                // Handle invalid file extension
                echo "Invalid file type: $value";
            }
        }

        if (!empty($OtherDocumentsUpload)) {
            $OtherDocuments = INSERT("user_documents", $OtherDocumentsUpload);
        }
    }

    $Update = true;

    //check $Update is true or not
    if ($Update == true) {
        $_SESSION['NEXT_FORM_STATUS'] = 6;
        $OnboardingId = SECURE($_POST['OnboardingId'], "d");
        UPDATE("UPDATE user_onboarding SET users_step_e='1' where user_onboarding_id='$OnboardingId'");
    }

    //send response
    RESPONSE($Update, "All documents uploaded successfully!", "Unable to upload documents, please try again!");

    //last step submitted and continue 
} elseif (isset($_POST['CONTINUE_AND_SUBMIT'])) {

    //check password change request is submitted or not
    if (isset($_POST['UserPassword_2']) && $_POST['UserPassword_2'] != null) {
        //check both are not null
        if ($_POST['UserPasswordNEW'] != null && $_POST['UserPassword_2'] != null) {
            $UserId = SECURE($_POST['UserId'], "d");
            $UserPassword = $_POST['UserPasswordNEW'];

            //check both are equal or not
            if ($_POST['UserPasswordNEW'] == $_POST['UserPassword_2']) {

                //update password for users
                $users = [
                    "UserPassword" => $_POST['UserPassword']
                ];

                //update password for user_details
                $Update = UPDATE_DATA("users", $users, "UserId='$UserId'");
            } else {
                //response to the user
                RESPONSE(false, "Passwords do not match!", "Passwords do not match!");
            }
        } else {
            //response to the user
            RESPONSE(false, "Password field is required!", "Password field is required!");
        }
    } else {
        $Update = true;
        $_SESSION['NEXT_FORM_STATUS'] = 7;
        $OnboardingId = SECURE($_POST['OnboardingId'], "d");
        UPDATE("UPDATE user_onboarding SET user_verification_status='1' where user_onboarding_id='$OnboardingId'");
        UPDATE("UPDATE user_onboarding SET user_verification_approval_status='1' where user_onboarding_id='$OnboardingId'");
    }

    //send response also mention thanking msg for completing onboarding process with APP_NAME, 
    RESPONSE($Update, "Your onboarding process has been completed successfully with " . APP_NAME . "!<br>Thank you for your time!", "Unable to complete onboarding process, please try again!");
}
