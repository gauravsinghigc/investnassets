<?php
// Define database connection constants
define("DB_SERVER_HOST", "localhost");
define("DB_SERVER_USER", "u694216744_roofnassets");
define("DB_SERVER_PASS", "Navix@9810895713");
define("DB_SERVER_DB_NAME", "u694216744_roofnassets");

// Create connection
$conn = new mysqli(DB_SERVER_HOST, DB_SERVER_USER, DB_SERVER_PASS, DB_SERVER_DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postData = file_get_contents("php://input");
if ($postData) {
    $requestData = json_decode($postData, true);

    // Check if the JSON decoding was successful
    if ($requestData !== null) {
        $CurrentDate = $requestData['CurrentDate'] ?? '';
        $CurrentTime = $requestData['CurrentTime'] ?? '';
        $CurrentDateTime = $requestData['CurrentDateTime'] ?? '';
        $UserId = $requestData['UserId'] ?? '';
        $Latitude = $requestData['Latitude'] ?? '';
        $Longitude = $requestData['Longitude'] ?? '';
        $DeviceInfo = $requestData['DeviceInfo'] ?? '';
        $IpAddress = $requestData['IpAddress'] ?? '';
        $AttendanceStatus = $requestData['AttendanceStatus'] ?? '';
        $OfficeStartTimeValue = 'OFFICE_START_TIME';
        $OfficeMaxStartTimeValue = 'OFFICE_MAX_START_TIME';
        $OfficeMInAttandanceRange = 'MINIMUM_ATTANDANCE_RANGE';
        $OfficeShortLeaveMaxTimeValue = 'SHORT_LEAVE_MAX_TIME';
        $OfficeEndTimeValue = 'OFFICE_END_TIME';
        if ($AttendanceStatus == 'PunchIn') {

            //Office Start Time
            $OfficeStartTime = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt1 = $conn->prepare($OfficeStartTime);
            $stmt1->bind_param("s", $OfficeStartTimeValue);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $row = $result1->fetch_assoc(); // Corrected variable name
            $OfficeStartTimeConfigValue = $row['configurationvalue'];

            //Office Max Start Time
            $OfficeMaxStartTime = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt2 = $conn->prepare($OfficeMaxStartTime); // Changed variable name for statement
            $stmt2->bind_param("s", $OfficeMaxStartTimeValue);
            $stmt2->execute();
            $result2 = $stmt2->get_result(); // Changed variable name for result
            $row = $result2->fetch_assoc(); // Corrected variable name
            $OfficeMaxStartTimeConfigValue = $row['configurationvalue'];


            //Office Min Attendance Ranges
            $OfficeMinAttendanceRanges = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt3 = $conn->prepare($OfficeMinAttendanceRanges); // Changed variable name for statement
            $stmt3->bind_param("s", $OfficeMInAttandanceRange); // Changed variable name for binding
            $stmt3->execute();
            $result3 = $stmt3->get_result(); // Changed variable name for result
            $row = $result3->fetch_assoc(); // Corrected variable name
            $OfficeMinAttendanceRangeConfigValue = $row['configurationvalue'];

            // User Employ Location Office
            $CheckEmployLocationId = "SELECT UserEmpLocations FROM user_employment_details where UserMainUserId=?";
            $stmt1 = $conn->prepare($CheckEmployLocationId);
            $stmt1->bind_param("s", $UserId);
            $stmt1->execute();
            $results = $stmt1->get_result();
            $row = $results->fetch_assoc(); // Corrected variable name
            $UserEmpLocationsIdConfigValue = $row['UserEmpLocations'];

            if (!empty($UserEmpLocationsIdConfigValue)) {
                $OfficeLang = "SELECT config_location_Longitude FROM config_locations where config_location_id=?";
                $stmt1 = $conn->prepare($OfficeLang);
                $stmt1->bind_param("s", $UserEmpLocationsIdConfigValue);
                $stmt1->execute();
                $results = $stmt1->get_result();
                $row = $results->fetch_assoc(); // Corrected variable name
                $UserEmpOfficeLangConfigValue = $row['config_location_Longitude'];

                $OfficeLat = "SELECT config_location_Latitude FROM config_locations where config_location_id=?";
                $stmt1 = $conn->prepare($OfficeLat);
                $stmt1->bind_param("s", $UserEmpLocationsIdConfigValue);
                $stmt1->execute();
                $results = $stmt1->get_result();
                $row = $results->fetch_assoc(); // Corrected variable name
                $UserEmpOfficeLongConfigValue = $row['config_location_Latitude'];
                if (!function_exists('deg2rad')) {
                    function deg2rad($deg)
                    {
                        return $deg * (pi() / 180);
                    }
                }
                $R = 6371;
                $dLat = deg2rad($Latitude - $UserEmpOfficeLangConfigValue); // Difference in latitude
                $dLon = deg2rad($Longitude - $UserEmpOfficeLongConfigValue); // Difference in longitude

                $a = sin($dLat / 2) * sin($dLat / 2) +
                    cos(deg2rad($UserEmpOfficeLangConfigValue)) * cos(deg2rad($Latitude)) *
                    sin($dLon / 2) * sin($dLon / 2);

                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $difference = $R * $c; // Distance in kilometers
                $Distance = number_format($difference, 3);
            } else {
                $Distance = "0";
            }

            if ($Distance <= $OfficeMinAttendanceRangeConfigValue) {
                $check_in_status = "true";
            } else {
                $check_in_status = "false";
            }

            //check attandance time
            if ($CurrentTime >= $OfficeStartTimeConfigValue && $CurrentTime <= $OfficeMaxStartTimeConfigValue) {

                // Person is between the start time and max start time
                $CheckCurrentDateCheckIn = "SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)=? and check_in_main_user_id=?";
                $stmt1 = $conn->prepare($CheckCurrentDateCheckIn);
                $stmt1->bind_param("ss", $CurrentDate, $UserId);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if (empty($result1->num_rows)) {

                    // Check Holiday
                    $CheckCurrentDateHoliday = "SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)=?";
                    $stmt1 = $conn->prepare($CheckCurrentDateHoliday);
                    $stmt1->bind_param("s", $CurrentDate);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    if (empty($result1->num_rows)) {

                        $query2 = "INSERT INTO user_attandance_check_in (check_in_main_user_id, check_in_location_longitude, check_in_location_latitude, check_in_date_time, check_in_ip_address, check_in_device_info, check_in_created_at, check_in_created_by, check_in_status, check_in_distance, check_in_time_status) VALUES ('$UserId', '$Longitude', '$Latitude', '$CurrentDateTime', '$IpAddress', '$DeviceInfo', '$CurrentDateTime', '$UserId', '$check_in_status', '$Distance', 'true')";
                        $stmt = $conn->prepare($query2);
                        $stmt->execute();
                        // Check for successful insertion
                        if ($stmt->affected_rows > 0) {
                            $response = array(
                                "status" => "success",
                                "data" => array(
                                    array(
                                        "message" => "Punch-In recorded!  Congrats you are on Time!! Good Morning! Have a nice day!!",
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        } else {
                            $response = array(
                                "status" => "success",
                                "data" => array(
                                    array(
                                        "message" => "Something went wrong!! Please try again later",
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        }
                    } else {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "Already Check In",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "Already Check In",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                }


                //if ealry come
            } elseif ($CurrentTime <= $OfficeStartTimeConfigValue) {
                //Person is come to early or befor start time
                $CheckCurrentDateCheckIn = "SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)=? and check_in_main_user_id=?";
                $stmt1 = $conn->prepare($CheckCurrentDateCheckIn);
                $stmt1->bind_param("ss", $CurrentDate, $UserId);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if (empty($result1->num_rows)) {
                    // Check Holiday
                    $CheckCurrentDateHoliday = "SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)=?";
                    $stmt1 = $conn->prepare($CheckCurrentDateHoliday);
                    $stmt1->bind_param("s", $CurrentDate);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    if (empty($result1->num_rows)) {
                        $query2 = "INSERT INTO user_attandance_check_in (check_in_main_user_id, check_in_location_longitude, check_in_location_latitude, check_in_date_time, check_in_ip_address, check_in_device_info, check_in_created_at, check_in_created_by, check_in_status, check_in_distance, check_in_time_status) VALUES ('$UserId', '$Longitude', '$Latitude', '$CurrentDateTime', '$IpAddress', '$DeviceInfo', '$CurrentDateTime', '$UserId', '$check_in_status', '$Distance', 'true')";
                        $stmt = $conn->prepare($query2);
                        $stmt->execute();
                        // Check for successful insertion
                        if ($stmt->affected_rows > 0) {
                            $response = array(
                                "status" => "success",
                                "data" => array(
                                    array(
                                        "message" => "Punch-In recorded!  Congrats you are on Time!! Good Morning! Have a nice day!!",
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        } else {
                            $response = array(
                                "status" => "error",
                                "data" => array(
                                    array(
                                        "message" => "Something went wrong!! Please try again later",
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        }
                    } else {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "Already Punch In",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "Already Punch In",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                }

                // Person is outside the office hours
            } else {

                //check if their is any OD request for current date or not
                $CheckAvailableODRequests = "SELECT * FROM od_forms where DATE(OdRequestDate)=? and ODFormStatus!='REJECTED' and ODFormStatus!='COMPLETED' and OdMainUserId=?";
                $stmt1 = $conn->prepare($CheckAvailableODRequests);
                $stmt1->bind_param("ss", $CurrentDate, $UserId);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if (empty($result1->num_rows)) {

                    $CheckCurrentDateCheckIn = "SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)=? and check_in_main_user_id=?";
                    $stmt1 = $conn->prepare($CheckCurrentDateCheckIn);
                    $stmt1->bind_param("ss", $CurrentDate, $UserId);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    if (empty($result1->num_rows)) {
                        // Check Holiday
                        $CheckCurrentDateHoliday = "SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)=?";
                        $stmt1 = $conn->prepare($CheckCurrentDateHoliday);
                        $stmt1->bind_param("s", $CurrentDate);
                        $stmt1->execute();
                        $result1 = $stmt1->get_result();
                        if (empty($result1->num_rows)) {
                            $query2 = "INSERT INTO user_attandance_check_in (check_in_main_user_id, check_in_location_longitude, check_in_location_latitude, check_in_date_time, check_in_ip_address, check_in_device_info, check_in_created_at, check_in_created_by, check_in_status, check_in_distance, check_in_time_status) VALUES ('$UserId', '$Longitude', '$Latitude', '$CurrentDateTime', '$IpAddress', '$DeviceInfo', '$CurrentDateTime', '$UserId', '$check_in_status', '$Distance', 'LATE')";
                            $stmt = $conn->prepare($query2);
                            $stmt->execute();
                            // Check for successful insertion
                            if ($stmt->affected_rows > 0) {
                                $response = array(
                                    "status" => "success",
                                    "data" => array(
                                        array(
                                            "message" => "Punch-In recorded!  Congrats you are on Time!! Good Morning! Have a nice day!!",
                                        )
                                    )
                                );
                                echo json_encode($response);
                                die;
                            } else {
                                $response = array(
                                    "status" => "error",
                                    "data" => array(
                                        array(
                                            "message" => "Something went wrong!! Please try again later",
                                        )
                                    )
                                );
                                echo json_encode($response);
                                die;
                            }
                        } else {
                            $response = array(
                                "status" => "success",
                                "data" => array(
                                    array(
                                        "message" => "Already Punch In",
                                    )
                                ),
                            );
                            echo json_encode($response);
                            die;
                        }
                    } else {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "Already Punch In",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "You have an active OD Request for today please review it!",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                }
            }
        } elseif ($AttendanceStatus == 'PunchOut') {
            //Short Leave Time
            $OfficeShortTime = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt1 = $conn->prepare($OfficeShortTime);
            $stmt1->bind_param("s", $OfficeShortLeaveMaxTimeValue);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $row = $result1->fetch_assoc(); // Corrected variable name
            $OfficeShortTimeConfigValue = $row['configurationvalue'];

            //Office End Time
            $OfficeEndTime = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt2 = $conn->prepare($OfficeEndTime); // Changed variable name for statement
            $stmt2->bind_param("s", $OfficeEndTimeValue);
            $stmt2->execute();
            $result2 = $stmt2->get_result(); // Changed variable name for result
            $row = $result2->fetch_assoc(); // Corrected variable name
            $OfficeEndTimeConfigValue = $row['configurationvalue'];

            //Office Min Attendance Ranges
            $OfficeMinAttendanceRanges = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname=?";
            $stmt3 = $conn->prepare($OfficeMinAttendanceRanges); // Changed variable name for statement
            $stmt3->bind_param("s", $OfficeMInAttandanceRange); // Changed variable name for binding
            $stmt3->execute();
            $result3 = $stmt3->get_result(); // Changed variable name for result
            $row = $result3->fetch_assoc(); // Corrected variable name
            $OfficeMinAttendanceRangeConfigValue = $row['configurationvalue'];

            // User Employ Location Office
            $CheckEmployLocationId = "SELECT UserEmpLocations FROM user_employment_details where UserMainUserId=?";
            $stmt1 = $conn->prepare($CheckEmployLocationId);
            $stmt1->bind_param("s", $UserId);
            $stmt1->execute();
            $results = $stmt1->get_result();
            $row = $results->fetch_assoc(); // Corrected variable name
            $UserEmpLocationsIdConfigValue = $row['UserEmpLocations'];

            if (!empty($UserEmpLocationsIdConfigValue)) {
                $OfficeLang = "SELECT config_location_Longitude FROM config_locations where config_location_id=?";
                $stmt1 = $conn->prepare($OfficeLang);
                $stmt1->bind_param("s", $UserEmpLocationsIdConfigValue);
                $stmt1->execute();
                $results = $stmt1->get_result();
                $row = $results->fetch_assoc(); // Corrected variable name
                $UserEmpOfficeLangConfigValue = $row['config_location_Longitude'];

                $OfficeLat = "SELECT config_location_Latitude FROM config_locations where config_location_id=?";
                $stmt1 = $conn->prepare($OfficeLat);
                $stmt1->bind_param("s", $UserEmpLocationsIdConfigValue);
                $stmt1->execute();
                $results = $stmt1->get_result();
                $row = $results->fetch_assoc(); // Corrected variable name
                $UserEmpOfficeLongConfigValue = $row['config_location_Latitude'];
                if (!function_exists('deg2rad')) {
                    function deg2rad($deg)
                    {
                        return $deg * (pi() / 180);
                    }
                }
                $R = 6371;
                $dLat = deg2rad($Latitude - $UserEmpOfficeLangConfigValue); // Difference in latitude
                $dLon = deg2rad($Longitude - $UserEmpOfficeLongConfigValue); // Difference in longitude

                $a = sin($dLat / 2) * sin($dLat / 2) +
                    cos(deg2rad($UserEmpOfficeLangConfigValue)) * cos(deg2rad($Latitude)) *
                    sin($dLon / 2) * sin($dLon / 2);

                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $difference = $R * $c; // Distance in kilometers
                $Distance = number_format($difference, 3);
            } else {
                $Distance = "0";
            }

            if ($Distance <= $OfficeMinAttendanceRangeConfigValue) {
                $check_in_status = "true";
            } else {
                $check_in_status = "false";
            }

            //if user check-out before the office minimum end time
            //early going to home or before minimum end time
            if ($CurrentTime < $OfficeShortTimeConfigValue) {
                $status = "HALF";
                $Msg = "Punch-Out recorded and you are early going! We added this as a half day for today. if have issue with this you can contact this to your HR!";

                //leaving office on minimum punch-out time or as a short leave
            } else if ($CurrentTime < $OfficeEndTimeConfigValue && $CurrentTime > $OfficeShortTimeConfigValue) {
                $status = "SHORT";
                $Msg = "Punch-Out recorded and you are early going! We added this as a short leave for today. if have issue with this you can contact this to your HR!";

                //leaving/check-out on time
            } else {
                $status = "true";
                $Msg = "Punch-Out recorded! You are leaving on time! Good Night!";
            }

            //check already check-out
            $CheckCurrentDateCheckOut = "SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)=? and check_out_main_user_id=?";
            $stmt1 = $conn->prepare($CheckCurrentDateCheckOut);
            $stmt1->bind_param("ss", $CurrentDate, $UserId);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            if (empty($result1->num_rows)) {
                // Check Holiday
                $CheckCurrentDateHoliday = "SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)=?";
                $stmt1 = $conn->prepare($CheckCurrentDateHoliday);
                $stmt1->bind_param("s", $CurrentDate);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if (empty($result1->num_rows)) {
                    //Check In id
                    $CheckCheckId = "SELECT check_in_id FROM user_attandance_check_in WHERE check_in_main_user_id=? AND DATE(check_in_date_time)=?";
                    $stmt1 = $conn->prepare($CheckCheckId);
                    $stmt1->bind_param("is", $UserId, $CurrentDate);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    $row = $result1->fetch_assoc(); // Corrected variable name
                    $CheckInIdValue = $row['check_in_id'];

                    if (!empty($CheckInIdValue)) {
                        $query2 = "INSERT INTO user_attandance_check_out (check_out_main_user_id, check_out_location_longitude, check_out_location_latitude, check_out_date_time, check_out_ip_address, check_out_device_info, check_out_created_at, check_out_created_by, check_out_status, check_out_distance, check_out_time_status,check_out_main_check_in_id) VALUES ('$UserId', '$Longitude', '$Latitude', '$CurrentDateTime', '$IpAddress', '$DeviceInfo', '$CurrentDateTime', '$UserId', '$check_in_status', '$Distance', '$status','304')";
                        $stmt = $conn->prepare($query2);
                        $stmt->execute();
                        // Check for successful insertion
                        if ($stmt->affected_rows > 0) {
                            $response = array(
                                "status" => "success",
                                "data" => array(
                                    array(
                                        "message" => $Msg,
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        } else {
                            $response = array(
                                "status" => "error",
                                "data" => array(
                                    array(
                                        "message" => "Something went wrong!! Please try again later",
                                    )
                                )
                            );
                            echo json_encode($response);
                            die;
                        }
                    } else {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "Something went wrong!! Please try aging later",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "Already Punch Out",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                }
            } else {
                $response = array(
                    "status" => "success",
                    "data" => array(
                        array(
                            "message" => "Already Punch Out",
                        )
                    ),
                );
                echo json_encode($response);
                die;
            }
        } else {
            $response = array(
                "status" => "success",
                "data" => array(
                    array(
                        "message" => "Already Punch In",
                    )
                ),
            );
            echo json_encode($response);
            die;
        }
    }
} else {
    // No POST data received
    $response = array("status" => "error", "message" => "No POST data received");
    echo json_encode($response);
}

// Close connection
$conn->close();
