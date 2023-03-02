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
$datetime = new DateTime();
    $date_posted = $datetime->format('Y-m-d H:i:s');


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
//video upload
if(isset($_FILES['video']) && !empty($_FILES['video']['name'])){
    $video = $_FILES['video'];
    $video_name = $video['name'];
    $video_tmp = $video['tmp_name'];
    $video_size = $video['size'];
    $video_error = $video['error'];

    $video_ext = explode('.', $video_name);
    $video_ext = strtolower(end($video_ext));

    $allowed_ext = array('mp4', 'avi', 'wmv');

    if(in_array($video_ext, $allowed_ext)) {
        if($video_error === 0) {
            if($video_size <= 209715200) { // max video size is 200MB
                $video_name_new = uniqid('', true) . '.' . $video_ext;
                $video_destination = 'sentVidoes/' .$video_name_new;
                $UserId = $_SESSION['UserId'];
                if(move_uploaded_file($video_tmp, $video_destination)) {
                    $sql = "Insert into chats([UserId]
                    ,[recipientId]
                    ,[Sent]
                    ,[sentvideo]
                    ,[chatId]
                    ,[senderId]
                    ,[time_sent]) 
                    VALUES ('$UserId', '$recipientId', '$message','$video_destination', '$chatId', '$UserId', '$date_posted')";
                $result = sqlsrv_query($conn, $sql);
                if($result) {
                    echo "success";
                } else {
                    echo "Error adding post with video.";
                }
            } else {
                echo "Error uploading video.";
            }
        } else {
            echo "Video size too large.";
        }
    }
    } else {
        echo "Error with video.";
    }
}else{
    // Insert data into the database
$query = "INSERT INTO chats ([UserId]
,[recipientId]
,[Sent]
,[sentimage]
,[chatId]
,[senderId]
,[time_sent]) 
VALUES ('$UserId', '$recipientId', '$message', '$sent_image', '$chatId', '$UserId', '$date_posted')";

if (sqlsrv_query($conn, $query)) {
echo "Message sent.";
} else {
echo "Error: " . sqlsrv_errors();
}


}



?>
