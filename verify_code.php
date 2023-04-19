<?php
session_start();

if(isset($_POST['verificationCode'])) {
    $code = $_POST['verificationCode'];

    if($code === $_SESSION["verification_code"]) {
        // Verification successful, do something (e.g. allow password reset)
        echo "success";
    } else {
        // Verification failed, show error message
        echo "Verification failed, please try again!";
    }
}

?>