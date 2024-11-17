<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

$AllUsers = _DB_COMMAND_("SELECT * FROM users ORDER BY UserId ASC", true);
if ($AllUsers != null) {
    foreach ($AllUsers as $Users) {

        //check users acccess provided or not
        $Check = CHECK("SELECT * FROM user_access where UserAccessUserId='" . $Users->UserId . "' and UserAccessName='" . $Users->UserType . "'");
        if ($Check == null) {

            $user_access = [
                "UserAccessUserId" => $Users->UserId,
                "UserAccessName" => $Users->UserType,
                "UserAccessCreatedAt" => CURRENT_DATE_TIME,
                "UserAccessStatus" => 1
            ];
            $Response = INSERT("user_access", $user_access);
            echo "=> " . "(" . $Users->UserId . ") " . $Users->UserFullName . " @ " . $Users->UserType . " { <b>Access Granted</b> }<br>";
        } else {
            echo "=> " . "(" . $Users->UserId . ") " . $Users->UserFullName . " @ " . $Users->UserType . " { <b>Access Exits</b> } <br>";
        }
    }
}
