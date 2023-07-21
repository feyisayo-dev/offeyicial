<?php
include('db.php');

// Get the UserId from the request parameters
$UserId = $_GET['UserId'];

// Create an empty array to hold the profile data
$profileData = array();

// Query the database to retrieve the user profile
$sql = "SELECT Surname, First_Name, Passport FROM User_Profile WHERE UserId = ?";
$stmt = sqlsrv_prepare($conn, $sql, array(&$UserId));
if (sqlsrv_execute($stmt)) {
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Assign the profile data to the array
        $profileData['surname'] = $row['Surname'];
        $profileData['firstName'] = $row['First_Name'];
        $passport = $row['Passport'];
        if (empty($passport)) {
            $profileData['passport'] = "UserPassport/DefaultImage.png";
        } else {
            $profileData['passport'] = "UserPassport/" . $passport;
        }
    }
}

// Return the profile data as JSON
header('Content-Type: application/json');
echo json_encode($profileData);
?>
