<?php

//save sender ids
if (isset($_POST['SAVE_NEW_SENDER_EMAIL_ID'])) {
    $config_mail_sender = [
        "config_mail_sender_host" => $_POST['config_mail_sender_host'],
        "config_mail_sender_username" => $_POST['config_mail_sender_username'],
        "config_mail_sender_password" => $_POST['config_mail_sender_password'],
        "config_mail_sent_from" => $_POST['config_mail_sender_username'],
        "config_mail_sender_port" => $_POST['config_mail_sender_port'],
        "config_mail_send_limit" => $_POST['config_mail_send_limit'],
    ];

    $Response = INSERT("config_mail_sender", $config_mail_sender);
    RESPONSE($Response, "SMTP details are updated successfully!", "Unable to update SMTP configuration!");

    //update sender ids
} elseif (isset($_POST['UPDATE_NEW_SENDER_EMAIL_ID'])) {
    $config_mail_sender_id = SECURE($_POST['config_mail_sender_id'], "d");

    $config_mail_sender = [
        "config_mail_sender_host" => $_POST['config_mail_sender_host'],
        "config_mail_sender_username" => $_POST['config_mail_sender_username'],
        "config_mail_sender_password" => $_POST['config_mail_sender_password'],
        "config_mail_sent_from" => $_POST['config_mail_sender_username'],
        "config_mail_sender_port" => $_POST['config_mail_sender_port'],
        "config_mail_send_limit" => $_POST['config_mail_send_limit'],
    ];

    $Response = UPDATE_DATA("config_mail_sender", $config_mail_sender, "config_mail_sender_id='$config_mail_sender_id'");
    RESPONSE($Response, "SMTP details are updated successfully!", "Unable to update SMTP configuration!");

    //remove sender email-id
} elseif (isset($_GET['Remove_Sender_Email_Ids'])) {
    $config_mail_sender_id = SECURE($_GET['config_mail_sender_id'], "d");
    DeleteReqHandler("Remove_Sender_Email_Ids", [
        "config_mail_sender" => "config_mail_sender_id='$config_mail_sender_id'"
    ], [
        "true" => "Sender email-id removed successfully!",
        "false" => "Unable to remove sender email-id!"
    ]);

    //send test mail
} elseif (isset($_POST['SEND_TEST_EMAIL'])) {
    $TEST_MAIL_SENDER_ID = $_POST['TEST_MAIL_SENDER_ID'];
    $TEST_MAIL_SUBJECT = $_POST['TEST_MAIL_SUBJECT'];
    $SEND_TO = $_POST['TEST_MAIL_TO'];
    $TEST_MAIL_MESSAGE = $_POST['TEST_MAIL_MESSAGE'];

    // Split the input by commas
    $emailsArray = explode(',', $SEND_TO);

    // Trim whitespace and validate emails
    $validEmails = [];
    foreach ($emailsArray as $email) {
        $trimmedEmail = trim($email);
        if (filter_var($trimmedEmail, FILTER_VALIDATE_EMAIL)) {
            $validEmails[] = $trimmedEmail;
        }
    }

    //send test mail to all provided emails
    if (!empty($validEmails)) {
        foreach ($validEmails as $validEmail) {
            $Response = SENDMAILSTEMPLATE($TEST_MAIL_SUBJECT, $validEmail, $TEST_MAIL_MESSAGE, $TEST_MAIL_SENDER_ID);
        }
    } else {
        $Response = false;
    }


    RESPONSE($Response, "Test mail is sent successfully!", "Unable to send test mail!");

    //save email templates
} elseif (isset($_POST['SAVE_NEW_EMAIL_TEMPLATES'])) {
    $EmailTemplate = UpperCaseSimilarVariables($_POST['config_mail_template_content'], "$");

    $config_mail_templates = [
        "config_mail_template_name" => $_POST['config_mail_template_name'],
        "config_mail_template_ref_no" => RemoveSpace(UpperCase($_POST['config_mail_template_name'])),
        "config_mail_template_content" => $EmailTemplate,
        "config_mail_template_created_at" => CURRENT_DATE_TIME,
        "config_mail_template_updated_at" => CURRENT_DATE_TIME,
        "config_mail_template_created_by" => LOGIN_UserId,
        "config_mail_template_updated_by" => LOGIN_UserId,
        "config_mail_template_status" => 1,
        "config_mail_template_subject" => UpperCaseSimilarVariables($_POST['config_mail_template_subject'], "$"),
        "config_email_template_type" => $_POST['config_email_template_type']
    ];

    $Response = INSERT("config_mail_templates", $config_mail_templates);
    $config_mail_template_id = FETCH("SELECT config_mail_template_id FROM config_mail_templates ORDER BY config_mail_template_id DESC LIMIT 1", "config_mail_template_id");

    //save csv headers if template_variable type is CUSTOM_VARIABLES
    if ($_POST['config_email_template_type'] == "CUSTOM_VARIABLES") {

        //get variables from template
        $emailTemplateContent = $EmailTemplate;
        preg_match_all('/\$\w+/', $emailTemplateContent, $matches);
        $ExtractAllVariables = array_unique($matches[0]);
        $StartCSVHeaders = 0;
        foreach ($ExtractAllVariables as $HeaderName) {
            if ($HeaderName != null) {
                $NewHeaderName = htmlentities(UpperCase(GetStrings($HeaderName, "$")));
                $config_email_template_headers = [
                    "config_email_template_main_id" => $config_mail_template_id,
                    "config_email_template_header_name" => $NewHeaderName
                ];
                $CheckDupliCateHeaders = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$NewHeaderName' and config_email_template_main_id='$config_mail_template_id'");
                if ($CheckDupliCateHeaders == null) {
                    $Response = INSERT("config_email_template_headers", $config_email_template_headers);
                }
            }
        }

        //get variables from subject
        $Subject = UpperCaseSimilarVariables($_POST['config_mail_template_subject'], "$");
        preg_match_all('/\$\w+/', $Subject, $matches);
        $ExtractAllVariables = array_unique($matches[0]);
        $StartCSVHeaders = 0;
        foreach ($ExtractAllVariables as $HeaderName) {
            if ($HeaderName != null) {
                $NewHeaderName = UpperCase(GetStrings($HeaderName, "$"));
                $config_email_template_headers = [
                    "config_email_template_main_id" => $config_mail_template_id,
                    "config_email_template_header_name" => $NewHeaderName
                ];
                $CheckDupliCateHeaders = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$NewHeaderName' and config_email_template_main_id='$config_mail_template_id'");
                if ($CheckDupliCateHeaders == null) {
                    $Response = INSERT("config_email_template_headers", $config_email_template_headers);
                }
            }
        }
    }

    //save default and required header
    $EMAILID = '$EMAILID';
    $HeaderContainEmailId = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$EMAILID' and config_email_template_main_id='$config_mail_template_id'");
    if ($HeaderContainEmailId == null) {
        $config_email_template_headers = [
            "config_email_template_main_id" => $config_mail_template_id,
            "config_email_template_header_name" => $EMAILID
        ];
        $Response = INSERT("config_email_template_headers", $config_email_template_headers);
    }


    $total_count = count($_FILES['config_mail_template_documents']['name']);
    for ($i = 0; $i < $total_count; $i++) {
        $UploadDir = "../storage/email_attachments/";
        $ProImageName = $_FILES['config_mail_template_documents']['name'][$i];
        $ProImageType = $_FILES['config_mail_template_documents']['type'][$i];
        $ProImageSize = $_FILES['config_mail_template_documents']['size'][$i];
        $ProImageTmpName = $_FILES['config_mail_template_documents']['tmp_name'][$i];
        $ProImageError = $_FILES['config_mail_template_documents']['error'][$i];
        $ProImageExt = pathinfo($ProImageName, PATHINFO_EXTENSION);

        $config_mail_template_documents = RemoveSpace(UpperCase($_POST['config_mail_template_name'])) . "_" . $i . "_" . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
        $ProImagePath = $UploadDir . $config_mail_template_documents;
        $ProImageStatus = 1;

        if ($ProImageExt === 'jpg' || $ProImageExt === 'jpeg' || $ProImageExt === 'pdf' || $ProImageExt === 'webp' || $ProImageExt === 'png' || $ProImageExt === 'gif') {
            if (!file_exists("$UploadDir/")) {
                mkdir("$UploadDir/", 0777, true);
            }
            move_uploaded_file($ProImageTmpName, $ProImagePath);
            $SaveImages = INSERT("config_mail_template_attachements", [
                "config_mail_template_main_id" => $config_mail_template_id,
                "config_mail_template_documents" => $config_mail_template_documents
            ]);
        } else {
            $SaveImages = false;
        }
    }

    if (isset($_POST['COMPOSE_OPTION'])) {
        $access_url = APP_URL . "/emails/compose?SELECTED_EMAIL_TEMPLATE_ID=" . $config_mail_template_id . "&SELECTED_SENDER_EMAIL_ID=1";
    }
    RESPONSE($Response, "Email templates are saved successfully!", "Unable to save email templates at the moment!");

    //update email templates
} elseif (isset($_POST['UPDATE_NEW_EMAIL_TEMPLATES'])) {
    $config_mail_template_id = SECURE($_POST['config_mail_template_id'], "d");
    $EmailTemplate = UpperCaseSimilarVariables($_POST['config_mail_template_content'], "$");

    $config_mail_templates = [
        "config_mail_template_name" => $_POST['config_mail_template_name'],
        "config_mail_template_ref_no" => RemoveSpace(UpperCase($_POST['config_mail_template_name'])),
        "config_mail_template_content" => $EmailTemplate,
        "config_mail_template_created_at" => CURRENT_DATE_TIME,
        "config_mail_template_updated_at" => CURRENT_DATE_TIME,
        "config_mail_template_created_by" => LOGIN_UserId,
        "config_mail_template_updated_by" => LOGIN_UserId,
        "config_mail_template_status" => 1,
        "config_mail_template_subject" => UpperCaseSimilarVariables($_POST['config_mail_template_subject'], "$"),
        "config_email_template_type" => $_POST['config_email_template_type']
    ];

    $Response = UPDATE_DATA("config_mail_templates", $config_mail_templates, "config_mail_template_id='$config_mail_template_id'");

    //save csv headers if template_variable type is CUSTOM_VARIABLES
    $CheckIfExitsOrNot = CHECK("SELECT * FROM config_email_template_headers WHERE config_email_template_main_id='$config_mail_template_id'");
    if ($CheckIfExitsOrNot != NULL) {
        DELETE_FROM("config_email_template_headers", "config_email_template_main_id='$config_mail_template_id'");
    }

    if ($_POST['config_email_template_type'] == "CUSTOM_VARIABLES") {
        //get variables from email templates
        $emailTemplateContent = $EmailTemplate;
        preg_match_all('/\$\w+/', $emailTemplateContent, $matches);
        $ExtractAllVariables = array_unique($matches[0]);
        $StartCSVHeaders = 0;
        foreach ($ExtractAllVariables as $HeaderName) {
            if ($HeaderName != null) {
                $NewHeaderName = htmlentities(UpperCase(GetStrings($HeaderName, "$")));
                $config_email_template_headers = [
                    "config_email_template_main_id" => $config_mail_template_id,
                    "config_email_template_header_name" => $NewHeaderName
                ];
                $CheckDupliCateHeaders = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$NewHeaderName' and config_email_template_main_id='$config_mail_template_id'");
                if ($CheckDupliCateHeaders == null) {
                    $Response = INSERT("config_email_template_headers", $config_email_template_headers);
                }
            }
        }

        //get variables from subject
        $Subject = UpperCaseSimilarVariables($_POST['config_mail_template_subject'], "$");
        preg_match_all('/\$\w+/', $Subject, $matches);
        $ExtractAllVariables = array_unique($matches[0]);
        $StartCSVHeaders = 0;
        foreach ($ExtractAllVariables as $HeaderName) {
            if ($HeaderName != null) {
                $NewHeaderName = UpperCase(GetStrings($HeaderName, "$"));
                $config_email_template_headers = [
                    "config_email_template_main_id" => $config_mail_template_id,
                    "config_email_template_header_name" => $NewHeaderName
                ];
                $CheckDupliCateHeaders = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$NewHeaderName' and config_email_template_main_id='$config_mail_template_id'");
                if ($CheckDupliCateHeaders == null) {
                    $Response = INSERT("config_email_template_headers", $config_email_template_headers);
                }
            }
        }
    } else {
        $CheckIfExitsOrNot = CHECK("SELECT * FROM config_email_template_headers WHERE config_email_template_main_id='$config_mail_template_id'");
        if ($CheckIfExitsOrNot != NULL) {
            DELETE_FROM("config_email_template_headers", "config_email_template_main_id='$config_mail_template_id'");
        }
    }

    //save default and required header
    $EMAILID = '$EMAILID';
    $HeaderContainEmailId = CHECK("SELECT * FROM config_email_template_headers where config_email_template_header_name='$EMAILID' and config_email_template_main_id='$config_mail_template_id'");
    if ($HeaderContainEmailId == null) {
        $config_email_template_headers = [
            "config_email_template_main_id" => $config_mail_template_id,
            "config_email_template_header_name" => $EMAILID
        ];
        $Response = INSERT("config_email_template_headers", $config_email_template_headers);
    }

    $total_count = count($_FILES['config_mail_template_documents']['name']);
    for ($i = 0; $i < $total_count; $i++) {
        $UploadDir = "../storage/email_attachments/";
        $ProImageName = $_FILES['config_mail_template_documents']['name'][$i];
        $ProImageType = $_FILES['config_mail_template_documents']['type'][$i];
        $ProImageSize = $_FILES['config_mail_template_documents']['size'][$i];
        $ProImageTmpName = $_FILES['config_mail_template_documents']['tmp_name'][$i];
        $ProImageError = $_FILES['config_mail_template_documents']['error'][$i];
        $ProImageExt = pathinfo($ProImageName, PATHINFO_EXTENSION);

        $config_mail_template_documents = RemoveSpace(UpperCase($_POST['config_mail_template_name'])) . "_" . $i . "_" . date("d_m_Y_h_m_s_a_") . "." . $ProImageExt;
        $ProImagePath = $UploadDir . $config_mail_template_documents;
        $ProImageStatus = 1;

        if ($ProImageExt === 'jpg' || $ProImageExt === 'jpeg' || $ProImageExt === 'pdf' || $ProImageExt === 'webp' || $ProImageExt === 'png' || $ProImageExt === 'gif') {
            if (!file_exists("$UploadDir/")) {
                mkdir("$UploadDir/", 0777, true);
            }
            move_uploaded_file($ProImageTmpName, $ProImagePath);
            $SaveImages = INSERT("config_mail_template_attachements", [
                "config_mail_template_main_id" => $config_mail_template_id,
                "config_mail_template_documents" => $config_mail_template_documents
            ]);
        } else {
            $SaveImages = false;
        }
    }

    if (isset($_POST['COMPOSE_OPTION'])) {
        $access_url = APP_URL . "/emails/compose?SELECTED_EMAIL_TEMPLATE_ID=" . $config_mail_template_id . "&SELECTED_SENDER_EMAIL_ID=1";
    }
    RESPONSE($Response, "Email templates are updated successfully!", "Unable to update email templates at the moment!");

    //remove old email templates
} elseif (isset($_GET['Remove_Email_Templates'])) {
    $config_mail_template_id = SECURE($_GET['config_mail_template_id'], "d");

    DeleteReqHandler("Remove_Email_Templates", [
        "config_mail_templates" => "config_mail_template_id='$config_mail_template_id'",
        "config_mail_template_attachements" => "config_mail_template_main_id='$config_mail_template_id'",
        "config_email_template_headers" => "config_email_template_main_id='$config_email_template_id'",
    ], [
        "true" => "Email templates removed successfully!",
        "false" => "Unable to remove email templates!"
    ]);



    //remove email template attachments
} elseif (isset($_GET['Remove_Email_Template_Attachements'])) {
    $config_mail_template_attachement_id = SECURE($_GET['config_mail_template_attachment_id'], "d");
    DeleteReqHandler("Remove_Email_Template_Attachements", [
        "config_mail_template_attachements" => "config_mail_template_attachment_id='$config_mail_template_attachement_id'"
    ], [
        "true" => "Email template attachements removed successfully!",
        "false" => "Unable to remove email template attachements!"
    ]);
}
