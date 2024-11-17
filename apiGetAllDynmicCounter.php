<?php
// Define database connection constants
DEFINE("DB_SERVER_HOST", "localhost");
DEFINE("DB_SERVER_USER", "inve_inve_investnassets");
DEFINE("DB_SERVER_PASS", "Navix@9810");
DEFINE("DB_SERVER_DB_NAME", "inve_inve_investnassets");
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
        $counterType = $requestData['counterType'] ;
        if(!empty($counterType)){
            // Define the SQL query
            $query1 = "SELECT * FROM config_lead_counters WHERE CompanyID='$companyMainId'";
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
