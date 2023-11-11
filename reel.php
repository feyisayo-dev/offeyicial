<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include 'db.php';
$UserId = $_SESSION["UserId"];
?>
<?php
// // Retrieve the followers/following
// $sql = "SELECT User_Profile.UserId, User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport
//     FROM User_Profile
//     INNER JOIN follows ON User_Profile.UserId = follows.UserId OR User_Profile.UserId = follows.recipientId
//     WHERE follows.UserId = ? OR follows.recipientId = ?";
// $params = array($UserId, $UserId);
// $stmt = sqlsrv_prepare($conn, $sql, $params);

// if ($stmt === false) {
//   die(print_r(sqlsrv_errors(), true));
// }

// if (sqlsrv_execute($stmt)) {
//   while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
//     $followerID = $row['UserId'];
//     $followerSurname = $row['Surname'];
//     $followerFirstName = $row['First_Name'];
//     $followerPassport = $row['Passport'];

//     // Retrieve and display the follower's reels
//     $reelsQuery = "SELECT [UserId]
//     ,[reelId]
//     ,[Video]
//     ,[audioFileNames]
//     ,[caption]
//     ,[visibility]
//     ,[comment]
//     ,[download]
//     ,[like]
//     ,[date_posted]
//                    FROM reels
//                    WHERE UserId = ?";
//     $reelsParams = array($followerID);
//     $reelsStmt = sqlsrv_prepare($conn, $reelsQuery, $reelsParams);

//     if ($reelsStmt === false) {
//       die(print_r(sqlsrv_errors(), true));
//     }

//     if (sqlsrv_execute($reelsStmt)) {
//       while ($reelsRow = sqlsrv_fetch_array($reelsStmt, SQLSRV_FETCH_ASSOC)) {
//         $reelID = $reelsRow['reelId'];
//         $reelVideo = $reelsRow['Video'];
//         $reelPhoto = $reelsRow['Photo'];

