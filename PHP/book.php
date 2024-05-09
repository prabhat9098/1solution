<?php

// Include the database connection
// include './db.php';
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include 'createBook.php';
    


} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
        include 'getBookById.php';
    } else {
        include 'getBook.php';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    include 'editBook.php';

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    include 'deleteBook.php';

}


$conn->close();

?>