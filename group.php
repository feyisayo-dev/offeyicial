<?php
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];
if (isset($_GET['groupId'])) {
    $groupId = $_GET['groupId'];

    $sql = "SELECT * FROM Group WHERE GroupId = ?";
    $stmt = sqlsrv_prepare($conn, $sql, $groupId);

    $sql1 = "SELECT User_Profile.UserId, User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport
    FROM User_Profile
    INNER JOIN group_members ON User_Profile.UserId = group_members.UserId
    WHERE group_members.UserId = ?";
    $params = array($UserId);
    $stmt1 = sqlsrv_prepare($conn, $sql1, $params);


    if ($stmt === false) {
        echo "Error preparing SQL statement: " . print_r(sqlsrv_errors(), true);
    } else {
        if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $Reach = $row['Reach'];
                $GroupName = $row['GroupName'];
                $GroupPic = $row['GroupPic'];
                $dateCreated = $row['DateCreated'];

                echo "User ID: $userId, Username: $GroupName, Date Created: $dateCreated <br>";
            }
        } else {
            echo "Error executing SQL statement: " . print_r(sqlsrv_errors(), true);
        }
    }

    function generateSessionID($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sessionID = '';

        $charCount = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $sessionID .= $characters[rand(0, $charCount - 1)];
        }

        return $sessionID;
    }

    $tsql = "SELECT sessionID FROM sessionID WHERE (UserId = '$UserId' AND groupId = '$groupId') OR (UserId = '$groupId' AND groupId = '$UserId')";
    $getResults = sqlsrv_query($conn, $tsql);

    if ($getResults === false) {
        die(json_encode(array("status" => "error", "message" => "Error querying the database.")));
    }

    if (sqlsrv_has_rows($getResults)) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $sessionID = $row['sessionID'];
    } else {
        $sessionID = generateSessionID();

        $tsql = "INSERT INTO sessionID (sessionID, UserId, groupId) VALUES ('$sessionID', '$UserId', '$groupId')";
        $insertResult = sqlsrv_query($conn, $tsql);

        if ($insertResult === false) {
            die(json_encode(array("status" => "error", "message" => "Error storing session ID in the database.")));
        }
    }

    sqlsrv_free_stmt($getResults);
    sqlsrv_close($conn);
}
?>



