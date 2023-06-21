<?php
session_start();
// Check if user is logged in
?>
<?php
$UserId = $_SESSION["UserId"];
include 'db.php';

?>
<!DOCTYPE html>
<html>

<head>
  <title>News Feed</title>
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
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">


  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="js/slim.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/png" sizes="32x32" />
  <style>
    @font-face {
      font-family: 'Modern-Age';
      src: url('fonts/Modern-Age.ttf');
    }

    @font-face {
      font-family: 'Billabong';
      src: url('fonts/FontsFree-Net-Billabong.ttf');
    }

    @font-face {
      font-family: 'SenjakalaDemoBold';
      src: url('fonts/SenjakalaDemoBold.ttf');
    }

    @font-face {
      font-family: 'Springlake';
      src: url('fonts/Springlake.ttf');
    }
    @font-face {
      font-family: 'WisdomVacation';
      src: url('fonts/WisdomVacation.ttf');
    }

    /* News feed post */
    .post {
      margin-left: 280px;
      top: 0;
      background-color: #fff;
      border: 1px solid #dddfe2;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      padding: 20px;
      margin-bottom: 20px;
    }

    /* Post header */
    .post-header {
      display: flex;
      align-items: center;
    }

    .UserPassport {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .post-author {
      margin: 0;
      font-size: 27px;
      color: black;
      /* font-weight: bold; */
    }

    /* Post title */
    .post-title {
      margin-top: 0;
      justify-content: center;
      display: flex;
      text-transform: uppercase;
    }

    /* Post content */
    .post-content {
      margin-bottom: 10px;
    }

    /* Post image */
    .post-image {
      width: 100%;
      max-height: 600px;
      margin-bottom: 10px;
    }

    /* Post video */
    .post-video {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      margin-bottom: 10px;
    }

    .video-container {
      position: relative;
      padding-bottom: 56.25%;
      /* 16:9 */
      height: 0;
      overflow: hidden;
    }

    .video-container video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .video-controls {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: space-between;
      padding: 10px;
      box-sizing: border-box;
    }

    .video-controls button {
      background-color: transparent;
      border: none;
      color: #fff;
      font-size: 18px;
      cursor: pointer;
    }

    /* Volume control */
    .volume-control {
      display: flex;
      align-items: center;
      margin-right: 20px;
    }

    .volume-control input[type="range"] {
      width: 100px;
      height: 10px;
      margin-left: 10px;
    }

    /* Time control */
    .time-control {
      display: flex;
      align-items: center;
    }

    .time-control input[type="range"] {
      flex-grow: 1;
      height: 4px;
    }

    .time-display {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      margin-left: 10px;
      width: 100px;
      font-size: 12px;
    }

    .currentTimeDisplay,
    .durationDisplay {
      text-align: right;
      min-width: 30px;
      color: white;
    }


    /* Post date */
    .post-date {
      margin: 0;
      font-size: 14px;
      color: #999;
    }

    /* Footer */
    .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 10px;
    }

    /* Like button */
    .like {
      display: inline-flex;
      align-items: center;
      padding: 8px 16px;
      background-color: #fff;
      color: #333;
      border: 1px solid #dddfe2;
      border-radius: 999px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .like:hover {
      background-color: #f0f2f5;
    }

    .like.likeing {
      background-color: #1877f2;
      color: #fff;
      border-color: #1877f2;
    }

    .like.likeing:hover {
      background-color: #166fe5;
      border-color: #166fe5;
    }

    /* Share button */
    .share-button {
      display: inline-flex;
      align-items: center;
      padding: 8px 16px;
      background-color: #fff;
      background-color: #0d6efd;
      ;
      border: 1px solid #dddfe2;
      border-radius: 999px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .share-button:hover {
      background-color: #f0f2f5;
    }

    .share-button i {
      margin-right: 5px;
    }

    /* Chat sidebar */
    .offcanvas-header {
      padding: 0.5rem;
      background-color: #f0f2f5;
      border-bottom: 1px solid #dddfe2;
    }

    .offcanvas-title {
      margin-bottom: 0;
      font-size: 1.5rem;
    }


    .comment-button {
      display: flex;
      align-items: center;
    }

    .comment-button i {
      margin-right: 5px;
    }

    @media (max-width: 767px) {
      body {
        width: 100%;
      }

      /* Reduce font sizes */
      .post-title {
        font-size: 20px;
      }

      .post-author {
        font-size: 14px;
      }

      .post-content {
        font-size: 16px;
      }

      .post-date {
        font-size: 12px;
      }

      /* Center post image and video */
      .post-image,
      .post-video {
        display: block;
        margin: 0 auto;
        max-width: 100%;
      }

      /* Adjust padding and margins */
      .post-header {
        padding: 10px;
      }

      .post {
        margin-bottom: 20px;
      }

      /* Reduce button sizes */
      .btn {
        padding: 6px 12px;
        font-size: 14px;
      }

      /* Hide UserPassport image */
      .UserPassport {
        display: none;
      }

      /* Adjust spacing between elements */
      .post-header {
        margin-bottom: 10px;
      }

      .post-date {
        margin-top: 10px;
      }
    }

    /* Custom CSS for the sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 20px;
      z-index: 9999;
      overflow-y: auto;
      transition: all 0.3s ease;
      background-color: #fff;
      border-right: 1px solid #ddd;
      padding: .5rem 1rem;
    }

    .sidebar-brand {
      margin-left: 15px;
      font-size: 30px;
      font-weight: 700;
      letter-spacing: 2px;
      color: #000;
      text-transform: uppercase;
      text-decoration: none;
      font-family: 'Modern-Age', cursive;
    }

    .sidebar-nav {
      margin-top: 50px;
      list-style: none;
      padding: 0;
    }

    .sidebar-nav .nav-link {
      font-size: 16px;
      text-transform: uppercase;
      font-weight: 500;
      color: #000;
      padding: 10px 20px;
      transition: all 0.3s ease;
    }

    .sidebar-nav .nav-link:hover {
      background-color: #f2f2f2;
      color: #000;
    }

    .sidebar-nav .search-container {
      display: flex;
      align-items: center;
      background-color: #fafafa;
      border-radius: 8px;
      padding: 5px;
    }

    .sidebar-nav .search-container i {
      color: #8e8e8e;
      margin-right: 5px;
    }

    .sidebar-nav .search-container input.searchtext {
      border: none;
      background-color: transparent;
      font-size: 14px;
      outline: none;
      width: 100%;
    }

    .sidebar-nav .search-container input.searchtext::placeholder {
      color: #8e8e8e;
    }

    .user-table {
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      display: none;
      position: absolute;
      top: 0;
      left: 262px;
      width: 200px;
      z-index: 9999;
    }

    .user-table.show {
      display: block;
    }

    .user-table li {
      padding: 8px 12px;
      cursor: pointer;
    }

    .user-table li:hover {
      background-color: #f2f2f2;
      text-decoration: none;
    }

    .user-table li:hover {
      background-color: #f2f2f2;
      text-decoration: none;
    }

    .comment-bubble {
      position: relative;
      background-color: white;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 10px;
    }

    .comment-heading {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .comment-passport {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }

    .post-name {
      font-weight: bold;
    }

    .comment-content {
      font-size: 14px;
    }


    #commentInput {
      height: 40px;
      border-radius: 10px;
      box-shadow: 2px 2px 2px blue;
    }

    .notification {
      background-color: #f5f5f5;
      border: 1px solid #ddd;
      color: #333;
      padding: 10px;
      margin-bottom: 10px;
      transition: opacity 0.5s ease-in-out;
    }

    .notification.hidden {
      opacity: 0;
    }

    #scrollToTopBtn {
      display: none;
      position: fixed;
      bottom: 30px;
      right: 30px;
      z-index: 99;
      font-size: 18px;
      border: none;
      outline: none;
      background-color: #04AA6D;
      color: white;
      cursor: pointer;
      padding: 10px;
      border-radius: 50%;
    }

    #scrollToTopBtn:hover {
      background-color: #0d6efd;
    }

    /* Sidebar */
    .offcanvas-body {
      padding: 15px;
    }

    .offcanvas-body ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .offcanvas-body ul li {
      margin-bottom: 10px;
    }

    .offcanvas-body ul li a {
      display: block;
      color: #333;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 5px;
      transition: all 0.2s ease-in-out;
    }

    .offcanvas-body ul li a:hover {
      background-color: #f7f7f7;
      color: #04AA6D;
    }

    li a {
      display: flex;
      align-items: center;
      text-transform: uppercase;
      text-decoration: none;
    }

    .passport {
      margin-right: 10px;
    }

    .passport img {
      width: 30px;
      height: 30px;
      object-fit: cover;
      border-radius: 50%;
    }

    .name {
      flex: 1;
    }

    .name span {
      font-size: 16px;
      font-weight: bold;
    }



    /* Show the modal when the passport image is clicked */
    .passport img:hover {
      cursor: pointer;
    }

    nav .logo {
      font-size: 30px;
      margin: 0;
      padding: 0;
      line-height: 1;
      font-weight: 500;
      letter-spacing: 2px;
      text-transform: uppercase;
    }

    .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
    }

    .logo img {
      height: 30px;
      margin-right: 10px;
    }

    .passport,
    .name {
      display: inline-block;
      vertical-align: middle;
    }

    /* Chat button */
    button[data-bs-target="#sidebar"] {
      position: fixed;
      bottom: 20px;
      /* right: 20px; */
      z-index: 9999;
      background-color: #04AA6D;
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 15px 20px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.2s ease-in-out;
    }

    button[data-bs-target="#sidebar"]:hover {
      background-color: #128C7E;
      transform: scale(1.05);
      box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
    }

    .allcoments {
      display: flex;
      flex-direction: row;
      margin-bottom: 10px;
      max-height: 200px;
      /* adjust height as needed */
      overflow-y: auto;
    }

    .commentauthor {
      display: inline-block;
      vertical-align: top;
      /* This ensures the image and name are aligned at the top */
      margin-right: 10px;
      /* Add some space between the image and name */
    }

    .commentpassport {
      width: 30px;
      /* Adjust the width of the image as needed */
      height: 30px;
      /* Adjust the height of the image as needed */
      border-radius: 50%;
    }


    .post-name {
      margin: 0;
      font-weight: bold;
    }

    .seecomments {
      flex: 1;
      background-color: #f5f5f5;
      border-radius: 10px;
      padding: 5px 10px;
      font-size: 14px;
    }

    #commentInput {
      height: 40px;
      border-radius: 10px;
      box-shadow: 2px 2px 2px blue;
    }

    .notification {
      background-color: #f5f5f5;
      border: 1px solid #ddd;
      color: #333;
      padding: 10px;
      margin-bottom: 10px;
      transition: opacity 0.5s ease-in-out;
    }

    .notification.hidden {
      opacity: 0;
    }

    .emoji {
      color: black;
      background-color: white;
      border: none;
      background-color: transparent;
    }

    .emoji:hover {
      background-color: green;
      border: none;
    }

    .emoji:focus {
      background-color: green;
      border: none;
    }

    .emoji-picker {
      position: relative;
    }

    .emoji-table-container {
      position: absolute;
      top: -150px;
      /* adjust this value to suit your needs */
      z-index: 1;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
      padding: 10px;
      max-height: 200px;
      overflow-y: auto;
    }

    #threedots {
      display: flex;
      justify-content: flex-end;
      text-decoration: none;
      align-items: right;
      margin-left: auto;
    }

    .blockUser,
    .blockButton {
      color: black;
      background-color: transparent;
      width: 100%;
      border: none;
    }

    .blockUser:hover,
    .blockButton:hover {
      transform: scale(1.05);
      background-color: transparent;
      color: black;
    }

    .post {
      background-color: #ffffff;
      padding: 20px;
    }

    .nav-item {
      padding-bottom: 10px;
    }

    #notificationBox {
      position: absolute;
      top: 100%;
      right: 0;
      width: 300px;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      padding: 10px;
      display: none;
    }

    .nav-item.open #notificationBox {
      display: block;
    }

    .comments-sidebar {
      background-color: #f0f0f0;
      padding: 10px;
      height: 100vh;
      overflow-y: auto;
      right: 0;
      top: 0;
      position: fixed;
      display: none;
    }

    .comments {
      margin-bottom: 10px;
    }

    .comment-input {
      padding: 10px;
      background-color: #fff;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    .emoji-picker {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .emoji-picker .btn {
      margin-right: 10px;
    }

    .emoji-table-container {
      display: none;
    }

    .comment-input textarea {
      width: 100%;
      resize: vertical;
    }

    .comment-input button {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="row">
    <div class="col-3">
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
    </div>
    <div class="container">
      <div id="user_table" class="user-table"></div>

      <div class="col-9">

        <div class="news-feed-container">
          <?php
          // Connect to the database
          include 'db.php';
          $query = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, COUNT(likes.PostId) AS num_likes, MAX(CASE WHEN likes.UserId = ? THEN 1 ELSE 0 END) AS is_liking
    FROM posts
    JOIN User_Profile ON User_Profile.UserId = posts.UserId
    LEFT JOIN likes ON likes.PostId = posts.PostId
    GROUP BY User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted
    ORDER BY posts.date_posted DESC";
          $params = array($UserId);
          $result = sqlsrv_query($conn, $query, $params);

          if ($result === false) {
            echo "Error executing query: " . sqlsrv_errors()[0]['message'];
            exit;
          }

          while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            // Your code to display the posts
            $date_posted = new DateTime($row['date_posted']);
            $formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
            $postId = $row['PostId'];
            $likes = $row['num_likes'];
            $islikeing = $row['is_liking'];
            $current_date = new DateTime();
            $date_postedx = new DateTime($formatted_date);
            $interval = $current_date->diff($date_postedx);

            if ($interval->y) {
              $time_ago = $interval->y . " years ago";
            } else if ($interval->m) {
              $time_ago = $interval->m . " months ago";
            } else if ($interval->d) {
              $time_ago = $interval->d . " days ago";
            } else if ($interval->h) {
              $time_ago = $interval->h . " hours ago";
            } else if ($interval->i) {
              $time_ago = $interval->i . " minutes ago";
            } else {
              $time_ago = $interval->s . " seconds ago";
            }
            // Store Likes, Comments, and Shares values in variables
            echo '<section>';
            echo '<div class="post">';
            echo '<div class="news-feed-post"  id="' . $postId . '">';
            echo '<div class="post-header">';
            echo '<img class="UserPassport" src="UserPassport/' . $row['Passport'] . '">';
            echo '<a href="user_profile.php?UserId=' . $row['UserId'] . '" style="text-decoration: none;"><p class="post-author"><strong>' . $row['Surname'] . ' ' . $row['First_Name'] . '</strong></p></a>';
            echo '<div id="threedots">
                    <button type="button" class="btn btn-link" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <div>
                        <button type="button" class="btn btn-primary blockUser" id="blockUser-' . $row['UserId'] . '" data-recipientid="' . $row['UserId'] . '" data-bs-toggle="modal" data-bs-target="#blockUserModal-' . $row['UserId'] . '">
                          Block User
                        </button>
                        <input type="hidden" id="bu' . $row['UserId'] . '" value="' . $row['UserId'] . '">
                      </div>
                      <div>
                        <button type="button" class="btn btn-primary blockButton" id="blockButton-' . $postId . '" data-postid="' . $postId . '" data-bs-toggle="modal" data-bs-target="#blockTypeofPostModal-' . $postId . '">
                          Block this type of post
                        </button>
                        <input type="hidden" id="b' . $postId . '" value="' . $postId . '">
                      </div>
                      <a class="dropdown-item" href="#">Report user</a>
                      <a class="dropdown-item" href="#">Repost post</a>
                    </div>
                  </div>';
            echo '</div>';
            echo '<h2 class="post-title">' . $row['title'] . '</h2>';
            if (!empty($row['image']) && !empty($row['video'])) {
              echo '<div class="post-carousel">';
              echo '<div class="owl-carousel">'; // Add the owl-carousel container

              // Add carousel items for each post with the same postId
              while ($row['PostId'] === $postId) {
                echo '<div class="post-item">';
                echo '<img class="post-image" src="' . $row['image'] . '">';
                echo '</div>';
                // Fetch the next row
                // ...
              }

              echo '</div>'; // Close the owl-carousel container

              echo '<div class="post-video">'; // Add the video container
              echo '<div class="video-container">';
              echo '<video data-my-Video-id="' . $postId . '" id="myVideo-' . $postId . '" class="w-100">';
              echo '<source src="' . $row["video"] . '" type="video/mp4">';
              echo 'Your browser does not support the video tag.';
              echo '</video>';
              echo '<div class="video-controls">';
              echo '<button id="rewindButton-' . $postId . '" onclick="rewind(\'' . $postId . '\')"><i class="bi bi-rewind"></i></button>';
              echo '<button onclick="togglePlayPause(\'' . $postId . '\')">';
              echo '<span id="playPauseButton-' . $postId . '"><i class="bi bi-play"></i></span>';
              echo '</button>';
              echo '<button id="fastForwardButton-' . $postId . '" onclick="fastForward(\'' . $postId . '\')"><i class="bi bi-fast-forward"></i></button>';
              echo '<div class="volume-control">';
              echo '<input type="range" id="volumeRange-' . $postId . '" min="0" max="1" step="0.01" value="1" onchange="setVolume(\'' . $postId . '\')">';
              echo '</div>';
              echo '<div class="time-control">';
              echo '<input type="range" id="timeRange-' . $postId . '" min="0" step="0.01" value="0" onchange="setCurrentTime(\'' . $postId . '\')">';
              echo '<div class="time-display">';
              echo '<div class="currentTimeDisplay" id="currentTimeDisplay-' . $postId . '">0:00</div>';
              echo '<div class="durationDisplay" id="durationDisplay-' . $postId . '">0:00</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            } else if (!empty($row['image'])) {
              echo '<img class="post-image" src="' . $row['image'] . '">';
            } else if (!empty($row['video'])) {
              echo '<div class="post-video">';
              echo '<div class="video-container">';
              echo '<video data-my-Video-id="' . $postId . '" id="myVideo-' . $postId . '" class="w-100">';
              echo '<source src="' . $row["video"] . '" type="video/mp4">';
              echo 'Your browser does not support the video tag.';
              echo '</video>';
              echo '<div class="video-controls">';
              echo '<button id="rewindButton-' . $postId . '" onclick="rewind(\'' . $postId . '\')"><i class="bi bi-rewind"></i></button>';
              echo '<button onclick="togglePlayPause(\'' . $postId . '\')">';
              echo '<span id="playPauseButton-' . $postId . '"><i class="bi bi-play"></i></span>';
              echo '</button>';
              echo '<button id="fastForwardButton-' . $postId . '" onclick="fastForward(\'' . $postId . '\')"><i class="bi bi-fast-forward"></i></button>';
              echo '<div class="volume-control">';
              echo '<input type="range" id="volumeRange-' . $postId . '" min="0" max="1" step="0.01" value="1" onchange="setVolume(\'' . $postId . '\')">';
              echo '</div>';
              echo '<div class="time-control">';
              echo '<input type="range" id="timeRange-' . $postId . '" min="0" step="0.01" value="0" onchange="setCurrentTime(\'' . $postId . '\')">';
              echo '<div class="time-display">';
              echo '<div class="currentTimeDisplay" id="currentTimeDisplay-' . $postId . '">0:00</div>';
              echo '<div class="durationDisplay" id="durationDisplay-' . $postId . '">0:00</div>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
            echo '<p class="post-content">' . $row['content'] . '</p>';
            //   $date_posted = date_format($row['date_posted'], 'Y-m-d H:i:s');
            echo '<p class="post-date">' . $time_ago . '</p>';
            echo '</div>';
            echo '<div class="footer">
      <button type="button" class="btn btn-primary like ' . ($islikeing ? 'likeing' : 'unlike') . '" data-postid="' . $postId . '">
          <span class="like-count">' . $likes . '</span>
          <span class="emoji">&#x2764;</span>
          ' . ($islikeing ? 'Unlike' : 'Like') . '
      </button>
      <button type="button" class="btn btn-primary share-button" data-postid="' . $postId . '">
          <i class="bi bi-share"></i> Share
      </button>
      <button type="button" class="btn btn-primary comment-button" data-postid="' . $postId . '">
  <i class="bi bi-chat-dots"></i> Comment</button>

  </div>';
            echo '</div>';
            echo '<div class="modal fade" data-postid="' . $postId . '" id="blockTypeofPostModal-' . $postId . '" tabindex="-1" aria-labelledby="blockTypeofPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="blockTypeofPostModalLabel">Block Post</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Could you help us categorize what sort of post this is?</p>
          <div class="form-check">
            <input class="form-check-input blockpost" type="checkbox" value="" id="pornographic-content-posts">
            <label class="form-check-label" for="pornographic-content-posts">
              Pornographic content post
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockpost" type="checkbox" value="" id="racist-posts">
            <label class="form-check-label" for="racist-posts">
              Racist posts
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockpost" type="checkbox" value="" id="bloody-content-posts">
            <label class="form-check-label" for="bloody-content-posts">
              Bloody content posts
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockpost" type="checkbox" value="" id="flashy-content-posts">
            <label class="form-check-label" for="flashy-content-posts">
              Flashy content posts
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockpost" type="checkbox" value="" id="other-reason-posts">
            <label class="form-check-label" for="other-reason-posts">
              Other reason
            </label>
          </div>
          <div class="form-group mt-3 blockpost" id="other-reason-textbox-posts" style="display: none;">
            <label for="other-reason-text">Please specify:</label>
            <textarea class="form-control" id="other-reason-text-posts" rows="3"></textarea>
          </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-postid="' . $postId . '" onclick="blockPosts()">Block</button>
      </div>
    </div>
  </div>
</div>';
            echo '<div class="modal fade" data-recipient-id="' . $row['UserId'] . '" id="blockUserModal-' . $row['UserId'] . '" tabindex="-1" aria-labelledby="blockUserModalLabel" aria-hidden="true">
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="blockUserModalLabel">Block User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Why do you want to block this user?</p>
          <div class="form-check">
            <input class="form-check-input blockuser" type="checkbox" value="" id="pornographic-content">
            <label class="form-check-label " for="pornographic-content">
              Pornographic content
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockuser" type="checkbox" value="" id="not-a-fan-of-posts">
            <label class="form-check-label " for="not-a-fan-of-posts">
              Not a fan of user"s posts
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockuser" type="checkbox" value="" id="bloody-content">
            <label class="form-check-label " for="bloody-content">
              Bloody content
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockuser" type="checkbox" value="" id="flashy-content">
            <label class="form-check-label " for="flashy-content">
              Flashy content
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input blockuser" type="checkbox" value="" id="other-reason">
            <label class="form-check-label " for="other-reason">
              Other reason
            </label>
          </div>
          <div class="form-group mt-3" id="other-reason-textbox" style="display: none;">
            <label for="other-reason-text">Please specify:</label>
            <textarea class="form-control" id="other-reason-text" rows="3"></textarea>
          </div>
        </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" data-recipient-id="' . $row['UserId'] . '" onclick="blockUser()">Block</button>
  </div>
</div>
</div>
</div>';
            echo '</section>';
          }
          ?>
          <button id="scrollToTopBtn"><i class="bi bi-arrow-up-short"></i></button>
          <?php

          // Retrieve all the chats of the current user
          $sql = "SELECT DISTINCT recipientId FROM chats WHERE UserId = '$UserId' OR recipientId= '$UserId'";
          $stmt = sqlsrv_query($conn, $sql);
          if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
          }

          // Display the chats in a list on the sidebar
          echo '<!-- Button to open the sidebar -->
