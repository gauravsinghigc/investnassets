<?php
$Dir = "../../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

//pagevariables
$PageName = "SEND NEW EMAIL";
$PageDescription = "Manage all customers";
$CAMPAIGN_TEMP_PROCESS_ID = $_SESSION['CAMPAIGN_TEMP_PROCESS_ID'];

if (isset($_POST['PROCESS_DYNAMIC_EMAILS'])) {
    $EMAIL_ID = $_POST['EMAIL_ID'];
    $TEMPLATE_ID = $_POST['TEMPLATE_ID'];
    $SENDING_MODULE = $_POST['SENDING_MODULE'];

    if ($SENDING_MODULE == "users") {
        $EMAILS_ACCOUNT_IDS = $_POST['UserId'];
        $TOTAL_EMAILS = count($EMAILS_ACCOUNT_IDS);
    } elseif ($SENDING_MODULE == "customers") {
        $EMAILS_ACCOUNT_IDS = $_POST['CustomerIds'];
        $TOTAL_EMAILS = count($EMAILS_ACCOUNT_IDS);
    } elseif ($SENDING_MODULE == "upload") {
        $GET_RECORDS_FROM_UPLOADED_FILE = $_SESSION['CAMPAIGN_TEMP_PROCESS_ID'];

        // Handle uploaded CSV records
        if ($SENDING_MODULE == "upload") {
            $FileName = explode(".", $_FILES['UPLOADED_CSV_FILE']['name']);
            if (end($FileName) == "csv") {  // Check if the uploaded file is a CSV
                $handle = fopen($_FILES['UPLOADED_CSV_FILE']['tmp_name'], "r");

                // Save temporary campaign name
                $temp_email_upload_handler = [
                    "temp_email_upload_handler_name" => $CAMPAIGN_TEMP_PROCESS_ID
                ];
                $Check = CHECK("SELECT * FROM temp_email_upload_handler WHERE temp_email_upload_handler_name='$CAMPAIGN_TEMP_PROCESS_ID'");
                if ($Check == null) {
                    INSERT("temp_email_upload_handler", $temp_email_upload_handler);
                    $temp_email_upload_handler_id = FETCH("SELECT * FROM temp_email_upload_handler ORDER BY temp_email_upload_handler_id DESC LIMIT 1", "temp_email_upload_handler_id");
                } else {
                    $temp_email_upload_handler_id = FETCH("SELECT * FROM temp_email_upload_handler ORDER BY temp_email_upload_handler_id DESC LIMIT 1", "temp_email_upload_handler_id");
                }

                // Read the first row as headers
                if (($headerRow = fgetcsv($handle)) !== false) {
                    foreach ($headerRow as $header) {
                        $HeaderValue = "$" . RemoveAllSpecialCharacters(UpperCase($header));
                        $temp_email_uploaded_headers = [
                            "temp_email_upload_handler_id" => $temp_email_upload_handler_id,
                            "temp_email_upload_header_name" => $HeaderValue,
                        ];

                        $CheckHeaders = CHECK("SELECT * FROM temp_email_uploaded_headers WHERE temp_email_upload_header_name='$HeaderValue' AND temp_email_upload_handler_id='$temp_email_upload_handler_id'");
                        if ($CheckHeaders == null) {
                            INSERT("temp_email_uploaded_headers", $temp_email_uploaded_headers);
                        }

                        $temp_email_uploaded_header_main_id = FETCH("SELECT * FROM temp_email_uploaded_headers WHERE temp_email_upload_header_name='$HeaderValue' AND temp_email_upload_handler_id='$temp_email_upload_handler_id'", "temp_email_uploaded_header_id");
                        $temp_email_upload_header_name = FETCH("SELECT * FROM temp_email_uploaded_headers WHERE temp_email_upload_header_name='$HeaderValue' AND temp_email_upload_handler_id='$temp_email_upload_handler_id'", "temp_email_upload_header_name");

                        // Read the remaining rows as values
                        $RecordNumber = 0;
                        while (($row = fgetcsv($handle)) !== false) {
                            $RecordNumber++;
                            $value = $row[array_search($header, $headerRow)];
                            $temp_email_uploaded_header_values = [
                                "temp_email_uploaded_header_main_id" => $temp_email_uploaded_header_main_id,
                                "temp_email_uploaded_header_value" => $value,
                                "temp_email_upload_header_record_value" => $RecordNumber
                            ];
                            if ($temp_email_upload_header_name == '$EMAILID') {
                                $CheckDuplicateValues = CHECK("SELECT * FROM temp_email_uploaded_header_values where temp_email_uploaded_header_value='$value' and temp_email_uploaded_header_main_id='$temp_email_uploaded_header_main_id'");
                            } else {
                                $CheckDuplicateValues = null;
                            }
                            if ($CheckDuplicateValues == null) {
                                INSERT("temp_email_uploaded_header_values", $temp_email_uploaded_header_values);
                            }
                        }

                        // Reset file pointer to the beginning of the values rows
                        fseek($handle, 0);
                        fgetcsv($handle);  // Skip headers row
                    }
                }
                fclose($handle);
            }
        }

        $CAMPAIGN_SQL = "SELECT * FROM temp_email_upload_handler where temp_email_upload_handler_name='$GET_RECORDS_FROM_UPLOADED_FILE'";
        $AllUploadedEmailIds = CHECK($CAMPAIGN_SQL);
        if ($AllUploadedEmailIds != null) {
            $EMAILS_ACCOUNT_IDS = [];
            $GetCampaignIds = FETCH($CAMPAIGN_SQL, "temp_email_upload_handler_id");

            //get campaign email header ids
            $CampaignEmailIds = _DB_COMMAND_("SELECT * FROM temp_email_uploaded_headers where temp_email_upload_handler_id='$GetCampaignIds' and temp_email_upload_header_name like '%EMAILID%'", true);
            if ($CampaignEmailIds != null) {
                foreach ($CampaignEmailIds as $GetEmailHeader) {
                    $EmailHeaderId = $GetEmailHeader->temp_email_uploaded_header_id;

                    //get email-ids
                    $EmaildsSQL = "SELECT * FROM temp_email_uploaded_header_values where temp_email_uploaded_header_main_id='$EmailHeaderId'";
                    $EmailIdsRecords = _DB_COMMAND_($EmaildsSQL, true);
                    if ($EmailIdsRecords != null) {
                        foreach ($EmailIdsRecords as $GetEmailId) {
                            $EmailId = $GetEmailId->temp_email_uploaded_header_value;
                            if (!in_array($EmailId, $EMAILS_ACCOUNT_IDS, true)) {
                                $EMAILS_ACCOUNT_IDS[] = $EmailId;
                            }
                        }
                    }
                }
            }
        }
        $TOTAL_EMAILS = count($EMAILS_ACCOUNT_IDS);
    } else {
        $EMAILS_ACCOUNT_IDS = [];
        $TOTAL_EMAILS = count($EMAILS_ACCOUNT_IDS);
    }
    sort($EMAILS_ACCOUNT_IDS);

    $_SESSION['EMAILS_ACCOUNT_IDS'] = $EMAILS_ACCOUNT_IDS;
    $_SESSION['SenderEmailId'] = $EMAIL_ID;
    $_SESSION['TOTAL_EMAILS'] = $TOTAL_EMAILS;
    $_SESSION['TEMPLATE_ID'] = $TEMPLATE_ID;
    $_SESSION['SENDING_MODULE'] = $SENDING_MODULE;

    //sql
    $EMAIL_SQL = "SELECT * FROM config_mail_sender where config_mail_sender_id='$EMAIL_ID'";
    $TEMPLATE_SQL = "SELECT * FROM config_mail_templates where config_mail_template_id='$TEMPLATE_ID'";
} else {
    header("location: ../index.php");
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
    <script type="text/javascript">
        function SidebarActive() {
            document.getElementById("profile").classList.add("active");
            document.getElementById("profile_view").classList.add("active");
        }
        window.onload = SidebarActive;
    </script>
    <style>
        .height-limit-2 {
            height: 100% !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php

        include $Dir . "/include/app/Header.php";
        include $Dir . "/include/sidebar/get-side-menus.php";
        include $Dir . "/include/app/Loader.php"; ?>

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
                                            <div class="shadow-sm">
                                                <div class="row pt-2">
                                                    <div class="col-md-12 text-center">
                                                        <img src="https://i.pinimg.com/originals/07/99/0d/07990de3a791c7330131934bc546ad25.gif" class="w-pr-20 img-fluid">
                                                        <img src="https://manipalalumni.manipal.edu/images/Processing.gif" class="img-fluid w-pr-10" id='ProcessingImage'>
                                                    </div>
                                                    <div class="col-md-12 text-center">
                                                        <hr class="w-75 mb-5">
                                                        <h6 id='IfUploaded'><i class='fa fa-spinner fa-spin text-danger'></i> Please wait while sending dynamic emails....</h6>
                                                        <p>we are also processing provided emails so that, only unique and valid emails will be used!</p>
                                                        <p id='DontRefreshMsg' class='text-danger hidden'><i class='fa fa-warning blink-data'></i> Please don't refresh the page, it will resend the template again to uploaded records!.</p>
                                                        <center>
                                                            <div class="flex-s-b w-75 text-center p-2 mt-3 mb-2">
                                                                <div class="w-25 text-center shadow-sm p-2 m-1">
                                                                    <h2 class='bold text-primary'><?php echo $TOTAL_EMAILS; ?></h2>
                                                                    <h6 class="bold text-primary">Total Emails</h6>
                                                                </div>
                                                                <div class="w-25 text-center shadow-sm p-2 m-1">
                                                                    <h2 class='bold text-success' id='TotalEmailsUnique'>0</h2>
                                                                    <h6 class="bold text-success">Unique Emails</h6>
                                                                </div>
                                                                <div class="w-25 text-center shadow-sm p-2 m-1">
                                                                    <h2 class="text-info" id='sendingCount'>0</>
                                                                        <h6 class="bold text-info">Sent Emails</h6>
                                                                </div>
                                                                <div class="w-25 text-center shadow-sm p-2 m-1">
                                                                    <h2 id='FailedEmails' class='text-danger'>0</>
                                                                        <h6 class="bold text-danger">Failed Emails</h6>
                                                                </div>
                                                                <div class="w-25 text-center shadow-sm p-2 m-1">
                                                                    <h2 class='text-warning text-shadow' id='duplicateEmails'>0</h2>
                                                                    <h6 class="bold text-warning">Duplicate Emails</h6>
                                                                </div>
                                                            </div>
                                                        </center>
                                                        <div id='SendingArea'>
                                                            <img src="https://media.geeksforgeeks.org/wp-content/uploads/20210722235713/hb.gif" class='img-fluid w-25'>
                                                            <a href="#" class='btn btn-md btn-success blink-data'><i class="fa fa-refresh fa-spin"></i> Sending...</a>
                                                        </div>
                                                        <div id="SentArea" class="hidden mb-2 mt-3">
                                                            <hr class="mb-4">
                                                            <a href="<?php echo APP_URL; ?>/emails/" class='btn btn-md btn-success'><i class='fa fa-angle-left'></i> Back to Email Dashboard</a>
                                                            <a href="<?php echo APP_URL; ?>/emails/" class='btn btn-md btn-default'><i class='fa fa-check text-danger blink-data'></i> EMAIL PROCCESSING DONE!!!</a>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 text-center mt-4">
                                                        <center>
                                                            <div class="flex-s-b w-100 shadow-sm p-3 ">
                                                                <div class="w-50">
                                                                    <h6 class='text-secondary'>SENDER EMAIL-ID</h6>
                                                                    <p class="bold">
                                                                        <i class='fa fa-envelope-o text-danger'></i> <?php echo FETCH($EMAIL_SQL, "config_mail_sent_from"); ?>
                                                                    </p>
                                                                </div>
                                                                <div class="w-50">
                                                                    <h6 class='text-secondary'>SELECTED TEMPLATE</h6>
                                                                    <p class="bold">
                                                                        <i class='fa fa-file text-success'></i> <?php echo FETCH($TEMPLATE_SQL, "config_mail_template_ref_no"); ?>
                                                                    </p>
                                                                </div>
                                                                <div class="w-50">
                                                                    <h6 class='text-secondary'>SENDING TO </h6>
                                                                    <p class="bold">
                                                                        <i class='fa fa-users text-info blink-data'></i> <?php echo UpperCase($SENDING_MODULE); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <script>
            function sendDynamicEmail() {

                console.log("Request Sent!");

                $.ajax({
                    url: '<?php echo APP_URL; ?>/emails/compose/sending/sender.php',
                    method: 'POST',
                    data: {
                        // Specify the data to be sent in the request
                        SendDynamicEmailForSelectedTemplate: 'true',

                    },
                    success: function(response) {
                        var responseData = JSON.parse(response);

                        document.getElementById("TotalEmailsUnique").innerHTML = responseData.totalEmails;
                        document.getElementById("sendingCount").innerHTML = responseData.sendingCount;
                        document.getElementById("FailedEmails").innerHTML = responseData.failedEmails;
                        document.getElementById("duplicateEmails").innerHTML = responseData.duplicateEmails;
                        document.getElementById("IfUploaded").innerHTML = "<i class='fa fa-check text-success'></i> All Emails are processed successfully and sent to provided email-ids."
                        document.getElementById("DontRefreshMsg").style.display = "block";

                        // Show response
                        document.getElementById("SendingArea").style.display = "none";
                        document.getElementById("SentArea").style.display = "block";
                        document.getElementById("ProcessingImage").style.display = "none";
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error("AJAX request failed:", status, error);
                        // Optionally, display an error message to the user
                        alert("Failed to send dynamic email. Please try again later.");
                    }
                });
            }

            sendDynamicEmail();
        </script>
        <?php
        include $Dir . "/include/forms/Add-New-Sender-Email-Ids.php";
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>