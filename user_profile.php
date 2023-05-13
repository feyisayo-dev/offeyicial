<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Redirect to login page
  header("Location: login.php");
  exit();
}
if (isset($_SESSION['UserId'])) {
  // Get the user ID of the profile owner from the URL
  $profileOwnerId = $_GET['UserId'];
  $UserId = $_SESSION["UserId"];
  include('db.php');
  // echo $profileOwnerId;
  // echo $UserId;
  // Check if the user viewing the profile is the same as the profile owner
  $isProfileOwner = ($UserId == $profileOwnerId);

  // Query the database to get the user's profile information
  // ...
  $stmt = sqlsrv_prepare($conn, "SELECT [UserId], [Surname], [First_Name], [gender], [email], [Password], [phone], [dob], [countryId], [stateId], [Passport], [bio] FROM User_Profile WHERE UserId = ?", array(&$profileOwnerId));

  if (!$stmt) {
    die(print_r(sqlsrv_errors(), true)); // handle the error
  }

  // execute the prepared statement
  $FetchStatement = sqlsrv_execute($stmt);

  // handle the result set
  if ($FetchStatement === false) {
    die(print_r(sqlsrv_errors(), true)); // handle the error
  }

  // fetch the data from the result set
  $record = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  $Surname = $record['Surname'];
  $First_Name = $record['First_Name'];
  $gender = $record['gender'];
  $email = $record['email'];
  $Password = $record['Password'];
  $phone = $record['phone'];
  $dob = $record['dob'];
  $countryId = $record['countryId'];
  $stateId = $record['stateId'];
  $Passport = $record['Passport'];
  $bio = $record['bio'];

  if (empty($Passport)) {
    $GetPassport = "UserPassport/DefaultImage.png";
  } else {
    $GetPassport = "UserPassport/" . $Passport;
  }
  if (empty($bio)) {
    $getbio = "Not yet set";
  } else {
    $getbio = $bio;
  }


  $fetchPostsinfo = "SELECT TOP 100 PERCENT [UserId], [PostId], [title], [content], [video], [image], [date_posted] FROM posts WHERE UserId='$profileOwnerId' ORDER BY date_posted DESC";

  $fetchPosts = sqlsrv_query($conn, $fetchPostsinfo);
  if ($fetchPosts === false) {
    die(print_r(sqlsrv_errors(), true));
  }


  // Get the count of followers and following for the profile owner and recipient
  $sql = "SELECT COUNT(*) as num_followers FROM follows WHERE UserId = ?";
  $params = array($profileOwnerId);
  $stmt = sqlsrv_query($conn, $sql, $params);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  $followers = $row['num_followers'];

  $sql = "SELECT COUNT(*) as num_following FROM follows WHERE recipientId = ?";
  $params = array($profileOwnerId);
  $stmt = sqlsrv_query($conn, $sql, $params);
  $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
  $following = $row['num_following'];
  // Display the profile information

  $sql = "SELECT * FROM follows WHERE UserId = ? AND recipientId = ?";
  $params = array($profileOwnerId, $UserId);
  $stmt = sqlsrv_query($conn, $sql, $params);
  $isFollowing = sqlsrv_has_rows($stmt);

  // If $isProfileOwner is true, display all the information


  // Check if user ID is equal to profile owner ID
  if ($UserId == $isProfileOwner) {
    echo '<title>Profile ~ ' . $Surname . ' ' . $First_Name . '</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">';
    echo '<script src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
';
    echo '<script src="country-states.js"></script>';
    echo '<link rel="stylesheet" href="profile.css">';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-link" onclick="window.location.href=\'index.php\'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-link" onclick="window.location.href=\'upload.php\'"><i class="bi bi-plus-square"></i>Add a Post</a>
            </li>
            <li class="nav-item">
                <div class="search-container">
                    <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                    <div id="user_table">
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="home.php#contact"><i class="bi bi-telephone"></i>Contact us</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" onclick="location.href=\'logoutmodal.php\'"><i class="bi bi-box-arrow-right"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>';

    // Display all information
    echo '<div class="container-fluid profile-section">';
    echo '<br><br><br>';
    echo '<div class="row">';
    echo '<div class="col-md-4 profile-pic">';
    echo '<img src="' . $GetPassport . '" class="button" alt="Profile Picture">';
    echo '<P>Enhance your online persona</P>';
    echo '<form action="" method="POST" enctype="multipart/form-data">
        <label for="upload1" class="custom-file-upload">
          <i class="fa fa-cloud-upload"></i> Choose File
        </label>
        <input type="file" class="custom-file-input" name="Fileupload" id="upload1" required />
        <button type="submit" name="button" id="button" >
        <i class="bi bi-cloud-arrow-up"></i>
</button>

      </form>
      ';
    echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-4 profile-info">';
    echo '<h2>' . $Surname . '  ' . $First_Name . '</h2>';
    echo '<p>Email: ' . $email . '</p>';
    echo '<p>Phone Number: ' . $phone . '</p>';
    echo '<p>Gender: ' . $gender . '</p>';
    echo '<p>Date of Birth: ' . $dob . '</p>';
    echo '<p>Location ID: ' . $countryId . ' ' . $stateId . '</p>';
    echo '<p>Bio: ' . $getbio . '</p>';
    echo '<div class="row">';
    echo '<div class="col-md-4">';
    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setBioModal">Set Bio</button>';
    echo '</div>';
    echo '<div class="col-md-4">';
    echo '<button type="button" style="background-color:red;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editprofile">Edit profile</button>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '<div class="col-md-4">
    <div class="row">
      <div class="col-md-6">
        <p style="margin-bottom: 0;">' . $following . '</p>
        <p style="font-size: 0.8rem;">Following</p>
      </div>
      <div class="col-md-6">
        <p style="margin-bottom: 0;">' . $followers . '</p>
        <p style="font-size: 0.8rem;">Followers</p>
      </div>
    </div>
  </div>';
    echo '</div>';

    echo '<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center text-uppercase text-success">Posts</h3>
            <div class="posts">';
    while ($row = sqlsrv_fetch_array($fetchPosts, SQLSRV_FETCH_ASSOC)) {
      $PostId = $row['PostId'];
      $title = $row['title'];
      $content = $row['content'];
      $video = $row['video'];
      $image = $row['image'];
      $date_posted = new DateTime($row['date_posted']);
      $formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
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

      echo '<div class="post">';
      if (!empty($title)) {
        echo '<h3 class="title">' . $title . '</h3>';
      }
      echo '<div class="row">';
      if (!empty($image)) {
        echo '<div class="col-md-6">
                    <img src="' . $image . '" class="img-fluid">
                </div>';
      }
      if (!empty($video)) {
        echo '<div class="video-container">
                <video id="myVideo" class="w-100">
                  <source src="' . $row["video"] . '" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                <div class="video-controls">
                  <button id="rewindButton" onclick="rewind()">Rewind 10 seconds</button>
                  <button id="fastForwardButton" onclick="fastForward()">Fast forward 10 seconds</button>
                  <button onclick="togglePlayPause()">
                    <span id="playPauseButton">Play</span>
                  </button>                        
                  <div class="volume-control">
                    <input type="range" id="volumeRange" min="0" max="1" step="0.01" value="1" onchange="setVolume()"> 
                  </div>
                  <div class="time-control">
                    <input type="range" id="timeRange" min="0" step="0.01" value="0" onchange="setCurrentTime()">
                    <div class="time-display">
                      <div id="currentTimeDisplay">0:00</div>
                      <div id="stroke"> / </div>
                      <div id="durationDisplay">0:00</div>
                    </div>
                  </div>
                </div>
              </div>
              
                    ';
      }
      echo '</div>';
      if (!empty($content)) {
        echo '<p>' . $content . '</p>';
      }
      if (!empty($time_ago)) {
        echo '<p>' . $time_ago . '</p>';
      }
      echo '</div>';
    }
    echo '</div>
        </div>
    </div>
</div>';
    echo '<div class="footer">';


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

    echo '</div>';
    // If $isProfileOwner is false, only display some of the information
    // ...
  } else {
    echo '<title>Profile ~ ' . $Surname . ' ' . $First_Name . '</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">';
    echo '<link rel="stylesheet" href="profile.css">';
    echo '<script src="country-states.js"></script>';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-link" onclick="window.location.href=\'index.php\'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-link" onclick="window.location.href=\'upload.php\'"><i class="bi bi-plus-square"></i>Add a Post</a>
            </li>
            <li class="nav-item">
                <div class="search-container">
                    <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                    <div id="user_table">
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="home.php#contact"><i class="bi bi-telephone"></i>Contact us</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" onclick="location.href=\'logoutmodal.php\'"><i class="bi bi-box-arrow-right"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>';

    // Display all information
    echo '<div class="container-fluid profile-section">';
    echo '<br><br><br>';
    echo '<div class="row">';
    echo '<div class="col-md-4 profile-pic">';
    echo '<img src="' . $GetPassport . '" class="button" alt="Profile Picture">';
    echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-4 profile-info">';
    echo '<h2>' . $Surname . '  ' . $First_Name . '</h2>';

    echo '<p>Gender: ' . $gender . '</p>';
    echo '<p>Bio: ' . $getbio . '</p>';
    echo '<div class="row">';
    echo '<div class="col-md-5">';
    echo '<button id="followBtn" class="follow ' . ($isFollowing ? 'following' : 'unfollow') . '">' . ($isFollowing ? 'Unfollow' : 'Follow') . '</button>';
    echo '</div>';
    echo '<div class="col-md-5">';
    echo '<button class="message" onclick="location.href=\'chat.php?UserIdx=' . $profileOwnerId . '\'">Message</button>';
    echo '</div>';
    echo '</div>';

    echo '</div>'; // close profile-info div

    echo '<div class="col-md-4">
    <div class="row">
      <div class="col-md-6">
        <p style="margin-bottom: 0;">' . $following . '</p>
        <p style="font-size: 0.8rem;">Following</p>
      </div>
      <div class="col-md-6">
        <p style="margin-bottom: 0;">' . $followers . '</p>
        <p style="font-size: 0.8rem;">Followers</p>
      </div>
    </div>
    </div>
    ';
    echo '<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center text-uppercase text-success">Posts</h3>
            <div class="posts">';
    while ($row = sqlsrv_fetch_array($fetchPosts, SQLSRV_FETCH_ASSOC)) {
      $PostId = $row['PostId'];
      $title = $row['title'];
      $content = $row['content'];
      $video = $row['video'];
      $image = $row['image'];
      $date_posted = new DateTime($row['date_posted']);
      $formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
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

      echo '<div class="post">';
      if (!empty($title)) {
        echo '<h3 class="title">' . $title . '</h3>';
      }
      echo '<div class="row">';
      if (!empty($image)) {
        echo '<div class="col-md-9">
                    <img src="' . $image . '" class="img-fluid">
                </div>';
      }
      if (!empty($video)) {
        echo '<div class="video-container">
                <video id="myVideo" class="w-100">
                  <source src="' . $row["video"] . '" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                <div class="video-controls">
                  <button id="rewindButton" onclick="rewind()">Rewind 10 seconds</button>
                  <button id="fastForwardButton" onclick="fastForward()">Fast forward 10 seconds</button>
                  <button onclick="togglePlayPause()">
                    <span id="playPauseButton">Play</span>
                  </button>                        
                  <div class="volume-control">
                    <input type="range" id="volumeRange" min="0" max="1" step="0.01" value="1" onchange="setVolume()"> 
                  </div>
                  <div class="time-control">
                    <input type="range" id="timeRange" min="0" step="0.01" value="0" onchange="setCurrentTime()">
                    <div class="time-display">
                      <div id="currentTimeDisplay">0:00</div>
                      <div id="stroke"> / </div>
                      <div id="durationDisplay">0:00</div>
                    </div>
                  </div>
                </div>
              </div>
              
                    ';
      }
      echo '</div>';
      if (!empty($content)) {
        echo '<p>' . $content . '</p>';
      }
      if (!empty($time_ago)) {
        echo '<p>' . $time_ago . '</p>';
      }
      echo '</div>';
    }
    echo '</div>
        </div>
    </div>
</div>';
  }
  echo '<div class="modal fade" id="setBioModal" tabindex="-1" role="dialog" aria-labelledby="setBioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="setBioModalLabel">Set Bio</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" id="bioTextArea" rows="3"> ' . $getbio . ' </textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveBio()">Save changes</button>
      </div>
    </div>
  </div>
</div>';
  echo '<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="editprofileLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editprofileLabel">Edit Profile</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <fieldset>
      <legend>Personal Information</legend>
      <div class="form-group">
        <label for="Surname">Surname:</label>
        <textarea style="height: 30px;" type="text" class="form-control" id="Surname" placeholder="Surname" name="Surname">' . $Surname . '</textarea>
      </div>
      <div class="form-group">
        <label for="First Name">First Name:</label>
        <textarea style="height: 30px;" type="text" class="form-control" id="First_Name" placeholder="First Name" name="First_Name">' . $First_Name . '</textarea>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <textarea style="height: 30px;" type="email" class="form-control" id="email" placeholder="Email" name="email">' . $email . '</textarea>
      </div>
    </fieldset>
    
    <fieldset>
      <legend>Contact Information</legend>
      <div class="form-group">
        <label for="Phone">Phone:</label>
        <textarea style="height: 30px;" type="text" class="form-control" id="phone" placeholder="Phone" name="phone">' . $phone . '</textarea>
      </div>
      <div class="form-inline">
        <div class="form-group">
          <label for="gender">Gender:</label>
          <select name="gender" id="gender" name="gender" class="form-control">
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Others">I prefer not to say</option>
          </select>
        </div>
        <div class="form-group">
          <label for="dob">DOB:</label>
          <input style="height: 30px;" type="date" class="form-control" id="dob" placeholder="dob" name="dob">' . $dob . '
              </div>
          </div>
          </fieldset>
  
          <fieldset>
      <legend>Location Information</legend>
          <div class="form-group">
              <div class="form-inline">
                  <div class="form-group">
                      <label for="Country">Country:</label>
                      <select name="country" class="countries form-control" id="countryId">
                          <option value="">Select Country</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="State">State:</label>
                      <select name="state" class="states form-control" id="stateId">
                          <option value="">Select State</option>
                      </select>
                  </div>
              </div>
          </div>
          <div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="editpro()">Save changes</button>
      </div>
    </div>
  </div>
  </div>
</div>';
  echo '<script src="js/jquery.min.js"></script>';
  echo '<script>
//Script to load
// user country code for selected option
let user_country_code = "$countryId";

(function () {

    let country_list = country_and_states["country"];
    let states_list = country_and_states["states"];

    // creating country name drop-down
    let option = "";
    option += "<option>select country</option>";
    for (let country_code in country_list) {
        // set selected option user country
        let selected = (country_code == user_country_code) ? " selected" : "";
        option += "<option value=\"" + country_code + "\"" + selected + ">" + country_list[country_code] + "</option>";
    }
    document.getElementById("countryId").innerHTML = option;

    // creating states name drop-down
    let text_box = "<input type=\"text\" class=\"input-text\" id=\"state\">";
    let state_code_id = document.getElementById("stateId");

    function create_states_dropdown() {
        // get selected country code
        let country_code = document.getElementById("countryId").value;
        let states = states_list[country_code];
        // invalid country code or no states add textbox
        if (!states) {
            state_code_id.innerHTML = text_box;
            return;
        }
        let option = "";
        if (states.length > 0) {
            option = "<select id=\"state\">\n";
            for (let i = 0; i < states.length; i++) {
                option += "<option value=\"" + states[i].code + "\">" + states[i].name + "</option>";
            }
            option += "</select>";
        } else {
            // create input textbox if no states
            option = text_box
        }
        state_code_id.innerHTML = option;
    }

    // country select change event
    const country_select = document.getElementById("countryId");
    country_select.addEventListener("change", create_states_dropdown);

    create_states_dropdown();
})();
// end of Country and State loading
</script>';



  echo '<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("////").pop();
  $(this).siblings(".custom-file-upload").html("<i class=\"bi bi-check-circle-fill\"></i> " + fileName);
});

