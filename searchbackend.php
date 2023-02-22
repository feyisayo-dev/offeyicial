<?php
session_start();
include ('db.php');

// Get search term from POST request
$search_term = $_POST['search_query'];



// Create and execute search query
$tsql = "select * from User_Profile WHERE Surname LIKE '%$search_term%' OR First_Name LIKE '%$search_term%'";
$stmt = sqlsrv_query($conn, $tsql);

// Check if query was successful
if($stmt === false) {
  die(print_r(sqlsrv_errors(), true));
}

// Fetch and display search results
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

 $FirstName= $row['First_Name'];
 $Surname=$row['Surname'] ;
 $UserIdx=$row['UserId'] ;
 $UserId=$_SESSION['UserId'];

 ?>
 <tr>
  <td>
    <a href="chat.php?UserIdx=<?php echo $UserIdx; ?>&UserId=<?php echo $UserId; ?>"><?php echo $FirstName;?></a>
 </td>
  <td>
 <a href="chat.php?UserIdx=<?php echo $UserIdx; ?>&UserId=<?php echo $UserId; ?>"><?php echo $Surname;?></a>
  </td>
 
 </tr>
 

  <?php
  //  echo "<td><a href='chat.php?UserId=echo $row['Surname']</a></td>";
  
}

?>
