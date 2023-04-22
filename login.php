<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $UserId = $_SESSION["UserId"];
    header("Location: user_profile.php?UserId=" . $UserId);
    exit();
}
?>


<html>

<head>
    <meta name="description" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="profile.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <title>Login</title>
    <meta charset=utf-8>
    <style>
        @media (max-width: 500px) {
            body {
                font-size: 12px;
            }
        }

        body {
            font-family: montserrat;
            font-size: 14px;
            background-image: url(img/bg.jpeg);
            background-size: cover;
        }

        .form_wrapper {
            background: transparent;
            width: 100%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .form_container {
            /* border: 2px solid blue; */
            padding: 1cm;
            /* background-image: url(img/connecting_users.jpg); */
            background: transparent;
        }

        .title_container {
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-group label {
            width: 100px;
            font-weight: bold;
            margin-right: 10px;
            color: white;
        }

        .form-group input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-shadow: 2px 2px 2px #0066ff;
        }

        .form-group input[type="checkbox"] {
            margin-left: 10px;
            border: 2px
        }

        .form-inline {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
        }

        .form-inline label {
            margin: 0 5px 0 0;
        }

        .form-inline input,
        .form-inline select {
            flex: 1;
            margin-bottom: 5px;
        }

        .form-inline .form-group {
            display: flex;
            align-items: center;
        }

        .form-inline .form-control {
            width: 100%;
        }

        .form_wrapper {
            width: 100%;
            margin: auto;
            /* border-top: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-bottom: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-left: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-right: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-style: groove;
            box-sizing: border-box; */
        }

        .login {
            background-color: #198754;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: groove #198754;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            cursor: not-allowed;
            width: 100px;

        }

        .form_wrapper input[type=login]:hover {
            background: #01fa0e;
        }

        .form_wrapper input[type=login]:focus {
            background: #01fa0e;
        }

        .form-group input[type="password"] {
            position: relative;
        }

        .form-group input[type="checkbox"] {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .show-password-btn {
            font-size: 12px;
            padding: 3px 6px;
        }

        button.container {
            font-size: 0.8em;
            /* make the font smaller */
            padding: 2px;
            /* reduce the size of the button */
            width: 50px;
        }

        h2 {
            color: white;
            /* sets text color to red */
            font-size: 50px;
            /* sets font size to 20px */
            text-align: center;
            /* centers the text */
            background: transparent;
        }

        /* Position the icon at the top left corner of the page */

        .icon {
            float: left;
            margin-top: 10px;
            margin-left: 10px;
            width: 50px;
            length: 50px;
        }

        .form_wrapper input[type=checkbox],
        .form_wrapper input[type=radio] {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        .form_container .row .col_half.last {
            border-left: 1px solid #cccccc;
        }

        .checkbox_option label {
            margin-right: 1em;
            height: 40px;
            padding: 3px;
            position: relative;
        }

        .checkbox_option label:before {
            content: "";
            display: inline-block;
            width: 0.5em;
            height: 0.5em;
            margin-right: 0.5em;
            vertical-align: -2px;
            border: 2px solid #cccccc;
            padding: 0.12em;
            background-color: transparent;
            background-clip: content-box;
            transition: all 0.2s ease;
        }

        .checkbox_option label:after {
            border-right: 2px solid #000000;
            border-top: 2px solid #000000;
            content: "";
            height: 20px;
            left: 2px;
            position: absolute;
            top: 7px;
            transform: scaleX(-1) rotate(135deg);
            transform-origin: left top;
            width: 7px;
            display: none;
        }

        .checkbox_option input:hover+label:before {
            border-color: #000000;
        }

        .checkbox_option input:checked+label:before {
            border-color: #000000;
        }

        .checkbox_option input:checked+label:after {
            -moz-animation: check 0.8s ease 0s running;
            -webkit-animation: check 0.8s ease 0s running;
            animation: check 0.8s ease 0s running;
            display: block;
            width: 7px;
            height: 20px;
            border-color: #000000;
        }

        .radio_option label {
            margin-right: 1em;
        }

        .radio_option label:before {
            content: "";
            display: inline-block;
            width: 0.5em;
            height: 0.5em;
            margin-right: 0.5em;
            border-radius: 100%;
            vertical-align: -3px;
            border: 2px solid #cccccc;
            padding: 0.15em;
            background-color: transparent;
            background-clip: content-box;
            transition: all 0.2s ease;
        }

        .radio_option input:hover+label:before {
            border-color: #000000;
        }

        .radio_option input:checked+label:before {
            background-color: #000000;
            border-color: #000000;
        }

        .select_option {
            position: relative;
            width: 100%;
        }

        .select_option select {
            display: inline-block;
            width: 100%;
            height: 35px;
            padding: 0px 15px;
            cursor: pointer;
            color: #7b7b7b;
            border: 1px solid #cccccc;
            border-radius: 0;
            background: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: all 0.2s ease;
        }

        .select_option select::-ms-expand {
            display: none;
        }

        .select_option select:hover,
        .select_option select:focus {
            color: #000000;
            background: #fafafa;
            border-color: #000000;
            outline: none;
        }

        .select_arrow {
            position: absolute;
            top: calc(50% - 4px);
            right: 15px;
            width: 0;
            height: 0;
            pointer-events: none;
            border-width: 8px 5px 0 5px;
            border-style: solid;
            border-color: #7b7b7b transparent transparent transparent;
        }

        .select_option select:hover+.select_arrow,
        .select_option select:focus+.select_arrow {
            border-top-color: #000000;
        }

        .credit {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 15px;
            color: #f5ba1a;
        }

        .credit a {
            color: #e1a70a;
        }

        @-webkit-keyframes check {
            0% {
                height: 0;
                width: 0;
            }

            25% {
                height: 0;
                width: 7px;
            }

            50% {
                height: 20px;
                width: 7px;
            }
        }

        @keyframes check {
            0% {
                height: 0;
                width: 0;
            }

            25% {
                height: 0;
                width: 7px;
            }

            50% {
                height: 20px;
                width: 7px;
            }
        }

        @-webkit-keyframes expand {
            0% {
                -webkit-transform: scale3d(1, 0, 1);
                opacity: 0;
            }

            25% {
                -webkit-transform: scale3d(1, 1.2, 1);
            }

            50% {
                -webkit-transform: scale3d(1, 0.85, 1);
            }

            75% {
                -webkit-transform: scale3d(1, 1.05, 1);
            }

            100% {
                -webkit-transform: scale3d(1, 1, 1);
                opacity: 1;
            }
        }

        @keyframes expand {
            0% {
                -webkit-transform: scale3d(1, 0, 1);
                transform: scale3d(1, 0, 1);
                opacity: 0;
            }

            25% {
                -webkit-transform: scale3d(1, 1.2, 1);
                transform: scale3d(1, 1.2, 1);
            }

            50% {
                -webkit-transform: scale3d(1, 0.85, 1);
                transform: scale3d(1, 0.85, 1);
            }

            75% {
                -webkit-transform: scale3d(1, 1.05, 1);
                transform: scale3d(1, 1.05, 1);
            }

            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
                opacity: 1;
            }
        }

        @-webkit-keyframes bounce {
            0% {
                -webkit-transform: translate3d(0, -25px, 0);
                opacity: 0;
            }

            25% {
                -webkit-transform: translate3d(0, 10px, 0);
            }

            50% {
                -webkit-transform: translate3d(0, -6px, 0);
            }

            75% {
                -webkit-transform: translate3d(0, 2px, 0);
            }

            100% {
                -webkit-transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        @keyframes bounce {
            0% {
                -webkit-transform: translate3d(0, -25px, 0);
                transform: translate3d(0, -25px, 0);
                opacity: 0;
            }

            25% {
                -webkit-transform: translate3d(0, 10px, 0);
                transform: translate3d(0, 10px, 0);
            }

            50% {
                -webkit-transform: translate3d(0, -6px, 0);
                transform: translate3d(0, -6px, 0);
            }

            75% {
                -webkit-transform: translate3d(0, 2px, 0);
                transform: translate3d(0, 2px, 0);
            }

            100% {
                -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        @media (max-width: 600px) {
            .form_wrapper .col_half {
                width: 100%;
                float: none;
            }

            .bottom_row .col_half {
                width: 50%;
                float: left;
            }

            .form_container .row .col_half.last {
                border-left: none;
            }

            .remember_me {
                padding-bottom: 20px;
            }
        }

        /*  */

        .input_field input {
            width: 100%;
            padding: 15px;
            font-size: 17px;
            padding-right: 50px;
            border: 1.4px solid #e6d9d9;
        }

        .input_field .showPass {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            font-size: 15px;
            margin: 0;
            background: transparent;
            padding: 0;
            border: 0;
            line-height: 1;
            margin-right: 10px;
            cursor: pointer;
            color: dodgerblue;
        }

        .input_field .showPass:focus {
            outline: none;
        }

        /*  */

        a {
            text-decoration: none;
            color: dodgerblue;
        }

        .navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }

        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }

        .navbar-brand img {
            display: inline-block;
            height: 30px;
            /* adjust height as needed */
            margin-right: 10px;
            /* add some space between image and text */
        }



        @media (max-width: 768px) {
            .navbar-collapse {
                position: fixed;
                top: 56px;
                bottom: 0;
                left: 100%;
                z-index: 1;
                width: 100%;
                padding-right: 1rem;
                padding-left: 1rem;
                overflow-y: auto;
                visibility: hidden;
                background-color: #fff;
                transition: visibility 0s linear 0.33s, left 0.33s ease-in-out;
            }

            .navbar-collapse.show {
                left: 0;
                visibility: visible;
                transition-delay: 0s;
            }

            .navbar-toggler {
                border-color: transparent;
            }

            .navbar-toggler:focus {
                outline: none;
            }

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }
        }

        @media (max-width: 767px) {

            /* Set the height of the collapsed navbar to 100vh */
            .navbar-collapse {
                height: 100vh;
            }

            /* Set the position of the collapsed navbar to fixed */
            .navbar-collapse.show {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                overflow-y: scroll;
            }

            /* Set the padding of the navbar items */
            .navbar-nav {
                padding-top: 30px;
                padding-bottom: 30px;
            }

            /* Set the font size and padding of the navbar items */
            .navbar-nav .nav-link {
                font-size: 18px;
                padding: 10px;
            }

            /* Set the color of the navbar items */
            .navbar-nav .nav-link.custom-link {
                color: #fff;
                background-color: #28a745;
                border-radius: 5px;
                padding: 8px 15px;
            }

            /* Set the position of the search bar */
            .search-container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            /* Set the width of the search bar */
            .searchtext {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: none;
            }
        }

        button {
            color: white;
            background-color: #198754;
            height: 2.5em;
            border: groove;
            border-radius: 10px;
        }

        .reg {
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 767px) {
            .reg {
                flex-direction: column;
                justify-content: center;
            }
        }

        .reg button {
            color: green;
            box-shadow: white;
            background-color: transparent;
            width: 80px;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .reg button:hover {
            transform: scale(1.05);
        }

        .register:hover {
            background-color: white;
        }

        .btn:hover {
            background-color: red;
            border-radius: 10px;
        }

        /* form {
  display: flex;
  align-items: center;
} */

        .verification {
            height: 40px;
            padding: 0 10px;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }

        input[type="email"] {
            flex: 1;
            /* border: black; */
            height: 40px;
            padding: 0 10px;
            border-radius: 5px;
            /* border: none; */
            margin-right: 10px;
        }

        .verification {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .verification:hover {
            background-color: #0069d9;
        }

        .forgot-password-form h2 {
            color: black;
            text-transform: uppercase;
            font-size: 30px;
        }

        .verify-code-form,
        .reset-password-form {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .verify-code-form h2,
        .reset-password-form h2 {
            margin-top: 0;
        }

        .verify-code-form p,
        .reset-password-form p {
            margin-bottom: 10px;
        }

        .verify-code-form label,
        .reset-password-form label {
            display: block;
            margin-bottom: 5px;
        }

        .verify-code-form input[type="text"],
        .reset-password-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .verify-code-form button,
        .reset-password-form button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .verify-code-form button:hover,
        .reset-password-form button[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php"><span class="text-success">Offeyicial</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="donate.php">Donate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reg.php"><i class="bi bi-person-plus"></i>Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="form_wrapper">

        <div class="form_container">
            <div class="title_container">
                <h2> Login Form</h2>
            </div>
            <center>
                <div id="message" style='color:red;'></div>
            </center>
            <div class="row clearfix">
                <div class="form-group"><span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="row clearfix">

                    <div class="form-group">
                        <label for="psw">Password:</label>
                        <input type="password" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        <button class="container" type="button" id="show-password-button" onclick="showPassword()"> Show

                    </div>
                </div>

            </div>
            <div>
                <center>
                    <input type="Login" name="Login" class="Login" value="Login" />
                </center>



            </div>



            <div class="input_field checkbox_option">
                <input type="checkbox" id="cb2">
                <label for="cb2">remember me</label>
            </div>
            <div class="reg">
                <button class="register" onclick="location.href='reg.php'">Register</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#forgotpassword">
                    Forgot Password
                </button>
            </div>

        </div>
    </div>
    <div class="modal fade" id="forgotpassword" tabindex="-1" aria-labelledby="forgotpasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotpasswordLabel">Forget password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="forgot-password-form">
                        <h2>Forgot Password</h2>
                        <p>Please enter your email address below to receive a verification code to reset your password.</p>
                        <div id="forgot-password-form">
                            <label for="email">Email:</label>
                            <input type="email" id="emailtosendto" name="email" required>
                            <button type="button" class="verification" onclick="sendVerificationCode()">Send Code</button>
                        </div>
                    </div>

                    <div class="verify-code-form" style="display:none;">
                        <h2>Verify Code</h2>
                        <p>Please enter the verification code you received in your email.</p>
                        <div id="verify-code-form">
                            <label for="verification-code">Verification Code:</label>
                            <input type="text" id="verification-code" name="verification-code" required>
                            <button type="button" class="verification" onclick="verifyCode()">Verify</button>
                        </div>
                    </div>


                    <div class="reset-password-form" style="display: none;">
                        <h2>Reset Password</h2>
                        <p>Please enter your new password below:</p>
                        <div>
                            <label for="new-password">New Password:</label>
                            <input type="password" id="new-password" name="new-password" required>
                            <label for="confirm-password">Confirm Password:</label>
                            <input type="password" id="confirm-password" name="confirm-password" required>
                            <button type="submit" onclick="resetPassword()">Reset Password</button>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>



<script>
    var userEmail = "";

    function sendVerificationCode() {
        // Get the user's email address
        const emailtosendto = $("#emailtosendto").val();

        // Store the email in a variable
        userEmail = emailtosendto;

        // Send a verification code to the user's email address using AJAX
        $.ajax({
            type: "POST",
            url: "send_verification_code.php",
            data: {
                emailtosendto: emailtosendto
            },
            success: function(response) {
                if (response === "success") {
                    // Show the verification code form
                    alert("Your verification is your UserId, current year, firstname no spaces in between")
                    $(".forgot-password-form").hide();
                    $(".verify-code-form").show();
                } else {
                    alert(response);
                }
            }
        });
    }

    function verifyCode() {
        // Get the verification code entered by the user
        const verificationCode = $("#verification-code").val();

        // Verify the verification code using AJAX
        $.ajax({
            type: "POST",
            url: "verify_code.php",
            data: {
                verificationCode: verificationCode
            },
            success: function(response) {
                if (response === "success") {
                    // Redirect the user to the password reset page
                    $(".verify-code-form").hide();
                    $(".reset-password-form").show();
                } else {
                    alert("Incorrect verification code.");
                }
            }
        });
    }

    function resetPassword() {
        // Get the new password entered by the user
        const newPassword = document.getElementById("new-password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        // Use the stored email variable
        const emailtosendto = userEmail;

        // Check if the new password and confirm password match
        if (newPassword !== confirmPassword) {
            alert("New password and confirm password do not match.");
            return;
        }

        // Update the user's password (using your preferred method)
        // Verify the verification code using AJAX
        $.ajax({
            type: "POST",
            url: "updatepass.php",
            data: {
                editpass: 1,
                emailtosendto: emailtosendto,
                newPassword: newPassword,
            },
            success: function(response) {
                if (response === "success") {
                    // Redirect the user to the login page
                    window.location.href = "login.php";
                } else {
                    alert(response);
                }
            }
        });
    }
</script>


<script>
    $('.Login').click(function() {
        let email = $('#email').val();
        let psw = $('#psw').val();

        if (email != "" && psw != "") {
            $.ajax({
                url: "LoginSubmit.php",
                type: "POST",
                async: false,
                data: {
                    "Login": 1,
                    "email": email,
                    "psw": psw
                },
                success: function(data) {
                    var jsonData = JSON.parse(data);
                    if (jsonData.status == "success") {
                        var UserId = jsonData.UserId;
                        // check if the user is already logged in
                        if (window.location.pathname != '/offeyicialchatroom/user_profile.php') {
                            window.location.href = "user_profile.php?UserId=" + UserId;
                        }
                    } else {
                        alert("Invalid login credentials");
                    }
                }
            });
        } else {
            alert("Please fill in all fields");
        }
    });
</script>


<script>
    function showPassword() {
        var passwordInput = document.getElementById("psw");
        var showPasswordButton = document.getElementById("show-password-button");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = "Hide";
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = "Show";
        }
    }
</script>


</html>