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
    <style>
        .callmain {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #recipient_info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        #recipient_info h3 {
            margin-top: 10px;
            font-size: 1.2rem;
        }

        .callbody {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #local_video {
            width: 300px;
            height: 225px;
            margin-bottom: 10px;
        }

        #remote_video {
            width: 300px;
            height: 225px;
            margin-bottom: 20px;
        }

        #call_button,
        #hangup_button {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 50%;
            background-color: transparent;
            border: none;
            margin: 10px;
            cursor: pointer;
            width: 50%;
            position: relative;
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
    </style>
</head>

<body>
    <div class="callmain">
        <!-- <div id="recipient_info">
            <img class="recipientPassport" src="<?php echo $recipientPassport; ?>">
            <h3><?php echo $recipientSurname . ' ' . $recipientFirstName; ?></h3>
        </div> -->
        <div class="callbody">
            <div id="local_video"></div>
            <div id="remote_video"></div>
            <div class="row">
                <button id="call_button"><i class="bi bi-telephone"></i></button>
                <button id="hangup_button"><i class="bi bi-telephone"></i></button>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/adapter-latest.js"></script>
    <script>
        // initialize variables
        var localStream, remoteStream, pc, isCaller;

        // get user media
        navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            })
            .then(function(stream) {
                // save local stream
                localStream = stream;
                document.querySelector('#local_video').srcObject = localStream;

                // create peer connection
                pc = new RTCPeerConnection();

                // add local stream to peer connection
                pc.addStream(localStream);

                // listen for incoming ice candidates
                pc.onicecandidate = function(event) {
                    if (event.candidate) {
                        sendMessage(JSON.stringify({
                            'candidate': event.candidate
                        }));
                    }
                };

                // listen for incoming remote stream
                pc.onaddstream = function(event) {
                    document.querySelector('#remote_video').srcObject = event.stream;
                };

                // listen for hangup event
                document.querySelector('#hangup_button').addEventListener('click', function() {
                    pc.close();
                    localStream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                    remoteStream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                });

                // check if we are the caller or the callee
                if (isCaller) {
                    // create offer
                    pc.createOffer().then(function(offer) {
                        return pc.setLocalDescription(offer);
                    }).then(function() {
                        sendMessage(JSON.stringify({
                            'sdp': pc.localDescription
                        }));
                    });
                } else {
                    // listen for incoming offer
                    pc.ondatachannel = function(event) {
                        var channel = event.channel;
                        channel.onmessage = function(event) {
                            var message = JSON.parse(event.data);
                            if (message.sdp) {
                                pc.setRemoteDescription(new RTCSessionDescription(message.sdp)).then(function() {
                                    if (pc.remoteDescription.type == 'offer') {
                                        pc.createAnswer().then(function(answer) {
                                            return pc.setLocalDescription(answer);
                                        }).then(function() {
                                            sendMessage(JSON.stringify({
                                                'sdp': pc.localDescription
                                            }));
                                        });
                                    }
                                });
                            } else if (message.candidate) {
                                pc.addIceCandidate(new RTCIceCandidate(message.candidate));
                            }
                        };
                    };
                }
            })
            .catch(function(error) {
                console.error(error);
            });

        // send message using websockets
        function sendMessage(message) {
            // code to send message using websockets
        }
    </script>
</body>

</html>