<?php
include 'db.php';

if (isset($_GET['postId'])) {
  $PostId = $_GET['postId'];

  // Perform a database query to check if the PostId exists
  $sql = "SELECT * FROM Posts WHERE PostId = ?";
  $params = array($PostId);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt !== false && sqlsrv_has_rows($stmt)) {
    // PostId found
    echo 'true';
  } else {
    // PostId not found
    echo 'false';
  }
}
?>
