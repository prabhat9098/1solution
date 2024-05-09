<?php
// Include the database configuration file
require_once 'config.php';

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if BorrowingID is provided in the request parameters
    if (isset($_GET["id"])) {
        // Get the BorrowingID from the request parameters
        $BorrowingID = $_GET["id"];

        // SQL query to fetch data from the borrowingrecords table based on BorrowingID
        $sql = "SELECT * FROM borrowingrecords WHERE BorrowingID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $BorrowingID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there is a row returned
        if ($result->num_rows > 0) {
            // Fetch the row as an associative array
            $borrowingRecord = $result->fetch_assoc();

            // Return the JSON response
            http_response_code(200);
            echo json_encode(array("success" => true, "data" => $borrowingRecord));
        } else {
            // No row found with the provided BorrowingID
            http_response_code(404);
            echo json_encode(array("success" => false, "message" => "No data found for BorrowingID: $BorrowingID"));
        }

        // Close the statement
        $stmt->close();
    } else {
        // BorrowingID not provided in the request parameters
        http_response_code(400);
        echo json_encode(array("success" => false, "message" => "BorrowingID not provided in request parameters"));
    }
} else {
    // If request method is not GET
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}


?>
