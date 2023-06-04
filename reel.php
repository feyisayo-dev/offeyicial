<?php
session_start();
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<title>Reels</title>';
echo '<link rel="stylesheet" href="reel.css">';
echo '<link rel="icon" href="img/offeyicial.png">';
echo '</head>';
echo '<body>';
include 'db.php';
$UserId = $_SESSION["UserId"];

// Retrieve the followers/following
$sql = "SELECT User_Profile.UserId, User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport
        FROM User_Profile
        INNER JOIN follows ON User_Profile.UserId = follows.UserId OR User_Profile.UserId = follows.recipientId
        WHERE follows.UserId = ? OR follows.recipientId = ?";
$params = array($UserId, $UserId);
$stmt = sqlsrv_prepare($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $followerID = $row['UserId'];
        $followerSurname = $row['Surname'];
        $followerFirstName = $row['First_Name'];
        $followerPassport = $row['Passport'];

        // Display the follower's information and reels
        echo "<div class='follower-container'>";
        echo "<div class='follower-details'>";
        echo "<div class='follower-passport'><img src='" . $followerPassport . "'></div>";
        echo "<div class='follower-name'>" . $followerSurname . " " . $followerFirstName . "</div>";
        echo "</div>";

        // Retrieve and display the follower's reels
        $reelsQuery = "SELECT reelId, Video, Photo
                       FROM reels
                       WHERE UserId = ?";
        $reelsParams = array($followerID);
        $reelsStmt = sqlsrv_prepare($conn, $reelsQuery, $reelsParams);

        if (sqlsrv_execute($reelsStmt)) {
            $reelsCount = sqlsrv_num_rows($reelsStmt);

            if ($reelsCount > 0) {
                while ($reelsRow = sqlsrv_fetch_array($reelsStmt, SQLSRV_FETCH_ASSOC)) {
                    $reelID = $reelsRow['reelId'];
                    $reelVideo = $reelsRow['Video'];
                    $reelPhoto = $reelsRow['Photo'];

                    // Display the reel information
                    echo "<div class='reel-container'>";
                    echo "<div class='reel'>";
                    echo "<video src='" . $reelVideo . "' controls></video>";
                    echo "<img src='" . $reelPhoto . "'>";
                    echo "<div class='reel-overlay'>";
                    echo "<button class='like-button'>Like</button>";
                    echo "<button class='comment-button'>Comment</button>";
                    echo "<button class='share-button'>Share</button>";
                    echo "<button class='save-button'>Save</button>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                // No reels found for the follower
                echo "<div class='no-reels'>Get more friends</div>";
            }
        } else {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "</div>";
    }
} else {
    die(print_r(sqlsrv_errors(), true));
}

echo '</body>';
echo '</html>';
?>
