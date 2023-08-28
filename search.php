<?php
session_start();
$UserId = $_SESSION["UserId"];
include 'db.php';

?>
<!DOCTYPE html>
<html>

<head>
  <title>News Feed</title>
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
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">


  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="js/slim.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/png" sizes="32x32" />

</head>

<body>
  <div class="row">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navmenu">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="home.php"><img src="icons/home.png" class="icon" alt=""></i>Home</a>
          </li>
          <li class="nav-item">
            <div class="search-container">
              <input class="searchtext" type="text" id="search2" placeholder="Search for names.." title="Type in a name">
              <div id="user_table">
              </div>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-link" onclick="window.location.href='index.php'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">
      <div id="user_table" class="user-table"></div>

      <div class="col-9">

        <div class="news-feed-container">
          <div class="Activity">
            <h2>Rizz</h2>
          </div>
          <div class="addpost">
            <div class="input-group">
              <input class="form-control addnewpost" type="text" id="addnewpost" placeholder="Add New Post" title="Add New Post">
              <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button">
                  <i class="bi bi-camera"></i>
                </button>
                <button class="btn btn-outline-primary" type="button">
                  <i class="bi bi-film"></i>
                </button>
                <button class="btn btn-primary" id="postButton" type="button">Post</button>
              </div>
            </div>
          </div>

          <div id="newsFeed" class="ps">
            <!-- Posts will be dynamically loaded here -->
          </div>
          <button id="scrollToTopBtn"><i class="bi bi-arrow-up-short"></i></button>
          <?php

          // Retrieve all the chats of the current user
          $sql = "SELECT DISTINCT recipientId FROM chats WHERE UserId = '$UserId' OR recipientId= '$UserId'";
          $stmt = sqlsrv_query($conn, $sql);
          if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
          }

          // Display the chats in a list on the sidebar
          echo '<!-- Button to open the sidebar -->
<button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
    <i class="bi bi-chat"></i> Chats
</button>

<!-- Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
        <button type="button" class="btn-close text-reset close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">';

          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $recipientId = $row['recipientId'];

            // Get the name of the recipient
            $sql2 = "SELECT Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";

            $stmt2 = sqlsrv_query($conn, $sql2);
            if ($stmt2 === false) {
              die(print_r(sqlsrv_errors(), true));
            }

            $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
            $recipientName = $row2['Surname'] . ' ' . $row2['First_Name'];
            $Passport = $row2['Passport'];
            if (empty($Passport)) {
              $passportImage = "UserPassport/DefaultImage.png";
            } else {
              $passportImage = "UserPassport/" . $Passport;
            }

            // Display the recipient name and passport image in the list
            echo '<li>';
            echo '<div class="passport">';
            echo '<a>';
            echo '<img src="' . $passportImage . '" alt="' . $recipientName . '">';
            echo '</a>';
            echo '</div>';
            echo '<div class="name"><span><a href="chat.php?UserIdx=' . $recipientId . '">' . $recipientName . '</a></span></div>';
            echo '</li>';
          }

          echo '</ul>
    </div>
