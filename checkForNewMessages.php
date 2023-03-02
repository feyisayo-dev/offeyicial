<?php
include 'db.php';

// Get the timestamp of the last message received by the client
$lastMessageTime = $_GET['lastMessageTime'] ?? '1900-01-01 00:00:00'; // If lastMessageTime is not set, use a default value
$UserId = $_SESSION['UserId'];

// Retrieve any new messages from the database
$query = "SELECT * FROM chats WHERE (UserId = ? AND recipientId = ?) OR (UserId = ? AND recipientId = ?) ORDER BY time_sent ASC";
        $params = array($UserId, $recipientId, $recipientId, $UserId);
        $stmt = sqlsrv_query($conn, $query, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

// Build an array of new messages
$newMessages = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $newMessages[] = $row;
}

// Send the new messages as JSON data
echo json_encode($newMessages);
?>
