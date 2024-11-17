<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

$YearMonth = "2024-02";
$StartDate = 1;
$EndDate = 29;

while ($StartDate <= $EndDate) {

    if ($StartDate < 10) {
        $StartDate = "0" . $StartDate;
    } else {
        $StartDate = $StartDate;
    }
    $IndateTime = "$YearMonth-$StartDate 11:00 PM";
    $OutdateTime = "$YearMonth-$StartDate 11:00 PM";
    $Instatus = "ABSANT";
    $Outstatus = "ABSANT";
    $RunningDate = DATE("Y-m-d", strtotime($IndateTime));

    //Auto Absant marking
    $FetchAllUsers = _DB_COMMAND_("SELECT UserId, UserCreatedAt, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC", true);
    if ($FetchAllUsers != null) {
        foreach ($FetchAllUsers as $Users) {
            $check_in_main_user_id = $Users->UserId;
            $check_out_main_user_id = $Users->UserId;
            $UserJoiningDate = $Users->UserCreatedAt;

            $RunningDate = DATE("Y-m-d", strtotime($RunningDate));
            $UserJoiningDate = DATE("Y-m-d", strtotime($UserJoiningDate));

            if ($RunningDate > $UserJoiningDate) {

                //get form details
                $user_attandance_check_in = [
                    "check_in_main_user_id" => $check_in_main_user_id,
                    "check_in_location_longitude" => "",
                    "check_in_location_latitude" => "",
                    "check_in_date_time" => $IndateTime,
                    "check_in_ip_address" => IP_ADDRESS,
                    "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
                    "check_in_created_at" => CURRENT_DATE_TIME,
                    "check_in_created_by" => "0",
                    "check_in_status" => "true",
                    "check_in_distance" => 0.1,
                    "check_in_time_status" => $Instatus,
                ];
                $IndateTime1 = DATE("Y-m-d", strtotime($IndateTime));
                $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$IndateTime1'");
                if ($CheckCurrentDateHoliday == null) {
                    $IFPunchInExists = CHECK("SELECT check_in_main_user_id, check_in_main_user_id FROM user_attandance_check_in where DATE(check_in_date_time)='$IndateTime1' and check_in_main_user_id='$check_in_main_user_id'");
                    if ($IFPunchInExists == null) {
                        INSERT("user_attandance_check_in", $user_attandance_check_in);

                        //add auto punchout
                        $user_attandance_check_out = [
                            "check_out_main_user_id" => $check_out_main_user_id,
                            "check_out_location_longitude" => "",
                            "check_out_location_latitude" => "",
                            "check_out_date_time" => $OutdateTime,
                            "check_out_ip_address" => IP_ADDRESS,
                            "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
                            "check_out_created_at" => CURRENT_DATE_TIME,
                            "check_out_created_by" => "0",
                            "check_out_status" => "true",
                            "check_out_distance" => "0.1",
                            "check_out_time_status" => $Outstatus,
                            "check_out_main_check_in_id" => FETCH("SELECT check_in_id FROM user_attandance_check_in where check_in_main_user_id='$check_out_main_user_id' and DATE(check_in_date_time)='$IndateTime'", "check_in_id"),
                        ];

                        $OutdateTime1 = DATE("Y-m-d", strtotime($OutdateTime));
                        //check if punch-in exists or not
                        $IFPunchInExists = CHECK("SELECT check_out_date_time, check_out_main_user_id FROM user_attandance_check_out where DATE(check_out_date_time)='$OutdateTime1' and check_out_main_user_id='$check_out_main_user_id'");
                        if ($IFPunchInExists == null) {
                            $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
                        }
                    }
                }
            }
        }
    }

    $StartDate = (int)$StartDate;
    $StartDate++;
}
