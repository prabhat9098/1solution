<?php
// Include the database configuration file
require_once 'config.php';

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Check if StudentID, ISBN, BorrowingDate, ReturnDate, and Fine are provided in the form data
    if (isset($_POST["StudentID"]) && isset($_POST["ISBN"]) && isset($_POST["BorrowingDate"]) && isset($_POST["ReturnDate"]) && isset($_POST["Fine"])) {
        // Get StudentID, ISBN, BorrowingDate, ReturnDate, and Fine from the form data
        $StudentID = $_POST["StudentID"];
        $ISBN = $_POST["ISBN"];
        $BorrowingDate = $_POST["BorrowingDate"];
        $ReturnDate = $_POST["ReturnDate"];
        $Fine = $_POST["Fine"];

        // SQL query to insert data into borrowingrecords table
        $insert_sql = "INSERT INTO borrowingrecords (StudentID, ISBN, BorrowingDate, ReturnDate, Fine) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("issss", $StudentID, $ISBN, $BorrowingDate, $ReturnDate, $Fine);

        if ($stmt->execute()) {
            // Data added successfully
            http_response_code(201);
            $response = array("success" => true, "message" => "Data added successfully");
            echo json_encode($response);
        } else {
            // Error adding data
            http_response_code(400);
            $response = array("success" => false, "message" => "Error adding data: " . $stmt->error);
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Required data not provided in the form data
        http_response_code(400);
        $response = array("success" => false, "message" => "Required data not provided in form data");
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
