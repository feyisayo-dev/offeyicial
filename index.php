<?php
session_start();
$UserId = $_SESSION["UserId"];
include 'db.php';
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$UserId'";
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
    body {
      overflow-x: hidden;
    }

    .navbar-nav a {
      font-size: 15px;
      text-transform: uppercase;
      font-weight: 500;
    }

    /* .navbar-nav .search-container2 .searchtext2 {
      border-radius: 5px;
    } */
    .search-container {
      display: flex;
      align-items: center;
      background-color: #fafafa;
      border-radius: 8px;
      padding: 5px;
    }

    .search-container i {
      color: #8e8e8e;
      margin-right: 5px;
    }

    .search-container input.searchtext {
      border: none;
      background-color: transparent;
      font-size: 14px;
      outline: none;
      width: 100%;
    }

    .search-container input.searchtext::placeholder {
      color: #8e8e8e;
    }

    .navbar-light .navbar-brand {
      color: #000;
      font-size: 25px;
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 2px;
    }

    .navbar-collapse {
      width: 500px;
      align-items: center;
      display: flex;
      margin-right: 50px;
      justify-content: center;
    }

    .navbar-light .navbar-brand:focus,
    .navbar-light .navbar-brand:hover {
      color: #000;
    }

    .navbar-light .navbar-nav .navbar-link {
      color: #000;
    }

    .navbar-brand img {
      display: inline-block;
      height: 30px;
      /* adjust height as needed */
      margin-right: 10px;
      /* add some space between image and text */
    }

    .navbar-toggler {
      position: absolute;
      right: 0;
      top: 2px;
    }

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
      top: 0;
      /* background-color: #fff; */
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
    }

    .post-title h2 {
      text-transform: uppercase;
      font-size: 20px;
      font-family: Springlake;
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
      /* height: 200px; */
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

    .volume-control input[type=range] {
      -webkit-appearance: none;
      margin: 18px 0;
      width: 100%;
    }

    .volume-control input[type=range]:focus {
      outline: none;
    }

    .volume-control input[type=range]::-webkit-slider-runnable-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      background: linear-gradient(to right, green, red);
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
      border-radius: 1.3px;
      border: 0.2px solid #010101;
    }

    .volume-control input[type=range]::-webkit-slider-thumb {
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
      border: 1px solid #000000;
      height: 16px;
      width: 16px;
      border-radius: 50%;
      background: #ffffff;
      cursor: pointer;
      -webkit-appearance: none;
      margin-top: -6px;
    }

    .volume-control input[type=range]:focus::-webkit-slider-runnable-track {
      background: linear-gradient(to right, green, red);
    }

    .volume-control input[type=range]::-moz-range-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
      background: linear-gradient(to right, green, red);
      border-radius: 1.3px;
      border: 0.2px solid #010101;
    }

    .volume-control input[type=range]::-moz-range-thumb {
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
      border: 1px solid #000000;
      height: 16px;
      width: 16px;
      border-radius: 50%;
      background: #ffffff;
      cursor: pointer;
    }

    .volume-control input[type=range]::-ms-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      background: transparent;
      border-color: transparent;
      border-width: 16px 0;
      color: transparent;
    }

    .volume-control input[type=range]::-ms-fill-lower {
      background: #2a6495;
      border: 0.2px solid #010101;
      border-radius: 2.6px;
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
    }

    .volume-control input[type=range]::-ms-fill-upper {
      background: #3071a9;
      border: 0.2px solid #010101;
      border-radius: 2.6px;
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
    }

    .volume-control input[type=range]::-ms-thumb {
      box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d;
      border: 1px solid #000000;
      height: 16px;
      width: 16px;
      border-radius: 50%;
      background: #ffffff;
      cursor: pointer;
    }

    .volume-control input[type=range]:focus::-ms-fill-lower {
      background: #3071a9;
    }

    .volume-control input[type=range]:focus::-ms-fill-upper {
      background: #367ebd;
    }


    /* Time control */
    .time-control {
      display: flex;
      align-items: center;
    }

    /* .time-control input[type="range"] {
  flex-grow: 1;
  background: linear-gradient(to right, '.getRandomColor().', '.getRandomColor().');
} */
    .time-control input[type=range] {
      height: 8.4px;
      -webkit-appearance: none;
      margin: 10px 0;
      width: 100%;
      background-color: transparent;
    }

    .time-control input[type=range]:focus {
      outline: none;
    }

    .time-control input[type=range]::-webkit-slider-runnable-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      animate: 0.2s;
      box-shadow: 1px 1px 1px #002200;
      background: #205928;
      border-radius: 1px;
      border: 1px solid #18D501;
    }

    .time-control input[type=range]::-webkit-slider-thumb {
      box-shadow: 3px 3px 3px #00AA00;
      border: 2px solid #83E584;
      height: 20px;
      width: 20px;
      border-radius: 20px;
      background: #439643;
      cursor: pointer;
      -webkit-appearance: none;
      margin-top: -7px;
    }

    .time-control input[type=range]:focus::-webkit-slider-runnable-track {
      background: #205928;
    }

    .time-control input[type=range]::-moz-range-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      animate: 0.2s;
      box-shadow: 1px 1px 1px #002200;
      background: #205928;
      border-radius: 1px;
      border: 1px solid #18D501;
    }

    .time-control input[type=range]::-moz-range-thumb {
      box-shadow: 3px 3px 3px #00AA00;
      border: 2px solid #83E584;
      height: 23px;
      width: 23px;
      border-radius: 23px;
      background: #439643;
      cursor: pointer;
    }

    .time-control input[type=range]::-ms-track {
      width: 100%;
      height: 8.4px;
      cursor: pointer;
      animate: 0.2s;
      background: transparent;
      border-color: transparent;
      color: transparent;
    }

    .time-control input[type=range]::-ms-fill-lower {
      background: #205928;
      border: 1px solid #18D501;
      border-radius: 2px;
      box-shadow: 1px 1px 1px #002200;
    }

    .time-control input[type=range]::-ms-fill-upper {
      background: #205928;
      border: 1px solid #18D501;
      border-radius: 2px;
      box-shadow: 1px 1px 1px #002200;
    }

    .time-control input[type=range]::-ms-thumb {
      margin-top: 1px;
      box-shadow: 3px 3px 3px #00AA00;
      border: 2px solid #83E584;
      height: 23px;
      width: 23px;
      border-radius: 23px;
      background: #439643;
      cursor: pointer;
    }

    .time-control input[type=range]:focus::-ms-fill-lower {
      background: #205928;
    }

    .time-control input[type=range]:focus::-ms-fill-upper {
      background: #205928;
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
      /* background-color: #fff; */
      background-color: white;
      border: 1px solid #dddfe2;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: black;
    }

    .w-100 {
      /* height: 200px; */
      width: 100% !important;
    }

    .owl-carousel .owl-stage-outer {
      height: 200px;
    }

    .like:hover {
      background-color: #f0f2f5;
      border: 1px solid #dddfe2;
      transform: scaleX(1.05);
      color: black;
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
      /* background-color: #fff; */
      background-color: white;
      border: 1px solid #dddfe2;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: black;
    }

    .share-button:hover {
      background-color: #f0f2f5;
      border: 1px solid #dddfe2;
      transform: scaleX(1.05);
      color: black;
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
      display: inline-flex;
      align-items: center;
      padding: 8px 16px;
      /* background-color: #fff; */
      background-color: white;
      border: 1px solid #dddfe2;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      color: black;
    }

    .comment-button:hover {
      background-color: white;
      color: black;
      border: 1px solid #dddfe2;
      transform: scaleX(1.05);
    }

    .comment-button i {
      margin-right: 5px;
    }

    @media (max-width: 1053px) {
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

      .post-title {
        font-size: 10px;
      }

      /* Adjust spacing between elements */
      .post-header {
        margin-bottom: 10px;
      }

      .post-date {
        margin-top: 10px;
      }

      .post-author strong {
        font-size: 12px;
      }

      .refresh-button {
        top: 10px;
      }
    }

    /* Custom CSS for the sidebar
    .sidebar {
      width: 240px;
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
      padding: 18px 20px;
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
    } */

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
      text-decoration: none;
      color: black;
    }

    .post-name:hover {
      color: black;
      transform: scaleX(1.05);
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
      width: 40px;
      height: 40px;
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
      font-family: Modern-Age;
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
      left: 20px;
      width: max-content;
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

    .emoji img {
      width: 24px;
      height: 24px;
    }

    .emoji:hover {
      background-color: aliceblue;
      border: none;
      transform: scaleX(1.05);
    }

    .emoji:focus {
      background-color: aliceblue;
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

    .open-sidebar {
      background-color: #f0f0f0;
      padding: 10px;
      height: 100vh;
      overflow-y: auto;
      width: 300px;
      right: 0;
      max-width: 360px;
      top: 60px;
      position: fixed;
    }

    .comments-sidebar {
      display: none;
    }

    #user_table {
      display: none;
      background-color: white;
      padding: 10px;
    }

    .comments {
      margin-bottom: 10px;
    }

    .comment-input {
      padding: 10px;
      background-color: #fff;
      margin-top: 10px;
      margin-bottom: 10px;
      border-radius: 10px;
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
      background-color: #198754;
      color: white;
      border-radius: 10px;
      border: none;
    }

    .comment-input button:hover {
      background-color: white;
      color: black;
    }

    .addpost {
      margin-bottom: 20px;
      margin-top: 20px;
    }

    .addpost .input-group {
      border-radius: 10px;
      overflow: hidden;
    }

    .addpost .form-control {
      /* border: 1px solid black; */
      border-radius: 10px;
      padding: 10px;
      font-size: 16px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      background-color: #f0f0f0;
    }

    .addpost .input-group-append button {
      border-radius: 0 10px 10px 0;
      padding: 8px;
      color: #f0f0f0;
      padding: 8px 20px;
      background-color: #198754;
      border: 1px solid #198754;
    }

    .row {
      background-color: #f0f0f0;
    }

    .addpost .input-group-append button i {
      font-size: 20px;
    }

    .addpost .input-group-append .btn-primary {
      border-radius: 0 10px 10px 0;
      padding: 8px 20px;
      background-color: #198754;
      border: 1px solid #198754;
    }

    .addpost .input-group-append .btn-primary:hover {
      background-color: #198754;
      transform: scaleX(1.05);
    }

    .post-media {
      display: flex;
      justify-content: center;
      position: relative;
    }

    .post-item {
      margin-bottom: 30px;
    }

    .button {
      position: absolute;
      bottom: 0;
      display: flex;
      justify-content: center;
      width: 100%;
      margin-bottom: 10px;
    }

    .previous-button,
    .next-button {
      width: 30px;
      height: 30px;
      background: none;
      border: none;
      color: black;
      font-size: 14px;
      cursor: pointer;
      margin: 0 5px;
    }

    .next-button {
      margin-left: 40px;
    }

    .Activity {
      margin-left: 280px;
      color: black;
      font-family: Billabong;
    }

    .Activity h2 {
      font-size: 70px;
      text-transform: capitalize;
    }

    .btn-link:hover {
      color: black;
      transform: scaleX(1.05);
    }

    .btn-link {
      font-weight: 400;
      color: black;
      text-decoration: underline;
    }

    .nav-link img {
      height: 24px;
    }

    .search_box {
      width: 216px;
      height: 28px;
      display: flex;
      align-items: center;
      position: absolute;
      right: 40%;
    }

    .profile-button {
      height: 30px;
      width: 30px;
      border: none;
      outline: none;
      background-color: transparent;
    }

    .profile-button__picture img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      object-position: center;
      border: 1px solid white;
      box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
    }

    .icon {
      margin: 0 10px 0 0;
      background-color: transparent;
    }

    .container {
      max-width: 935px;
      margin-top: 90px;
    }

    .news-feed-container {
      max-width: 760px;
    }

    .name_div {
      display: flex;
      align-items: center;
      padding: 20px 8px 10px 0px;
      border-radius: 10px;
    }

    .pass_div {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
      border: 1px solid white;
      box-shadow: 0px 0px 5px 0px rgb(16 189 66 / 50%);
    }

    .name {
      color: black;
      font-family: Modern-Age;
      text-decoration: none;
      display: inline-block;
    }

    .name:hover {
      color: green;
    }

    .name_div:hover {
      transform: scaleX(1.05);
      background-color: #bfc3bf;
    }


    .search-containermodal {
      display: flex;
      align-items: center;
      background-color: #fafafa;
      border-radius: 8px;
      padding: 5px;
    }

    .search-containermodal i {
      color: #8e8e8e;
      margin-right: 5px;
    }

    .search-containermodal input.searchtext {
      border: none;
      background-color: transparent;
      font-size: 14px;
      outline: none;
      width: 100%;
    }

    .search-containermodal input.searchtext::placeholder {
      color: #8e8e8e;
    }

    /* Style for the search results container */
    #searchResults {
      margin-top: 10px;
      display: inline-flex;
    }

    /* Style for each search result */
    .search-result {
      border: 1px solid #ccc;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 10px;
      color: black;
      text-decoration: none;
      box-shadow: 2px 2px green;
    }

    .search-result:hover {
      color: white;
      background-color: #333;
      box-shadow: #04AA6D;
    }

    /* Style for search result title */
    .search-result h3 {
      margin: 0;
      font-size: 18px;
    }

    /* Style for search result content */
    .search-result p {
      margin: 5px 0;
      font-size: 14px;
    }

    /* Style for search result date */
    .search-result small {
      color: #666;
      font-size: 12px;
    }

    #close {
      color: white;
      background-color: red;
      border: none;
      border-radius: 10px;
    }

    #close:hover {
      color: red;
      background-color: white;
      transform: scaleX(1.05);
    }

    .close {
      background-color: transparent;
      border: none;
    }

    .header {
      display: flex;
      align-items: center;
      background-color: #fafafa;
      border-radius: 8px;
      padding: 5px;
    }

    .header i {
      color: #8e8e8e;
      margin-right: 5px;
    }

    .custom-file input {
      display: none;
    }
  </style>

