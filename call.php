<?php
session_start();
// Check if user is logged in
include('db.php');
$UserId = $_SESSION['UserId'];
$UserIdx = $_GET['UserIdx'];
$sessionID = $_GET['sessionId'];

?>


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

        .recipientName {
            font-size: 1rem;
            font-weight: normal;
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
            $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserIdx'";
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
                <video class="video-player remote" id="<?php echo $UserIdx; ?>" autoplay playsinline></video>
            </div>

            <div class="over" id="over">
                <image id="recipientPassport" height="50" width="50" />
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 80">
                    <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle">
                        <tspan class="recipientName" dy="0"><?php echo $Surname ?></tspan>
                        <tspan class="recipientName" x="50%" dy="1.5em"><?php echo $First_Name ?></tspan>
                        <!-- <a id="recipientName" x="50%" dy="1.5em"><?php echo $First_Name . '' . $Surname ?></a> -->
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
            <script src="js/bootstrap.bundle.min.js"></script>

            <script>
                var userB = document.getElementById("videos").querySelector(".remote").id;
                console.log(userB);
                var UserId = '<?php echo $_SESSION["UserId"]; ?>';
                console.log(UserId);
            </script>
            <!-- <script src="js/call.js"></script> -->

            <!-- <script>
                $(document).ready(function() {
                    // Get the UserIdx from the URL query parameters
                    const urlParams = new URLSearchParams(window.location.search);
                    const UserIdx = <?php echo $UserIdx; ?>;
                    const sessionId = sessionStorage.getItem('sessionId'); // Retrieve the sessionId from sessionStorage



                    // Make an AJAX request to sendsession.php
                    $.ajax({
                        url: 'sendsession.php',
                        type: 'POST',
                        data: {
                            UserIdx: UserIdx,
                            sessionId: sessionId
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            </script> -->
            <!-- Remove the individual script tags -->
            <script>
                var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

                // Check if the UserId exists
                if (!UserId) {
                    // UserId not found, redirect to login page
                    window.location.href = "login.php";
                }
            </script>
            <script>
                var localStream;
                var remoteStream;
                var localVideo = document.getElementById("<?php echo $UserId; ?>");
                var remoteVideo = document.getElementById("<?php echo $UserIdx; ?>");
                var hangupButton = document.getElementById('hangup_button');
                var audioCallButton = document.getElementById('audio_call_button');
                var videoCallButton = document.getElementById('video_call_button');
                var callerStatusElement = document.getElementById('status');
                var peerConnection;
                var userB = document.getElementById("videos").querySelector(".remote").id;
                var UserId = "<?php echo $UserId ?>";
                var signalingSocket;

                hangupButton.addEventListener('click', function() {
                    hangUpCall();
                });

                audioCallButton.addEventListener('click', toggleAudio);
                videoCallButton.addEventListener('click', toggleVideo);

                function toggleAudio() {
                    localStream.getAudioTracks().forEach(function(track) {
                        track.enabled = !track.enabled;
                    });
                }

                function toggleVideo() {
                    localStream.getVideoTracks().forEach(function(track) {
                        track.enabled = !track.enabled;
                    });
                }
                var UserIdx = <?php echo $_GET['UserIdx']; ?>;

                function initSignaling() {
                    var sessionId = "<?php echo $sessionID; ?>";
                    var userB = document.getElementById("videos").querySelector(".remote").id;
                    var signalingServerUrl = 'ws://localhost:8888?UserId=' + UserId + '&sessionID=' + sessionId + '&UserIdx=' + userB;
                    var retryCount = 0;
                    var maxRetries = 3;

                    function connectSignalingSocket() {
                        signalingSocket = new WebSocket(signalingServerUrl);

                        signalingSocket.onopen = function() {
                            console.log('Signaling socket connection established');
                            sendIncomingCallSignal();
                        };

                        function sendIncomingCallSignal() {
                            var message = {
                                type: 'incoming_call',
                                callerUserId: UserId,
                                callertoUserId: userB,
                            };
                            sendMessage(message);
                        }

                        signalingSocket.onmessage = function(event) {
                            var message = JSON.parse(event.data);
                            console.log(message);

                            if (message.type === 'hangup') {
                                handleHangupMessage(message);
                            } else if (message.type === 'answer') {
                                handleAnswerMessage(message);
                            }
                        };

                        signalingSocket.onclose = function(event) {
                            console.log('Signaling socket connection closed:', event.code, event.reason);
                            if (retryCount < maxRetries) {
                                console.log('Retry connecting signaling socket...');
                                retryCount++;
                                setTimeout(connectSignalingSocket, 3000); // Retry after 3 seconds
                            } else {
                                console.log('Maximum retry count reached. Cannot establish signaling socket connection.');
                            }
                        };

                        signalingSocket.onerror = function(error) {
                            console.log('Signaling socket error:', error);
                        };
                    }

                    connectSignalingSocket();
                }


                function startVideoCall() {
                    function getUserMediaWithRetry(constraints, maxRetries, delay) {
                        return new Promise(function(resolve, reject) {
                            function attempt() {
                                navigator.mediaDevices.getUserMedia(constraints)
                                    .then(resolve)
                                    .catch(function(error) {
                                        if (maxRetries > 0) {
                                            console.log('Failed to access camera and microphone. Retrying...');
                                            maxRetries--;
                                            setTimeout(attempt, delay);
                                        } else {
                                            reject(error);
                                        }
                                    });
                            }
                            attempt();
                        });
                    }

                    var constraints = {
                        video: true,
                        audio: true
                    };
                    var maxRetries = 7;
                    var delay = 1000; // 1 second

                    getUserMediaWithRetry(constraints, maxRetries, delay)
                        .then(function(stream) {
                            localStream = stream;
                            peerConnection = new RTCPeerConnection();

                            stream.getTracks().forEach(function(track) {
                                peerConnection.addTrack(track, stream);
                            });
                            sendCallOffer({
                                audio: true,
                                video: true
                            }, userB);


                            hangupButton.disabled = false;
                            audioCallButton.disabled = false;
                            videoCallButton.disabled = false;

                            localVideo.style.display = 'block';
                            remoteVideo.style.display = 'block';
                            localVideo.srcObject = stream;
                        })
                        .catch(function(error) {
                            console.log('Error accessing camera and microphone:', error);
                        });

                    initSignaling();

                    function sendCallOffer(mediaConstraints, userB) {
                        var offerOptions = {
                            offerToReceiveAudio: mediaConstraints.audio ? 1 : 0,
                            offerToReceiveVideo: mediaConstraints.video ? 1 : 0
                        };

                        peerConnection.createOffer(offerOptions)
                            .then(function(offer) {
                                return peerConnection.setLocalDescription(offer);
                            })
                            .then(function() {
                                var sdpOffer = peerConnection.localDescription;
                                console.log("SDP Offer:", sdpOffer);

                                var sessionId = "<?php echo $sessionID; ?>";

                                var userB = '<?php echo $_GET['UserIdx']; ?>';
                                sendMessage({
                                    type: 'offer',
                                    offer: sdpOffer,
                                    mediaConstraints: mediaConstraints,
                                    callerUserId: UserId,
                                    callertoUserId: userB,
                                    sessionId: sessionId
                                });
                            })
                            .catch(function(error) {
                                console.log('Error creating call offer:', error);
                            });
                    }

                }


                // Define the pendingCandidates variable at the global scope
                var pendingCandidates = [];

                function handleAnswerMessage(message) {
                    var answer = new RTCSessionDescription(message.answer);

                    if (peerConnection.signalingState === 'have-local-offer') {
                        peerConnection.setRemoteDescription(answer)
                            .then(function() {
                                if (pendingCandidates.length > 0) {
                                    pendingCandidates.forEach(function(candidate) {
                                        peerConnection.addIceCandidate(candidate)
                                            .catch(function(error) {
                                                console.log('Error handling pending ICE candidate:', error);
                                            });
                                    });
                                    pendingCandidates = [];
                                }
                            })
                            .catch(function(error) {
                                console.log('Error handling call answer:', error);
                            });
                    } else {
                        peerConnection.addEventListener('signalingstatechange', function() {
                            if (peerConnection.signalingState === 'have-local-offer') {
                                peerConnection.setRemoteDescription(answer)
                                    .then(function() {
                                        if (pendingCandidates.length > 0) {
                                            pendingCandidates.forEach(function(candidate) {
                                                peerConnection.addIceCandidate(candidate)
                                                    .catch(function(error) {
                                                        console.log('Error handling pending ICE candidate:', error);
                                                    });
                                            });
                                            pendingCandidates = [];
                                        }
                                    })
                                    .catch(function(error) {
                                        console.log('Error handling call answer:', error);
                                    });
                            }
                        });
                    }
                }

                function handleCandidateMessage(message) {
                    var candidate = new RTCIceCandidate(message.candidate);
                    peerConnection.addIceCandidate(candidate)
                        .catch(function(error) {
                            console.log('Error handling ICE candidate:', error);
                        });
                }

                function handleHangupMessage() {
                    var callerUserId = message.callerUserId;
                    console.log("Call has been ended from:", callerUserId)
                    hangUpCall();
                }

                function hangUpCall() {
                    // Stop the media streams
                    localStream.getTracks().forEach(function(track) {
                        track.stop();
                    });

                    // Close the RTCPeerConnection
                    if (peerConnection) {
                        peerConnection.close();
                        peerConnection = null;
                    }

                    // Update the UI to reflect the call status
                    hangupButton.disabled = true;
                    audioCallButton.disabled = false;
                    videoCallButton.disabled = false;
                    localVideo.srcObject = null;
                    remoteVideo.srcObject = null;
                    callerStatusElement.textContent = 'Call Ended';

                    // Send a hangup message to the server
                    const message = {
                        type: 'hangup',
                        callerUserId: UserId,
                        callertoUserId: userB,
                    };
                    sendMessage(message);
                    var recipientId = "<?php echo $_GET['UserIdx']; ?>";
                    history.pushState({
                        page: 'chat'
                    }, null, "chat.php?UserIdx=" + recipientId);
                    loadChatPage();
                }

                function sendMessage(message) {
                    if (signalingSocket && signalingSocket.readyState === WebSocket.OPEN) {
                        signalingSocket.send(JSON.stringify(message));
                    } else {
                        console.log('WebSocket connection is not open. Message not sent:', message);
                    }
                }

                startVideoCall();
                // Function to load the chat.php content dynamically
                function loadChatPage() {
                    var recipientId = "<?php echo $_GET['UserIdx']; ?>";

                    // Create an AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // Request successful
                                var response = xhr.responseText;

                                // Update the content of the desired location in the current page
                                document.getElementById("chatbox").innerHTML = response;

                                // Execute the JavaScript code from the loaded content
                                var scriptElements = document.getElementById("chatbox").querySelectorAll("script");
                                scriptElements.forEach(function(scriptElement) {
                                    var scriptCode = scriptElement.innerHTML;
                                    eval(scriptCode);
                                });
                            } else {
                                // Request failed
                                console.log("Error: " + xhr.status);
                            }
                        }
                    };

                    // Send the AJAX request to retrieve the content of chat.php
                    xhr.open("GET", "chat.php?UserIdx=" + recipientId, true);
                    xhr.send();
                }

                // Handle the popstate event to load the chat.php content when using the browser's back/forward buttons
                window.addEventListener("popstate", function(event) {
                    if (event.state && event.state.page === "chat") {
                        loadChatPage();
                    }
                });
            </script>

</body>

</html>