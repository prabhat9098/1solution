<?php

// Include the database connection
// include './db.php';
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include 'createPublisher.php';
    


} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
        include 'getPublisherById.php';
    } else {
        include 'getPublisher.php';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    include 'editPublisher.php';

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    include 'deletePublisher.php';

}


$conn->close();

?>