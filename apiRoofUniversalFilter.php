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
       
        $phoneNumber = $requestData['phoneNumber'] ?? '';
        $userId = $requestData['userId'] ?? '';
        
        if(!empty($phoneNumber)){
            // Define the SQL query
          $query1 = "SELECT * FROM leads AS l LEFT JOIN projects AS p ON p.ProjectsId = l.LeadProjectId WHERE l.LeadPersonManagedBy ='$userId' AND l.LeadPersonPhoneNumber LIKE '%$phoneNumber%'";
             
          $query2 = "SELECT * FROM data_leads AS dl 
            LEFT JOIN projects AS p ON p.ProjectsId = dl.LeadProjectId 
            WHERE dl.LeadPersonManagedBy ='$userId' AND dl.LeadPersonPhoneNumber LIKE '%$phoneNumber%'";  
            
            $query3 = "SELECT * FROM data_lead_uploads AS dlu 
            LEFT JOIN projects AS p ON p.ProjectsId = dlu.LeadProjectsRef 
            WHERE dlu.LeadsUploadedfor ='$userId' AND dlu.LeadsPhone LIKE '%$phoneNumber%'";  
            
            
               // Execute the queries
            $result1 = $conn->query($query1);
            $result2 = $conn->query($query2);
            $result3 = $conn->query($query3);

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
            
            // Check if any rows were returned from the second query
            if ($result3) {
                // Fetch data and add it to the combined array
                while ($row = $result3->fetch_assoc()) {
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
