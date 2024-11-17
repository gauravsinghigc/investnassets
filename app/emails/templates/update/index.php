<?php
$Dir = "../../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "UPDATE EMAIL TEMPLATES";
$PageDescription = "Manage all customers";

if (isset($_GET['id'])) {
    $config_mail_template_id = SECURE($_GET['id'], "d");
    $_SESSION['CONFIG_MAIL_TEMPLATE_ID'] = $config_mail_template_id;
} else {
    $config_mail_template_id = $_SESSION['CONFIG_MAIL_TEMPLATE_ID'];
}

$PAGE_LEVEL_SQL = "SELECT * FROM config_mail_templates WHERE config_mail_template_id='$config_mail_template_id' LIMIT 1";
$CheckEntry = CHECK($PAGE_LEVEL_SQL);

if ($CheckEntry == null) {
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
        .tox.tox-tinymce {
            height: 25rem !important;
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
                                            <h4 class="app-heading mb-0"><i class="fa fa-gears"></i> <?php echo $PageName; ?></h4>
                                        </div>
                                    </div>

                                    <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="app-sub-heading">UPDATE EMAIL TEMPLATE</h5>
                                                <?php echo FormPrimaryInputs(IfRequested("GET", "access_url", true, false), [
                                                    "config_mail_template_id" => $config_mail_template_id
                                                ]); ?>
                                                <div class="flex-s-b">
                                                    <div class="form-group pb-1 w-75 mr-1">
                                                        <label for="config_mail_template_name">Template Name</label>
                                                        <input type="text" value='<?php echo FETCH($PAGE_LEVEL_SQL, "config_mail_template_name"); ?>' name="config_mail_template_name" class="form-control" required="">
                                                    </div>
                                                    <div class="form-group pb-1 w-50 ml-1">
                                                        <label for="config_mail_template_name">Template Variable Type</label>
                                                        <select onchange='ShowVariableOptions()' id='VariableType' name='config_email_template_type' class='form-control' required=''>
                                                            <?php echo InputOptionsWithKey([
                                                                "NULL" => "Select Variable Type",
                                                                "MODULE_VARIABLES" => "Linked with system variables",
                                                                "CUSTOM_VARIABLES" => "Linked with custom variables"
                                                            ], FETCH($PAGE_LEVEL_SQL, "config_email_template_type")); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p class="text-secondary pb-2">You can also use system variable for including dynamic values via variables of other modules. you can search and copy variables, if need again so simply re-click on selected/copied variable, it will re-copied!</p>
                                                <div class="form-group pb-1">
                                                    <label for="config_mail_template_name">Mail Subject</label>
                                                    <input type="text" name="config_mail_template_subject" value='<?php echo FETCH($PAGE_LEVEL_SQL, "config_mail_template_subject"); ?>' class="form-control" required="">
                                                </div>
                                                <div class="form-group pb-1">
                                                    <label for="config_mail_template_name">Create Template</label>
                                                    <textarea placeholder="Start Typing here" name="config_mail_template_content" class="form-control editor"><?php echo html_entity_decode(FETCH($PAGE_LEVEL_SQL, "config_mail_template_content")); ?></textarea>
                                                </div>
                                                <div class="form-group pb-1">
                                                    <h6 class="app-sub-heading">Uploaded Attachments</h6>
                                                    <div>
                                                        <?php
                                                        $AllAttachements = _DB_COMMAND_("SELECT * FROM config_mail_template_attachements where config_mail_template_main_id='$config_mail_template_id'", true);
                                                        if ($AllAttachements != null) {
                                                            foreach ($AllAttachements as $Attachement) {
                                                        ?>
                                                                <div class="shadow-sm p-1 mb-1 flex-s-b">
                                                                    <a href="<?php echo STORAGE_URL; ?>/email_attachments/<?php echo $Attachement->config_mail_template_documents; ?>" target="_blank" class="btn btn-xs">
                                                                        <h6 class="mb-0 text-info"><i class='fa fa-file text-danger'></i> <?php echo $Attachement->config_mail_template_documents; ?></h6>
                                                                    </a>
                                                                    <div class="w-50 text-right">
                                                                        <a href="<?php echo STORAGE_URL; ?>/email_attachments/<?php echo $Attachement->config_mail_template_documents; ?>" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-eye"></i> View </a>
                                                                        <?php echo CONFIRM_DELETE_POPUP(
                                                                            "RemoveAttachments",
                                                                            [
                                                                                "Remove_Email_Template_Attachements" => true,
                                                                                "config_mail_template_attachment_id" => $Attachement->config_mail_template_attachment_id
                                                                            ],
                                                                            null,
                                                                            "<i class='fa fa-trash'></i> Remove",
                                                                            "btn btn-xs btn-default text-danger"
                                                                        ); ?>
                                                                    </div>
                                                                </div>
                                                        <?php
                                                            }
                                                        } else {
                                                            echo "<h6>No Attachement found!</h6>";
                                                        }
                                                        if (isset($_GET['access_url'])) {
                                                            $checked = "checked";
                                                        } else {
                                                            $checked = "";
                                                        } ?>
                                                    </div>
                                                </div>

                                                <div class="form-group pb-2">
                                                    <hr>
                                                    <label class="w-100">Upload NEW Attachments <span class="text-info pull-right small"><?php echo $req; ?>(you can upload multiple files)</span></label>
                                                    <input type='FILE' class="form-control" multiple name='config_mail_template_documents[]'>
                                                </div>
                                                <div class='w-100 text-right'>
                                                    <div class="btn btn-md">
                                                        <div class="w-100 text-right">
                                                            <div class="flex-s-b">
                                                                <input type='checkbox' <?php echo $checked; ?> name='COMPOSE_OPTION' value='true'>
                                                                <span class="p-1">SEND NEW Email after save!</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group pb-1 text-right">
                                                    <?php echo CONFIRM_DELETE_POPUP(
                                                        "EmailTemplateList",
                                                        [
                                                            "Remove_Email_Templates" => true,
                                                            "config_mail_template_id" => $config_mail_template_id
                                                        ],
                                                        null,
                                                        "<i class='fa fa-trash'></i> Remove Template",
                                                        "btn btn-md text-danger pull-left"
                                                    );
                                                    ?>
                                                    <a href="../index.php" class="btn btn-md btn-default"><i class="fa fa-angle-left"></i> Back to All Templates</a>
                                                    <button type='submit' name='UPDATE_NEW_EMAIL_TEMPLATES' class='btn btn-md btn-primary'><i class="fa fa-check"></i> UPDATE TEMPLATE</button>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <?php if (FETCH($PAGE_LEVEL_SQL, "config_email_template_type") == "MODULE_VARIABLES") {
                                                    $ModuleShow = "";
                                                    $CustomVaribale = "hidden"; ?>
                                                <?php } else {
                                                    $ModuleShow = "hidden";
                                                    $CustomVaribale = "";
                                                } ?>
                                                <div id='SystemVariables' class="<?php echo $ModuleShow; ?>">
                                                    <h5 class="app-sub-heading">AVAILABLE SYSTEM VARIABLES</h5>
                                                    <?php include $Dir . "/app/emails/sections/require-variable-options.php"; ?>
                                                </div>
                                                <div id='CustomVariables' class="<?php echo $CustomVaribale; ?>">
                                                    <h5 class="app-sub-heading">AVAILABLE CUSTOM VARIABLES</h5>
                                                    <div class="shadow-sm p-1">
                                                        <h5 class="mb-0">Add CSV's All Headers</h5>
                                                        <p class="text-secondary">Here you can add all header name of CSV file that contain records and we have to send a email on that records. Headers name will pick the values dynamically in email-templates.</p>
                                                        <p class="shadow-sm p-2 rounded mt-2">
                                                            <span>Declare/Mention/use variables as :<br> <b>$HEADERNAME</b>, <b>$HEADERCOLUMNNAME</b></span><br>
                                                            <span class="text-info small">All characters must be in uppercase and started with dollar sign</span><br>
                                                            <span class="text-info small">For remove any variable simpley remove it from the template or make empty variable input box.</span><br>
                                                            <hr>
                                                            <span class='p-2 text-danger small'><i class='fa fa-info-circle'></i> Leave empty if confused or not understand, we will automatically pick mention variable from the templates.</span>
                                                        </p>
                                                        <hr>
                                                        <?php
                                                        $AllCSVHeaders = _DB_COMMAND_("SELECT * FROM config_email_template_headers where config_email_template_main_id='$config_mail_template_id'", true);
                                                        if ($AllCSVHeaders != null) {
                                                            foreach ($AllCSVHeaders as $Headers) {
                                                        ?>
                                                                <div class="form-group pb-1">
                                                                    <label>CSV Header Name (Without space)</label>
                                                                    <input type="text" name='config_email_template_header_name[]' oninput="addDollarSignup(this)" value='<?php echo $Headers->config_email_template_header_name; ?>' class="form-control dollar" placeholder="CSV/EXCEL Header Names without space">
                                                                </div>
                                                        <?php }
                                                        } ?>
                                                        <div id='MoreHeaders'>

                                                        </div>
                                                        <button type='button' onclick="AddMoreHeaders()" class='btn btn-default btn-xs text-danger'><i class='fa fa-plus'></i> Add More Headers</button>

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

        <script>
            function addDollarSignup(input) {
                function enforceDollarSign() {
                    if (!input.value.startsWith('$')) {
                        input.value = '$' + input.value;
                    }
                }

                function handleInput(event) {
                    const cursorPosition = input.selectionStart + input.value.length;
                    let sanitizedValue = input.value;

                    // Remove spaces from the input
                    sanitizedValue = sanitizedValue.replace(/\s/g, '');

                    // Ensure dollar sign at the beginning
                    if (sanitizedValue.length === 0 || sanitizedValue.charAt(0) !== '$') {
                        sanitizedValue = '$' + sanitizedValue;
                    }

                    // Remove special characters immediately following the dollar sign
                    sanitizedValue = sanitizedValue.replace(/^\$[^a-zA-Z0-9]+/, '$');

                    // Update the input value
                    input.value = sanitizedValue;

                    // Set cursor position back to where it was if it moved
                    if (cursorPosition > 1) {
                        input.setSelectionRange(cursorPosition, cursorPosition);
                    } else {
                        input.setSelectionRange(1, 1);
                    }
                }

                // Initialize the dollar sign on focus and input events
                input.addEventListener('focus', enforceDollarSign);
                input.addEventListener('input', handleInput);
            }




            function AddMoreHeaders() {
                // Create a new div to hold the new input field
                const newDiv = document.createElement('div');
                newDiv.classList.add('form-group', 'pb-1');

                // Create a new label for the new input field
                const newLabel = document.createElement('label');
                newLabel.textContent = 'CSV Header Name (Without space)';

                // Create the new input field
                const newInput = document.createElement('input');
                newInput.type = 'text';
                newInput.name = 'config_email_template_header_name[]';
                newInput.classList.add('form-control');
                newInput.classList.add('dollar');
                newInput.placeholder = 'CSV/EXCEL Header Names without space';
                newInput.addEventListener('input', function() {
                    addDollarSignup(newInput);
                });

                // Append the label and input to the new div
                newDiv.appendChild(newLabel);
                newDiv.appendChild(newInput);

                // Append the new div to the MoreHeaders div
                document.getElementById('MoreHeaders').appendChild(newDiv);
            }

            function ShowVariableOptions() {
                var VariableType = document.getElementById('VariableType').value;
                var SubmitBtn = document.getElementById('SubmitBtn');
                if (VariableType == "MODULE_VARIABLES") {
                    document.getElementById('SystemVariables').style.display = "block";
                    document.getElementById('CustomVariables').style.display = "none";
                    SubmitBtn.type = "submit";
                    SubmitBtn.disabled = false;
                } else if (VariableType == "CUSTOM_VARIABLES") {
                    document.getElementById('SystemVariables').style.display = "none";
                    document.getElementById('CustomVariables').style.display = "block";
                    SubmitBtn.type = "submit";
                    SubmitBtn.disabled = false;
                } else {
                    document.getElementById('SystemVariables').style.display = "none";
                    document.getElementById('CustomVariables').style.display = "block";
                    SubmitBtn.type = "button";
                    SubmitBtn.disabled = true;
                }
            }
        </script>
        <?php
        include $Dir . "/include/forms/Add-New-Sender-Email-Ids.php";
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>