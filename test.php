<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';
if (isset($_POST['UserId']) && isset($_POST['recipientId'])) {
    $UserId = $_POST['UserId'];
    $recipientId = $_POST['recipientId'];
    // rest of the code that uses these variables
} else {
    echo "Error: UserId or recipientId parameter is missing from URL";
}

if (isset($_POST['message']) && !empty($_POST['message'])) {
    $message = $_POST['message'];
} else {
    $message = null;
}

// $sql = "SELECT UserId FROM User_Profile WHERE UserId = $UserId OR UserId = $recipientId";
// $stmt = sqlsrv_query($conn, $sql);

$sql = "SELECT COUNT(chatId) FROM chats";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false || $stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$UserCounter = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)[0];
$num = $UserCounter + 1;
$num_padded = sprintf("%05d", $num);

$chatId = 'CHAT' . $UserId . $recipientId . $num_padded;

// File Upload
if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    $image_ext = explode('.', $image_name);
    $image_ext = strtolower(end($image_ext));

    $allowed_ext = array('jpg', 'jpeg', 'png');

    if(in_array($image_ext, $allowed_ext)) {
        if($image_error === 0) {
            if($image_size <= 2097152) {
                $image_name_new = uniqid('', true) . '.' . $image_ext;
                $sent_image = 'sentimages/' .$image_name_new;
                if(move_uploaded_file($image_tmp, $sent_image)) {
                    $query = "INSERT INTO chats ([[UserId]
                    ,[recipientId]
                    ,[Sent]
                    ,[sentimage]
                    ,[chatId]
                    ,[senderId]) 
                    VALUES ('$UserId', '$recipientId', '$message', '$sent_image', '$chatId', '$UserId')";
                $result = sqlsrv_query($conn, $query);
                if($result) {
                    echo "success";
                } else {
                    echo "Error adding post with image.";
                }
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Image size too large.";
        }
    } else {
        echo "Error with image.";
    }
  }
  } else{
    // Insert data into the database
$query = "INSERT INTO chats ([[UserId]
,[recipientId]
,[Sent]
,[chatId]
,[senderId]) 
VALUES ('$UserId', '$recipientId', '$message', '$chatId', '$UserId')";

if (sqlsrv_query($conn, $query)) {
echo "Message sent.";
} else {
echo "Error: " . sqlsrv_errors();
}
  }






?>
