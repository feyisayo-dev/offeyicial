<?php
session_start();
    // Connect to the database
    include ('db.php');
    $UserId = $_SESSION['UserId'];
    $query = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, COUNT(likes.PostId) AS num_likes, MAX(CASE WHEN likes.UserId = ? THEN 1 ELSE 0 END) AS is_liking
    FROM posts 
    JOIN User_Profile ON User_Profile.UserId = posts.UserId 
    LEFT JOIN likes ON likes.PostId = posts.PostId
    GROUP BY User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted
    ORDER BY posts.date_posted DESC";
$params = array($UserId);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
echo "Error executing query: " . sqlsrv_errors()[0]['message'];
exit;
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
// Your code to display the posts
$date_posted = new DateTime($row['date_posted']);
$formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
$postId = $row['PostId'];
$likes = $row['num_likes'];
$islikeing = $row['is_liking'];
$current_date = new DateTime();
$date_postedx = new DateTime($formatted_date);
$interval = $current_date->diff($date_postedx);

if ($interval->y) {
  $time_ago = $interval->y . " years ago";
} else if ($interval->m) {
  $time_ago = $interval->m . " months ago";
} else if ($interval->d) {
  $time_ago = $interval->d . " days ago";
} else if ($interval->h) {
  $time_ago = $interval->h . " hours ago";
} else if ($interval->i) {
  $time_ago = $interval->i . " minutes ago";
} else {
  $time_ago = $interval->s . " seconds ago";
}
// Store Likes, Comments, and Shares values in variables
echo '<section id="'.$postId.'">';
echo '<div class="post">';
echo '<div class="news-feed-post">';
echo '<div class="post-header">';
echo '<img class="UserPassport" src="UserPassport/' . $row['Passport'] . '">';
echo '<p class="post-author">' . $row['Surname'] . ' ' . $row['First_Name'] . '</p>';
echo '</div>';
echo '<h2 class="post-title">' . $row['title'] . '</h2>';
echo '<p class="post-content">' . $row['content'] . '</p>';
if (!empty($row['image'])) {
  echo '<img class="post-image" src="' . $row['image'] . '">';
}
if (!empty($row['video'])) {
  echo '<div class="post-video"><iframe src="' . $row['video'] . '"></iframe></div>';
}
    //   $date_posted = date_format($row['date_posted'], 'Y-m-d H:i:s');
      echo '<p class="post-date">' . $time_ago . '</p>';
      echo '</div>';
      echo '<div class="footer">
      <button type="button" class="btn btn-primary like ' . ($islikeing ? 'likeing' : 'unlike') . '" data-postid="' . $postId . '">
          <span class="like-count">' . $likes . '</span>
          ' . ($islikeing ? 'Unlike' : 'Like') . '
          <span class="emoji">&#x2764;</span>
      </button>
      <button type="button" class="btn btn-primary share-button" data-postid="' . $postId . '">
          <i class="bi bi-share"></i> Share
      </button>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
          <i class="bi bi-chat-dots"></i> Comment
      </button>
  </div>';
    echo '</section>';
    }

?>