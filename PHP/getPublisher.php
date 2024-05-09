<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // SQL query to fetch all data from Authors table
    $select_sql = "SELECT * FROM publishers";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        // Authors data found
        $authors = array();
        while ($row = $result->fetch_assoc()) {
            $authors[] = $row;
        }
        http_response_code(200);
        echo json_encode($authors);
    } else {
        // No authors data found
        http_response_code(404);
        $response = array("success" => false, "message" => "No Publisher found");
        echo json_encode($response);
    }
} else {
    // If request method is not GET
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection


?>
