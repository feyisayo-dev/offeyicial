<?php
session_start();
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
    <script src="js/socket.io.js"></script>


    <script>
        // initialize variables
        // var socket = io();
        var localStream, remoteStream, pc, isCaller, selectedCallType;
        var startTime, timerInterval;
        const WebSocket = require('ws');
        const server = new WebSocket.Server({
            port: 5050
        });

        var ws = new WebSocket('ws://localhost:5050');

        // get dropdown options and call button
        var videoCallOption = document.querySelector('#video_call_button');
        var audioCallOption = document.querySelector('#audio_call_button');
        var callButton = document.querySelector('#call_button');
        var callTime = document.querySelector('#call_timer');
        var startTime = Date.now();

        function updateCallTime() {
            var elapsedTime = Math.floor((Date.now() - startTime) / 1000); // calculate elapsed time in seconds
            var minutes = Math.floor(elapsedTime / 60);
            var seconds = elapsedTime % 60;
            callTime.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds; // format time as mm:ss
        }

        setInterval(updateCallTime, 1000); // call updateCallTime every second


        // add event listeners to dropdown options
        videoCallOption.addEventListener('click', function() {
            selectedCallType = 'video';
            document.querySelector('#local_video').style.display = 'block';
            document.querySelector('#remote_video').style.display = 'block';
            callTime.style.display = 'none';
        });

        audioCallOption.addEventListener('click', function() {
            selectedCallType = 'audio';
            document.querySelector('#local_video').style.display = 'none';
            document.querySelector('#remote_video').style.display = 'none';
            callTime.style.display = 'block';
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

                        // create offer SDP message
                        pc.createOffer().then((offer) => {
                            // set local description
                            pc.setLocalDescription(offer).then(() => {
                                // send offer to signaling server
                                const message = {
                                    type: 'offer',
                                    sdp: offer.sdp
                                };
                                ws.send(JSON.stringify(message));
                            });
                        });

                        // handle incoming messages from signaling server
                        ws.onmessage = (event) => {
                            const message = JSON.parse(event.data);
                            if (message.type === 'answer') {
                                // set remote description
                                const answer = new RTCSessionDescription({
                                    type: 'answer',
                                    sdp: message.sdp
                                });
                                pc.setRemoteDescription(answer);
                            } else if (message.type === 'candidate') {
                                // add ICE candidate to PeerConnection object
                                const candidate = new RTCIceCandidate({
                                    candidate: message.candidate,
                                    sdpMLineIndex: message.label,
                                    sdpMid: message.id
                                });
                                pc.addIceCandidate(candidate);
                            }
                        };

                        // handle ICE candidate events
                        pc.onicecandidate = (event) => {
                            if (event.candidate) {
                                // send ICE candidate to signaling server
                                const message = {
                                    type: 'candidate',
                                    label: event.candidate.sdpMLineIndex,
                                    id: event.candidate.sdpMid,
                                    candidate: event.candidate.candidate
                                };
                                ws.send(JSON.stringify(message));
                            }
                        };
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

                        // start timer
                        startTime = new Date().getTime();

                        // create offer and set local description
                        pc.createOffer({
                            offerToReceiveAudio: 1,
                            offerToReceiveVideo: 0
                        }).then(function(offer) {
                            pc.setLocalDescription(new RTCSessionDescription(offer));

                            // send offer to remote peer
                            socket.emit('offer', {
                                offer: offer,
                                to: callToUsername,
                                from: username
                            });
                        });
                    })
                    .catch(function(error) {
                        console.log('Error getting user media: ' + error);
                    });
            }
        });
        // listen for incoming calls
        socket.on('call', function(data) {
            // save remote username
            callFromUsername = data.from;

            // show incoming call modal
            $('#incomingCallModal').modal('show');

            // play ringtone sound
            ringtone.play();

            // set call type to video or audio
            selectedCallType = data.callType;

            // accept call when user clicks on accept button
            $('#acceptCallBtn').click(function() {
                // stop ringtone sound
                ringtone.pause();
                ringtone.currentTime = 0;

                // hide incoming call modal
                $('#incomingCallModal').modal('hide');

                // save remote stream
                remoteStream = new MediaStream();

                // create peer connection and add remote stream
                pc = new RTCPeerConnection();
                pc.addStream(remoteStream);

                // answer call and set local description
                pc.setRemoteDescription(new RTCSessionDescription(data.offer))
                    .then(function() {
                        return navigator.mediaDevices.getUserMedia({
                            audio: selectedCallType === 'audio',
                            video: selectedCallType === 'video'
                        });
                    })
                    .then(function(stream) {
                        // save local stream
                        localStream = stream;

                        // add local stream to peer connection
                        pc.addStream(localStream);

                        // create answer and set local description
                        return pc.createAnswer({
                            offerToReceiveAudio: 1,
                            offerToReceiveVideo: selectedCallType === 'video' ? 1 : 0
                        });
                    })
                    .then(function(answer) {
                        pc.setLocalDescription(new RTCSessionDescription(answer));

                        // send answer to remote peer
                        socket.emit('answer', {
                            answer: answer,
                            to: callFromUsername,
                            from: username
                        });
                    })
                    .catch(function(error) {
                        console.log('Error answering call: ' + error);
                    });
            });

            // reject call when user clicks on reject button
            $('#rejectCallBtn').click(function() {
                // stop ringtone sound
                ringtone.pause();
                ringtone.currentTime = 0;

                // hide incoming call modal
                $('#incomingCallModal').modal('hide');

                // send busy signal to remote peer
                socket.emit('busy', {
                    to: callFromUsername,
                    from: username
                });
            });
        });

        // listen for answer from remote peer
        socket.on('answer', function(data) {
            // set remote description
            pc.setRemoteDescription(new RTCSessionDescription(data.answer))
                .catch(function(error) {
                    console.log('Error setting remote description: ' + error);
                });
        });

        // listen for busy signal from remote peer
        socket.on('busy', function(data) {
            // show busy signal modal
            $('#busySignalModal').modal('show');

            // stop ringtone sound
            ringtone.pause();
            ringtone.currentTime = 0;

            // hide incoming call modal
            $('#incomingCallModal').modal('hide');
        });

        // listen for ice candidates and add to peer connection
        pc.onicecandidate = function(event) {
            if (event.candidate) {
                socket.emit('ice-candidate', {
                    candidate: event.candidate,
                    to: callTo,
                    from: currentUser
                });
            }
        };

        // create offer and set as local description
        pc.createOffer({
            offerToReceiveAudio: true,
            offerToReceiveVideo: false
        }).then(function(offer) {
            pc.setLocalDescription(offer);
            socket.emit('make-offer', {
                offer: offer,
                to: callTo,
                from: currentUser
            });
        });

        // listen for offer from other user
        socket.on('offer-made', function(data) {
            // set call type to audio or video
            selectedCallType = data.offer.sdp.indexOf('m=video') !== -1 ? 'video' : 'audio';

            // save other user's socket id
            otherSocketId = data.socketId;

            // set remote description
            pc.setRemoteDescription(new RTCSessionDescription(data.offer));

            // create answer and set as local description
            pc.createAnswer({
                offerToReceiveAudio: true,
                offerToReceiveVideo: selectedCallType === 'video'
            }).then(function(answer) {
                pc.setLocalDescription(answer);
                socket.emit('make-answer', {
                    answer: answer,
                    to: otherSocketId,
                    from: currentUser
                });
            });
        });

        // listen for answer from other user
        socket.on('answer-made', function(data) {
            // set remote description
            pc.setRemoteDescription(new RTCSessionDescription(data.answer));
        });

        // listen for ice candidates from other user and add to peer connection
        socket.on('ice-candidate', function(data) {
            pc.addIceCandidate(new RTCIceCandidate(data.candidate));
        });

        // when call is ended, hang up and reset variables
        function hangUpCall() {
            pc.close();
            socket.emit('hang-up', {
                to: otherSocketId,
                from: currentUser
            });
            resetCallVariables();
        }
    </script>


</body>

</html>