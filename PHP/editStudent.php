<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is PUT
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Check if student ID is provided in the URL parameters
    if (isset($_GET["student_id"])) {
        // Get student ID from the URL parameters
        $student_id = $_GET["student_id"];

        // Decode JSON data from request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if name, email, and address are provided in the request body
        if (isset($data["name"]) && isset($data["email"]) && isset($data["address"])) {
            // Get data from the request body
            $name = $data["name"];
            $email = $data["email"];
            $address = $data["address"];

            // Prepare SQL query to update data in students table
            $update_sql = "UPDATE students SET Name = ?, Email = ?, Address = ? WHERE StudentID = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssi", $name, $email, $address, $student_id);

            if ($stmt->execute()) {
                // Student updated successfully
                http_response_code(200);
                $response = array("success" => true, "message" => "Student updated successfully");
                echo json_encode($response);
            } else {
                // Error updating student
                http_response_code(400);
                $response = array("success" => false, "message" => "Error updating student: " . $stmt->error);
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Required fields not provided in the request body
            http_response_code(400);
            $response = array("success" => false, "message" => "Name, email, or address not provided in request body");
            echo json_encode($response);
        }
    } else {
        // Student ID not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "Student ID not provided in URL parameters");
        echo json_encode($response);
    }
} else {
    // If request method is not PUT
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}

?>
