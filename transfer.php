<?php
session_start();
include('db.php');
$UserId = $_SESSION['UserId'];
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
                <div class="loading">
                    <p class="loadingText" style="font-size: 50px;">PLEASE WAIT WHILE YOUR WLAN IS SETTING</p>
                    <img src="icons/internet.gif">
                </div>
                <div class="closeBtn">
                    <img width="40px" height="40px" src="icons/close.png">
                </div>
            </div>
        </div>
        <script src="node_modules/socket.io-client/dist/socket.io.js"></script>

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
            var closeBtn = document.querySelector('.closeBtn');
            var overlay = document.querySelector('.overlay');

            SendBtn.addEventListener('click', function() {
                overlay.style.display = 'block';
                animationBox.style.display = 'flex';
                const sendFileForm = new FormData();
                sendFileForm.append('UserId', UserId);
                fetch('http://localhost:8888/sendFile', {
                        method: 'POST',
                        body: sendFileForm,
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Error setting up wlan');
                        }
                        return response.json();
                    })
                    .then((result) => {
                        if (result) {
                            console.log('ask user to sign in into your page');
                        } else {
                            alert('Error');
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    });
            })
            closeBtn.addEventListener('click', function() {
                animationBox.style.display = 'none';
                overlay.style.display = 'none';
            })
            overlay.addEventListener('click', function() {
                overlay.style.display = 'none';
                animationBox.style.display = 'none';
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