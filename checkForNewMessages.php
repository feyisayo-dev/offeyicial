<?php
include 'db.php';

$UserId = $_POST['UserId'];
$recipientId = $_POST['recipientId'];
$timestamp = $_POST['timestamp'];

$query = "SELECT * FROM chats WHERE ((UserId = ? AND recipientId = ?) OR (UserId = ? AND recipientId = ?)) AND time_sent > ? ORDER BY time_sent ASC";
$params = array($UserId, $recipientId, $recipientId, $UserId, $timestamp);
$stmt = sqlsrv_query($conn, $query, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$response = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // process each row of the result set
    $chatId = $row['chatId'];
    $senderId = $row['senderId'];
    $message = $row['Sent'];
    $sent_image = $row['sentimage'];
    $sent_video = $row['sentvideo'];
    $time_sent = $row['time_sent'];

    $chatItem = array();
    $chatItem['senderId'] = $senderId;
    $chatItem['chatId'] = $chatId;
    $chatItem['message'] = $message;
    $chatItem['sent_image'] = $sent_image;
    $chatItem['sent_video'] = $sent_video;
    $chatItem['time_sent'] = $time_sent;

    $response[] = $chatItem;
}

echo json_encode($response);
?>
