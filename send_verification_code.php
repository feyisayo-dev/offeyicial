<?php
session_start();
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["emailtosendto"];

    // Check if the user exists in the database
    $sql = "SELECT UserId, First_Name, Surname FROM User_Profile WHERE email = '$email'";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        if(sqlsrv_has_rows($result)) {
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            $UserId = $row['UserId'];
            $firstName = $row['First_Name'];
            $surname = $row['Surname'];

            // Assume $userId, $firstName, and $surname contain the user's information
            $verificationCode = $UserId . date("Y") . $firstName;

            $_SESSION["verification_code"] = $verificationCode;

            echo "success";
        } else {
            // User does not exist
            echo "User does not exist.";
        }
    } else {
        // Error in SQL query
        echo "Error in SQL query.";
    }
}
?>