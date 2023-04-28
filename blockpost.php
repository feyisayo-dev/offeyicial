<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserId'])) {
  // User is not logged in, redirect to login page
  header("Location: login.php");
  exit();
}

// Get post ID from AJAX request
$postId = $_POST['postId'];
$checkedCheckboxes = $_POST['checkedCheckboxes'];



// Get user ID from session
$UserId = $_SESSION['UserId'];

// Get block preferences from AJAX request
$pornographic = $_POST['pornographicContentPosts'];
// echo $pornographic;

$racism = $_POST['racistPosts'];
// echo $racism;

$bloody = $_POST['bloodyContentPosts'];
// echo $bloody;

$flashy = $_POST['flashyContentPosts'];
// echo $flashy;

$other = isset($_POST['otherReasonCheckboxPosts']) ? $_POST['otherReasonTextPosts'] : '';

// Connect to database
include('db.php');

if ($conn === false) {
  die(print_r(sqlsrv_errors(), true));
}

// Check if user has already blocked this post
$sql = "SELECT UserId FROM Users_prefer WHERE UserId = ? AND PostId = ?";
$params = array($UserId, $postId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
  die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt)) {
  // User has already blocked this post, update their preferences
  $sql = "UPDATE Users_prefer SET Pornographic = ?, Bloody = ?, Racism = ?, Flashy = ?, Other = ? WHERE UserId = ? AND PostId = ?";
  $params = array($pornographic, $bloody, $racism, $flashy, $other, $UserId, $postId);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  }
  echo "success";
} else {
  // User has not blocked this post, insert new preferences
  $sql = "INSERT INTO Users_prefer (UserId, Pornographic, Bloody, Racism, Flashy, Other, PostId) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $params = array($UserId, $pornographic, $bloody, $racism, $flashy, $other, $postId);
  $stmt = sqlsrv_query($conn, $sql, $params);

  if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
  }
  echo "success";
}
// echo $checkedCheckboxes;


// Close database connection
sqlsrv_close($conn);
