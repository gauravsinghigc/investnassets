<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Courier";
$PageDescription = "Manage teams";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
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
                                                <a href="#" onclick="Databar('AddCourierPopUp')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add
                                                    Courier</a>
                                            </div>

                                            <!-- Navbar courier-start -->
                                            <div class="col-md-3">
                                                <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT * FROM reception_courier"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Total Courier</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-danger fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_courier_created_at FROM reception_courier WHERE DATE(reception_courier_created_at)='" . DATE('Y-m-d') . "'"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Today Courier</h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-dark fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_courier_status FROM reception_courier WHERE reception_courier_status = '0' "); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Running Courier </h5>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="card-body  text-light top-card text-start" style="border-radius:5px; background-color: red;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_courier_status FROM reception_courier WHERE reception_courier_status = '1' "); ?> </h4>
                                                    <h5 class="mb-2 fs-15">Completed</h5>
                                                </div>
                                            </div>

                                            <!-- form courier start here -->
                                            <div class='col-md-3 mb-2 text-left'>
                                                <input type="text" name="reception_courier_name_of_party" onchange="form.submit()" value='<?php echo IfRequested("GET", "reception_courier_name_of_party", "", false)  ?>' placeholder="Name Of Party" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="number" name="reception_courier_party_contact_number" value='<?php echo IfRequested("GET", "reception_courier_party_contact_number", "", false) ?>' onchange="form.submit()" placeholder="Party Contact number" class="form-control" maxlength="12" minlength="10">
                                            </div>

                                            <div class="col-md-3">
                                                <input type="text" name="reception_courier_city" value='<?php echo IfRequested("GET", "reception_courier_city", "", false) ?>' onchange="form.submit()" placeholder="city" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <select name="reception_courier_state" class="form-control">
                                                    <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
                                                </select>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="text" name="reception_courier_sender_name" value="<?php echo IfRequested("GET", "reception_courier_sender_name", "", false) ?>" onchange="form.submit()" placeholder="Sender Name" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" name="reception_courier_sender_contact_number" value="<?php echo IfRequested("GET", "reception_courier_sender_contact_number", "", false) ?>" onchange="form.submit()" placeholder="Sender Contact Number" class="form-control" maxlength="12" minlength="10">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="reception_courier_name" value='<?php echo IfRequested("GET", "reception_courier_name", "", false) ?>' onchange="form.submit()" placeholder="Courier Name" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="reception_courier_tracking_number" value='<?php echo IfRequested("GET", "reception_courier_tracking_number", "", false) ?>' onchange="form.submit()" placeholder="Tracking Number" class="form-control">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="" class="m-3">From date:</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="date" name="reception_courier_date_from" value='<?php echo IfRequested("GET", "reception_courier_date_from", date("Y-m-d", strtotime("-1 month")), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="" class="m-3">To date:</label>
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="date" name="reception_courier_date_to" value='<?php echo IfRequested("GET", "reception_courier_date_to", date("Y-m-d"), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class="col-md-4">
                                                <select name="reception_courier_status" class="form-control" required="" placeholder="Status">
                                                    <?php
                                                    echo InputOptionsWithKey([
                                                        "1" => "Pending",
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
                                                <select name="reception_courier_user_main_id" required="" placeholder="" class="form-control">
                                                    <?php $Allusers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
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
                                                        <b><?php echo TOTAL("SELECT * FROM reception_courier where DATE(reception_courier_created_at)>='$From' and DATE(reception_courier_created_at)<='$To'"); ?>
                                                        </b>
                                                        ReceptionCourier <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['FromDate']); ?></span>
                                                        <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['ToDate']); ?></span>
                                                        <a href="index.php" class="text-danger pull-right float-right" style='float:right !important;'><i class="fa fa-times"></i> Clear Filter</a>
                                                    </p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>

                                    <!-- form courier end here -->
                                    <div class="col-md-12">
                                        <p class='data-list p-2 flex-s-b bg-primary text-white' style='background-color:black !important;'>
                                            <span class='w-pr-10'>Sno</span>
                                            <span class='w-pr-10'>Date</span>
                                            <span class='w-pr-30'>NameOfParty</span>
                                            <span class='w-pr-40'>PartyContactNumber</span>
                                            <span class='w-pr-15'>City</span>
                                            <span class='w-pr-15'>State</span>
                                            <span class='w-pr-20'>Pincode</span>
                                            <span class='w-pr-30'>Department</span>
                                            <span class='w-pr-30'>SenderName</span>
                                            <span class='w-pr-30'>ContactNumber</span>
                                            <span class='w-pr-30'>CourierName</span>
                                            <span class='w-pr-30'>TrackingNumber</span>
                                            <span class='w-pr-20'>ItemDetails</span>
                                            <span class='w-pr-30'>ReceiptReceived</span>
                                            <span class='w-pr-25'>ReturnedDate</span>
                                            <span class='w-pr-20'>Status</span>
                                            <span class='w-pr-10 text-right'>
                                                ACTION
                                            </span>
                                        </p>
                                    </div>
                                    <?php

                                    $start = START_FROM;
                                    $viewlimit = DEFAULT_RECORD_LISTING;
                                    if (isset($_GET['reception_courier_sender_name'])) {
                                        $reception_courier_user_main_id = $_GET['reception_courier_user_main_id'];
                                        $reception_courier_name_of_party = $_GET['reception_courier_name_of_party'];
                                        $reception_courier_party_contact_number = $_GET['reception_courier_party_contact_number'];
                                        $reception_courier_city = $_GET['reception_courier_city'];
                                        $reception_courier_state = $_GET['reception_courier_state'];
                                        $reception_courier_sender_name = $_GET['reception_courier_sender_name'];
                                        $reception_courier_sender_contact_number = $_GET['reception_courier_sender_contact_number'];
                                        $reception_courier_name = $_GET['reception_courier_name'];
                                        $reception_courier_tracking_number = $_GET['reception_courier_tracking_number'];
                                        $FromDate = $_GET['reception_courier_date_from'];
                                        $ToDate = $_GET['reception_courier_date_to'];
                                        $reception_courier_status = $_GET['reception_courier_status'];
                                        if ($reception_courier_user_main_id == null) {
                                            $UserCheckQuery = "";
                                        } else {
                                            $UserCheckQuery =  "reception_courier_user_main_id='$reception_courier_user_main_id' and";
                                        }
                                        $AllCourier = _DB_COMMAND_("SELECT * FROM reception_courier WHERE $UserCheckQuery reception_courier_sender_name like '%$reception_courier_sender_name%' and reception_courier_name_of_party like '%$reception_courier_name_of_party%' and  reception_courier_user_main_id like '%$reception_courier_user_main_id%' and  DATE(reception_courier_date)>='$FromDate' and DATE(reception_courier_date)<='$ToDate' and reception_courier_party_contact_number like '%$reception_courier_party_contact_number%' and reception_courier_city like '%$reception_courier_city%' and reception_courier_state like '%$reception_courier_state%' and reception_courier_sender_contact_number like '%$reception_courier_sender_contact_number%' and reception_courier_name like '%$reception_courier_name%' and  reception_courier_tracking_number like '%$reception_courier_tracking_number%' and reception_courier_status like '%$reception_courier_status%' ORDER BY reception_courier_id DESC", true);
                                    } else {
                                        $AllCourier = _DB_COMMAND_("SELECT * FROM reception_courier ORDER BY reception_courier_id DESC", true);
                                    }

                                    if ($AllCourier == null) {
                                        NoData("No Data Found!", "Please search with valid entry");
                                    } else {
                                        $serial = 0;
                                        foreach ($AllCourier as $data) {
                                            $serial++;
                                    ?>
                                            <div class="col-md-12">
                                                <p class='data-list p-2 flex-s-b'>
                                                    <span class='w-pr-10'><?php echo $serial; ?></span>
                                                    <span class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $data->reception_courier_date); ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_name_of_party; ?></span>
                                                    <span class='w-pr-40'><?php echo $data->reception_courier_party_contact_number; ?></span>
                                                    <span class='w-pr-15'><?php echo $data->reception_courier_city; ?></span>
                                                    <span class='w-pr-15'><?php echo $data->reception_courier_state; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_courier_pincode; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_user_main_id; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_sender_name; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_sender_contact_number; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_name; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_tracking_number; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_courier_item_details; ?></span>
                                                    <span class='w-pr-30'><?php echo $data->reception_courier_receipt_received; ?></span>
                                                    <span class='w-pr-25'><?php echo $data->reception_courier_returned_date; ?></span>
                                                    <span class='w-pr-20'><?php echo courier($data->reception_courier_status) ?></span>
                                                    <span class='w-pr-10 text-right'>
                                                        <button class="bg bg-warning" style="border-radius: 5px; padding: 3px; "><a href="#" onclick="Databar('AddCourierPopUp_<?php echo $data->reception_courier_id; ?>')" style="font-size: 12px;">Update</a> </button>
                                                    </span>
                                                </p>
                                            </div>
                                    <?php
                                            include '../../include/forms/Update_CourierAddPopWindow.php';
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
    include $Dir . "/include/forms/CourierAddPopWindow.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>