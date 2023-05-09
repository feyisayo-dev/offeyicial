<?php
// session_start();
include('db.php');
// $UserId = $_SESSION['UserId'];
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
    </style>
</head>

<body>
    <div class="callmain">
        <div class="callbody">
            <div id="local_video"></div>
            <div id="remote_video"></div>
            <div class="row">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="callTypeDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select call type
                    </button>
                    <div class="dropdown-menu" aria-labelledby="callTypeDropdown">
                        <a class="dropdown-item" href="#" id="videoCallOption">Video Call</a>
                        <a class="dropdown-item" href="#" id="audioCallOption">Audio Call</a>
                    </div>
                </div>
                <div class="row">
                    <div class="btn-group" role="group" aria-label="Call buttons">
                        <button id="call_button" class="btn"><i class="bi bi-telephone"></i></button>
                        <button id="hangup_button" class="btn"><i class="bi bi-telephone"></i></button>
                    </div>
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
    <!-- <script src="js/index.umd.js"></script> -->
    <!-- <script>
        $(document).ready(function() {
            $('#callTypeDropdown').click(function() {
                alert('Yes, button is clickable');
            });
        });
    </script> -->


    <script>
        // initialize variables
        var localStream, remoteStream, pc, isCaller, selectedCallType;

        // get dropdown options and call button
        var videoCallOption = document.querySelector('#videoCallOption');
        var audioCallOption = document.querySelector('#audioCallOption');
        var callButton = document.querySelector('#call_button');

        // add event listeners to dropdown options
        videoCallOption.addEventListener('click', function() {
            selectedCallType = 'video';
        });

        audioCallOption.addEventListener('click', function() {
            selectedCallType = 'audio';
        });

        // add event listener to call button
        callButton.addEventListener('click', function() {
            // get user media based on selected call type
            if (selectedCallType === 'video') {
                navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: true
                    })
                    .then(function(stream) {
                        // save local stream
                        localStream = stream;
                        document.querySelector('#local_video').srcObject = localStream;

                        // create peer connection and add local stream
                        pc = new RTCPeerConnection();
                        pc.addStream(localStream);

                        // ...
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            } else if (selectedCallType === 'audio') {
                navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: false
                    })
                    .then(function(stream) {
                        // save local stream
                        localStream = stream;

                        // create peer connection and add local stream
                        pc = new RTCPeerConnection();
                        pc.addStream(localStream);

                        // ...
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }
        });

        // $('#callTypeDropdown').on('click', function() {
        //     $('#callTypeDropdown').dropdown('toggle');
        // });
    </script>

</body>

</html>