<?php
session_start();
include("db.php");

if (isset($_POST['phonenumbertosendto'])) {
    $phonenumbertosendto = $_POST["phonenumbertosendto"];

    // Check if the user exists in the database
    $sql = "SELECT UserId, First_Name, Surname FROM User_Profile WHERE phone = '$phonenumbertosendto'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        if (sqlsrv_has_rows($result)) {
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $UserId = $row['UserId'];
            $firstName = $row['First_Name'];
            $surname = $row['Surname'];

            // Assume $userId, $firstName, and $surname contain the user's information
            $verificationCode = $UserId . date("Y") . $firstName;

            $_SESSION["verification_code"] = $verificationCode;
        } else {
            // User does not exist
            echo "User does not exist.";
        }
    } else {
        // Error in SQL query
        echo "Error in SQL query.";
    }
    require_once('vendor/autoload.php'); // if you use Composer

    $token = "q2hqha2y2cbfiiia"; // Ultramsg.com token
    $instance_id = "instance46912"; // Ultramsg.com instance id
    $client = new UltraMsg\WhatsAppApi($token, $instance_id);

    $to = $phonenumbertosendto; // e.g. "14151234567" for a US number
    $body = "Please do not share this information with anyone <br> Your verification code is: " . $verificationCode;

    $api = $client->sendChatMessage($to, $body);
    if ($api['sent']) {
        // message sent successfully
        echo "successyes";
    } else {
        // error sending message
        echo "Error sending verification code via WhatsApp: " . $api['message'];
    }
}
