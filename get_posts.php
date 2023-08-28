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
