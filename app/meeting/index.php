<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Meeting";
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
                                    <form action="" method="get">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h4 class="mb-0 app-heading">
                                                    <?php echo $PageName; ?>
                                                </h4>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" onclick="Databar('AddMeetingPopUp')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add
                                                    Meeting</a>
                                            </div>

                                            <!-- Navbar meeting-start -->
                                            <div class="col-md-3">
                                                <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT * FROM reception_meeting"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Total Meeting</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 card">
                                                <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-danger fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_meeting_created_at FROM reception_meeting WHERE DATE(reception_meeting_created_at)='" . DATE('Y-m-d') . "'"); ?>
                                                    </h4>
                                                    <h5 class="mb-2  fs-15">Today Meeting</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 card">
                                                <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-dark fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_meeting_status FROM reception_meeting WHERE reception_meeting_status = '0' "); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Running Meeting</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3 card">
                                                <div class="card-body  text-light top-card text-start" style="border-radius:5px; background-color: red;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_meeting_status FROM reception_meeting WHERE reception_meeting_status = '1' "); ?> </h4>
                                                    <h5 class="mb-2 fs-15">Completed</h5>
                                                </div>
                                            </div>

                                            <!-- form meeting start here -->
                                            <div class='col-md-3 mb-2 text-left'>
                                                <select name="reception_meeting_select_project" onchange="form.submit()" required="" placeholder="" class="form-control">
                                                    <option value="">All Projects</option>
                                                    <?php
                                                    $AllMeeting = _DB_COMMAND_("SELECT * FROM projects ", true);
                                                    if ($AllMeeting != null) {
                                                        foreach ($AllMeeting  as $M) {
                                                            echo "<option value='" . $M->ProjectsId   . "'>" . $M->ProjectTypeId . " " . $M->ProjectName . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="reception_meeting_associate_name" onchange="form.submit()" value='<?php echo IfRequested("GET", "reception_meeting_associate_name", "", false); ?>' placeholder="Associate name" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="reception_meeting_associate_mob_no" onchange="form.submit()" value='<?php echo IfRequested("GET", "reception_meeting_associate_mob_no", "", false); ?>' placeholder="Associate Mobile number" class="form-control" maxlength="12" minlength="10">
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="reception_meeting_customer_name" value='<?php echo IfRequested("GET", "reception_meeting_customer_name", "", false); ?>' onchange="form.submit()" placeholder="Customer name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="number" name="recption_meeting_customer_mobile" onchange="form.submit()" value='<?php echo IfRequested("GET", "recption_meeting_customer_mobile", "", false) ?>' placeholder="Customer mobile number" class="form-control" maxlength="12" minlength="10">
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="reception_meeting_city" value='<?php echo IfRequested("GET", "reception_meeting_city", "", false); ?>' onchange="form.submit()" placeholder="city" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <select name="reception_meeting_state" onchange="form.submit()" class="form-control">
                                                    <option value="">All States</option>
                                                    <?php echo InputOptions(StatesName, ""); ?>
                                                </select>
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="" class="m-3">From date:</label>
                                            </div>
                                            <div class='col-md-2'>
                                                <input type="date" name="FromDate" onchange="form.submit()" value='<?php echo IfRequested("GET", "FromDate", date("Y-m-d", strtotime("-1 month")), false) ?>' placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="" class="m-3">To date:</label>
                                            </div>
                                            <div class='col-md-2'>
                                                <input type="date" name="ToDate" value='<?php echo IfRequested("GET", "ToDate", date("Y-m-d"), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>

                                            <div class="col-md-3">
                                                <select name="reception_meeting_status" onchange="form.submit()" class="form-control" required="" placeholder="Status">
                                                    <?php
                                                    echo InputOptionsWithKey([
                                                        "1" => "In Meeting",
                                                        "0" => "Completed",
                                                        "" => "All Type Status"
                                                    ], "");
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-1 mt-3">
                                                <label for="User Business">User Business</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <select name="reception_meeting_user_main_id" required="" onchange="form.submit()" placeholder="" class="form-control">
                                                    <option value="">All Users</option>
                                                    <?php $Allusers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
                                                    if ($Allusers != null) {
                                                        foreach ($Allusers  as $U) {
                                                            echo "<option value='" . $U->UserId . "'>" . $U->UserFullName . " @ " . $U->UserPhoneNumber . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-2 text-right">
                                                <div class="">
                                                    <?php if (isset($_GET['FromDate'])) {
                                                        $From = $_GET['FromDate'];
                                                        $To = $_GET['ToDate']; ?>
                                                        <a target="_blank" href="export.php?FromDate=<?php echo $From; ?>&ToDate=<?php echo $To; ?>" class="btn btn-block btn-md btn-default"><i class="fa fa-file-pdf-o"></i> Export All</a>
                                                    <?php } else { ?>
                                                        <a target="_blank" href="export.php" class="btn btn-md btn-default btn-block"><i class="fa fa-file-pdf"></i> Export All</a>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <?php if (isset($_GET['FromDate'])) {
                                                $From = $_GET['FromDate'];
                                                $To = $_GET['ToDate']; ?>
                                                <div class=" col-md-12 mb-3">
                                                    <p class="p-1 mb-2">
                                                        <i class="fa fa-filter text-danger"></i>
                                                        <b><?php echo TOTAL("SELECT * FROM reception_meeting where DATE(reception_meeting_created_at)>='$From' and DATE(reception_meeting_created_at)<='$To'"); ?>
                                                        </b>
                                                        ReceptionCourier <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['FromDate']); ?></span>
                                                        <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['ToDate']); ?></span>
                                                        <a href="index.php" class="text-danger pull-right float-right" style='float:right !important;'><i class="fa fa-times"></i> Clear Filter</a>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <!-- form meeting end here -->
                                    <div class="col-md-12">
                                        <p class='data-list p-2 flex-s-b bg-primary text-white' style='background-color:black !important;'>
                                            <span class='w-pr-5'>Sno</span>
                                            <span class='w-pr-20'>Business Head</span>
                                            <span class='w-pr-12'>Category</span>
                                            <span class='w-pr-15'>Project</span>
                                            <span class='w-pr-20'>MeetingDate</span>
                                            <span class='w-pr-20'>AssociateName</span>
                                            <span class='w-pr-30'>AssociateMobileNumber</span>
                                            <span class='w-pr-20'>CustomerName</span>
                                            <span class='w-pr-20'>CustomerMobile</span>
                                            <span class='w-pr-10'>City</span>
                                            <span class='w-pr-10'>State</span>
                                            <span class='w-pr-20'>Pincode</span>
                                            <span class='w-pr-20'>OUT-Time</span>
                                            <span class='w-pr-20'>In-Time</span>
                                            <span class='w-pr-20'>Status</span>
                                            <span class='w-pr-10 text-right'>
                                                ACTION
                                            </span>
                                        </p>
                                    </div>

                                    <?php
                                    $start = START_FROM;
                                    $viewlimit = DEFAULT_RECORD_LISTING;

                                    if (isset($_GET['reception_meeting_associate_name'])) {
                                        $reception_meeting_user_main_id = $_GET['reception_meeting_user_main_id'];
                                        $reception_meeting_select_project = $_GET['reception_meeting_select_project'];
                                        $reception_meeting_associate_name = $_GET['reception_meeting_associate_name'];
                                        $reception_meeting_associate_mob_no = $_GET['reception_meeting_associate_mob_no'];
                                        $reception_meeting_customer_name = $_GET['reception_meeting_customer_name'];
                                        $recption_meeting_customer_mobile = $_GET['recption_meeting_customer_mobile'];
                                        $reception_meeting_city = $_GET['reception_meeting_city'];
                                        $reception_meeting_state = $_GET['reception_meeting_state'];
                                        $reception_meeting_status = $_GET['reception_meeting_status'];
                                        $FromDate = $_GET['FromDate'];
                                        $ToDate = $_GET['ToDate'];
                                        if ($reception_meeting_user_main_id == null) {
                                            $UserCheckQuery = "";
                                        } else {
                                            $UserCheckQuery = "reception_meeting_user_main_id='$reception_meeting_user_main_id' and";
                                        }
                                        $Meeting = _DB_COMMAND_("SELECT * FROM reception_meeting where reception_meeting_associate_name like '%$reception_meeting_associate_name%' and reception_meeting_user_main_id like '%$reception_meeting_user_main_id' and reception_meeting_select_project like '%$reception_meeting_select_project%' and reception_meeting_associate_mob_no like '%$reception_meeting_associate_mob_no%' and reception_meeting_customer_name like '%$reception_meeting_customer_name%' and reception_meeting_city like '%$reception_meeting_city' and reception_meeting_status like '%$reception_meeting_status%' and recption_meeting_customer_mobile like '%$recption_meeting_customer_mobile%' and Date(reception_meeting_date)<='%$FromDate%'and Date(reception_meeting_date)<='%$ToDate%'  ORDER BY reception_meeting_id DESC", true);
                                        // $Meeting = _DB_COMMAND_("SELECT * FROM reception_meeting where $UserCheckQuery  reception_meeting_associate_name like '%$reception_meeting_associate_name%' and reception_meeting_status like '%$reception_meeting_status%' and DATE(reception_meeting_date)>='$FromDate' and DATE(reception_meeting_date)<='$ToDATE' and reception_meeting_city like '%$reception_meeting_city%' and reception_meeting_state like '%$reception_meeting_state%' and reception_meeting_associate_mob_no like '%$reception_meeting_associate_mob_no%' and reception_meeting_customer_name like '%$reception_meeting_customer_name%' and recption_meeting_customer_mobile like '%$reception_meeting_customer_mobile%' and reception_meeting_select_project like '%$reception_meeting_select_project%' and reception_meeting_user_main_id like '%$reception_meeting_user_main_id%'  ORDER BY reception_meeting_id DESC", true);
                                    } else {
                                        $Meeting = _DB_COMMAND_("SELECT * FROM reception_meeting ORDER BY reception_meeting_id DESC", true);
                                    }

                                    if ($Meeting == null) {
                                        echo "No data found for user";
                                    } else {
                                        $serial = 0;
                                        foreach ($Meeting as $data) {
                                            $serial++;
                                    ?>
                                            <div class="col-md-12">
                                                <p class='data-list p-2 flex-s-b bg'>
                                                    <span class='w-pr-5'><?php echo $serial ?></span>
                                                    <span class='w-pr-20'><?php echo UserDetails($data->reception_meeting_user_main_id) ?></span>
                                                    <span class='w-pr-12'><?php echo ($data->reception_Category)  ?></span>
                                                    <span class='w-pr-15'><?php echo ($data->reception_meeting_select_project) ?></span>
                                                    <span class='w-pr-20'><?php echo DATE_FORMATES("d M, Y", $data->reception_meeting_date) ?> </span>
                                                    <span class='w-pr-20'><?php echo $data->reception_meeting_associate_name ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_meeting_associate_mob_no ?></span>
                                                    <span class='w-pr-20'><?php echo ($data->reception_meeting_customer_name) ?></span>
                                                    <span class='w-pr-20'><?php echo ($data->recption_meeting_customer_mobile) ?></span>
                                                    <span class='w-pr-10'><?php echo ($data->reception_meeting_city) ?></span>
                                                    <span class='w-pr-10'><?php echo ($data->reception_meeting_state) ?></span>
                                                    <span class='w-pr-20'><?php echo ($data->recption_meeting_pincode) ?></span>
                                                    <span class='w-pr-20'><?php echo ($data->reception_meeting_out_time) ?></span>
                                                    <span class='w-pr-20'><?php echo ($data->reception_meeting_in_time) ?></span>
                                                    <span class='w-pr-20'><?php echo meeting($data->reception_meeting_status) ?></span>

                                                    <span class='w-pr-10 text-right'>
                                                        <button class="bg bg-warning" style="border-radius: 5px; padding: 3px; "> <a href="#" onclick="Databar('AddMeetingPopUp_<?php echo $data->reception_meeting_id; ?>')" style="font-size: 12px;">Update</a> </button>
                                                    </span>
                                                </p>
                                            </div>
                                    <?php
                                            include '../../include/forms/Update_MeetingPopWindow.php';
                                        }
                                    }
                                    ?>
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
    include $Dir . "/include/forms/MeetingPopWindow.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>