<?php
// Define database connection constants
DEFINE("DB_SERVER_HOST", "localhost");
DEFINE("DB_SERVER_USER", "root");
DEFINE("DB_SERVER_PASS", "C6Hm5LkZR7HbGpg");
DEFINE("DB_SERVER_DB_NAME", "investnassets");
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
        $companyMainId = $requestData['companyMainId'] ?? '';

        // Validate input data (e.g., check for required fields)

        // Combine date and time strings
        $combinedDateTimeString = "$currentDate $currentTime";

        // Parse combined date and time string
        $currentDateTime = DateTime::createFromFormat('Y-m-d h:i A', $combinedDateTimeString);

        // Add 15 minutes
        $newDateTime = $currentDateTime->add(new DateInterval('PT15M'));

        // Format the new date and time
        $startTime = $newDateTime->format('h:i A');
 
        // Define the SQL query
        $query1 = "SELECT * FROM lead_followups AS lf 
                    LEFT JOIN leads AS l ON lf.LeadFollowMainId = l.LeadsId 
                    LEFT JOIN projects AS p ON p.ProjectsId = l.LeadProjectId 
                    WHERE lf.LeadFollowUpHandleBy = '$userId' 
                    AND l.CompanyID = '$companyMainId' 
                    AND lf.LeadFollowUpDate = '$currentDate' 
                    AND lf.LeadFollowUpRemindStatus = 'ACTIVE' 
                    AND (lf.LeadFollowUpTime >= '$currentTime' AND lf.LeadFollowUpTime <= '$startTime')";
                    
        $query2 = "SELECT * FROM data_lead_followups AS dlf 
            LEFT JOIN data_leads AS dl ON dlf.LeadFollowMainId = dl.LeadsId  
            LEFT JOIN projects AS p ON p.ProjectsId = dl.LeadProjectId 
            WHERE dlf.LeadFollowUpHandleBy ='$userId' 
            AND dl.CompanyID='$companyMainId' 
            AND dlf.LeadFollowUpDate = '$currentDate' 
            AND dlf.LeadFollowUpRemindStatus='ACTIVE' 
            AND (dlf.LeadFollowUpTime >= '$currentTime' AND dlf.LeadFollowUpTime <= '$startTime')";
            
            // Execute the queries
            $result1 = $conn->query($query1);
            $result2 = $conn->query($query2);

            // Initialize an empty array to store the combined data
            $data = array();
            // Check if any rows were returned from the first query
            if ($result1) {
                // Fetch data and add it to the combined array
                while ($row = $result1->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            // Check if any rows were returned from the second query
            if ($result2) {
                // Fetch data and add it to the combined array
                while ($row = $result2->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            // Check if any data was retrieved
            if (!empty($data)) {
                // Convert the array to JSON format
                $response = array("status" => "success", "data" => $data);
            } else {
               // Query execution failed
               $error = $conn->error;
                $response = array("status" => "error", "message" => "No data found:$error");
            }
            
            // Output the JSON response
            echo json_encode($response);
        
    } 
    else {
        // JSON decoding failed
        $response = array("status" => "error", "message" => "Failed to decode JSON data");
        echo json_encode($response);
    }
} else {
    // No POST data received
    $response = array("status" => "error", "message" => "No POST data received");
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
