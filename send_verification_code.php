<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $sql = "SELECT UserId FROM User_Profile WHERE email = '$email'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        $user_id = $row['UserId'];

        $timestamp = time();
        $rand_num = rand(1000, 9999); // Generate a random 4-digit number
        $verification_code = $user_id . $timestamp . $rand_num;
    }

    // Send the verification code to the user's email address
    $to = $email;
    $subject = "Verification Code";
    $message = "Your verification code is: " . $verificationCode;
    $headers = "From: oluwafeyisayofummi@gmail.com" . "\r\n" .
        "Reply-To:" . $to . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        // Store the verification code in the session for later use
        $_SESSION["verification_code"] = $verificationCode;
        echo "success";
    } else {
        echo "failure: " . error_get_last()["message"];
    }
}
