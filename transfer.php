<?php
session_start();
include('db.php');
$UserId = $_SESSION['UserId'];
// $UserIdx = $_GET['UserIdx'];
?>
<?php
function getaddress($lat, $lng)
{
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if ($status == "OK") {
        return $data->results[0]->formatted_address;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offeyicial FastFile - Transfer Files Instantly</title>
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link rel="stylesheet" href="css/transfer.css">
</head>

<body>
    <div class="one">
        <div class="header">
            <div class="newbg">
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </div>
            <header>
                <h1>Offeyicial</h1>
                <h2>FastFile</h2>
                <p>Transfer files instantly without internet.</p>
            </header>
        </div>
        <div class="mainbody">
            <div class="area">
                <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
            <div class="pic1">
                <img width="400px" src="images/send.png">
            </div>
            <div class="pic2">
                <img width="400px" src="images/sendpic.png">
            </div>
            <div class="pic4">
                <img width="400px" src="images/file_transfer.gif">
            </div>
            <div class="outer">
                <div class="pic3">
                    <img width="200px" src="images/wifi.png">
                </div>
                <div class="box">
                    <main>
                        <div class="btn" id="send-files">
                            <img src="icons/sendafile.png" alt="Send Files">
                            <p>Send File</p>
                        </div>
                        <div class="btn" id="receive-files">
                            <img src="icons/receive.png" alt="Receive Files">
                            <p>Receive File</p>
                        </div>
                    </main>
                </div>
                <div class="how-to-use">
                    <a href="tutorial.html">How to Use</a>
                </div>
            </div>
            <div class="overlay"></div>
            <div id="AnimationBox">
                <div class="BoxHeader">
                    <p class="BoxHeaderText" style="font-size: 50px;">Follow</p>
                    <p class="BoxHeaderText" style="font-size: 30px;">the</p>
                    <p class="BoxHeaderText" style="font-size: 50px;">Instructions</p>
                    <p class="BoxHeaderText" style="font-size: 30px;">below</p>
                </div>
                <div class="compPass">
                    <p>Other UserId</p>
                    <input type="text" class="compass" id="compass" placeholder="Ask other user for UserId">
                    <button id="SubmitCompass">Submit</button>
                </div>
                <div class="loading">
                    <p class="loadingText" style="font-size: 50px;">PLEASE WAIT WHILE YOUR WLAN IS SETTING</p>
                    <img src="icons/internet.gif">
                </div>
                <div class="SendTheFileBody">
                    <p class="SendTheFilep">Select the file to be sent</p>
                    <button id="SendTheFile">Submit</button>
                </div>
                <div class="closeBtn">
                    <img width="40px" height="40px" src="icons/close.png">
                </div>
            </div>
        </div>
    </div>
    <script src="node_modules/socket.io-client/dist/socket.io.js"></script>
    <script>
        var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

        // Check if the UserId exists
        if (!UserId) {
            // UserId not found, redirect to login page
            window.location.href = "login.php";
        }
    </script>
    <script>
        var UserId = "<?php echo $_SESSION['UserId']; ?>";
        var socketUrl = 'http://localhost:8888';
        const socket = io(socketUrl, {
            query: {
                UserId,
            }
        });
        let attemptForConnect = 0;

        function showLocation(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            fetch('getaddress.php?lat=' + latitude + '&lng=' + longitude)
                .then(response => response.json())
                .then(address => {
                    console.log('This is the address id ' + address.place_id);
                    console.log(address.address.road);
                })
                .catch(error => {
                    console.log(error);
                });

            const formData = new FormData();
            formData.append('UserId', UserId);
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);
            console.log(latitude, longitude);
            fetch('http://localhost:8888/locationHeatMap', {
                    method: 'POST',
                    body: formData,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Error sending location');
                    }
                    return response.json();
                })
                .then((result) => {
                    if (result) {
                        console.log('heat map updated');
                    } else {
                        console.log(null);
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        }

        function submitDetails(username, passkey, bodyofBody, bodyOfReg) {
            bodyofBody.innerHTML = '';
            var loader = document.createElement('img');
            loader.src = 'icons/internet.gif';
            bodyofBody.appendChild(loader);
            const formOfReg = new FormData();
            formOfReg.append('username', username);
            formOfReg.append('passkey', passkey);
            formOfReg.append('UserId', UserId);
            fetch('http://localhost:8888/newDetails', {
                    method: 'POST',
                    body: formOfReg,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Error sending details');
                    }
                    return response.json();
                })
                .then((result) => {
                    if (result) {
                        console.log('profile created sucessfully');
                        bodyOfReg.style.display = 'none';
                    } else {
                        alert('Error');
                    }
                })
                .catch((error) => {
                    reject(error);
                });
        }

        function checkIfUserHasReg() {
            const Form = new FormData();
            Form.append('UserId', UserId)
            fetch('http://localhost:8888/regConfirm', {
                    method: 'POST',
                    body: Form,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Error checking if user has been registered');
                    }
                    return response.json();
                })
                .then((result) => {
                    if (result === 'yes') {
                        console.log(result);
                    } else {
                        console.log('You are not registered');
                        var mainbody = document.querySelector('.mainbody');
                        var bodyOfReg = document.createElement('div');
                        bodyOfReg.classList.add('RegBody');
                        var RegBodyTitle = document.createElement('div');
                        RegBodyTitle.classList.add('RegBodyTitle');
                        RegBodyTitle.innerHTML = ' Create Your Profile';
                        var RegBodyBody = document.createElement('div');
                        RegBodyBody.classList.add('RegBodyBody');
                        var RegBodyBodyUser = document.createElement('div');
                        RegBodyBodyUser.classList.add('regbodyUsername');
                        const randomSuffix = Math.random().toString(36).substring(2);

                        var regbodyUsernameInput = document.createElement('input');
                        regbodyUsernameInput.classList.add('inputForReg');
                        regbodyUsernameInput.name = `username_${randomSuffix}`;
                        regbodyUsernameInput.autocomplete = 'new-password';
                        regbodyUsernameInput.placeholder = 'Your Username';
                        regbodyUsernameInput.type = 'text';

                        var regbodyPasskey = document.createElement('input');
                        regbodyPasskey.classList.add('passkeyForReg');
                        regbodyPasskey.name = `password_${randomSuffix}`;
                        regbodyPasskey.autocomplete = 'new-password';
                        regbodyPasskey.type = 'password';
                        regbodyPasskey.placeholder = 'Your passkey(Minimum of 8 digits)';

                        var RegBodySubmit = document.createElement('div');
                        RegBodySubmit.classList.add('SubmitForReg');
                        RegBodySubmit.innerHTML = 'Submit';
                        RegBodySubmit.addEventListener('click', function() {
                            console.log(regbodyUsernameInput.value, regbodyPasskey.value);
                            submitDetails(regbodyUsernameInput.value, regbodyPasskey.value, RegBodyBody, bodyOfReg);
                        })
                        var over = document.createElement('div');
                        over.classList.add('over');
                        over.style.display = 'block';
                        RegBodyBodyUser.appendChild(regbodyUsernameInput);
                        RegBodyBodyUser.appendChild(regbodyPasskey);

                        RegBodyBody.appendChild(RegBodyTitle);
                        RegBodyBody.appendChild(RegBodyBodyUser);
                        RegBodyBody.appendChild(RegBodySubmit);
                        bodyOfReg.appendChild(RegBodyBody);
                        bodyOfReg.appendChild(over);
                        mainbody.appendChild(bodyOfReg);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
        socket.on('connect', () => {
            console.log('Socket.IO connection established');
            socket.emit('userConnected', UserId);
            if (attemptForConnect === 0) {
                attemptForConnect++;
                checkIfUserHasReg();
            } else {
                console.log('Reconnected');
            }
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showLocation);
            } else {
                console.log('Geolacation is not supported by this browser.');
            }
        });


        socket.on('location', (data) => {
            console.log('Location of User', UserId, 'is', data);
        });
        var SendBtn = document.getElementById('send-files');
        var ReceiveBtn = document.getElementById('receive-files');
        var animationBox = document.getElementById('AnimationBox');
        var SubmitCompass = document.getElementById('SubmitCompass');
        var closeBtn = document.querySelector('.closeBtn');
        var loading = document.querySelector('.loading');
        var SendTheFile = document.getElementById('SendTheFile');
        var SendTheFileBody = document.querySelector('.SendTheFileBody');
        loading.style.display = 'none';
        const fileContent = "This is the content of the file.";
        SendTheFileBody.style.display = 'none';
        let UserIdx;
        // UserIdx = document.getElementById('compass').value;
        var overlay = document.querySelector('.overlay');
        var compassBody = document.querySelector('.compPass');
        var compass = document.querySelector('.compass');
        let peerConnection;
        let dataChannel;


        function initPeerConnection(UserIdx) {
            console.log('initPeerConnection done');
            peerConnection = new RTCPeerConnection();

            dataChannel = peerConnection.createDataChannel('fileTransfer');

            dataChannel.addEventListener('open', () => {
                console.log('Data channel opened');
            });

            dataChannel.addEventListener('message', (event) => {
                console.log('Received data:', event.data);
            });

            dataChannel.addEventListener('close', () => {
                console.log('Data channel closed');
            });

            peerConnection.addEventListener('icecandidate', (event) => {
                console.log('ice candidate seen', event.candidate);
                if (event.candidate) {
                    console.log('Sending ICE candidate');
                    sendIceCandidate(event.candidate, UserIdx);
                }
            });
        }

        function sendIceCandidate(iceCandidates, UserIdx) {
            // UserIdx = document.getElementById('compass').value;
            console.log('Sending ICE candidates:', iceCandidates);
            console.log('Sending to:', UserIdx);
            sendMessage({
                type: 'candidate',
                candidates: iceCandidates,
                callerUserId: UserId,
                callertoUserId: UserIdx,
            });
        }

        async function sendOffer() {
            try {
                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(offer);

                console.log('Sending offer:', offer);
                sendMessage({
                    type: 'offer',
                    offer: offer,
                    callerUserId: UserId,
                    callertoUserId: UserIdx,
                });
            } catch (error) {
                console.error('Error creating offer:', error);
            }
        }

        async function handleOffer(message) {
            var offer = new RTCSessionDescription(message.offer);
            var UserIdx = message.callerUserId;
            animationBox.style.display = 'flex';
            SendTheFileBody.style.display = 'none';
            loading.style.display = 'flex';
            compassBody.style.display = 'none';


            try {
                if (!peerConnection) {
                    initPeerConnection(UserIdx);
                }

                await peerConnection.setRemoteDescription(offer);
                const answer = await peerConnection.createAnswer();
                await peerConnection.setLocalDescription(answer);

                console.log('Sending answer:', answer);
                sendMessage({
                    type: 'answer',
                    answer: answer,
                    callerUserId: UserIdx,
                    callertoUserId: UserId,
                });
            } catch (error) {
                console.error('Error handling offer:', error);
            }
        }


        function handleAnswerMessage(message) {
            console.log('This is the recieved answer', message.answer);
            var answer = new RTCSessionDescription(message.answer);
            peerConnection.setRemoteDescription(answer);
            loading.style.display = 'none';
            console.log(dataChannel);
            SendTheFileBody.style.display = 'flex';
        }


        function handleIceCandidate(candidate) {
            var candidates = candidate.candidate;
            try {
                const iceCandidate = new RTCIceCandidate(candidates);
                peerConnection.addIceCandidate(iceCandidate)
                    .then(() => {
                        console.log('ICE candidate added successfully');
                    })
                    .catch((error) => {
                        console.error('Error adding ICE candidate:', error);
                    });
            } catch (error) {
                console.error('Error creating RTCIceCandidate:', error);
            }
        }

        function handleNotAvailable(message) {
            var callertoUserId = message.callertoUserId;
            console.log("User not available:", callertoUserId)
        }

        function sendData(data) {
            if (dataChannel.readyState === 'open') {
                dataChannel.send(data);
            } else {
                console.warn('Data channel is not open. Cannot send data.');
            }
        }

        function closeConnection() {
            if (peerConnection) {
                peerConnection.close();
            }
        }

        SubmitCompass.addEventListener('click', () => {
            UserIdx = document.getElementById('compass').value;
            alert(UserIdx);
            loading.style.display = 'flex';
            compassBody.style.display = 'none';
            const sendFileForm = new FormData();
            sendFileForm.append('UserId', UserId);
            initPeerConnection(UserIdx);
            sendOffer();
        });

        function sendMessage(message) {
            console.log('Message to be sent', message);
            socket.emit('transfer', JSON.stringify(message));
        }


        function initSignaling() {
            socket.on('transfer', function(data) {
                var message = JSON.parse(data);
                console.log(message);
                if (message.type === 'offer') {
                    handleOffer(message);
                } else if (message.type === 'answer') {
                    handleAnswerMessage(message);
                } else if (message.type === 'candidate') {
                    handleIceCandidate(message);
                } else if (message.type === 'notAvailable') {
                    handleNotAvailable(message);
                }
            });
        }
        initSignaling();


        SendBtn.addEventListener('click', function() {
            overlay.style.display = 'block';
            animationBox.style.display = 'flex';
        })
        SendTheFile.addEventListener('click', function() {
            sendData(fileContent);
        })
        closeBtn.addEventListener('click', function() {
            animationBox.style.display = 'none';
            overlay.style.display = 'none';
            loading.style.display = 'none';
            compassBody.style.display = 'flex';
        })
        overlay.addEventListener('click', function() {
            overlay.style.display = 'none';
            animationBox.style.display = 'none';
            loading.style.display = 'none';
            compassBody.style.display = 'flex';
        })

        function wifi() {
            if ('settings' in window.navigator) {
                window.navigator.settings
                    .configure({
                        setting: 'wifi'
                    })
                    .then(() => {
                        console.log('Opened Wi-Fi settings');
                    })
                    .catch((err) => {
                        console.error('Error opening Wi-Fi settings:', err);
                    });
            } else {
                console.warn('Wi-Fi settings not supported in this browser');
            }
        }
    </script>
</body>

</html>