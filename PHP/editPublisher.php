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
    // Check if PublisherID is provided in the URL parameters
    if (isset($_GET["id"])) {
        // Get PublisherID from the URL parameters
        $publisherID = $_GET["id"];

        // Decode JSON data from request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if Name, Address, or ContactInfo is provided in the request body
        if (isset($data["Name"]) || isset($data["Address"]) || isset($data["ContactInfo"])) {
            // Build SET clause for the update query
            $set_clause = "";
            if (isset($data["Name"])) {
                $set_clause .= "Name = '" . $data["Name"] . "'";
            }
            if (isset($data["Address"])) {
                $set_clause .= ($set_clause ? ", " : "") . "Address = '" . $data["Address"] . "'";
            }
            if (isset($data["ContactInfo"])) {
                $set_clause .= ($set_clause ? ", " : "") . "ContactInfo = '" . $data["ContactInfo"] . "'";
            }

            // SQL query to update publisher data by ID
            $update_sql = "UPDATE publishers SET $set_clause WHERE PublisherID = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("s", $publisherID);

            if ($stmt->execute()) {
                // Publisher data updated successfully
                http_response_code(200);
                $response = array("success" => true, "message" => "Publisher updated successfully");
                echo json_encode($response);
            } else {
                // Error updating publisher data
                http_response_code(400);
                $response = array("success" => false, "message" => "Error updating publisher: " . $stmt->error);
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Name, Address, or ContactInfo not provided in the request body
            http_response_code(400);
            $response = array("success" => false, "message" => "Name, Address, or ContactInfo not provided in request body");
            echo json_encode($response);
        }
    } else {
        // PublisherID not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "PublisherID not provided in URL parameters");
        echo json_encode($response);
    }
} else {
    // If request method is not PUT or PATCH
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}
?>
