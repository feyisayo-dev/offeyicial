<?php
include('db.php');

// Get the postId from the AJAX request
$postId = $_POST['postId'];
// $postIdStr = implode(',', $postId);s

// SQL query to retrieve comments for the specific postId
$sql = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, comments.PostId, comments.UserId, comments.comment, comments.date_posted
FROM comments
JOIN User_Profile ON User_Profile.UserId = comments.UserId
WHERE comments.PostId = '".$postId."'
ORDER BY comments.date_posted DESC";


// Execute the query
$result = sqlsrv_query($conn, $sql);

// Check if query executed successfully
if (!$result) {
    die("Error executing query: " . print_r(sqlsrv_errors(), true));
}

// Loop through the result and create HTML markup for each comment
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $Surname = $row['Surname'];
    $First_Name = $row['First_Name'];
    $comment = $row['comment'];
    $UserId = $row['UserId'];
   
    echo '<div class="comment-bubble">
    <div class="comment-heading">
        <img class="comment-passport" src="UserPassport/' . $row['Passport'] . '">
        <a class="post-name" href="user_profile.php?UserId=' . $UserId . '">' . $row['Surname'] . ' ' . $row['First_Name'] . '</a>
    </div>
    <div class="comment-content">' . $comment . '</div>
</div>';


}

// Close database connection
sqlsrv_close($conn);
