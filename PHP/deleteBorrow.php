<?php
// Include the database configuration file
require_once 'config.php';

// Check if the request method is DELETE
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Check if BorrowingID is provided in the request parameters
    if (isset($_GET["id"])) {
        // Get the BorrowingID from the request parameters
        $BorrowingID = $_GET["id"];

        // SQL query to delete data from the borrowingrecords table based on BorrowingID
        $delete_sql = "DELETE FROM borrowingrecords WHERE BorrowingID = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $BorrowingID);

        if ($stmt->execute()) {
            // Data deleted successfully
            http_response_code(200);
            $response = array("success" => true, "message" => "Data deleted successfully");
            echo json_encode($response);
        } else {
            // Error deleting data
            http_response_code(400);
            $response = array("success" => false, "message" => "Error deleting data: " . $stmt->error);
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // BorrowingID not provided in the request parameters
        http_response_code(400);
        echo json_encode(array("success" => false, "message" => "BorrowingID not provided in request parameters"));
    }
} else {
    // If request method is not DELETE
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

// Close database connection

?>
