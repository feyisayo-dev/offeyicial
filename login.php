<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $UserId = $_SESSION["UserId"];
    header("Location: user_profile.php?UserId=" . $UserId);
    exit();
}else{
    echo "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="./styletologin.css">

</head>

<body>
    <section class="container">
        <div class="login-container">
            <div class="circle circle-one"></div>
            <div class="form-container">
                <!-- <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" /> -->
                <h1 class="opacity">LOGIN</h1>
                <div class="form-to-submit">
                    <input id="email" type="text" placeholder="EMAIL" />
                    <input id="psw" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                        required placeholder="PASSWORD" />
                    <button class="Login opacity">SUBMIT</button>
                </div>
                <div class="register-forget opacity">
                    <button class="btn btn-primary" class="register" type="button"
                        onclick="location.href='reg.php'">REGISTER</button>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#forgotpassword">FORGOT PASSWORD</button>
                </div>
            </div>
            <div class="circle circle-two"></div>
        </div>
        <div class="theme-btn-container"></div>
    </section>

</body>
<div class="modal fade" id="forgotpassword" tabindex="-1" aria-labelledby="forgotpasswordLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="forgotpasswordLabel"></h5> -->
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="icons/close.png">
                </button>
            </div>
            <div class="modal-body">
                <div class="forgot-password-form">
                    <h2>Forgot Password</h2>
                    <p>Please enter your Phone number below to receive a verification code to reset your
                        password.</p>
                    <div id="forgot-password-form">
                        <input type="phone" id="phonenumbertosendto" name="phone" placeholder="PHONE NUMBER" required>
                        <button type="button" class="verification" onclick="sendVerificationCode()">Send
                            Code</button>
                    </div>
                </div>

                <div class="verify-code-form" style="display:none;">
                    <h2>Verify Code</h2>
                    <p>Please enter the verification code you received in your phone.</p>
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

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="./scripttologin.js"></script>
<script>
    var userPhone = "";

    function sendVerificationCode() {
        const phonenumbertosendto = $("#phonenumbertosendto").val();
        userPhone = phonenumbertosendto;
        $.ajax({
            type: "POST",
            url: "send_verification_code.php",
            data: {
                phonenumbertosendto: phonenumbertosendto
            },
            success: function (response) {
                console.log(response);
                if (response === "successyes") {
                    $(".forgot-password-form").hide();
                    $(".verify-code-form").show();
                } else {
                    alert(response);
                }
            }
        });
    }

    function verifyCode() {
        const verificationCode = $("#verification-code").val();

        $.ajax({
            type: "POST",
            url: "verify_code.php",
            data: {
                verificationCode: verificationCode
            },
            success: function (response) {
                if (response === "success") {
                    $(".verify-code-form").hide();
                    $(".reset-password-form").show();
                } else {
                    alert("Incorrect verification code.");
                }
            }
        });
    }

    function resetPassword() {
        const newPassword = document.getElementById("new-password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        const phonenumbertosendto = userPhone;

        if (newPassword !== confirmPassword) {
            alert("New password and confirm password do not match.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "updatepass.php",
            data: {
                editpass: 1,
                phonenumbertosendto: phonenumbertosendto,
                newPassword: newPassword,
            },
            success: function (response) {
                if (response === "success") {
                    window.location.href = "login.php";
                } else {
                    alert(response);
                }
            }
        });
    }

    $('.Login').click(function () {
        let email = $('#email').val();
        let psw = $('#psw').val();

        if (email != "" && psw != "") {
            $.ajax({
                url: "LoginSubmit.php",
                type: "POST",
                async: true,
                data: {
                    "Login": 1,
                    "email": $.trim(email),
                    "psw": $.trim(psw)
                },
                success: function (data) {
                    console.log(data);
                    if (data !== 'failed') {
                        var UserId = data;
                        if (window.location.pathname !== '/offeyicialchatroom/user_profile.php') {
                            window.location.href = "user_profile.php?UserId=" + UserId;
                        }
                    } else {
                        toastr.error("Invalid login credentials");
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toastr.error("Oops! Something went wrong. Please try again later.");
                }
            });

        } else {
            alert("Please fill in all fields");
        }
    });

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
    var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";
    if (UserId) {
        window.location.href = "user_profile.php?UserId=" + UserId;
    }
</script>

</html>