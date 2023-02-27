<?php
include('db.php');
if (isset($_POST['submit'])) {
    $message = $_POST['message'];
    $email = $_POST['email'];
    $name = $_POST['name'];

    $sql = "SELECT COUNT(messageId) FROM complaints";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false || $stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $UserCounter = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)[0];
    $num = $UserCounter + 1;
    $num_padded = sprintf("%05d", $num);

    $messageId = 'COM'. $num_padded;
    $query = "INSERT INTO complaints ([messageId]
    ,[message]
    ,[email]
    ,[name]) 
        VALUES ('$messageId', '$message', '$email', '$name')";

    if (sqlsrv_query($conn, $query)) {
        echo "Message sent.";
    } else {
        echo "Error: " . sqlsrv_errors();
    }
    $errors = sqlsrv_errors();
print_r($errors);

}
?>
