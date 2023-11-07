<?php
session_start();
if(isset($_POST['follow'])){
    require('db.php');
    $UserId = $_SESSION['UserId'];
    $recipientId = $_POST['profileOwnerId'];

    $sql = "SELECT * FROM follows WHERE UserId = ? AND recipientId = ?";
    $params = array($UserId, $recipientId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if($row) {
        $sql = "DELETE FROM follows WHERE UserId = ? AND recipientId = ?";
        $params = array($UserId, $recipientId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "unfollowed";
        }
    } else {
        $sql = "INSERT INTO follows (UserId, recipientId) VALUES (?, ?)";
        $params = array($UserId, $recipientId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "followed";
        }
    }
}

?>
