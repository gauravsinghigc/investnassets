<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "EMAIL TEMPLATES";
$PageDescription = "Manage all customers";

$PAGE_LEVEL_SQL = "SELECT * FROM config_mail_templates ORDER BY config_mail_template_id DESC";
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
                                            <h4 class="app-heading"><i class="fa fa-gears"></i> <?php echo $PageName; ?></h4>
                                        </div>
                                        <div class="col-md-12 text-danger">
                                            <a href="<?php echo APP_URL; ?>/emails/templates/new" class="btn btn-sm btn-danger"><i class="fa fa-file"></i> NEW EMAIL TEMPLATE</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="data-list bg-dark flex-s-b">
                                                <div class="w-pr-5">Sno</div>
                                                <div class="w-pr-25">TemplateName</div>
                                                <div class="w-pr-25">TemplateRefName</div>
                                                <div class="w-pr-25">Subject</div>
                                                <div class="w-pr-15">VariableType</div>
                                                <div class="w-pr-10">CreatedAt</div>
                                                <div class="w-pr-5">Status</div>
                                            </div>
                                            <?php
                                            $START = START_FROM;
                                            $LIST_LIMIT = DEFAULT_RECORD_LISTING;

                                            $AllEmailTemplates = _DB_COMMAND_($PAGE_LEVEL_SQL . " limit $START, $LIST_LIMIT", true);
                                            if ($AllEmailTemplates != NULL) {
                                                $SerialNo = SERIAL_NO;
                                                foreach ($AllEmailTemplates as $EmailTemplate) {
                                                    $SerialNo++;
                                            ?>
                                                    <div class="data-list flex-s-b">
                                                        <div class="w-pr-5"><?php echo $SerialNo; ?></div>
                                                        <div class="w-pr-25">
                                                            <a href="update/?id=<?php echo SECURE($EmailTemplate->config_mail_template_id, "e"); ?>" class="bold text-underline text-info">
                                                                <?php echo LimitText($EmailTemplate->config_mail_template_name, 0, 35); ?>
                                                            </a>
                                                        </div>
                                                        <div class="w-pr-25"><?php echo LimitText($EmailTemplate->config_mail_template_ref_no, 0, 35); ?></div>
                                                        <div class="w-pr-25"><?php echo LimitText($EmailTemplate->config_mail_template_subject, 0, 35); ?></div>
                                                        <div class="w-pr-15"><?php echo LimitText($EmailTemplate->config_email_template_type, 0, 35); ?></div>
                                                        <div class="w-pr-10"><?php echo DATE_FORMATES("d M, Y", $EmailTemplate->config_mail_template_created_at); ?></div>
                                                        <div class="w-pr-5"><?php echo StatusViewWithText($EmailTemplate->config_mail_template_status); ?></div>
                                                    </div>
                                            <?php
                                                }
                                            } else {
                                                echo NoData("No Email template found! Please create one!");
                                            }
                                            echo PaginationFooter(TOTAL($PAGE_LEVEL_SQL), "index.php"); ?>
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