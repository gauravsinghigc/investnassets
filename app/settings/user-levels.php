<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "User Hierarchy Structure";
$PageDescription = "Manage System Profile, address, logo";
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
            document.getElementById("config_levels").classList.add("active");
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="shadow-sm p-2 b-r-1">
                                                <h4 class="app-heading">System Settings</h4>
                                                <?php include "common.php"; ?>
                                            </div>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="shadow-sm p-2 b-r-1">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h4 class="app-heading"><?php echo $PageName; ?></h4>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="#" onclick="Databar('AddUserLevels')" class='btn btn-sm btn-block btn-danger'><i class="fa fa-plus"></i> Add Levels</a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="data-list flex-s-b bg-dark">
                                                            <div class="w-pr-5">Sno</div>
                                                            <div class="w-pr-10">LevelName</div>
                                                            <div class="w-pr-15">YearlyTarget</div>
                                                            <div class="w-pr-15">QuartlyTarget</div>
                                                            <div class="w-pr-18">CreatedBy</div>
                                                            <div class="w-pr-10">LastUpdate</div>
                                                            <div class="w-pr-10">Status</div>
                                                            <div class="w-pr-10">Users</div>
                                                            <div class="w-pr-5 text-right">Action</div>
                                                        </div>

                                                        <?php
                                                        $AllUserLevels = _DB_COMMAND_("SELECT * FROM config_user_levels ORDER BY config_user_level_order_by DESC", true);
                                                        if ($AllUserLevels != null) {
                                                            $SerialNo = SERIAL_NO;
                                                            foreach ($AllUserLevels as $UserLevels) {
                                                                $SerialNo++;
                                                        ?>
                                                                <div class="data-list flex-s-b">
                                                                    <div class="w-pr-5"><?php echo $SerialNo; ?></div>
                                                                    <div class="w-pr-10" onclick="Databar('EditUserLevels_<?php echo $UserLevels->config_user_level_id; ?>')"><b><?php echo $UserLevels->config_user_level_name; ?></b> (<?php echo $UserLevels->config_user_level_short_name; ?>)</div>
                                                                    <div class="w-pr-15"><?php echo Price($UserLevels->config_user_level_yearly_target, "text-success", "Rs."); ?></div>
                                                                    <div class="w-pr-15"><?php echo Price(round($UserLevels->config_user_level_yearly_target / 3, 2), "text-success", "Rs."); ?></div>
                                                                    <div class="w-pr-18"><?php echo UserCreatedBy($UserLevels->config_user_level_created_by); ?></div>
                                                                    <div class="w-pr-10"><?php echo DATE_FORMATES("d M, Y", $UserLevels->user_user_level_updated_at); ?></div>
                                                                    <div class="w-pr-10"><?php echo StatusViewWithText($UserLevels->config_user_level_status); ?></div>
                                                                    <div class="w-pr-10">10 users</div>
                                                                    <div class="w-pr-5">
                                                                        <a href="#" onclick="Databar('EditUserLevels_<?php echo $UserLevels->config_user_level_id; ?>')" class='btn btn-xs btn-warning'><i class="fa fa-edit"></i></a>
                                                                    </div>
                                                                </div>
                                                        <?php
                                                                include $Dir . "/include/forms/Update-User-levels.php";
                                                            }
                                                        } else {
                                                            NoData("No user level found!");
                                                        } ?>
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

        <?php
        include $Dir . "/include/forms/Add-New-User-Levels.php";
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>