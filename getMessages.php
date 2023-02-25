<?php
session_start();
        include 'db.php';
$UserId = $_SESSION['UserId'];


        $query = "SELECT * FROM chats ORDER BY time_sent ASC";
        $result = sqlsrv_query($conn, $query);

        while ($row = sqlsrv_fetch_array($result)) {
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
?>
