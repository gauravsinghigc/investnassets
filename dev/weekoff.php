<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

$WeekDay = WEEKLY_OFF_DAY_OF_THE_MONTH;
$CurrentMonth = date("Y-m");

$StartDay = 0;
$LastDayOfTheMonth = AttandanceMonthdays($CurrentMonth);

while ($StartDay < $LastDayOfTheMonth) {
  $StartDay++;
  $ConstructDate = "$CurrentMonth-$StartDay";
  $DateOfTheMonth = date("Y-m-d", strtotime($ConstructDate));

  //check week day of in the running calendar dates
  $NumberOfWeekDay = date('N', strtotime($DateOfTheMonth));
  $NameOfWeekDay = date('l', strtotime($DateOfTheMonth));

  if ($NumberOfWeekDay == $WeekDay) {
    $CheckInHoliday = CHECK("SELECT ConfigHolidayid, ConfigHolidayFromDate FROM config_holidays where DATE(ConfigHolidayFromDate)='$DateOfTheMonth'");
    if ($CheckInHoliday == null) {
      $config_holidays = [
        "ConfigHolidayName" => "WEEKLY-OFF",
        "ConfigHolidayFromDate" => $DateOfTheMonth,
        "ConfigHolidayToDate" => "",
        "ConfigHolidayNotes" => SECURE("WEEKLY-OFF as per HR/Attandance Policy", "e"),
        "ConfigHolidayCreatedBy" => "0",
        "ConfigHolidayCreatedAt" => CURRENT_DATE_TIME,
        "ConfigHolidayUpdatedAt" => CURRENT_DATE_TIME,
        "ConfigHolidayUpdatedBy" => 0
      ];
      $Save = INSERT("config_holidays", $config_holidays);
    }
  }
}
