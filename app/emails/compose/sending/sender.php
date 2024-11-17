<?php
// Include necessary files
$Dir = "../../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

// Initialize arrays
$EMAIL_SENT = [];
$EMAIL_SENT_FAILED = [];
$EMAIL_COLLECTIONS = [];
$SENDING_TEMPLATES = [];
$SENDING_SUBJECTS = [];

//Debug Mode 
$DebuggingTrue = false;

$EmailIdLists = $_SESSION['EMAILS_ACCOUNT_IDS'];
$SenderEmailId = $_SESSION['SenderEmailId'];
$TemplateId = $_SESSION['TEMPLATE_ID'];
$SendingModule = $_SESSION['SENDING_MODULE'];
$TotalEmails = $_SESSION['TOTAL_EMAILS'];
$CAMPAIGN_TEMP_PROCESS_ID = $_SESSION['CAMPAIGN_TEMP_PROCESS_ID'];

// Process email lists
if ($SendingModule == "users") {
    foreach ($EmailIdLists as $EmailId) {
        $UserEmailIds = strtolower(FETCH("SELECT * FROM users where UserId='$EmailId'", "UserEmailId"));
        if (!in_array($UserEmailIds, $EMAIL_COLLECTIONS, true)) {
            $EMAIL_COLLECTIONS[] = $UserEmailIds;
        }
    }
} elseif ($SendingModule == "customers") {
    foreach ($EmailIdLists as $EmailId) {
        $UserEmailIds = strtolower(FETCH("SELECT * FROM customers where CustomerId='$EmailId'", "CustomerEmailId"));
        if (!in_array($UserEmailIds, $EMAIL_COLLECTIONS, true)) {
            $EMAIL_COLLECTIONS[] = $UserEmailIds;
        }
    }

    //if sending module is uploaded via csv file
} elseif ($SendingModule == "upload") {
    foreach ($EmailIdLists as $EmailId) {
        if (!in_array($EmailId, $EMAIL_COLLECTIONS, true)) {
            $EMAIL_COLLECTIONS[] = $EmailId;
        }
    }
    //get All headers Name
    $AllHandlerSQL = "SELECT * FROM temp_email_upload_handler where temp_email_upload_handler_name='$CAMPAIGN_TEMP_PROCESS_ID'";
    $AllHandlerSQLProcessor = _DB_COMMAND_($AllHandlerSQL, true);
    if ($AllHandlerSQLProcessor != null) {

        ///get all available Handlers
        foreach ($AllHandlerSQLProcessor as $Handler) {
            $HandlerId = $Handler->temp_email_upload_handler_id;
            $HandlerName = $Handler->temp_email_upload_handler_name;
            if ($DebuggingTrue == true) {
                echo "(HANDLERID:$HandlerId)-----Handler Name: <b><small>$HandlerName</small></b><br>";
            }

            //get All headers of this handler
            $AllHeaderSQL = "SELECT * FROM temp_email_uploaded_headers, temp_email_uploaded_header_values where temp_email_uploaded_headers.temp_email_uploaded_header_id=temp_email_uploaded_header_values.temp_email_uploaded_header_main_id and temp_email_upload_handler_id='$HandlerId' GROUP BY temp_email_upload_header_record_value ASC";
            $AllHeaderSQLProcessor = _DB_COMMAND_($AllHeaderSQL, true);
            if ($AllHeaderSQLProcessor != null) {

                // Assuming you have a function _DB_COMMAND_ to execute SQL and return results
                // and a function FETCH to get a single field value from the query result

                // Step 1: Fetch all header names
                $TotalRecords = COUNT($AllHeaderSQLProcessor);
                if ($DebuggingTrue == true) {
                    echo "---TOTAL RECORDS:------------------- <b>$TotalRecords</b> Records<BR>";
                    echo "<hr>";
                }
                $StartRecordProcessing = 0;

                while ($StartRecordProcessing < $TotalRecords) {
                    $StartRecordProcessing++;
                    if ($DebuggingTrue == true) {
                        echo "@-------------PROCESSING STARTED FOR :------------------- <b>$StartRecordProcessing</b> No of Records<BR>";
                    }
                    $RecordViewId = $StartRecordProcessing;

                    // Step 2: Get template variables for the current record
                    $AllTemplateVariblesSQL = "SELECT * FROM temp_email_uploaded_header_values WHERE temp_email_upload_header_record_value='$RecordViewId'";
                    $AllTemplateVariblesSQLProcessor = _DB_COMMAND_($AllTemplateVariblesSQL, true);



                    // Debugging: Check if the query returned any results
                    if (empty($AllTemplateVariblesSQLProcessor)) {
                        if ($DebuggingTrue == true) {
                            echo "No variables found for RecordViewId: $RecordViewId<br>";
                        }
                        continue;
                    }

                    // Initialize an array to store the variables and their values
                    $variables = [];
                    $Records = 0;

                    foreach ($AllTemplateVariblesSQLProcessor as $TempVariables) {
                        $Records++;
                        // Fetch the variable name
                        $VariableName = FETCH("SELECT temp_email_upload_header_name FROM temp_email_uploaded_headers WHERE temp_email_uploaded_header_id='" . $TempVariables->temp_email_uploaded_header_main_id . "'", "temp_email_upload_header_name");
                        //Header Email-IDs
                        if ($VariableName == '$EMAILID') {
                            $RequestedEmailId = $TempVariables->temp_email_uploaded_header_value;
                        }

                        // Debugging: Check if the variable name was fetched correctly
                        if (empty($VariableName)) {
                            if ($DebuggingTrue == true) {
                                echo "Variable name not found for header ID: " . $TempVariables->temp_email_uploaded_header_main_id . "<br>";
                            }
                            continue;
                        }

                        // Get the variable value
                        $VariableValue = $TempVariables->temp_email_uploaded_header_value;
                        $variables[$VariableName] = $VariableValue;
                    }

                    // Debugging: Check the collected variables
                    if (empty($variables)) {
                        if ($DebuggingTrue == true) {
                            echo "No variables were processed for RecordViewId: $RecordViewId<br>";
                        }
                        continue;
                    }

                    // Step 3: Get the email template
                    if ($DebuggingTrue == true) {
                        echo "############-------TEMPLATE-PROCESSING : <b>$RecordViewId</b>-----------###########<br>";
                    }

                    $EmailTemplate = FETCH("SELECT config_mail_template_content FROM config_mail_templates WHERE config_mail_template_id='$TemplateId'", "config_mail_template_content");
                    $EmailTemplateSubject = FETCH("SELECT config_mail_template_subject FROM config_mail_templates WHERE config_mail_template_id='$TemplateId'", "config_mail_template_subject");

                    // Debugging: Check if the email template was fetched correctly
                    if (empty($EmailTemplate)) {
                        if ($DebuggingTrue == true) {
                            echo "Email template not found for TemplateId: $TemplateId<br>";
                        }
                        continue;
                    }

                    // Step 4: Replace placeholders in the template with actual values
                    foreach ($variables as $key => $value) {
                        // Note: Using the variable name directly without double dollar sign $$ as the key in str_replace
                        $EmailTemplate = str_replace("$key", $value, $EmailTemplate);
                    }


                    // Step 5: Replace placeholders in the template with actual values
                    foreach ($variables as $key => $value) {
                        // Note: Using the variable name directly without double dollar sign $$ as the key in str_replace
                        $EmailTemplateSubject = str_replace("$key", $value, $EmailTemplateSubject);
                    }


                    //Caputre avaialble attachements
                    $AllAttachements = "SELECT * FROM config_mail_template_attachements where config_mail_template_main_id='$TemplateId'";
                    $AllAttachementsProcessor = _DB_COMMAND_($AllAttachements, true);
                    if ($AllAttachementsProcessor != null) {
                        $MailAttachments = [];

                        //prepare attachments for email 
                        foreach ($AllAttachementsProcessor as $Attachements) {
                            $MailAttachments[] = [
                                "name" => $Attachements->config_mail_template_documents,
                                "FilePath" => __DIR__ . "/../../../../storage/email_attachments/" . $Attachements->config_mail_template_documents
                            ];
                        }
                    } else {
                        $MailAttachments = [];
                    }

                    //prepare email data with attachments
                    $EmailIndexValues = $RecordViewId - 1;
                    $SENDING_TEMPLATES[] = [
                        "Sentto" => $RequestedEmailId,
                        "template" => $EmailTemplate,
                        "subject" => $EmailTemplateSubject,
                        "attachments" => $MailAttachments
                    ];
                }
            }
        }
    }



    //else if no sending module is defined
} else {
    $UserEmailIds = "noemail@domain.com";
    if (!in_array($UserEmailIds, $EMAIL_COLLECTIONS, true)) {
        $EMAIL_COLLECTIONS[] = $UserEmailIds;
    }
}

