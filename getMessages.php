<?php
session_start();
        include 'db.php';
$UserId = $_SESSION['UserId'];
if (isset($_GET['UserIdx'])) {
    $recipientId = $_GET['UserIdx'];
    $query = "SELECT * FROM chats WHERE UserId = ? AND recipientId = ? ORDER BY time_sent ASC";
        $params = array($UserId, $recipientId);
        $stmt = sqlsrv_query($conn, $query, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // process each row of the result set
            $senderId = $row['senderId'];
            $message = $row['Sent'];
            $sent_image = $row['sentimage'];

            echo '<div class="' . ($senderId == $UserId ? 'Sent' : 'received') . '">';
            echo '<div class="message">';
            echo $message;
            echo '</div>';
            if (!empty($sent_image)) {
                echo '<div class="image"><img src="' . $sent_image . '"></div>';
            }
            echo '</div>';
        }
  } else {
    echo 'UserIdx not found';
  }
  



?>
