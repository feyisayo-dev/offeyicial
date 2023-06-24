<?php
session_start();
// Check if user is logged in
?>
<?php
include 'db.php';
$UserId = $_SESSION['UserId'];
// Get the surname and first name of the user with the UserId from the database
$rsql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
$rstmt = sqlsrv_prepare($conn, $rsql);
if (sqlsrv_execute($rstmt)) {
  while ($row = sqlsrv_fetch_array($rstmt, SQLSRV_FETCH_ASSOC)) {
    $Surname = $row['Surname'];
    $First_Name = $row['First_Name'];
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Chat~<?php echo $Surname . " " . $First_Name; ?></title>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <link rel="stylesheet" href="css\all.min.css">
  <link rel="stylesheet" href="css\font\bootstrap-icons.css">
  <link rel="stylesheet" href="css\fontawesome.min.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/aos.css" rel="stylesheet">
  <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="css/remixicon/remixicon.css" rel="stylesheet">
  <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="js/twemoji.min.js"></script>




  <style>
    @font-face {
      font-family: 'Modern-Age';
      src: url('fonts/Modern-Age.ttf');
    }

    body {
      background-color: #f2f2f2;
    }

    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      background-color: #f8f9fa;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    nav a {
      color: #212529;
      text-decoration: none;
      margin-left: 20px;
      font-size: 16px;
    }

    nav a:hover {
      color: aliceblue;
    }

    nav i {
      margin-right: 5px;
    }

    nav .profile {
      display: flex;
      align-items: center;
      margin-left: auto;
      font-size: 14px;
    }

    nav .profile-name {
      margin-left: 10px;
    }



    .chat-container {
      width: 100%;
      /* margin: 50px auto; */
      background-color: #f2f2f2;
      border-radius: 10px;
      /* padding: 20px; */
    }

    .chat-header {
      text-align: left;
      /* height: 70px; */
      background-color: #bed2e4;
      color: white;
      padding: 6px;
    }

    .recipientPassport {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }

    .chat-header h1 {
      margin: 0;
    }

    .chat-messages {
      height: 300px;
      overflow-y: scroll;
      padding: 20px;
    }

    .chat-messages ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .chat-messages li {
      display: flex;
      align-items: flex-start;
      margin-bottom: 10px;
    }

    .chatbox {
      background-color: #f2f2f2;
      height: calc(100vh - 200px);
      overflow-y: scroll;
      padding: 10px;
      position: relative;
      width: 100%;
      overflow: hidden;
    }

    .Sent {
      float: right;
      background: linear-gradient(to bottom, darkturquoise 0%, aliceblue 100%);
      color: #444;
      padding: 8px;
      border-radius: 10px;
      margin-top: 10px;
      margin-left: auto;
      max-width: 75%;
      word-wrap: break-word;
      clear: both;
    }

    .received {
      float: left;
      background: linear-gradient(to bottom, white 0%, #b4b1e6 100%);
      color: #444;
      padding: 8px;
      border-radius: 10px;
      margin-top: 10px;
      margin-right: auto;
      max-width: 75%;
      word-wrap: break-word;
      clear: both;
    }

    .image {
      text-align: center;
    }

    .image img {
      max-width: 100%;
      max-height: 300px;
      border-radius: 10px;
      margin-top: 10px;
    }

    .message {
      margin-bottom: 5px;
    }

    .chat-input {
      display: flex;
      padding: 20px;
      background-color: #f2f2f2;
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .chat-input input[type="text"] {
      flex: 1;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 10px;
      box-shadow: 2px 2px 2px blue;
    }


    button[type="submit"] {
      padding: 12px 20px;
      background-color: darkturquoise;
      color: white;
      border: none;
      border-radius: 5px;
      margin-left: 10px;
    }

    .image-icon {
      display: inline-block;
      cursor: pointer;
    }

    /* .image-icon i {
                font-size: 25px;
                color: gray;
            } */

    .image-input {
      /* display: none; */
      width: 180px;
      background-color: aliceblue;
      color: white;
    }

    textarea {
      width: 100%;
      height: 30px;
      padding: 5px;
      font-size: 16px;
      font-family: montserrat;
      resize: none;
      border-radius: 10px;
      box-shadow: 2px 2px 2px aliceblue;
    }

    .message-sender {
      font-size: 12px;
      color: black;
    }

    .chats {
      height: auto;
      background: auto;
      border: 4px;
    }

    .image-input {
      opacity: 0;
      position: absolute;
      pointer-events: none;
    }

    .custom-file-label {
      cursor: pointer;
      color: darkturquoise;
    }

    .custom-file-label:hover {
      transform: scaleX(1.05);
    }

    .icon {
      position: relative;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      color: white;
      text-transform: capitalize;
    }

    .call-icon {
      float: right;
      margin-top: 10px;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      color: white;
      margin-right: 30px;
    }

    .call-icon:hover {
      transform: scale(1.05);
      color: white;
    }

    .navbar form {
      display: inline-block;
      margin-left: 20px;
    }

    .searchtext {
      background-color: #f2f2f2;
      border: none;
      padding: 8px;
      font-size: 16px;
      width: 200px;
      border-radius: 10px;
    }

    /* searchdropdown */
    .search-container {
      position: relative;
    }

    #user_table {
      list-style: none;
      padding: 0;
      margin: 0;
      width: 100%;
      position: absolute;
      z-index: 9999;
      background-color: #fff;
      /* border: 1px solid #ddd; */
      border-top: none;
    }

    #user_table li {
      padding: 8px 12px;
      cursor: pointer;
    }

    #user_table li:hover {
      background-color: #f2f2f2;
    }

    .video-input {
      opacity: 0;
      position: absolute;
      pointer-events: none;
    }

    .custom-file-label {
      cursor: pointer;
    }

    .chatbox::-webkit-scrollbar-track {
      background-color: #f5f5f5;
    }

    /* Define the scrollbar width and color */
    .chatbox::-webkit-scrollbar {
      width: 8px;
      background-color: #f5f5f5;
    }

    /* Define the scrollbar thumb color */
    .chatbox::-webkit-scrollbar-thumb {
      background-color: #888;
      border-radius: 10px;
    }


    /* On hover, darken the scrollbar thumb color */
    .chatbox::-webkit-scrollbar-thumb:hover {
      background-color: aliceblue;
    }

    /* #videoPlayer {
  max-width: 100%;
  max-height: 100%;
  margin: auto;
} */



    /* Chat button */
    button[data-bs-target="#sidebar"] {
      position: absolute;
      top: 60px;
      right: 300px;
      z-index: 999;
      background-color: aliceblue;
      color: black;
      border: none;
      border-radius: 50px;
      padding: 15px 20px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.2s ease-in-out;
      width: 100px;
      /* set a fixed width */
      height: 50px;
      /* set a fixed height */
    }


    button[data-bs-target="#sidebar"]:hover {
      background-color: #128C7E;
      transform: scale(1.05);
      box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.2);
    }

    /* Sidebar */
    .offcanvas {
      position: fixed;
      bottom: 0;
      right: -350px;
      z-index: 9998;
      width: 350px;
      height: 100vh;
      padding: 0;
      background-color: #fff;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }

    .offcanvas.show {
      right: 0;
    }

    .offcanvas-header {
      padding: 15px;
      background-color: aliceblue;
      color: #fff;
    }

    .offcanvas-title {
      margin: 0;
      font-size: 1.5rem;
    }

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
      color: aliceblue;
    }

    li a {
      display: flex;
      align-items: center;
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

    /* Modal styles */
    .modal {
      display: none;
      /* Hide the modal by default */
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
      margin: 10% auto;
      width: 80%;
      max-width: 500px;
      background-color: aliceblue;
    }

    .modal img {
      width: 100%;
      height: auto;
      object-fit: contain;
      border-radius: 5px;
    }

    /* Show the modal when the passport image is clicked */
    .passport img:hover {
      cursor: pointer;
    }

    .modal.show {
      display: block;
    }

    nav .logo {
      font-size: 30px;
      margin: 0;
      padding: 0;
      line-height: 1;
      font-weight: 500;
      letter-spacing: 2px;
      text-transform: uppercase;
      font-family: Modern-Age;
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

    .emoji {
      color: darkturquoise;
      background-color: transparent;
      border: none;
    }

    .emoji:hover {
      background-color: transparent;
      border: none;
      color: aqua;
      transform: scaleX(1.05);
    }

    .emoji-picker {
      position: relative;
    }

    .emoji-table-container {
      position: absolute;
      top: -200px;
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

    .emoji-picker,
    .custom-file {
      display: inline-block;
      vertical-align: middle;
      margin-right: 10px;
    }

    .textsubmit {
      display: inline-block;
      vertical-align: middle;
    }

    .video-container {
      position: relative;
      width: 400px;
      height: 400px;
    }

    #videoplayer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .iframe {
      display: none;
    }

    #buttonplay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1;
    }

    #buttonplay.clicked {
      display: none;
    }

    .form-group {
      position: fixed;
      bottom: 10px;
      width: 100%;
      padding-top: 30px;
    }

    .preview img {
      max-width: 100%;
      /* max-height: 200px; */
      display: block;
      margin: 0 auto;
    }

    /* The Modal (background) */
    .modal {
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
      margin: 15% auto;
      /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      /* Could be more or less, depending on screen size */
    }

    /* Close Button */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Style the preview image or video */
    #image-preview,
    #video-preview {
      max-width: 100%;
      max-height: 100%;
      /* display: none; */
    }

    @media only screen and (max-width: 767px) {
      .message {
        font-size: 25px;
        margin-bottom: 5px;
      }
    }

    .call-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 9999;
    }

    .popup {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      padding: 4px 8px;
      background-color: #f5f5f5;
      border-radius: 4px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      z-index: 1;
    }

    .popup a {
      display: block;
      margin-bottom: 4px;
      font-size: 14px;
      color: #333;
      text-decoration: none;
    }

    .Sent {
      position: relative;
    }

    .Sent .popup {
      left: -70px;
    }

    .received {
      position: relative;
    }

    .received .popup {
      right: -70px;
    }

    .popup a:hover {
      background-color: #e6e6e6;
    }

    .changebackground {
      position: absolute;
      display: block;
      background-color: white;
      border: 1px solid #ccc;
      padding: 5px;
    }

    .theme-option {
      cursor: pointer;
      padding: 5px;
    }

    .theme-option:hover {
      background-color: #f2f2f2;
    }

    .dropdown {
      display: inline-block;
      position: relative;
      padding: 10px;
    }

    .dropdown-toggle.custom-toggle {
      background-color: transparent;
      border: none;
      padding: 0;
    }

    .dropdown-toggle.custom-toggle .dots {
      display: block;
      width: 3px;
      height: 3px;
      margin-bottom: 2px;
      background-color: #000;
      border-radius: 50%;
    }

    .dropdown-toggle::after {
      display: none;
    }

    .dropdown-menu {
      position: absolute;
      display: none;
      background-color: white;
      border: 1px solid #ccc;
      padding: 5px;
    }

    .dropdown-option {
      cursor: pointer;
      padding: 5px;
    }

    .dropdown-option:hover {
      background-color: #f2f2f2;
    }


    .dropdown-item {
      padding: 10px;
    }
  </style>
