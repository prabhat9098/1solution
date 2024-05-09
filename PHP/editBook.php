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
    // Check if ISBN is provided in the URL parameters
    if (isset($_GET["ISBN"])) {
        // Get ISBN from the URL parameters
        $ISBN = $_GET["ISBN"];

        // Decode JSON data from request body
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if Title, PublicationDate, Genre, PublisherId, and AuthorIds are provided in the request body
        if (isset($data["Title"]) && isset($data["PublicationDate"]) && isset($data["Genre"]) && isset($data["PublisherId"]) && isset($data["AuthorIds"])) {
            // Get data from the request body
            $Title = $data["Title"];
            $PublicationDate = $data["PublicationDate"];
            $Genre = $data["Genre"];
            $PublisherId = $data["PublisherId"];
            $AuthorIds = explode(",", $data["AuthorIds"]); // Split author IDs into an array

            // Prepare SQL query to update data in books table
            $update_sql = "UPDATE books SET Title = ?, PublicationDate = ?, Genre = ?, PublisherId = ? WHERE ISBN = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("sssss", $Title, $PublicationDate, $Genre, $PublisherId, $ISBN);

            if ($stmt->execute()) {
                // Book updated successfully
                // Now, update books_authors table

                // First, delete existing entries for this book from books_authors table
                $delete_sql = "DELETE FROM books_authors WHERE ISBN = ?";
                $stmt_delete = $conn->prepare($delete_sql);
                $stmt_delete->bind_param("s", $ISBN);
                $stmt_delete->execute();
                $stmt_delete->close();

                // Now, insert new entries for authors of this book into books_authors table
                foreach ($AuthorIds as $AuthorId) {
                    // Trim whitespace from each AuthorId
                    $AuthorId = trim($AuthorId);

                    // Insert into books_authors table
                    $insert_book_author_sql = "INSERT INTO books_authors (ISBN, AuthorId) VALUES (?, ?)";
                    $stmt_book_author = $conn->prepare($insert_book_author_sql);
                    $stmt_book_author->bind_param("ss", $ISBN, $AuthorId);
                    $stmt_book_author->execute();
                    $stmt_book_author->close();
                }

                http_response_code(200);
                $response = array("success" => true, "message" => "Book updated successfully");
                echo json_encode($response);
            } else {
                // Error updating book
                http_response_code(400);
                $response = array("success" => false, "message" => "Error updating book: " . $stmt->error);
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            // Required fields not provided in the request body
            http_response_code(400);
            $response = array("success" => false, "message" => "ISBN, Title, PublicationDate, Genre, PublisherId, or AuthorIds not provided in request body");
            echo json_encode($response);
        }
    } else {
        // ISBN not provided in the URL parameters
        http_response_code(400);
        $response = array("success" => false, "message" => "ISBN not provided in URL parameters");
        echo json_encode($response);
    }
} else {
    // If request method is not PUT
    http_response_code(400);
    $response = array("success" => false, "message" => "Invalid request method");
    echo json_encode($response);
}

?>
