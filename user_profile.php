<?php
session_start();
// Check if user is logged in

if (isset($_SESSION['UserId'])) {
  $profileOwnerId = $_GET['UserId'];
  $UserId = $_SESSION["UserId"];
  include('db.php');
  // echo $profileOwnerId;
  // echo $UserId;
  $isProfileOwner = ($UserId == $profileOwnerId);


  $stmt = sqlsrv_prepare($conn, "SELECT [UserId], [Surname], [First_Name], [gender], [email], [Password], [phone], [dob], [countryId], [stateId], [Passport], [bio] FROM User_Profile WHERE UserId = ?", array(&$profileOwnerId));

  if (!$stmt) {
    die(print_r(sqlsrv_errors(), true)); 
  }

  $FetchStatement = sqlsrv_execute($stmt);

  if ($FetchStatement === false) {
    die(print_r(sqlsrv_errors(), true)); 
  }

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
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <script src="js/owl.carousel.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/sweetalert2@10.js"></script>
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
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
                <a class="nav-link custom-link" onclick="window.location.href=\'index.php?UserId=' . $UserId . '\'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
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

    echo ' <div class="wrapper">
    <svg>
      <text x="50%" y="50%" dy=".35em" text-anchor="middle">
      <tspan dy="0">' . $Surname . '</tspan>
    <tspan x="50%" dy="1.5em">' . $First_Name . '</tspan>
      </text>
    </svg>
  </div>';
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

    echo '<div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center text-uppercase text-success">Posts</h3>
                    <div id="posts" class="posts">
                    </div>
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
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <script src="js/sweetalert2@10.js"></script>';
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
    echo ' <div class="wrapper">
    <svg>
      <text x="50%" y="50%" dy=".35em" text-anchor="middle">
      <tspan dy="0">' . $Surname . '</tspan>
    <tspan x="50%" dy="1.5em">' . $First_Name . '</tspan>
      </text>
    </svg>
  </div>';
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
            <div id="posts" class="posts">';
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
<script>
  var userId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

  // Check if the UserId exists
  if (!userId) {
    // UserId not found, redirect to login page
    window.location.href = "login.php";
  }
</script>
<script src="node_modules/socket.io-client/dist/socket.io.js"></script>
<script src="js/owl.carousel.min.js"></script>

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
    const formData = new FormData();
    formData.append('UserId', UserId);

    fetch('http://localhost:8888/fetchPostForEachUser', {
        method: 'POST',
        body: formData,
      })
      .then((response) => {
        if (!response.ok) {
          throw new Error('Error finding post');
        }
        return response.json();
      })
      .then((result) => {
        result.forEach((post) => {
          loadNewsFeed(post);
        });
      })
      .catch((error) => {
        console.error(error);
      });
  });



  function likepost(postId) {
    var post = document.getElementById(postId);
    var UserId = "<?php echo $_SESSION['UserId']; ?>";
    var likeBtn = post.querySelector('.like');
    var likeCountSpan = likeBtn.querySelector('.like-count');
    var likeCount = parseInt(likeCountSpan.textContent);
    const formData = new FormData();
    formData.append('UserId', UserId);
    formData.append('postId', postId);

    fetch('http://localhost:8888/likepost', {
        method: 'POST',
        body: formData,
      })
      .then((response) => {
        console.log(response);
        if (!response.ok) {
          throw new Error('Error liking/unliking post');
        }
        return response.json();
      })
      .then((result) => {
        const likeStatus = result.likeStatus;
        if (likeStatus === 'like') {
          likeBtn.classList.add('likeing');
          likeBtn.classList.remove('unlike');
          likeCount++;
          likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
            '<span class="emoji"><img src="icons/love.png"></span>';
        } else if (likeStatus === 'unlike') {
          likeBtn.classList.add('unlike');
          likeBtn.classList.remove('likeing');
          likeCount--;
          likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
            '<span class="emoji"><img src="icons/unlove.png"></span>';
        }

        likeCountSpan.textContent = likeCount;
      })
      .catch((error) => {
        console.error(error);
      });
  }

  function checkIfItIsClicked(postId) {
    console.log('checking for post with', postId, 'and UserId', UserId);
    var post = document.getElementById(postId);
    var likeBtn = post.querySelector('.like');
    var likeCountSpan = likeBtn.querySelector('.like-count');
    var likeCount = parseInt(likeCountSpan.textContent);
    const formData = new FormData();
    formData.append('UserId', UserId);
    formData.append('postId', postId);
    fetch('http://localhost:8888/checkLikeforPost', {
        method: 'POST',
        body: formData,
      })
      .then((response) => {
        if (response.ok) {
          return response.json();
        } else {
          throw new Error('Error checking if the post has been liked');
        }
      })
      .then((result) => {
        const likeStatus = result.likeStatus;
        if (likeStatus === 'liked') {
          likeBtn.classList.add('likeing');
          likeBtn.classList.remove('unlike');
          likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
            '<span class="emoji"><img src="icons/love.png"></span>';
        } else if (likeStatus === 'notLiked') {
          likeBtn.classList.add('unlike');
          likeBtn.classList.remove('likeing');
          likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
            '<span class="emoji"><img src="icons/unlove.png"></span>';
        }
      })
      .catch((error) => {
        console.error(error);
      });
  }

  function loadNewsFeed(data) {
    var newsFeed = document.getElementById('posts');

    var postElement = document.createElement('section');
    var postDiv = document.createElement('div');
    postDiv.className = 'post';
    postDiv.id = data.postId;

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
      likepost(data.postId);
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
    checkIfItIsClicked(data.postId);

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
    function setVolume(postId) {
      var video = document.getElementById('myVideo-' + postId);
      var volumeRange = document.getElementById('volumeRange-' + postId);

      video.volume = volumeRange.value;
    }

    window.addEventListener('DOMContentLoaded', function() {
      var videos = document.getElementsByTagName('video');

      for (var i = 0; i < videos.length; i++) {
        var video = videos[i];
        var postId = data.postId;
        var volumeRange = document.getElementById('volumeRange-' + postId);

        video.addEventListener('volumechange', function() {
          volumeRange.value = video.volume;
        });

        volumeRange.oninput = function() {
          setVolume(postId);
        };
      }
    });


    function setCurrentTime(postId) {
      var video = document.getElementById('myVideo-' + postId);
      var timeRange = document.getElementById('timeRange-' + postId);
      var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

      var newTime = video.duration * (timeRange.value / 100);

      video.currentTime = newTime;

      currentTimeDisplay.innerHTML = formatTime(video.currentTime);
    }

    // Function to format time in MM:SS format
    function formatTime(time) {
      var minutes = Math.floor(time / 60);
      var seconds = Math.floor(time % 60);

      minutes = String(minutes).padStart(2, '0');
      seconds = String(seconds).padStart(2, '0');

      return minutes + ':' + seconds;
    }


    function handleTimeUpdate(postId) {
      var video = document.getElementById('myVideo-' + postId);
      var timeRange = document.getElementById('timeRange-' + postId);
      var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

      var currentTime = video.currentTime;
      var duration = video.duration;
      var progress = (currentTime / duration) * 100;

      timeRange.value = progress;

      currentTimeDisplay.innerHTML = formatTime(currentTime);
    }

    var videos = document.getElementsByTagName('video');

    for (var i = 0; i < videos.length; i++) {
      var video = videos[i];
      var postId = data.postId;
      var timeRange = document.getElementById('timeRange-' + postId);
      var durationDisplay = document.getElementById('durationDisplay-' + postId);
      var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

      video.addEventListener('loadedmetadata', function() {
        durationDisplay.innerHTML = formatTime(video.duration);
      });

      video.addEventListener('timeupdate', function() {
        handleTimeUpdate(postId);
      });

      timeRange.oninput = function() {
        var newTime = video.duration * (timeRange.value / 100);
        video.currentTime = newTime;
        currentTimeDisplay.innerHTML = formatTime(newTime);
      };
    }
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

  function updateLikeCount(postId, likeCount) {
    console.log('Updating Like count for', postId);
    var post = document.getElementById(postId);
    if (post) {
      console.log('post div found');
      var likeBtn = post.querySelector('.like');
      var likeCountSpan = likeBtn.querySelector('.like-count');
      if (likeCountSpan) {
        likeCountSpan.textContent = likeCount;
      } else {
        console.log('No buttonElement found');
      }
    } else {
      console.log('no post with postId found');
    }

  }
</script>