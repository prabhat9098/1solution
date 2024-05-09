<?php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "Prabhat@123";
$database = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
