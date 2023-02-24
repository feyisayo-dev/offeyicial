<?php
session_start();
include 'db.php';
if (isset($_POST['UserId']) && isset($_POST['recipientId'])) {
    $UserId = $_POST['UserId'];
    $recipientId = $_POST['recipientId'];
    // rest of the code that uses these variables
  } else {
    echo "Error: UserId or recipientId parameter is missing from URL";
  }
 
  
$message = $_POST['message'];



$sql = "SELECT UserId FROM User_Profile WHERE UserId = $UserId OR UserId = $recipientId";
$stmt = sqlsrv_query($conn, $sql);

$tsql = "SELECT COUNT(chatId) FROM chats";
$tstmt = sqlsrv_query($conn, $tsql);

if ($stmt === false || $tstmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$UserCounter = sqlsrv_fetch_array($tstmt, SQLSRV_FETCH_NUMERIC)[0];
$num = $UserCounter + 1;
$num_padded = sprintf("%05d", $num);

$chatId = 'CHATOFF' . $UserId . $recipientId . $num_padded;


// File Upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $file = $_FILES['image'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

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
    $sent_image = null;
}


// Insert data into the database
$query = "insert INTO chats ([UserId]
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
