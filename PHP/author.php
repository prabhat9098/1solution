<?php

// Include the database connection
// include './db.php';
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include 'createAuthor.php';
    


} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
        include 'getAuthodById.php';
    } else {
        include 'getAuthor.php';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    include 'editAuthor.php';

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    include 'deleteAuthor.php';

}


$conn->close();

?>