<?php
session_start();
$UserId = $_SESSION["UserId"];
include 'db.php';
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$UserId'";
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Feed</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <script src="js/jquery.min.js"></script>
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <script src="js/slim.min.js"></script>
    <link rel="stylesheet" href="css/offeyicial.css">


</head>

<body>
    <nav>
        <div class="container">
            <h2 class="logo">
                Offeyicial
            </h2>
            <div class="search-bar">
                <i class="uil uil-search"></i>
                <input type="search" placeholder="Search for post">
            </div>
            <div class="create">
                <label class="btn btn-primary" for="create-post">Create</label>
                <div class="profile-photo">
                    <img src="<?php echo $recipientPassport ?>" alt="">
                </div>
            </div>
        </div>
    </nav>

    <!-------------------------------- MAIN ----------------------------------->
    <main>
        <div class="container">
            <!----------------- LEFT -------------------->
            <div class="left">
                <a class="profile">
                    <div class="profile-photo">
                        <img src="<?php echo $recipientPassport ?>">
                    </div>
                    <div onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'" class="handle">
                        <h4><?php echo $recipientSurname . ' ' . $recipientFirstName ?></h4>
                        <!-- <p class="text-muted">
                            @niaridania
                        </p> -->
                    </div>
                </a>

                <!----------------- SIDEBAR -------------------->
                <div class="sidebar">
                    <a class="menu-item active">
                        <span><i class="uil uil-home"></i></span>
                        <h3>Home</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-compass"></i></span>
                        <h3>Explore</h3>
                    </a>
                    <a class="menu-item" id="notifications">
                        <span><i class="uil uil-bell"><small class="notification-count">9+</small></i></span>
                        <h3>Notification</h3>
                        <!--------------- NOTIFICATION POPUP --------------->
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-2.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Keke Benjamin</b> accepted your friend request
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-3.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>John Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-4.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Marry Oppong</b> and <b>283 Others</b> liked your post
                                    <small class="text-muted">4 Minutes Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-5.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Doris Y. Lartey</b> commented on a post you are tagged in
                                    <small class="text-muted">2 Days Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-6.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Keyley Jenner</b> commented on a post you are tagged in
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-photo">
                                    <img src="./images/profile-7.jpg">
                                </div>
                                <div class="notification-body">
                                    <b>Jane Doe</b> commented on your post
                                    <small class="text-muted">1 Hour Ago</small>
                                </div>
                            </div>
                        </div>
                        <!--------------- END NOTIFICATION POPUP --------------->
                    </a>
                    <a class="menu-item" id="messages-notifications">
                        <span><i class="uil uil-envelope-alt"><small class="notification-count">6</small></i></span>
                        <h3>Messages</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-bookmark"></i></span>
                        <h3>Bookmarks</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-chart-line"></i></span>
                        <h3>Analytics</h3>
                    </a>
                    <a class="menu-item" id="theme">
                        <span><i class="uil uil-palette"></i></span>
                        <h3>Theme</h3>
                    </a>
                    <a class="menu-item">
                        <span><i class="uil uil-setting"></i></span>
                        <h3>Setting</h3>
                    </a>
                </div>
                <!----------------- END OF SIDEBAR -------------------->
                <label class="btn btn-primary" for="create-post">Create Post</label>
            </div>

            <!----------------- MIDDLE -------------------->
            <div class="middle">
                <!----------------- STORIES -------------------->
                <div class="stories">
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-8.jpg">
                        </div>
                        <p class="name">Your Story</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-9.jpg">
                        </div>
                        <p class="name">Lila James</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-10.jpg">
                        </div>
                        <p class="name">Winnie Haley</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-11.jpg">
                        </div>
                        <p class="name">Daniel Bale</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-12.jpg">
                        </div>
                        <p class="name">Jane Doe</p>
                    </div>
                    <div class="story">
                        <div class="profile-photo">
                            <img src="./images/profile-13.jpg">
                        </div>
                        <p class="name">Tina White</p>
                    </div>
                </div>
                <!----------------- END OF STORIES -------------------->
                <form action="" class="create-post">
                    <div class="profile-photo">
                        <img src="./images/profile-1.jpg">
                    </div>
                    <input type="text" placeholder="What's on your mind, <?php echo $recipientFirstName ?> ?" id="create-post">
                    <input type="submit" value="Post" class="btn btn-primary">
                </form>
                <!----------------- FEEDS -------------------->
                <div id="newsFeed">
                </div>
                <div class="feeds">
                </div>
                <!----------------- END OF FEEDS -------------------->
            </div>
            <!----------------- END OF MIDDLE -------------------->

            <!----------------- RIGHT -------------------->
            <div class="right">
                <!------- MESSAGES ------->
                <div class="messages">
                    <div class="heading">
                        <h4>Messages</h4>
                        <i class="uil uil-edit"></i>
                    </div>
                    <!------- SEARCH BAR ------->
                    <div class="search-bar">
                        <i class="uil uil-search"></i>
                        <input type="search" placeholder="Search messages" id="message-search">
                    </div>
                    <!------- MESSAGES CATEGORY ------->
                    <div class="category">
                        <h6 class="active">Primary</h6>
                        <h6>General</h6>
                        <h6 class="message-requests">Requests (7)</h6>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-17.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Edem Quist</h5>
                            <p class="text-muted">Just woke up bruh</p>
                        </div>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-6.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Daniella Jackson</h5>
                            <p class="text-bold">2 new messages</p>
                        </div>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-8.jpg">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Chantel Msiza</h5>
                            <p class="text-muted">lol u right</p>
                        </div>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-10.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Juliet Makarey</h5>
                            <p class="text-muted">Birtday Tomorrow</p>
                        </div>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-3.jpg">
                            <div class="active"></div>
                        </div>
                        <div class="message-body">
                            <h5>Keylie Hadid</h5>
                            <p class="text-bold">5 new messages</p>
                        </div>
                    </div>
                    <!------- MESSAGES ------->
                    <div class="message">
                        <div class="profile-photo">
                            <img src="./images/profile-15.jpg">
                        </div>
                        <div class="message-body">
                            <h5>Benjamin Dwayne</h5>
                            <p class="text-muted">haha got that!</p>
                        </div>
                    </div>
                </div>
                <!------- END OF MESSAGES ------->

                <!------- FRIEND REQUEST ------->
                <div class="friend-requests">
                    <h4>Requests</h4>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="./images/profile-20.jpg">
                            </div>
                            <div>
                                <h5>Hajia Bintu</h5>
                                <p class="text-muted">8 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">
                                Accept
                            </button>
                            <button class="btn">
                                Decline
                            </button>
                        </div>
                    </div>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="./images/profile-18.jpg">
                            </div>
                            <div>
                                <h5>Edelson Mandela</h5>
                                <p class="text-muted">2 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">
                                Accept
                            </button>
                            <button class="btn">
                                Decline
                            </button>
                        </div>
                    </div>
                    <div class="request">
                        <div class="info">
                            <div class="profile-photo">
                                <img src="./images/profile-17.jpg">
                            </div>
                            <div>
                                <h5>Megan Baldwin</h5>
                                <p class="text-muted">5 mutual friends</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary">
                                Accept
                            </button>
                            <button class="btn">
                                Decline
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!----------------- END OF RIGHT -------------------->
        </div>
    </main>

    <!----------------- THEME CUSTOMIZATION -------------------->
    <div class="customize-theme">
        <div class="card">
            <h2>Customize your view</h2>
            <p class="text-muted">Manage your font size, color, and background</p>

            <!----------- FONT SIZE ----------->
            <div class="font-size">
                <h4>Font Size</h4>
                <div>
                    <h6>Aa</h6>
                    <div class="choose-size">
                        <span class="font-size-1"></span>
                        <span class="font-size-2 active"></span>
                        <span class="font-size-3"></span>
                        <span class="font-size-4"></span>
                        <span class="font-size-5"></span>
                    </div>
                    <h3>Aa</h3>
                </div>
            </div>

            <!----------- PRIMARY COLORS ----------->
            <div class="color">
                <h4>Color</h4>
                <div class="choose-color">
                    <span class="color-1 active"></span>
                    <span class="color-2"></span>
                    <span class="color-3"></span>
                    <span class="color-4"></span>
                    <span class="color-5"></span>
                </div>
            </div>

            <!----------- BACKGROUND COLORS ----------->
            <div class="background">
                <h4>Background</h4>
                <div class="choose-bg">
                    <div class="bg-1 active">
                        <span></span>
                        <h5 for="bg-1">Light</h5>
                    </div>
                    <div class="bg-2">
                        <span></span>
                        <h5 for="bg-2">Dim</h5>
                    </div>
                    <div class="bg-3">
                        <span></span>
                        <h5 for="bg-3">Dark</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/index.js"></script>
    <script src="node_modules/socket.io-client/dist/socket.io.js"></script>

    <script>
        var UserId = "<?php echo $_SESSION['UserId']; ?>";
        var socketUrl = 'ws://localhost:8888';
        const socket = io(socketUrl, {
            query: {
                UserId
            }
        });
        let attemptsForPost = 0;

        socket.on('connect', () => {
            console.log('Socket.IO connection established');
            console.log('attempts', attemptsForPost);
            if (attemptsForPost === 0) {
                socket.emit('fetchPosts', UserId);
                // fetchPoeple(UserId);
                attemptsForPost++;
            } else {
                console.log('Reconnected');
            }
        });


        socket.on('posts', (data) => {
            data.forEach((transformedData, index) => {
                console.log(`Received post data #${index + 1}:`);
                console.log('UserId:', transformedData.UserId);
                console.log('surname:', transformedData.surname);
                console.log('firstName:', transformedData.firstName);
                console.log('passport:', transformedData.passport);
                console.log('postId:', transformedData.postId);
                console.log('image:', transformedData.image);
                console.log('video:', transformedData.video);
                console.log('title:', transformedData.title);
                console.log('content:', transformedData.content);
                console.log('timeAgo:', transformedData.timeAgo);
                console.log('datePosted:', transformedData.datePosted);
                console.log('likes:', transformedData.likes);
                loadFeed(transformedData)
                pauseandplayOtherVideo();
            });
        });

        function pauseandplayOtherVideo() {
            var VideoNotes = document.querySelectorAll('.post-video');
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

        function autoplayVid() {
            postItems = document.querySelectorAll('.post-item');
            postItems.forEach(function(postItem) {
                var postVideos = postItem.querySelectorAll('.post-video');
                postVideos.forEach(function(postVideo) {
                    videoElement = postVideo.querySelector('video');
                    videoControls = postVideo.querySelector('.video-controls');
                    videoCtlBtn = videoControls.querySelector('.play');
                    var span = videoCtlBtn.querySelector('span');
                    if (videoElement) {
                        if (postItem.style.display === 'block') {
                            console.log('in position' + postItem.id);
                            videoElement.play();
                            span.innerHTML = "<i class='bi bi-pause-circle-fill'></i>";
                        } else {
                            console.log('out of position' + postItem.id);
                            videoElement.pause();
                            span.innerHTML = "<i class='bi bi-play'></i>";
                        }
                    }
                });
            })
        }


        function loadFeed(result) {
            var feeds = document.querySelector(".feeds");
            var feedDiv = document.createElement('div');
            feedDiv.className = 'feed';

            var headDiv = document.createElement('div');
            headDiv.className = 'head';

            var userDiv = document.createElement('div');
            userDiv.className = 'user';

            var profilePhotoDiv = document.createElement('div');
            profilePhotoDiv.className = 'profile-photo';
            var profileImg = document.createElement('img');
            profileImg.src = result.passport;
            profilePhotoDiv.appendChild(profileImg);

            var infoDiv = document.createElement('div');
            infoDiv.className = 'info';
            infoDiv.href = 'user_profile.php?UserId=' + result.UserId;
            var nameH3 = document.createElement('h3');
            nameH3.textContent = result.firstName + ' ' + result.surname;
            var small = document.createElement('small');
            small.textContent = result.timeAgo;

            infoDiv.appendChild(nameH3);
            infoDiv.appendChild(small);

            userDiv.appendChild(profilePhotoDiv);
            userDiv.appendChild(infoDiv);

            headDiv.appendChild(userDiv);

            var threeDotsDiv = document.createElement('div');
            threeDotsDiv.className = 'dropdown';

            var editSpan = document.createElement('button');
            editSpan.className = 'edit btn btn-link dropdown-toggle';
            editSpan.type = 'button';
            editSpan.id = 'dropdownMenuButton' + result.postId;
            editSpan.setAttribute('data-toggle', 'dropdown');
            editSpan.setAttribute('aria-haspopup', 'true');
            editSpan.setAttribute('aria-expanded', 'false');
            editSpan.innerHTML = '<i class="uil uil-ellipsis-h"></i>';

            var dropdownMenu = document.createElement('div');
            dropdownMenu.className = 'dropdown-menu dropdown-menu-right';
            dropdownMenu.setAttribute('aria-labelledby', 'dropdownMenuButton' + result.postId);

            var blockUserDiv = document.createElement('div');
            blockUserDiv.classList.add('dropdown-item');
            var blockUserButton = document.createElement('button');
            blockUserButton.type = 'button';
            blockUserButton.className = 'btn btn-primary blockUser';
            blockUserButton.id = 'blockUser-' + result.UserId;
            blockUserButton.dataset.recipientid = result.UserId;
            blockUserButton.dataset.postid = result.postId;
            blockUserButton.innerHTML = 'Block User';

            var blockUserInput = document.createElement('input');
            blockUserInput.type = 'hidden';
            blockUserInput.id = 'bu' + result.UserId;
            blockUserInput.value = result.UserId;

            blockUserDiv.appendChild(blockUserButton);
            blockUserDiv.appendChild(blockUserInput);
            dropdownMenu.appendChild(blockUserDiv);

            var blockButtonDiv = document.createElement('div');
            blockButtonDiv.classList.add('dropdown-item');
            var blockButtonButton = document.createElement('button');
            blockButtonButton.type = 'button';
            blockButtonButton.className = 'btn btn-primary blockButton';
            blockButtonButton.id = 'blockButton-' + result.postId;
            blockButtonButton.dataset.recipientid = result.UserId;
            blockButtonButton.dataset.postid = result.postId;
            blockButtonButton.innerHTML = 'Block this type of post';

            var blockButtonInput = document.createElement('input');
            blockButtonInput.type = 'hidden';
            blockButtonInput.id = 'b' + result.postId;
            blockButtonInput.value = result.postId;

            blockButtonDiv.appendChild(blockButtonButton);
            blockButtonDiv.appendChild(blockButtonInput);
            dropdownMenu.appendChild(blockButtonDiv);

            dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
                '<a class="dropdown-item" href="#">Repost post</a>';

            threeDotsDiv.appendChild(editSpan);
            threeDotsDiv.appendChild(dropdownMenu);

            headDiv.appendChild(threeDotsDiv);
            feedDiv.appendChild(headDiv);
            if (result.image && result.image.length > 0) {
                result.image.forEach(function(imagePath) {
                    var postItem = document.createElement('div');
                    postItem.className = 'post-item';

                    var photoDiv = document.createElement('div');
                    photoDiv.className = 'photo';

                    var photoImg = document.createElement('img');
                    photoImg.src = imagePath;
                    photoDiv.appendChild(photoImg);

                    postItem.appendChild(photoDiv);
                    feedDiv.appendChild(postItem);;
                });
            }

            if (result.video !== null && result.video !== '') {
                result.video.forEach(function(videoPath, index) {
                    var newId = result.postId + '-' + index;
                    var postItem = document.createElement('div');
                    postItem.className = 'post-item';
                    postItem.id = 'post-item' + newId;

                    var videoContainer = document.createElement('div');
                    videoContainer.className = 'post-video';
                    var video = document.createElement('video');
                    video.setAttribute('data-my-Video-id', newId);
                    video.id = 'myVideo-' + newId;
                    video.className = 'w-100';

                    var source = document.createElement('source');
                    source.src = videoPath;
                    source.type = 'video/mp4';

                    video.appendChild(source);
                    videoContainer.appendChild(video);

                    var videoControls = document.createElement('div');
                    videoControls.className = 'video-controls';

                    var rewindButton = document.createElement('button');
                    rewindButton.id = 'rewindButton-' + newId;
                    rewindButton.onclick = function() {
                        rewind(newId);
                    };
                    rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
                    videoControls.appendChild(rewindButton);
                    var playPauseButton = document.createElement('button');
                    playPauseButton.classList.add('play');
                    playPauseButton.onclick = function() {
                        togglePlayPause(newId);
                    };
                    playPauseButton.innerHTML = '<span class="playPauseButton" id="playPauseButton-' + newId + '"><i class="bi bi-play"></i></span>';
                    videoControls.appendChild(playPauseButton);
                    var fastForwardButton = document.createElement('button');
                    fastForwardButton.id = 'fastForwardButton-' + newId;
                    fastForwardButton.onclick = function() {
                        fastForward(newId);
                    };
                    fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
                    videoControls.appendChild(fastForwardButton);
                    var volumeControl = document.createElement('div');
                    volumeControl.className = 'volume-control';
                    var volumeRange = document.createElement('input');
                    volumeRange.type = 'range';
                    volumeRange.id = 'volumeRange-' + newId;
                    volumeRange.min = '0';
                    volumeRange.max = '1';
                    volumeRange.step = '0.01';
                    volumeRange.value = '1';
                    volumeRange.onchange = function() {
                        setVolume(newId);
                    };
                    volumeControl.appendChild(volumeRange);
                    videoControls.appendChild(volumeControl);
                    var timeControl = document.createElement('div');
                    timeControl.className = 'time-control';
                    var timeRange = document.createElement('input');
                    timeRange.type = 'range';
                    timeRange.id = 'timeRange-' + newId;
                    timeRange.min = '0';
                    timeRange.step = '0.01';
                    timeRange.value = '0';
                    timeRange.onchange = function() {
                        setCurrentTime(newId);
                    };
                    timeControl.appendChild(timeRange);
                    var timeDisplay = document.createElement('div');
                    timeDisplay.className = 'time-display';
                    var currentTimeDisplay = document.createElement('div');
                    currentTimeDisplay.className = 'currentTimeDisplay';
                    currentTimeDisplay.id = 'currentTimeDisplay-' + newId;
                    currentTimeDisplay.innerHTML = '0:00';
                    timeDisplay.appendChild(currentTimeDisplay);
                    timeDisplay.innerHTML += '<div class="slash">/</div>';
                    var durationDisplay = document.createElement('div');
                    durationDisplay.className = 'durationDisplay';
                    durationDisplay.id = 'durationDisplay-' + newId;
                    durationDisplay.innerHTML = '0:00';

                    video.addEventListener('loadedmetadata', function() {
                        console.log("Video loaded", video.duration)
                        durationDisplay.innerHTML = formatTime(video.duration);
                    });

                    video.addEventListener('timeupdate', function() {
                        handleTimeUpdate(newId);
                    });

                    timeRange.oninput = function() {
                        var newTime = video.duration * (timeRange.value / 100);
                        video.currentTime = newTime;
                        currentTimeDisplay.innerHTML = formatTime(newTime);
                    };
                    timeDisplay.appendChild(durationDisplay);
                    timeControl.appendChild(timeDisplay);
                    videoControls.appendChild(timeControl);

                    videoContainer.appendChild(videoControls);
                    postItem.appendChild(videoContainer);
                    feedDiv.appendChild(postItem);
                });
            }

            var previousButton = document.createElement('button');
            previousButton.className = 'previous-button';
            previousButton.innerHTML = '<i class="bi bi-arrow-left-circle"></i>';

            var nextButton = document.createElement('button');
            nextButton.className = 'next-button';
            nextButton.innerHTML = '<i class="bi bi-arrow-right-circle"></i>';
            var button = document.createElement('div');
            button.className = 'button';

            button.appendChild(previousButton);
            button.appendChild(nextButton);
            feedDiv.appendChild(button);
            var postItems = feedDiv.getElementsByClassName('post-item');
            var currentIndex = 0;
            feedDiv.addEventListener('keydown', function(event) {
                console.log('clicked');
                if (event.key === 'ArrowLeft') {
                    if (currentIndex > 0) {
                        postItems[currentIndex].style.display = 'none';
                        currentIndex--;
                        postItems[currentIndex].style.display = 'block';
                        autoplayVid();
                        postItems[currentIndex].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                } else if (event.key === 'ArrowRight') {
                    if (currentIndex < postItems.length - 1) {
                        postItems[currentIndex].style.display = 'none';
                        currentIndex++;
                        postItems[currentIndex].style.display = 'block';
                        autoplayVid();
                        postItems[currentIndex].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
            previousButton.addEventListener('click', function() {
                if (currentIndex > 0) {
                    postItems[currentIndex].style.display = 'none';
                    currentIndex--;
                    postItems[currentIndex].style.display = 'block';
                    autoplayVid();
                    postItems[currentIndex].scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            nextButton.addEventListener('click', function() {
                if (currentIndex < postItems.length - 1) {
                    postItems[currentIndex].style.display = 'none';
                    currentIndex++;
                    postItems[currentIndex].style.display = 'block';
                    autoplayVid();
                    postItems[currentIndex].scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            var mediaItems = feedDiv.getElementsByClassName('post-item');
            console.log(mediaItems.length);
            for (var i = 1; i < mediaItems.length; i++) {
                mediaItems[i].style.display = 'none';
            }

            var actionButtonsDiv = document.createElement('div');
            actionButtonsDiv.className = 'action-buttons';

            var interactionButtonsDiv = document.createElement('div');
            interactionButtonsDiv.className = 'interaction-buttons';
            interactionButtonsDiv.innerHTML = `
                    <span><i class="uil uil-heart"></i></span>
                    <span><i class="uil uil-comment-dots"></i></span>
                    <span><i class="uil uil-share-alt"></i></span>
                `;

            var bookmarkDiv = document.createElement('div');
            bookmarkDiv.className = 'bookmark';
            bookmarkDiv.innerHTML = '<span><i class="uil uil-bookmark-full"></i></span>';

            actionButtonsDiv.appendChild(interactionButtonsDiv);
            actionButtonsDiv.appendChild(bookmarkDiv);
            feedDiv.appendChild(actionButtonsDiv);

            var likedByDiv = document.createElement('div');
            likedByDiv.className = 'liked-by';
            likedByDiv.innerHTML = result.likes;
            feedDiv.appendChild(likedByDiv);

            var captionDiv = document.createElement('div');
            captionDiv.className = 'caption';
            captionDiv.innerHTML = `
                    <p><b>${result.firstName} ${result.surname}</b> ${result.content}.
                    </p>
                `;
            feedDiv.appendChild(captionDiv);

            var commentsDiv = document.createElement('div');
            commentsDiv.className = 'comments text-muted';
            commentsDiv.textContent = 'View comments';
            feedDiv.appendChild(commentsDiv);

            feeds.appendChild(feedDiv);


            let myVideo;

            function togglePlayPause(postId) {
                const playPauseButton = document.getElementById("playPauseButton-" + postId);
                const myVideo = document.getElementById("myVideo-" + postId);

                if (myVideo.paused) {
                    myVideo.play();
                    playPauseButton.innerHTML = "<i class='bi bi-pause-circle-fill'></i>";
                } else {
                    myVideo.pause();
                    playPauseButton.innerHTML = "<i class='bi bi-play'></i>";
                }
            }

            function rewind(postId) {
                const myVideo = document.getElementById("myVideo-" + postId);
                myVideo.currentTime -= 10;
            }

            function fastForward(postId) {
                const myVideo = document.getElementById("myVideo-" + postId);
                myVideo.currentTime += 10;
            }

            function setVolume(postId) {
                var video = document.getElementById('myVideo-' + postId);
                var volumeRange = document.getElementById('volumeRange-' + postId);

                video.volume = volumeRange.value;
            }

            window.addEventListener('DOMContentLoaded', function() {
                var videos = document.getElementsByTagName('video');

                for (var i = 0; i < videos.length; i++) {
                    var video = videos[i];
                    var postId = result.postId;
                    var volumeRange = document.getElementById('volumeRange-' + postId);

                    video.addEventListener('volumechange', function() {
                        volumeRange.value = video.volume;
                    });

                    volumeRange.oninput = function() {
                        setVolume(postId);
                    };
                }
            });


            function setCurrentTime(postId) {
                var video = document.getElementById('myVideo-' + postId);
                var timeRange = document.getElementById('timeRange-' + postId);
                var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

                var newTime = video.duration * (timeRange.value / 100);

                video.currentTime = newTime;

                currentTimeDisplay.innerHTML = formatTime(video.currentTime);
            }

            function formatTime(time) {
                var minutes = Math.floor(time / 60);
                var seconds = Math.floor(time % 60);

                minutes = String(minutes).padStart(2, '0');
                seconds = String(seconds).padStart(2, '0');

                return minutes + ':' + seconds;
            }


            function handleTimeUpdate(newId) {
                var video = document.getElementById('myVideo-' + newId);
                var timeRange = document.getElementById('timeRange-' + newId);
                var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + newId);

                var currentTime = video.currentTime;
                var duration = video.duration;
                var progress = (currentTime / duration) * 100;

                timeRange.value = progress;

                currentTimeDisplay.innerHTML = formatTime(currentTime);
            }

        }
    </script>
</body>

</html>