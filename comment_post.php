<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];

if (isset($_POST['postId']) && isset($_POST['comment'])) {
    $postId = $_POST['postId'];
    $comment = $_POST['comment'];

    // Insert new comment
    $query = "INSERT INTO comments (PostId, UserId, comment) VALUES (?, ?, ?)";
    $params = array($postId, $UserId, $comment);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Update number of comments for the post
    $query = "UPDATE post SET comment = comment + 1 WHERE PostId = ?";
    $params = array($postId);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Get updated comment count
    $query = "SELECT comment FROM post WHERE PostId = ?";
    $params = array($postId);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $numComments = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)[0];

    // Return updated comment count and comment section
    $commentSection = '<div class="comment-section">';
    $commentSection .= '<h3>Comments (' . $numComments . ')</h3>';
    $commentSection .= '<ul>';

    // Retrieve all comments for this post
    $query = "SELECT comments.comment, User_Profile.First_Name, User_Profile.Surname FROM comments JOIN User_Profile ON User_Profile.UserId = comments.UserId WHERE PostId = ?";
    $params = array($postId);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $commentSection .= '<li>';
        $commentSection .= '<p>' . $row['First_Name'] . ' ' . $row['Surname'] . ': ' . $row['comment'] . '</p>';
        $commentSection .= '</li>';
    }

    $commentSection .= '</ul>';
    $commentSection .= '</div>';

    $response = array(
        'num_comments' => $numComments,
        'comment_section' => $commentSection
    );
    echo json_encode($response);
}
?>