<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
    <i class="bi bi-chat"></i> Chats
</button>

<!-- Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
        <button type="button" class="btn-close text-reset close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">';

          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $recipientId = $row['recipientId'];

            // Get the name of the recipient
            $sql2 = "SELECT Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";

            $stmt2 = sqlsrv_query($conn, $sql2);
            if ($stmt2 === false) {
              die(print_r(sqlsrv_errors(), true));
            }

            $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
            $recipientName = $row2['Surname'] . ' ' . $row2['First_Name'];
            $Passport = $row2['Passport'];
            if (empty($Passport)) {
              $passportImage = "UserPassport/DefaultImage.png";
            } else {
              $passportImage = "UserPassport/" . $Passport;
            }

            // Display the recipient name and passport image in the list
            echo '<li>';
            echo '<div class="passport">';
            echo '<a>';
            echo '<img src="' . $passportImage . '" alt="' . $recipientName . '">';
            echo '</a>';
            echo '</div>';
            echo '<div class="name"><span><a href="chat.php?UserIdx=' . $recipientId . '">' . $recipientName . '</a></span></div>';
            echo '</li>';
          }

          echo '</ul>
    </div>
</div>';

          ?>
        </div>
      </div>
      <div class="col-3 comments-sidebar" id="commentSidebar">
        <div class="comment-input">
          <div class="emoji-picker">
            <button type="button" class="btn btn-primary emoji" onclick="toggleEmojiPicker()">
              <i class="fas fa-smile"></i>
            </button>
            <div class="emoji-table-container" style="display:none">
              <table>
                <tr>
                  <td onclick="insertEmoji('&#x1F600;')">😀</td>
                  <td onclick="insertEmoji('&#x1F601;')">😁</td>
                  <td onclick="insertEmoji('&#x1F602;')">😂</td>
                  <td onclick="insertEmoji('&#x1F603;')">😃</td>
                  <td onclick="insertEmoji('&#x1F604;')">😄</td>
                  <td onclick="insertEmoji('&#x1F605;')">😅</td>
                </tr>
                <tr>
                  <td onclick="insertEmoji('&#x1F606;')">😆</td>
                  <td onclick="insertEmoji('&#x1F607;')">😇</td>
                  <td onclick="insertEmoji('&#x1F608;')">😈</td>
                  <td onclick="insertEmoji('&#x1F609;')">😉</td>
                  <td onclick="insertEmoji('&#x1F610;')">😐</td>
                  <td onclick="insertEmoji('&#x1F611;')">😑</td>
                </tr>
                <!-- Add more rows and columns for additional emojis -->
                <tr>
                  <td onclick="insertEmoji('&#x1F60A;')">😊</td>
                  <td onclick="insertEmoji('&#x1F60B;')">😋</td>
                  <td onclick="insertEmoji('&#x1F60C;')">😌</td>
                  <td onclick="insertEmoji('&#x1F60D;')">😍</td>
                  <td onclick="insertEmoji('&#x1F60E;')">😎</td>
                  <td onclick="insertEmoji('&#x1F60F;')">😏</td>
                </tr>
                <tr>
                  <td onclick="insertEmoji('&#x1F612;')">😒</td>
                  <td onclick="insertEmoji('&#x1F613;')">😓</td>
                  <td onclick="insertEmoji('&#x1F616;')">😖</td>
                  <td onclick="insertEmoji('&#x1F615;')">😕</td>
                  <td onclick="insertEmoji('&#x1F617;')">😗</td>
                  <td onclick="insertEmoji('&#x1F618;')">😘</td>
                </tr>
                <tr>
                  <td onclick="insertEmoji('&#x1F619;')">😙</td>
                  <td onclick="insertEmoji('&#x1F61A;')">😚</td>
                  <td onclick="insertEmoji('&#x1F61B;')">😛</td>
                  <td onclick="insertEmoji('&#x1F61C;')">😜</td>
                  <td onclick="insertEmoji('&#x1F61D;')">😝</td>
                  <td onclick="insertEmoji('&#x1F61E;')">😞</td>
                </tr>
              </table>
            </div>
          </div>
          <textarea class="form-control" name="commentText" placeholder="Type your comment here" id="commentInput" rows="3"></textarea>
          <button type="button" class="btn btn-primary" onclick="submitComment()">Comment</button>
        </div>
        <div class="comments"></div>
      </div>
    </div>


  </div>
  </div>
  </div>
  <script src="js/jquery.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.comment-button').click(function() {
        var postId = $(this).data('postid');
        var commentsSidebar = $('#commentSidebar');

        $.ajax({
          type: "POST",
          url: "getCommentBox.php",
          data: {
            postId: postId
          },
          success: function(response) {
            commentsSidebar.find('.comments').html(response);
            commentsSidebar.show();
          }
        });
      });
    });
  </script>

