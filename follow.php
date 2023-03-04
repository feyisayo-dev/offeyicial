<?php
if(isset($_POST['follow'])){
    require('db.php');
    $profileOwnerId = $_POST['profileOwnerId'];
    $recipientId = $_POST['recipientId'];

    // Check if the user has already followed the recipient
    $sql = "SELECT * FROM follows WHERE UserId = ? AND recipientId = ?";
    $params = array($profileOwnerId, $recipientId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if($row) {
        // User has already followed the recipient, so unfollow them
        $sql = "DELETE FROM follows WHERE UserId = ? AND recipientId = ?";
        $params = array($profileOwnerId, $recipientId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "unfollowed";
        }
    } else {
        // User has not followed the recipient, so follow them
        $sql = "INSERT INTO follows (UserId, recipientId) VALUES (?, ?)";
        $params = array($profileOwnerId, $recipientId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "followed";
        }
    }
}

?>