//send emails
foreach ($SENDING_TEMPLATES as $SentTo => $Template) {

    if ($DebuggingTrue == true) {
        echo "Send To : <b>" . $Template['Sentto'] . "</b><br>";
        echo "Subject: " . "" . $Template["subject"] . "<br>";
        echo "Template: " . "" . $Template["template"] . "<br>";
        echo "---------------------------------------------------------------------<br>";
        echo "Attachments:" . count($Template['attachments']) . " attachements <br>";
        //check attachments
        if (!empty($Template['attachments'])) {
            foreach ($Template['attachments'] as $Name => $File) {
                echo "Attachment Name: <b>" . $File['name'] . "</b><br>";
                echo "Attachment Path: <b>" . $File['FilePath'] . "</b><br>";
                echo "---------------------------------------------------------------------<br>";
            }
        }
    }
    //$EmailResponse = true;
    $EmailResponse = SENDMAILSTEMPLATE($Template["subject"], $Template['Sentto'], $Template["template"], $SenderEmailId, $Template['attachments']);
    if ($EmailResponse == true) {
        if (!in_array($Template['Sentto'], $EMAIL_SENT, true)) {
            $EMAIL_SENT[] = $Template['Sentto'];
        }
    } else {
        if (!in_array($Template['Sentto'], $EMAIL_SENT_FAILED, true)) {
            $EMAIL_SENT_FAILED[] = $Template['Sentto'];
        }
    }
}

//remove previously uploaded records
if ($DebuggingTrue == false) {
    DELETE_SQL("DELETE FROM temp_email_uploaded_headers");
    DELETE_SQL("DELETE FROM temp_email_uploaded_header_values");
    DELETE_SQL("DELETE FROM temp_email_upload_handler");
}


// Get counts
$TOTAL_SENT_EMAILS = count($EMAIL_SENT);
$TOTAL_FAILED_EMAILS = count($EMAIL_SENT_FAILED);
$TOTAL_EMAIL_COLLECTION = count($EMAIL_COLLECTIONS);
$DUPLICATE_EMAIL_ID = $TotalEmails - $TOTAL_EMAIL_COLLECTION;

// Create JSON response
$response['totalEmails'] = $TOTAL_EMAIL_COLLECTION;
$response['sendingCount'] = $TOTAL_SENT_EMAILS;
$response['failedEmails'] = $TOTAL_FAILED_EMAILS;
$response['duplicateEmails'] = $DUPLICATE_EMAIL_ID;

echo json_encode($response);
