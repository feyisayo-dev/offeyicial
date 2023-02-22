<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit();
}
?>

    <!-- rest of your HTML code -->

    <?php
    $UserId=$_GET["UserId"];
    include ('db.php');

    $fetchUserInfo="Select [Surname]
    ,[First_Name]
    ,[gender]
    ,[email]
    ,[Password]
    ,[phone]
    ,[dob]
    ,[countryId]
    ,[stateId]
    ,[Passport] from User_Profile where UserId='$UserId'";
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

?>
<?php
$UserId=$_GET["UserId"];
include ('db.php');

$fetchPostsinfo = "SELECT [PostId], [title], [content], [video], [image], [date_posted] FROM posts WHERE UserId='$UserId' ORDER BY date_posted DESC";

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
    $date_posted=$row['date_posted'];
    $date_postedy = date_format($date_posted, 'Y-m-d H:i:s');
    $current_date = new DateTime();
    $date_postedx = new DateTime($date_postedy);
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
?>

            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <title>Profile - Offeyicial</title>
                <link rel="stylesheet" href="css/all.min.css" />
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="css\font\bootstrap-icons.css">
  <link rel="icon" href="img\offeyicial.jpeg" type="image/jpeg" sizes="32x32" />

                <style>
                    .user-profile {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }
                    
                    .profile-pic img {
                        width: 250px;
                        height: 250px;
                        border-radius: 90%;
                        margin-top: 20px;
                    }
                    
                    .user-details {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-top: 20px;
                        text-align: center;
                    }
                    
                    .user-details h2 {
                        font-size: 24px;
                        margin-bottom: 10px;
                    }
                    
                    .user-details p {
                        font-size: 18px;
                        margin-bottom: 10px;
                    }
                    
                    .user-details-item {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        margin-bottom: 10px;
                    }
                    
                    .user-details-item span {
                        font-weight: bold;
                        margin-right: 10px;
                    }
                    
                    .user-posts {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        margin-top: 20px;
                        text-align: center;
                    }
                    
                    .user-posts h2 {
                        font-size: 24px;
                        margin-bottom: 10px;
                    }
                    
                    .user-posts-item {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-right: 20px;
                    }
                    
                    .user-posts-item img {
                        width: 150px;
                        height: 150px;
                        margin-bottom: 10px;
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
                        cursor: pointer;
                    }
                    
                    /* h3 {
                        text-align: center;
                        text-transform: uppercase;
                    } */
                    .grid-container {
                        display: grid;
                        /* grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); */
                        grid-gap: 20px;
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
                                <a class="nav-link custom-link" onclick="window.location.href='index.php?UserId=<?php echo $UserId; ?>'"></i>NEWS-FEED</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId; ?>'">Add a Post</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='search.php?UserId=<?php echo $UserId; ?>'">Search Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"></i>Logout</a>
                            </li>

                    </div>
                </nav>

                <div class="container-fluid profile-section">
                    <br><br><br>
                    <div class="row">
                        <div class="col-md-4 profile-pic">
                            <img src="UserPassport/<?php echo $Passport; ?>" class="button" alt="Profile Picture">
                            <P>Enhance your online persona</P>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="file" name="Fileupload" id="upload1" placeholder="Choose file path" style="float: left;background-color:orange;" required />

                                <button type="submit" name="button" id="button" style="background-color:#006600; border-radius:5px;">

                            <i class="fa fa-plus" style="color:#FFFFFF; size:40px">&nbsp;Upload</i> </button>
                                <hr>
                        </div>
                        <div class="col-md-8 profile-info">
                            <h2>
                                <?php echo $Surname .'  ' . $First_Name;?>
                            </h2>
                            <p>Email:
                                <?php echo  $email;  ?>
                            </p>
                            <p>Phone Number:
                                <?php echo $phone;?>
                            </p>
                            <p>Gender:
                                <?php echo $gender; ?>
                            </p>
                            <p>Date of Birth:
                                <?php echo   $dob;?>
                            </p>
                            <p>Location ID:
                                <?php echo $countryId .'  ' . $stateId;?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h3 style="text-align: center; color:green; text-transform: uppercase;" >Posts</h3>
                            <div class="posts">
	      <div class="post">
		  <h3 style="text-transform: uppercase; font-family: arial;"><?php echo   $title;?></h3>
		  <!-- <div class="grid-container">
            <div class="grid-item">
                <img src="<?php echo $image; ?>">
            </div>
            <div class="grid-item">
                <video controls>
                <source src="<?php echo $video; ?>" type="video/mp4">
                </video>
            </div>
            </div> -->


            <?php if (!empty($image)): ?>
                <div class="grid-item">
                  <img src="<?php echo $image; ?>">
                </div>
              <?php endif; ?>
              
              <?php if (!empty($video)): ?>
                <div class="grid-item">
                  <video controls>
                    <source src="<?php echo $video; ?>" type="video/mp4">
                  </video>
                </div>
              <?php endif; ?>
              

		  <p><?php echo   $content;?></p>
		  <p><?php echo   $time_ago;?></p>
		  </div>

                            </div>
                        </div>
                    </div>
                </div>
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
                              
                              $URL="user_profile.php?UserId=$UserId";
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              // 	--------------------------------------------------------------------
                                                                
                                    }





}

?>
            </body>

            </html>