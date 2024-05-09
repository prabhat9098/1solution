<?php

// Check if student ID is provided
if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Student ID is required"));
    exit();
}

// Get ID from GET request
$id = $_GET['id'];

// SQL query to fetch student by ID
$sql = "SELECT * FROM Students WHERE StudentID='$id'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch result row as associative array
    $student = $result->fetch_assoc();
    // Return student data as JSON
    http_response_code(200); // OK
    header('Content-Type: application/json');
    echo json_encode($student);
} else {
    http_response_code(404); // Not Found
    echo json_encode(array("message" => "Student not found"));
}

?>
