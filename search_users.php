<?php
session_start();
include ('db.php');

$search_term = $_POST['search_query'];



$tsql = "select * from User_Profile WHERE Surname LIKE '%$search_term%' OR First_Name LIKE '%$search_term%' OR UserId LIKE '%$search_term%'";
$stmt = sqlsrv_query($conn, $tsql);

if($stmt === false) {
  die(print_r(sqlsrv_errors(), true));
}
if ($search_term == "") {
  echo "";
  }else{
  
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

  $FirstName= $row['First_Name'];
  $Surname=$row['Surname'] ;
  $UserIdx=$row['UserId'] ;
  $passport=$row['Passport'] ;
  $UserId=$_SESSION['UserId'];
  if (empty($passport)) {
    $recipientPassport = "UserPassport/DefaultImage.png";
  } else {
    $recipientPassport = "UserPassport/" . $passport;
  }
  echo "<div class='name_div'>
  <img class='pass_div' src='".$recipientPassport."'><a class='name'>".$FirstName." ".$Surname."</a>
  </div>";
}

echo "</ul>";
  }



?>
