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
    // Check if ISBN is provided in the URL parameters
    if (isset($_GET["id"])) {
        // Get ISBN from the URL parameters
        $isbnID = $_GET["id"];

        // SQL query to fetch book data by ISBN
        $select_sql = "SELECT b.*, p.Name AS PublisherName, GROUP_CONCAT(a.Name SEPARATOR ', ') AS AuthorNames 
                        FROM books b 
                        LEFT JOIN publishers p ON b.PublisherId = p.PublisherID 
                        LEFT JOIN books_authors ba ON b.ISBN = ba.ISBN 
                        LEFT JOIN authors a ON ba.AuthorId = a.authorID 
                        WHERE b.ISBN = ?
                        GROUP BY b.ISBN";
        $stmt = $conn->prepare($select_sql);
        $stmt->bind_param("s", $isbnID );
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Book data found
            $book = $result->fetch_assoc();
            http_response_code(200);
            echo json_encode($book);
        } else {
            // No book data found
            http_response_code(404);
            $response = array("success" => false, "message" => "Book not found");
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // ISBN not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "ISBN not provided in URL parameters");
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