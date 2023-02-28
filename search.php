<?php
session_start();
include('db.php');
$UserId = $_SESSION['UserId'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
        Search
        </title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <script src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#user_table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
        <style>
          body{
            background: f1fbff;
          }
#search {
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid #ccc;
  box-shadow: 2px 2px 2px green;
  border-radius: 4px;
  width: 50%;
}

#user_table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  text-decoration: none;
}

#user_table td, #user_table th {
  border: 1px solid #ddd;
  padding: 8px;
}

#user_table tr:nth-child(even) {
  background-color: #f2f2f2;
}

#user_table tr:hover {
  background-color: #ddd;
}

#user_table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  /* background: #000; */
  color: green;
  text-transform: uppercase;
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
        .custom-link {
  text-decoration: none;
}
 label{
  color: green;
  font-family: Bebas Neue, Pacifico, Great Vibes, Dancing Script;
  font-size: 20px;
 }

        </style>
    </head>
    

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
                                <a class="nav-link custom-link" onclick="window.location.href='index.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
                            </li>
                <li class="nav-item">
				<a class="nav-link custom-link"onclick="window.location.href='upload.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-plus-square"></i>Add a Post</a>
                </li>
                <li class="nav-item">
				<a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId; ?>'"><i class="bi bi-person"></i>Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                </li>

        </div>
    </nav>
  <div>
    <br><br><br>
    <label for="search">Who are you looking for:</label>
    <input class="bg-light"  type="text" id="search" placeholder="Search for names.." title="Type in a name">
  </div>
  <table id="user_table">
    <tr>
      <th>Firstname</th>
      <th>Lastname</th>
    </tr>
  </table>
<script>
$("#search").on("keyup", function() {
  var search_query = $(this).val();
  $.ajax({
    url: "searchbackend.php",
    method: "POST",
    data: {search_query:search_query},
    success: function(data){
      // Update the table with the returned results
      $("#user_table").html(data);
    }
});
});
</script>
</body>

</html>

