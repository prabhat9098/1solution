<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if authorID, name, and biography are provided in the form data
    if (isset($_POST["authorID"]) && isset($_POST["name"]) && isset($_POST["biography"])) {
        // Get authorID, name, and biography from the form data
        $authorID = $_POST["authorID"];
        $name = $_POST["name"];
        $biography = $_POST["biography"];

        // SQL query to insert data into Authors table
        $insert_sql = "INSERT INTO Authors (authorID, name, biography) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sss", $authorID, $name, $biography);

        if ($stmt->execute()) {
            // Author added successfully
            http_response_code(201);
            $response = array("success" => true, "message" => "Author added successfully");
            echo json_encode($response);
        } else {
            // Error adding author
            http_response_code(400);
            $response = array("success" => false, "message" => "Error adding author: " . $stmt->error);
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // authorID, name, or biography not provided in the form data
        http_response_code(400);
        $response = array("success" => false, "message" => "authorID, name, or biography not provided in form data");
        echo json_encode($response);
    }
} else {
    // If request method is not POST
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection


?>
