<?php
session_start();
include 'db.php';
$UserId = $_SESSION["UserId"];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reels</title>
    <link rel="stylesheet" href="reel.css">
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <style>

    </style>
</head>

<body>
    <div class="sidebar">
        <a class="sidebar-brand" href="home.php"><span class="text-success">Offeyicial</span></a>
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i></i>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="window.location.href='reel.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-camera-reels"></i></i>Reels</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>"><i class="bi bi-plus-square"></i>New Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notificationLink" href="#"><i class="bi bi-bell-fill"></i>Notifications</a>
                <div id="notificationBox">
                    <!-- Content of the notification box goes here -->
                    <!-- You can customize the content as per your requirements -->
                </div>
            </li>
            <li class="nav-item">
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                </div>
            </li>

            <li>
                <a class="nav-link scrollto" href="#contact"><i class="bi bi-telephone"></i>Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="location.href='logoutmodal.php'"><i class="bi bi-box-arrow-right"></i>Logout</a>
            </li>
        </ul>
    </div>
    <div class='icon'>
        <h2>Reels</h2>
    </div>
    <?php
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
                echo $reelsCount;

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
                    echo "<div class='no-reels'>";
                    echo "<h2>No reels available</h2>";
                    echo "<p>Start creating and sharing your own reels to inspire others!</p>";
                    echo "</div>";
                }
                
            } else {
                die(print_r(sqlsrv_errors(), true));
            }

            echo "</div>";
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }
    ?>
</body>

</html>