</head>

<body>
  <div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="search_box">
        <div class="search-container">
          <i class="bi bi-search"></i>
          <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a onclick="window.location.href='home.php'"><img width="40" height="40" src="icons/home.png" class="icon" alt=""></a>
          </li>
          <li class="nav-item">
            <a onclick="window.location.href='#'" id="notificationLink"> <img width="40" height="40" src="icons/notification.png" class="icon" alt=""> </a>
            <div id="notificationBox">
              <!-- Content of the notification box goes here -->
              <!-- You can customize the content as per your requirements -->
            </div>
          </li>
          <li class="nav-item">
            <a onclick="window.location.href='reel.php'"> <img width="40" height="40" src="icons/reel.png" class="icon" alt=""></a>
          </li>
          <li class="nav-item">
            <a> <svg width="40" height="40" class="icon" data-bs-toggle="modal" data-bs-target="#searchfor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 100 100">
                <path fill="#c7ede6" d="M87.959,55.636c0.3-0.616,0.566-1.264,0.796-1.943c2.633-7.77-1.349-17.078-9.733-19.325c-0.906-11.384-8.906-19.193-17.941-20.526c-10.341-1.525-19.814,5.044-22.966,15.485c-3.799-1.346-7.501-1.182-10.99,0.857c-1.583,0.732-3.031,1.812-4.33,3.233c-1.907,2.086-3.147,4.719-3.652,7.495c-0.748,0.118-1.483,0.236-2.176,0.484c-4.04,1.449-6.589,4.431-7.288,8.923c-0.435,2.797,0.443,5.587,0.933,6.714c1.935,4.455,6.422,6.98,10.981,6.312c0.227-0.033,0.557,0.069,0.752,0.233c0.241,7.12,3.698,13.417,8.884,17.014c8.321,5.772,19.027,3.994,25.781-3.921c2.894,2.96,6.338,4.398,10.384,3.876c4.023-0.519,7.147-2.739,9.426-6.349c1.053,0.283,2.051,0.691,3.083,0.804c4.042,0.442,7.324-1.165,9.732-4.8c0.922-1.391,1.793-3.194,1.793-6.354C91.429,60.593,90.136,57.626,87.959,55.636z"></path>
                <path fill="#fdfcef" d="M76.064,49.008c0,0,11.691,0,11.762,0c2.7,0,4.888-2.189,4.888-4.889c0-2.355-1.666-4.321-3.884-4.784c0.026-0.206,0.043-0.415,0.043-0.628c0-2.796-2.267-5.063-5.063-5.063c-1.651,0-3.113,0.794-4.037,2.017c-0.236-3.113-3.017-5.514-6.27-5.116c-2.379,0.291-4.346,2.13-4.784,4.486c-0.14,0.756-0.126,1.489,0.014,2.177c-0.638-0.687-1.546-1.119-2.557-1.119c-1.85,0-3.361,1.441-3.48,3.261c-0.84-0.186-1.754-0.174-2.717,0.188c-1.84,0.691-3.15,2.423-3.227,4.387c-0.109,2.789,2.12,5.085,4.885,5.085c0.21,0,0.948,0,1.118,0h10.151"></path>
                <path fill="#472b29" d="M87.827,49.507H76.064c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h11.762c2.419,0,4.388-1.969,4.388-4.389c0-2.067-1.466-3.873-3.486-4.295c-0.255-0.053-0.426-0.293-0.394-0.552c0.023-0.186,0.039-0.374,0.039-0.565c0-2.517-2.047-4.563-4.563-4.563c-1.439,0-2.765,0.663-3.638,1.818c-0.125,0.166-0.339,0.237-0.54,0.178c-0.199-0.059-0.342-0.234-0.357-0.441c-0.104-1.377-0.779-2.671-1.85-3.549c-1.083-0.888-2.456-1.283-3.861-1.109c-2.166,0.266-3.956,1.943-4.353,4.081c-0.124,0.668-0.12,1.336,0.012,1.986c0.045,0.22-0.062,0.442-0.261,0.544c-0.198,0.105-0.443,0.06-0.595-0.104c-0.575-0.618-1.353-0.959-2.19-0.959c-1.569,0-2.878,1.227-2.981,2.793c-0.01,0.146-0.082,0.28-0.199,0.367c-0.117,0.088-0.268,0.12-0.408,0.089c-0.84-0.184-1.637-0.131-2.433,0.167c-1.669,0.628-2.836,2.211-2.903,3.939c-0.047,1.207,0.387,2.35,1.222,3.218c0.835,0.868,1.959,1.347,3.164,1.347h11.269c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5H61.639c-1.479,0-2.859-0.587-3.884-1.654c-1.025-1.065-1.558-2.468-1.5-3.949c0.083-2.126,1.51-4.069,3.551-4.836c0.8-0.3,1.627-0.399,2.468-0.299c0.376-1.822,1.997-3.182,3.905-3.182c0.684,0,1.354,0.18,1.944,0.51c0-0.385,0.035-0.772,0.107-1.158c0.476-2.562,2.62-4.574,5.215-4.892c1.681-0.205,3.32,0.266,4.616,1.328c1.003,0.823,1.716,1.951,2.038,3.192c1.012-0.915,2.319-1.425,3.713-1.425c3.067,0,5.563,2.496,5.563,5.563c0,0.083-0.002,0.166-0.007,0.248c2.254,0.673,3.848,2.776,3.848,5.164C93.215,47.09,90.798,49.507,87.827,49.507z"></path>
                <path fill="#fdfcef" d="M73.231,38.239c-1.808-0.119-3.365,1.13-3.476,2.789c-0.014,0.206-0.005,0.409,0.025,0.606c-0.349-0.394-0.865-0.661-1.458-0.7c-1.085-0.071-2.022,0.645-2.158,1.62c-0.197-0.054-0.403-0.09-0.616-0.104c-1.582-0.104-2.944,0.989-3.042,2.441"></path>
                <path fill="#472b29" d="M62.507,45.14c-0.006,0-0.012,0-0.017-0.001c-0.138-0.009-0.242-0.128-0.233-0.266c0.106-1.587,1.593-2.788,3.308-2.674c0.137,0.009,0.273,0.026,0.409,0.053c0.273-0.968,1.25-1.654,2.366-1.567c0.425,0.027,0.824,0.16,1.163,0.382c0.001-0.019,0.002-0.037,0.003-0.057c0.12-1.794,1.786-3.162,3.742-3.021c0.138,0.009,0.242,0.128,0.233,0.266c-0.009,0.138-0.124,0.255-0.266,0.232c-1.657-0.11-3.108,1.037-3.21,2.557c-0.013,0.185-0.005,0.37,0.023,0.552c0.017,0.109-0.041,0.218-0.141,0.265c-0.099,0.047-0.219,0.022-0.293-0.061c-0.322-0.364-0.779-0.583-1.288-0.617c-0.934-0.044-1.775,0.556-1.894,1.404c-0.01,0.071-0.05,0.135-0.11,0.175c-0.061,0.04-0.134,0.052-0.204,0.032c-0.187-0.051-0.377-0.083-0.567-0.097c-1.44-0.09-2.687,0.897-2.775,2.209C62.747,45.039,62.638,45.14,62.507,45.14z"></path>
                <path fill="#fdfcef" d="M89.806,39.907c-1.699-0.801-3.664-0.234-4.389,1.267c-0.09,0.186-0.157,0.379-0.201,0.574"></path>
                <path fill="#472b29" d="M85.216,41.998c-0.018,0-0.037-0.002-0.056-0.006c-0.134-0.031-0.219-0.165-0.188-0.3c0.049-0.215,0.123-0.426,0.219-0.626c0.784-1.622,2.903-2.241,4.721-1.385c0.125,0.06,0.179,0.208,0.12,0.333c-0.059,0.126-0.209,0.176-0.333,0.12c-1.574-0.743-3.393-0.227-4.058,1.148c-0.08,0.167-0.142,0.342-0.182,0.521C85.433,41.92,85.33,41.998,85.216,41.998z"></path>
                <path fill="#fff" d="M70.802 21.395h-10.03c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.03c.276 0 .5.224.5.5S71.078 21.395 70.802 21.395zM73.683 21.395h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S73.96 21.395 73.683 21.395zM77.738 21.395h-2.545c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.545c.276 0 .5.224.5.5S78.014 21.395 77.738 21.395zM75.712 17.666h-9.617c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.617c.276 0 .5.224.5.5S75.989 17.666 75.712 17.666zM64.364 17.666h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S64.64 17.666 64.364 17.666zM61.987 17.666h-1.456c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.456c.276 0 .5.224.5.5S62.264 17.666 61.987 17.666zM73.149 19.53h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S73.425 19.53 73.149 19.53z"></path>
                <path fill="#fff" d="M73.149 17.666h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S73.425 17.666 73.149 17.666zM66.666 19.53h-1.759c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.759c.276 0 .5.224.5.5S66.943 19.53 66.666 19.53z"></path>
                <path fill="#c0d078" d="M66.07,72.605H36.357c-3.766,0-6.847-3.081-6.847-6.847V36.045c0-3.766,3.081-6.847,6.847-6.847H66.07c3.766,0,6.847,3.081,6.847,6.847v29.713C72.918,69.524,69.836,72.605,66.07,72.605z"></path>
                <path fill="#472b29" d="M66.07,73.305H36.357c-4.162,0-7.547-3.386-7.547-7.547V36.046c0-4.162,3.386-7.548,7.547-7.548H66.07c4.162,0,7.548,3.386,7.548,7.548v29.713C73.618,69.92,70.232,73.305,66.07,73.305z M36.357,29.898c-3.39,0-6.147,2.758-6.147,6.147v29.713c0,3.39,2.757,6.146,6.147,6.146H66.07c3.39,0,6.147-2.757,6.147-6.146V36.046c0-3.39-2.758-6.147-6.147-6.147H36.357z"></path>
                <path fill="#fdfcee" d="M64.268,69.505H38.16c-3.052,0-5.549-2.497-5.549-5.549V37.847c0-3.052,2.497-5.549,5.549-5.549h26.109c3.052,0,5.549,2.497,5.549,5.549v26.109C69.817,67.008,67.32,69.505,64.268,69.505z"></path>
                <path fill="#472b29" d="M64.163 69.854H38.265c-3.311 0-6.004-2.692-6.004-6.003V37.953c0-3.311 2.693-6.004 6.004-6.004h24.663c.193 0 .35.156.35.35s-.157.35-.35.35H38.265c-2.924 0-5.304 2.38-5.304 5.305v25.898c0 2.924 2.379 5.304 5.304 5.304h25.898c2.925 0 5.304-2.38 5.304-5.304V49.524c0-.193.157-.35.35-.35s.35.156.35.35v14.327C70.167 67.162 67.473 69.854 64.163 69.854zM69.817 47.806c-.193 0-.35-.156-.35-.35v-2.756c0-.193.157-.35.35-.35s.35.156.35.35v2.756C70.167 47.65 70.011 47.806 69.817 47.806zM69.817 43.673c-.193 0-.35-.156-.35-.35v-1.378c0-.193.157-.35.35-.35s.35.156.35.35v1.378C70.167 43.516 70.011 43.673 69.817 43.673z"></path>
                <path fill="#fdfcef" d="M39.901,75.373c1.883,0,3.517,0,3.54,0c2.11,0,3.821-1.674,3.821-3.739c0-1.802-1.302-3.305-3.035-3.66c0.02-0.158,0.034-0.317,0.034-0.48c0-2.139-1.772-3.873-3.957-3.873c-1.29,0-2.433,0.607-3.155,1.543c-0.185-2.381-2.358-4.218-4.9-3.913c-1.859,0.223-3.397,1.629-3.739,3.431c-0.11,0.578-0.098,1.139,0.011,1.665c-0.498-0.525-1.208-0.856-1.998-0.856c-1.446,0-2.627,1.102-2.72,2.494c-0.657-0.142-1.371-0.133-2.123,0.143c-1.438,0.528-2.462,1.853-2.522,3.356c-0.085,2.133,1.657,3.889,3.818,3.889c0.164,0,0.741,0,0.874,0h7.934 M33.423,75.373h0.36"></path>
                <path fill="#472b29" d="M43.441,75.873h-3.541c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h3.541c1.831,0,3.32-1.453,3.32-3.239c0-1.524-1.108-2.858-2.635-3.17c-0.256-0.053-0.428-0.293-0.396-0.552c0.017-0.137,0.029-0.276,0.029-0.419c0-1.859-1.551-3.372-3.457-3.372c-1.092,0-2.098,0.491-2.759,1.348c-0.126,0.164-0.34,0.23-0.539,0.174c-0.198-0.06-0.339-0.234-0.355-0.44c-0.079-1.02-0.566-1.944-1.37-2.604c-0.829-0.681-1.886-0.979-2.973-0.853c-1.646,0.197-3.006,1.442-3.307,3.028c-0.094,0.493-0.091,0.988,0.01,1.471c0.045,0.219-0.06,0.441-0.258,0.545c-0.197,0.103-0.44,0.063-0.595-0.1c-0.429-0.451-1.01-0.7-1.636-0.7c-1.169,0-2.145,0.891-2.221,2.027c-0.01,0.146-0.082,0.278-0.198,0.366c-0.116,0.087-0.262,0.12-0.406,0.089c-0.639-0.137-1.243-0.098-1.845,0.125c-1.262,0.463-2.144,1.631-2.195,2.905c-0.035,0.876,0.283,1.709,0.895,2.346c0.635,0.66,1.496,1.024,2.423,1.024h8.808c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5h-8.808c-1.185,0-2.331-0.485-3.144-1.331c-0.803-0.836-1.219-1.929-1.173-3.078c0.067-1.675,1.212-3.204,2.85-3.806c0.609-0.224,1.239-0.305,1.88-0.244c0.344-1.396,1.629-2.424,3.135-2.424c0.493,0,0.977,0.113,1.414,0.323c0.009-0.242,0.037-0.484,0.083-0.727c0.382-2.009,2.097-3.585,4.17-3.833c1.364-0.168,2.685,0.218,3.726,1.071c0.748,0.613,1.279,1.409,1.547,2.302c0.791-0.647,1.785-1.006,2.842-1.006c2.458,0,4.457,1.961,4.457,4.372c0,0.034,0,0.068-0.001,0.103c1.764,0.555,3.003,2.188,3.003,4.038C47.762,73.971,45.824,75.873,43.441,75.873z M33.783,75.873h-0.359c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h0.359c0.276,0,0.5,0.224,0.5,0.5S34.059,75.873,33.783,75.873z"></path>
                <path fill="#472b29" d="M41.733 70.07c-.018 0-.037-.002-.055-.006-.135-.031-.219-.165-.188-.3.038-.166.094-.327.169-.479.605-1.225 2.273-1.678 3.722-1.006.125.058.18.206.122.331-.059.126-.206.18-.332.122-1.204-.556-2.578-.209-3.063.773-.058.117-.101.241-.13.369C41.951 69.991 41.848 70.07 41.733 70.07zM36.575 75.873h-1.107c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.107c.276 0 .5.224.5.5S36.851 75.873 36.575 75.873z"></path>
                <path fill="#fff" d="M17.889 50.679H7.859c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.03c.276 0 .5.224.5.5S18.165 50.679 17.889 50.679zM20.77 50.679h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S21.047 50.679 20.77 50.679zM24.825 50.679h-2.546c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.546c.276 0 .5.224.5.5S25.101 50.679 24.825 50.679zM24.825 52.545h-9.616c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.616c.276 0 .5.224.5.5S25.101 52.545 24.825 52.545zM13.477 52.545h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S13.753 52.545 13.477 52.545zM11.1 52.545H9.644c-.276 0-.5-.224-.5-.5s.224-.5.5-.5H11.1c.276 0 .5.224.5.5S11.377 52.545 11.1 52.545zM20.236 48.815h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S20.513 48.815 20.236 48.815zM20.236 46.95h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S20.513 46.95 20.236 46.95zM16.967 54.409h-1.758c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.758c.276 0 .5.224.5.5S17.244 54.409 16.967 54.409z"></path>
                <path fill="#472b29" d="M47.544,54.171c-0.128,0-0.256-0.049-0.354-0.146c-0.195-0.195-0.195-0.512,0-0.707l1.89-1.891c0.195-0.195,0.512-0.195,0.707,0s0.195,0.512,0,0.707l-1.89,1.891C47.8,54.122,47.672,54.171,47.544,54.171z"></path>
                <path fill="#88ae45" d="M39.442,61.772L39.442,61.772c-0.743-0.743-0.743-1.958,0-2.701l5.401-5.401c0.743-0.743,1.958-0.743,2.701,0h0c0.743,0.743,0.743,1.958,0,2.701l-5.401,5.401C41.4,62.514,40.185,62.514,39.442,61.772z"></path>
                <path fill="#472b29" d="M40.792,62.73c-0.591,0-1.183-0.225-1.633-0.675l0,0c-0.9-0.901-0.9-2.366,0-3.268l5.401-5.4c0.869-0.869,2.396-0.869,3.266,0c0.435,0.435,0.674,1.015,0.674,1.633s-0.239,1.198-0.674,1.634l-5.401,5.401C41.975,62.505,41.384,62.73,40.792,62.73z M39.725,61.489c0.589,0.59,1.546,0.59,2.135,0l5.401-5.401c0.284-0.283,0.44-0.663,0.44-1.067s-0.156-0.783-0.44-1.066c-0.568-0.569-1.568-0.569-2.135,0l-5.401,5.4C39.137,59.942,39.137,60.9,39.725,61.489L39.725,61.489z"></path>
                <path fill="#d1dc82" d="M47.343,53.864c-0.627-0.627-1.611-0.668-2.188-0.091l-0.105,0.105l0.228,0.228l2.051,2.051l0.105-0.105C48.011,55.475,47.97,54.49,47.343,53.864z"></path>
                <path fill="#472b29" d="M47.333,56.805c-0.096,0-0.192-0.037-0.265-0.109l-2.43-2.432c-0.146-0.146-0.146-0.384,0-0.53s0.384-0.147,0.53,0.001l2.43,2.43c0.146,0.146,0.146,0.385,0,0.531C47.525,56.769,47.43,56.805,47.333,56.805z"></path>
                <path fill="#77cbd2" d="M55.393 39.138A6.683 6.683 0 1 0 55.393 52.504A6.683 6.683 0 1 0 55.393 39.138Z" opacity=".74" transform="rotate(-45.001 55.392 45.822)"></path>
                <path fill="#e1e0d8" d="M61.316,39.897c-3.281-3.281-8.601-3.281-11.882,0c-3.281,3.281-3.281,8.601,0,11.882c3.281,3.281,8.601,3.281,11.882,0C64.598,48.499,64.598,43.179,61.316,39.897z"></path>
                <path fill="#472b29" d="M55.375 54.636c-2.254 0-4.508-.857-6.224-2.573-3.432-3.433-3.432-9.017 0-12.449 3.432-3.431 9.017-3.432 12.448 0 3.432 3.433 3.432 9.017 0 12.449C59.883 53.779 57.629 54.636 55.375 54.636zM55.375 37.84c-2.049 0-4.098.78-5.658 2.341-3.12 3.12-3.12 8.196 0 11.316 3.121 3.122 8.198 3.121 11.317 0 3.12-3.12 3.12-8.196 0-11.316C59.473 38.62 57.424 37.84 55.375 37.84zM40.37 62.429c-.053 0-.102-.034-.119-.087l-.935-2.905c-.021-.065.015-.136.081-.157.065-.021.136.016.157.081l.935 2.905c.021.065-.015.136-.081.157C40.395 62.427 40.383 62.429 40.37 62.429zM40.962 62.227c-.054 0-.104-.035-.12-.089l-1.06-3.56c-.02-.066.018-.137.084-.156.067-.015.136.019.155.084l1.06 3.56c.02.066-.018.137-.084.156C40.986 62.225 40.974 62.227 40.962 62.227zM41.319 60.976c-.054 0-.104-.035-.12-.089l-.887-2.979c-.02-.066.018-.137.084-.156.067-.015.136.019.155.084l.887 2.979c.02.066-.018.137-.084.156C41.343 60.974 41.331 60.976 41.319 60.976zM41.681 59.671c-.054 0-.104-.035-.12-.089l-.625-2.101c-.02-.066.018-.137.084-.156.066-.016.136.02.155.084l.625 2.101c.02.066-.018.136-.084.156C41.704 59.669 41.692 59.671 41.681 59.671z"></path>
                <path fill="#a8dbdb" d="M55.375 39.156A6.683 6.683 0 1 0 55.375 52.522A6.683 6.683 0 1 0 55.375 39.156Z" transform="rotate(-45.001 55.375 45.84)"></path>
                <path fill="#472b29" d="M55.375,52.847c-1.873,0-3.632-0.729-4.956-2.054c-1.323-1.323-2.052-3.083-2.052-4.955s0.729-3.632,2.052-4.955c1.324-1.324,3.083-2.054,4.956-2.054c1.872,0,3.632,0.729,4.956,2.054c1.324,1.323,2.053,3.083,2.053,4.955s-0.729,3.632-2.053,4.955l0,0l0,0C59.007,52.118,57.247,52.847,55.375,52.847z M55.375,39.48c-1.699,0-3.295,0.661-4.496,1.862c-1.201,1.201-1.862,2.798-1.862,4.496s0.661,3.295,1.862,4.496c1.201,1.201,2.797,1.862,4.496,1.862c1.698,0,3.295-0.661,4.496-1.862l0,0c1.201-1.201,1.863-2.798,1.863-4.496s-0.662-3.295-1.863-4.496C58.67,40.141,57.074,39.48,55.375,39.48z"></path>
              </svg> </a>
          </li>
          <li class="nav-item">
            <a onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>'"> <img width="40" height="40" src="icons/add.png" class="icon" alt=""> </a>
          </li>
          <li class="nav-item">
            <button onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'" class="profile-button">
              <div class="profile-button__picture">
                <img src="<?php echo $recipientPassport ?>" alt="User Picture" />
              </div>
            </button>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">

      <div class="news-feed-container">
        <div class="Activity">
          <h2>Rizz</h2>
        </div>
        <div class="addpost">
          <div class="input-group">
            <input class="form-control addnewpost" type="text" id="addnewpost" placeholder="Add New Post" title="Add New Post">
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#imagesmodal">
                <i class="bi bi-camera"></i>
              </button>
              <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#videosmodal">
                <i class="bi bi-film"></i>
              </button>
              <button class="btn btn-primary" id="postButton" type="button">Post</button>
            </div>
          </div>
        </div>

        <div id="newsFeed">
          <!-- Posts will be dynamically loaded here -->
        </div>
        <button id="scrollToTopBtn"><i class="bi bi-arrow-up"></i></button>
      </div>
      <div class="open-sidebar" id="open-sidebar">
        <div id="user_table" class="user-table"></div>
        <div class="comments-sidebar" id="commentSidebar">
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
            <textarea class="form-control" name="commentText" placeholder="Type your comment" id="commentInput" rows="3"></textarea>
            <button type="button" class="btn btn-primary" onclick="submitComment()">Comment</button>
          </div>
          <div class="comments"></div>
        </div>
      </div>
    </div>
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
  <div class="modal fade" id="searchfor" tabindex="-1" role="dialog" aria-labelledby="searchforLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="search-containermodal">
            <i class="bi bi-search"></i>
            <input class="searchtext" type="text" id="searchforthingsinput" placeholder="Search for posts.." title="Type in a name">
          </div>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img width="40" height="40" src="icons/close.png" class="icon" alt=""></span>
          </button>
        </div>
        <div class="modal-body">
          <div id="searchResults"></div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- //images modal -->
  <div class="modal fade" id="imagesmodal" tabindex="-1" role="dialog" aria-labelledby="searchforLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="header">
            <i class="bi bi-camera-fill"></i>
            Upload your images
          </div>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img width="40" height="40" src="icons/close.png" class="icon" alt=""></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" multiple>
            <label class="custom-file-label" for="image"><i class="bi bi-image"></i> Choose Images</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- //videos modal -->
  <div class="modal fade" id="videosmodal" tabindex="-1" role="dialog" aria-labelledby="searchforLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="header">
            <i class="bi bi-camera-reels-fill"></i>
            Upload your videos
          </div>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img width="40" height="40" src="icons/close.png" class="icon" alt=""></span>
          </button>
        </div>
        <div class="modal-body">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="video" name="video" accept="video/*" multiple>
            <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i> Choose Video</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="node_modules/socket.io-client/dist/socket.io.js"></script>
  <script src="js/sweetalert2@10.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const searchInput = document.getElementById("searchforthingsinput");
      const searchResultsContainer = document.getElementById("searchResults");
      const UserId = "<?php echo $UserId ?>";

      searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.trim().toLowerCase();

        if (searchTerm.length > 0) {
          fetch(`search_posts.php?searchTerm=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
              displaySearchResults(data);
            });
        } else {
          searchResultsContainer.innerHTML = "";
        }
      });

      function displaySearchResults(results) {
        searchResultsContainer.innerHTML = "";

        if (results.length === 0) {
          searchResultsContainer.innerHTML = "No results found.";
          return;
        }

        results.forEach(result => {
          const postElement = document.createElement("a");
          postElement.classList.add("search-result");
          postElement.href = 'index.php?postId=' + result.PostId + '&UserId=' + UserId;
          postElement.innerHTML = `
                    <h3>${result.title}</h3>
                    <p>${result.content}</p>
                    <small>${result.date_posted}</small>
                `;

          searchResultsContainer.appendChild(postElement);
        });
      }
    });
  </script>

  <script>
    var UserId = "<?php echo $_SESSION['UserId']; ?>";
    var socketUrl = 'ws://localhost:8888';
    const socket = io(socketUrl, {
      query: {
        UserId
      }
    });

    socket.on('connect', () => {
      console.log('Socket.IO connection established');
    });

    socket.on('posts', (data) => {
      data.forEach((transformedData, index) => {
        console.log(`Received reels data #${index + 1}:`);
        console.log('UserId:', transformedData.UserId);
        console.log('surname:', transformedData.surname);
        console.log('firstName:', transformedData.firstName);
        console.log('passport:', transformedData.passport);
        console.log('postId:', transformedData.postId);
        console.log('image:', transformedData.image);
        console.log('video:', transformedData.video);
        console.log('title:', transformedData.title);
        console.log('content:', transformedData.content);
        console.log('timeAgo:', transformedData.timeAgo);
        console.log('likes:', transformedData.likes);
        console.log('isLiking:', transformedData.isLiking);

        loadNewsFeed(transformedData);
      });
    });

    function likepost(postId, UserId) {
      const formData = new FormData();
      formData.append('UserId', UserId);
      formData.append('postId', postId);

      fetch('http://localhost:8888/likepost', {
          method: 'POST',
          body: formData,
        })
        .then((response) => {
          if (!response.ok) {
            throw new Error('Error liking/unliking post');
          }
          return response.json();
        })
        .then((result) => {
          console.log('post has been liked') 
        })
        .catch((error) => {
          console.error(error);
        });
    }

    function loadNewsFeed(data) {
      var postElement = document.createElement('section');
      var postDiv = document.createElement('div');
      postDiv.className = 'post';

      var newsFeedPostDiv = document.createElement('div');
      newsFeedPostDiv.className = 'news-feed-post';

      var postHeaderDiv = document.createElement('div');
      postHeaderDiv.className = 'post-header';

      var userPassportImg = document.createElement('img');
      userPassportImg.className = 'UserPassport';
      userPassportImg.src = data.passport;

      var authorLink = document.createElement('a');
      authorLink.href = 'user_profile.php?UserId=' + data.UserId;
      authorLink.style.textDecoration = 'none';

      var authorNameP = document.createElement('p');
      authorNameP.className = 'post-author';
      authorNameP.innerHTML = '<strong>' + data.surname + ' ' + data.firstName + '</strong>';

      authorLink.appendChild(authorNameP);
      postHeaderDiv.appendChild(userPassportImg);
      postHeaderDiv.appendChild(authorLink);

      var threeDotsDiv = document.createElement('div');
      threeDotsDiv.id = 'threedots';

      var dropdownButton = document.createElement('button');
      dropdownButton.type = 'button';
      dropdownButton.className = 'btn btn-link';
      dropdownButton.dataset.bsToggle = 'dropdown';
      dropdownButton.setAttribute('aria-haspopup', 'true');
      dropdownButton.setAttribute('aria-expanded', 'false');
      dropdownButton.innerHTML = '<i class="fas fa-ellipsis-h"></i>';

      var dropdownMenu = document.createElement('div');
      dropdownMenu.className = 'dropdown-menu dropdown-menu-right';

      var blockUserDiv = document.createElement('div');
      var blockUserButton = document.createElement('button');
      blockUserButton.type = 'button';
      blockUserButton.className = 'btn btn-primary blockUser';
      blockUserButton.id = 'blockUser-' + data.UserId;
      blockUserButton.dataset.recipientid = data.UserId;
      blockUserButton.dataset.bsToggle = 'modal';
      blockUserButton.dataset.bsTarget = '#blockUserModal-' + data.UserId;
      blockUserButton.innerHTML = 'Block User';

      var blockUserInput = document.createElement('input');
      blockUserInput.type = 'hidden';
      blockUserInput.id = 'bu' + data.UserId;
      blockUserInput.value = data.UserId;

      blockUserDiv.appendChild(blockUserButton);
      blockUserDiv.appendChild(blockUserInput);

      var blockButtonDiv = document.createElement('div');
      var blockButtonButton = document.createElement('button');
      blockButtonButton.type = 'button';
      blockButtonButton.className = 'btn btn-primary blockButton';
      blockButtonButton.id = 'blockButton-' + data.postId;
      blockButtonButton.dataset.postid = data.postId;
      blockButtonButton.dataset.bsToggle = 'modal';
      blockButtonButton.dataset.bsTarget = '#blockTypeofPostModal-' + data.postId;
      blockButtonButton.innerHTML = 'Block this type of post';

      var blockButtonInput = document.createElement('input');
      blockButtonInput.type = 'hidden';
      blockButtonInput.id = 'b' + data.postId;
      blockButtonInput.value = data.postId;

      blockButtonDiv.appendChild(blockButtonButton);
      blockButtonDiv.appendChild(blockButtonInput);

      dropdownMenu.appendChild(blockUserDiv);
      dropdownMenu.appendChild(blockButtonDiv);
      dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
        '<a class="dropdown-item" href="#">Repost post</a>';

      threeDotsDiv.appendChild(dropdownButton);
      threeDotsDiv.appendChild(dropdownMenu);

      var postMediaDiv = document.createElement('div');
      postMediaDiv.className = 'post-media';

      // Check if the post has an image
      if (data.image !== null && data.image !== '') {
        var postItem = document.createElement('div');
        postItem.className = 'post-item';
        var image = document.createElement('img');
        image.className = 'post-image';
        image.src = data.image;
        postItem.appendChild(image);
        postMediaDiv.appendChild(postItem);
      }

      // Check if the post has a video
      if (data.video !== null && data.video !== '') {
        var postItem = document.createElement('div');
        postItem.className = 'post-item';
        var videoContainer = document.createElement('div');
        videoContainer.className = 'post-video';
        var video = document.createElement('video');
        video.setAttribute('data-my-Video-id', data.postId);
        video.id = 'myVideo-' + data.postId;
        video.className = 'w-100';
        var source = document.createElement('source');
        source.src = data.video;
        source.type = 'video/mp4';
        video.appendChild(source);
        videoContainer.appendChild(video);
        // videoContainer.innerHTML += 'Your browser does not support the video tag.';
        var videoControls = document.createElement('div');
        videoControls.className = 'video-controls';
        var rewindButton = document.createElement('button');
        rewindButton.id = 'rewindButton-' + data.postId;
        rewindButton.onclick = function() {
          rewind(data.postId);
        };
        rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
        videoControls.appendChild(rewindButton);
        var playPauseButton = document.createElement('button');
        playPauseButton.onclick = function() {
          togglePlayPause(data.postId);
        };
        playPauseButton.innerHTML = '<span id="playPauseButton-' + data.postId + '"><i class="bi bi-play"></i></span>';
        videoControls.appendChild(playPauseButton);
        var fastForwardButton = document.createElement('button');
        fastForwardButton.id = 'fastForwardButton-' + data.postId;
        fastForwardButton.onclick = function() {
          fastForward(data.postId);
        };
        fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
        videoControls.appendChild(fastForwardButton);
        var volumeControl = document.createElement('div');
        volumeControl.className = 'volume-control';
        var volumeRange = document.createElement('input');
        volumeRange.type = 'range';
        volumeRange.id = 'volumeRange-' + data.postId;
        volumeRange.min = '0';
        volumeRange.max = '1';
        volumeRange.step = '0.01';
        volumeRange.value = '1';
        volumeRange.onchange = function() {
          setVolume(data.postId);
        };
        volumeControl.appendChild(volumeRange);
        videoControls.appendChild(volumeControl);
        var timeControl = document.createElement('div');
        timeControl.className = 'time-control';
        var timeRange = document.createElement('input');
        timeRange.type = 'range';
        timeRange.id = 'timeRange-' + data.postId;
        timeRange.min = '0';
        timeRange.step = '0.01';
        timeRange.value = '0';
        timeRange.onchange = function() {
          setCurrentTime(data.postId);
        };
        timeControl.appendChild(timeRange);
        var timeDisplay = document.createElement('div');
        timeDisplay.className = 'time-display';
        var currentTimeDisplay = document.createElement('div');
        currentTimeDisplay.className = 'currentTimeDisplay';
        currentTimeDisplay.id = 'currentTimeDisplay-' + data.postId;
        currentTimeDisplay.innerHTML = '0:00';
        timeDisplay.appendChild(currentTimeDisplay);
        timeDisplay.innerHTML += '<div class="slash">/</div>';
        var durationDisplay = document.createElement('div');
        durationDisplay.className = 'durationDisplay';
        durationDisplay.id = 'durationDisplay-' + data.postId;
        durationDisplay.innerHTML = '0:00';
        timeDisplay.appendChild(durationDisplay);
        timeControl.appendChild(timeDisplay);
        videoControls.appendChild(timeControl);
        videoContainer.appendChild(videoControls);
        postItem.appendChild(videoContainer);
        postMediaDiv.appendChild(postItem);

        // Create the Previous and Next buttons
        var previousButton = document.createElement('button');
        previousButton.className = 'previous-button';
        previousButton.innerHTML = '<i class="bi bi-arrow-left"></i>';

        var nextButton = document.createElement('button');
        nextButton.className = 'next-button';
        nextButton.innerHTML = '<i class="bi bi-arrow-right"></i>';

        var button = document.createElement('div');
        button.className = 'button';

        button.appendChild(previousButton);
        button.appendChild(nextButton);
        postMediaDiv.appendChild(button);

        var postItems = postMediaDiv.getElementsByClassName('post-item');
        var currentIndex = 0;

        previousButton.addEventListener('click', function() {
          if (currentIndex > 0) {
            postItems[currentIndex].style.display = 'none';
            currentIndex--;
            postItems[currentIndex].style.display = 'block';
            postItems[currentIndex].scrollIntoView({
              behavior: 'smooth'
            });
          }
        });

        nextButton.addEventListener('click', function() {
          if (currentIndex < postItems.length - 1) {
            postItems[currentIndex].style.display = 'none'; // Hide the current post item
            currentIndex++; // Increment the current index
            postItems[currentIndex].style.display = 'block'; // Show the next post item
            postItems[currentIndex].scrollIntoView({
              behavior: 'smooth'
            }); // Scroll to the next post item
          }
        });
      }

      // Hide all media elements except the first one
      var mediaItems = postMediaDiv.getElementsByClassName('post-item');
      console.log(mediaItems.length);
      for (var i = 1; i < mediaItems.length; i++) {
        mediaItems[i].style.display = 'none';
      }

      // Append the post media div before the post content
      // newsFeedPostDiv.insertBefore(postMediaDiv, postContentDiv);

      var postContentDiv = document.createElement('div');
      postContentDiv.className = 'post-content';
      postContentDiv.textContent = data.content;

      var postDateDiv = document.createElement('div');
      postDateDiv.className = 'post-date';
      postDateDiv.textContent = data.timeAgo;

      var footerDiv = document.createElement('div');
      footerDiv.className = 'footer';

      var likeButton = document.createElement('button');
      likeButton.type = 'button';
      likeButton.className = 'btn btn-primary like ' + (data.isLiking ? 'likeing' : 'unlike');
      likeButton.dataset.postid = data.postId;
      likeButton.innerHTML = '<span class="like-count">' + data.likes + '</span>' +
        (data.isLiking ? '<span class="emoji"><img src="icons/love.png"></span>' : '<span class="emoji"><img src="icons/unlove.png"></span>');
      likeButton.addEventListener('click', function() {
        likepost(data.postId, UserId);
      });

      var shareButton = document.createElement('button');
      shareButton.type = 'button';
      shareButton.className = 'btn btn-primary share-button';
      shareButton.dataset.postid = data.postId;
      shareButton.innerHTML = '<i class="bi bi-share"></i> Share';

      var commentButton = document.createElement('button');
      commentButton.type = 'button';
      commentButton.className = 'btn btn-primary comment-button';
      commentButton.dataset.postid = data.postId;
      commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> Comment';

      footerDiv.appendChild(likeButton);
      footerDiv.appendChild(shareButton);
      footerDiv.appendChild(commentButton);

      postDiv.appendChild(newsFeedPostDiv);
      newsFeedPostDiv.appendChild(postHeaderDiv);
      postHeaderDiv.appendChild(threeDotsDiv);
      var postTitleDiv = document.createElement('div');
      postTitleDiv.className = 'post-title';

      var postTitleH2 = document.createElement('h2');
      postTitleH2.textContent = data.title;

      postTitleDiv.appendChild(postTitleH2);
      postDiv.appendChild(postTitleDiv);
      // Append the post media div to the post div
      postDiv.appendChild(postMediaDiv);
      postDiv.appendChild(postContentDiv);
      postDiv.appendChild(postDateDiv);
      postDiv.appendChild(footerDiv);
      postElement.appendChild(postDiv);

      newsFeed.appendChild(postElement);
    }
    $('.owl-carousel').owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: false,
      navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>']
    })

    // Add event listener to the "Post" button
    var postButton = document.getElementById('postButton');
    postButton.addEventListener('click', function() {
      // Code to handle posting a new post
      // ...

      // After posting, reload the news feed
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
  <script>
    $(document).ready(function() {
      $('.comment-button').click(function() {
        console.log('clicked');
        // var commentsSidebar = document.getElementById('commentsSidebar');
        user_table.style.display = 'none';
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
  var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

  // Check if the UserId exists
  if (!UserId) {
    // UserId not found, redirect to login page
    window.location.href = "login.php";
  }
</script>

<script>
  var urlParams = new URLSearchParams(window.location.search);
  var postId = urlParams.get('postId');
  console.log(postId);

  // Check if the PostId exists
  function checkPostIdExistence(postId) {
    return new Promise(function(resolve, reject) {
      // Make an AJAX call to postIdfinding.php
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Response received successfully
            var response = xhr.responseText;
            resolve(response === 'true');
          } else {
            // Error occurred
            reject();
          }
        }
      };

      xhr.open('GET', 'postIdfinding.php?postId=' + postId, true);
      xhr.send();
    });
  }

  if (postId) {
    checkPostIdExistence(postId)
      .then(function(result) {
        if (!result) {
          // PostId not found, redirect to 404 error page
          window.location.href = "error404.php";
        } else {
          // Scroll to post with matching id
          var postElement = document.getElementById('post-' + postId);
          if (postElement) {
            postElement.scrollIntoView();
          }
        }
      })
      .catch(function() {
        // Error occurred while checking PostId existence
        console.log('An error occurred.');
      });
  }
</script>
<script>
  $(document).ready(function() {
    var UserId = "<?php echo $_SESSION['UserId']; ?>";

    $(".like").click(function() {
      var likeBtn = $(this);
      var islikeing = likeBtn.hasClass('likeing');
      var postId = likeBtn.data('postid');

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
    var refreshTime = 120000;

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
        'background-color': 'transparent',
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
    var postId = $("#postId").val();

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

    // Use SweetAlert to display the modal
    Swal.fire({
      title: 'Copy this link to share:',
      html: shareUrl,
      showCancelButton: false,
      showCloseButton: true,
      focusConfirm: false,
      confirmButtonText: 'Copy',
    }).then(function(result) {
      if (result.isConfirmed) {
        copyToClipboard(shareUrl);
        Swal.fire('Copied!', 'Link copied to clipboard.', 'success');
      }
    });
  });

  // Function to copy text to clipboard
  function copyToClipboard(text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
  }
</script>

<!-- <script>
  $(document).ready(function() {
    $("#search").on("keyup", function() {
      // alert('yes');
      var commentsSidebar = document.getElementById('commentsSidebar');
      var user_table = document.getElementById('user_table');
      commentsSidebar.style.display = 'none';
      var value = $(this).val().toLowerCase();
      if (value === "") {
        $("#user_table").html("");
      } else {
        // Run the search function if the search box is not empty
        $("#user_table tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      }
    });
  });
</script> -->

<script>
  const searchBox = document.getElementById('search');
  const resultsDiv = document.getElementById('user_table');
  const commentSidebar = document.getElementById('commentSidebar');

  searchBox.addEventListener('input', function() {
    const searchTerm = this.value;

    // Clear the results if the search box is empty
    if (!searchTerm.trim()) {
      resultsDiv.innerHTML = '';
      return;
    }

    $(document).ready(function() {
      $("#search").on("keyup", function() {
        // alert('yes');
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
              $('#user_table').show();
              commentSidebar.style.display = "none";
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
<!-- <script>
  function toggleSidebar() {
    const maxWidth = 950;
    const posts = document.getElementById('newsFeed');
    const sidebar = document.querySelector('.sidebar');
    const Activity = document.querySelector('.Activity');
    const navbar = document.querySelector('.navbar');
    const addpost = document.querySelector('.addpost');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    function handleResize() {
      const windowWidth = window.innerWidth;
      if (windowWidth <= maxWidth) {
        sidebar.style.display = 'none';
        navbar.style.display = 'block';
        posts.style.marginLeft = '40px';
        addpost.style.marginTop = '20px';
        addpost.style.marginLeft = '50px';
        Activity.style.marginLeft = '50px';
        Activity.style.marginTop = '80px';
      } else {
        sidebar.style.display = 'block';
        navbar.style.display = 'none';
        posts.style.marginLeft = '280px';
        addpost.style.marginTop = '20px';
        addpost.style.marginLeft = '280px';
        Activity.style.marginLeft = '280px';
        Activity.style.marginTop = '80px';
        navbarCollapse.classList.remove('show');
      }
    }

    // Initial check on page load
    handleResize();

    // Listen for window resize events
    window.addEventListener('resize', handleResize);
  }

  // Call the toggleSidebar function
  toggleSidebar();
</script> -->

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
  //  check UserId of the post before modal
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