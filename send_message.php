<?php
session_start();
include 'db.php';

$UserId = ($_POST['UserId']);
$recipientId = ($_POST['recipientId']);
$message = $_POST['message'];



$sql = "SELECT Surname FROM User_Profile WHERE UserId = $UserId OR UserId = $recipientId";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    $Surname = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
        $surname = trim($row[0]);
        $shortSurname = getSurname(0, 0, $surname);
        array_push($Surname, $shortSurname);
    }

    $UserSurname = $Surname[0];
    $recipientIdSurname = $Surname[1];
}

$chatId = 'OFF' . $UserSurname . $recipientIdSurname . $num_padded;

// File Upload
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    // Check if there was any error uploading the file
    if ($file_error === 0) {
        // Check if the file size is within the allowed limit
        if ($file_size <= 1000000) {
            // Move the uploaded file to a permanent location
            move_uploaded_file($file_tmp, "sentimages/" . $file_name);

            // Store the file name in the database
            $sent_image = "sentimages/" . $file_name;
        } else {
            echo "File size too large.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    $sent_image = null;
}

// Insert data into the database
$query = "insert INTO chats ([[UserId]
,[recipientId]
,[Sent]
,[sentimage]
,[chatId]
,[senderId])
    VALUES ('$UserId', '$recipientId', '$message', '$sent_image', '$chatId', '$UserId')";

if (sqlsrv_query($conn, $query)) {
  echo "Message sent.";
} else {
  echo "Error: " . sqlsrv_errors();
}

?>
