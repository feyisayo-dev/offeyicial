<?php
session_start();

if (isset($_SESSION['UserId'])) {
    // Get the user ID of the profile owner from the URL
    $profileOwnerId = $_GET['UserId'];
    $UserId=$_SESSION["UserId"];
    include ('db.php');
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

    if (empty( $Passport)) {
      $GetPassport="UserPassport/DefaultImage.png";
     }else{
     $GetPassport="UserPassport/".$Passport;
     }
     if (empty($bio)) {
        $getbio = "Not yet set";
    } else {
        $getbio = $bio;
    }
    

$fetchPostsinfo = "SELECT [PostId], [title], [content], [video], [image], [date_posted] FROM posts WHERE UserId='$profileOwnerId' ORDER BY date_posted DESC";

$fetchPosts=sqlsrv_query($conn,$fetchPostsinfo);
if( $fetchPosts === false ) {
     die( print_r( sqlsrv_errors(), true));
}

while($row = sqlsrv_fetch_array($fetchPosts, SQLSRV_FETCH_ASSOC)) {
    $PostId=$row['PostId'];
    $title=$row['title'];
    $content=$row['content'];
    $video=$row['video'];
    $image=$row['image'];
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
    
    // rest of the code to display post information
}
    // Get the count of followers and following for the profile owner and recipient
    $sql = "SELECT COUNT(*) as num_followers FROM follows WHERE recipientId = ?";
    $params = array($profileOwnerId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $followers = $row['num_followers'];

    $sql = "SELECT COUNT(*) as num_following FROM follows WHERE UserId = ?";
    $params = array($profileOwnerId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $following = $row['num_following'];
    // Display the profile information

    // If $isProfileOwner is true, display all the information


// Check if user ID is equal to profile owner ID
if ($UserId == $isProfileOwner) {
    echo '<title>Profile ~ '.$Surname.' '.$First_Name.'</title>
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
    echo '<link rel="stylesheet" href="profile.css">';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
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
                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>';

    // Display all information
    echo '<div class="container-fluid profile-section">';
    echo '<br><br><br>';
    echo '<div class="row">';
    echo '<div class="col-md-4 profile-pic">';
    echo '<img src="'.$GetPassport.'" class="button" alt="Profile Picture">';
        echo '<P>Enhance your online persona</P>';
        echo '<form action="" method="POST" enctype="multipart/form-data">';
            echo '<label for="upload1" class="custom-file-upload">
            <i class="fa fa-cloud-upload"></i> Choose File
          </label>
          <input type="file" class="custom-file-input" name="Fileupload" id="upload1" required />
          ';
            echo '<button type="submit" name="button" id="button" style="background-color:#006600; border-radius:5px;">';
        echo '<i class="fa fa-plus" style="color:#FFFFFF; size:40px">&nbsp;Upload</i> </button>';
            echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-4 profile-info">';
        echo '<h2>' .$Surname .'  ' . $First_Name. '</h2>';
        echo '<p>Email: '.$email.'</p>';
        echo '<p>Phone Number: '.$phone.'</p>';
        echo '<p>Gender: '.$gender.'</p>';
        echo '<p>Date of Birth: '.$dob.'</p>';
        echo '<p>Location ID: '.$countryId.' '.$stateId.'</p>';  
        echo '<p>Bio: '.$getbio.'</p>';        
        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setBioModal">
        Set Bio
      </button>';     
    echo '</div>';
    echo '<div class="col-md-4">
    <div class="row">
      <div class="col-md-6">
        <p style="margin-bottom: 0;">'.$following.'</p>
        <p style="font-size: 0.8rem;">Following</p>
      </div>
      <div class="col-md-6">
        <p style="margin-bottom: 0;">'.$followers.'</p>
        <p style="font-size: 0.8rem;">Followers</p>
      </div>
    </div>
  </div>';
echo '</div>';

echo '<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center text-uppercase text-success">Posts</h3>
            <div class="posts">
                <div class="post">';
                if (!empty($image)) {
                    echo '<h3 class="title">' . $title . '</h3>';
                }
                echo '<div class="row">';
                if (!empty($image)) {
                    echo '<div class="col-md-6">
                                <img src="' . $image . '" class="img-fluid">
                            </div>';
                }
                if (!empty($video)) {
                    echo '<div class="col-md-6">
                                <video controls class="w-100">
                                    <source src="' . $video . '" type="video/mp4">
                                </video>
                            </div>';
                }
                echo '</div>';
                if (!empty($image)) {
                    echo '<p>' . $content . '</p>';
                }
                if (!empty($image)) {
                    echo '<p>' . $time_ago . '</p>';
                }
            echo '</div>
            </div>
        </div>
    </div>
</div>';

    // If $isProfileOwner is false, only display some of the information
    // ...
} else {
    echo '<title>Profile ~ '.$Surname.' '.$First_Name.'</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />';    
    echo '<link rel="stylesheet" href="profile.css">';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
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
                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>';

    // Display all information
    echo '<div class="container-fluid profile-section">';
    echo '<br><br><br>';
   echo '<div class="row">';
    echo '<div class="col-md-4 profile-pic">';
    echo '<img src="'.$GetPassport.'" class="button" alt="Profile Picture">';
        echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-4 profile-info">';
        echo '<h2>' .$Surname .'  ' . $First_Name. '</h2>';

        echo '<p>Gender: '.$gender.'</p>';
        echo '<p>Bio: '.$getbio.'</p>';    
        echo '<button id="followBtn" class="follow unfollow">Follow</button>';
    echo '<div class="col-md-4">
    <div class="row">
      <div class="col-md-6">
        <p style="margin-bottom: 0;">'.$following.'</p>
        <p style="font-size: 0.8rem;">Following</p>
      </div>
      <div class="col-md-6">
        <p style="margin-bottom: 0;">'.$followers.'</p>
        <p style="font-size: 0.8rem;">Followers</p>
      </div>
    </div>
  </div>
  ';
echo '</div>';
echo '<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center text-uppercase text-success">Posts</h3>
            <div class="posts">
                <div class="post">';
                if (!empty($image)) {
                    echo '<h3 class="title">' . $title . '</h3>';
                }
                echo '<div class="row">';
                if (!empty($image)) {
                    echo '<div class="col-md-6">
                                <img src="' . $image . '" class="img-fluid">
                            </div>';
                }
                if (!empty($video)) {
                    echo '<div class="col-md-6">
                                <video controls class="w-100">
                                    <source src="' . $video . '" type="video/mp4">
                                </video>
                            </div>';
                }
                echo '</div>';
                if (!empty($image)) {
                    echo '<p>' . $content . '</p>';
                }
                if (!empty($image)) {
                    echo '<p>' . $time_ago . '</p>';
                }
            echo '</div>
            </div>
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
        <textarea class="form-control" id="bioTextArea" rows="3"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveBio()">Save changes</button>
      </div>
    </div>
  </div>
</div>';
echo '<script src="js/jquery.min.js"></script>';
echo '<script>
$(".custom-file-input").on("change", function() {
  // Get the selected file name
  var fileName = $(this).val().split("\\").pop();
  // Update the label text
  $(this).next(".custom-file-label").html("<i class=\"bi bi-check-circle-fill\"></i> " + fileName);
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
        $(".col-md-8.profile-info").load(location.href + " .col-md-8.profile-info>*","");
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
                if(isset($_POST['button'])){

$FirstPassportName=basename($_FILES["Fileupload"]["name"]);

$target_dir = "UserPassport/";//directory on the server in my application folder
$target_file = $target_dir . $FirstPassportName; 
$PassportName= $FirstPassportName;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


if (unlink("UserPassport/".$Passport)) {

}
//  else {
// 	echo 'There was a error deleting the file ' . $filename;
// }


include ('db.php');


if($imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "jpeg" && $imageFileType != "png" ) {

echo "<script type=\"text/javascript\">
alert(\"Sorry, only JPG,PNG & PDF files are allowed.\");
</script>"; 

}

if (move_uploaded_file($_FILES["Fileupload"]["tmp_name"], $target_file)) {


include ('db.php');
        
$sql="Update User_Profile SET Passport='$PassportName' WHERE UserId='$UserId'";


$smc=sqlsrv_query($conn,$sql);

//give information if the data is successful or not.

If ($smc===false){
                   echo" <font color='black'><em> data not successfully upload</em></font><br/>";
                   die( print_r( sqlsrv_errors(), true));  
                 }else{
                     
                    // echo"File Upload successful";
                    echo "<script type=\"text/javascript\">
                              alert(\"The file has been uploaded\");
                              </script>"; 
                         }




                              // $msg = $picture;
                              
                              $URL="user_profile.php?UserId=" .$UserId ;
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              // 	--------------------------------------------------------------------
                                                                
                                    }





}

?>