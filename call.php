<?php
session_start();
// Check if user is logged in
include('db.php');
$UserId = $_SESSION['UserId'];
?>
<?php
include('db.php');

// Get the UserId of the user you are talking to
$recipientId = $_GET['UserIdx'];

// Get the name of the user you are talking to
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
$stmt = sqlsrv_prepare($conn, $sql);
if (sqlsrv_execute($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $recipientSurname = $row['Surname'];
        $recipientFirstName = $row['First_Name'];
        $Passport = $row['Passport'];
        if (empty($Passport)) {
            $recipientPassport = "UserPassport/DefaultImage.png";
        } else {
            $recipientPassport = "UserPassport/" . $Passport;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Video Call</title>
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
        /* Call modal styles */
        .callmain {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            margin: 10px;
        }

        .callbody {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
        }

        #video_call_button,
        #audio_call_button {
            background-color: white;
            color: black;
            border-radius: 10px;
            border: none;
        }

        #video_call_button:hover,
        #audio_call_button:hover {
            color: white;
            background-color: #333;
            transform: scale(1.05);
        }

        #local_video,
        #remote_video {
            width: 100%;
            height: 200px;
            background-color: #333;
            margin: 10px 0;
            border-radius: 5px;
        }

        .dropdown-menu {
            width: 100%;
            max-width: 250px;
        }

        .dropdown-menu a {
            font-size: 16px;
        }

        #call_button,
        #hangup_button {
            margin: 10px;
            font-size: 24px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            padding: 10px;
            transition: all 0.3s ease;
        }

        #call_button {
            color: green;
        }

        #hangup_button {
            color: red;
        }

        #call_button:hover,
        #hangup_button:hover {
            transform: scale(1.05);
        }

        #call_button:hover,
        #hangup_button:hover {
            cursor: pointer;
            opacity: 0.8;
        }

        @media (max-width: 576px) {
            .callbody {
                max-width: 100%;
            }
        }

        .info-container .status {
            font-size: 18px;
            color: #777;
        }

        /* Name and avatar container */
        .name-avatar-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 10px;
        }

        .avatar-container {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .status {
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="callmain">
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

            // Get the UserId of the user you are talking to
            $recipientId = $_GET['UserIdx'];

            // Get the name of the user you are talking to
            $sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
            $stmt = sqlsrv_prepare($conn, $sql);
            if (sqlsrv_execute($stmt)) {
                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $recipientSurname = $row['Surname'];
                    $recipientFirstName = $row['First_Name'];
                    $Passport = $row['Passport'];
                    if (empty($Passport)) {
                        $recipientPassport = "UserPassport/DefaultImage.png";
                    } else {
                        $recipientPassport = "UserPassport/" . $Passport;
                    }
                }
            }
            ?>
            <div class="name-avatar-container">
                <div class="avatar-container">
                    <img class="avatar" src="<?php echo $recipientPassport; ?>" alt="">
                </div>
                <div class="name-container">
                    <div class="name"><?php echo $recipientFirstName . ' ' . $recipientSurname; ?></div>
                    <div class="status">Calling...</div>
                </div>
            </div>
            <div class="callbody">
                <div class="row">
                    <div class="col">
                        <button id="video_call_button" class="btn btn-primary"><i class="bi bi-camera-video"></i> Video Call</button>
                    </div>
                    <div class="col">
                        <button id="audio_call_button" class="btn btn-secondary"><i class="bi bi-mic"></i> Audio Call</button>
                    </div>
                </div>
                <hr>
                <div id="local_video"></div>
                <div id="remote_video"></div>
                <div class="row">
                    <div class="btn-group" role="group" aria-label="Call buttons">
                        <button id="call_button" class="btn btn-success"><i class="bi bi-telephone"></i> Call</button>
                        <button id="hangup_button" class="btn btn-danger"><i class="bi bi-telephone-x"></i> Hang Up</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p id="call_timer">00:00:00</p>
                    </div>
                </div>
            </div>
        </div>


        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slim.min.js"></script>
        <script src="js/dexie.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/adapter-latest.js"></script>
        <script src="node_modules/simplewebrtc/simplewebrtc.bundle.js"></script>
        <!-- <script src="node_modules/simplewebrtc/simplewebrtc.js"></script> -->

        <script>
            // Initialize the SimpleWebRTC object
            var webrtc = new SimpleWebRTC({
                // the id/element dom element that will hold "our" video
                localVideoEl: 'local_video',
                // the id/element dom element that will hold remote videos
                remoteVideosEl: 'remote_video',
                // immediately ask for camera access
                autoRequestMedia: true,
                // URL of the signaling server
                url: 'http://localhost:8080/offeyicialchatroom',
                // enable/disable peer-to-peer mode
                enableDataChannels: true,
                // additional ICE servers can be added here
                // iceServers: [{url:'stun:stun.l.google.com:19302'}],
                // Set the nick name for the user
                nick: '<?php echo $First_Name . ' ' . $Surname; ?>'
            });





            // Start the local video
            webrtc.startLocalVideo();

            // When the "video_call_button" is clicked
            $('#video_call_button').click(function() {
                // Show the local and remote video containers
                $('#local_video').show();
                $('#remote_video').show();

                // Set the media constraints for audio and video
                webrtc.config.media = {
                    audio: true,
                    video: true
                };

                // Join the video call
                webrtc.joinRoom('<?php echo $recipientId; ?>');

                // Set the status text
                $('.status').text('In Video Call');
            });

            // When the "audio_call_button" is clicked
            $('#audio_call_button').click(function() {
                // Hide the local and remote video containers
                $('#local_video').hide();
                $('#remote_video').hide();

                // Set the media constraints for audio only
                webrtc.config.media = {
                    audio: true,
                    video: false
                };

                // Join the audio call
                webrtc.joinRoom('<?php echo $recipientId; ?>');

                // Set the status text
                $('.status').text('In Audio Call');
            });

            // When the "call_button" is clicked
            $('#call_button').click(function() {
                // Set the status text
                $('.status').text('Calling...');

                // Call the recipient
                webrtc.call('<?php echo $recipientId; ?>');
            });

            // When the "hangup_button" is clicked
            $('#hangup_button').click(function() {
                // End the call
                webrtc.leaveRoom();

                // Set the status text
                $('.status').text('Call Ended');
            });
        </script>


</body>

</html>