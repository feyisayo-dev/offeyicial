<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];

if (isset($_POST['postId']) && isset($_POST['action'])) {
    $postId = $_POST['postId'];
    $action = $_POST['action'];

    if ($action === 'like') {
        $query = "UPDATE posts SET Likes = Likes + 1 WHERE PostId = ?";
    } else if ($action === 'unlike') {
        $query = "UPDATE posts SET Likes = Likes - 1 WHERE PostId = ?";
    }
    
    $params = array($postId);
    $stmt = sqlsrv_prepare($conn, $query, $params);
    
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    if(sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    // Get updated like count
    $query = "SELECT Likes FROM posts WHERE PostId = ?";
    $params = array($postId);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $likes = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)[0];

    // Return updated like count and show comment section
    $response = array(
        'likes' => $likes,
        'comment_section' => '<div class="comment-section">Comment section here</div>'
    );
    echo json_encode($response);
}
?>
