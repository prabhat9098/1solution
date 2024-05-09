<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is PUT or PATCH
if ($_SERVER["REQUEST_METHOD"] == "PUT" || $_SERVER["REQUEST_METHOD"] == "PATCH") {
    // Check if authorID is provided in the URL parameters
    if (isset($_GET["id"])) {
        // Get authorID from the URL parameters
        $authorID = $_GET["id"];

        // Decode JSON data from request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if name or biography is provided in the request body
        if (isset($data["name"]) || isset($data["biography"])) {
            // Build SET clause for the update query
            $set_clause = "";
            if (isset($data["name"])) {
                $set_clause .= "name = '" . $data["name"] . "'";
            }
            if (isset($data["biography"])) {
                $set_clause .= ($set_clause ? ", " : "") . "biography = '" . $data["biography"] . "'";
            }

            // SQL query to update author data by ID
            $update_sql = "UPDATE Authors SET $set_clause WHERE authorID = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("s", $authorID);

            if ($stmt->execute()) {
                // Author data updated successfully
                http_response_code(200);
                $response = array("success" => true, "message" => "Author updated successfully");
                echo json_encode($response);
            } else {
                // Error updating author data
                http_response_code(400);
                $response = array("success" => false, "message" => "Error updating author: " . $stmt->error);
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Name or biography not provided in the request body
            http_response_code(400);
            $response = array("success" => false, "message" => "Name or biography not provided in request body");
            echo json_encode($response);
        }
    } else {
        // authorID not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "authorID not provided in URL parameters");
        echo json_encode($response);
    }
} else {
    // If request method is not PUT or PATCH
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}



?>
