<?php
session_start();
// Check if user is logged in
include('db.php');
$UserId = $_SESSION['UserId'];

?>
<script>
    // Get the current URL
    // var url = new URL(window.location.href);

    // Get the value of the 'roomId' parameter from the URL
    // var roomId = url.searchParams.get('roomId');

    // Use the roomId value as needed
    // console.log(roomId);
    var UserIdx = "<?php echo $_GET['UserIdx']; ?>"

    // Extract the UserIdx from the roomId
    // var regex = /OFF.*?OFF([A-Za-z0-9]+)/;
    // var match = roomId.match(regex);
    // var UserIdxno = match ? match[1] : "";
    // var UserIdx = "OFF" + UserIdxno;

    console.log(UserIdx); // Output: OFF0006 // Output: UserIdx
    // Make an AJAX request to pass the UserIdx to a PHP script
    var formData = new FormData();
    formData.append("UserIdx", UserIdx);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_recipient.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Request completed successfully
            console.log("Recipient ID updated successfully");

            // Retrieve the recipientId from the response
            var recipientId = xhr.responseText;
            // Use the recipientId variable as needed
            console.log(recipientId);
            // Pass the recipientId to your PHP code by creating a hidden input field
            var hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "recipientId";
            hiddenInput.class = "hiddenrec";
            hiddenInput.id = "hiddenrecid";
            hiddenInput.value = recipientId;
            document.getElementById("callmain").appendChild(hiddenInput);

            // Make an AJAX request to retrieve the user profile data
            var profileRequest = new XMLHttpRequest();
            profileRequest.open("GET", "get_user_profile.php?UserId=" + recipientId, true);
            profileRequest.onreadystatechange = function() {
                if (profileRequest.readyState === 4 && profileRequest.status === 200) {
                    // Request completed successfully
                    console.log("User profile retrieved successfully");

                    // Parse the JSON response
                    var profileData = JSON.parse(profileRequest.responseText);

                    // Update the name and passport elements in the HTML
                    document.getElementById("recipientName").textContent = profileData.firstName + " " + profileData.surname;
                    document.getElementById("recipientPassport").setAttribute("xlink:href", profileData.passport);
                }
            };
            profileRequest.send();
            // Update the HTML elements with recipientId
            document.getElementById("videos").querySelector(".remote").id = recipientId;
            document.getElementById("hang").querySelector(".hang").href = "chat.php?UserIdx=" + recipientId;
        }
    };

    // Send the FormData object as data in the AJAX request
    xhr.send(formData);
</script>

<!DOCTYPE html>
<html>

