<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
include $Dir . "/app/emails/compose/sections/Header-request.php";


//pagevariables
$PageName = "SEND NEW EMAIL";
$PageDescription = "Manage all customers";

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
                                            <h4 class="app-heading"><i class="fa fa-send"></i> <?php echo $PageName; ?></h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">
                                            <form class="shadow-sm p-1 rounded-1" action="" method="GET">
                                                <div class="form-group pb-1">
                                                    <h6 class="app-sub-heading">Select Email template & Sender Email-Id</h6>
                                                    <label>Select Email Template</label>
                                                    <select onchange="form.submit()" class="form-control" required name='SELECTED_EMAIL_TEMPLATE_ID'>
                                                        <option value="0">Select Email Template</option>
                                                        <?php
                                                        $AllEmailTemplates = _DB_COMMAND_("SELECT config_mail_template_id, config_mail_template_ref_no FROM config_mail_templates ORDER BY config_mail_template_name ASC", true);
                                                        if ($AllEmailTemplates != null) {
                                                            foreach ($AllEmailTemplates as $EmailTemplate) {
                                                                if ($EmailTemplate->config_mail_template_id == IfRequested("GET", "SELECTED_EMAIL_TEMPLATE_ID", $SELECTED_EMAIL_TEMPLATE_ID, false)) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option value='" . $EmailTemplate->config_mail_template_id . "' $selected>" . $EmailTemplate->config_mail_template_ref_no . "</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='0'>No Email Templates Found</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group pb-1">
                                                    <label>Select Sender Email-id</label>
                                                    <select onchange="form.submit()" name="SELECTED_SENDER_EMAIL_ID" class="form-control form-control-sm" required>
                                                        <option value='0'>Select Sender Email-id</option>
                                                        <?php
                                                        $AllSenderEmails = "SELECT * FROM config_mail_sender ORDER BY config_mail_sender_id DESC";
                                                        $AllSenderEmails = _DB_COMMAND_($AllSenderEmails, true);
                                                        if ($AllSenderEmails != null) {
                                                            foreach ($AllSenderEmails as $Sender) {
                                                                if ($Sender->config_mail_sender_id == IfRequested("GET", "SELECTED_SENDER_EMAIL_ID", $SELECTED_SENDER_EMAIL_ID, false)) {
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                                echo "<option value='" . $Sender->config_mail_sender_id . "' $selected>" . $Sender->config_mail_sender_username . " @ " . $Sender->config_mail_sender_host . " - (Max: " . $Sender->config_mail_send_limit . ")</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='0'>No Sender Email-ids</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group pb-1 mt-3">
                                                    <h6 class="app-sub-heading">EMAIL TEMPLATE PREVIEW</h6>
                                                    <?php
                                                    if (isset($_SESSION['SELECTED_EMAIL_TEMPLATE_ID'])) {
                                                        $EmailTemplaTeSQL = "SELECT * FROM config_mail_templates where config_mail_template_id='$SELECTED_EMAIL_TEMPLATE_ID'";
                                                        $SenderEamilidSQL = "SELECT * FROM config_mail_sender where config_mail_sender_id='$SELECTED_SENDER_EMAIL_ID'";
                                                    ?>
                                                        <div class="shadow-sm border-primary p-2 rounded-1">
                                                            <h6 class="text-warning mb-0">Subject:</h6>
                                                            <p class="pb-4"><?php echo FETCH($EmailTemplaTeSQL, "config_mail_template_subject"); ?></p>

                                                            <h6 class="text-warning mb-0">Message:</h6>
                                                            <div class="shadow-sm mt-1 p-2 b-r-2 bg-light border-info border-width-2 mb-3">
                                                                <?php
                                                                $emailTemplateContent = FETCH($EmailTemplaTeSQL, "config_mail_template_content");
                                                                echo html_entity_decode($emailTemplateContent); ?>
                                                            </div>
                                                            <a href="<?php echo APP_URL; ?>/emails/templates/update/?id=<?php echo SECURE($SELECTED_EMAIL_TEMPLATE_ID, "e"); ?>&access_url=<?php echo RUNNING_URL; ?>" class='btn btn-xs btn-primary'>
                                                                <i class='fa fa-edit'></i> Edit
                                                            </a>

                                                            <h6 class="text-warning mb-0 mt-3">Sender Email-ID</h6>
                                                            <p class="pb-4">
                                                                <?php
                                                                if ($SELECTED_SENDER_EMAIL_ID != 0) {
                                                                    echo FETCH($SenderEamilidSQL, "config_mail_sender_username"); ?>
                                                                    @ <?php echo FETCH($SenderEamilidSQL, "config_mail_sender_host"); ?><br>
                                                                    <span>SEND LIMIT : <?php echo FETCH($SenderEamilidSQL, "config_mail_send_limit"); ?> emails/24hr</span>
                                                                <?php } else {
                                                                    echo "No Sender Email-id is selected!";
                                                                } ?>
                                                            </p>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        echo NoData("No Email-Template is selected! Please any one template...");
                                                    } ?>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="shadow-sm p-2">
                                                <h5 class="app-sub-heading">Sent to</h5>
                                                <form class="">
                                                    <div class="form-group pb-1">
                                                        <label>Select Records/Data source</label>
                                                        <select onchange="form.submit()" name='EMAIL_CONTAINING_MODULES' class="form-control">
                                                            <?php echo InputOptionsWithKey([
                                                                "null" => "Choose one module",
                                                                "users" => "Users Module",
                                                                "customers" => "Customers Module",
                                                                "upload" => "Upload records/data via CSV"
                                                            ], IfRequested("GET", "EMAIL_CONTAINING_MODULES", $EMAIL_CONTAINING_MODULES, false)); ?>
                                                        </select>
                                                    </div>
                                                    <?php if ($EMAIL_CONTAINING_MODULES == "customers") { ?>
                                                        <div class="row">
                                                            <div class='form-group col-md-6 pb-1'>
                                                                <label>Project Relation</label>
                                                                <select class="form-control" onchange="form.submit()" name="HAVE_PROJECT_ID" required="">
                                                                    <option value="0">Select Project</option>
                                                                    <?php
                                                                    $Alldata = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName ASC", true);
                                                                    if ($Alldata != null) {
                                                                        foreach ($Alldata as $data) {
                                                                            if ($data->ProjectsId == $HAVE_PROJECT_ID) {
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            } ?>
                                                                            <option value="<?php echo $data->ProjectsId; ?>" <?php echo $selected; ?>>
                                                                                <?php echo $data->ProjectName; ?>
                                                                            </option>
                                                                    <?php }
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class='form-group col-md-6 pb-1'>
                                                                <label>Send Email For</label>
                                                                <select class="form-control" onchange="form.submit()" name="CUSTOMER_ENTRY_TYPE" required="">
                                                                    <?php echo InputOptionsWithKey([
                                                                        "registrations" => "Booking Customers",
                                                                        "bookings" => "Registration Customers"
                                                                    ], $CUSTOMER_ENTRY_TYPE); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Business Head</label>
                                                                <select name="BUSINESS_HEAD_ID" onchange="form.submit()" class="form-control form-control-sm" required="">
                                                                    <option value="">All Business Head</option>
                                                                    <option value="1">Assign Admin</option>
                                                                    <?php
                                                                    $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                                                                    if ($AllCustomers != null) {
                                                                        $Sno = 0;
                                                                        foreach ($AllCustomers as $Customers) {
                                                                            $Sno++;
                                                                            $UserMainUserId = $Customers->UserMainUserId;
                                                                            if ($BUSINESS_HEAD_ID == $UserMainUserId) {
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                    ?>
                                                                            <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                                                                                <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                                                                            </option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Team Head</label>
                                                                <select name="TEAM_HEAD_ID" onchange="form.submit()" class="form-control form-control-sm" required="">
                                                                    <option value="">All Team Head</option>
                                                                    <option value="1">Assign Admin</option>
                                                                    <?php
                                                                    $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                                                                    if ($AllCustomers != null) {
                                                                        $Sno = 0;
                                                                        foreach ($AllCustomers as $Customers) {
                                                                            $Sno++;
                                                                            $UserMainUserId = $Customers->UserMainUserId;
                                                                            if ($TEAM_HEAD_ID == $UserMainUserId) {
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                    ?>
                                                                            <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                                                                                <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                                                                            </option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Direct Sale</label>
                                                                <select name="DIRECT_SALE_ID" onchange="form.submit()" class="form-control form-control-sm" required="">
                                                                    <option value="">All Sale Person</option>
                                                                    <option value="1">Assign Admin</option>
                                                                    <?php
                                                                    $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                                                                    if ($AllCustomers1 != null) {
                                                                        $Sno = 0;
                                                                        foreach ($AllCustomers1 as $Customers1) {
                                                                            $Sno++;
                                                                            $UserMainUserId1 = $Customers1->UserMainUserId;
                                                                            if ($DIRECT_SALE_ID == $UserMainUserId1) {
                                                                                $selected1 = "selected";
                                                                            } else {
                                                                                $selected1 = "";
                                                                            }
                                                                    ?>
                                                                            <option value="<?php echo $UserMainUserId1; ?>" <?php echo $selected1; ?>>
                                                                                <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                                                                            </option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Record Status</label>
                                                                <select name="ENTRY_STATUS" onchange="form.submit()" class="form-control form-control-sm" required="">
                                                                    <?php echo InputOptionsWithKey([
                                                                        "" => "All Records",
                                                                        "active" => "Active",
                                                                        "refund" => "Refund",
                                                                        "cancel" => "Cancellation",
                                                                        "pending" => "Pending",
                                                                        "done" => "Done"
                                                                    ], IfRequested("GET", "ENTRY_STATUS", $ENTRY_STATUS, false)); ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Allotment Phase</label>
                                                                <input type='search' name='ALLOTMENT_PHASE' onchange="form.submit()" value='<?php echo IfRequested('GET', 'ALLOTMENT_PHASE', $ALLOTMENT_PHASE, false); ?>' class="form-control form-control-sm" list='RegAllotmentPhase' placeholder="Allotment Phase">
                                                                <?php echo SUGGEST("registrations", "RegAllotmentPhase", "ASC"); ?>
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Entry Date From</label>
                                                                <input type='date' name='RECORDS_DATE_FROM' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RECORDS_DATE_FROM', $RECORDS_DATE_FROM, false); ?>' class="form-control form-control-sm" list='RegistrationDate' placeholder="Allotment Phase">
                                                            </div>
                                                            <div class="col-md-6 form-group">
                                                                <label>Entry Date To</label>
                                                                <input type='date' name='RECORDS_DATE_TO' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RECORDS_DATE_TO', $RECORDS_DATE_TO, false); ?>' class="form-control form-control-sm" list='RegistrationDate' placeholder="Allotment Phase">
                                                            </div>
                                                        </div>

                                                    <?php } elseif ($EMAIL_CONTAINING_MODULES == "users") { ?>

                                                    <?php }
                                                    if ($EMAIL_CONTAINING_MODULES == "upload") {
                                                        $enctype = "enctype='multipart/form-data'";
                                                    } else {
                                                        $enctype = "";
                                                    } ?>
                                                </form>
                                                <form class="" method="POST" action='sending/' <?php echo $enctype; ?>>
                                                    <input type='hidden' name='EMAIL_ID' value='<?php echo $SELECTED_SENDER_EMAIL_ID; ?>'>
                                                    <input type='hidden' name='TEMPLATE_ID' value='<?php echo $SELECTED_EMAIL_TEMPLATE_ID; ?>'>
                                                    <input type='hidden' name='SENDING_MODULE' value='<?php echo $EMAIL_CONTAINING_MODULES; ?>'>
                                                    <?php if ($EMAIL_CONTAINING_MODULES == "customers") { ?>
                                                        <input type='hidden' name='HAVE_PROJECT_ID' value='<?php echo $HAVE_PROJECT_ID; ?>'>
                                                        <input type='hidden' name='CUSTOMER_ENTRY_TYPE' value='<?php echo $CUSTOMER_ENTRY_TYPE; ?>'>
                                                        <input type='hidden' name='BUSINESS_HEAD_ID' value='<?php echo $BUSINESS_HEAD_ID; ?>'>
                                                        <input type='hidden' name='TEAM_HEAD_ID' value='<?php echo $TEAM_HEAD_ID; ?>'>
                                                        <input type='hidden' name='DIRECT_SALE_ID' value='<?php echo $DIRECT_SALE_ID; ?>'>
                                                        <input type='hidden' name='ENTRY_STATUS' value='<?php echo $ENTRY_STATUS; ?>'>
                                                        <input type='hidden' name='ALLOTMENT_PHASE' value='<?php echo $ALLOTMENT_PHASE; ?>'>
                                                        <input type='hidden' name='RECORDS_DATE_FROM' value='<?php echo $RECORDS_DATE_FROM; ?>'>
                                                        <input type='hidden' name='RECORDS_DATE_TO' value='<?php echo $RECORDS_DATE_TO; ?>'>
                                                    <?php } elseif ($EMAIL_CONTAINING_MODULES == "users") { ?>

                                                    <?php } ?>

                                                    <div class="form-group pb-1">
                                                        <?php if ($EMAIL_CONTAINING_MODULES != null) { ?>
                                                            <?php
                                                            if ($EMAIL_CONTAINING_MODULES == "users") {
                                                                $UserSqls = "SELECT UserId, UserFullName, UserPhoneNumber, UserType, UserDateOfBirth, UserEmailId, UserCreatedAt FROM users where UserStatus='1' ORDER BY UserFullName ASC";
                                                                $AllUsersSQL = _DB_COMMAND_($UserSqls, true);
                                                                if ($AllUsersSQL != null) { ?>
                                                                    <div class="email-id-lists row height-limit">
                                                                        <div class="col-md-12">
                                                                            <h6 class="app-sub-heading">Email Ids Found!</h6>
                                                                            <input type='search' id='SearchInputTrigger' oninput="SearchData('SearchInputTrigger', 'RecordLists')" class="form-control" placeholder="Search special Email-Ids...">
                                                                        </div>
                                                                        <div class='col-md-6 mb-1 RecordLists'>
                                                                            <label class="d-block emails bg-light-grey border-danger p-1 w-100">
                                                                                <input onclick="CheckAll()" type='checkbox'>
                                                                                <div class="p-1 w-pr-100">
                                                                                    <h6 class="mb-0">All USERS (<?php echo TOTAL($UserSqls); ?>)</h6>
                                                                                    <p class='text-secondary font-italic font-weight-light'>ALL - ALL - ALL</p>
                                                                                    <p class="mt-0 pt-0">
                                                                                        <i class="fa fa-hashtag bold"></i>
                                                                                        ALL PHONE NUMBERS<br>
                                                                                        <i class="fa fa-at bold"></i>
                                                                                        ALL EMAIL-IDs<br>
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        ALL Dates<br>
                                                                                        <i class="fa fa-birthday-cake"></i>
                                                                                        All Birthdays
                                                                                    </p>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                        <?php foreach ($AllUsersSQL as $Users) { ?>
                                                                            <div class='col-md-6 RecordLists mb-1'>
                                                                                <label class="d-block emails p-1 w-100">
                                                                                    <input class='checks' type='checkbox' name='UserId[]' value='<?php echo $Users->UserId; ?>'>
                                                                                    <div class="p-1 w-pr-100">
                                                                                        <h6 class="mb-0"><?php echo $Users->UserFullName; ?></h6>
                                                                                        <p class='text-secondary font-italic font-weight-light'>
                                                                                            <?php echo $Users->UserType; ?> -
                                                                                            <?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $Users->UserId . "'"); ?> -
                                                                                            <?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $Users->UserId . "'"); ?> -
                                                                                            <?php echo UserLocation($Users->UserId, null); ?>
                                                                                        </p>
                                                                                        <p class="mt-0 pt-0">
                                                                                            <i class="fa fa-hashtag bold"></i>
                                                                                            <?php echo $Users->UserPhoneNumber; ?><br>
                                                                                            <i class="fa fa-at bold"></i>
                                                                                            <?php echo $Users->UserEmailId; ?><br>
                                                                                            <i class="fa fa-calendar"></i>
                                                                                            <?php echo DATE_FORMATES("d M, Y", $Users->UserCreatedAt); ?><br>
                                                                                            <i class="fa fa-birthday-cake"></i>
                                                                                            <?php echo DATE_FORMATES("d M, Y", $Users->UserDateOfBirth); ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php
                                                                } else {
                                                                    echo NoData("No Users found!");
                                                                }
                                                                ?>

                                                                <?php
                                                            } elseif ($EMAIL_CONTAINING_MODULES == "customers") {
                                                                if ($CUSTOMER_ENTRY_TYPE == "bookings") {
                                                                    $filteredRecords = FilterRecordParameters([
                                                                        "BookingTeamHeadId" => $TEAM_HEAD_ID,
                                                                        "BookingDirectSalePersonId" => $DIRECT_SALE_ID,
                                                                        "BookingBusinessHead" => $BUSINESS_HEAD_ID,
                                                                        "BookingStatus" => $ENTRY_STATUS,
                                                                        "BookingProjectPhase" => $ALLOTMENT_PHASE,
                                                                        "BookingForProject" => $HAVE_PROJECT_ID,
                                                                    ]);
                                                                    $CustomerSql = "SELECT * FROM customers, bookings where $filteredRecords DATE(BookingCreatedAt)<='$RECORDS_DATE_TO' and DATE(BookingCreatedAt)<='$RECORDS_DATE_FROM' and customers.CustomerId=bookings.BookingMainCustomerId and CustomerEmailId!='' ORDER BY CustomerName ASC";
                                                                } else if ($CUSTOMER_ENTRY_TYPE == "registrations") {
                                                                    $filteredRecords = FilterRecordParameters([
                                                                        "BookingTeamHeadId" => $TEAM_HEAD_ID,
                                                                        "BookingDirectSalePersonId" => $DIRECT_SALE_ID,
                                                                        "BookingBusinessHead" => $BUSINESS_HEAD_ID,
                                                                        "BookingStatus" => $ENTRY_STATUS,
                                                                        "BookingProjectPhase" => $ALLOTMENT_PHASE,
                                                                        "BookingForProject" => $HAVE_PROJECT_ID,
                                                                    ]);
                                                                    $CustomerSql = "SELECT * FROM customers, registrations where customers.CustomerId=registrations.RegMainCustomerId and CustomerEmailId!='' ORDER BY CustomerName ASC";
                                                                } else {
                                                                    $CustomerSql = "SELECT * FROM customers where CustomerEmailId!='' ORDER BY CustomerName ASC";
                                                                }
                                                                $AllCustomersSQL = _DB_COMMAND_($CustomerSql, true);
                                                                if ($AllCustomersSQL != null) { ?>
                                                                    <div class="email-id-lists  row height-limit">
                                                                        <div class="col-md-12">
                                                                            <h6 class="app-sub-heading">Records Found!</h6>
                                                                            <input type='search' id='SearchInputTrigger' oninput="SearchData('SearchInputTrigger', 'RecordLists')" class="form-control" placeholder="Search special Email-Ids...">
                                                                        </div>
                                                                        <div class='col-md-6 mb-1 RecordLists'>
                                                                            <label class="d-block emails bg-light-grey border-danger p-1 w-100">
                                                                                <input onclick="CheckAll()" type='checkbox'>
                                                                                <div class="p-1 w-pr-100">
                                                                                    <h6 class="mb-0">All CUSTOMERS (<?php echo TOTAL($CustomerSql); ?>)</h6>
                                                                                    <p class="mt-0 pt-0">
                                                                                        <i class="fa fa-user bold"></i>
                                                                                        ALL CUSTOMERS<br>
                                                                                        <i class="fa fa-hashtag bold"></i>
                                                                                        ALL PHONE NUMBERS<br>
                                                                                        <i class="fa fa-at bold"></i>
                                                                                        ALL EMAIL-IDs
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        ALL Dates<br>
                                                                                        <i class="fa fa-birthday-cake"></i>
                                                                                        ALL Birthdays
                                                                                    </p>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                        <?php foreach ($AllCustomersSQL as $Customers) { ?>
                                                                            <div class='col-md-6 RecordLists mb-1'>
                                                                                <label class="d-block emails p-1 w-100">
                                                                                    <input class='checks' type='checkbox' name='CustomerIds[]' value='<?php echo $Customers->CustomerId; ?>'>
                                                                                    <div class="p-1 w-pr-100">
                                                                                        <h6 class="mb-0"><?php echo $Customers->CustomerName; ?></h6>
                                                                                        <p class="mt-0 pt-0">
                                                                                            <i class="fa fa-user bold"></i>
                                                                                            <?php echo $Customers->CustomerRelationName; ?><br>
                                                                                            <i class="fa fa-hashtag bold"></i>
                                                                                            <?php echo $Customers->CustomerPhoneNumber; ?><br>
                                                                                            <i class="fa fa-at bold"></i>
                                                                                            <?php echo $Customers->CustomerEmailId; ?><br>
                                                                                            <i class="fa fa-calendar"></i>
                                                                                            <?php echo DATE_FORMATES("d M, Y", $Customers->CustomerCreatedAt); ?><br>
                                                                                            <i class="fa fa-birthday-cake"></i>
                                                                                            <?php echo DATE_FORMATES("d M, Y", $Customers->CustomerBirthdate); ?><br>
                                                                                        </p>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php } else {
                                                                    echo NoData("No Customer found!");
                                                                }
                                                            } elseif ($EMAIL_CONTAINING_MODULES == "upload") { ?>
                                                                <div class="w-100 shadow-sm p-1">
                                                                    <h6 class="app-sub-heading">Upload CSV file!</h6>
                                                                    <div class="form-group">
                                                                        <label>Upload Record file (csv only)</label>
                                                                        <input type="file" name="UPLOADED_CSV_FILE" required accept=".csv,text/csv" class="form-control">
                                                                    </div>
                                                                    <hr>
                                                                    <h6 class="text-danger mt-3 mb-1">Please read care fully before uploading records.</h6>
                                                                    <p>Make sure you have included below details;</p>
                                                                    <ul>
                                                                        <li>All Define variable mention in csv as header name</li>
                                                                        <li>You have to make one primary common column whose header name is <b>EMAILID</b>, where email list is provided by you.</li>
                                                                        <li>HeaderName must be uppercase and not contain any special character or space between two words.</li>
                                                                        <li>Varibale used in template are available in csv file</li>
                                                                        <li>number of variables in email template is equal to number of headers in csv file</li>
                                                                        <li>Uploaded csv must have below mention headers as column with approx 1 records as row.
                                                                            <ul>
                                                                                <?php
                                                                                preg_match_all('/\$\w+/', $emailTemplateContent, $matches);
                                                                                $ExtractAllVariables = array_unique($matches[0]);
                                                                                $StartCSVHeaders = 0;
                                                                                foreach ($ExtractAllVariables as $VariableName) {
                                                                                    $StartCSVHeaders++;
                                                                                    $VariableName = removeSpecialCharacter($VariableName, "$");
                                                                                    if ($StartCSVHeaders == 1) {
                                                                                        echo "<li>$StartCSVHeaders Column - <b>EMAILID</b></li>";
                                                                                        $StartCSVHeaders++;
                                                                                    }
                                                                                    echo "<li>$StartCSVHeaders Column - <b>$VariableName</b></li>";
                                                                                }
                                                                                ?>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            <?php
                                                            } else {
                                                                echo NoData("No email-ids found in selected module!");
                                                            } ?>

                                                            <div class="row">
                                                                <div class="col-md-12 text-right">
                                                                    <hr>
                                                                    <button type="submit" name='PROCESS_DYNAMIC_EMAILS' class="btn btn-sm btn-primary fs-20"><i class='fa fa-send'></i> Start Processing Emails</button>
                                                                </div>
                                                            </div>
                                                        <?php

                                                        } else {
                                                            echo NoData("Select Module containing email-ids!");
                                                        } ?>
                                                    </div>
                                                </form>
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
            function CheckAll() {
                const checkboxes = document.querySelectorAll('.checks');
                const anyUnchecked = Array.from(checkboxes).some(checkbox => !checkbox.checked);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = anyUnchecked;
                });
            }
        </script>
        <?php
        include $Dir . "/include/forms/Add-New-Sender-Email-Ids.php";
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>