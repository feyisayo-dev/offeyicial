<?php
session_start();
include ('db.php');
if(isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['psw'];

    // Verify the user
    $sql = "select [email],[Password],UserId from User_Profile WHERE email = '$email' AND Password = '$password'";
    $result = sqlsrv_query($conn, $sql);

    if(sqlsrv_has_rows($result)) {
        // Login successful
        // Store the user's email in the session
        $row = sqlsrv_fetch_array($result);
        $UserId = $row['UserId'];
        $_SESSION['UserId'] = $UserId;
        echo json_encode(['status' => "success", 'UserId' => $UserId]);

    }else {
      // Login failed
      echo json_encode(["status" => 'failed']);
  }
  
    $_SESSION['loggedin'] = true;
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The user is logged in
  } else {
    // The user is not logged in
  }
?>