<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the POST request
    if (isset($_FILES['voicenote']) && !empty($_FILES['voicenote'])) {
        $voiceNote = $_FILES['voicenote'];
    } else {
        $voiceNote = null;
    }
    $UserId = $_SESSION['UserId'];
    $recipientId = $_POST['recipientId'];
    $datetime = new DateTime();
    $date_posted = $datetime->format('Y-m-d H:i:s');

    // Query to get the last chatId counter
    $sql = "SELECT MAX(chatId) FROM chats WHERE chatId LIKE 'CHAT{$UserId}{$recipientId}%'";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $lastChatId = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)[0];
    if ($lastChatId) {
        $lastNumber = (int)substr($lastChatId, -5); // Extract last 5 digits
        $num = $lastNumber + 1;
    } else {
        $num = 1; // Start from 1 if no previous chatId exists
    }
    $num_padded = sprintf("%05d", $num);

    $chatId = 'CHAT' . $UserId . $recipientId . $num_padded;

    // Process and store the voice note
    $formattedDate = str_replace(array(' ', ':'), '_', $date_posted);
    $voiceNotePath = 'voiceNote/' . $chatId . '_' . $formattedDate . '.webm';
    move_uploaded_file($voiceNote['tmp_name'], $voiceNotePath);

    // Insert data into the database
    $tsql = "INSERT INTO chats ([UserId], [recipientId], [chatId], [senderId], [time_sent], [voice_notes])
             VALUES ('$UserId', '$recipientId', '$chatId', '$UserId', '$date_posted', '$voiceNotePath')";

    $stmt = sqlsrv_query($conn, $tsql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_close($conn);

    // Respond to the client
    echo json_encode(array('message' => 'Voice note sent successfully'));
}
