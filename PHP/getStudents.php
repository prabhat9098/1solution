<?php


// SQL query to fetch all students
$sql = "SELECT * FROM Students";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch result rows as associative array
    $students = array();
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    // Return students data as JSON
    http_response_code(200); // OK
    header('Content-Type: application/json');
    echo json_encode($students);
} else {
    http_response_code(404); // Not Found
    echo json_encode(array("message" => "No students found"));
}

?>
