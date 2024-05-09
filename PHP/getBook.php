<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // SQL query to fetch book details along with publisher and authors
    $select_sql = "SELECT b.*, p.Name AS PublisherName, GROUP_CONCAT(a.Name SEPARATOR ', ') AS AuthorNames 
                    FROM books b 
                    LEFT JOIN publishers p ON b.PublisherId = p.PublisherID 
                    LEFT JOIN books_authors ba ON b.ISBN = ba.ISBN 
                    LEFT JOIN authors a ON ba.AuthorId = a.authorID 
                    GROUP BY b.ISBN";
    $result = $conn->query($select_sql);

    if ($result === false) {
        // Error in SQL query
        http_response_code(500);
        $response = array("success" => false, "message" => "Error in SQL query: " . $conn->error);
        echo json_encode($response);
    } elseif ($result->num_rows > 0) {
        // Books data found
        $books = array();
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        http_response_code(200);
        echo json_encode($books);
    } else {
        // No books data found
        http_response_code(404);
        $response = array("success" => false, "message" => "No Books found");
        echo json_encode($response);
    }
} else {
    // If request method is not GET
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection

?>