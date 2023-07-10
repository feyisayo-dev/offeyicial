<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];
$query = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, COUNT(likes.PostId) AS num_likes, MAX(CASE WHEN likes.UserId = posts.UserId THEN 1 ELSE 0 END) AS is_liking
    FROM posts
    JOIN User_Profile ON User_Profile.UserId = posts.UserId
    LEFT JOIN likes ON likes.PostId = posts.PostId
    GROUP BY User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted
    ORDER BY posts.date_posted DESC";
$result = sqlsrv_query($conn, $query);

if ($result === false) {
    echo json_encode(array('error' => "Error executing query: " . sqlsrv_errors()[0]['message']));
    exit;
}

$posts = array(); // Create an empty array to store the posts

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $date_posted = new DateTime($row['date_posted']);
    $formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
    $postId = $row['PostId'];
    $likes = $row['num_likes'];
    $isLiking = $row['is_liking'];
    $current_date = new DateTime();
    $date_postedx = new DateTime($formatted_date);
    $interval = $current_date->diff($date_postedx);
    $Passport = $row['Passport'];
    if (empty($Passport)) {
        $GetPassport = "UserPassport/DefaultImage.png";
    } else {
        $GetPassport = "UserPassport/" . $Passport;
    }

    // Create an associative array for each post
    $post = array(
        'surname' => $row['Surname'],
        'firstName' => $row['First_Name'],
        'UserId' => $row['UserId'],
        'passport' => $GetPassport,
        'postId' => $postId,
        'title' => $row['title'],
        'content' => $row['content'],
        'timeAgo' => getTimeAgo($interval),
        'likes' => $likes,
        'isLiking' => $isLiking,
        'carouselItems' => []
    );

    // Add the image to the carouselItems array if it exists
    if (!empty($row['image'])) {
        $imageItem = '<div class="post-item"><img class="post-image" src=' . trim($row['image'], '"') . '></div>';
        $post['carouselItems'][] = $imageItem;
    }

    // Add the video to the carouselItems array if it exists
    if (!empty($row['video'])) {
        $videoItem = '<div class="post-item">';
        $videoItem .= '<video data-my-Video-id="' . $postId . '" id="myVideo-' . $postId . '" class="w-100">';
        $videoItem .= '<source src=' . trim($row['video'], '"') . ' type="video/mp4">';
        $videoItem .= 'Your browser does not support the video tag.';
        $videoItem .= '</video>';
        $videoItem .= '<div class="video-controls">';
        $videoItem .= '<button id="rewindButton-' . $postId . '" onclick="rewind(\'' . $postId . '\')"><i class=\'bi bi-rewind\'></i></button>';
        $videoItem .= '<button onclick="togglePlayPause(\'' . $postId . '\')">';
        $videoItem .= '<span id="playPauseButton-' . $postId . '"><i class=\'bi bi-play\'></i></span>';
        $videoItem .= '</button>';
        $videoItem .= '<button id="fastForwardButton-' . $postId . '" onclick="fastForward(\'' . $postId . '\')"><i class=\'bi bi-fast-forward\'></i></button>';
        $videoItem .= '<div class="volume-control">';
        $videoItem .= '<input type="range" id="volumeRange-' . $postId . '" min="0" max="1" step="0.01" value="1" onchange="setVolume(\'' . $postId . '\')">';
        $videoItem .= '</div>';
        $videoItem .= '<div class="time-control">';
        $videoItem .= '<input type="range" id="timeRange-' . $postId . '" min="0" step="0.01" value="0" onchange="setCurrentTime(\'' . $postId . '\')">';
        $videoItem .= '<div class="time-display">';
        $videoItem .= '<div class="currentTimeDisplay" id="currentTimeDisplay-' . $postId . '">0:00</div>';
        $videoItem .= '<div class="slash" id="slash-' . $postId . '">/</div>';
        $videoItem .= '<div class="durationDisplay" id="durationDisplay-' . $postId . '">0:00</div>';
        $videoItem .= '</div>';
        $videoItem .= '</div>';
        $videoItem .= '</div>';
        $videoItem .= '</div>';
        $post['carouselItems'][] = $videoItem;
    }

    // Push the post into the array
    $posts[] = $post;
}

// Encode the posts array as JSON and send it as the response
echo json_encode(array('posts' => $posts));

// Function to calculate the time ago
function getTimeAgo($interval) {
    if ($interval->y) {
        return $interval->y . " years ago";
    } elseif ($interval->m) {
        return $interval->m . " months ago";
    } elseif ($interval->d) {
        return $interval->d . " days ago";
    } elseif ($interval->h) {
        return $interval->h . " hours ago";
    } elseif ($interval->i) {
        return $interval->i . " minutes ago";
    } else {
        return $interval->s . " seconds ago";
    }
}
?>
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