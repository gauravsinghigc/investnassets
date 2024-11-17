<?php
// Define database connection constants
define("DB_SERVER_HOST", "localhost");
define("DB_SERVER_USER", "shubham");
define("DB_SERVER_PASS", "2255");
define("DB_SERVER_DB_NAME", "roofnassest");

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

        $currentDate = $requestData['currentDate'] ?? '';
        $currentTime = $requestData['currentTime'] ?? '';
        $userId = $requestData['userId'] ?? '';

        if (!empty($currentDate)) {
            //check active OD Requests
            $CheckActiveODs = "SELECT OdRequestDate FROM od_forms where DATE(OdRequestDate)=? and ODFormStatus='ACTIVE' and OdMainUserId=?";
            $stmt1 = $conn->prepare($CheckActiveODs);
            $stmt1->bind_param("ss", $currentDate, $userId);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            if ($result1->num_rows > 0) {
                //check active meetings
                $ActiveMeetings = "SELECT user_meeting_status FROM user_meetings where user_meeting_status='ACTIVE' and user_main_user_id=? and DATE(user_meeting_date)=?";
                $stmt1 = $conn->prepare($ActiveMeetings);
                $stmt1->bind_param("ss", $userId, $currentDate);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if (empty($result1->num_rows)) {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "StartMeeting",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                } else {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "EndMeeting",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                }
            } else {
                $CheckLeaves = "SELECT UserLeaveStatus FROM user_leaves where DATE(UserLeaveFromDate)<=? and UserMainId=?  and UserLeaveStatus='ACTIVE'";
                $stmt1 = $conn->prepare($CheckLeaves);
                $stmt1->bind_param("ss", $currentDate, $userId);
                $stmt1->execute();
                $result1 = $stmt1->get_result();
                if ($result1->num_rows > 0) {
                    $response = array(
                        "status" => "success",
                        "data" => array(
                            array(
                                "message" => "OnLeave",
                            )
                        ),
                    );
                    echo json_encode($response);
                    die;
                } else {

                    $CheckTodayAttandance = "SELECT check_in_location_longitude FROM user_attandance_check_in WHERE check_in_main_user_id=? AND DATE(check_in_date_time)=?";
                    $stmt1 = $conn->prepare($CheckTodayAttandance);
                    $stmt1->bind_param("ss", $userId, $currentDate);
                    $stmt1->execute();
                    $result1 = $stmt1->get_result();
                    if (empty($result1->num_rows)) {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "PunchIn",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    } else {
                        $response = array(
                            "status" => "success",
                            "data" => array(
                                array(
                                    "message" => "PunchOut",
                                )
                            ),
                        );
                        echo json_encode($response);
                        die;
                    }
                }
            }
        }
    }
} else {
    // No POST data received
    $response = array("status" => "error", "message" => "No POST data received");
    echo json_encode($response);
}

// Close connection
$conn->close();
