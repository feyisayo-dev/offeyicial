<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chatId'])) {
    $chatId = $_POST['chatId'];
    
    $query = "DELETE from chats WHERE chatId = '$chatId'";
    $stmt = sqlsrv_query($conn, $query);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    $response = array('message' => 'Message deleted successfully', $chatId);
    echo json_encode($response); // Return JSON response
}
?>
