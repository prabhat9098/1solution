<?php
// Include the database configuration file
require_once 'config.php';

// Set headers to allow cross-origin requests and specify JSON content type
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if ISBN, Title, PublicationDate, Genre, PublisherId, and AuthorIds are provided in the form data
    if (isset($_POST["ISBN"]) && isset($_POST["Title"]) && isset($_POST["PublicationDate"]) && isset($_POST["Genre"]) && isset($_POST["PublisherId"]) && isset($_POST["AuthorIds"])) {
        // Get form data
        $ISBN = $_POST["ISBN"];
        $Title = $_POST["Title"];
        $PublicationDate = $_POST["PublicationDate"];
        $Genre = $_POST["Genre"];
        $PublisherId = $_POST["PublisherId"];
        $AuthorIds = explode(",", $_POST["AuthorIds"]); // Split author IDs into an array

        // SQL query to insert data into books table
        $insert_sql = "INSERT INTO books (ISBN, Title, PublicationDate, Genre, PublisherId) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssss", $ISBN, $Title, $PublicationDate, $Genre, $PublisherId);

        if ($stmt->execute()) {
            // Book added successfully
            // Now, insert into book_authors table
            foreach ($AuthorIds as $AuthorId) {
                // Trim whitespace from each AuthorId
                $AuthorId = trim($AuthorId);
                
                // Insert into book_authors table
                $insert_book_author_sql = "INSERT INTO books_authors (ISBN, AuthorId) VALUES (?, ?)";
                $stmt_book_author = $conn->prepare($insert_book_author_sql);
                $stmt_book_author->bind_param("ss", $ISBN, $AuthorId);
                $stmt_book_author->execute();
                $stmt_book_author->close();
            }
            
            http_response_code(201);
            $response = array("success" => true, "message" => "Book added successfully");
            echo json_encode($response);
        } else {
            // Error adding book
            http_response_code(400);
            $response = array("success" => false, "message" => "Error adding book: " . $stmt->error);
            echo json_encode($response);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Required fields not provided in the form data
        http_response_code(400);
        $response = array("success" => false, "message" => "ISBN, Title, PublicationDate, Genre, PublisherId, or AuthorIds not provided in form data");
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