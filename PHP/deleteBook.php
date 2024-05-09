<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is DELETE
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Check if authorID is provided in the URL parameters
    if (isset($_GET["id"])) {
        // Get authorID from the URL parameters
        $isbnID = $_GET["id"];

        // SQL query to delete author data by ID
        $delete_sql = "DELETE FROM Books WHERE ISBN = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("s", $isbnID);

        if ($stmt->execute()) {
            // Author data deleted successfully
            http_response_code(200);
            $response = array("success" => true, "message" => "Books deleted successfully");
            echo json_encode($response);
        } else {
            // Error deleting author data
            http_response_code(400);
            $response = array("success" => false, "message" => "Error deleting Book: " . $stmt->error);
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // authorID not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "ISBNID not provided in URL parameters");
        echo json_encode($response);
    }
} else {
    // If request method is not DELETE
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}



?>
