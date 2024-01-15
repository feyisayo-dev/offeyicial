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
            <div id="AnimationBox">
                <div class="BoxHeader">
                    <p class="BoxHeaderText" style="font-size: 50px;">Follow</p>
                    <p class="BoxHeaderText" style="font-size: 30px;">the</p>
                    <p class="BoxHeaderText" style="font-size: 50px;">Instructions</p>
                    <p class="BoxHeaderText" style="font-size: 30px;">below</p>
                </div>
                <div class="closeBtn">
                    <img width="40px" height="40px" src="icons/close.png">
                </div>
            </div>
        </div>
        <script>
            var SendBtn = document.getElementById('send-files');
            var ReceiveBtn = document.getElementById('receive-files');
            var animationBox = document.getElementById('AnimationBox');

            SendBtn.addEventListener('click', function() {
                animationBox.style.display = 'flex';
                if (animationBox.style.display === 'flex') {
                    console.log('It is open');
                    window.onclick = function(event) {
                        if (event.target != animationBox) {
                            console.log('trying to close');
                            animationBox.style.display = "none";
                        }
                    }
                }
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