</body>
<script src="js/owl.carousel.min.js"></script>
<script>
  document.addEventListener("click", function(event) {
    var notificationLink = document.getElementById("notificationLink");
    var notificationBox = document.getElementById("notificationBox");

    if (event.target !== notificationLink && !notificationLink.contains(event.target)) {
      notificationLink.parentElement.classList.remove("open");
    }
  });

  document.getElementById("notificationLink").addEventListener("click", function(event) {
    event.preventDefault();
    var parent = this.parentElement;
    parent.classList.toggle("open");
  });
</script>
<script>
  $(document).ready(function() {
    $(".owl-carousel").owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: false
      // You can customize other options according to your needs
    });
  });
</script>


<script>
  // Get postId from URL parameter
  var urlParams = new URLSearchParams(window.location.search);
  var postId = urlParams.get('postId');

  // Scroll to post with matching id
  if (postId) {
    var postElement = document.getElementById('post-' + postId);
    if (postElement) {
      postElement.scrollIntoView();
    }
  }
</script>
<script>
  $(document).ready(function() {
    var UserId = "<?php echo $_SESSION['UserId']; ?>";

    $(".like").click(function() {
      var likeBtn = $(this);
      var islikeing = likeBtn.hasClass('likeing');
      var postId = likeBtn.data('postid');
      // alert(postId);

      $.ajax({
        url: "like_posts.php",
        type: "POST",
        data: {
          like: 1,
          postId: postId,
          UserId: UserId,
          islikeing: islikeing ? 0 : 1
        },
        success: function(response) {
          alert(response);
          if (response === 'liked') {
            likeBtn.addClass('likeing');
          } else if (response === 'unliked') {
            likeBtn.removeClass('likeing');
          }

          var likeCount = likeBtn.parent().find('.like-count');
          if (likeCount.length) {
            likeCount.text(response.numLikes);
          }
          $("#" + postId + " .footer").load(location.href + " #" + postId + " .footer > *");

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Set the time after which the refresh button will appear (in milliseconds)
    var refreshTime = 120000; // 2 minutes

    setTimeout(function() {
      // Add refresh button to the top of the page
      $('body').prepend('<button class="refresh-button"><i class="bi-arrow-clockwise"></i></button>');
      // Position the refresh button at the top center
      $('.refresh-button').css({
        'position': 'fixed',
        'top': '80px',
        'left': '50%',
        'transform': 'translateX(-50%)',
        'z-index': '999',
        'background-color': 'white',
        'color': 'black',
        'border': 'none',
        'border-radius': '50%',
        'font-size': '30px',
      });
    }, refreshTime);

    // Refresh button click event
    $('body').on('click', '.refresh-button', function() {
      location.reload();
    });
  });
</script>
<script>
  function insertEmoji(emoji) {
    var textarea = document.querySelector("#commentInput");
    textarea.value += emoji;
  }
</script>
<script>
  function toggleEmojiPicker() {
    var container = document.querySelector(".emoji-table-container");
    if (container.style.display === "none") {
      container.style.display = "block";
    } else {
      container.style.display = "none";
    }
  }
</script>

<script>
  // COMMENT SECTION
  function submitComment() {
    var comment = $("#commentInput").val();
    var UserId = "<?php echo $UserId ?>";
    var postId = $("#postId").val(); // Retrieve the post ID from the hidden input field

    // Do something with the comment, e.g. send it to the server using AJAX
    if (comment != "") {
      $.ajax({
        url: "comment_post.php",
        type: "POST",
        async: false,
        data: {
          "addcoment": 1,
          "postId": postId,
          "comment": comment,
          "UserId": UserId,
        },
        success: function(data) {
          alert(data)
          $("#commentInput").val("");
        }
      });
    } else {
      alert("Field Missing");
    }

  }
</script>

<script>
  var UserId = <?php echo json_encode($UserId); ?>;
  // Share button
  $(document).on('click', '.share-button', function() {
    var postId = $(this).data('postid');
    var shareUrl = 'http://localhost:8080/offeyicialchatroom/index.php?postId=' + postId;
    prompt('Copy this link to share:', shareUrl);
  });
</script>
<script>
  $(document).ready(function() {
    $("#search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      if (value === "") {
        // Clear the table if the search box is empty
        //   $('#user_table').val('');

        $("#user_table").html("");
      } else {
        // Run the search function if the search box is not empty
        $("#user_table tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      }
    });
  });
</script>
<script>
  const searchBox = document.getElementById('search');
  const resultsDiv = document.getElementById('user_table');

  searchBox.addEventListener('input', function() {
    const searchTerm = this.value;

    // Clear the results if the search box is empty
    if (!searchTerm.trim()) {
      resultsDiv.innerHTML = '';
      return;
    }

    $(document).ready(function() {
      $("#search").on("keyup", function() {
        var searchValue = $(this).val().toLowerCase();
        if (searchValue === "") {
          $("#user_table").removeClass("show").html("");
        } else {
          $.ajax({
            url: "searchbackend.php",
            method: "POST",
            data: {
              search_query: searchValue
            },
            success: function(data) {
              $("#user_table").addClass("show").html(data);
            }
          });
        }
      });

      $(document).on("click", function(e) {
        // Check if the click is outside the search box and user table
        if (!$(e.target).closest(".search-container, #user_table").length) {
          $("#user_table").removeClass("show").html("");
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Show or hide the button depending on the scroll position
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#scrollToTopBtn').fadeIn();
      } else {
        $('#scrollToTopBtn').fadeOut();
      }
    });

    // Scroll to top when the button is clicked
    $('#scrollToTopBtn').click(function() {
      $('html, body').animate({
        scrollTop: 0
      }, 10);
      return false;
    });
  });
</script>
<script>
  // Declare myVideo as a global variable
  let myVideo;

  function togglePlayPause(postId) {
    const playPauseButton = document.getElementById("playPauseButton-" + postId);
    const myVideo = document.getElementById("myVideo-" + postId);

    if (myVideo.paused) {
      myVideo.play();
      playPauseButton.innerHTML = "<i class='bi bi-pause-circle-fill'></i>";
    } else {
      myVideo.pause();
      playPauseButton.innerHTML = "<i class='bi bi-play'></i>";
    }
  }

  function rewind(postId) {
    const myVideo = document.getElementById("myVideo-" + postId);
    myVideo.currentTime -= 10;
  }

  // <i class="bi bi-fast-forward"></i>
  function fastForward(postId) {
    const myVideo = document.getElementById("myVideo-" + postId);
    myVideo.currentTime += 10;
  }

  // Set volume
  (function() {
    function setVolume(postId) {
      var video = document.getElementById('myVideo-' + postId);
      var volumeRange = document.getElementById('volumeRange-' + postId);

      // Set the volume of the video
      video.volume = volumeRange.value;
    }

    // Update the volume range when the video is loaded
    window.addEventListener('DOMContentLoaded', function() {
      var videos = document.getElementsByTagName('video');

      for (var i = 0; i < videos.length; i++) {
        (function() {
          var video = videos[i];
          var postId = video.getAttribute('data-my-Video-id');
          var volumeRange = document.getElementById('volumeRange-' + postId);

          // Update the volume range as the volume changes
          video.addEventListener('volumechange', function() {
            volumeRange.value = video.volume;
          });

          // Set the setVolume function with the postId argument
          volumeRange.oninput = function() {
            setVolume(postId);
          };
        })();
      }
    });
  })();


  function setCurrentTime(postId) {
    return function() {
      var video = document.getElementById('myVideo-' + postId);
      var timeRange = document.getElementById('timeRange-' + postId);
      var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

      // Calculate the new time based on the range value
      var newTime = video.duration * (timeRange.value / 100);

      // Set the current time of the video
      video.currentTime = newTime;

      // Update the current time display
      currentTimeDisplay.innerHTML = formatTime(video.currentTime);
    };
  }

  // Helper function to format time in HH:MM:SS format
  function formatTime(time) {
    var minutes = Math.floor(time / 60);
    var seconds = Math.floor(time % 60);

    // Add leading zeros if necessary
    minutes = String(minutes).padStart(2, '0');
    seconds = String(seconds).padStart(2, '0');

    return minutes + ':' + seconds;
  }

  // Update the time range and duration display when the video is loaded
  window.addEventListener('DOMContentLoaded', function() {
    var videos = document.getElementsByTagName('video');

    for (var i = 0; i < videos.length; i++) {
      (function() {
        var video = videos[i];
        var postId = video.getAttribute('data-my-Video-id');
        var timeRange = document.getElementById('timeRange-' + postId);
        var durationDisplay = document.getElementById('durationDisplay-' + postId);

        // Update the duration display
        video.addEventListener('loadedmetadata', function() {
          durationDisplay.innerHTML = formatTime(video.duration);
        });

        // Update the time range as the video progresses
        video.addEventListener('timeupdate', function() {
          var currentTime = video.currentTime;
          var duration = video.duration;

          // Calculate the percentage of progress
          var progress = (currentTime / duration) * 100;

          // Set the value of the time range
          timeRange.value = progress;

          // Update the current time display
          var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);
          currentTimeDisplay.innerHTML = formatTime(currentTime);
        });

        // Set the setCurrentTime function with the postId argument
        timeRange.onchange = setCurrentTime(postId);
      })();
    }
  });
</script>
<!-- <script>
  $("blockUserModal-"+postId).on('hidden.bs.modal', function () {
    $('input[type="checkbox"]').prop('checked', false);
  })
</script> -->
<script>
  $(document).ready(function() {
    // Add event listener to "other reason" checkbox
    $('#other-reason').on('change', function() {
      if ($(this).is(':checked')) {
        $('#other-reason-textbox').show();
      } else {
        $('#other-reason-textbox').hide();
      }
    });

    // Add event listener to all checkboxes
    $(".blockuser").on('change', function() {
      if ($(this).is(':checked')) {
        alert($(this).siblings('label').text());
      }
    });
  });


  function blockUser() {
    // Get the values of all the form elements
    const checkboxes = document.querySelectorAll('.blockuser');
    const checkedCheckboxes = [];
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        checkedCheckboxes.push(checkbox.id);
      }
    });
    if (checkedCheckboxes.length > 0) {
      alert('Checked checkboxes: ' + checkedCheckboxes.join(', '));
    } else {
      alert('Please select at least one checkbox.');
    }

    const recipientId = $(event.target).data('recipient-id');
    alert(recipientId);
    // Get the selected reasons for blocking the user
    const pornographicContent = $('#blockUserModal-' + recipientId + ' #pornographic-content').is(':checked');
    const notAFanOfPosts = $('#blockUserModal-' + recipientId + ' #not-a-fan-of-posts').is(':checked');
    const bloodyContent = $('#blockUserModal-' + recipientId + ' #bloody-content').is(':checked');
    const flashyContent = $('#blockUserModal-' + recipientId + ' #flashy-content').is(':checked');
    const otherReasonCheckbox = $('#blockUserModal-' + recipientId + ' #other-reason').is(':checked');
    const otherReasonTextbox = $('#blockTypeofPostModal-' + recipientId + ' #other-reason-textbox').val();

    const form = new FormData();
    form.append("recipientId", recipientId);
    form.append("pornographicContent", pornographicContent);
    form.append("notAFanOfPosts", notAFanOfPosts);
    form.append("bloodyContent", bloodyContent);
    form.append("flashyContent", flashyContent);
    form.append("otherReason", otherReasonCheckbox);
    form.append("otherReasonText", otherReasonTextbox);

    $.ajax({
      url: 'blockuser.php',
      type: 'POST',
      data: form,
      processData: false,
      contentType: false,
      success: function(response) {
        console.log(response);
        alert("User blocked successfully.");
      },
      error: function(error) {
        console.error(error);
        alert("An error occurred while blocking the user. Please try again later.");
      }
    });
  }
</script>
<script>
  $(document).ready(function() {
    // Add event listener to "other reason" checkbox
    $('#other-reason-posts').on('change', function() {
      if ($(this).is(':checked')) {
        $('#other-reason-textbox-posts').show();
      } else {
        $('#other-reason-textbox-posts').hide();
      }
    });

    // Add event listener to all checkboxes
    $(".blockpost").on('change', function() {
      if ($(this).is(':checked')) {
        alert($(this).siblings('label').text());
      }
    });
  });
  //  check userId of the post before modal
  // $(document).on('click', '.blockButton', function() {
  //   var postId = $(this).data('postid');
  //   alert(postId);
  // });

  function blockPosts() {
    // Get the values of all the form elements
    const checkboxes = document.querySelectorAll('.blockpost');
    const checkedCheckboxes = [];
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        checkedCheckboxes.push(checkbox.id);
      }
    });
    if (checkedCheckboxes.length > 0) {
      alert('Checked checkboxes: ' + checkedCheckboxes.join(', '));
    } else {
      alert('Please select at least one checkbox.');
    }

    const postId = $(event.target).closest('.modal').data('postid');
    // Retrieve the post ID from the hidden input field
    alert(postId);
    const pornographicContentPosts = $('#blockTypeofPostModal-' + postId + ' #pornographic-content-posts').is(':checked');
    alert(pornographicContentPosts);
    const racistPosts = $('#blockTypeofPostModal-' + postId + ' #racist-posts').is(':checked');
    alert(racistPosts);
    const bloodyContentPosts = $('#blockTypeofPostModal-' + postId + ' #bloody-content-posts').is(':checked');
    alert(bloodyContentPosts);
    const flashyContentPosts = $('#blockTypeofPostModal-' + postId + ' #flashy-content-posts').is(':checked');
    alert(flashyContentPosts);
    const otherReasonCheckboxPosts = $('#blockTypeofPostModal-' + postId + ' #other-reason-posts').is(':checked');
    alert(otherReasonCheckboxPosts);
    const otherReasonTextPosts = $('#blockTypeofPostModal-' + postId + ' #other-reason-text-posts').val();

    // Assuming you want to submit the form data to a server endpoint using JavaScript fetch API:
    const form = new FormData();
    form.append("postId", postId);
    form.append("pornographicContentPosts", pornographicContentPosts);
    form.append("racistPosts", racistPosts);
    form.append("bloodyContentPosts", bloodyContentPosts);
    form.append("flashyContentPosts", flashyContentPosts);
    form.append("otherReasonCheckboxPosts", otherReasonCheckboxPosts);
    form.append("otherReasonTextPosts", otherReasonTextPosts);
    form.append("checkedCheckboxes", checkedCheckboxes);

    $.ajax({
      url: 'blockpost.php',
      type: 'POST',
      data: form,
      processData: false,
      contentType: false,
      success: function(response) {
        // confirm what is being said in the console
        console.log(response);
        if (response == "success") {
          console.log(response);
          alert("Post type blocked successfully.");
          // alert checked checkbox
          alert(checkedCheckboxes);
          $('#blockTypeofPostModal-' + postId).modal('hide');
        }
      },
      error: function(response) {
        console.error(response);
        alert("An error occurred while blocking the type of post. Please try again later.");
      }
    });
  }
</script>

</html>