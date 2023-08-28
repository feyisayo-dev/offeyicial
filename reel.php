<?php
session_start();
include 'db.php';
$UserId = $_SESSION["UserId"];
?>
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

    // Retrieve and display the follower's reels
    $reelsQuery = "SELECT reelId, Video, Photo
                   FROM reels
                   WHERE UserId = ?";
    $reelsParams = array($followerID);
    $reelsStmt = sqlsrv_prepare($conn, $reelsQuery, $reelsParams);

    if ($reelsStmt === false) {
      die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($reelsStmt)) {
      while ($reelsRow = sqlsrv_fetch_array($reelsStmt, SQLSRV_FETCH_ASSOC)) {
        $reelID = $reelsRow['reelId'];
        $reelVideo = $reelsRow['Video'];
        $reelPhoto = $reelsRow['Photo'];

        // Do something with $reelID, $reelVideo, $reelPhoto
      }
    } else {
      die(print_r(sqlsrv_errors(), true));
    }
  }
} else {
  die(print_r(sqlsrv_errors(), true));
}
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
        <a class="nav-link" onclick="window.location.href='addreel.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-camera-reels"></i></i>Add Reels</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-plus-square"></i>New Post</a>
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
  <div class="app__videos">
    <!-- video starts -->
    <div class="video">
      <video class="video__player" src="uploads/63ee18ffed0737.49776399.mp4"></video>

      <!-- sidebar -->
      <div class="videoSidebar">
        <div class="videoSidebar__button">
          <span class="material-icons"><i class="bi bi-bookmark"></i></span>
          <p style="color:white;">12</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-chat"></i> </span>
          <p style="color:white;">23</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-share-fill"></i> </span>
          <p style="color:white;">75</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-download"></i> </span>
        </div>
      </div>

      <!-- footer -->
      <div class="videoFooter">
        <div class="videoFooter__text">
          <h3>Harinivas P</h3>
          <p class="videoFooter__description">Best Video Ever</p>

          <div class="videoFooter__ticker">
            <span class="material-icons videoFooter__icon"> music_note </span>
            <marquee>Song name</marquee>
          </div>
        </div>
        <img src="icons/cd.png" alt="" class="videoFooter__record" />
      </div>
    </div>
    <!-- video ends -->
  </div>

  <script>
    const videos = document.querySelectorAll('video');

    for (const video of videos) {
      video.addEventListener('click', function() {
        console.log('clicked');
        if (video.paused) {
          video.play();
        } else {
          video.pause();
        }
      });
    }
  </script>
</body>

</html>