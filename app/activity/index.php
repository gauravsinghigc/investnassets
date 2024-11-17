<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Activity";
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
                                                <a href="#" onclick="Databar('AddAcitivity')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add
                                                    Activity</a>
                                            </div>
                                            <!-- Navbar activity-start -->
                                            <div class="col-md-3">
                                                <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_activity_created_at FROM reception_activity"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Total Activity</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-danger fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_activity_created_at FROM reception_activity WHERE DATE(reception_activity_created_at)='" . DATE('Y-m-d') . "'"); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Today Activity</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                                                    <h4 class="text-dark fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_activity_status FROM reception_activity WHERE reception_activity_status = '0' "); ?>
                                                    </h4>
                                                    <h5 class="mb-2 fs-15">Running Activity</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card-body text-light top-card text-start" style="border-radius:5px; background-color: red;">
                                                    <h4 class="text-light fs-30 mt-2">
                                                        <?php echo TOTAL("SELECT reception_activity_status FROM reception_activity WHERE reception_activity_status = '1' "); ?> </h4>
                                                    <h5 class="mb-2 fs-15">Complete Activity</h5>
                                                </div>
                                            </div>
                                            <!-- form activity start here -->
                                            <div class='col-md-3 mb-2 text-left'>
                                                <input type="text" name='reception_activity_customer_name' value='<?php echo IfRequested("GET", "reception_activity_customer_name", "", false) ?>' onchange="form.submit()" placeholder="Customer name" class="form-control">
                                            </div>
                                            <div class='col-md-3'>
                                                <input type="number" name='reception_activity_customer_mobile' value='<?php echo IfRequested("GET", "reception_activity_customer_mobile", "", false) ?>' onchange="form.submit()" placeholder="Customer mobile number" class="form-control" maxlength="12" minlength="10">
                                            </div>
                                            <div class='col-md-3'>
                                                <select name="reception_activity_type_of_activity" required="" onchange="form.submit()" placeholder="Type Of Activity" class="form-control">
                                                    <?php
                                                    echo InputOptionsWithKey([
                                                        "1" => "Meeting",
                                                        "2" => "SiteVisit",
                                                        "3" => "All Type Of Activity"
                                                    ], "3");
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name='reception_activity_place_of_activity_number' value='<?php echo IfRequested("GET", "reception_activity_place_of_activity_number", "", false) ?>' onchange="form.submit()" placeholder="Place Of Activity" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name='reception_activity_city' value='<?php echo IfRequested("GET", "reception_activity_city", "", false) ?>' onchange="form.submit()" placeholder="city" class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <select name="reception_activity_state" onchange="form.submit()" class="form-control">
                                                    <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
                                                </select>
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="FromDate" class="m-3">From date:</label>
                                            </div>
                                            <div class='col-md-2'>
                                                <input type="date" name='FromDate' value='<?php echo IfRequested("GET", "FromDate", date("Y-m-d", strtotime("-1 month")), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class='col-md-1'>
                                                <label for="ToDate" class="m-3">To date:</label>
                                            </div>
                                            <div class='col-md-2'>
                                                <input type="date" name='ToDate' value='<?php echo IfRequested("GET", "ToDate", date("Y-m-d"), false) ?>' onchange="form.submit()" placeholder="" class="form-control  m-1">
                                            </div>
                                            <div class="col-md-4">
                                                <select name="reception_activity_status" class="form-control" onchange="form.submit()" required="" placeholder="Status">
                                                    <?php
                                                    echo InputOptionsWithKey([
                                                        "1" => "Pending",
                                                        "0" => "Completed",
                                                        "2" => "All Activity Status"
                                                    ], "2");
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-1 mt-3">
                                                <label for="User Business">User Business</label>
                                            </div>
                                            <div class='col-md-4'>
                                                <select name="reception_activity_user_main_id" required="" placeholder="" onchange="form.submit()" class="form-control">
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
                                                        <b><?php echo TOTAL("SELECT * FROM reception_activity where DATE(reception_activity_created_at)>='$From' and DATE(reception_activity_created_at)<='$To'"); ?>
                                                        </b>
                                                        Activity <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['FromDate']); ?></span>
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
                                            <span class='w-pr-5'>Sno</span>
                                            <span class='w-pr-15'>BusinessHead</span>
                                            <span class='w-pr-20'>CustomerName</span>
                                            <span class='w-pr-20'>MobileNumber</span>
                                            <span class='w-pr-20'>TypeOfActivity</span>
                                            <span class='w-pr-20'>PlaceOfActivity</span>
                                            <span class='w-pr-10'>City</span>
                                            <span class='w-pr-10'>State</span>
                                            <span class='w-pr-20'>Pincode</span>
                                            <span class='w-pr-20'>OUT-Time</span>
                                            <span class='w-pr-20'>IN-OUT</span>
                                            <span class='w-pr-20'>Status</span>
                                            <span class='w-pr-10 text-right'>
                                                ACTION
                                            </span>
                                        </p>
                                    </div>
                                    <?php
                                    $start = START_FROM;
                                    $viewlimit = DEFAULT_RECORD_LISTING;

                                    if (isset($_GET['reception_activity_customer_name'])) {
                                        $reception_activity_customer_name = $_GET['reception_activity_customer_name'];
                                        $reception_activity_user_main_id = $_GET['reception_activity_user_main_id'];
                                        $reception_activity_type_of_activity = $_GET['reception_activity_type_of_activity'];
                                        $reception_activity_customer_mobile = $_GET['reception_activity_customer_mobile'];
                                        $reception_activity_place_of_activity_number = $_GET['reception_activity_place_of_activity_number'];
                                        $reception_activity_city = $_GET['reception_activity_city'];
                                        $reception_activity_state = $_GET['reception_activity_state'];
                                        $FromDate = $_GET['FromDate'];
                                        $ToDate = $_GET['ToDate'];
                                        $reception_activity_status = $_GET['reception_activity_status'];
                                        if ($reception_activity_user_main_id == null) {
                                            $UserCheckQuery = "";
                                        } else {
                                            $UserCheckQuery = "reception_activity_user_main_id = '$reception_activity_user_main_id' and";
                                        }
                                        $Activity = _DB_COMMAND_("SELECT * FROM reception_activity where $UserCheckQuery reception_activity_customer_name like '%$reception_activity_customer_name%'  ORDER BY reception_activity_id DESC",  true);
                                    } else {
                                        $Activity = _DB_COMMAND_("SELECT * FROM reception_activity ORDER BY reception_activity_id DESC", true);
                                    }

                                    if ($Activity == null) {
                                        echo "Data not found";
                                    } else {
                                        $serial = 0;
                                        foreach ($Activity as $data) {
                                            $serial++;
                                    ?>
                                            <div class="col-md-12">
                                                <p class='data-list p-2 flex-s-b bg'>
                                                    <span class='w-pr-5'><?php echo $serial ?></span>
                                                    <span class='w-pr-15'><?php echo UserDetails($data->reception_activity_user_main_id); ?></span>
                                                    <span class='w-pr-15'><?php echo $data->reception_activity_customer_name; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_customer_mobile; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_type_of_activity; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_place_of_activity_number; ?></span>
                                                    <span class='w-pr-10'><?php echo $data->reception_activity_city; ?></span>
                                                    <span class='w-pr-10'><?php echo $data->reception_activity_state; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_pincode; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_out_time; ?></span>
                                                    <span class='w-pr-20'><?php echo $data->reception_activity_in_time; ?></span>
                                                    <span class='w-pr-20'><?php echo activity($data->reception_activity_status); ?></span>
                                                    <span class='w-pr-10 text-right'>
                                                        <button class="bg bg-warning" style="border-radius: 5px; padding: 3px; "><a href="#" onclick="Databar('AddAcitivity_<?php echo $data->reception_activity_id; ?>')" style="font-size:12px;">Update</a> </button>
                                                    </span>
                                                </p>
                                            </div>
                                    <?php
                                            include '../../include/forms/Update_ActivityPopWindow.php';
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
    include $Dir . "/include/forms/ActivityPopWindow.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>