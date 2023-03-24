<?php
          include 'db.php';

          $query = "SELECT * FROM chats WHERE (UserId = ? AND recipientId = ?) OR (UserId = ? AND recipientId = ?) ORDER BY time_sent ASC";
          $params = array($UserId, $recipientId, $recipientId, $UserId);
          $stmt = sqlsrv_query($conn, $query, $params);
          if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
          }

          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // process each row of the result set
            $senderId = $row['senderId'];
            $message = $row['Sent'];
            $sent_image = $row['sentimage'];
            $sent_video = $row['sentvideo'];
            echo '<div class="' . ($senderId == $UserId ? 'Sent' : 'received') . '">';
            echo '<div class="message">';
            echo $message;
            echo '</div>';
            if (!empty($sent_image)) {
              echo '<div class="image"><img src="' . $sent_image . '"></div>';
            }
            if (!empty($sent_video)) {
              echo '<div class="video-container">
                  <video id="videoplayer" width="400" height="400" preload="none" controls autoplay="false">
                      <source src="' . $sent_video . '" type="video/mp4">
                  </video>
                  <button type="button" id="buttonplay" class="btn btn-primary">Watch Video</button>
              </div>';
            }


            echo '</div>';
          }
          ?>