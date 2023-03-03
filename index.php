<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit();
}
?>
<?php
$UserId=$_SESSION["UserId"];
include ('db.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title>News Feed</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css\font\bootstrap-icons.css">

  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <style>
.post {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto auto auto;
  gap: 10px;
  border: 1px solid #ddd;
  padding: 10px;
}

.post-header {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 10px;
  align-items: center;
}

.UserPassport {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.post-author {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 24px;
  font-weight: bold;
  color: #1877f2;
}

.post-title {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 18px;
  font-weight: bold;
  color: #1c1e21;
  margin: 10px 0;
}

.post-content {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 14px;
  color: #1c1e21;
  line-height: 1.5;
  margin-bottom: 10px;
}

.post-image, .post-video, iframe {
  width: 100%;
  max-width: 500px;
  margin: 10px 0;
  height: 500px;
}

.post-date {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  color: #90949c;
  margin-top: 10px;
}

.post-footer {
  display: grid;
  grid-template-columns: repeat(3, auto);
  gap: 10px;
  align-items: center;
}

.post-footer button {
  display: flex;
  align-items: center;
  gap: 5px;
  background-color: transparent;
  border: none;
  color: #606770;
  cursor: pointer;
  font-size: 14px;
}

.post-footer button:hover {
  text-decoration: underline;
}

.post-footer button:focus {
  outline: none;
}

.post-footer button svg {
  height: 16px;
  width: 16px;
  fill: #606770;
}

.post-footer button .count {
  font-weight: 600;
  margin-left: 2px;
}

.post-footer button.like svg {
  fill: #1877f2;
}

.post-footer button.like .count {
  color: #1877f2;
}

.post-footer button.comment svg {
  fill: #606770;
}

.post-footer button.share svg {
  fill: #606770;
}

.navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }
        
        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }
        .searchtext {
  background-color: #f2f2f2;
  border: none;
  padding: 8px;
  font-size: 16px;
  width: 200px;
  border-radius: 10px;
}

/* searchdropdown */
.search-container {
  position: relative;
}

#user_table {
  list-style: none;
  padding: 0;
  margin: 0;
  width: 100%;
  position: absolute;
  z-index: 9999;
  background-color: #fff;
  border: 1px solid #ddd;
  border-top: none;

}

#user_table li {
  padding: 8px 12px;
  cursor: pointer;
  text-decoration: none;
}

#user_table li:hover {
  background-color: #f2f2f2;
  text-decoration: none;

}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
                                <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link custom-link" onclick="window.location.href='upload.php'"><i class="bi bi-plus-square"></i>Add a Post</a>
                            </li>
                            <li class="nav-item">
                            <div class="search-container">
                                <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                                <div id="user_table">
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Logout</a>
                            </li>

        </div>
    </nav>
    <br><br>
<div class="news-feed-container">
<br>
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

  echo '<div class="post" id="post-'.$row['PostId'].'">';
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
</div>

</body>
<script>
  // Get postId from URL parameter
var urlParams = new URLSearchParams(window.location.search);
var postId = urlParams.get('postId');

// Scroll to post with matching id
if (postId) {
  var postElement = document.getElementById('post-' + postId);
  if (postElement) {
    postElement.scrollIntoView();
  }
}

</script>
<script>
            $(document).ready(function() {
                // Update newsfeed every 20 seconds
                setInterval(function() {
                    $.ajax({
                        url: 'news-feed.php',
                        type: 'GET',
                        success: function(data) {
                            $('.post').html(data);
                        }
                    });
                }, 20000);
            });

        </script>
        <script>
// Like button
$('.like-button').click(function() {
    let postId = $(this).data('postid');

    $.ajax({
        url: 'like_posts.php',
        type: 'POST',
        data: { PostId: postId },
        dataType: 'json',
        success: function(data) {
            let numLikes = parseInt($('.num-likes', this).text()) + data.Likes;

            $('.num-likes', this).text(numLikes);
            if (data.Likes > 0) {
                $('i', this).removeClass('bi-hand-thumbs-down').addClass('bi-hand-thumbs-up');
            } else {
                $('i', this).removeClass('bi-hand-thumbs-up').addClass('bi-hand-thumbs-down');
            }
        }
    });
});
</script>
<script>
  // COMMENT SECTION
$(document).on('click', '.comment-button', function() {
  var postId = $(this).data('postid');
  var commentBox = $(this).siblings('.comment-box');
  
  if (commentBox.length) {
    commentBox.toggle();
  } else {
    commentBox = $('<div class="comment-box"><textarea></textarea><button class="submit-comment">Submit</button></div>');
    $(this).parent().append(commentBox);
  }
  
  commentBox.find('.submit-comment').off('click').on('click', function() {
    var commentText = commentBox.find('textarea').val();
    $.ajax({
      url: 'comment_post.php',
      method: 'POST',
      data: { postId: postId, comment: commentText },
      dataType: 'json',
      success: function(data) {
        commentBox.find('textarea').val('');
        var numComments = commentBox.siblings('.comment-button').find('.num-comments');
        numComments.text(data.num_comments);
        var commentSection = $(data.comment_section);
        commentBox.before(commentSection);
      }
    });
  });
});
</script>
        <script>
          var UserId = <?php echo json_encode($UserId); ?>; 
          // Share button
        $(document).on('click', '.share-button', function() {
          var postId = $(this).data('postid');
          var shareUrl = 'http://localhost:8080/offeyicialchatroom/index.php?UserId=' + UserId + '&postId=' + postId;
          prompt('Copy this link to share:', shareUrl);
        });

        </script>
        <script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    if (value === "") {
      // Clear the table if the search box is empty
    //   $('#user_table').val('');

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

  // Your search function here
  $("#search").on("keyup", function() {
    var search_query = $(this).val();
    $.ajax({
      url: "searchbackend.php",
      method: "POST",
      data: {search_query:search_query},
      success: function(data){
        // Update the table with the returned results
        $("#user_table").html(data);
      }
    });
  });
});

</script>

</html>
