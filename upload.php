<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Redirect to login page
  header("Location: login.php");
  exit();
}
?>
<?php
include('db.php');
$UserId = $_SESSION['UserId'];
?>

<!-- rest of your HTML code -->
<!DOCTYPE html>
<html>

<head>
  <title>
    Share a Post
  </title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css\font\bootstrap-icons.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <style>
    /* Add mobile-friendly styles */
    @media (max-width: 500px) {
      body {
        font-size: 12px;
      }

      #title,
      #content {
        width: 100%;
      }

      .title_container strong {
        font-size: 30px;
        width: 100%;
      }

      .form-group {
        padding: 0.5rem;
      }

      .custom-body .submit,
      .custom-body .profile {
        width: 100%;
      }
    }


    .custom-body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
      font-size: 16px;
    }

    .container {
      background: url(img/13.jpeg);
      background-size: cover;
      width: 100%;
      margin: 50px auto;
      padding: 40px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .title_container {
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: white;
    }

    input[type="text"],
    textarea {
      width: 100%;
      /* padding: 10px; */
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
      resize: vertical;
      height: 40px;
    }

    .custom-file-label {
      padding: 10px;
      border-radius: 5px;
      /* border: 1px solid #ddd; */
      margin-top: 20px;
      cursor: pointer;
    }

    .submit {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
    }

    .profile {
      background-color: #ddd;
      color: #333;
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
      width: 123px;
    }

    .profile:hover {
      background-color: #333;
      color: #fff;
    }

    strong {
      color: pink;
      font-family: 'Calligraffitti';
      /* sets text color to red */
      font-size: 50px;
      /* sets font size to 20px */
      text-align: center;
      /* centers the text */
      background: transparent;
      width: 50%;
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

    .navbar-brand img {
      display: inline-block;
      height: 30px;
      /* adjust height as needed */
      margin-right: 10px;
      /* add some space between image and text */
    }



    
    .custom-link {
      text-decoration: none;
      cursor: pointer;
    }

    .custom-file-input {
      opacity: 0;
      position: absolute;
      pointer-events: none;
    }

    .custom-file-label {
      cursor: pointer;
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
      text-decoration: none;
    }

    #user_table li:hover {
      background-color: #f2f2f2;
      text-decoration: none;

    }
  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <a class="navbar-brand" href="home.php"><span class="text-success">Offeyicial </span></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navmenu">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
      </li>
      <li class="nav-item">
        <div class="search-container">
          <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
          <div id="user_table">
      </li>
      <li class="nav-item">
        <a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link custom-link" onclick="window.location.href='index.php'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
      </li>

  </div>
</nav>

<body class="custom-body">
  <div class="container">
    <div class="title_container">
      <strong>Unleash Your Creativity!</strong>
    </div>
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title">
    </div>
    <div class="form-group">
      <label for="content">Content:</label>
      <textarea id="content" name="content"></textarea>
    </div>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
      <label class="custom-file-label" for="image"><i class="bi bi-image"></i> Choose Image</label>
    </div>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="video" name="video" accept="video/*">
      <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i> Choose Video</label>
    </div>

    <input type="submit" value="Add Post" class="submit">
    <input class="profile" value="Back to profile" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'">
  </div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- name of the files -->
<script>
  $('.custom-file-input').on('change', function() {
    var fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').html('<i class="bi bi-check-circle-fill"></i> ' + fileName);
  });
</script>
 <!-- uploading a post  -->
<script>
  $(document).ready(function() {
    $('.submit').click(function() {
      var title = $('#title').val();
      var content = $('#content').val();
      var image = $('#image').prop('files')[0];
      var video = $('#video').prop('files')[0];

      // Check if title or content is empty
      if (title === '' || content === '') {
        alert('Title and content are required.');
        return;
      }

      var form_data = new FormData();
      form_data.append('title', title);
      form_data.append('content', content);
      form_data.append('image', image);
      form_data.append('video', video);


      $.ajax({
        url: 'addpost.php', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(response) {
          if (response === "success") {
            console.log("Post added successfully");
            alert("Post added successfully");
            window.location.href = "index.php";
          } else {
            console.log("Error adding post: " + response);
            alert("Error adding post: " + response);
            $('#title').val('');
            $('#content').val('');
            $('#image').val('');
            $('#video').val('');


          }
        }

      });

    });
  });
</script>

<script>
  $(document).ready(function() {
    $("#search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#user_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
<!-- script for searching -->
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


</html>