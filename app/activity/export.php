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
        <th>TypeOfActivity</th>
        <th>Date</th>
        <th>Status</th>
        <th>In-Out</th>
        <!-- <th>In-Out</th> -->
      </tr>
    </thead>
    <tbody>
      <?php

      if (isset($_GET['reception_activity_user_main_id'])) {
        $reception_activity_user_main_id = $_GET['reception_activity_user_main_id'];
        $reception_activity_customer_name = $_GET['reception_activity_customer_name'];
        $reception_activity_type_of_activity = $_GET['reception_activity_type_of_activity'];
        $reception_activity_customer_mobile = $_GET['reception_activity_customer_mobile'];
        $reception_activity_place_of_activity_number = $_GET['reception_activity_place_of_activity_number'];
        $reception_activity_city = $_GET['reception_activity_city'];
        $reception_activity_state = $_GET['reception_activity_state'];
        $FromDate = $_GET['reception_activity_state'];
        $ToDate = $_GET['reception_activity_state'];
        $reception_activity_status = $_GET['reception_activity_status'];
        if ($reception_activity_user_main_id == null) {
          $UserCheckQuery = "";
        } else {
          $UserCheckQuery = "reception_activity_user_main_id = '$reception_activity_user_main_id' and";
        }
        $Activity = _DB_COMMAND_("SELECT * FROM reception_activity  WHERE   $UserCheckQuery reception_activity_status like '%reception_activity_status%' and FromDate<= '$FromDate' and ToDate<= '$ToDate' and reception_activity_customer_name like '%$reception_activity_customer_name%' and reception_activity_customer_mobile like '%$reception_activity_customer_mobile%' and reception_activity_type_of_activity like '%$reception_activity_type_of_activity%' and reception_activity_place_of_activity_number like '%$reception_activity_place_of_activity_number%' and reception_activity_city like '%$reception_activity_city%' and reception_activity_state like '%$reception_activity_state%' ORDER BY reception_activity_id DESC ", true);
      } else {
        $Activity = _DB_COMMAND_("SELECT * FROM reception_activity ORDER BY reception_activity_id DESC", true);
      }

      if ($Activity != null) {
        $SerialNo = 0;
        foreach ($Activity as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->reception_activity_customer_name; ?>
            </td>
            <td class='w-pr-12'><?php echo $Visitor->reception_activity_customer_mobile; ?></span>
            <td class='w-pr-15'><?php echo $Visitor->reception_activity_type_of_activity; ?></td>
            <!-- <td class='w-pr-20'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></td> -->
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->reception_activity_created_at); ?></td>
            <td class='w-pr-20'><?php echo $Visitor->reception_activity_status; ?></td>
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->reception_activity_created_at); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->reception_activity_out_time); ?></td>
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