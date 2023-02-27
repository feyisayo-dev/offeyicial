<?php
    // Connect to the database
    include ('db.php'); 
    $result = sqlsrv_query($conn, "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, posts.Likes, posts.Comments, posts.Shares 
FROM posts 
JOIN User_Profile ON User_Profile.UserId = posts.UserId 
ORDER BY posts.date_posted DESC");



while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $date_posted = new DateTime($row['date_posted']);
    $formatted_date = date_format($date_posted, 'Y-m-d H:i:s');
    
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
  $num_likes = $row['Likes'];
  $num_comments = $row['Comments'];
  $num_shares = $row['Shares'];

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
//   $date_posted = date_format($row['date_posted'], 'Y-m-d H:i:s');
  echo '<p class="post-date">' . $time_ago . '</p>';
  echo '</div>';
  echo '<div class="post-footer">';
  echo '<button class="like-button" data-postid="' . $row['PostId'] . '">' . '<i class="bi bi-hand-thumbs-up"></i>' . 'Like <span class="num-likes">' . $row['Likes'] . '</span></button>';
  echo '<button class="comment-button" data-postid="' . $row['PostId'] . '">' . '<i class="bi bi-chat-dots"></i>' . 'Comment <span class="num-comments">' . $row['Comments'] . '</span></button>';
  echo '<button class="share-button" data-postid="' . $row['PostId'] . '">' . '<i class="bi bi-share"></i>' . 'Share</button>';
  echo '</div>';
echo '</div>';
  
}

?>