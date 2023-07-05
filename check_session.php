<?php
// Include necessary dependencies and configurations

// Include the database connection file
include('db.php');

// Get the session ID from the query parameter
$sessionId = $_GET['sessionId'];

// Prepare and execute the SQL query to check if the session ID exists
$tsql = "SELECT sessionId FROM sessionID WHERE sessionID = '$sessionId'";
$getResults = sqlsrv_query($conn, $tsql);

if ($getResults === false) {
  die(json_encode(array("status" => "error", "message" => "Error querying the database.")));
}

// Fetch the result row
$row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);

if ($row) {
  // Session is valid
  echo json_encode(array("status" => "success"));
} else {
  // Session is not found or invalid
  echo json_encode(array("status" => "error", "message" => "Invalid session ID."));
}
?>