<head>
    <title>Call</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript -->
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <!-- <script src="js/owl.carousel.min.js"></script> -->

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #videos {
            display: grid;
            grid-template-columns: 1fr;
            height: 100vh;
            overflow: hidden;
        }

        .video-player {
            background-color: black;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* .video-player.remote {
            display: none;
        } */

        .smallFrame {
            position: fixed;
            top: 20px;
            left: 20px;
            height: 170px;
            width: 300px;
            border-radius: 5px;
            border: 2px solid #b366f9;
            -webkit-box-shadow: 3px 3px 15px -1px rgba(0, 0, 0, 0.77);
            box-shadow: 3px 3px 15px -1px rgba(0, 0, 0, 0.77);
            z-index: 999;
        }


        #controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1em;
        }


        .control-container {
            background-color: rgb(179, 102, 249, .9);
            padding: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .control-container img {
            height: 30px;
            width: 30px;
        }

        #leave-btn {
            background-color: rgb(255, 80, 80, 1);
        }

        @media screen and (max-width:600px) {
            .smallFrame {
                height: 80px;
                width: 120px;
            }

            .control-container img {
                height: 20px;
                width: 20px;
            }
        }

        .over {
            position: fixed;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 999;
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 3px 3px 15px -1px rgba(0, 0, 0, 0.77);
        }

        #recipientPassport {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
            border: 5px solid white;
        }

        #recipientName {
            font-size: 1.2rem;
            font-weight: bold;
        }

        svg {
            font-family: "Miltonian";
            width: 100%;
            height: 100%;
        }

        svg text {
            animation: stroke 10s infinite alternate;
            stroke-width: 2;
            stroke: #1DA035;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 2rem;
            text-align: center;
            text-transform: capitalize;
        }

        @keyframes stroke {
            0% {
                fill: rgba(35, 204, 67, 0);
                stroke: rgba(29, 160, 53, 1);
                stroke-dashoffset: 25%;
                stroke-dasharray: 0 50%;
                stroke-width: 2;
            }

            70% {
                fill: rgba(35, 204, 67, 0);
                stroke: rgba(29, 160, 53, 1);
            }

            80% {
                fill: rgba(35, 204, 67, 0);
                stroke: rgba(29, 160, 53, 1);
                stroke-width: 3;
            }

            100% {
                fill: rgba(35, 204, 67, 1);
                stroke: rgba(29, 160, 53, 0);
                stroke-dashoffset: -25%;
                stroke-dasharray: 50% 0;
                stroke-width: 0;
            }
        }

        .wrapper {
            background-color: transparent;
            width: 100%;
        }

        ;

        .status {
            font-size: 1rem;
            color: gray;
        }


        #controls {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 1em;
            z-index: 999;
        }

        .control-container {
            background-color: rgb(179, 102, 249, 0.9);
            padding: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .control-container img {
            height: 30px;
            width: 30px;
        }

        #leave-btn {
            background-color: rgb(255, 80, 80, 1);
        }

        @media screen and (max-width: 600px) {
            .over {
                top: 10px;
                left: 10px;
                padding: 5px;
            }

            .avatar {
                width: 30px;
                height: 30px;
            }

            .name {
                font-size: 1rem;
            }

            .status {
                font-size: 0.8rem;
            }

            #controls {
                bottom: 10px;
            }

            .control-container img {
                height: 20px;
                width: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="callmain" id="callmain">
        <div class="info-container">
            <?php
            // Connect to the database
            include 'db.php';

            $UserId = $_SESSION['UserId'];

            // Get the surname and first name of the user with the UserId from the database
            $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
            $stmt = sqlsrv_prepare($conn, $sql);
            if (sqlsrv_execute($stmt)) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $Surname = $row['Surname'];
                    $First_Name = $row['First_Name'];
                }
            }

            ?>
            <div id="videos">
                <video class="video-player local" id="<?php echo $UserId; ?>" autoplay playsinline></video>
                <video class="video-player remote" autoplay playsinline></video>
            </div>

            <div class="over">
                <image id="recipientPassport" height="50" width="50" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 80">
                    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle">
                        <a id="recipientName" x="50%" dy="1.5em"></a>
                    </text>
                </svg>
                <div id="status" class="status">Calling...</div>
            </div>


            <div id="controls">

                <div class="control-container" id="video_call_button">
                    <img src="icons/camera.png" />
                </div>

                <div class="control-container" id="audio_call_button">
                    <img src="icons/mic.png" />
                </div>

                <div id="hang">
                    <div class="control-container hang" href="" id="hangup_button">
                        <img src="icons/phone.png" />
                    </div>
                </div>

            </div>

            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/slim.min.js"></script>
            <script src="js/dexie.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/adapter-latest.js"></script>
            <script src="js/bootstrap.bundle.min.js"></script>
            <script>
                var userB = document.getElementById("videos").querySelector(".remote").id;
                console.log(userB);
                var UserId = '<?php echo $_SESSION["UserId"]; ?>';
                console.log(UserId);
            </script>

            <!-- Remove the individual script tags -->
            <script src="js/call.js"></script>
            <script>
                var userId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

                // Check if the UserId exists
                if (!userId) {
                    // UserId not found, redirect to login page
                    window.location.href = "login.php";
                }
            </script>
</body>

</html>