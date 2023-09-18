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
    <!-- video starts -->
    <div class="video">
      <video class="video__player" src="uploads/63ee18ffed0737.49776399.mp4"></video>

      <!-- sidebar -->
      <div class="videoSidebar">
        <div class="videoSidebar__button">
          <span class="material-icons"><i class="bi bi-bookmark"></i></span>
          <p style="color:white;">12</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-chat"></i> </span>
          <p style="color:white;">23</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-share-fill"></i> </span>
          <p style="color:white;">75</p>
        </div>

        <div class="videoSidebar__button">
          <span class="material-icons"> <i class="bi bi-download"></i> </span>
        </div>
      </div>

      <!-- footer -->
      <div class="videoFooter">
        <div class="videoFooter__text">
          <h3>Harinivas P</h3>
          <p class="videoFooter__description">Best Video Ever</p>

          <div class="videoFooter__ticker">
            <span class="material-icons videoFooter__icon"> music_note </span>
            <marquee>Song name</marquee>
          </div>
        </div>
        <img src="icons/cd.png" alt="" class="videoFooter__record" />
      </div>
    </div>
    <!-- video ends -->
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="node_modules/socket.io-client/dist/socket.io.js"></script>

  <script>
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
  </script>
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
      });
    });

    function loadReels(data) {
      var app__videos = document.querySelector('.app__videos');
      console.log('reels:', data);

      // var UserId = data.UserId;
      // var Video = data.Video;
      // var audioFileNames = data.audioFileNames;
      // var caption = data.caption;
      // var comment = data.comment;
      // var date_posted = data.date_posted;
      // var download = data.download;
      // var like = data.like;
      // var reelId = data.reelId;
      // var visibility = data.visibility;
      var videoContainer = document.createElement('div');
      videoContainer.className = 'video';

      // Create a video element and set its source
      var videoElement = document.createElement('video');
      videoElement.className = 'video__player';
      videoElement.src = data.Video;
      videoElement.addEventListener('click', function() {
        console.log('clicked');
        if (videoElement.paused) {
          videoElement.play();
        } else {
          videoElement.pause();
        }
      });
      // Create the sidebar
      var videoSidebar = document.createElement('div');
      videoSidebar.className = 'videoSidebar';

      // Create sidebar buttons and append them to the sidebar
      var buttonsData = [{
          icon: '<i class="bi bi-heart"></i>',
          visible: data.like === 'true'
        }, // Check if like is 'true'
        {
          icon: '<i class="bi bi-bookmark"></i>',
          count: 12
        },
        {
          icon: '<i class="bi bi-chat"></i>',
          count: 23,
          visible: data.comment === 'true'
        }, // Check if comment is 'true'
        {
          icon: '<i class="bi bi-share-fill"></i>',
          count: 75
        },
        {
          icon: '<i class="bi bi-download"></i>',
          visible: data.download === 'true'
        }, // Check if download is 'true'
      ];

      buttonsData.forEach(function(buttonData) {
        if (buttonData.visible || buttonData.count > 0) {
          // Create the button only if it's visible or if count is greater than 0
          var button = document.createElement('div');
          button.className = 'videoSidebar__button';
          button.id = 'videoSidebar__button' + data.reelId;
          var iconSpan = document.createElement('span');
          iconSpan.className = 'material-icons';
          iconSpan.innerHTML = buttonData.icon;
          var countP = document.createElement('p');
          countP.style.color = 'green';
          countP.textContent = buttonData.count;
          button.appendChild(iconSpan);
          button.appendChild(countP);
          videoSidebar.appendChild(button);
        }
      });
      // Create the video footer
      var videoFooter = document.createElement('div');
      videoFooter.className = 'videoFooter';

      // Create video footer text and append it to the video footer
      var videoFooterText = document.createElement('div');
      videoFooterText.className = 'videoFooter__text';
      var h3 = document.createElement('h3');
      h3.textContent = data.UserId; // Change this to the appropriate user property
      var descriptionP = document.createElement('p');
      descriptionP.className = 'videoFooter__description';
      descriptionP.textContent = data.caption; // Change this to the appropriate caption property

      // Create video footer ticker and append it to the video footer text
      var videoFooterTicker = document.createElement('div');
      videoFooterTicker.className = 'videoFooter__ticker';
      var tickerSpan = document.createElement('span');
      tickerSpan.className = 'material-icons videoFooter__icon';
      tickerSpan.textContent = 'music_note';
      var marquee = document.createElement('marquee');
      marquee.textContent = data.audioFileNames; // Change this to the appropriate song name property

      videoFooterTicker.appendChild(tickerSpan);
      videoFooterTicker.appendChild(marquee);
      videoFooterText.appendChild(h3);
      videoFooterText.appendChild(descriptionP);
      videoFooterText.appendChild(videoFooterTicker);

      // Create the video footer record image and append it to the video footer
      var recordImage = document.createElement('img');
      recordImage.src = 'icons/cd.png'; // Change this to the appropriate image source
      recordImage.alt = '';
      recordImage.className = 'videoFooter__record';

      videoFooter.appendChild(videoFooterText);
      videoFooter.appendChild(recordImage);

      // Append all the elements to the video container
      videoContainer.appendChild(videoElement);
      videoContainer.appendChild(videoSidebar);
      videoContainer.appendChild(videoFooter);
      app__videos.appendChild(videoContainer);
    }
  </script>
</body>

</html>