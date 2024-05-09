<?php
// add_student.php

// Check if all required data is present
if (!isset($_POST['student_id']) || !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['address'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing required data: student_id, name, email, address"));
    exit();
}

// Get data from POST request
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];

// Check if any data is empty
if (empty($student_id)) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing or empty data: student_id"));
    exit();
}

if (empty($name)) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing or empty data: name"));
    exit();
}

if (empty($email)) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing or empty data: email"));
    exit();
}

if (empty($address)) {
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Missing or empty data: address"));
    exit();
}

// SQL query to insert student data
$sql = "INSERT INTO Students (StudentID, Name, Email, Address) VALUES ('$student_id', '$name', '$email', '$address')";

// Execute query
if ($conn->query($sql) === TRUE) {
    http_response_code(201); // Created
    echo json_encode(array("message" => "New student added successfully"));
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
}

