<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

?>
<html>

<head>
  <title>All Visitors</title>
</head>

<body onload="window.print()">
  <table style='width:100% !important;' border="1">
    <thead>
      <tr>
        <th>Sno</th>
        <th>Name</th>
        <th>PhoneNumber</th>
        <th>CustomerDetails</th>
        <th>Date</th>
        <th>VisitType</th>
        <th>MeetingTime</th>
        <!-- <th>In-Out</th> -->
      </tr>
    </thead>
    <tbody>
      <?php

      if (isset($_GET['reception_sitevisit_user_main_id'])) {
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

        $SiteVisit = _DB_COMMAND_("SELECT * FROM  reception_sitevisit WHERE  $UserCheckQuery reception_sitevisit_status like '%$reception_sitevisit_status%' and reception_sitevisit_booking_date<= '$FromDate' and reception_sitevisit_booking_date<= '$ToDate' and reception_sitevisit_associate_name like '%$reception_sitevisit_associate_name%' and reception_sitevisit_associate_mobile_number like '%$reception_sitevisit_associate_mobile_number%' and reception_sitevisit_customer_name like '%$reception_sitevisit_customer_name%' and reception_sitevisit_customer_mobile_number like '%$reception_sitevisit_customer_mobile_number%' and reception_sitevisit_vendor_firm_name like '%$reception_sitevisit_vendor_firm_name%' and reception_sitevisit_driver_name like '%$reception_sitevisit_driver_name%' and reception_sitevisit_cab_number like '%$reception_sitevisit_cab_number%' ORDER BY reception_sitevisit_id DESC", true);
      } else {

        $SiteVisit = _DB_COMMAND_("SELECT * FROM reception_sitevisit ORDER BY reception_sitevisit_id DESC", true);
      }

      if ($SiteVisit != null) {
        $SerialNo = 0;
        foreach ($SiteVisit as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->reception_sitevisit_associate_name; ?>
            </td>
            <td class='w-pr-12'><?php echo $Visitor->reception_sitevisit_associate_mobile_number; ?></span>
            <td class='w-pr-15'><?php echo $Visitor->reception_sitevisit_customer_name; ?></td>
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->reception_sitevisit_created_at); ?></td>
            <td class='w-pr-20'><?php echo $Visitor->reception_sitevisit_status; ?></td>
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->reception_sitevisit_created_at); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->reception_sitevisit_out_time); ?></td>
          </tr>
      <?php
        }
      } else {
        NoData("No Visitor Found!");
      } ?>
    </tbody>
  </table>
</body>

</html>