</head>

<body>

  <nav>

    <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>

    <div class="profile">
      <?php
      // session_start();

      // Connect to the database
      include 'db.php';

      $UserId = $_SESSION['UserId'];

      // Get the surname and first name of the user with the UserId from the database
      $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
      $stmt = sqlsrv_prepare($conn, $sql);
      if (sqlsrv_execute($stmt)) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
          $Surname = $row['Surname'];
          $First_Name = $row['First_Name'];
        }
      }
      ?>
      <div class="search-container">
        <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
        <div id="user_table">
          <!-- <ul>
            <li></li>
        </ul> -->
        </div>
      </div>


      <a href="user_profile.php?UserId=<?php echo $UserId ?>" class="profile-name"><i class="bi bi-person"></i><?php echo $Surname . " " . $First_Name; ?></a>
    </div>
  </nav>




  <div class="chat-container">
    <div class="chat-header">
      <h1>
        <?php
        include 'db.php';

        // Get the UserId of the user you are talking to
        $recipientId = $_GET['UserIdx'];

        // Get the name of the user you are talking to
        $sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (sqlsrv_execute($stmt)) {
          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $recipientSurname = $row['Surname'];
            $recipientFirstName = $row['First_Name'];
            $Passport = $row['Passport'];
            if (empty($Passport)) {
              $recipientPassport = "UserPassport/DefaultImage.png";
            } else {
              $recipientPassport = "UserPassport/" . $Passport;
            }
          }
        }

        $UserId = $_SESSION['UserId'];

        // Get the surname and first name of the user with the UserId from the database
        $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (sqlsrv_execute($stmt)) {
          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Surname = $row['Surname'];
            $First_Name = $row['First_Name'];
          }
          echo '<img class="recipientPassport" src="' . $recipientPassport . '">';
          echo '<a class="icon" href="user_profile.php?UserId=' . $recipientId . '">' . $recipientSurname . ' ' . $recipientFirstName . '</a>';
          // Add the reset button
          echo '<div class="dropdown">
                <button class="dropdown-toggle custom-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-target="#chtheme" aria-controls="chtheme">
                  <span class="dots"></span>
                  <span class="dots"></span>
                  <span class="dots"></span>
                </button>

                <ul class="dropdown-menu" id="chtheme" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#" onclick="resetTheme()">Reset Theme</a></li>
                </ul>
              </div>';
          echo '<a class="call-icon" id="callbtn"><i class="bi bi-telephone"></i></a>';
        }
        echo '</div>';
        ?>
        <div class="chatbox">

        </div>
        <br><br>


        <div class="form-group">
          <div class="row">
            <div class="foot">
              <div class="emoji-picker">
                <!-- emoji table code goes here -->
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
              <div class="custom-file">
                <input type="file" class="image-input" id="image" name="image" accept="image/*" onchange="previewImage()">
                <label class="custom-file-label" for="image"><i class="bi bi-image"></i></label>
              </div>
              <div class="custom-file">
                <input type="file" class="video-input" id="video" name="video" accept="video/*" onchange="previewVideo()">
                <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i></label>
              </div>


              <div class="d-flex" style="align-items:center">
                <textarea placeholder="Type in your message" class="form-control" id="message" rows="3"></textarea>
                <button type="submit" class="submit"><i class="bi bi-send"></i></button>
              </div>
            </div>
          </div>
        </div>
        <div class="footer">
          <?php

          // Retrieve all the chats of the current user
          $sql = "SELECT DISTINCT recipientId FROM chats WHERE UserId = '$UserId' OR recipientId= '$UserId'";
          $stmt = sqlsrv_query($conn, $sql);
          if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
          }

          // Display the chats in a list on the sidebar
          echo '<!-- Button to open the sidebar -->
