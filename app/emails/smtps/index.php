<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "SMTPs or SENDER MAIL-ids";
$PageDescription = "Manage all customers";

//Page level SQL
$PAGE_LEVEL_SQL = "SELECT * FROM config_mail_sender ORDER BY config_mail_sender_id DESC";

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
                                            <h4 class="app-heading mb-0"><i class="fa fa-gears"></i> <?php echo $PageName; ?></h4>
                                        </div>
                                        <div class="col-md-12 pt-2">
                                            <?php include "../sections/instant-action-bar.php"; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 d-block mx-auto">
                                            <div class="shadow-sm p-2">
                                                <h4 class="app-sub-heading">Send a test mail </h4>
                                                <div class="p-1">
                                                    <form id='TestSMTPForm' class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                                                        <?php echo FormPrimaryInputs(true); ?>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-12 pb-1">
                                                                    <label>Select Sender Email-id</label>
                                                                    <select name="TEST_MAIL_SENDER_ID" class="form-control form-control-sm" required>
                                                                        <?php
                                                                        if (_DB_COMMAND_($PAGE_LEVEL_SQL, true) != null) {
                                                                            foreach (_DB_COMMAND_($PAGE_LEVEL_SQL, true) as $Sender) {
                                                                                echo "<option value='" . $Sender->config_mail_sender_id . "'>" . $Sender->config_mail_sender_username . " @ " . $Sender->config_mail_sender_host . " - (Max: " . $Sender->config_mail_send_limit . ")</option>";
                                                                            }
                                                                        } else {
                                                                            echo "<option value='0'>No Sender Email-ids</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12 pb-1">
                                                                    <label>Subject</label>
                                                                    <input type="text" name="TEST_MAIL_SUBJECT" placeholder="Subject: " class="form-control form-control-sm" required>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label>Sent to (define multiple email separated by commas)</label>
                                                                    <textarea name="TEST_MAIL_TO" rows='4' placeholder="email1@gmail.com, email2@gmail.com, email3@gmail.com" class="form-control form-control-sm" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-12 pt-3">
                                                                    <label>Message</label>
                                                                    <textarea name="TEST_MAIL_MESSAGE" placeholder="Message: " class="form-control form-control-sm editor"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-12 pt-3">
                                                            <button type="submit" id='SendButton' onclick="ButtonAnimation('SendButton', 'Sending test mail...', 'TestSMTPForm')" name='SEND_TEST_EMAIL' class="btn btn-md btn-block fs-25 btn-primary"><i class='fa fa-send'></i> Send Test Mail</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <h4 class='app-sub-heading'>ALL Sender Mail-Ids</h4>
                                            <div class='data-list flex-s-b bg-dark'>
                                                <div class='w-pr-5'>Sno</div>
                                                <div class='w-pr-25'>SENDER-EMAIL</div>
                                                <div class='w-pr-20'>HOST</div>
                                                <div class='w-pr-25'>UserName</div>
                                                <div class='w-pr-20'>Password</div>
                                                <div class='w-pr-10'>Limit/24hr</div>
                                            </div>
                                            <?php
                                            $start = START_FROM;
                                            $end = DEFAULT_RECORD_LISTING;
                                            $AllSenderEmails = _DB_COMMAND_($PAGE_LEVEL_SQL . " limit $start, $end", true);
                                            if ($AllSenderEmails != null) {
                                                $SerialNo = SERIAL_NO;
                                                foreach ($AllSenderEmails as $SenderEmails) {
                                                    $SerialNo++;

                                                    if ($SenderEmails->config_mail_sender_id == 1) {
                                                        $Primary = "<i class='fa fa-star fa-spin text-warning'></i>";
                                                    } else {
                                                        $Primary = "";
                                                    }
                                            ?>
                                                    <div class='data-list flex-s-b small'>
                                                        <div class='w-pr-5'><?php echo $SerialNo; ?></div>
                                                        <div class='w-pr-25'>
                                                            <a onclick="Databar('Update_Sender_Email_Id_<?php echo $SenderEmails->config_mail_sender_id; ?>')" class='text-info bold text-underline'>
                                                                <?php echo $Primary; ?> <?php echo $SenderEmails->config_mail_sender_username; ?>
                                                            </a>
                                                        </div>
                                                        <div class='w-pr-20'><?php echo $SenderEmails->config_mail_sender_host; ?></div>
                                                        <div class='w-pr-25'><?php echo $SenderEmails->config_mail_sender_username; ?></div>
                                                        <div class='w-pr-20 code'><code class="bold"><?php echo $SenderEmails->config_mail_sender_password; ?></code></div>
                                                        <div class='w-pr-10'><?php echo $SenderEmails->config_mail_send_limit; ?>
                                                            <small class='text-secondary fs-10'>/24hr</small>
                                                        </div>
                                                    </div>
                                            <?php
                                                    include $Dir . "/include/forms/Update-Sender-Email-ids.php";
                                                }
                                                echo "<p class='text-center p-2 shadow-sm'><i class='fa fa-star fa-spin text-warning'></i> is primary sender email-id and you can't delete!</p>";
                                                PaginationFooter(TOTAL($PAGE_LEVEL_SQL), "index.php");
                                            } else {
                                                echo NoData("NO Sender emails are available! Please create a new one");
                                            } ?>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
        include $Dir . "/include/forms/Add-New-Sender-Email-Ids.php";
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>