</script>
';
  echo '<script>
function saveBio() {
  var bio = document.getElementById("bioTextArea").value;
  var UserId = "' . $_GET["UserId"] . '";

  // Do something with the bio, e.g. send it to the server using AJAX
  if (bio != "") {
    $.ajax({
      url: "SubmitUserForm.php",
      type: "POST",
      async: false,
      data: {
        "addbio": 1,
        "bio": bio,
        "UserId": UserId,

      },
      success: function (data) {
        alert(data)
        $("#bioTextArea").val("");
        // Reload the frame with class "col-md-8 profile-info"
        $(".col-md-4.profile-info").load(location.href + " .col-md-4.profile-info>*","");
      }
    });
  } else {
    alert("Field Missing");
  }
  console.log(bio);
  // Close the modal
  $("#setBioModal").modal("hide");
}
</script>';
  echo '<script>
function editpro() {
    var UserId = "' . $_GET["UserId"] . '";

    var Surname = $("#Surname").val();
    var First_Name = $("#First_Name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var gender = $("#gender").val();
    var dob = $("#dob").val();
    var country = $("#countryId").val();
    var state = $("#stateId").val();

    if (Surname === "" || First_Name === "" || email === "" || phone === "" || gender === "" || dob === "" || country === "" || state === "") {
        alert("Please fill in all the required fields.");
        return false;
    }

    $.ajax({
        url: "SubmitUserForm.php", 
        type: "POST",
        data: {
            edit: 1,
            UserId: UserId,
            Surname: Surname,
            First_Name: First_Name,
            email: email,
            phone: phone,
            gender: gender,
            dob: dob,
            country: country,
            state: state
        },
        success: function(data) {
            alert(data);
            location.reload();
        },
        error: function(xhr, status, error) {
            // handle error response here
            alert(data);
        }
    });
}
</script>';

  echo ' <script>
$(document).ready(function(){
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

</script>';
  echo '<script>
$(document).ready(function() {
  const searchBox = $("#search");
  const resultsDiv = $("#user_table");

  searchBox.on("input", function() {
    const searchTerm = this.value.trim();

    // Clear the results if the search box is empty
    if (!searchTerm) {
      resultsDiv.html("");
      return;
    }

    // Send a request to the server to get the search results
    $.ajax({
      url: "searchbackend.php",
      method: "POST",
      data: { search_query: searchTerm },
      success: function(data) {
        // Update the table with the returned results
        resultsDiv.html(data);
      }
    });
  });
});
</script>';
  echo '<script>
$(document).ready(function() {
    var profileOwnerId = "' . $profileOwnerId . '";
    var recipientId = "' . $UserId . '";
    var followBtn = $("#followBtn");

    $(".follow").click(function() {
        // alert("Button is working!");
        $.ajax({
            url: "follow.php",
            type: "POST",
            data: {
                follow: 1,
                unfollow: 1,
                profileOwnerId: profileOwnerId,
                recipientId: recipientId
            },
            success: function(response) {
                alert(response);

                if (response == "followed") {
                    followBtn.removeClass("btn-primary").addClass("btn-secondary").text("Unfollow");
                } else if (response == "unfollowed") {
                    followBtn.removeClass("btn-secondary").addClass("btn-primary").text("Follow");
                }
                        
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
});
</script>';
  echo '<script>
    // Get the video element
const myVideo = document.getElementById("myVideo");

// Get the controls
const playPauseButton = document.getElementById("playPauseButton");
const rewindButton = document.getElementById("rewindButton");
const fastForwardButton = document.getElementById("fastForwardButton");
const volumeRange = document.getElementById("volumeRange");
const timeRange = document.getElementById("timeRange");
const currentTimeDisplay = document.getElementById("currentTimeDisplay");

// Update the current time display
// function updateCurrentTimeDisplay() {
//   currentTimeDisplay.textContent = formatTime(myVideo.currentTime) + " / " + formatTime(myVideo.duration);
// }

// Format time in minutes and seconds
// function formatTime(time) {
//   const minutes = Math.floor(time / 60);
//   const seconds = Math.floor(time % 60);
//   return (minutes < 10 ? "0" : "") + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
// }

// Toggle play/pause
function togglePlayPause() {
    // console.log("Toggle play/pause button clicked");
    if (myVideo.paused) {
      myVideo.play();
      playPauseButton.textContent = "Pause";
    } else {
      myVideo.pause();
      playPauseButton.textContent = "Play";
    }
}

  
// Rewind 10 seconds
function rewind() {
  myVideo.currentTime -= 10;
}

// Fast forward 10 seconds
function fastForward() {
  myVideo.currentTime += 10;
}

// Set volume
function setVolume() {
  myVideo.volume = volumeRange.value;
}

// Set current time
function setCurrentTime() {
  myVideo.currentTime = timeRange.value;
  updateCurrentTimeDisplay();
}

// Update the time range input on time update
myVideo.ontimeupdate = function() {
  timeRange.value = myVideo.currentTime;
  updateCurrentTimeDisplay();
};

// Get the video and time range input elements
// const myVideo = document.getElementById("myVideo");
// const timeRange = document.getElementById("timeRange");

// Set the max value of the time range input on metadata load
myVideo.onloadedmetadata = function() {
  timeRange.max = myVideo.duration;
  updateCurrentTimeDisplay();
  updateDurationDisplay();
};

// Update the current time display element when the time updates
myVideo.ontimeupdate = function() {
  updateCurrentTimeDisplay();
};

// Update the current time display element
function updateCurrentTimeDisplay() {
  const currentTimeDisplay = document.getElementById("currentTimeDisplay");
  const currentTime = myVideo.currentTime;
  currentTimeDisplay.textContent = formatTime(currentTime);
}

// Update the duration display element
function updateDurationDisplay() {
  const durationDisplay = document.getElementById("durationDisplay");
  const duration = myVideo.duration;
  durationDisplay.textContent = formatTime(duration);
}

// Format the time in the format of "h:m:ss"
function formatTime(time) {
  const minutes = Math.floor(time / 60);
  const seconds = Math.floor(time % 60);
  const formattedTime = minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
  return formattedTime;
}


  </script>
  ';
} else {
  // User is not logged in, redirect to the login page
  header('Location: login.php');
  exit;
}
?>
<?php
if (isset($_POST['button'])) {

  $FirstPassportName = basename($_FILES["Fileupload"]["name"]);

  $target_dir = "UserPassport/"; //directory on the server in my application folder
  $target_file = $target_dir . $FirstPassportName;
  $PassportName = $FirstPassportName;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


  if (unlink("UserPassport/" . $Passport)) {
  }
  //  else {
  // 	echo 'There was a error deleting the file ' . $filename;
  // }


  include('db.php');


  if ($imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "jpeg" && $imageFileType != "png") {

    echo "<script type=\"text/javascript\">
alert(\"Sorry, only JPG,PNG & PDF files are allowed.\");
</script>";
  }

  if (move_uploaded_file($_FILES["Fileupload"]["tmp_name"], $target_file)) {


    include('db.php');

    $sql = "Update User_Profile SET Passport='$PassportName' WHERE UserId='$UserId'";


    $smc = sqlsrv_query($conn, $sql);

    //give information if the data is successful or not.

    if ($smc === false) {
      echo " <font color='black'><em> data not successfully upload</em></font><br/>";
      die(print_r(sqlsrv_errors(), true));
    } else {

      // echo"File Upload successful";
      echo "<script type=\"text/javascript\">
                              alert(\"The file has been uploaded\");
                              </script>";
    }




    // $msg = $picture;

    $URL = "user_profile.php?UserId=" . $UserId;
    echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    // 	--------------------------------------------------------------------

  }
}

?>