<button id="sidebar-toggle" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
    <i class="bi bi-chat"></i></button>

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
            echo '<a data-bs-toggle="modal" data-bs-target="#profilepicturemodal">';
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


        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
          function resetTheme() {
            localStorage.removeItem('messageSentcolor');
            localStorage.removeItem('messageReceivedcolor');
            localStorage.removeItem('messageSentTheme');
            localStorage.removeItem('messageReceivedTheme');
            localStorage.removeItem('dropdownTheme');
            localStorage.removeItem('chatboxTheme');
            location.reload(); // Reload the page to apply the default theme
          }
        </script>
        <script>
          var sidebarToggle = document.getElementById('sidebar-toggle');

          sidebarToggle.addEventListener('mousedown', function(e) {
            // get the current position of the button
            var posX = e.clientX - sidebarToggle.offsetLeft;
            var posY = e.clientY - sidebarToggle.offsetTop;

            // make the button draggable
            document.addEventListener('mousemove', moveButton);

            function moveButton(e) {
              sidebarToggle.style.left = (e.clientX - posX) + 'px';
              sidebarToggle.style.top = (e.clientY - posY) + 'px';
            }

            // stop dragging the button when the mouse button is released
            document.addEventListener('mouseup', function() {
              document.removeEventListener('mousemove', moveButton);
            });
          });
        </script>
        <script>
          // Function to save the theme settings to localStorage
          function savechatheaderTheme(theme) {
            localStorage.setItem('dropdownTheme', theme);
          }

          // Function to apply the theme settings to the chatbox
          function applychatheaderTheme(theme) {
            var chatheader = document.querySelector('.chat-header');
            chatheader.style.backgroundColor = theme;
          }

          // Check if there are previously saved theme settings in localStorage
          var savedDropdownTheme = localStorage.getItem('dropdownTheme');
          if (savedDropdownTheme) {
            // Apply the saved theme settings
            applychatheaderTheme(savedDropdownTheme);
          }


          document.addEventListener('contextmenu', function(event) {
            var clickedElement = event.target;

            // Check if the clicked element is within a .chat-header element
            var chatHeader = clickedElement.closest('.chat-header');

            // Remove any existing dropdown menus except the one within the clicked .chat-header element
            var existingDropdownMenus = document.querySelectorAll('.dropdown-menu');
            existingDropdownMenus.forEach(function(dropdownMenu) {
              if (dropdownMenu !== chatHeader.querySelector('.dropdown-menu')) {
                dropdownMenu.remove();
              }
            });

            if (chatHeader) {
              event.preventDefault();

              var changeThemeOption = document.createElement('div');
              changeThemeOption.textContent = 'Change Theme';
              changeThemeOption.classList.add('dropdown-option');

              var dropdownMenu = document.createElement('div');
              dropdownMenu.classList.add('dropdown-menu');
              dropdownMenu.appendChild(changeThemeOption);

              // Append the dropdown menu to the clicked .chat-header element
              chatHeader.appendChild(dropdownMenu);


              var rect = event.target.getBoundingClientRect();
              dropdownMenu.style.top = '130px';
              dropdownMenu.style.right = '600px';

              changeThemeOption.addEventListener('click', function() {
                var newColor = prompt('Enter a new background color:');
                if (newColor !== null && newColor.trim() !== '') {
                  document.querySelector('.chat-header').style.backgroundColor = newColor;
                  // Save the new theme settings
                  savechatheaderTheme(newColor);
                  // Apply the new theme settings
                  applychatheaderTheme(newColor);
                }
              });

              // Remove the popup when the user clicks outside of it
              document.addEventListener('click', function(e) {
                if (dropdownMenu.contains(e.target)) {
                  dropdownMenu.remove();
                }
              });
            }
          });
        </script>
        <script>
          // Function to save the theme settings to localStorage
          function savebackgroundTheme(theme) {
            localStorage.setItem('chatboxTheme', theme);
          }


          // Function to apply the theme settings to the chatbox
          function applybackgroundTheme(theme) {
            var chatboxes = document.querySelectorAll('.chatbox, .chat-container');

            chatboxes.forEach(function(chatbox) {
              chatbox.style.backgroundColor = theme;
            });
          }

          // Check if there are previously saved theme settings in localStorage
          var savedChatboxTheme = localStorage.getItem('chatboxTheme');
          if (savedChatboxTheme) {
            // Apply the saved theme settings
            applybackgroundTheme(savedChatboxTheme);
          }

          document.addEventListener('contextmenu', function(event) {
            var clickedElement = event.target;

            // Check if the clicked element is within a .chatbox element
            var chatbox = clickedElement.closest('.chatbox, .chat-container');

            // Remove any existing dropdown menus except the one within the clicked chatbox element
            var existingBackgrounds = document.querySelectorAll('.changebackground');
            existingBackgrounds.forEach(function(background) {
              if (background !== chatbox.querySelector('.changebackground')) {
                background.remove();
              }
            });

            if (chatbox) {
              event.preventDefault();

              var changeThemeOption = document.createElement('div');
              changeThemeOption.textContent = 'Change Theme';
              changeThemeOption.classList.add('theme-option');

              var backgrounds = document.createElement('div');
              backgrounds.classList.add('changebackground');
              backgrounds.appendChild(changeThemeOption);

              // Append the dropdown menu to the clicked .chatbox element
              chatbox.appendChild(backgrounds);

              var rect = event.target.getBoundingClientRect();
              backgrounds.style.top = '130px';
              backgrounds.style.right = '600px';

              changeThemeOption.addEventListener('click', function() {
                var newColor = prompt('Enter a new background color:');
                if (newColor !== null && newColor.trim() !== '') {
                  chatbox.style.backgroundColor = newColor;
                  // Save the new theme settings
                  savebackgroundTheme(newColor);
                  // Apply the new theme settings
                  applybackgroundTheme(newColor);
                }
              });

              // Remove the popup when the user clicks outside of it
              document.addEventListener('click', function(e) {
                if (!backgrounds.contains(e.target)) {
                  backgrounds.remove();
                }
              });
            }
          });
        </script>

        <script>
          // Function to save the theme settings to localStorage
          function saveSentmessagebackgroundTheme(theme) {
            localStorage.setItem('messageSentcolor', theme);
          }

          // Function to save the theme settings to localStorage
          function saveReceivedmessagebackgroundTheme(theme) {
            localStorage.setItem('messageReceivedcolor', theme);
          }

          // Function to apply the theme settings to the chatbox
          function applySentmessagesbackgroundTheme(theme) {
            var sentbackground = document.querySelectorAll('.Sent');
            sentbackground.forEach(function(message) {
              message.style.backgroundColor = theme;
            });
          }

          // Function to apply the theme settings to the chatbox
          function applyReceivedmessagesbackgroundTheme(theme) {
            var receivedbackground = document.querySelectorAll('.received');
            receivedbackground.forEach(function(message) {
              message.style.backgroundColor = theme;
            });
          }

          // Function to save the theme settings to localStorage
          function saveSentmessageTheme(theme) {
            localStorage.setItem('messageSentTheme', theme);
            console.log('saved');
          }

          // Function to save the theme settings to localStorage
          function saveReceivedmessageTheme(theme) {
            localStorage.setItem('messageReceivedTheme', theme);
            console.log('saved');
          }

          // Function to apply the theme settings to the chatbox
          function applySentmessagesTheme(theme) {
            var sent = document.querySelectorAll('.Sent');
            sent.forEach(function(message) {
              message.style.background = theme;
            });
          }

          // Function to apply the theme settings to the chatbox
          function applyReceivedmessagesTheme(theme) {
            var received = document.querySelectorAll('.received');
            received.forEach(function(message) {
              message.style.background = theme;
            });
          }


          var lastTimestamp = Date.now();

          function checkForNewMessages() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                if (response.length > 0) {
                  lastTimestamp = response[response.length - 1].time_sent;
                  var chatbox = document.querySelector('.chatbox');
                  response.forEach(function(message) {
                    var div = document.createElement('div');
                    div.className = message.senderId == "<?php echo $UserId; ?>" ? 'Sent' : 'received';
                    div.innerHTML = '<div class="message">' + message.message + '</div>';
                    if (message.sent_image) {
                      div.innerHTML += '<div class="image"><img src="' + message.sent_image + '"></div>';
                    }
                    if (message.sent_video) {
                      div.innerHTML += '<div class="video-container"><div id="videoplayer"><video width="400" height="400" class="iframe" preload="none" controls autoplay="false"><source src="' + message.sent_video + '" type="video/mp4"></video><button type="button" id="buttonplay" class="btn btn-primary">Watch Video</button></div></div>';
                      // Add event listener to play the video when the "Watch Video" button is clicked
                      var videoPlayer = div.querySelector('video');
                      var playButton = div.querySelector('#buttonplay');
                      playButton.addEventListener('click', function() {
                        videoPlayer.style.display = 'block';
                        videoPlayer.play();
                        playButton.style.display = 'none';
                      });
                    }
                    chatbox.appendChild(div);


                    // Check if there are previously saved theme settings in localStorage
                    var savedSentmessagecolorTheme = localStorage.getItem('messageSentcolor');
                    if (savedSentmessagecolorTheme) {
                      // Apply the saved theme settings
                      applySentmessagesbackgroundTheme(savedSentmessagecolorTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var savedReceivedmessagecolorTheme = localStorage.getItem('messageReceivedcolor');
                    if (savedReceivedmessagecolorTheme) {
                      // Apply the saved theme settings
                      applyReceivedmessagesbackgroundTheme(savedReceivedmessagecolorTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var SavedmessageSentTheme = localStorage.getItem('messageSentTheme');
                    if (SavedmessageSentTheme) {
                      // Apply the saved theme settings
                      applySentmessagesTheme(SavedmessageSentTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var SavedmessageReceivedTheme = localStorage.getItem('messageReceivedTheme');
                    if (SavedmessageReceivedTheme) {
                      // Apply the saved theme settings
                      applyReceivedmessagesTheme(SavedmessageReceivedTheme);
                    }


                  });
                  chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom

                  // Add right-click event listener to each message div
                  var messageDivs = document.querySelectorAll('.message');
                  messageDivs.forEach(function(div) {
                    div.addEventListener('contextmenu', function(e) {
                      // Prevent default right-click menu from showing
                      e.preventDefault();
                      // Get the class of the clicked message
                      var clickedClass = e.target.parentNode.className;
                      // Remove any existing popup
                      var existingPopups = document.querySelectorAll('.popup');
                      existingPopups.forEach(function(popup) {
                        popup.remove();
                      });

                      // Get the class of the clicked message
                      var clickedClass = e.target.parentNode.className;

                      // Create new popup and position it beside the clicked message
                      var popup = document.createElement('div');
                      popup.className = 'popup';
                      popup.innerHTML = '<a class="delete" href="#">Delete</a><a class="reply" href="#">Reply</a><a class="change-theme" href="#">Change Theme</a>';

                      // Position the popup beside the clicked message
                      var messageRect = e.target.getBoundingClientRect();
                      var chatboxRect = chatbox.getBoundingClientRect();

                      // Calculate the popup's top and left positions
                      var popupTop = messageRect.top - chatboxRect.top + messageRect.height / 2 - popup.offsetHeight / 2;
                      var popupLeft;
                      if (clickedClass === 'Sent') {
                        popupLeft = messageRect.left - chatboxRect.left - popup.offsetWidth;
                      } else if (clickedClass === 'received') {
                        popupLeft = messageRect.left - chatboxRect.left + messageRect.width;
                      }

                      popup.style.top = popupTop + 'px';
                      popup.style.left = popupLeft + 'px';
                      // Add event listeners to delete, reply, and change theme options
                      var deleteBtn = popup.querySelector('.delete');
                      deleteBtn.addEventListener('click', function() {
                        // TODO: Implement delete functionality
                        // Hide the message from the user or recipient
                      });

                      var replyBtn = popup.querySelector('.reply');
                      replyBtn.addEventListener('click', function() {
                        // TODO: Implement reply functionality
                        // Show a reply form for the user to enter a reply message
                      });

                      var changeThemeBtn = popup.querySelector('.change-theme');
                      changeThemeBtn.addEventListener('click', function() {
                        // Check if change theme options already exist
                        var changeThemeOptions = popup.querySelector('.change-theme-options');
                        if (changeThemeOptions) {
                          // If change theme options already exist, remove them
                          changeThemeOptions.remove();
                        } else {
                          var changeThemeOptions = document.createElement('div');
                          changeThemeOptions.className = 'change-theme-options';
                          changeThemeOptions.innerHTML = '<a class="background-gradient" href="#">Change Background</a><a class="background-color" href="#">Change Background Color</a>';
                          popup.appendChild(changeThemeOptions);

                          var backgroundBtn = popup.querySelector('.background-gradient');
                          backgroundBtn.addEventListener('click', function(e) {
                            var newColor = prompt('Enter a new background gradient:');
                            if (newColor !== null && newColor.trim() !== '') {
                              if (clickedClass === 'Sent') {
                                var sentElements = document.querySelectorAll('.Sent');
                                sentElements.forEach(function(element) {
                                  element.style.background = newColor;
                                  // Save the new theme settings
                                  saveSentmessageTheme(newColor);
                                  // Apply the new theme settings
                                  applySentmessagesTheme(newColor);
                                });
                              } else if (clickedClass === 'received') {
                                var receivedElements = document.querySelectorAll('.received');
                                receivedElements.forEach(function(element) {
                                  element.style.background = newColor;
                                  // Save the new theme settings
                                  saveReceivedmessageTheme(newColor);
                                  // Apply the new theme settings
                                  applyReceivedmessagesTheme(newColor);
                                });
                              }
                            }
                          });



                          var backgroundcolorBtn = popup.querySelector('.background-color');
                          backgroundcolorBtn.addEventListener('click', function(e) {
                            var newColor = prompt('Enter a new background color:');
                            if (newColor !== null && newColor.trim() !== '') {
                              if (clickedClass === 'Sent') {
                                var sentElements = document.querySelectorAll('.Sent');
                                sentElements.forEach(function(element) {
                                  element.style.backgroundColor = newColor;
                                  // Save the new theme settings
                                  saveSentmessagebackgroundTheme(newColor);
                                  // Apply the new theme settings
                                  applySentmessagesbackgroundTheme(newColor);
                                });
                              } else if (clickedClass === 'received') {
                                var receivedElements = document.querySelectorAll('.received');
                                receivedElements.forEach(function(element) {
                                  element.style.backgroundColor = newColor;
                                  // Save the new theme settings
                                  saveRecievedmessagebackgroundTheme(newColor);
                                  // Apply the new theme settings
                                  applyReceivedmessagesbackgroundTheme(newColor);
                                });
                              }
                            }
                          });
                        }
                      });

                      // Add the popup to the chatbox
                      chatbox.appendChild(popup);

                      // Remove the popup when the user clicks outside of it
                      document.addEventListener('click', function(e) {
                        if (popup && !popup.contains(e.target)) {
                          popup.remove();
                        }
                      });
                    });
                  });
                }
              }
            };
            xhttp.open('POST', 'checkForNewMessages.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var UserId = '<?php echo $UserId; ?>';
            var recipientId = '<?php echo $_GET['UserIdx']; ?>';
            var data = 'UserId=' + UserId + '&recipientId=' + recipientId + '&timestamp=' + lastTimestamp;
            xhttp.send(data);
          }

          setInterval(checkForNewMessages, 500); // Call the function every 1 second
        </script>



        <script>
          function insertEmoji(emoji) {
            var textarea = document.querySelector("#message");
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
          function previewImage() {
            // Get the selected file
            var file = document.getElementById('image').files[0];
            // Create a FileReader object
            var reader = new FileReader();
            // Set the image source when the file is loaded
            reader.onload = function(e) {
              var imgModal = document.getElementById('image-modal');
              var imgPreview = document.getElementById('image-preview');
              imgPreview.src = e.target.result;
              imgModal.style.display = "block";
            }
            // Load the file as a data URL
            reader.readAsDataURL(file);
          }

          function previewVideo() {
            let fileInput = document.querySelector('.video-input');
            let file = fileInput.files[0];
            let videoPreview = document.querySelector('#video-preview');
            let videoModal = document.querySelector('#video-modal');
            let closeModal = videoModal.querySelector('.close');
            let reader = new FileReader();
            reader.addEventListener('load', function() {
              videoPreview.src = reader.result;
              videoModal.style.display = 'block';
            }, false);

            if (file) {
              reader.readAsDataURL(file);
            }
            closeModal.addEventListener('click', function() {
              videoModal.style.display = 'none';
              videoPreview.src = '';
            });
          }
          $(document).ready(function() {
            // Send the message
            $('.submit').click(function() {
              var message = $('#message').val();
              var image = $('.image-input').prop('files')[0];
              var UserId = '<?php echo $UserId; ?>';
              var recipientId = '<?php echo $_GET['UserIdx']; ?>';
              var video = $('#video').prop('files')[0];
              var formData = new FormData();
              formData.append('message', message);
              formData.append('image', image);
              formData.append('UserId', UserId);
              formData.append('recipientId', recipientId);
              formData.append('video', video);
              // Send the AJAX request
              $.ajax({
                url: 'send_message.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                  console.log(response);
                  $('#message').val('');
                }
              });
            });
          });
        </script>
        <script>
          $(document).ready(function() {
            $("#search").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              if (value === "") {
                // Clear the table if the search box is empty
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
            // Your search function here
            $("#search").on("keyup", function() {
              var search_query = $(this).val();
              $.ajax({
                url: "searchbackend.php",
                method: "POST",
                data: {
                  search_query: search_query
                },
                success: function(data) {
                  // Update the table with the returned results
                  $("#user_table").html(data);
                }
              });
            });
          });
        </script>

        <script>
          var recipientId = "<?php echo $recipientId ?>"
          $(document).ready(function() {
            $('#callbtn').click(function() {
              $.ajax({
                url: 'call.php?UserIdx=' + recipientId,
                success: function(response) {
                  $('#call-modal .modal-body').html(response);
                  $('#call-modal').modal('show');
                  $('#call-modal').find('#callbtn').click(function() {
                    $.ajax({
                      url: 'call.php?UserIdx=' + recipientId,
                      success: function(response) {
                        $('#call-modal .modal-body').html(response);
                      },
                      error: function() {
                        alert('Error calling server');
                      }
                    });
                  });
                  $('#call-modal').on('hide.bs.modal', function(e) {
                    if (!confirm('Are you sure you want to leave the call?')) {
                      e.preventDefault();
                      e.stopImmediatePropagation();
                    }
                  });
                },
                error: function() {
                  alert('Error calling server');
                }
              });
            });
          });
        </script>

        <!-- Call modal -->
        <div class="modal fade" id="call-modal" tabindex="-1" role="dialog" aria-labelledby="call-modal-label" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">
                  Call
                </h4>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <!-- response from call.php will be displayed here -->
              </div>
            </div>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="profilepicturemodal" tabindex="-1" role="dialog" aria-labelledby="profilepicturemodalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php
                include 'db.php';
                // Get the UserId of the user you are talking to
                $recipientId = $_GET['UserIdx'];
                // Fetch the passport image
                $sql = "SELECT Passport FROM User_Profile WHERE UserId = '$recipientId'";
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt === false) {
                  die(print_r(sqlsrv_errors(), true));
                }

                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                $Passport = $row['Passport'];
                if (empty($Passport)) {
                  $passportImage = "UserPassport/DefaultImage.png";
                } else {
                  $passportImage = "UserPassport/" . $Passport;
                }
                echo '<img id="modalImg" src="' . $passportImage . '">';

                ?>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div class="preview">
          <div id="image-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="image-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="image-modal-label">Image Preview</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <img id="image-preview" src="#" alt="Image Preview">
                </div>
              </div>
            </div>
          </div>
          <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="video-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="video-modal-label">Video Preview</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <video id="video-preview" src="#"></video>
                </div>
              </div>
            </div>
          </div>
        </div>
</body>

</html>