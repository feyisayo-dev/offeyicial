<?php
session_start();
include('db.php');

if(isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['psw'];

    // Verify the user
    $sql = "SELECT UserId, Password FROM User_Profile WHERE email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);
    
    if($stmt !== false && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $UserId = $row['UserId'];
        $hashed_password = $row['Password'];
        
        if($password === $hashed_password) {
            // Login successful
            $_SESSION['UserId'] = $UserId;
            echo json_encode(['status' => "success", 'UserId' => $UserId]);
        } else {
            // Invalid email or password
            echo json_encode(["status" => 'failed']);
        }
    } else {
        // Invalid email or password
        echo json_encode(["status" => 'failed']);
    }
  
    $_SESSION['loggedin'] = true;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The user is logged in
} else {
    // The user is not logged in
}
