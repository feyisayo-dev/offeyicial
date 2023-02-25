<?php
    // Connect to the database
    include ('db.php'); 
    $result = sqlsrv_query($conn, "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted 
FROM posts 
JOIN User_Profile ON User_Profile.UserId = posts.UserId 
ORDER BY posts.date_posted DESC");



while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
  $date_posted = date_format($row['date_posted'], 'Y-m-d H:i:s');
  $current_date = new DateTime();
  $date_postedx = new DateTime($date_posted);
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
  echo '<div class= "post">';
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
  $date_posted = date_format($row['date_posted'], 'Y-m-d H:i:s');
  echo '<p class="post-date">' . $time_ago . '</p>';
  echo '</div>';
  echo '<div class="post-footer">';
  echo '<button>' . '<i class="bi bi-hand-thumbs-up"></i>' . 'Like' . '</button>';
  echo '<button>' . '<i class="bi bi-chat-dots"></i>' . 'Comment' . '</button>';
  echo '<button>' . '<i class="bi bi-share"></i>' . 'Share' . '</button>';
echo '</div>';
echo '</div>';
  
}

?>