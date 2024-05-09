<?php

// Include the database connection
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include 'createStudent.php';

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
       include 'getStudentById.php';
    } else {
      include 'getStudents.php';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    include 'editStudent.php';
  
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
   include 'deleteStudent.php';
}

$conn->close();
?>