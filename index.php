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
  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.jpeg" type="image/jpeg" sizes="32x32" />
  <style>
.news-feed-container {
width: 80%;
margin: 50px auto;
background: #fafafa;
border-radius: 10px;
box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.news-feed-item {
display: flex;
flex-direction: column;
align-items: center;
margin: 30px 0;
padding: 30px;
background: #fff;
border-radius: 10px;
box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.UserPassport {
width: 50px;
height: 50px;
border-radius: 50%;
margin-bottom: 20px;
}

.post-author {
font-family: "Montserrat", sans-serif;
font-size: 20px;
font-weight: bold;
color: #333;
margin-bottom: 20px;
}

.news-title {
font-size: 24px;
font-weight: bold;
color: #333;
margin-bottom: 20px;
text-align: center;
}

.news-date {
font-style: italic;
color: #777;
margin-bottom: 20px;
text-align: center;
}

.news-content {
line-height: 1.5;
color: #333;
margin-bottom: 20px;
text-align: center;
}
.UserPassport {
width: 50px;
height: 50px;
border-radius: 50%;
display: inline-block;
vertical-align: top;
}

.post-author {
font-family: montserrat;
color: green;
font-size: 30px;
display: inline-block;
vertical-align: top;
margin-left: 10px;
}
.post-video ,.post-image{
    width: 400px;
    height: 400px;
    padding: 10px;
    
}
iframe{
    width: 390px;
    height: 390px;
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
                                <a class="nav-link" href="logout.php"></i>Logout</a>
                            </li>

        </div>
    </nav>
    <br><br>
<div class="news-feed-container">
  <?php include 'news-feed.php'; ?>
</div>

</body>
</html>
