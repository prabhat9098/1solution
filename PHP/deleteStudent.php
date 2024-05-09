<?php
// delete_student.php

// Check if student ID is provided
if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Student ID is required"));
    exit();
}

// Get ID from DELETE request
$id = $_GET['id'];

// SQL query to delete student by ID
$sql = "DELETE FROM Students WHERE StudentID='$id'";

// Execute query
if ($conn->query($sql) === TRUE) {
    http_response_code(200); // OK
    echo json_encode(array("message" => "Student deleted successfully"));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error deleting student: " . $conn->error));
}

?>