</div>';

          ?>
        </div>
      </div>
      <div class="col-3 comments-sidebar" id="commentSidebar">
        <div class="comment-input">
          <div class="emoji-picker">
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
                <!-- Add more rows and columns for additional emojis -->
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
          <textarea class="form-control" name="commentText" placeholder="Type your comment" id="commentInput" rows="3"></textarea>
          <button type="button" class="btn btn-primary" onclick="submitComment()">Comment</button>
        </div>
        <div class="comments"></div>
      </div>
    </div>


  </div>
  </div>
  </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/sweetalert2@10.js"></script>
  <script>
    function loadNewsFeed() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            console.log('Response:', xhr.responseText);
            var newsFeed = document.getElementById('newsFeed');
            newsFeed.innerHTML = '';

            response.posts.forEach(function(post) {
              var postElement = document.createElement('section');
              var postDiv = document.createElement('div');
              postDiv.className = 'post';

              var newsFeedPostDiv = document.createElement('div');
              newsFeedPostDiv.className = 'news-feed-post';

              var postHeaderDiv = document.createElement('div');
              postHeaderDiv.className = 'post-header';

              var userPassportImg = document.createElement('img');
              userPassportImg.className = 'UserPassport';
              userPassportImg.src = post.passport;

              var authorLink = document.createElement('a');
              authorLink.href = 'user_profile.php?UserId=' + post.UserId;
              authorLink.style.textDecoration = 'none';

              var authorNameP = document.createElement('p');
              authorNameP.className = 'post-author';
              authorNameP.innerHTML = '<strong>' + post.surname + ' ' + post.firstName + '</strong>';

              authorLink.appendChild(authorNameP);
              postHeaderDiv.appendChild(userPassportImg);
              postHeaderDiv.appendChild(authorLink);

              var threeDotsDiv = document.createElement('div');
              threeDotsDiv.id = 'threedots';

              var dropdownButton = document.createElement('button');
              dropdownButton.type = 'button';
              dropdownButton.className = 'btn btn-link';
              dropdownButton.dataset.bsToggle = 'dropdown';
              dropdownButton.setAttribute('aria-haspopup', 'true');
              dropdownButton.setAttribute('aria-expanded', 'false');
              dropdownButton.innerHTML = '<i class="fas fa-ellipsis-h"></i>';

              var dropdownMenu = document.createElement('div');
              dropdownMenu.className = 'dropdown-menu dropdown-menu-right';

              var blockUserDiv = document.createElement('div');
              var blockUserButton = document.createElement('button');
              blockUserButton.type = 'button';
              blockUserButton.className = 'btn btn-primary blockUser';
              blockUserButton.id = 'blockUser-' + post.UserId;
              blockUserButton.dataset.recipientid = post.UserId;
              blockUserButton.dataset.bsToggle = 'modal';
              blockUserButton.dataset.bsTarget = '#blockUserModal-' + post.UserId;
              blockUserButton.innerHTML = 'Block User';

              var blockUserInput = document.createElement('input');
              blockUserInput.type = 'hidden';
              blockUserInput.id = 'bu' + post.UserId;
              blockUserInput.value = post.UserId;

              blockUserDiv.appendChild(blockUserButton);
              blockUserDiv.appendChild(blockUserInput);

              var blockButtonDiv = document.createElement('div');
              var blockButtonButton = document.createElement('button');
              blockButtonButton.type = 'button';
              blockButtonButton.className = 'btn btn-primary blockButton';
              blockButtonButton.id = 'blockButton-' + post.postId;
              blockButtonButton.dataset.postid = post.postId;
              blockButtonButton.dataset.bsToggle = 'modal';
              blockButtonButton.dataset.bsTarget = '#blockTypeofPostModal-' + post.postId;
              blockButtonButton.innerHTML = 'Block this type of post';

              var blockButtonInput = document.createElement('input');
              blockButtonInput.type = 'hidden';
              blockButtonInput.id = 'b' + post.postId;
              blockButtonInput.value = post.postId;

              blockButtonDiv.appendChild(blockButtonButton);
              blockButtonDiv.appendChild(blockButtonInput);

              dropdownMenu.appendChild(blockUserDiv);
              dropdownMenu.appendChild(blockButtonDiv);
              dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
                '<a class="dropdown-item" href="#">Repost post</a>';

              threeDotsDiv.appendChild(dropdownButton);
              threeDotsDiv.appendChild(dropdownMenu);

              // Update the code to handle images and videos directly without carouselItems
              // Create a div for the post media
              var postMediaDiv = document.createElement('div');
              postMediaDiv.className = 'post-media';

              // Check if the post has an image
              if (post.image !== null && post.image !== '') {
                var postItem = document.createElement('div');
                postItem.className = 'post-item';
                var image = document.createElement('img');
                image.className = 'post-image';
                image.src = post.image;
                postItem.appendChild(image);
                postMediaDiv.appendChild(postItem);
              }

              // Check if the post has a video
              if (post.video !== null && post.video !== '') {
                var postItem = document.createElement('div');
                postItem.className = 'post-item';
                var videoContainer = document.createElement('div');
                videoContainer.className = 'post-video';
                var video = document.createElement('video');
                video.setAttribute('data-my-Video-id', post.postId);
                video.id = 'myVideo-' + post.postId;
                video.className = 'w-100';
                var source = document.createElement('source');
                source.src = post.video;
                source.type = 'video/mp4';
                video.appendChild(source);
                videoContainer.appendChild(video);
                // videoContainer.innerHTML += 'Your browser does not support the video tag.';
                var videoControls = document.createElement('div');
                videoControls.className = 'video-controls';
                var rewindButton = document.createElement('button');
                rewindButton.id = 'rewindButton-' + post.postId;
                rewindButton.onclick = function() {
                  rewind(post.postId);
                };
                rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
                videoControls.appendChild(rewindButton);
                var playPauseButton = document.createElement('button');
                playPauseButton.onclick = function() {
                  togglePlayPause(post.postId);
                };
                playPauseButton.innerHTML = '<span id="playPauseButton-' + post.postId + '"><i class="bi bi-play"></i></span>';
                videoControls.appendChild(playPauseButton);
                var fastForwardButton = document.createElement('button');
                fastForwardButton.id = 'fastForwardButton-' + post.postId;
                fastForwardButton.onclick = function() {
                  fastForward(post.postId);
                };
                fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
                videoControls.appendChild(fastForwardButton);
                var volumeControl = document.createElement('div');
                volumeControl.className = 'volume-control';
                var volumeRange = document.createElement('input');
                volumeRange.type = 'range';
                volumeRange.id = 'volumeRange-' + post.postId;
                volumeRange.min = '0';
                volumeRange.max = '1';
                volumeRange.step = '0.01';
                volumeRange.value = '1';
                volumeRange.onchange = function() {
                  setVolume(post.postId);
                };
                volumeControl.appendChild(volumeRange);
                videoControls.appendChild(volumeControl);
                var timeControl = document.createElement('div');
                timeControl.className = 'time-control';
                var timeRange = document.createElement('input');
                timeRange.type = 'range';
                timeRange.id = 'timeRange-' + post.postId;
                timeRange.min = '0';
                timeRange.step = '0.01';
                timeRange.value = '0';
                timeRange.onchange = function() {
                  setCurrentTime(post.postId);
                };
                timeControl.appendChild(timeRange);
                var timeDisplay = document.createElement('div');
                timeDisplay.className = 'time-display';
                var currentTimeDisplay = document.createElement('div');
                currentTimeDisplay.className = 'currentTimeDisplay';
                currentTimeDisplay.id = 'currentTimeDisplay-' + post.postId;
                currentTimeDisplay.innerHTML = '0:00';
                timeDisplay.appendChild(currentTimeDisplay);
                timeDisplay.innerHTML += '<div class="slash">/</div>';
                var durationDisplay = document.createElement('div');
                durationDisplay.className = 'durationDisplay';
                durationDisplay.id = 'durationDisplay-' + post.postId;
                durationDisplay.innerHTML = '0:00';
                timeDisplay.appendChild(durationDisplay);
                timeControl.appendChild(timeDisplay);
                videoControls.appendChild(timeControl);
                videoContainer.appendChild(videoControls);
                postItem.appendChild(videoContainer);
                postMediaDiv.appendChild(postItem);

                // Create the Previous and Next buttons
                var previousButton = document.createElement('button');
                previousButton.className = 'previous-button';
                previousButton.innerHTML = '<i class="bi bi-arrow-left"></i>';

                var nextButton = document.createElement('button');
                nextButton.className = 'next-button';
                nextButton.innerHTML = '<i class="bi bi-arrow-right"></i>';

                var button = document.createElement('div');
                button.className = 'button';

                // Append the Previous and Next buttons to the postMediaDiv
                button.appendChild(previousButton);
                button.appendChild(nextButton);
                postMediaDiv.appendChild(button);

                // Get all the post items
                var postItems = postMediaDiv.getElementsByClassName('post-item');
                var currentIndex = 0; // Track the current index of the post item

                // Add click event listeners to scroll to the previous and next post items
                previousButton.addEventListener('click', function() {
                  if (currentIndex > 0) {
                    postItems[currentIndex].style.display = 'none'; // Hide the current post item
                    currentIndex--; // Decrement the current index
                    postItems[currentIndex].style.display = 'block'; // Show the previous post item
                    postItems[currentIndex].scrollIntoView({
                      behavior: 'smooth'
                    }); // Scroll to the previous post item
                  }
                });

                nextButton.addEventListener('click', function() {
                  if (currentIndex < postItems.length - 1) {
                    postItems[currentIndex].style.display = 'none'; // Hide the current post item
                    currentIndex++; // Increment the current index
                    postItems[currentIndex].style.display = 'block'; // Show the next post item
                    postItems[currentIndex].scrollIntoView({
                      behavior: 'smooth'
                    }); // Scroll to the next post item
                  }
                });
              }

              // Hide all media elements except the first one
              var mediaItems = postMediaDiv.getElementsByClassName('post-item');
              console.log(mediaItems.length);
              for (var i = 1; i < mediaItems.length; i++) {
                mediaItems[i].style.display = 'none';
              }

              // Append the post media div before the post content
              // newsFeedPostDiv.insertBefore(postMediaDiv, postContentDiv);

              var postContentDiv = document.createElement('div');
              postContentDiv.className = 'post-content';
              postContentDiv.textContent = post.content;

              var postDateDiv = document.createElement('div');
              postDateDiv.className = 'post-date';
              postDateDiv.textContent = post.timeAgo;

              var footerDiv = document.createElement('div');
              footerDiv.className = 'footer';

              var likeButton = document.createElement('button');
              likeButton.type = 'button';
              likeButton.className = 'btn btn-primary like ' + (post.isLiking ? 'likeing' : 'unlike');
              likeButton.dataset.postid = post.postId;
              likeButton.innerHTML = '<span class="like-count">' + post.likes + '</span>' +
                '<span class="emoji">&#x2764;</span>' +
                (post.isLiking ? 'Unlike' : 'Like');

              var shareButton = document.createElement('button');
              shareButton.type = 'button';
              shareButton.className = 'btn btn-primary share-button';
              shareButton.dataset.postid = post.postId;
              shareButton.innerHTML = '<i class="bi bi-share"></i> Share';

              var commentButton = document.createElement('button');
              commentButton.type = 'button';
              commentButton.className = 'btn btn-primary comment-button';
              commentButton.dataset.postid = post.postId;
              commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> Comment';

              footerDiv.appendChild(likeButton);
              footerDiv.appendChild(shareButton);
              footerDiv.appendChild(commentButton);

              postDiv.appendChild(newsFeedPostDiv);
              newsFeedPostDiv.appendChild(postHeaderDiv);
              postHeaderDiv.appendChild(threeDotsDiv);
              var postTitleDiv = document.createElement('div');
              postTitleDiv.className = 'post-title';

              var postTitleH2 = document.createElement('h2');
              postTitleH2.textContent = post.title;

              postTitleDiv.appendChild(postTitleH2);
              postDiv.appendChild(postTitleDiv);
              // Append the post media div to the post div
              postDiv.appendChild(postMediaDiv);
              postDiv.appendChild(postContentDiv);
              postDiv.appendChild(postDateDiv);
              postDiv.appendChild(footerDiv);
              postElement.appendChild(postDiv);

              newsFeed.appendChild(postElement);
            });
            $('.owl-carousel').owlCarousel({
              items: 1,
              loop: true,
              nav: true,
              dots: false,
              navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>']
            })
          } else {
            console.log('Error: ' + xhr.status);
          }
        }
      };

      xhr.open('GET', 'get_posts.php', true);
      xhr.send();
    }

    // Load initial news feed
    loadNewsFeed();

    // Add event listener to the "Post" button
    var postButton = document.getElementById('postButton');
    postButton.addEventListener('click', function() {
      // Code to handle posting a new post
      // ...

      // After posting, reload the news feed
      loadNewsFeed();
    });
  </script>
  <script>
    // Declare myVideo as a global variable
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

    // <i class="bi bi-fast-forward"></i>
    function fastForward(postId) {
      const myVideo = document.getElementById("myVideo-" + postId);
      myVideo.currentTime += 10;
    }

    // Set volume
    (function() {
      function setVolume(postId) {
        var video = document.getElementById('myVideo-' + postId);
        var volumeRange = document.getElementById('volumeRange-' + postId);

        // Set the volume of the video
        video.volume = volumeRange.value;
      }

      // Update the volume range when the video is loaded
      window.addEventListener('DOMContentLoaded', function() {
        var videos = document.getElementsByTagName('video');

        for (var i = 0; i < videos.length; i++) {
          (function() {
            var video = videos[i];
            var postId = video.getAttribute('data-my-Video-id');
            var volumeRange = document.getElementById('volumeRange-' + postId);

            // Update the volume range as the volume changes
            video.addEventListener('volumechange', function() {
              volumeRange.value = video.volume;
            });

            // Set the setVolume function with the postId argument
            volumeRange.oninput = function() {
              setVolume(postId);
            };
          })();
        }
      });
    })();


    function setCurrentTime(postId) {
      return function() {
        var video = document.getElementById('myVideo-' + postId);
        var timeRange = document.getElementById('timeRange-' + postId);
        var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

        // Calculate the new time based on the range value
        var newTime = video.duration * (timeRange.value / 100);

        // Set the current time of the video
        video.currentTime = newTime;

        // Update the current time display
        currentTimeDisplay.innerHTML = formatTime(video.currentTime);
      };
    }

    // Helper function to format time in HH:MM:SS format
    function formatTime(time) {
      var minutes = Math.floor(time / 60);
      var seconds = Math.floor(time % 60);

      // Add leading zeros if necessary
      minutes = String(minutes).padStart(2, '0');
      seconds = String(seconds).padStart(2, '0');

      return minutes + ':' + seconds;
    }

    // Update the time range and duration display when the video is loaded
    window.addEventListener('DOMContentLoaded', function() {
      var videos = document.getElementsByTagName('video');

      for (var i = 0; i < videos.length; i++) {
        (function() {
          var video = videos[i];
          var postId = video.getAttribute('data-my-Video-id');
          var timeRange = document.getElementById('timeRange-' + postId);
          var durationDisplay = document.getElementById('durationDisplay-' + postId);

          // Update the duration display
          video.addEventListener('loadedmetadata', function() {
            durationDisplay.innerHTML = formatTime(video.duration);
          });

          // Update the time range as the video progresses
          video.addEventListener('timeupdate', function() {
            var currentTime = video.currentTime;
            var duration = video.duration;

            // Calculate the percentage of progress
            var progress = (currentTime / duration) * 100;

            // Set the value of the time range
            timeRange.value = progress;

            // Update the current time display
            var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);
            currentTimeDisplay.innerHTML = formatTime(currentTime);
          });

          // Set the setCurrentTime function with the postId argument
          timeRange.onchange = setCurrentTime(postId);
        })();
      }
    });
  </script>
  <script>
    $(document).ready(function() {
      $('.comment-button').click(function() {
        console.log('clicked');
        var postId = $(this).data('postid');
        var commentsSidebar = $('#commentSidebar');

        $.ajax({
          type: "POST",
          url: "getCommentBox.php",
          data: {
            postId: postId
          },
          success: function(response) {
            commentsSidebar.find('.comments').html(response);
            commentsSidebar.show();
          }
        });
      });
    });
  </script>

