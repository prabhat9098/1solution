<?php

// Include the database connection
// include './db.php';
include 'config.php';

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include 'createBorrow.php';
    


} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['id'])) {
        include 'getBorrowById.php';
    } else {
        include 'getBorrow.php';
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    include 'editBorrow.php';

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    include 'deleteBorrow.php';

}


$conn->close();

?>