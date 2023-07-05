<?php
// Include necessary dependencies and configurations

// Include the database connection file
include('db.php');

// Include the WebSocket library
require 'WebSocket/Client.php';
use WebSocket\Client;

// Get the UserIds from the session and query parameters
$UserId = $_SESSION['UserId'];
$UserIdx = $_GET['UserIdx'];

// Prepare and execute the SQL query to check if the combination of UserId and UserIdx already exists
$tsql = "SELECT sessionId FROM sessionID WHERE (UserId = '$UserId' AND UserIdx = '$UserIdx') OR (UserId = '$UserIdx' AND UserIdx = '$UserId')";
$getResults = sqlsrv_query($conn, $tsql);

if ($getResults === false) {
  die(json_encode(array("status" => "error", "message" => "Error querying the database.")));
}

// Fetch the result row
$row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);

// Check if a session exists for the given UserIds
if ($row) {
  $sessionId = $row['sessionId'];

  // Create a WebSocket client
  $client = new WebSocket\Client('ws://localhost:8888');

  // Create a notification message
  $notification = array(
    'type' => 'notification',
    'message' => 'Incoming call'
  );

  // Send the notification to the recipient user
  $client->send(json_encode($notification));

  // Close the WebSocket connection
  $client->close();

  // Redirect the user to the chat.php page with the sessionId parameter
  header("Location: chat.php?UserIdx=$UserIdx&sessionId=$sessionId");
  exit();
} else {
  die(json_encode(array("status" => "error", "message" => "Session not found.")));
}
?>
