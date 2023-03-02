<?php
session_start();

if (isset($_SESSION['UserId'])) {
    // Get the user ID of the profile owner from the URL
    $profileOwnerId = $_GET['UserId'];

    // Check if the user viewing the profile is the same as the profile owner
    $isProfileOwner = ($_SESSION['UserId'] == $profileOwnerId);

    // Query the database to get the user's profile information
    // ...

    // Display the profile information
    // If $isProfileOwner is true, display all the information
    // If $isProfileOwner is false, only display some of the information
    // ...
} else {
    // User is not logged in, redirect to the login page
    header('Location: login.php');
    exit;
}
?>