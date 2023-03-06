<?php
session_start();
// connect to MSSQL
include('db.php');

// get data from AJAX request
$postId = $_POST['postId'];
$comment = $_POST['comment'];
$UserId = $_SESSION['UserId'];

// prepare and execute query to insert comment
$sql = "INSERT INTO comments (postId, UserId, comment) VALUES (?, ?, ?)";
$params = array($postId, $UserId, $comment);
$stmt = sqlsrv_prepare($conn, $sql, $params);
if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
}

// close MSSQL connection
sqlsrv_close($conn);

// return success message
echo "Comment added successfully.";

?>