</body>
<script>
  document.addEventListener("click", function(event) {
    var notificationLink = document.getElementById("notificationLink");
    var notificationBox = document.getElementById("notificationBox");

    if (event.target !== notificationLink && !notificationLink.contains(event.target)) {
      notificationLink.parentElement.classList.remove("open");
    }
  });

  document.getElementById("notificationLink").addEventListener("click", function(event) {
    event.preventDefault();
    var parent = this.parentElement;
    parent.classList.toggle("open");
  });
</script>
<script>
  $(document).ready(function() {
    $(".owl-carousel").owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: false
      // You can customize other options according to your needs
    });
  });
</script>
<script>
  var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

  // Check if the UserId exists
  if (!UserId) {
    // UserId not found, redirect to login page
    window.location.href = "login.php";
  }
</script>

<script>
  var urlParams = new URLSearchParams(window.location.search);
  var postId = urlParams.get('postId');
  console.log(postId);

  // Check if the PostId exists
  function checkPostIdExistence(postId) {
    return new Promise(function(resolve, reject) {
      // Make an AJAX call to postIdfinding.php
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Response received successfully
            var response = xhr.responseText;
            resolve(response === 'true');
          } else {
            // Error occurred
            reject();
          }
        }
      };

      xhr.open('GET', 'postIdfinding.php?postId=' + postId, true);
      xhr.send();
    });
  }

  if (postId) {
    checkPostIdExistence(postId)
      .then(function(result) {
        if (!result) {
          // PostId not found, redirect to 404 error page
          window.location.href = "error404.php";
        } else {
          // Scroll to post with matching id
          var postElement = document.getElementById('post-' + postId);
          if (postElement) {
            postElement.scrollIntoView();
          }
        }
      })
      .catch(function() {
        // Error occurred while checking PostId existence
        console.log('An error occurred.');
      });
  }
