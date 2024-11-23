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
        $companyMainId = $requestData['companyMainId'] ?? '';
        $formType = $requestData['formType'] ;
        if(!empty($formType)){
            // Define the SQL query
            $query1 = "SELECT ConfigValueDetails FROM configs as c LEFT JOIN config_values as cv ON cv.ConfigValueGroupId =c.ConfigsId  WHERE c.ConfigGroupName='CALL_STATUS' AND cv.CompanyID='$companyMainId'";
               // Execute the queries
            $result1 = $conn->query($query1);
            // Initialize an empty array to store the combined data
            $data = array();
            // Check if any rows were returned from the first query
            if ($result1) {
                // Fetch data and add it to the combined array
                while ($row = $result1->fetch_assoc()) {
                    $data[] = $row;
                }
            }

             // Check if any data was retrieved
            if (!empty($data)) {
                // Convert the array to JSON format
                $response = array("status" => "success", "data" => $data);
            } else {
               $response = array(
                                    "status" => "error",
                                    "data" => array(
                                        array(
                                            "error" => "No data found",
            
                                                                )
                                                            )
                                                        );
            }
             // Output the JSON response
            echo json_encode($response);
        }else{
             
               $response = array(
                                    "status" => "error",
                                    "data" => array(
                                        array(
                                            "error" => "No data found",
            
                                                                )
                                                            )
                                                        );
            echo json_encode($response);
        }
       
         
        
    } 
    else {
       
         $response = array(
                                    "status" => "error",
                                    "data" => array(
                                        array(
                                            "error" => "No data found",
            
                                                                )
                                                            )
                                                        );
        echo json_encode($response);
    }
} else {
     $response = array(
                                    "status" => "error",
                                    "data" => array(
                                        array(
                                            "error" => "No data found",
            
                                                                )
                                                            )
                                                        );
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
