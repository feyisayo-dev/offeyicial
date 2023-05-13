<?php
session_start();
include('db.php');

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['psw'];

    // Verify the user
    $sql = "SELECT UserId, Password FROM User_Profile WHERE email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt !== false && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $UserId = $row['UserId'];
        $hashed_password = $row['Password'];

        if (password_verify($password, $hashed_password)) {
            // Login successful
            $_SESSION['UserId'] = $UserId;
            echo $UserId; // Return the UserId as a simple string
            exit();
        } else {
            // Invalid email or password
            echo 'failed'; // Return a simple string indicating login failure
        }
    } else {
        // Invalid email or password
        echo 'failed'; // Return a simple string indicating login failure
    }

    $_SESSION['loggedin'] = true;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The user is logged in
} else {
    // The user is not logged in
      // Redirect to login page
  header("Location: login.php");
  exit();
}
?>