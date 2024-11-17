<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

$FetchAllUsers = _DB_COMMAND_("SELECT UserId, UserCreatedAt, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC", true);
if ($FetchAllUsers != null) {
    foreach ($FetchAllUsers as $Users) {
        $ReqId = $Users->UserId;
        $payrolls_from_date = DATE("Y-m-d", strtotime("2024-02-01"));
        $payrolls_to_date = DATE("Y-m-d", strtotime("2024-02-29"));
        $PayrollSQL = "SELECT payrolls_main_user_id, payrolls_id FROM payrolls where payrolls_status='CLOSED' and payrolls_main_user_id='$ReqId' and DATE(payrolls_from_date)='$payrolls_from_date' and DATE(payrolls_to_date)='$payrolls_to_date'";
        $CheckExistingPayroll = CHECK($PayrollSQL);
        if ($CheckExistingPayroll != null) {
            $PayrollId = FETCH($PayrollSQL, "payrolls_id");
            DELETE_FROM("payrolls", "payrolls_status='CLOSED' and payrolls_main_user_id='$ReqId' and DATE(payrolls_from_date)='$payrolls_from_date' and DATE(payrolls_to_date)='$payrolls_to_date'");
            DELETE_FROM("payroll_allowances", "payroll_main_id='$PayrollId'");
            DELETE_FROM("payroll_deductions", "payroll_main_id='$PayrollId'");

            echo "@Removed----------(U:$ReqId)--<br>";
        } else {
            echo "@Failed-----------(U:$ReqId)--<br>";
        }
    }
} else {
    echo "false";
}