<?php
include 'db.php';
$UserId = $_SESSION['UserId'];
$rsql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
$rstmt = sqlsrv_prepare($conn, $rsql);
if (sqlsrv_execute($rstmt)) {
    while ($row = sqlsrv_fetch_array($rstmt, SQLSRV_FETCH_ASSOC)) {
        $Surname = $row['Surname'];
        $First_Name = $row['First_Name'];
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Group Chat~<?php echo $Surname . " " . $First_Name; ?></title>
    <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link rel="stylesheet" href="css\all.min.css">
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <link rel="stylesheet" href="css\fontawesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="css/chat.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/twemoji.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="node_modules/socket.io-client/dist/socket.io.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>

<body>
    <div id="chatbox" class="chat_interface">
        <nav>

            <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>

            <div class="profile">
                <div class="search-container">
                    <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                    <div id="user_table">
                        <!-- <ul>
        <li></li>
    </ul> -->
                    </div>
                </div>


                <a href="user_profile.php?UserId=<?php echo $UserId ?>" class="profile-name"><i class="bi bi-person"></i><?php echo $Surname . " " . $First_Name; ?></a>
            </div>
        </nav>
        <div class="chat-container">
            <div class="sidebar">
                <ul class="sidebar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="window.location.href='reel.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-camera-reels"></i></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>"><i class="bi bi-plus-square"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="notificationLink" href="#"><i class="bi bi-bell-fill"></i></a>
                        <div id="notificationBox">
                            <!-- Content of the notification box goes here -->
                            <!-- You can customize the content as per your requirements -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="location.href='logoutmodal.php'"><i class="bi bi-box-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
            <div class="chat-header">
                <img class="recipientPassport">
                <a class="icon"></a>
                <div class="dropdown">
                    <button class="dropdown-toggle custom-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-target="#chtheme" aria-controls="chtheme">
                        <span class="dots"></span>
                        <span class="dots"></span>
                        <span class="dots"></span>
                    </button>

                    <ul class="dropdown-menu reset" id="chtheme" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" onclick="resetTheme()">Reset Theme</a></li>
                    </ul>
                </div>
                <a class="call-icon" id="callbtn"><i class="bi bi-telephone"></i></a>
            </div>
            <div class="chatbox">
                <button id="scrollToBottomBtn"><i class="bi bi-arrow-down"></i></button>
                <div id="video-preview"></div>
                <div class="form-group">
                    <div class="row">
                        <div class="foot">
                            <div class="emoji-picker">
                                <!-- emoji table code goes here -->
                                <button type="button" class="btn btn-primary emoji" onclick="toggleEmojiPicker()">
                                    <i class="fas fa-smile"></i>
                                </button>
                                <div class="emoji-table-container" style="display:none">
                                    <table>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F600;')">😀</td>
                                            <td onclick="insertEmoji('&#x1F601;')">😁</td>
                                            <td onclick="insertEmoji('&#x1F602;')">😂</td>
                                            <td onclick="insertEmoji('&#x1F603;')">😃</td>
                                            <td onclick="insertEmoji('&#x1F604;')">😄</td>
                                            <td onclick="insertEmoji('&#x1F605;')">😅</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F606;')">😆</td>
                                            <td onclick="insertEmoji('&#x1F607;')">😇</td>
                                            <td onclick="insertEmoji('&#x1F608;')">😈</td>
                                            <td onclick="insertEmoji('&#x1F609;')">😉</td>
                                            <td onclick="insertEmoji('&#x1F610;')">😐</td>
                                            <td onclick="insertEmoji('&#x1F611;')">😑</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F620;')">😠</td>
                                            <td onclick="insertEmoji('&#x1F621;')">😡</td>
                                            <td onclick="insertEmoji('&#x1F622;')">😢</td>
                                            <td onclick="insertEmoji('&#x1F623;')">😣</td>
                                            <td onclick="insertEmoji('&#x1F624;')">😤</td>
                                            <td onclick="insertEmoji('&#x1F625;')">😥</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F626;')">😦</td>
                                            <td onclick="insertEmoji('&#x1F627;')">😧</td>
                                            <td onclick="insertEmoji('&#x1F628;')">😨</td>
                                            <td onclick="insertEmoji('&#x1F629;')">😩</td>
                                            <td onclick="insertEmoji('&#x1F630;')">😰</td>
                                            <td onclick="insertEmoji('&#x1F631;')">😱</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F632;')">😲</td>
                                            <td onclick="insertEmoji('&#x1F633;')">😳</td>
                                            <td onclick="insertEmoji('&#x1F634;')">😴</td>
                                            <td onclick="insertEmoji('&#x1F635;')">😵</td>
                                            <td onclick="insertEmoji('&#x1F636;')">😶</td>
                                            <td onclick="insertEmoji('&#x1F637;')">😷</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F638;')">😸</td>
                                            <td onclick="insertEmoji('&#x1F639;')">😹</td>
                                            <td onclick="insertEmoji('&#x1F640;')">😰</td>
                                            <td onclick="insertEmoji('&#x1F641;')">😱</td>
                                            <td onclick="insertEmoji('&#x1F642;')">😲</td>
                                            <td onclick="insertEmoji('&#x1F643;')">😳</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F60A;')">😊</td>
                                            <td onclick="insertEmoji('&#x1F60B;')">😋</td>
                                            <td onclick="insertEmoji('&#x1F60C;')">😌</td>
                                            <td onclick="insertEmoji('&#x1F60D;')">😍</td>
                                            <td onclick="insertEmoji('&#x1F60E;')">😎</td>
                                            <td onclick="insertEmoji('&#x1F60F;')">😏</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F612;')">😒</td>
                                            <td onclick="insertEmoji('&#x1F613;')">😓</td>
                                            <td onclick="insertEmoji('&#x1F616;')">😖</td>
                                            <td onclick="insertEmoji('&#x1F615;')">😕</td>
                                            <td onclick="insertEmoji('&#x1F617;')">😗</td>
                                            <td onclick="insertEmoji('&#x1F618;')">😘</td>
                                        </tr>
                                        <tr>
                                            <td onclick="insertEmoji('&#x1F619;')">😙</td>
                                            <td onclick="insertEmoji('&#x1F61A;')">😚</td>
                                            <td onclick="insertEmoji('&#x1F61B;')">😛</td>
                                            <td onclick="insertEmoji('&#x1F61C;')">😜</td>
                                            <td onclick="insertEmoji('&#x1F61D;')">😝</td>
                                            <td onclick="insertEmoji('&#x1F61E;')">😞</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="custom-file" id="image-custom-file">
                                <input type="file" class="image-input" id="image" name="image" accept="image/*" onchange="previewImage()" multiple>
                                <label class="custom-file-label" for="image"><i class="bi bi-image"></i></label>
                            </div>
                            <div class="custom-file" id="video-custom-file">
                                <input type="file" class="video-input" id="video" name="video" accept="video/*" onchange="previewVideo()">
                                <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i></label>
                            </div>


                            <div class="d-flex">
                                <textarea placeholder="Type in your message" class="form-control" id="message" rows="3" oninput="toggleButtons()"></textarea>
                                <div class="button-container">
                                    <button type="button" class="voice-note" onmousedown="startRecording('voice')" onmouseleave="cancelRecording()">
                                        <i class="bi bi-mic"></i>
                                    </button>
                                    <button type="button" class="video-note" onmousedown="startRecording('video')" onmouseleave="cancelRecording()">
                                        <i class="bi bi-camera-video"></i>
                                    </button>
                                </div>
                                <div id="sound-visualizer" class="boxContainer">
                                    <div class="box box1"></div>
                                    <div class="box box2"></div>
                                    <div class="box box3"></div>
                                    <div class="box box4"></div>
                                    <div class="box box5"></div>
                                </div>
                                <div id="video-box" class="video-box">
                                    <video id="video-stream"></video>
                                </div>
                                <div id="loader" class="loader">
                                    <img src="icons/internet.gif">
                                </div>
                                <button type="submit" class="submit" id="send-button" style="display: none;">
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <button id="sidebar-toggle" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                    <i class="bi bi-chat"></i>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
                        <button type="button" class="btn-close text-reset close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="list-unstyled">
                            <li>
                                <div class="passport">
                                    <a data-bs-toggle="modal" data-bs-target="#profilepicturemodal">
                                        <img>
                                    </a>
                                </div>
                                <div class="name">
                                    <span>
                                        <a></a>
                                    </span>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div id="createGroupIcon">
                        <button class="CreateGp" type="button" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                            <i class="fas fa-pen"></i>
                        </button>
                    </div>
                </div>

            </div>
            <!-- Ringing Box -->
            <div class="ringing-box" id="ringingBox">
                <div class="main">
                    <div class="profilering">
                        <div class="nameDiv">
                            <h2><?php echo $GroupName; ?></h2>
                        </div>
                        <div class="status">
                            <h2>Incoming Call</h2>
                        </div>
                        <div class="imageDiv">
                            <img src="<?php echo $GroupPic ?>" alt="profile pic">
                        </div>
                    </div>
                    <div class="buttons">
                        <div class="reject">
                            <button id="hangup_button_pop" class="rejectBtn"><i class="bi bi-telephone-x"></i></button>
                        </div>
                        <div class="answer">
                            <button id="answer_button" class="answerBtn"><i class="bi bi-telephone"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="callInterface" style="display: none;">
        <div class="callmain" id="callmain">
            <div class="info-container">
                <?php
                include 'db.php';

                $UserId = $_SESSION['UserId'];

                $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$groupId'";
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
                    <video class="video-player remote" id="<?php echo $groupId; ?>" autoplay playsinline></video>
                </div>

                <div class="over" id="over">
                    <img id="recipientPassport" height="50" width="50" src="<?php echo $recipientPassport ?>">
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
            </div>
        </div>
    </div>
    <div class="modal fade" id="createGroupModal" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">
                        <legend>Group Information</legend>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="grp 1">
                        <input type="text" class="form-control" id="GroupName" placeholder="Group Name">
                    </div>
                    <div class="grp 2">
                        <input type="text" class="form-control" id="searchUser" placeholder="Search by UserId, Surname, or First Name">
                    </div>
                    <div id="searchResults"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closeGrp" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary SubmitGrp" data-bs-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <script></script> -->


    <!-- <script> </script> -->

    <script>
        var userB = '<?php echo $_GET["groupId"]; ?>';
        console.log(userB);
        var UserId = '<?php echo $_SESSION["UserId"]; ?>';
        console.log(UserId);
    </script>

    <script>
        document.getElementById('searchUser').addEventListener('input', function() {
            var searchValue = this.value.trim();
            fetch('search_users.php?search=' + encodeURIComponent(searchValue))
                .then(response => response.text())
                .then(data => {
                    document.getElementById('searchResults').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        });
    </script>

    </script>


    <script>
        function resetTheme() {
            localStorage.removeItem('messageSentcolor');
            localStorage.removeItem('messageReceivedcolor');
            localStorage.removeItem('messageSentTheme');
            localStorage.removeItem('messageReceivedTheme');
            localStorage.removeItem('dropHeaderTheme');
            localStorage.removeItem('chatboxTheme');
            location.reload(); // Reload the page to apply the default theme
        }
    </script>
    <script>
        var sidebarToggle = document.getElementById('sidebar-toggle');

        sidebarToggle.addEventListener('mousedown', function(e) {
            var posX = e.clientX - sidebarToggle.offsetLeft;
            var posY = e.clientY - sidebarToggle.offsetTop;

            document.addEventListener('mousemove', moveButton);

            function moveButton(e) {
                sidebarToggle.style.left = (e.clientX - posX) + 'px';
                sidebarToggle.style.top = (e.clientY - posY) + 'px';
            }

            document.addEventListener('mouseup', function() {
                document.removeEventListener('mousemove', moveButton);
            });
        });
    </script>
    <script>
        function savechatheaderTheme(theme) {
            localStorage.setItem('dropHeaderTheme', theme);
        }

        function applychatheaderTheme(theme) {
            var chatheader = document.querySelector('.chat-header');
            chatheader.style.backgroundColor = theme;
        }

        var savedDropdownTheme = localStorage.getItem('dropHeaderTheme');
        if (savedDropdownTheme) {
            applychatheaderTheme(savedDropdownTheme);
        }

        var chatHeader = document.querySelector('.chat-header');

        chatHeader.addEventListener('contextmenu', function(event) {
            event.preventDefault();

            var existingDropdownMenus = document.querySelectorAll('.dropdown-menu');
            existingDropdownMenus.forEach(function(dropdownMenu) {
                if (dropdownMenu !== chatHeader.querySelector('.dropdown-menu')) {
                    dropdownMenu.remove();
                }
            });

            var changeThemeOption = document.createElement('div');
            changeThemeOption.textContent = 'Change header Theme';
            changeThemeOption.classList.add('dropdown-option');

            var dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu', 'change');
            dropdownMenu.appendChild(changeThemeOption);

            chatHeader.appendChild(dropdownMenu);

            var rect = event.target.getBoundingClientRect();
            dropdownMenu.style.top = '130px';
            dropdownMenu.style.right = '400px';
            dropdownMenu.style.zIndex = '9999';
            dropdownMenu.style.display = 'block';

            changeThemeOption.addEventListener('click', function() {
                var newColor = prompt('Enter a background color:');
                if (newColor !== null && newColor.trim() !== '') {
                    chatHeader.style.backgroundColor = newColor;
                    savechatheaderTheme(newColor);
                    applychatheaderTheme(newColor);
                }
            });

            document.addEventListener('click', function(event) {
                if (!dropdownMenu.contains(event.target) && !chatHeader.contains(event.target)) {
                    dropdownMenu.remove();
                }
            });
        });
    </script>

    <script>
        function savebackgroundTheme(theme) {
            localStorage.setItem('chatboxTheme', theme);
        }

        function applybackgroundTheme(theme) {
            var chatboxes = document.querySelectorAll('.chatbox, .chat-container');

            chatboxes.forEach(function(chatbox) {
                chatbox.style.backgroundColor = theme;
            });
        }

        var savedChatboxTheme = localStorage.getItem('chatboxTheme');
        if (savedChatboxTheme) {
            applybackgroundTheme(savedChatboxTheme);
        }

        document.addEventListener('contextmenu', function(event) {
            if (event.target.closest('.chat-header')) {
                return;
            }
            var clickedElement = event.target;

            var chatbox = document.querySelector('.chatbox');
            var chatcontainer = document.querySelector('.chat-container');

            if (chatbox) {
                event.preventDefault();

                var changeThemeOption = document.createElement('div');
                changeThemeOption.textContent = 'Change Theme';
                changeThemeOption.classList.add('theme-option');

                var backgrounds = document.createElement('div');
                backgrounds.classList.add('changebackground');
                backgrounds.appendChild(changeThemeOption);

                chatbox.appendChild(backgrounds);

                var rect = event.target.getBoundingClientRect();
                backgrounds.style.top = '130px';
                backgrounds.style.right = '600px';

                changeThemeOption.addEventListener('click', function() {
                    var newColor = prompt('Enter a new background color:');
                    if (newColor !== null && newColor.trim() !== '') {
                        chatbox.style.backgroundColor = newColor;
                        chatcontainer.style.backgroundColor = newColor;
                        savebackgroundTheme(newColor);
                        applybackgroundTheme(newColor);
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!backgrounds.contains(e.target)) {
                        backgrounds.remove();
                    }
                });
            }
        });
    </script>


    <script>
        function saveSentmessagebackgroundTheme(theme) {
            localStorage.setItem('messageSentcolor', theme);
        }

        function saveReceivedmessagebackgroundTheme(theme) {
            localStorage.setItem('messageReceivedcolor', theme);
        }

        function applySentmessagesbackgroundTheme(theme) {
            var sentbackground = document.querySelectorAll('.Sent');
            sentbackground.forEach(function(message) {
                message.style.backgroundColor = theme;
            });
        }

        function applyReceivedmessagesbackgroundTheme(theme) {
            var receivedbackground = document.querySelectorAll('.received');
            receivedbackground.forEach(function(message) {
                message.style.backgroundColor = theme;
            });
        }

        function saveSentmessageTheme(theme) {
            localStorage.setItem('messageSentTheme', theme);
            console.log('saved');
        }

        function saveReceivedmessageTheme(theme) {
            localStorage.setItem('messageReceivedTheme', theme);
            console.log('saved');
        }

        function applySentmessagesTheme(theme) {
            var sent = document.querySelectorAll('.Sent');
            sent.forEach(function(message) {
                message.style.background = theme;
            });
        }

        function applyReceivedmessagesTheme(theme) {
            var received = document.querySelectorAll('.received');
            received.forEach(function(message) {
                message.style.background = theme;
            });
        }


        var lastTimestamp = Date.now();

        function isSameDay(date1, date2) {
            return (
                date1.getDate() === date2.getDate() &&
                date1.getMonth() === date2.getMonth() &&
                date1.getFullYear() === date2.getFullYear()
            );
        }

        function getFormattedDate(date) {
            return date.toDateString();
        }

        function formatTime(time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);

            minutes = String(minutes).padStart(2, "0");
            seconds = String(seconds).padStart(2, "0");

            return minutes + ":" + seconds;
        }
        // isToday(date);
        var lastDisplayedDate = null;
        var groupId = '<?php echo $_GET['groupId']; ?>';
        const sessionId = "<?php echo $sessionID ?>";
        var UserId = "<?php echo $_SESSION['UserId']; ?>";
        var socketUrl = 'http://localhost:8888';
        const socket = io(socketUrl, {
            query: {
                UserId,
                groupId,
                sessionId,
            }
        });
        let callIdGlobal;
        let attemptsForChats = 0;
        socket.on('connect', () => {
            console.log('Socket.IO connection established');
            socket.emit('userConnected', UserId);
            if (attemptsForChats === 0) {
                socket.emit('fetchMessageForEachUser', {
                    UserId,
                    groupId
                });
                fetchLastSeenMessageId();
                fetchUserProfileData(groupId);
                fetchPoeple(UserId);
                attemptsForChats++;
            } else {
                console.log('Reconnected');
            }
            var offlineMessages = JSON.parse(localStorage.getItem('offlineMessages'));
            if (offlineMessages && offlineMessages.length > 0) {
                offlineMessages.forEach(function(message) {
                    socket.emit('newMessages', message);
                });
                localStorage.removeItem('offlineMessages');
            }
        });

        socket.on('disconnect', () => {
            socket.emit('userDisconnected', UserId);
        });
        socket.on('messageRead', (chatId, groupId) => {
            console.log('This message has been read', chatId);
        });
        async function getLastMessageIdFromChatHistory() {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('UserId', UserId);
                formData.append('groupId', groupId);

                fetch('http://localhost:8888/LastIdSeen', {
                        method: 'POST',
                        body: formData,
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error('Error checking last seen message');
                        }
                        return response.json();
                    })
                    .then((result) => {
                        if (result) {
                            resolve(result.lastId);
                        } else {
                            return null;
                        }
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }

        async function setChatboxScrollPositionToLastSeen(lastSeenMessageId) {
            const chatbox = document.querySelector('.chatbox');

            function waitForElementToExist(elementId, maxAttempts, interval, callback) {
                let attempts = 0;

                function checkElement() {
                    console.log('this is the element Id', elementId);
                    const element = document.getElementById(elementId);
                    attempts++;

                    if (element) {
                        callback(element);
                    } else if (attempts < maxAttempts) {
                        setTimeout(checkElement, interval);
                    } else {
                        console.error(`Element with ID '${elementId}' not found after ${maxAttempts} attempts.`);
                    }
                }

                checkElement();
            }

            waitForElementToExist(lastSeenMessageId, 10, 1000, (lastSeenMessage) => {
                if (lastSeenMessage) {
                    const position = lastSeenMessage.offsetTop + lastSeenMessage.clientHeight;
                    chatbox.scrollTop = position;
                    console.log(position, lastSeenMessage.offsetTop, lastSeenMessage.clientHeight);

                    // const redLine = document.createElement('div');
                    // redLine.style.width = '100%';
                    // redLine.style.height = '2px';
                    // redLine.style.backgroundColor = 'red';
                    // redLine.style.position = 'absolute';
                    // redLine.style.top = position + 'px';
                    // chatbox.appendChild(redLine);
                } else {
                    console.log('Message container not found');
                }
            });

        }
        let lastSeenMessageId = 'CHAT' + UserId + groupId;
        async function fetchLastSeenMessageId() {
            try {
                const lastSeenMessageIdFromServer = await getLastMessageIdFromChatHistory();
                console.log('This is the last Id', lastSeenMessageIdFromServer);
                const chatbox = document.getElementById('chatbox');

                if (lastSeenMessageIdFromServer && lastSeenMessageId) {
                    const lastSeenMessageIdNum = parseInt(lastSeenMessageId);
                    const lastSeenMessageIdFromServerNum = parseInt(lastSeenMessageIdFromServer);

                    lastSeenMessageId = lastSeenMessageIdFromServer;
                    if (lastSeenMessageIdFromServer != null) {
                        setChatboxScrollPositionToLastSeen(lastSeenMessageId);
                    } else {
                        chatbox.scrollTop = chatbox.scrollHeight;
                    }

                }

            } catch (error) {
                console.log('Error finding last seen message ID', error);
            }
        }
        var recipientPassport = document.querySelector('.recipientPassport');
        var icon = document.querySelector('.icon');

        async function fetchUserProfileData(groupId) {
            try {
                const response = await fetch(`http://localhost:8888/getUserProfile/${groupId}`);
                if (response.ok) {
                    const userProfileData = await response.json();
                    if (userProfileData.Passport != null) {
                        var passDef = 'UserPassport/' + userProfileData.Passport;
                    } else {
                        passDef = 'UserPassport/DefaultImage.png'
                    }
                    recipientPassport.src = passDef;
                    icon.textContent = userProfileData.Surname + " " + userProfileData.First_Name;
                    icon.href = 'user_profile.php?UserId=' + groupId;
                } else {
                    throw new Error('Error fetching user profile data');
                }
            } catch (error) {
                console.error(error);
                return null;
            }
        }
        var passport = document.querySelector('.passport');
        var passportModal = passport.querySelector('a');
        var passportModalImg = passportModal.querySelector('img');

        var NameOfP = document.querySelector('.name');
        var NameOfPSpan = NameOfP.querySelector('span');
        var NameOfPSpanA = NameOfPSpan.querySelector('a');

        async function fetchPoeple(UserId) {
            try {
                const response = await fetch(`http://localhost:8888/getPeople/${UserId}`);
                if (response.ok) {
                    const userData = await response.json();
                    console.log('This are the users data', userData);
                    if (userData) {
                        userData.forEach((result) => {
                            if (result.Passport != null) {
                                var passUser = 'UserPassport/' + result.Passport;
                            } else {
                                passUser = 'UserPassport/DefaultImage.png';
                            }

                            passportModalImg.src = passUser;
                            passportModalImg.alt = result.UserId;
                            NameOfPSpanA.textContent = `${result.Surname} ${result.FirstName}`;
                            NameOfPSpanA.href = 'chat.php?UserId=', result.UserId;
                        });
                    } else {
                        passUser = 'UserPassport/DefaultImage.png';
                        passportModalImg.src = passUser;
                        passportModalImg.alt = 'New User';
                        NameOfPSpanA.textContent = `Talk to new people`;
                    }

                } else {
                    throw new Error('Error fetching user data');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function playpauseVideoNotes() {
            var VideoNotes = document.querySelectorAll('.video_note');
            console.log('this is the length of the video notes', VideoNotes.length);
            VideoNotes.forEach(function(VideoNote) {
                var videoElement = VideoNote.querySelector('video');
                videoElement.addEventListener('play', function() {
                    console.log('Video started playing');
                    VideoNotes.forEach(function(otherContainer) {
                        if (otherContainer !== VideoNote) {
                            var otherVideo = otherContainer.querySelector('video');
                            if (!otherVideo.paused) {
                                otherVideo.pause();
                                console.log('Paused other video');
                            }
                        }
                    });
                });
            });
        }

        function onlineStats(status) {
            var onlineStatus = document.createElement('div');
            onlineStatus.className = 'onlineStatus';
            onlineStatus.id = 'online-status-' + groupId;
            icon.appendChild(onlineStatus);
            if (status === 'online') {
                onlineStatus.style.boxShadow = 'rgb(11, 220, 77)';
                onlineStatus.style.backgroundColor = 'green';
            } else if (status === 'offline') {
                onlineStatus.style.boxShadow = 'rgb(187, 27, 27)';
                onlineStatus.style.backgroundColor = 'red';
            } else {
                onlineStatus.style.display = 'none';
            }
        }
        socket.on('userStatus', ({
            groupId,
            status
        }) => {
            console.log('this is the status for User', groupId, ':', status);
            onlineStats(status);
        });
        socket.on('missedCall', () => {
            console.log('There is a missed Call')
            checkForCalls();
        });

        let unreadMessageCount = 0;

        socket.on('fetchMessageForEachUser', (data) => {
            checkForCalls();
            console.log('Received messages for each user:');
            const hasUnreadMessages = data.some((result) => result.isRead === 0 && result.senderId === groupId);

            if (hasUnreadMessages) {
                unreadMessageCount = data.filter((result) => result.isRead === 0 && result.senderId === groupId).length;
                console.log('This is the unread status before oepning the page', unreadMessageCount);
                if (unreadMessageCount === 1) {
                    const unreadMessageDiv = document.createElement('div');
                    unreadMessageDiv.className = 'unread-message';
                    unreadMessageDiv.textContent = 'Unread Message';
                    chatbox.appendChild(unreadMessageDiv);
                } else {
                    const unreadMessageDiv = document.querySelector('.unread-message');
                    unreadMessageDiv.textContent = `Unread Messages (${unreadMessageCount})`;
                }
            } else {
                console.log('No unread messages');
            }
            data.forEach((result, index) => {
                console.log(`Received result #${index + 1}:`);
                checkForNewMessages(result);
                playpauseVideoNotes();
            });
        });


        var chatbox = document.querySelector('.chatbox');

        var messages = document.getElementById('message');
        var icon = document.querySelector('.icon');

        var isTypingElement = null;
        messages.addEventListener('keyup', function() {
            socket.emit('typing', {
                UserId,
                groupId
            });
        });

        socket.on('typing', (data) => {
            console.log(`${data.UserId} is typing`);
            if (isTypingElement) {
                icon.removeChild(isTypingElement);
                isTypingElement = null;
            }
            typingTimeout = setTimeout(function() {
                if (isTypingElement) {
                    icon.removeChild(isTypingElement);
                    isTypingElement = null;
                }
            }, 1000);
            isTypingElement = document.createElement('p');
            isTypingElement.className = 'isTyping';
            isTypingElement.innerHTML = `is typing`;
            icon.appendChild(isTypingElement);
        });

        let debouncedMarkMessagesAsRead = debounce(markMessagesAsRead, 500);

        chatbox.addEventListener('scroll', debouncedMarkMessagesAsRead);

        function markMessagesAsRead() {
            const messages = document.querySelectorAll('.message');
            const chatbox = document.getElementById('chatbox');

            messages.forEach((message) => {
                const rect = message.getBoundingClientRect();

                if (rect.top >= 0 && rect.bottom <= chatbox.clientHeight && rect.height / message.clientHeight >= 0.5) {
                    const messageId = message.id;
                    socket.emit('messageRead', {
                        messageId,
                        groupId
                    });
                }
            });
        }

        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        async function updateCallLog(callIdGlobal) {
            console.log(callIdGlobal);
            const formData = new FormData();
            formData.append('UserId', UserId);
            formData.append('CallId', callIdGlobal);
            formData.append('groupId', groupId);
            try {
                const response = await fetch('http://localhost:8888/UpdatingCallLogs', {
                    method: 'POST',
                    body: formData
                });
                const update = await response.json();
                console.log('Missed Call:', update);
            } catch (error) {
                console.error('Error updating calls logs:', error);
            }
        }

        function markCallsAsRead() {
            const calls = document.querySelectorAll('.call');
            const chatbox = document.getElementById('chatbox');

            calls.forEach((message) => {
                const rect = message.getBoundingClientRect();

                if (rect.top >= 0 && rect.bottom <= chatbox.clientHeight && rect.height / message.clientHeight >= 0.5) {
                    const callId = calls.id;
                    socket.emit('CallSeen', {
                        callId,
                        groupId
                    });
                }
            });
        }

        async function checkForCalls() {
            const formData = new FormData();
            formData.append('UserId', UserId);
            formData.append('groupId', groupId);
            try {
                const response = await fetch('http://localhost:8888/checkForCalls', {
                    method: 'POST',
                    body: formData
                });
                const missedCall = await response.json();
                console.log('Missed Call:', missedCall);
                if (missedCall.callsData) {
                    const calls = missedCall.callsData;
                    for (const call of calls) {
                        console.log('This is the main aray', call, 'while this is the status', call.Status);
                        if (call.Seen = '0') {
                            if (call.Status === '0') {
                                console.log('Missed Call found');
                                var div = document.createElement('div');
                                div.classList.add('received');
                                var timestamp = new Date(call.TimeOfCall);
                                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                                div.innerHTML = '<div class="message-container">' +
                                    '<div class="message"><div class = "missedCall call" id="missedCall-' + Math.random() + '">' +
                                    '<p> Missed call from ' + missedCall.UserName + '</p>' +
                                    '</div><div class="timestamp">' + formattedTime + '</div>' + '</div></div></div>';

                            } else if (call.Status === '1') {
                                console.log('Call found');
                                var div = document.createElement('div');
                                var timestamp = new Date(call.TimeOfCall);
                                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                                div.innerHTML = '<div class="message-container">' +
                                    '<div class="message"><div class="AnsweredCall call" id="Call-' + Math.random() + '">' +
                                    '<p>Call from ' + missedCall.UserName + '</p>' +
                                    '</div><div class="timestamp">' + formattedTime + '</div>' + '</div></div></div>';

                            }
                        }
                        chatbox.appendChild(div);
                    }
                } else {
                    console.log('No calls from ', missedCall.UserName)
                }
            } catch (error) {
                console.error('Error checking Missed Call:', error);
            }
            console.log('Checking for missed calls');
            markCallsAsRead();
        }

        function checkForNewMessages(message) {
            var div = document.createElement('div');
            var timestamp = new Date(message.time_sent);

            div.className = message.senderId == "<?php echo $UserId; ?>" ? 'Sent' : 'received';
            var sender = message.senderId
            if (div.className === 'received') {
                var chatId = message.chatId;
                var deletedReceivedMessage = localStorage.getItem('deletedReceivedMessage_' + chatId);
                if (deletedReceivedMessage === 'true') {
                    div.innerHTML = '<div id="' + chatId + '" class="message" data-isRead = "' + message.isRead + '">' + 'You deleted the message' + '</div>';
                    div.style.color = 'red';
                }
            }

            var videoLinkRegex = /(https?:\/\/[^\s]+)/i;
            if (videoLinkRegex.test(message.message)) {
                var videoURL = message.message.match(videoLinkRegex)[0];
                var videoLink = '<a href="' + videoURL + '" target="_blank">' + videoURL + '</a>';
                var downloadLink = '<a href="' + videoURL + '" download class="download-button">Download Video</a>';
                var iframeContent = ` <!DOCTYPE html> <html> <head> </head> <body> <a href="${videoURL}" target="_blank">${videoURL}</a> <br> <img src="${videoURL}" alt="Thumbnail" class="thumbnail"> <br> <a href="${videoURL}" download class="download-button">Download Video</a> </body> </html> `;
                div.innerHTML = ` <div class="message-container"> <div class="message" data-isRead="${message.isRead}" id="${message.chatId}"> <iframe srcdoc="${iframeContent}"></iframe> </div> </div>`;

                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
            } else if (message.message !== null) {
                div.innerHTML = '<div class="message-container">' + '<div id="' + message.chatId + '" class="message" data-isRead = "' + message.isRead + '">' + message.message + '</div>';
                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>' + '</div>';
            }


            if (message.sent_image) {
                div.innerHTML += '<div class="message-container">' + '<div id="' + message.chatId + '" class="message">' + '<div id="image-' + message.chatId + '" class="image"><img src="' + message.sent_image + '"></div></div>';
                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>' + '</div>';
            }
            if (message.sent_video) {
                div.innerHTML += '<div class="message-container">' + '<div id="' + message.chatId + '" class="message"><div id="video-container-' + message.chatId + '" class="video-container"><div id="videoplayer"><video width="400" height="400" class="iframe" preload="none" controls autoplay="false"><source src="' + message.sent_video + '" type="video/mp4"></video><button type="button" id="buttonplay" class="btn btn-primary">Watch Video</button></div></div></div>';
                var videoPlayer = div.querySelector('video');
                var playButton = div.querySelector('#buttonplay');
                playButton.addEventListener('click', function() {
                    videoPlayer.style.display = 'block';
                    videoPlayer.play();
                    playButton.style.display = 'none';
                });
                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>' + '</div>';
            }

            if (message.voice_notes) {
                div.innerHTML += '<div class="message-container">' + '<div id="' + message.chatId + '" class="message" data-isRead = "' + message.isRead + '">' + '<div id="voiceNote-' + message.chatId + '" class="voiceNote">' + '<audio id="audio-' + message.chatId + '">' + '<source src="' + message.voice_notes + '" type="audio/webm">' + '</audio>' + '<div class="audio-controls-' + message.chatId + ' audio-controls">' + '<div class="controls-' + message.chatId + ' controls">' + '<div class="speed-' + message.chatId + ' speed">' + '<label for="speed-' + message.chatId + '"></label>' + '<span id="speed-label-' + message.chatId + '">1x</span>' + '</div>' + '<button class="play-pause-' + message.chatId + ' play-pause"></button>' + '</div>' + '<div class="timeline-' + message.chatId + ' timeline">' + '<input type="range" class="timeline-slider-' + message.chatId + ' timeline-slider" min="0" value="0">' + '<div class="progress-' + message.chatId + ' progress"></div>' + '</div>' + '<div class="time-' + message.chatId + ' time">' + '<span class="current-time-' + message.chatId + ' current-time">0:00</span>' + '<span class="divider">/</span>' + '<span class="total-time-' + message.chatId + ' total-time">0:00</span>' + '</div>' + '<div class="volume-' + message.chatId + ' volume">' + '<button class="volume-button-' + message.chatId + ' volume-button"></button>' + '<div class="volume-slider-' + message.chatId + ' volume-slider">' + '<div class="volume-percentage-' + message.chatId + ' volume-percentage"></div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
                const chatId = message.chatId;

                function waitForElementToExist(elementId, maxAttempts, interval, callback) {
                    let attempts = 0;

                    function checkElement() {
                        const element = document.getElementById(elementId);
                        attempts++;

                        if (element) {
                            callback(element);
                        } else if (attempts < maxAttempts) {
                            setTimeout(checkElement, interval);
                        } else {
                            console.error(`Element with ID '${elementId}' not found after ${maxAttempts} attempts.`);
                        }
                    }

                    checkElement();
                }

                waitForElementToExist(chatId, 10, 1000, (messageContainer) => {
                    const voiceNoteContainer = messageContainer.querySelector(".voiceNote");
                    if (voiceNoteContainer) {
                        const audio = voiceNoteContainer.querySelector("#audio-" + chatId);
                        const timeline = voiceNoteContainer.querySelector(".timeline-" + chatId);
                        const progress = voiceNoteContainer.querySelector(".progress-" + chatId);
                        const playPause = voiceNoteContainer.querySelector(".play-pause-" + chatId);
                        const timelineSlider = voiceNoteContainer.querySelector(".timeline-slider-" + chatId);
                        const currentTime = voiceNoteContainer.querySelector(".current-time-" + chatId);
                        const totalTime = voiceNoteContainer.querySelector(".total-time-" + chatId);
                        const volumeButton = voiceNoteContainer.querySelector(".volume-button-" + chatId);
                        const volumeSlider = voiceNoteContainer.querySelector(".volume-slider-" + chatId);
                        const volumePercentage = voiceNoteContainer.querySelector(".volume-percentage-" + chatId);
                        const speedButton = voiceNoteContainer.querySelector(".speed-" + chatId);
                        const speedLabel = voiceNoteContainer.querySelector("#speed-label-" + chatId);
                        const speedOptions = [1, 1.5, 2];
                        let currentSpeedIndex = 0;

                        audio.addEventListener("loadedmetadata", () => {
                            totalTime.innerHTML = formatTime(audio.duration);
                            audio.volume = 0.75;
                            volumePercentage.style.width = audio.volume * 100 + "%";
                        });
                        audio.addEventListener("canplaythrough", () => {
                            totalTime.innerHTML = formatTime(audio.duration);
                        });
                        audio.addEventListener("ended", () => {
                            audio.currentTime = 0;
                            playPause.classList.remove("paused");
                            progress.style.width = "0";
                            currentTime.textContent = formatTime(audio.currentTime);
                        });

                        timeline.addEventListener("input", () => {
                            const timeToSeek = (timeline.value / 100) * audio.duration;
                            audio.currentTime = timeToSeek;
                        });

                        playPause.addEventListener("click", () => {
                            if (audio.paused) {
                                audio.play();
                                playPause.classList.add("paused");
                            } else {
                                audio.pause();
                                playPause.classList.remove("paused");
                            }
                        });

                        audio.addEventListener("timeupdate", () => {
                            const percent = (audio.currentTime / audio.duration) * 100;
                            progress.style.width = percent + "%";
                            // console.log('Progess', percent);
                            currentTime.textContent = formatTime(audio.currentTime);
                            timelineSlider.value = percent;
                        });

                        timelineSlider.addEventListener("input", () => {
                            const percent = timelineSlider.value;
                            const timeToSeek = (percent / 100) * audio.duration;
                            audio.currentTime = timeToSeek;
                        });
                        volumeButton.addEventListener("click", () => {
                            audio.muted = !audio.muted;
                            updateVolumeIcon();
                        });

                        volumeSlider.addEventListener("click", e => {
                            const sliderWidth = window.getComputedStyle(volumeSlider).width;
                            const newVolume = e.offsetX / parseInt(sliderWidth);
                            audio.volume = newVolume;
                            volumePercentage.style.width = newVolume * 100 + "%";
                            updateVolumeIcon();
                        });

                        speedButton.addEventListener("click", () => {
                            currentSpeedIndex = (currentSpeedIndex + 1) % speedOptions.length;
                            audio.playbackRate = speedOptions[currentSpeedIndex];
                            speedLabel.textContent = speedOptions[currentSpeedIndex] + "x";
                        });

                        function updateVolumeIcon() {
                            volumeButton.classList.remove("volume-off", "volume-low", "volume-high");
                            if (audio.muted) {
                                volumeButton.classList.add("volume-off");
                            } else if (audio.volume < 0.5) {
                                volumeButton.classList.add("volume-low");
                            } else {
                                volumeButton.classList.add("volume-high");
                            }
                        }

                        function getTimeCodeFromNum(num) {
                            const hours = Math.floor(num / 3600);
                            const minutes = Math.floor((num % 3600) / 60);
                            const seconds = Math.floor(num % 60);
                            return hours + ":" + String(minutes).padStart(2, "0") + ":" + String(seconds).padStart(2, "0");
                        }
                    } else {
                        console.log("Voice note container not found");
                    }
                });

                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>' + '</div>';
            }
            if (message.video_notes) {
                div.innerHTML = ` <div class="message-container"> <div id="${message.chatId}" class="message" style="background-color: transparent;" data-isRead="${message.isRead}"> <div class="video_note" id="video_note-${message.chatId}"> <video id="video-note-${message.chatId}" src="${message.video_notes}" autoplay="true"></video> </div> <div class="totalTimeVN"> <div class="current-time" id="current-time-${message.chatId}">0:00</div> <div class="slash">/</div> <div class="total-duration" id="total-${message.chatId}">0:00</div> </div> </div> </div> `;
                const chatId = message.chatId;

                function waitForElementToExist(elementId, maxAttempts, interval, callback) {
                    let attempts = 0;
                    console.log('Amount of attempts', attempts);

                    function checkElement() {
                        const element = document.getElementById(elementId);
                        attempts++;

                        if (element) {
                            callback(element);
                        } else if (attempts < maxAttempts) {
                            setTimeout(checkElement, interval);
                        } else {
                            console.error(`Element with ID '${elementId}' not found after ${maxAttempts} attempts.`);
                        }
                    }

                    checkElement();
                }

                waitForElementToExist(chatId, 10, 1000, (messageContainer) => {
                    const videoNoteContainer = messageContainer.querySelector(".video_note");
                    if (videoNoteContainer) {
                        const videoElement = document.querySelector("#video-note-" + chatId);
                        const CurentTime = document.querySelector("#current-time-" + chatId);
                        const Total = document.querySelector("#total-" + chatId);
                        videoElement.addEventListener("loadedmetadata", function() {
                            const duration = videoElement.duration;
                            Total.innerHTML = formatTime(duration);
                            console.log('This is the duration of Vn with chatId', message.chatId, 'is', duration);
                        });
                        videoElement.addEventListener("canplaythrough", function() {
                            const duration = videoElement.duration;
                            Total.innerHTML = formatTime(duration);
                        });
                        videoElement.addEventListener('click', () => {
                            if (!videoElement.paused) {
                                videoElement.pause();
                                console.log('Video paused');
                            } else {
                                videoElement.play();
                                videoElement.muted = false;
                                console.log('Video started playing');
                            }
                        });

                        function formatTime(seconds) {
                            const minutes = Math.floor(seconds / 60);
                            const secs = Math.floor(seconds % 60);
                            return `${minutes}:${secs < 10 ? "0" : ""}${secs}`;
                        }
                        console.log(Total.innerHTML);

                        videoElement.addEventListener("timeupdate", () => {
                            CurentTime.innerHTML = formatTime(videoElement.currentTime);
                        });
                    } else {
                        console.log("video note container not found");
                    }
                });

                var timestamp = new Date(message.time_sent);
                var formattedTime = timestamp.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>' + '</div>';
            }



            if (!lastDisplayedDate || !isSameDay(timestamp, lastDisplayedDate)) {
                var dateDiv = document.createElement('div');
                dateDiv.className = 'date';
                dateDiv.textContent = getFormattedDate(timestamp);
                chatbox.appendChild(dateDiv);
                lastDisplayedDate = timestamp;
            }

            chatbox.appendChild(div);


            lastDisplayedDate = timestamp;

            var savedSentmessagecolorTheme = localStorage.getItem('messageSentcolor');
            if (savedSentmessagecolorTheme) {
                applySentmessagesbackgroundTheme(savedSentmessagecolorTheme);
            }
            var savedReceivedmessagecolorTheme = localStorage.getItem('messageReceivedcolor');
            if (savedReceivedmessagecolorTheme) {
                applyReceivedmessagesbackgroundTheme(savedReceivedmessagecolorTheme);
            }
            var SavedmessageSentTheme = localStorage.getItem('messageSentTheme');
            if (SavedmessageSentTheme) {
                applySentmessagesTheme(SavedmessageSentTheme);
            }
            var SavedmessageReceivedTheme = localStorage.getItem('messageReceivedTheme');
            if (SavedmessageReceivedTheme) {
                applyReceivedmessagesTheme(SavedmessageReceivedTheme);
            }

            var messageDivs = document.querySelectorAll('.message');
            messageDivs.forEach(function(div) {
                div.addEventListener('contextmenu', function(e) {
                    e.preventDefault();
                    var clickedClass = e.target.parentNode.className;
                    var clickedId = e.target.parentNode.id;
                    var existingPopups = document.querySelectorAll('.popup');
                    existingPopups.forEach(function(popup) {
                        popup.remove();
                    });

                    var clickedClass = e.target.parentNode.className;


                    var popup = document.createElement('div');
                    popup.className = 'popup';
                    popup.setAttribute('data-chat-id', div.id);
                    popup.innerHTML = '<a class="delete" href="#">Delete</a><a class="edit" href="#">Edit</a><a class="reply" href="#">Reply</a><a class="change-theme" href="#">Change Theme</a>';
                    var chatId = popup.getAttribute('data-chat-id');
                    // alert(div.id);
                    var messageRect = e.target.getBoundingClientRect();
                    var chatboxRect = chatbox.getBoundingClientRect();

                    var popupTop = messageRect.top - chatboxRect.top + messageRect.height / 2 - popup.offsetHeight / 2;
                    var popupLeft;
                    if (clickedClass === 'Sent') {
                        popupLeft = messageRect.left - chatboxRect.left - popup.offsetWidth;
                    } else if (clickedClass === 'received') {
                        popupLeft = messageRect.left - chatboxRect.left + messageRect.width;
                    }
                    popup.style.top = popupTop + 'px';
                    popup.style.left = popupLeft + 'px';
                    var deleteBtn = popup.querySelector('.delete');
                    deleteBtn.addEventListener('click', function() {
                        var chatId = popup.getAttribute('data-chat-id');
                        var senderId = message.senderId;
                        var currentUserId = "<?php echo $UserId; ?>";
                        console.log(currentUserId)
                        var isSentMessage = senderId === currentUserId;

                        if (isSentMessage = true) {
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'delete_message.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                            var formData = 'chatId=' + encodeURIComponent(chatId);

                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log('Response:', xhr.responseText);
                                    var response = JSON.parse(xhr.responseText);
                                    var message = response.message;

                                    var deletedMessage = document.getElementById(chatId);
                                    deletedMessage.innerHTML = 'You deleted this message';
                                    deletedMessage.class = 'message';
                                    deletedMessage.style.color = 'red';
                                    alert(message);
                                    popup.style.display = 'none';
                                }
                            };

                            xhr.send(formData);
                        } else {
                            var deletedMessage = document.getElementById(chatId);
                            deletedMessage.innerHTML = 'You deleted the message';
                            deletedMessage.style.color = 'red';
                            localStorage.setItem('deletedReceivedMessage_' + chatId, 'true'); // Save the setting
                            popup.style.display = 'none';
                        }
                    });


                    var replyBtn = popup.querySelector('.reply');
                    replyBtn.addEventListener('click', function() {
                        // TODO: Implement reply functionality
                        // Show a reply form for the user to enter a reply message
                    });

                    var editBtn = popup.querySelector('.edit');
                    if (message.message === null) {
                        editBtn.style.display = 'none';
                    } else {
                        editBtn.addEventListener('click', function() {

                        });
                    }

                    var changeThemeBtn = popup.querySelector('.change-theme');
                    changeThemeBtn.addEventListener('click', function() {
                        var changeThemeOptions = popup.querySelector('.change-theme-options');
                        if (changeThemeOptions) {
                            changeThemeOptions.remove();
                        } else {
                            var changeThemeOptions = document.createElement('div');
                            changeThemeOptions.className = 'change-theme-options';
                            changeThemeOptions.innerHTML = '<a class="background-gradient" href="#">Change Background</a><a class="background-color" href="#">Change Background Color</a>';
                            popup.appendChild(changeThemeOptions);

                            var backgroundBtn = popup.querySelector('.background-gradient');
                            backgroundBtn.addEventListener('click', function(e) {
                                var newColor = prompt('Enter a new background gradient:');
                                if (newColor !== null && newColor.trim() !== '') {
                                    if (clickedClass === 'Sent') {
                                        var sentElements = document.querySelectorAll('.Sent');
                                        sentElements.forEach(function(element) {
                                            element.style.background = newColor;
                                            saveSentmessageTheme(newColor);
                                            applySentmessagesTheme(newColor);
                                        });
                                    } else if (clickedClass === 'received') {
                                        var receivedElements = document.querySelectorAll('.received');
                                        receivedElements.forEach(function(element) {
                                            element.style.background = newColor;
                                            saveReceivedmessageTheme(newColor);
                                            applyReceivedmessagesTheme(newColor);
                                        });
                                    }
                                }
                            });



                            var backgroundcolorBtn = popup.querySelector('.background-color');
                            backgroundcolorBtn.addEventListener('click', function(e) {
                                var newColor = prompt('Enter a new background color:');
                                if (newColor !== null && newColor.trim() !== '') {
                                    if (clickedClass === 'Sent') {
                                        var sentElements = document.querySelectorAll('.Sent');
                                        sentElements.forEach(function(element) {
                                            element.style.backgroundColor = newColor;
                                            saveSentmessagebackgroundTheme(newColor);
                                            applySentmessagesbackgroundTheme(newColor);
                                        });
                                    } else if (clickedClass === 'received') {
                                        var receivedElements = document.querySelectorAll('.received');
                                        receivedElements.forEach(function(element) {
                                            element.style.backgroundColor = newColor;
                                            saveRecievedmessagebackgroundTheme(newColor);
                                            applyReceivedmessagesbackgroundTheme(newColor);
                                        });
                                    }
                                }
                            });
                        }
                    });
                    chatbox.appendChild(popup);

                    document.addEventListener('click', function(e) {
                        if (popup && !popup.contains(e.target)) {
                            popup.remove();
                        }
                    });
                });
            });
        }


        // calling aspect
        const hangupButtonpop = document.getElementById('hangup_button_pop');
        const answerButton = document.getElementById('answer_button');
        const ringingBox = document.getElementById('ringingBox');
        var UserId = "<?php echo $UserId ?>";
        var groupId = "<?php echo $groupId ?>";
        var peerConnection;
        console.log(sessionId);
        console.log(UserId);
        console.log(groupId);
        var localStream;
        var remoteStream;
        var localVideo = document.getElementById("<?php echo $UserId; ?>");
        var remoteVideo = document.getElementById("<?php echo $groupId; ?>");
        var hangupButton = document.getElementById('hangup_button');
        var audioCallButton = document.getElementById('audio_call_button');
        var videoCallButton = document.getElementById('video_call_button');
        var callerStatusElement = document.getElementById('status');
        var chatInterface = document.getElementById('chatbox');
        var callInterface = document.getElementById('callInterface');
        var callbtn = document.getElementById('callbtn');
        var pendingCandidates = [];
        var ringtone = document.createElement('audio');
        ringtone.id = "ringtone";
        ringtone.loop = true;
        ringtone.src = "ringingtone/ringtone.mp3";
        ringtone.type = "audio/mpeg";
        ringtone.autoplay = false;
        chatInterface.appendChild(ringtone);

        function resetCallUI() {
            hangupButton.disabled = false;
            callerStatusElement.textContent = 'Calling...';
            ringtone.pause();
            ringtone.currentTime = 0;
            ringingBox.style.display = 'none';
        }
        callbtn.addEventListener('click', function() {
            chatInterface.style.display = 'none';
            callInterface.style.display = 'block';
            startVideoCall();
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

        function startPeerConnection(peerConnection) {
            if (!peerConnection) {
                console.error('peerConnection is not initialized');
                return;
            }

            var iceCandidates = [];

            peerConnection.addEventListener('icecandidate', event => {
                console.log('Finding ICE candidate:', event);
                if (event.candidate) {
                    console.log('ICE candidate found:', event.candidate);
                    iceCandidates.push(event.candidate);
                    sendIceCandidates(iceCandidates);
                } else {
                    console.log('ICE candidate gathering complete.');
                }
            });

            peerConnection.addEventListener('iceconnectionstatechange', function() {
                console.log('ICE connection state:', peerConnection.iceConnectionState);
                if (peerConnection.iceConnectionState === 'failed') {
                    console.log('ICE connection state was failed try again:', peerConnection.iceConnectionState);
                }
            });

            peerConnection.addEventListener('datachannel', function(event) {
                // Handle data channel events if needed.
            });

            function sendIceCandidates(iceCandidates) {
                console.log('Sending ICE candidates:', iceCandidates);
                sendMessage({
                    type: 'candidate',
                    candidates: iceCandidates,
                    callerUserId: groupId,
                    callertoUserId: UserId,
                });
            }
        }

        function joinCall(message) {
            ringtone.pause();
            chatInterface.style.display = 'none';
            callInterface.style.display = 'block';
            callerStatusElement.textContent = 'Joining Call';

            var offer = new RTCSessionDescription(message.offer);

            var retryCount = 0;

            function getUserMediaWithRetry(maxRetries, delay) {
                return new Promise(function(resolve, reject) {
                    function attempt() {
                        navigator.mediaDevices
                            .getUserMedia(mediaConstraints)
                            .then(resolve)
                            .catch(function(error) {
                                if (retryCount < maxRetries) {
                                    console.log('Failed to access camera and microphone. Retrying...');
                                    retryCount++;

                                    if (retryCount === 7) {
                                        mediaConstraints = {
                                            audio: true,
                                            video: false
                                        };
                                        console.log('Switching to audio-only mode.');
                                    }

                                    setTimeout(attempt, delay);
                                } else {
                                    reject(error);
                                }
                            });
                    }
                    attempt();
                });
            }

            var mediaConstraints = {
                audio: true,
                video: true
            }; // Initial constraints

            getUserMediaWithRetry(7, 1000)
                .then(function(stream) {
                    localStream = stream;
                    peerConnection = new RTCPeerConnection();
                    console.log('This is the connection', peerConnection);
                    startPeerConnection(peerConnection);
                    stream.getTracks().forEach(function(track) {
                        peerConnection.addTrack(track, stream);
                    });
                    console.log('Local stream added to peer connection');

                    peerConnection
                        .setRemoteDescription(offer)
                        .then(function() {
                            console.log('Remote description set successfully.');

                            if (
                                peerConnection.signalingState === 'have-remote-offer' ||
                                peerConnection.signalingState === 'have-local-pranswer'
                            ) {
                                return peerConnection.createAnswer();
                            } else {
                                throw new Error('Invalid signaling state for creating an answer.');
                            }
                        })
                        .then(function(answer) {
                            return peerConnection.setLocalDescription(answer);
                        })
                        .then(function() {
                            console.log('ICE gathering state:', peerConnection.iceGatheringState);
                            console.log('Local description set successfully.');

                            var sdpAnswer = peerConnection.localDescription;
                            console.log('SDP Answer:', sdpAnswer);

                            sendMessage({
                                type: 'answer',
                                answer: sdpAnswer,
                                mediaConstraints: mediaConstraints,
                                callerUserId: groupId,
                                callertoUserId: UserId,
                            });
                        })
                        .catch(function(error) {
                            console.log('Error handling call offer:', error);
                        });
                    localVideo.srcObject = localStream;
                    callerStatusElement.textContent = 'Exchanging Stream';

                    peerConnection.ontrack = function(event) {
                        if (event.streams && event.streams[0]) {
                            console.log('Received remote stream:', event.streams[0], 'and', event.streams);
                            remoteVideo.srcObject = event.streams[0];
                        }
                    };

                    console.log('Sending local stream as remote stream', localStream);
                })
                .catch(function(error) {
                    console.log('Error accessing camera and microphone:', error);
                });
        }



        function initSignaling() {

            socket.on('message', function(data) {
                var message = JSON.parse(data);
                console.log(message);

                if (message.type === 'offer') {
                    handleIncomingOffer(message);
                } else if (message.type === 'incoming_call') {
                    handleIncomingCall(message);
                } else if (message.type === 'answer') {
                    handleAnswerMessage(message);
                } else if (message.type === 'hangup') {
                    handleHangupMessage(message);
                } else if (message.type === 'candidate') {
                    handleCandidateMessage(message);
                } else if (message.type === 'notAvailable') {
                    handleNotAvailable(message);
                } else if (message.type === 'callId') {
                    handleCallId(message);
                }
            });
        }

        function startVideoCall() {
            var mediaConstraints = {
                video: true,
                audio: true
            };
            var maxRetries = 7;
            var delay = 1000;

            function getUserMediaWithRetry(mediaConstraints, maxRetries, delay) {
                return new Promise(function(resolve, reject) {
                    function attempt() {
                        navigator.mediaDevices.getUserMedia(mediaConstraints)
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

            getUserMediaWithRetry(mediaConstraints, maxRetries, delay)
                .then(function(stream) {
                    localStream = stream;
                    peerConnection = new RTCPeerConnection();
                    console.log('This is the connection', peerConnection);
                    startPeerConnection(peerConnection);
                    stream.getTracks().forEach(function(track) {
                        peerConnection.addTrack(track, stream);
                    });
                    sendCallOffer(mediaConstraints, groupId);

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

            function sendIncomingCallSignal() {
                ringtone.play();
                var message = {
                    type: 'incoming_call',
                    callerUserId: UserId,
                    callertoUserId: groupId,
                };
                sendMessage(message);
            }

            function sendCallOffer(mediaConstraints, groupId) {
                console.log('Call is to be sent to', groupId);
                callerStatusElement.textContent = 'Sending Call Offer';
                var offerOptions = {
                    offerToReceiveAudio: mediaConstraints.audio ? 1 : 0,
                    offerToReceiveVideo: mediaConstraints.video ? 1 : 0
                };

                peerConnection.createOffer(offerOptions)
                    .then(function(offer) {
                        return peerConnection.setLocalDescription(offer);
                    })
                    .then(function() {
                        // console.log('ICE gathering state:', peerConnection.iceGatheringState);
                        var sdpOffer = peerConnection.localDescription;
                        console.log("SDP Offer:", sdpOffer);

                        sendMessage({
                            type: 'offer',
                            offer: sdpOffer,
                            mediaConstraints: mediaConstraints,
                            callerUserId: UserId,
                            callertoUserId: groupId,
                            sessionId: sessionId
                        });
                        sendIncomingCallSignal();
                        callerStatusElement.textContent = 'Sent Call Offer';
                    })
                    .catch(function(error) {
                        console.log('Error creating call offer:', error);
                    });
            }
        }
        async function handleCallId(message) {
            var callId = message.callId;
            if (callId) {
                callIdGlobal = callId;
            } else {
                console.log('No callid in the call package');
            }
        }

        function handleAnswerMessage(message) {
            var answer = new RTCSessionDescription(message.answer);
            var UserId = message.callerUserId;
            console.log(UserId);
            console.log(callIdGlobal);
            updateCallLog(callIdGlobal);
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

            peerConnection.ontrack = function(event) {
                if (event.streams && event.streams[0]) {
                    remoteVideo.srcObject = event.streams[0];
                    callerStatusElement.textContent = 'Exchanging Stream';
                    ringtone.pause();
                    console.log('Received remote stream:', event.streams[0]);
                }
            };

        }


        function handleCandidateMessage(message) {
            console.log('Received candidate:', message.candidate);

            if (!message.candidate || !Array.isArray(message.candidate) || message.candidate.length === 0) {
                console.log('Invalid ICE candidate data:', message.candidate);
                return;
            }

            var callerUserId = message.callerUserId;
            console.log('Incoming candidate from:', callerUserId);

            for (var i = 0; i < message.candidate.length; i++) {
                var rtcCandidate = new RTCIceCandidate(message.candidate[i]);
                peerConnAdd(rtcCandidate);
            }
        }

        function peerConnAdd(rtcCandidate) {
            if (peerConnection) {
                peerConnection
                    .addIceCandidate(rtcCandidate)
                    .catch(function(error) {
                        console.log('Error handling ICE candidate:', error);
                    });
            } else {
                console.log('peerConnection is not properly initialized.');
            }
        }



        function handleHangupMessage(message) {
            var callerUserId = message.callerUserId;
            console.log("Call has been ended from:", callerUserId)
            hangUpCall();
            ringtone.pause();
        }

        function handleNotAvailable(message) {
            var callertoUserId = message.callertoUserId;
            console.log("User not available:", callertoUserId)
            callerStatusElement.textContent = 'User not available';
            const busyTimeout = 5000;
            let busyId;
            busyId = setTimeout(function() {
                hangUpCall();
                ringtone.pause();
            }, busyTimeout);
        }

        function showRingingBox() {
            ringingBox.style.display = 'block';
            playRingtoneOnce();
        }

        function playRingtoneOnce() {
            ringtone.play();
            console.log('ringing tone played');
        }

        function handleIncomingCall(message) {
            var callerUserId = message.callerUserId;
            var callertoUserId = message.callertoUserId;
            console.log('Incoming call from:', callerUserId);

            showRingingBox();
        }

        function resetAudio() {
            ringtone.currentTime = 0;
        }

        function handleIncomingOffer(message) {
            var callerUserId = message.callerUserId;
            console.log('Incoming offer from:', callerUserId);
            const callTimeout = 30000;
            let timeoutID;
            timeoutID = setTimeout(function() {
                console.log('calltime is over');
                hangUpCallChatUI();
                resetAudio();
                sendMessage({
                    type: 'missed',
                    callerUserId: groupId,
                    callertoUserId: UserId,
                    sessionId: sessionId
                });
                ringtone.pause();
            }, callTimeout);

            function handleAnswerButtonClick() {
                clearTimeout(timeoutID);
                ringtone.pause();
                const joinTimeout = 1000;
                let jointimeId;
                jointimeId = setTimeout(function() {
                    joinCall(message);
                    resetAudio();
                }, joinTimeout);
            }

            hangupButtonpop.addEventListener('click', function() {
                console.log('hangup button clicked');
                ringingBox.style.display = 'none';
                clearTimeout(timeoutID);
                hangUpCallChatUI();
                resetAudio();
                ringtone.pause();
            });
            answerButton.addEventListener('click', handleAnswerButtonClick);
        }

        function sendMessage(message) {
            console.log('Message to be sent', message);
            socket.emit('message', JSON.stringify(message));
        }

        function hangUpCallChatUI() {
            sendMessage({
                type: 'hangup',
                callerUserId: UserId,
                callertoUserId: groupId,
            });
            ringingBox.style.display = 'none';
            ringtone.autoplay = false;
            ringtone.pause();
        }
        hangupButton.addEventListener('click', function() {
            hangUpCallChatUI();
            hangUpCall();
        });

        function hangUpCall() {
            localStream.getTracks().forEach(function(track) {
                track.stop();
            });
            updateCallLog(callIdGlobal);
            if (peerConnection) {
                peerConnection.close();
                peerConnection = null;
            }

            hangupButton.disabled = true;
            audioCallButton.disabled = false;
            videoCallButton.disabled = false;
            localVideo.srcObject = null;
            remoteVideo.srcObject = null;
            callerStatusElement.textContent = 'Call Ended';
            chatInterface.style.display = "block";
            callInterface.style.display = "none";
            resetCallUI();
        }
        initSignaling();


        var SendMessageBtn = document.getElementById('send-button');

        SendMessageBtn.addEventListener('click', function() {
            var MessageToBeSent = $('#message').val() || null;
            var imageInput = document.querySelector('.image-input');
            var videoInput = document.getElementById('video');

            var image = null;
            if (imageInput.files.length > 0) {
                image = imageInput.files;
            }

            var video = null;
            if (videoInput.files.length > 0) {
                video = videoInput.files;
            }

            if (socket.connected) {
                socket.emit('newMessages', {
                    UserId,
                    groupId,
                    MessageToBeSent,
                    image,
                    video,
                });
            } else {
                var offlineMessages = localStorage.getItem('offlineMessages') || [];
                offlineMessages.push({
                    UserId,
                    groupId,
                    MessageToBeSent,
                    image,
                    video,
                });
                localStorage.setItem('offlineMessages', JSON.stringify(offlineMessages));
            }

            $('#message').val('');
            $('.image-input').val('');
            $('#video').val('');
        });

        socket.on('newMessage', (newMessage) => {
            console.log('Received data:', newMessage);
            console.log('UserId:', newMessage.UserId);

            const hasUnreadMessages = newMessage.isRead === 0 && newMessage.senderId === groupId;

            if (hasUnreadMessages) {
                unreadMessageCount++;

                if (unreadMessageCount === 1) {
                    const unreadMessageDiv = document.createElement('div');
                    unreadMessageDiv.className = 'unread-message';
                    unreadMessageDiv.textContent = 'Unread Message';
                    chatbox.appendChild(unreadMessageDiv);
                } else {
                    const unreadMessageDiv = document.querySelector('.unread-message');
                    unreadMessageDiv.textContent = `Unread Messages (${unreadMessageCount})`;
                }
            }
            if (newMessage.UserId === UserId) {
                chatbox.scrollTop = chatbox.scrollHeight;
            }
            checkForNewMessages(newMessage);
            playpauseVideoNotes();
        });

        socket.on('ReadStatus', (messageId) => {
            console.log('Received data:', messageId);
            var message = document.getElementById(messageId);
            if (unreadMessageCount > 0) {
                unreadMessageCount--;
            }

            if (unreadMessageCount === 0) {
                var unreadMessageDiv = document.querySelector('.unread-message');
                if (unreadMessageDiv) {
                    chatbox.removeChild(unreadMessageDiv);
                }
            }
        });
        document.getElementById('message').addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                document.getElementById("send-button").click();
            }
        });


        $(chatbox).scroll(function() {
            const distanceFromBottom = $(chatbox)[0].scrollHeight - ($(chatbox).scrollTop() + $(chatbox).outerHeight());

            if (distanceFromBottom > 100) {
                $('#scrollToBottomBtn').fadeIn();
            } else {
                $('#scrollToBottomBtn').fadeOut();
            }
        });

        $('#scrollToBottomBtn').click(function() {
            $(chatbox).animate({
                scrollTop: $(chatbox)[0].scrollHeight
            }, 500);
            return false;
        });



        //voice Notes
        let mediaRecorder;
        let isRecording = false;
        let soundVisualizerInterval;
        let soundVisualizer = document.getElementById('sound-visualizer');
        var videoBox = document.getElementById('video-box');
        var loader = document.getElementById('loader');
        const videoElement = document.getElementById('video-stream');
        let chunks = [];


        function toggleButtons() {
            var message = document.getElementById('message').value.trim();
            var voiceButton = document.querySelector('.voice-note');
            var videoButton = document.querySelector('.video-note');
            var sendButton = document.getElementById('send-button');

            if (message === '') {
                voiceButton.style.display = 'inline-block';
                videoButton.style.display = 'inline-block';
                sendButton.style.display = 'none';
            } else {
                voiceButton.style.display = 'none';
                videoButton.style.display = 'none';
                sendButton.style.display = 'inline-block';
            }
        }
        toggleButtons();
        let startRecordingTime;

        let maxRetries = 7;
        let retryDelay = 1000;

        function startRecording(type) {
            if (isRecording) return;
            isRecording = true;
            loader.style.display = 'block';


            function getMediaStreamWithRetry(retriesLeft, type) {
                navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: type === 'video'
                    })
                    .then(function(stream) {
                        startRecordingTime = Date.now();
                        if (type === 'voice') {
                            soundVisualizer.style.display = 'block';
                            soundVisualizerInterval = setInterval(updateSoundVisualizer, 100);
                            videoBox.style.display = 'none';
                            loader.style.display = 'none';
                        } else if (type === 'video') {
                            loader.style.display = 'none';
                            soundVisualizer.style.display = 'none';
                            videoBox.style.display = 'block';
                        }
                        if (stream.getAudioTracks().length === 0) {
                            console.error('Microphone not providing audio data.');
                            return;
                        }

                        if (type === 'video' && stream.getVideoTracks().length === 0) {
                            console.error('No video tracks available.');
                            return;
                        }
                        mediaRecorder = new MediaRecorder(stream, {
                            mimeType: type === 'video' ? 'video/webm' : 'audio/webm'
                        });
                        if (type === 'video') {
                            videoBox.srcObject = stream;
                        }
                        mediaRecorder.addEventListener('dataavailable', event => {
                            console.log('Data available:', event.data);
                            if (event.data.size > 0) {
                                chunks.push(event.data);
                            }
                        });

                        mediaRecorder.onstop = async function() {
                            isRecording = false;
                            const blob = new Blob(chunks, {
                                type: mediaRecorder.mimeType
                            });
                            console.log('Recording stopped. Blob created:', blob);
                            const recordingDuration = (Date.now() - startRecordingTime) / 1000;
                            const duration = recordingDuration.toFixed(2);
                            console.log('Recording duration:', duration, 'seconds');
                            await submitMedia(blob, type, UserId, groupId);
                            stream.getTracks().forEach(function(track) {
                                track.stop();
                            });
                            chunks = [];
                        };

                        mediaRecorder.start();
                        console.log('Recording started:', type);
                    })
                    .catch(function(error) {
                        if (retriesLeft > 0) {
                            console.error('Error accessing media devices. Retrying...', error);
                            setTimeout(function() {
                                getMediaStreamWithRetry(retriesLeft - 1, type);
                            }, retryDelay);
                        } else {
                            soundVisualizer.style.display = 'none';
                            videoBox.style.display = 'none';
                            console.error('Failed to access media devices after multiple retries:', error);
                        }
                    });
            }
            getMediaStreamWithRetry(maxRetries, type);
        }

        function updateSoundVisualizer(loudness) {
            const spikeContainers = document.querySelectorAll('.boxContainer .box');

            spikeContainers.forEach((spike, index) => {
                const animation = getAnimationForLoudness(loudness, index);
                spike.style.animationName = animation;
            });
        }

        function getAnimationForLoudness(loudness, index) {
            if (loudness < 30) return 'quiet';
            if (loudness < 70) return index % 2 === 0 ? 'normal' : 'quiet';
            const boxContainer = document.getElementById('sound-visualizer');
            boxContainer.style.display = "flex"
            return 'loud';
        }

        function stopRecording(type) {
            if (mediaRecorder && isRecording) {
                mediaRecorder.stop();
            }
        };


        function cancelRecording() {
            if (mediaRecorder && isRecording) {
                mediaRecorder.stop();
                isRecording = false;
                // deleteVoiceNote();
                console.log("To be deleted");
            }
            soundVisualizer.style.display = 'none';
            videoBox.style.display = 'none';
            clearInterval(soundVisualizerInterval);
        }

        async function deleteVoiceNote() {
            const formData = new FormData();
            formData.append('filename', voiceNoteFilename);

            try {
                const response = await fetch('delete_voice_note.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.text();
                console.log('Voice note deleted:', result);
            } catch (error) {
                console.error('Error deleting voice note:', error);
            }
        }


        async function submitMedia(blob, type, UserId, groupId) {

            if (mediaRecorder && isRecording) {
                mediaRecorder.stop();
            }
            videoBox.style.display = 'none';
            soundVisualizer.style.display = 'none';
            console.log('Blob to be submitted:', blob);
            const formData = new FormData();
            formData.append(type === 'video' ? 'video' : 'audio', blob);
            formData.append('recipientId', groupId);
            formData.append('UserId', UserId);

            try {
                const response = await fetch(type === 'video' ? 'http://localhost:8888/sendVideoNote' : 'http://localhost:8888/sendVoiceNote', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('Media saved successfully:', result);
                } else {
                    console.error('Media submission failed:', response.statusText);
                }
            } catch (error) {
                console.error('Error saving media:', error);
            }
        }
    </script>

    <script>
        var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

        if (!UserId) {
            window.location.href = "login.php";
        }
    </script>

    <script>
        function insertEmoji(emoji) {
            var textarea = document.querySelector("#message");
            textarea.value += emoji;
        }
    </script>
    <script>
        function toggleEmojiPicker() {
            var container = document.querySelector(".emoji-table-container");
            if (container.style.display === "none") {
                container.style.display = "block";
            } else {
                container.style.display = "none";
            }
        }
    </script>

    <script>
        function previewImage() {
            var files = document.getElementById('image').files;
            var previewContainer = $('#previewContainer');
            previewContainer.empty();

            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = (function(file) {
                    return function(e) {
                        var activeClass = (previewContainer.children().length === 0) ? 'active' : '';
                        previewContainer.append('<div class="carousel-item ' + activeClass + '"><img src="' + e.target.result + '" class="img-fluid"></div>');
                    };
                })(files[i]);
                reader.readAsDataURL(files[i]);
            }

            var customFile = document.getElementById('image-custom-file');
            customFile.dataset.bsToggle = 'modal';
            customFile.dataset.bsTarget = '#image-modal';
            customFile.click();
        }



        function previewVideo() {
            let fileInput = document.querySelector('.video-input');
            let file = fileInput.files[0];
            let videoPreview = document.querySelector('#video-preview');
            let videoModal = document.querySelector('#video-modal');
            let closeModal = videoModal.querySelector('.close');
            let reader = new FileReader();
            reader.addEventListener('load', function() {
                videoPreview.src = reader.result;
                videoModal.style.display = 'block';
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
            closeModal.addEventListener('click', function() {
                videoModal.style.display = 'none';
                videoPreview.src = '';
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                if (value === "") {
                    $("#user_table").html("");
                } else {
                    $("#user_table tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                }
            });
        });
    </script>
    <script>
        const searchBox = document.getElementById('search');
        const resultsDiv = document.getElementById('user_table');
        searchBox.addEventListener('input', function() {
            const searchTerm = this.value;
            if (!searchTerm.trim()) {
                resultsDiv.innerHTML = '';
                return;
            }
            $("#search").on("keyup", function() {
                var search_query = $(this).val();
                $.ajax({
                    url: "searchbackend.php",
                    method: "POST",
                    data: {
                        search_query: search_query
                    },
                    success: function(data) {
                        $("#user_table").html(data);
                    }
                });
            });
        });
    </script>



    <script>
        var sessionID = "<?php echo $sessionID ?>";

        sessionStorage.setItem('sessionId', sessionID);
    </script>

    <!-- Modal -->
    <div class="modal fade" id="profilepicturemodal" tabindex="-1" role="dialog" aria-labelledby="profilepicturemodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    include 'db.php';
                    // Get the UserId of the user you are talking to
                    $recipientId = $_GET['groupId'];
                    // Fetch the passport image
                    $sql = "SELECT Passport FROM User_Profile WHERE UserId = '$recipientId'";
                    $stmt = sqlsrv_query($conn, $sql);
                    if ($stmt === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }

                    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                    $Passport = $row['Passport'];
                    if (empty($Passport)) {
                        $passportImage = "UserPassport/DefaultImage.png";
                    } else {
                        $passportImage = "UserPassport/" . $Passport;
                    }
                    echo '<img id="modalImg" src="' . $passportImage . '">';

                    ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="preview">
        <div id="image-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="image-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="image-modal-label">Image Preview</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <img src="icons/close.png">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="previewContainer"></div>
                            <a class="carousel-control-prev" href="#carousel" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" id="modalicon" aria-hidden="true"></span>
                                <span class="sr-only"></span>
                            </a>
                            <a class="carousel-control-next" href="#carousel" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" id="modalicon" aria-hidden="true"></span>
                                <span class="sr-only"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="okay" class="btn btn-secondary" data-bs-dismiss="modal">Okay</button>
                    <button type="button" id="dismiss" class="btn btn-secondary ml-auto" data-bs-dismiss="modal">Dismiss</button>
                </div>
            </div>
        </div>
    </div>
    <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="video-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="video-modal-label">Video Preview</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="video-preview" src="#"></video>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>