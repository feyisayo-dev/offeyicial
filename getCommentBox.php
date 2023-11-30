<?php
include('db.php');

$postId = $_POST['postId'];
// $postIdStr = implode(',', $postId);s

$sql = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, comments.PostId, comments.UserId, comments.comment, comments.date_posted
FROM comments
JOIN User_Profile ON User_Profile.UserId = comments.UserId
WHERE comments.PostId = '".$postId."'
ORDER BY comments.date_posted DESC";


$result = sqlsrv_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . print_r(sqlsrv_errors(), true));
}

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

sqlsrv_close($conn);
