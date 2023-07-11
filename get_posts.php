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
    echo json_encode(array('error' => "Error executing query: " . sqlsrv_errors()[0]['message']), JSON_PRETTY_PRINT);
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
        'image' => $row['image'],
        'video' => $row['video'],
        'title' => $row['title'],
        'content' => $row['content'],
        'timeAgo' => getTimeAgo($interval),
        'likes' => $likes,
        'isLiking' => $isLiking,
        // 'carouselItems' => []
    );

    // // Add the image to the carouselItems array if it exists
    // if (!empty($row['image'])) {
    //     $imageItem = '<div class="post-item"><img class="post-image" src=' . $row['image'] . '></div>';
    //     $post['carouselItems'][] = $imageItem;
    // }

    // // Add the video to the carouselItems array if it exists
    // if (!empty($row['video'])) {
    //     $videoItem = '<div class="post-video">';
    //     $videoItem .= '<video data-my-Video-id="' . $postId . '" id="myVideo-' . $postId . '" class="w-100">';
    //     $videoItem .= '<source src=' . $row['video'] . ' type="video/mp4">';
    //     $videoItem .= '</video>';
    //     $videoItem .= 'Your browser does not support the video tag.';
    //     $videoItem .= '<div class="video-controls">';
    //     $videoItem .= '<button id="rewindButton-' . $postId . '" onclick="rewind(\'' . $postId . '\')"><i class=\'bi bi-rewind\'></i></button>';
    //     $videoItem .= '<button onclick="togglePlayPause(\'' . $postId . '\')">';
    //     $videoItem .= '<span id="playPauseButton-' . $postId . '"><i class=\'bi bi-play\'></i></span>';
    //     $videoItem .= '</button>';
    //     $videoItem .= '<button id="fastForwardButton-' . $postId . '" onclick="fastForward(\'' . $postId . '\')"><i class=\'bi bi-fast-forward\'></i></button>';
    //     $videoItem .= '<div class="volume-control">';
    //     $videoItem .= '<input type="range" id="volumeRange-' . $postId . '" min="0" max="1" step="0.01" value="1" onchange="setVolume(\'' . $postId . '\')">';
    //     $videoItem .= '</div>';
    //     $videoItem .= '<div class="time-control">';
    //     $videoItem .= '<input type="range" id="timeRange-' . $postId . '" min="0" step="0.01" value="0" onchange="setCurrentTime(\'' . $postId . '\')">';
    //     $videoItem .= '<div class="time-display">';
    //     $videoItem .= '<div class="currentTimeDisplay" id="currentTimeDisplay-' . $postId . '">0:00</div>';
    //     $videoItem .= '<div class="slash" id="slash-' . $postId . '">/</div>';
    //     $videoItem .= '<div class="durationDisplay" id="durationDisplay-' . $postId . '">0:00</div>';
    //     $videoItem .= '</div>';
    //     $videoItem .= '</div>';
    //     $videoItem .= '</div>';
    //     $videoItem .= '</div>';
    //     $post['carouselItems'][] = $videoItem;
    // }

    // Push the post into the array
    $posts[] = $post;
}

// Encode the posts array as JSON and send it as the response
echo json_encode(array('posts' => $posts), JSON_PRETTY_PRINT);

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
