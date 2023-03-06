<?php
include('db.php');

// Get the postId from the AJAX request
$postId = $_POST['postId'];

// SQL query to retrieve comments for the specific postId
// $sql = "SELECT * FROM comments WHERE postId = '$postId'";
$sql = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, comments.UserId, comments.postId, comments.comment 
from comments
JOIN User_Profile ON User_Profile.UserId = comments.UserId 
ORDER BY posts.date_posted DESC";


// Execute the query
$result = sqlsrv_query($conn, $sql);


// Check if query executed successfully
if (!$result) {
    die("Error executing query: " . sqlsrv_errors());
}

// Loop through the result and create HTML markup for each comment
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $Surname= $row['Surname'];
    $First_Name = $row['First_Name'];
    $comment = $row['comment'];
    echo '<div class="comment">';
    echo '<p class="comment-author">' . $Surname .''.$First_Name. '</p>';
    echo '<p class="comment-text">' . $comment . '</p>';
    echo '</div>';
}

// Close database connection
sqlsrv_close($conn);
?>
