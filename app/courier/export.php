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
        <th>SenderName</th>
        <th>Date</th>
        <th>Status</th>
        <th>Time</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($_GET['reception_courier_user_main_id'])) {
        $reception_courier_user_main_id = $_GET['reception_courier_user_main_id'];
        $reception_courier_name_of_party = $_GET['reception_courier_name_of_reception_courier_tracking_numberparty'];
        $reception_courier_party_contact_number = $_GET['reception_courier_party_contact_number'];
        $reception_courier_city = $_GET['reception_courier_city'];
        $reception_courier_state = $_GET['reception_courier_state'];
        $reception_courier_sender_name = $_GET['reception_courier_sender_name'];
        $reception_courier_sender_contact_number = $_GET['reception_courier_sender_contact_number'];
        $reception_courier_name = $_GET['reception_courier_name'];
        $reception_courier_tracking_number = $_GET['reception_courier_tracking_number'];
        $FromDate = $_GET['FromDate'];
        $ToDate = $_GET['ToDate'];
        $reception_courier_status = $_GET['reception_courier_status'];
        if ($reception_courier_user_main_id == null) {
          $UserCheckQuery = "";
        } else {
          $UserCheckQuery =  "reception_courier_user_main_id = '$reception_courier_user_main_id' and";
        }
        $AllCourier = _DB_COMMAND_("SELECT * FROM reception_courier WHERE  $UserCheckQuery reception_courier_status like '%$reception_courier_status%' and FromDate<= '$FromDate' and ToDate<= '$ToDate' and reception_courier_name_of_party like '%$reception_courier_name_of_party%' and reception_courier_party_contact_number like '%$reception_courier_party_contact_number%' and reception_courier_city like '%$reception_courier_city%' and reception_courier_state like '%$reception_courier_state%' and reception_courier_sender_name like '%$reception_courier_sender_name%' and reception_courier_sender_contact_number like '%$reception_courier_sender_contact_number%' and reception_courier_name like '%$reception_courier_name%' and reception_courier_tracking_number like '%$reception_courier_tracking_number%' ORDER BY reception_courier_id DESC", true);
      } else {
        $AllCourier = _DB_COMMAND_("SELECT * FROM reception_courier ORDER BY reception_courier_id DESC", true);
      }

      if ($AllCourier != null) {
        $SerialNo = 0;
        foreach ($AllCourier as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->reception_courier_name_of_party; ?>
            </td>
            <td class='w-pr-12'><?php echo $Visitor->reception_courier_party_contact_number; ?></span>
            <td class='w-pr-15'><?php echo $Visitor->reception_courier_sender_name; ?></td>
            <!-- <td class='w-pr-20'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></td> -->
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->reception_courier_created_at); ?></td>
            <td class='w-pr-20'><?php echo $Visitor->reception_courier_status; ?></td>
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->reception_courier_created_at); ?> </td>
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