//         // Do something with $reelID, $reelVideo, $reelPhoto
//       }
//     } else {
//       die(print_r(sqlsrv_errors(), true));
//     }
//   }
// } else {
//   die(print_r(sqlsrv_errors(), true));
// }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Reels</title>
  <link rel="stylesheet" href="reel.css">
  <link rel="stylesheet" href="css/all.min.css" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font/bootstrap-icons.css">
  <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
  <link href="css/aos.css" rel="stylesheet">
  <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="css/remixicon/remixicon.css" rel="stylesheet">
  <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body>
  <div class="sidebar">
    <a class="sidebar-brand" href="home.php"><span class="text-success">Offeyicial</span></a>
    <ul class="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i></i>Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="window.location.href='addreel.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-camera-reels"></i></i>Add Reels</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-plus-square"></i>New Post</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="notificationLink" href="#"><i class="bi bi-bell-fill"></i>Notifications</a>
        <div id="notificationBox">
          <!-- Content of the notification box goes here -->
          <!-- You can customize the content as per your requirements -->
        </div>
      </li>
      <li class="nav-item">
        <div class="search-container">
          <i class="bi bi-search"></i>
          <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
        </div>
      </li>

      <li>
        <a class="nav-link scrollto" href="#contact"><i class="bi bi-telephone"></i>Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" onclick="location.href='logoutmodal.php'"><i class="bi bi-box-arrow-right"></i>Logout</a>
      </li>
    </ul>
  </div>
  <div class="app__videos">

  </div>
  <script src="js/jquery.min.js"></script>
  <script src="node_modules/socket.io-client/dist/socket.io.js"></script>

  <!-- <script>
    const videos = document.querySelectorAll('video');

    for (const video of videos) {
      video.addEventListener('click', function() {
        console.log('clicked');
        if (video.paused) {
          video.play();
        } else {
          video.pause();
        }
      });
    }
  </script> -->
  <script>
    var UserId = "<?php echo $_SESSION['UserId']; ?>";
    var socketUrl = 'ws://localhost:8888';
    const socket = io(socketUrl, {
      query: {
        UserId
      }
    });

    socket.on('connect', () => {
      console.log('Socket.IO connection established');
      socket.emit('fetchReels', UserId);
    });

    socket.on('reels', (data) => {
      data.forEach((reelData, index) => {
        console.log(`Received reels data #${index + 1}:`);
        console.log('UserId:', reelData.UserId);
        console.log('Video:', reelData.Video);
        console.log('audioFileNames:', reelData.audioFileNames);
        console.log('caption:', reelData.caption);
        console.log('comment:', reelData.comment);
        console.log('date_posted:', reelData.date_posted);
        console.log('download:', reelData.download);
        console.log('like:', reelData.like);
        console.log('reelId:', reelData.reelId);
        console.log('visibility:', reelData.visibility);

        loadReels(reelData);
        handleVideoContainers();
      });
    });

    var likeCounts = {};
    socket.on('reelsLike', (data) => {
      console.log('Recieved likes');
      data.forEach((reelsLikes) => {
        console.log(`Received reel likes:`);
        console.log('UserId:', reelsLikes.UserId);
        console.log('reelId:', reelsLikes.reelId);

        if (!likeCounts[reelsLikes.reelId]) {
          likeCounts[reelsLikes.reelId] = [];
        }

        if (!likeCounts[reelsLikes.reelId].includes(reelsLikes.UserId)) {
          likeCounts[reelsLikes.reelId].push(reelsLikes.UserId);
        }

        updateLikeCount(reelsLikes.reelId, likeCounts[reelsLikes.reelId]);
      });
    });
    var bookmarkCount = {};
    socket.on('reelsBookmark', (data) => {
      console.log('Received bookmarks');
      data.forEach((reelsbookmarks) => {
        console.log(`Received reel bookmarks:`);
        console.log('UserId:', reelsbookmarks.UserId);
        console.log('reelId:', reelsbookmarks.reelId);

        if (!bookmarkCount[reelsbookmarks.reelId]) {
          bookmarkCount[reelsbookmarks.reelId] = [];
        }

        if (!bookmarkCount[reelsbookmarks.reelId].includes(reelsbookmarks.UserId)) {
          bookmarkCount[reelsbookmarks.reelId].push(reelsbookmarks.UserId);
        }

        updateBookmarkCount(reelsbookmarks.reelId, bookmarkCount[reelsbookmarks.reelId]);
      });
    });


    socket.on('reelsComment', (data) => {
      data.forEach((reelsComments) => {
        console.log(`Received reel comments:`);
        console.log('UserId:', reelsComments.UserId);
        console.log('reelId:', reelsComments.reelId);
        console.log('comment:', reelsComments.comment);
        if (!commentCount[reelsComments.reelId]) {
          commentCount[reelsComments.reelId] = [];
        }

        if (!commentCount[reelsComments.reelId].includes(reelsComments.UserId)) {
          commentCount[reelsComments.reelId].push(reelsComments.UserId);
        }

        updateCommentCount(reelsComments.reelId, commentCount[reelsComments.reelId]);
      });
    });

    function loadReels(data) {
      var app__videos = document.querySelector('.app__videos');
      console.log('reels:', data);

      var videoContainer = document.createElement('div');
      videoContainer.className = 'video';

      //creating the play button in the middle
      var playButton = document.createElement('img');
      playButton.src = 'icons/playLogo.png';
      playButton.className = 'playLogo';
      playButton.style.position = 'absolute';
      playButton.style.display = 'none';
      playButton.style.inset = '40%';
      videoContainer.appendChild(playButton);

      // Create a video element and set its source
      var videoElement = document.createElement('video');
      videoElement.className = 'video__player';
      videoElement.src = data.Video;
      // videoElement.autoplay = true;
      videoElement.addEventListener('click', function() {
        console.log('clicked');
        if (videoElement.paused) {
          videoElement.play();
          playButton.style.display = 'none';
        } else {
          videoElement.pause();
          playButton.style.display = 'block';
        }
      });

      //creating comment bar
      var commentBoxInput = document.createElement('div');
      commentBoxInput.className = 'commentBoxInput';
      commentBoxInput.id = 'commentBoxInput' + data.reelId;

      var comments = document.createElement('div');
      comments.className = 'comments';
      comments.id = 'comments' + data.reelId;

      var commentHeader = document.createElement('div');
      commentHeader.className = 'commentHeader';
      commentHeader.id = 'commentHeader' + data.reelId;

      var commentHeaderP = document.createElement('p');
      commentHeaderP.className = 'commentHeaderP';
      commentHeaderP.textContent = 'Comments appear here';
      commentHeaderP.id = 'commentHeaderP' + data.reelId;

      var commentBox = document.createElement('div');
      commentBox.className = 'comment-box';
      commentBox.id = 'comment-box' + data.reelId;

      var commentInput = document.createElement('input');
      commentInput.type = 'text';
      commentInput.placeholder = 'Add a comment...';
      commentInput.className = 'comment-input';
      commentInput.id = 'comment-input' + data.reelId;

      var submitButton = document.createElement('button');
      submitButton.textContent = 'Post';
      submitButton.className = 'comment-button';
      submitButton.id = 'comment-button' + data.reelId;

      commentBox.appendChild(commentInput);
      commentBox.appendChild(submitButton);

      commentHeader.appendChild(commentHeaderP);
      commentBoxInput.appendChild(commentHeader);
      commentBoxInput.appendChild(comments);
      commentBoxInput.appendChild(commentBox);
      videoContainer.appendChild(commentBoxInput);

      // Create the sidebar
      var videoSidebar = document.createElement('div');
      videoSidebar.className = 'videoSidebar';
      videoSidebar.id = 'videoSidebar' + data.reelId;

      videoElement.addEventListener('click', function() {
        var commentBoxInput = document.querySelector('#commentBoxInput' + data.reelId);
        commentBoxInput.style.display = 'none';
      });
      var buttonsData = [{
          icon: 'bi bi-heart',
          visible: data.like === 'true',
          isFilled: false,
          count: 0,
          class: 'liked',
        },
        {
          icon: 'bi bi-bookmark',
          count: 0,
          visible: true,
          isFilled: false,
          class: 'bookmarked',
        },
        {
          icon: 'bi bi-chat',
          count: 0,
          visible: data.comment === 'true',
          isFilled: false,
          class: 'commented',
        },
        {
          icon: 'bi bi-share-fill',
          count: 0,
          visible: true,
          isFilled: false,
          class: 'shared',
        },
        {
          icon: 'bi bi-download',
          visible: data.download === 'true',
          isFilled: false,
          class: 'downloaded',
        },
      ];

      function handleButtonHover(buttonData, button, icon) {
        if (buttonData.class == 'commented') {
          buttonData.isFilled = !buttonData.isFilled;
          if (buttonData.isFilled) {
            icon.className = buttonData.icon + '-fill';
          } else {
            icon.className = buttonData.icon;
          }
        }
      }

      function handleButtonClick(buttonData, buttonElement, icon) {
        if (buttonData.class == 'liked' || buttonData.class == 'bookmarked') {
          buttonData.isFilled = !buttonData.isFilled;
          var UserId = '<?php echo $_SESSION['UserId']; ?>';
          var reelId = data.reelId;
          if (buttonData.isFilled) {
            icon.className = buttonData.icon + '-fill';
          } else {
            icon.className = buttonData.icon;
          }
          if (buttonData.class == 'liked') {
            const formData = new FormData();
            formData.append('UserId', UserId);
            formData.append('reelId', reelId);

            fetch('http://localhost:8888/likeReel', {
                method: 'POST',
                body: formData,
              })
              .then((response) => {
                if (!response.ok) {
                  throw new Error('Error liking/unliking Video');
                }
                return response.json();
              })
              .then((result) => {
                icon.className = buttonData.icon + '-fill';
              })
              .catch((error) => {
                console.error(error);
              });
          }
          if (buttonData.class == 'bookmarked') {
            const formData = new FormData();
            formData.append('UserId', UserId);
            formData.append('reelId', reelId);

            fetch('http://localhost:8888/BookMarkReel', {
                method: 'POST',
                body: formData,
              })
              .then((response) => {
                if (!response.ok) {
                  throw new Error('Error liking/unliking Video');
                }
                return response.json();
              })
              .then((result) => {
                icon.className = buttonData.icon + '-fill';
              })
              .catch((error) => {
                console.error(error);
              });
          }
        }
        if (buttonData.class === 'commented') {
          var commentBoxInput = document.querySelector('#commentBoxInput' + data.reelId);
          commentBoxInput.style.display = 'block';
        }
      }

      function checkIfItIsClicked(buttonData, buttonElement, icon) {
        if (buttonData.class == 'bookmarked') {
          var reelId = data.reelId;
          var UserId = '<?php echo $_SESSION['UserId']; ?>';
          console.log('This is what I brought from the bookmark before checking:', UserId , reelId);
          const formData = new FormData();
          formData.append('UserId', UserId);
          formData.append('reelId', reelId);
          fetch('http://localhost:8888/checkBookmark', {
              method: 'POST',
              body: formData,
            })
            .then((response) => {
              if (response.ok) {
                return response.json();
              } else {
                throw new Error('Error checking if the reel has been bookmarked');
              }
            })
            .then((result) => {
              if (result.Bookmarked) {
                icon.className = 'bi bi-bookmark' + '-fill';
              } else {
                icon.className = 'bi bi-bookmark';
              }
            })
            .catch((error) => {
              console.error(error);
            });
        }
        if (buttonData.class == 'liked') {
          var SessionUserId = '<?php echo $_SESSION['UserId']; ?>';
          var reelId = data.reelId;
          const formData = new FormData();
          formData.append('UserId', SessionUserId);
          formData.append('reelId', reelId);
          fetch('http://localhost:8888/checkLike', {
              method: 'POST',
              body: formData,
            })
            .then((response) => {
              if (response.ok) {
                return response.json();
              } else {
                throw new Error('Error checking if the reel has been liked');
              }
            })
            .then((result) => {
              if (result.liked) {
                icon.className = 'bi bi-heart' + '-fill';
              } else {
                icon.className = 'bi bi-heart';
              }
            })
            .catch((error) => {
              console.error(error);
            });
        }
      }

      buttonsData.forEach(function(buttonData) {
        if (buttonData.visible) {
          var button = document.createElement('div');
          button.className = 'videoSidebar__button';
          button.id = 'videoSidebar__button' + data.reelId + buttonData.class;
          var iconSpan = document.createElement('span');
          iconSpan.className = 'material-icons';
          var icon = document.createElement('i');
          icon.className = buttonData.icon;
          button.addEventListener('click', function() {
            handleButtonClick(buttonData, button, icon);
          });
          button.addEventListener('hover', function() {
            handleButtonHover(buttonData, button, icon);
          });
          checkIfItIsClicked(buttonData, button, icon);
          var countP = document.createElement('p');
          countP.style.color = 'black';
          countP.className = buttonData.class + 'p_text';
          countP.textContent = buttonData.count;
          iconSpan.appendChild(icon);
          button.appendChild(iconSpan);
          button.appendChild(countP);
          videoSidebar.appendChild(button);
        }
      });

      var videoFooter = document.createElement('div');
      videoFooter.className = 'videoFooter';

      async function fetchUserProfileData(UserId) {
        try {
          const response = await fetch(`http://localhost:8888/getUserProfile/${UserId}`);
          if (response.ok) {
            const userProfileData = await response.json();
            return userProfileData;
          } else {
            throw new Error('Error fetching user profile data');
          }
        } catch (error) {
          console.error(error);
          return null;
        }
      }

      const videoFooterText = document.createElement('div');
      videoFooterText.className = 'videoFooter__text';

      async function setVideoFooterText(UserId, caption) {
        try {
          const userProfileData = await fetchUserProfileData(UserId);

          const h3 = document.createElement('p');
          if (userProfileData) {
            h3.textContent = `${userProfileData.Surname} ${userProfileData.First_Name}`;
          } else {
            h3.textContent = UserId;
          }

          const descriptionP = document.createElement('p');
          descriptionP.className = 'videoFooter__description';
          descriptionP.textContent = caption;

          videoFooterText.appendChild(h3);
          videoFooterText.appendChild(descriptionP);
          var videoFooterTicker = document.createElement('div');
          videoFooterTicker.className = 'videoFooter__ticker';
          var tickerSpan = document.createElement('span');
          tickerSpan.className = 'material-icons videoFooter__icon';
          tickerSpan.textContent = 'music_note';
          var marquee = document.createElement('marquee');
          marquee.textContent = data.audioFileNames;

          videoFooterTicker.appendChild(tickerSpan);
          videoFooterTicker.appendChild(marquee);
          videoFooterText.appendChild(videoFooterTicker);
        } catch (error) {
          console.error('Error fetching user profile data:', error);
        }
      }

      setVideoFooterText(data.UserId, data.caption);



      var recordImage = document.createElement('img');
      recordImage.src = 'icons/cd.png';
      recordImage.alt = '';
      recordImage.className = 'videoFooter__record';

      videoFooter.appendChild(videoFooterText);
      videoFooter.appendChild(recordImage);

      videoContainer.appendChild(videoElement);
      videoContainer.appendChild(videoSidebar);
      videoContainer.appendChild(videoFooter);
      app__videos.appendChild(videoContainer);
    }

    function updateLikeCount(reelId, UserId) {
      var buttonElement = document.getElementById('videoSidebar__button' + reelId + 'liked');
      if (buttonElement) {
        var countP = buttonElement.querySelector('p');
        if (UserId.length > 0) {
          countP.textContent = UserId.length;
        } else {
          countP.textContent = '0';
        }
      } else {
        console.log('No buttonElement found');
      }
    }

    function updateCommentCount(reelId, commentCount) {
      var buttonElement = document.getElementById('videoSidebar__button' + reelId + 'commented');
      if (buttonElement) {
        var countP = buttonElement.querySelector('p');
        countP.textContent = commentCount.length;
      }
    }

    function updateBookmarkCount(reelId, bookamrksCount) {
      var UserId = '<?php echo $_SESSION['UserId']; ?>';
      var buttonElement = document.getElementById('videoSidebar__button' + reelId + 'bookmarked');
      if (buttonElement) {
        var countP = buttonElement.querySelector('p');
        countP.textContent = bookamrksCount.length;
        console.log('Numbe of bookmarks', bookamrksCount.length);
      }
    }

    function handleVideoContainers() {
      // console.log('#');
      var videoContainers = document.querySelectorAll('.video');
      console.log(videoContainers.length);
      videoContainers.forEach(function(videoContainer) {
        // console.log('Video #');
        var videoElement = videoContainer.querySelector('.video__player');
        var playButton = videoContainer.querySelector('.playLogo');

        videoElement.addEventListener('play', function() {
          console.log('Video started playing');
          videoContainers.forEach(function(otherContainer) {
            if (otherContainer !== videoContainer) {
              var otherVideo = otherContainer.querySelector('.video__player');
              if (!otherVideo.paused) {
                otherVideo.pause();
                console.log('Paused other video');
              }
            }
          });
        });

        videoElement.addEventListener('touchstart', function() {
          console.log('Touch started');
          videoElement.play();
          playButton.style.display = 'none';
        });

        videoElement.addEventListener('touchend', function() {
          console.log('Touch ended');
          videoElement.pause();
        });
      });
    }
  </script>
</body>

</html>