</script>
<script>
  $(document).ready(function() {
    var UserId = "<?php echo $_SESSION['UserId']; ?>";

    $(".like").click(function() {
      var likeBtn = $(this);
      var islikeing = likeBtn.hasClass('likeing');
      var postId = likeBtn.data('postid');
      // alert(postId);

      $.ajax({
        url: "like_posts.php",
        type: "POST",
        data: {
          like: 1,
          postId: postId,
          UserId: UserId,
          islikeing: islikeing ? 0 : 1
        },
        success: function(response) {
          alert(response);
          if (response === 'liked') {
            likeBtn.addClass('likeing');
          } else if (response === 'unliked') {
            likeBtn.removeClass('likeing');
          }

          var likeCount = likeBtn.parent().find('.like-count');
          if (likeCount.length) {
            likeCount.text(response.numLikes);
          }
          $("#" + postId + " .footer").load(location.href + " #" + postId + " .footer > *");

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function() {
    // Set the time after which the refresh button will appear (in milliseconds)
    var refreshTime = 120000; // 2 minutes

    setTimeout(function() {
      // Add refresh button to the top of the page
      $('body').prepend('<button class="refresh-button"><i class="bi-arrow-clockwise"></i></button>');
      // Position the refresh button at the top center
      $('.refresh-button').css({
        'position': 'fixed',
        'top': '80px',
        'left': '50%',
        'transform': 'translateX(-50%)',
        'z-index': '999',
        'background-color': 'transparent',
        'color': 'black',
        'border': 'none',
        'border-radius': '50%',
        'font-size': '30px',
      });
    }, refreshTime);

    // Refresh button click event
    $('body').on('click', '.refresh-button', function() {
      location.reload();
    });
  });
</script>
<script>
  function insertEmoji(emoji) {
    var textarea = document.querySelector("#commentInput");
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
  // COMMENT SECTION
  function submitComment() {
    var comment = $("#commentInput").val();
    var UserId = "<?php echo $UserId ?>";
    var postId = $("#postId").val(); // Retrieve the post ID from the hidden input field

    // Do something with the comment, e.g. send it to the server using AJAX
    if (comment != "") {
      $.ajax({
        url: "comment_post.php",
        type: "POST",
        async: false,
        data: {
          "addcoment": 1,
          "postId": postId,
          "comment": comment,
          "UserId": UserId,
        },
        success: function(data) {
          alert(data)
          $("#commentInput").val("");
        }
      });
    } else {
      alert("Field Missing");
    }

  }
</script>

<script>
  var UserId = <?php echo json_encode($UserId); ?>;
  // Share button
  $(document).on('click', '.share-button', function() {
    var postId = $(this).data('postid');
    var shareUrl = 'http://localhost:8080/offeyicialchatroom/index.php?postId=' + postId;

    // Use SweetAlert to display the modal
    Swal.fire({
      title: 'Copy this link to share:',
      html: shareUrl,
      showCancelButton: false,
      showCloseButton: true,
      focusConfirm: false,
      confirmButtonText: 'Copy',
    }).then(function(result) {
      if (result.isConfirmed) {
        copyToClipboard(shareUrl);
        Swal.fire('Copied!', 'Link copied to clipboard.', 'success');
      }
    });
  });

  // Function to copy text to clipboard
  function copyToClipboard(text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
  }
</script>

<script>
  $(document).ready(function() {
    $("#search2").on("keyup", function() {
      // alert('yes');
      var value = $(this).val().toLowerCase();
      if (value === "") {
        $("#user_table").html("");
      } else {
        // Run the search function if the search box is not empty
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

    // Clear the results if the search box is empty
    if (!searchTerm.trim()) {
      resultsDiv.innerHTML = '';
      return;
    }

    $(document).ready(function() {
      $("#search").on("keyup", function() {
        // alert('yes');
        var searchValue = $(this).val().toLowerCase();
        if (searchValue === "") {
          $("#user_table").removeClass("show").html("");
        } else {
          $.ajax({
            url: "searchbackend.php",
            method: "POST",
            data: {
              search_query: searchValue
            },
            success: function(data) {
              $("#user_table").addClass("show").html(data);
            }
          });
        }
      });

      $(document).on("click", function(e) {
        // Check if the click is outside the search box and user table
        if (!$(e.target).closest(".search-container, #user_table").length) {
          $("#user_table").removeClass("show").html("");
        }
      });
    });
  });
</script>
<!-- <script>
  function toggleSidebar() {
    const maxWidth = 950;
    const posts = document.getElementById('newsFeed');
    const sidebar = document.querySelector('.sidebar');
    const Activity = document.querySelector('.Activity');
    const navbar = document.querySelector('.navbar');
    const addpost = document.querySelector('.addpost');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    function handleResize() {
      const windowWidth = window.innerWidth;
      if (windowWidth <= maxWidth) {
        sidebar.style.display = 'none';
        navbar.style.display = 'block';
        posts.style.marginLeft = '40px';
        addpost.style.marginTop = '20px';
        addpost.style.marginLeft = '50px';
        Activity.style.marginLeft = '50px';
        Activity.style.marginTop = '80px';
      } else {
        sidebar.style.display = 'block';
        navbar.style.display = 'none';
        posts.style.marginLeft = '280px';
        addpost.style.marginTop = '20px';
        addpost.style.marginLeft = '280px';
        Activity.style.marginLeft = '280px';
        Activity.style.marginTop = '80px';
        navbarCollapse.classList.remove('show');
      }
    }

    // Initial check on page load
    handleResize();

    // Listen for window resize events
    window.addEventListener('resize', handleResize);
  }

  // Call the toggleSidebar function
  toggleSidebar();
</script> -->

<script>
  $(document).ready(function() {
    // Show or hide the button depending on the scroll position
    $(window).scroll(function() {
      if ($(this).scrollTop() > 100) {
        $('#scrollToTopBtn').fadeIn();
      } else {
        $('#scrollToTopBtn').fadeOut();
      }
    });

    // Scroll to top when the button is clicked
    $('#scrollToTopBtn').click(function() {
      $('html, body').animate({
        scrollTop: 0
      }, 10);
      return false;
    });
  });
</script>

<script>
  $(document).ready(function() {
    // Add event listener to "other reason" checkbox
    $('#other-reason').on('change', function() {
      if ($(this).is(':checked')) {
        $('#other-reason-textbox').show();
      } else {
        $('#other-reason-textbox').hide();
      }
    });

    // Add event listener to all checkboxes
    $(".blockuser").on('change', function() {
      if ($(this).is(':checked')) {
        alert($(this).siblings('label').text());
      }
    });
  });


  function blockUser() {
    // Get the values of all the form elements
    const checkboxes = document.querySelectorAll('.blockuser');
    const checkedCheckboxes = [];
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        checkedCheckboxes.push(checkbox.id);
      }
    });
    if (checkedCheckboxes.length > 0) {
      alert('Checked checkboxes: ' + checkedCheckboxes.join(', '));
    } else {
      alert('Please select at least one checkbox.');
    }

    const recipientId = $(event.target).data('recipient-id');
    alert(recipientId);
    // Get the selected reasons for blocking the user
    const pornographicContent = $('#blockUserModal-' + recipientId + ' #pornographic-content').is(':checked');
    const notAFanOfPosts = $('#blockUserModal-' + recipientId + ' #not-a-fan-of-posts').is(':checked');
    const bloodyContent = $('#blockUserModal-' + recipientId + ' #bloody-content').is(':checked');
    const flashyContent = $('#blockUserModal-' + recipientId + ' #flashy-content').is(':checked');
    const otherReasonCheckbox = $('#blockUserModal-' + recipientId + ' #other-reason').is(':checked');
    const otherReasonTextbox = $('#blockTypeofPostModal-' + recipientId + ' #other-reason-textbox').val();

    const form = new FormData();
    form.append("recipientId", recipientId);
    form.append("pornographicContent", pornographicContent);
    form.append("notAFanOfPosts", notAFanOfPosts);
    form.append("bloodyContent", bloodyContent);
    form.append("flashyContent", flashyContent);
    form.append("otherReason", otherReasonCheckbox);
    form.append("otherReasonText", otherReasonTextbox);

    $.ajax({
      url: 'blockuser.php',
      type: 'POST',
      data: form,
      processData: false,
      contentType: false,
      success: function(response) {
        console.log(response);
        alert("User blocked successfully.");
      },
      error: function(error) {
        console.error(error);
        alert("An error occurred while blocking the user. Please try again later.");
      }
    });
  }
</script>
<script>
  $(document).ready(function() {
    // Add event listener to "other reason" checkbox
    $('#other-reason-posts').on('change', function() {
      if ($(this).is(':checked')) {
        $('#other-reason-textbox-posts').show();
      } else {
        $('#other-reason-textbox-posts').hide();
      }
    });

    // Add event listener to all checkboxes
    $(".blockpost").on('change', function() {
      if ($(this).is(':checked')) {
        alert($(this).siblings('label').text());
      }
    });
  });
  //  check UserId of the post before modal
  // $(document).on('click', '.blockButton', function() {
  //   var postId = $(this).data('postid');
  //   alert(postId);
  // });

  function blockPosts() {
    // Get the values of all the form elements
    const checkboxes = document.querySelectorAll('.blockpost');
    const checkedCheckboxes = [];
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        checkedCheckboxes.push(checkbox.id);
      }
    });
    if (checkedCheckboxes.length > 0) {
      alert('Checked checkboxes: ' + checkedCheckboxes.join(', '));
    } else {
      alert('Please select at least one checkbox.');
    }

    const postId = $(event.target).closest('.modal').data('postid');
    // Retrieve the post ID from the hidden input field
    alert(postId);
    const pornographicContentPosts = $('#blockTypeofPostModal-' + postId + ' #pornographic-content-posts').is(':checked');
    alert(pornographicContentPosts);
    const racistPosts = $('#blockTypeofPostModal-' + postId + ' #racist-posts').is(':checked');
    alert(racistPosts);
    const bloodyContentPosts = $('#blockTypeofPostModal-' + postId + ' #bloody-content-posts').is(':checked');
    alert(bloodyContentPosts);
    const flashyContentPosts = $('#blockTypeofPostModal-' + postId + ' #flashy-content-posts').is(':checked');
    alert(flashyContentPosts);
    const otherReasonCheckboxPosts = $('#blockTypeofPostModal-' + postId + ' #other-reason-posts').is(':checked');
    alert(otherReasonCheckboxPosts);
    const otherReasonTextPosts = $('#blockTypeofPostModal-' + postId + ' #other-reason-text-posts').val();

    // Assuming you want to submit the form data to a server endpoint using JavaScript fetch API:
    const form = new FormData();
    form.append("postId", postId);
    form.append("pornographicContentPosts", pornographicContentPosts);
    form.append("racistPosts", racistPosts);
    form.append("bloodyContentPosts", bloodyContentPosts);
    form.append("flashyContentPosts", flashyContentPosts);
    form.append("otherReasonCheckboxPosts", otherReasonCheckboxPosts);
    form.append("otherReasonTextPosts", otherReasonTextPosts);
    form.append("checkedCheckboxes", checkedCheckboxes);

    $.ajax({
      url: 'blockpost.php',
      type: 'POST',
      data: form,
      processData: false,
      contentType: false,
      success: function(response) {
        // confirm what is being said in the console
        console.log(response);
        if (response == "success") {
          console.log(response);
          alert("Post type blocked successfully.");
          // alert checked checkbox
          alert(checkedCheckboxes);
          $('#blockTypeofPostModal-' + postId).modal('hide');
        }
      },
      error: function(response) {
        console.error(response);
        alert("An error occurred while blocking the type of post. Please try again later.");
      }
    });
  }
</script>

</html>