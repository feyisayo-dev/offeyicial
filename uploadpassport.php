<?php
                if(isset($_POST['image'])){
                    $UserId = $_SESSION['UserId'];

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
                              
                              $URL="user_profile.php?UserId=" +$UserId ;
                              echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
                              echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                              // 	--------------------------------------------------------------------
                                                                
                                    }





}

?>