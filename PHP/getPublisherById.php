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
    // Check if authorID is provided in the URL parameters
    if (isset($_GET["id"])) {
        // Get authorID from the URL parameters
        $authorID = $_GET["id"];

        // SQL query to fetch author data by ID
        $select_sql = "SELECT * FROM publishers WHERE PublisherID = ?";
        $stmt = $conn->prepare($select_sql);
        $stmt->bind_param("s", $authorID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Author data found
            $author = $result->fetch_assoc();
            http_response_code(200);
            echo json_encode($author);
        } else {
            // No author data found
            http_response_code(404);
            $response = array("success" => false, "message" => "Publisher not found");
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // authorID not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "authorID not provided in URL parameters");
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
