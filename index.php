<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit();
}
?>
<?php
$UserId=$_GET["UserId"];
include ('db.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title>News Feed</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css\font\bootstrap-icons.css">

  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.jpeg" type="image/jpeg" sizes="32x32" />
  <style>
.post {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto auto auto;
  gap: 10px;
  border: 1px solid #ddd;
  padding: 10px;
}

.post-header {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
  align-items: center;
}

.UserPassport {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.post-author {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 24px;
  font-weight: bold;
  color: #1877f2;
}

.post-title {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 18px;
  font-weight: bold;
  color: #1c1e21;
  margin: 10px 0;
}

.post-content {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  color: #1c1e21;
  line-height: 1.5;
  margin-bottom: 10px;
}

.post-image, .post-video, iframe {
  width: 100%;
  max-width: 500px;
  margin: 10px 0;
  height: 500px;
}

.post-date {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  color: #90949c;
  margin-top: 10px;
}

.post-footer {
  display: grid;
  grid-template-columns: repeat(3, auto);
  gap: 10px;
  align-items: center;
}

.post-footer button {
  display: flex;
  align-items: center;
  gap: 5px;
  background-color: transparent;
  border: none;
  color: #606770;
  cursor: pointer;
  font-size: 14px;
}

.post-footer button:hover {
  text-decoration: underline;
}

.post-footer button:focus {
  outline: none;
}

.post-footer button svg {
  height: 16px;
  width: 16px;
  fill: #606770;
}

.post-footer button .count {
  font-weight: 600;
  margin-left: 2px;
}

.post-footer button.like svg {
  fill: #1877f2;
}

.post-footer button.like .count {
  color: #1877f2;
}

.post-footer button.comment svg {
  fill: #606770;
}

.post-footer button.share svg {
  fill: #606770;
}

.navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }
        
        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                                <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-person"></i>Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-plus-square"></i>Add a Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='search.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-search"></i>Search Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
                            </li>

        </div>
    </nav>
    <br><br>
<div class="news-feed-container">
<br>
  <?php include 'news-feed.php'; ?>
</div>

</body>
</html>
