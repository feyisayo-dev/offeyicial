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
    $fetchUserInfo="Select [Surname]
    ,[First_Name]
    ,[gender]
    ,[email]
    ,[Password]
    ,[phone]
    ,[dob]
    ,[countryId]
    ,[stateId]
    ,[Passport] from User_Profile where UserId='$profileOwnerId'";
$FetchStatement=sqlsrv_query($conn,$fetchUserInfo);
if( $FetchStatement === false ) {
     die( print_r( sqlsrv_errors(), true));
}

if (sqlsrv_fetch($FetchStatement)===false) {
    die( print_r( sqlsrv_errors(), true));
}else{
    $Surname=sqlsrv_get_field($FetchStatement,0);
    $First_Name=sqlsrv_get_field($FetchStatement,1);
    $gender=sqlsrv_get_field($FetchStatement,2);
    $email=sqlsrv_get_field($FetchStatement,3);
    $Password=sqlsrv_get_field($FetchStatement,4);
    $phone=sqlsrv_get_field($FetchStatement,5);
    $dob=sqlsrv_get_field($FetchStatement,6);
    $countryId=sqlsrv_get_field($FetchStatement,7);
    $stateId=sqlsrv_get_field($FetchStatement,8);
    $Passport=sqlsrv_get_field($FetchStatement,9);
    if (empty( $Passport)) {
      $GetPassport="UserPassport/DefaultImage.png";
     }else{
     $GetPassport="UserPassport/".$Passport;
     }
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

    // Display the profile information

    // If $isProfileOwner is true, display all the information


// Check if user ID is equal to profile owner ID
if ($UserId == $isProfileOwner) {
    echo '<title>Profile ~ '.$Surname.' '.$First_Name.'</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />';    
    echo '<link rel="stylesheet" href="profile.css">';
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
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
            echo '<input type="file" name="Fileupload" id="upload1" placeholder="Choose file path" style="float: left;background-color:orange;" required />';
            echo '<button type="submit" name="button" id="button" style="background-color:#006600; border-radius:5px;">';
        echo '<i class="fa fa-plus" style="color:#FFFFFF; size:40px">&nbsp;Upload</i> </button>';
            echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-8 profile-info">';
        echo '<h2>' .$Surname .'  ' . $First_Name. '</h2>';
        echo '<p>Email: '.$email.'</p>';
        echo '<p>Phone Number: '.$phone.'</p>';
        echo '<p>Gender: '.$gender.'</p>';
        echo '<p>Date of Birth: '.$dob.'</p>';
        echo '<p>Location ID: '.$countryId.' '.$stateId.'</p>';        
    echo '</div>';
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
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
            echo '<input type="file" name="Fileupload" id="upload1" placeholder="Choose file path" style="float: left;background-color:orange;" required />';
            echo '<button type="submit" name="button" id="button" style="background-color:#006600; border-radius:5px;">';
        echo '<i class="fa fa-plus" style="color:#FFFFFF; size:40px">&nbsp;Upload</i> </button>';
            echo '<hr>';
    echo '</div>';
    echo '<div class="col-md-8 profile-info">';
        echo '<h2>' .$Surname .'  ' . $First_Name. '</h2>';

        echo '<p>Gender: '.$gender.'</p>';        
    echo '</div>';
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
                              
                              $URL="user_profile.php?UserId=<?php echo $UserId ?>";
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              // 	--------------------------------------------------------------------
                                                                
                                    }





}

?>