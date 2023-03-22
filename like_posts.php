<?php
if(isset($_POST['like'])){
    require('db.php');
    $UserId = $_POST['UserId'];
    $postId = $_POST['postId'];

    // Check if the user has already liked the recipient
    $sql = "SELECT * FROM likes WHERE UserId = ? AND postId = ?";
    $params = array($UserId, $postId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if($row) {
        // User has already liked the recipient, so unfollow them
        $sql = "DELETE FROM likes WHERE UserId = ? AND postId = ?";
        $params = array($UserId, $postId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "unliked";
        }
    } else {
        // User has not liked the recipient, so follow them
        $sql = "INSERT INTO likes (UserId, postId) VALUES (?, ?)";
        $params = array($UserId, $postId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "liked";
        }
    }
}else{
    echo "error liking this post";
}

?>