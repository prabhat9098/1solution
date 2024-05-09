<?php
// Include the database configuration file
require_once 'config.php';

// Check if the request method is PUT
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Check if BorrowingID is provided in the request parameters
    if (isset($_GET["id"])) {
        // Get the BorrowingID from the request parameters
        $BorrowingID = $_GET["id"];

        // Get JSON data from the request body
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        // Check if JSON data is decoded successfully
        if ($data !== null) {
            // Extract data from JSON
            $StudentID = $data["StudentID"];
            $ISBN = $data["ISBN"];
            $BorrowingDate = $data["BorrowingDate"];
            $ReturnDate = $data["ReturnDate"];
            $Fine = $data["Fine"];

            // SQL query to update data in the borrowingrecords table
            $update_sql = "UPDATE borrowingrecords SET StudentID=?, ISBN=?, BorrowingDate=?, ReturnDate=?, Fine=? WHERE BorrowingID=?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("issssi", $StudentID, $ISBN, $BorrowingDate, $ReturnDate, $Fine, $BorrowingID);

            if ($stmt->execute()) {
                // Data updated successfully
                http_response_code(200);
                $response = array("success" => true, "message" => "Data updated successfully");
                echo json_encode($response);
            } else {
                // Error updating data
                http_response_code(400);
                $response = array("success" => false, "message" => "Error updating data: " . $stmt->error);
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Error decoding JSON data
            http_response_code(400);
            $response = array("success" => false, "message" => "Error decoding JSON data");
            echo json_encode($response);
        }
    } else {
        // BorrowingID not provided in the request parameters
        http_response_code(400);
        echo json_encode(array("success" => false, "message" => "BorrowingID not provided in request parameters"));
    }
} else {
    // If request method is not PUT
    http_response_code(400);
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

// Close database connection

?>
