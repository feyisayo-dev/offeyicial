<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserId'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Get post ID from AJAX request
$recipientId = $_POST['recipientId'];



// Get user ID from session
$UserId = $_SESSION['UserId'];

// Get block preferences from AJAX request
$pornographicContent = $_POST['pornographicContent'];
// echo $pornographicContent;

$notAFanOfPosts = $_POST['notAFanOfPosts'];
// echo $notAFanOfPosts;

$bloodyContent = $_POST['bloodyContent'];
// echo $bloodyContent;

$flashyContent = $_POST['flashyContent'];
// echo $flashyContent;

$other = isset($_POST['otherReason']) ? $_POST['otherReasonText'] : '';

// Connect to database
include('db.php');

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Check if user has already blocked this post
$sql = "SELECT UserId FROM User_prefer_user WHERE UserId = ? AND recipientId = ?";
$params = array($UserId, $recipientId);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt)) {
    // User has already blocked this post, update their preferences
    $sql = "UPDATE User_prefer_user SET pornographicContent = ?, bloodyContent = ?, notAFanOfPosts = ?, flashyContent = ?, Other = ? WHERE UserId = ? AND recipientId = ?";
    $params = array($pornographicContent, $bloodyContent, $notAFanOfPosts, $flashyContent, $other, $UserId, $recipientId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    echo "success";
} else {
    // User has not blocked this post, insert new preferences
    $sql = "INSERT INTO User_prefer_user (UserId, pornographicContent, bloodyContent, notAFanOfPosts, flashyContent, Other, recipientId) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($UserId, $pornographicContent, $bloodyContent, $notAFanOfPosts, $flashyContent, $other, $recipientId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    echo "success";
}


// Close database connection
sqlsrv_close($conn);
