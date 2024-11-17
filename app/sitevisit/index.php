<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Site Visit";
$PageDescription = "Manage teams";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> <?php echo $PageName; ?> | <?php echo APP_NAME; ?> </title>
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
                                                <a href="#" onclick="Databar('AddSite-VisitPopUp')" class="btn btn-sm btn-danger btn-block">
                                                    <i class="fa fa-plus"></i>
                                                    Add SiteVisit
                                                </a>
                                            </div>

                                            <!-- Navbar site visit start   -->
                                            <div class="col-md-3">
                                                <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-light  fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_sitevisit_created_at FROM reception_sitevisit"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Total Visit</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-danger fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_sitevisit_created_at FROM reception_sitevisit WHERE DATE(reception_sitevisit_created_at)='" . DATE('Y-m-d') . "'"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Today Visit</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-dark fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_sitevisit_status  FROM reception_sitevisit WHERE reception_sitevisit_status = '0' "); ?>

                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Running Site Visit</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card-body  text-light top-card text-start" style="border-radius:5px; background-color: red;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_sitevisit_status FROM reception_sitevisit WHERE reception_sitevisit_status = '1' "); ?> </h4>
                                                    <h5 class="mb-2 fs-15">Completed</h5>
                                                </div>
                                            </div>

                                            <!-- form SiteVisit start here -->
                                            <div class='col-md-3 mb-2 text-left'>
                                                <select name="reception_sitevisit_project_to_visit" value='<?php echo IfRequested("GET", "reception_sitevisit_project_to_visit", "", false) ?>' required="" onchange="form.submit()" placeholder="" class="form-control">
                                                    <option value="">Select Project</option>
                                                    <?php
                                                    $AllMeeting = _DB_COMMAND_("SELECT ProjectsId, ProjectTypeId, ProjectName FROM projects ", true);
                                                    if ($AllMeeting != null) {
                                                        foreach ($AllMeeting  as $M) {
                                                            echo "<option value='" . $M->ProjectsId   . "'>" . $M->ProjectTypeId . $M->ProjectName . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name='reception_sitevisit_associate_name' value='<?php echo IfRequested("GET", "reception_sitevisit_associate_name", "", false) ?>' onchange="form.submit()" placeholder="Associate Name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="number" name='reception_sitevisit_associate_mobile_number' value='<?php echo IfRequested("GET", "reception_sitevisit_associate_mobile_number", "", false) ?>' onchange="form.submit()" placeholder="Associate Mobile Number" class="form-control" maxlength="12" minlength="10">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name='reception_sitevisit_customer_name' value='<?php echo IfRequested("GET", "reception_sitevisit_customer_name", "", false) ?>' onchange="form.submit()" placeholder="Customer Name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="number" name='reception_sitevisit_customer_mobile_number' value='<?php echo IfRequested("GET", "reception_sitevisit_customer_mobile_number", "", false) ?>' onchange="form.submit()" placeholder="Customer Mobile Number" class="form-control" maxlength="12" minlength="10">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name='reception_sitevisit_vendor_firm_name' value='<?php echo IfRequested("GET", "reception_sitevisit_vendor_firm_name", "", false) ?>' onchange="form.submit()" placeholder="Vendor Firm Name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name='reception_sitevisit_driver_name' value='<?php echo IfRequested("GET", "reception_sitevisit_driver_name", "", false) ?>' onchange="form.submit()" placeholder="Driver Name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name='reception_sitevisit_cab_number' value='' onchange="form.submit()" placeholder="Cab Number" class="form-control">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="FromDate" class="mt-3">From date:</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="date" name='FromDate' value='<?php echo IfRequested("GET", "FromDate", date("Y-m-d", strtotime("-1 month")), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="ToDate" class="m-3">To date:</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="date" name='ToDate' value='<?php echo IfRequested("GET", "ToDate", date("Y-m-d"), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>

                                            <div class="col-md-4">
                                                <select name="reception_sitevisit_status" class="form-control" onchange="form.submit()" required="" placeholder="Status">
                                                    <?php
                                                    echo InputOptionsWithKey([
                                                        "1" => "Pending",
                                                        "0" => "Completed",
                                                        "2" => "All Type Status"
                                                    ], IfRequested("GET", "reception_sitevisit_status", "2", false));
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-3">
                                                <label for="Type Of Activity">User Business</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <select name="reception_sitevisit_user_main_id" required="" onchange="form.submit()" placeholder="" class="form-control">
                                                    <option value=''>Select Users</option>
                                                    <?php $Allusers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1'", true);
                                                    if ($Allusers != null) {
                                                        foreach ($Allusers  as $U) {
                                                            echo "<option value='" . $U->UserId . "'>" . $U->UserFullName . " @ " . $U->UserPhoneNumber . "</option>";
                                                        }
                                                    } ?>
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
                                                        <b><?php echo TOTAL("SELECT * FROM reception_sitevisit where DATE(reception_sitevisit_created_at)>='$From' and DATE(reception_sitevisit_created_at)<='$To'"); ?>
                                                        </b>
                                                        SiteVisit <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['FromDate']); ?></span>
                                                        <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['ToDate']); ?></span>
                                                        <a href="index.php" class="text-danger pull-right float-right" style='float:right !important;'><i class="fa fa-times"></i> Clear Filter</a>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <!-- form activity end here -->
                                    <div class="col-md-12">
                                        <p class='data-list p-2 flex-s-b bg-primary text-white' style='background-color:black !important;'>
                                            <span class='w-pr-10'>Sno</span>
                                            <span class='w-pr-40'>BusinessHead</span>
                                            <span class='w-pr-40'>ProjectToVisit</span>
                                            <span class='w-pr-40'>BookingDate</span>
                                            <span class='w-pr-40'>AssociateDetails</span>
                                            <span class='w-pr-40'>CustomerDetails</span>
                                            <span class='w-pr-40'>ApprovedBy</span>
                                            <span class='w-pr-40'>VendorFirmName</span>
                                            <span class='w-pr-40'>DriverDetails</span>
                                            <span class='w-pr-20'>VehicleDetails</span>
                                            <span class='w-pr-40 ml-2'>DistanceCovered</span>
                                            <span class='w-pr-30 ml-2'>TotalKm</span>
                                            <span class='w-pr-30'>IN-OUT-Time</span>
                                            <span class='w-pr-35'>TotalHours</span>
                                            <span class='w-pr-20'>Status</span>
                                            <span class='w-pr-10 text-right'>
                                                ACTION
                                            </span>
                                        </p>
                                        <?php

                                        $start = START_FROM;
                                        $viewlimit = DEFAULT_RECORD_LISTING;

                                        if (isset($_GET['reception_sitevisit_associate_name'])) {
                                            $reception_sitevisit_user_main_id = $_GET['reception_sitevisit_user_main_id'];
                                            $reception_sitevisit_status = $_GET['reception_sitevisit_status'];
                                            $reception_sitevisit_cab_number = $_GET['reception_sitevisit_cab_number'];
                                            $reception_sitevisit_associate_name = $_GET['reception_sitevisit_associate_name'];
                                            $reception_sitevisit_associate_mobile_number = $_GET['reception_sitevisit_associate_mobile_number'];
                                            $reception_sitevisit_customer_name = $_GET['reception_sitevisit_customer_name'];
                                            $reception_sitevisit_customer_mobile_number = $_GET['reception_sitevisit_customer_mobile_number'];
                                            $reception_sitevisit_vendor_firm_name = $_GET['reception_sitevisit_vendor_firm_name'];
                                            $reception_sitevisit_driver_name = $_GET['reception_sitevisit_driver_name'];
                                            $reception_sitevisit_project_to_visit = $_GET['reception_sitevisit_project_to_visit'];
                                            $FromDate = $_GET['FromDate'];
                                            $ToDate = $_GET['ToDate'];
                                            if ($reception_sitevisit_user_main_id == null) {
                                                $UserCheckQuery = "";
                                            } else {
                                                $UserCheckQuery = "reception_sitevisit_user_main_id = '$reception_sitevisit_user_main_id' and";
                                            }
                                            $SiteVisit = _DB_COMMAND_("SELECT * FROM reception_sitevisit Where $UserCheckQuery reception_sitevisit_associate_name like '%$reception_sitevisit_associate_name%' and reception_sitevisit_user_main_id like '%$reception_sitevisit_user_main_id%' and reception_sitevisit_associate_mobile_number like '%$reception_sitevisit_associate_mobile_number%' and reception_sitevisit_customer_name like '%$reception_sitevisit_customer_name%' and reception_sitevisit_customer_mobile_number like '%$reception_sitevisit_customer_mobile_number%' and reception_sitevisit_vendor_firm_name like '%$reception_sitevisit_vendor_firm_name%' and Date(reception_sitevisit_booking_date)<='$FromDate' and Date(reception_sitevisit_booking_date)<='$ToDate'  ORDER BY reception_sitevisit_id DESC ", true);
                                        } else {
                                            $SiteVisit = _DB_COMMAND_("SELECT * FROM reception_sitevisit ORDER BY reception_sitevisit_id DESC", true);
                                        }

                                        if ($SiteVisit == null) {
                                            echo NoData("No Data Found!");
                                        } else {
                                            $serial = 0;
                                            foreach ($SiteVisit as $data) {
                                                $serial++;
                                        ?>
                                                <div class="col-md-12">
                                                    <p class='data-list p-2 flex-s-b bg'>
                                                        <span class='w-pr-10'>
                                                            <?php echo ($data->$serial) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo UserDetails($data->reception_sitevisit_user_main_id) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_project_to_visit) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo DATE_FORMATES("d M, Y", $data->reception_sitevisit_booking_date) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_associate_name) ?> <br>
                                                            <?php echo PHONE($data->reception_sitevisit_associate_mobile_number, "link", "", "fa fa-phone"); ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_customer_name) ?>
                                                            <?php echo ($data->reception_sitevisit_customer_mobile_number) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_approved_by) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_vendor_firm_name) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_driver_name) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_cab_number) ?>
                                                            <?php echo ($data->reception_sitevisit_type_of_vehicle) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_open_km) ?>
                                                            <?php echo ($data->reception_sitevisit_close_km) ?>
                                                        </span>
                                                        <span class='w-pr-20'>
                                                            <?php echo ($data->reception_sitevisit_total_km) ?>
                                                        </span>
                                                        <span class='w-pr-20'>
                                                            <?php echo ($data->reception_sitevisit_in_time) ?>
                                                            <?php echo ($data->reception_sitevisit_out_time) ?>
                                                        </span>
                                                        <span class='w-pr-40'>
                                                            <?php echo ($data->reception_sitevisit_total_hours) ?>
                                                        </span>
                                                        <span class='w-pr-20'>
                                                            <?php echo SiteVisit($data->reception_sitevisit_status) ?>
                                                        </span>
                                                        <span class='w-pr-10 text-right'>
                                                            <button class="bg bg-warning" style="border-radius: 10px; padding: 3px; "><a href="#" onclick="Databar('AddSite-VisitPopUp_<?php $data->reception_sitevisit_id ?>')" style="font-size: 12px;">Update</a> </button>
                                                        </span>
                                                    </p>
                                                </div>
                                        <?php
                                                include '../../include/forms/Update_SiteVisitPopWindow.php';
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
    include $Dir . "/include/forms/SiteVisitPopWindow.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>