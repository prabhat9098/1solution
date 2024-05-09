<?php
// Include the database configuration file
require_once 'config.php';

// SQL query to fetch all data from the borrowingrecords table
$sql = "SELECT * FROM borrowingrecords";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Array to hold the results
    $borrowingRecords = array();

    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        // Add the row to the array
        $borrowingRecords[] = $row;
    }

    // Return the JSON response
    http_response_code(200);
    echo json_encode(array("success" => true, "data" => $borrowingRecords));
} else {
    // No rows found
    http_response_code(404);
    echo json_encode(array("success" => false, "message" => "No data found"));
}

// Close database connection

?>
