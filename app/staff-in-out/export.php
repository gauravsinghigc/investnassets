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
        <!-- <th>Name</th> -->
        <!-- <th>PhoneNumber</th> -->
        <!-- <th>type</th> -->
        <!-- <th>Purpose</th> -->
        <!-- <th>StaffInOutType</th> -->
        <!-- <th>MeetingWith</th> -->
        <!-- <th>purpose</th> -->
        <th>User in out status</th>
        <th>User Business</th>
        <th>Date</th>
        <th>Time</th>


      </tr>
    </thead>
    <tbody>
      <?php
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
        $StaffInOut = _DB_COMMAND_("SELECT * FROM user_in_out where $UserCheckQuery user_in_out_status like '%$user_in_out_status%' and user_in_out_date>='$FromDate' and user_in_out_date<='$ToDATE' ORDER BY user_in_out_id DESC", true);
      } else {
        $StaffInOut = _DB_COMMAND_("SELECT * FROM user_in_out ORDER BY user_in_out_id DESC", true);
      }





      if ($StaffInOut != null) {
        $SerialNo = 0;
        foreach ($StaffInOut as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->user_in_out_status; ?>
            </td>
            <!-- <td class='w-pr-12'><?php echo $Visitor->user_main_id; ?></span> -->
            <!-- <td class='w-pr-15'><?php echo $Visitor->UserType; ?></td> -->
            <td class='w-pr-20'><?php echo FETCH("SELECT * FROM user_in_out inner join users where UserId='" . $Visitor->user_main_id  . "'", "UserFullName"); ?></td>
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->user_in_out_created_at); ?></td>
            <!-- <td class='w-pr-20'><?php echo $Visitor->user_in_out_status; ?></td> -->
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->user_in_out_created_at); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->user_out_time); ?></td>
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