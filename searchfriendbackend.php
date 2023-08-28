<?php
session_start();
include ('db.php');

// Get search term from GET request
$search_term = $_GET['search_query'];

// Create and execute search query
$tsql = "SELECT * FROM User_Profile WHERE Surname LIKE '%$search_term%' OR First_Name LIKE '%$search_term%'";
$stmt = sqlsrv_query($conn, $tsql);

// Check if query was successful
if($stmt === false) {
  die(print_r(sqlsrv_errors(), true));
}

// Display search results with checkboxes
echo "<ul>";
while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  $FirstName = $row['First_Name'];
  $Surname = $row['Surname'];
  $UserIdx = $row['UserId'];
  $UserId = $_SESSION['UserId'];

  // Create a list item for each search result with a checkbox
  echo "<li>
            <input type='checkbox' class='checkbox' name='selectedUsers[]' value='$UserIdx' id='checkbox-$UserIdx'>
            <label for='checkbox-$UserIdx'>$FirstName $Surname</label>
        </li>";
}
echo "</ul>";
