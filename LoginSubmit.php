<?php
session_start();
include('db.php');

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $password = $_POST['psw'];

    $sql = "SELECT UserId, Password FROM User_Profile WHERE email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt !== false && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $UserId = $row['UserId'];
        $hashed_password = $row['Password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['UserId'] = $UserId;
            echo $UserId;
            exit();
        } else {
            echo 'failed';
        }
    } else {
        echo 'failed';
    }

    $_SESSION['loggedin'] = true;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
} else {
    header("Location: login.php");
    exit();
}
