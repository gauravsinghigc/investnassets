<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Staff In/Out Time";
$PageDescription = "Manage teams";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo $PageName; ?> |
        <?php echo APP_NAME; ?>
    </title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include $Dir . "/assets/HeaderFiles.php"; ?>
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
                                        <div class="col-md-10">
                                            <h4 class="mb-0 app-heading">
                                                <?php echo $PageName; ?>
                                            </h4>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" onclick="Databar('AddStaff-In-OutPopUp')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add
                                                Staff Out details</a>
                                        </div>

                                        <!-- Navbar staff-in-out-start -->
                                        <div class="col-md-3">
                                            <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                                                <h4 class="text-light fs-30 mt-2">
                                                    <?php echo TOTAL("SELECT * FROM user_in_out"); ?>
                                                </h4>
                                                <h5 class="mb-2 fs-15">Total StaffInOut Entry</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                                                <h4 class="text-light fs-30 mt-2">
                                                    <?php echo TOTAL("SELECT user_in_out_created_at FROM user_in_out WHERE DATE(user_in_out_created_at)='" . DATE('Y-m-d') . "'"); ?>
                                                </h4>
                                                <h5 class="mb-2 fs-15">Today StaffInOut Entry</h5>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                                                <h4 class="fs-30 mt-2">
                                                    <?php echo TOTAL("SELECT user_in_out_status FROM user_in_out WHERE user_in_out_status = '0' "); ?>
                                                </h4>
                                                <h5 class="mb-2 fs-15">Running StaffOut Entry</h5>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card-body  text-light top-card text-start" style="border-radius:5px; background-color: red;">
                                                <h4 class="text-light fs-30 mt-2">
                                                    <?php echo TOTAL("SELECT user_in_out_status FROM user_in_out WHERE user_in_out_status = '1' "); ?> </h4>
                                                <h5 class="mb-2 fs-15">Completed</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Navbar staff-in-out-end -->



                                    <!--  form start staff-in-out -->
                                    <div class='row'>
                                        <div class="col-md-12">
                                            <form action="" class="row" method="get">
                                                <div class='col-md-2'>
                                                    <div class="form-group">
                                                        <select onchange="form.submit()" name="user_main_id" required="" placeholder="" class="form-control">
                                                            <option value="">All Users</option>
                                                            <?php $Allusers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
                                                            if ($Allusers != null) {
                                                                foreach ($Allusers  as $U) {
                                                                    if (isset($_GET['user_main_id'])) {
                                                                        if ($_GET['user_main_id'] == $U->UserId) {
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    echo "<option value='" . $U->UserId . "' $selected>" . $U->UserFullName . " @ " . $U->UserPhoneNumber . "</option>";
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='col-md-1'>
                                                    <label for="" class="m-3">From date:</label>
                                                </div>
                                                <div class='col-md-2'>
                                                    <input onchange="form.submit()" type="date" name='FromDate' value='<?php echo IfRequested("GET", "FromDate", date('Y-m-d', strtotime("-1 month")), false); ?>' placeholder="" class="form-control  m-1">
                                                </div>
                                                <div class='col-md-1'>
                                                    <label for="" class="m-3">To date:</label>
                                                </div>
                                                <div class='col-md-2'>
                                                    <input onchange="form.submit()" type="date" name='ToDATE' value='<?php echo IfRequested("GET", "ToDATE", date('Y-m-d'), false); ?>' placeholder="" class="form-control  m-1">
                                                </div>
                                                <div class="col-md-2">
                                                    <select onchange="form.submit()" name="user_in_out_status" class="form-control" required="user_main_id" placeholder="Status">
                                                        <?php
                                                        echo InputOptionsWithKey([
                                                            "0" => "Pending",
                                                            "1" => "Completed",
                                                            "" => "All Type Status"
                                                        ], IfRequested("GET", "user_in_out_status", "", false));
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <div class="">
                                                        <?php if (isset($_GET['FromDate'])) {
                                                            $From = $_GET['FromDate'];
                                                            $To = $_GET['ToDATE']; ?>
                                                            <a target="_blank" href="export.php?fromdate=<?php echo $From; ?>&todate=<?php echo $To; ?>" class="btn btn-block btn-md btn-default"><i class="fa fa-file-pdf-o"></i> Export All</a>
                                                        <?php } else { ?>
                                                            <a target="_blank" href="export.php" class="btn btn-md btn-default btn-block"><i class="fa fa-file-pdf"></i> Export All</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- form end staff-in-out  -->


                                    <div class='row'>
                                        <?php if (isset($_GET['user_in_out_status'])) {
                                            $From = $_GET['FromDate'];
                                            $To = $_GET['ToDATE']; ?>
                                            <div class=" col-md-12 mb-3">
                                                <p class="p-1 mb-2">
                                                    <i class="fa fa-filter text-danger"></i>
                                                    Staff In-Out <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['FromDate']); ?></span>
                                                    <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['ToDATE']); ?></span>
                                                    <a href="index.php" class="text-danger pull-right float-right" style='float:right !important;'><i class="fa fa-times"></i> Clear Filter</a>
                                                </p>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <p class='data-list p-2 flex-s-b bg-primary text-white' style='background-color:black !important;'>
                                                <span class='w-pr-5'>Sno</span>
                                                <span class='w-pr-15'>PersonName</span>
                                                <span class='w-pr-12'>Date</span>
                                                <span class='w-pr-10'>OUT-Time</span>
                                                <span class='w-pr-10'>In-Time</span>
                                                <span class='w-pr-10'>Report By </span>
                                                <span class='w-pr-10'>Status</span>
                                                <span class='w-pr-10 text-right'>
                                                    ACTION
                                                </span>
                                            </p>
                                        </div>

                                        <?php
                                        // filter start here: 
                                        $start = START_FROM;
                                        $viewlimit = DEFAULT_RECORD_LISTING;

                                        if (isset($_GET['user_main_id'])) {
                                            $user_main_id = $_GET['user_main_id'];
                                            $user_in_out_status = $_GET['user_in_out_status'];
                                            $FromDate = $_GET['FromDate'];
                                            $ToDATE = $_GET['ToDATE'];
                                            if ($user_main_id == null) {
                                                $UserCheckQuery = "";
                                            } else {
                                                $UserCheckQuery = "user_main_id='$user_main_id' and";
                                            }
                                            $StaffInOut = _DB_COMMAND_("SELECT * FROM user_in_out where $UserCheckQuery user_in_out_status like '%$user_in_out_status%' and DATE(user_in_out_date)>='$FromDate' and DATE(user_in_out_date)<='$ToDATE' ORDER BY user_in_out_id DESC", true);
                                        } else {
                                            $StaffInOut = _DB_COMMAND_("SELECT * FROM user_in_out ORDER BY user_in_out_id DESC", true);
                                        }

                                        // filter end here
                                        if ($StaffInOut == null) {
                                            echo "No data found for user";
                                        } else {
                                            $serial = 0;
                                            foreach ($StaffInOut as $data) {
                                                $serial++;
                                        ?>
                                                <div class="col-md-12">
                                                    <p class='data-list w-100 p-2 flex-s-b'>
                                                        <span class='w-pr-5'>
                                                            <?php echo $serial; ?>
                                                        </span>
                                                        <span class='w-pr-15'>
                                                            <?php
                                                            echo UserDetails($data->user_main_id);
                                                            ?>
                                                        </span>

                                                        <span class='w-pr-12'>
                                                            <?php echo DATE_FORMATES("d M, Y", $data->user_in_out_date); ?>
                                                        </span>
                                                        <span class='w-pr-10'>
                                                            <?php echo $data->user_out_time ?>
                                                        </span>
                                                        <span class='w-pr-10'>
                                                            <?php echo $data->user_in_time; ?>
                                                        </span>
                                                        <span class='w-pr-10'>Report By </span>
                                                        <span class='w-pr-10'>
                                                            <?php echo StaffInoutstatus($data->user_in_out_status); ?>
                                                        </span>
                                                        <span class='w-pr-10 text-right'>
                                                            <button class="bg bg-warning" style="border-radius: 5px; padding: 3px; "><a href="#" onclick="Databar('AddStaff-In-OutPopUp_<?php echo $data->user_in_out_id; ?>')" style="font-size: 12px;">Update</a> </button>
                                                        </span>
                                                    </p>
                                                </div>
                                        <?php
                                                include '../../include/forms/Update_Staff_In_Out_TimePopWindow.php';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include $Dir . "/include/app/Footer.php"; ?>
    </div>


    <?php
    include $Dir . "/include/forms/Staff_In_Out_TimePopWindow.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>