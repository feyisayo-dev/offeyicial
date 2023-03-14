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
<?php
include('db.php');
  

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

  <!-- <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> -->
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <style>
section {
  width: 100%;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.post {
  width: 100%;
  margin: 0 auto;
  max-width: 600px;
  background-color: white;
  border: 1px solid #ddd;
  margin-bottom: 20px;
}

.post-header {
  display: flex;
  align-items: center;
  padding: 10px;
}
.post-author{
  font-size: 20px;
  color: black;
  font: Arial, Helvetica;
}

.post-header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.post-title {
  font-size: 20px;
  font-weight: bold;
  margin: 10px;
}

.post-content {
  margin: 10px;
}

.post-image {
  width: 100%;
  height: auto;
}

.post-video {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 56.25%;
}

.post-video iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.post-date {
  margin: 10px;
  color: #999;
  font-size: 12px;
}

.footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border-top: 1px solid #ddd;
}

.footer button {
  display: flex;
  align-items: center;
  background: transparent;
  border: none;
  font-size: 14px;
  color: #666;
  cursor: pointer;
  padding: 5px 10px;
  transition: all 0.3s;
}

.footer button:hover {
  background-color: #ddd;
}

.footer button .like-count {
  margin-right: 5px;
  font-weight: bold;
}

.footer button .emoji {
  margin-left: 5px;
}

.likeing {
  color: #e74c3c;
}

.unlike {
  color: #666;
}

.share-button {
  display: flex;
  align-items: center;
}

.share-button i {
  margin-right: 5px;
}

.comment-button {
  display: flex;
  align-items: center;
}

.comment-button i {
  margin-right: 5px;
}
@media (max-width: 767px) {
  body {
    width: 100%;
  }
  /* Reduce font sizes */
  .post-title {
    font-size: 24px;
  }
  .post-author {
    font-size: 14px;
  }
  .post-content {
    font-size: 16px;
  }
  .post-date {
    font-size: 12px;
  }
  
  /* Center post image and video */
  .post-image,
  .post-video {
    display: block;
    margin: 0 auto;
    max-width: 100%;
  }
  
  /* Adjust padding and margins */
  .post-header {
    padding: 10px;
  }
  .post {
    margin-bottom: 20px;
  }
  
  /* Reduce button sizes */
  .btn {
    padding: 6px 12px;
    font-size: 14px;
  }
  
  /* Hide UserPassport image */
  .UserPassport {
    display: none;
  }
  
  /* Adjust spacing between elements */
  .post-header {
    margin-bottom: 10px;
  }
  .post-date {
    margin-top: 10px;
  }
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
        @media (max-width: 767px) {
/* Set the height of the navbar to 100% */
.navbar {
height: 100%;
}

/* Set the height of the collapsed navbar to 100vh */
.navbar-collapse {
height: 100vh;
}

/* Set the position of the collapsed navbar to fixed */
.navbar-collapse.show {
position: fixed;
top: 0;
left: 0;
right: 0;
bottom: 0;
z-index: 9999;
overflow-y: scroll;
}

/* Set the padding of the navbar items */
.navbar-nav {
padding-top: 30px;
padding-bottom: 30px;
}

/* Set the font size and padding of the navbar items */
.navbar-nav .nav-link {
font-size: 18px;
padding: 10px;
}

/* Set the color of the navbar items */
.navbar-nav .nav-link.custom-link {
color: #fff;
background-color: #28a745;
border-radius: 5px;
padding: 8px 15px;
}

/* Set the position of the search bar */
.search-container {
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
}

/* Set the width of the search bar */
.searchtext {
width: 100%;
padding: 10px;
border-radius: 5px;
border: none;
}
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
.allcoments {
  display: flex;
  flex-direction: row;
  margin-bottom: 10px;
  max-height: 200px; /* adjust height as needed */
  overflow-y: auto;
}

.commentauthor {
  display: inline-block;
  vertical-align: top; /* This ensures the image and name are aligned at the top */
  margin-right: 10px; /* Add some space between the image and name */
}

.commentpassport {
  width: 30px; /* Adjust the width of the image as needed */
  height: 30px; /* Adjust the height of the image as needed */
  border-radius: 50%;
}


.post-name {
  margin: 0;
  font-weight: bold;
}

.seecomments {
  flex: 1;
  background-color: #f5f5f5;
  border-radius: 10px;
  padding: 5px 10px;
  font-size: 14px;
}
#commentInput{
  height: 40px;
  border-radius: 10px;
  box-shadow: 2px 2px 2px blue;
}
.notification {
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  color: #333;
  padding: 10px;
  margin-bottom: 10px;
  transition: opacity 0.5s ease-in-out;
}

.notification.hidden {
  opacity: 0;
}
#scrollToTopBtn {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 30px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    background-color: #555;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 4px;
}

#scrollToTopBtn:hover {
    background-color: #444;
}



  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php"><span class="text-success">Offeyicial</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
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
echo '<section>';
echo '<div class="post">';
echo '<div class="news-feed-post"  id="'.$postId.'">';
echo '<div class="post-header">';
echo '<img class="UserPassport" src="UserPassport/' . $row['Passport'] . '">';
echo '<a href="user_profile.php?UserId='.$row['UserId'].'" style="text-decoration: none;"><p class="post-author"><strong>' . $row['Surname'] . ' ' . $row['First_Name'] . '</strong></p></a>';
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
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal" data-postid="'.$postId.'">
      <i class="bi bi-chat-dots"></i> Comment
    <input type="hidden" id="postId" value="'.$postId.'">

  </button>  
  </div>';
    echo '</section>';
    }
?>
<button id="scrollToTopBtn"><i class="fas fa-arrow-up"></i></button>

<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="commentModalLabel">Comment</h5>
      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="comments">

    </div>
    <div class="modal-body">
    <textarea class="form-control"name="commentText" placeholder="Type your comment here" id="commentInput" rows="3"></textarea>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onclick="submitComment()">Comment</button>
    </div>
  </div>
</div>
</div>

</div>

</body>
<script>
   $(document).ready(function() {
  $('#commentModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var postId = button.data('postid');
    var modal = $(this);

    $.ajax({
      type: "POST",
      url: "getCommentBox.php",
      data: {postId: postId},
      success: function(response) {
        modal.find('.comments').html(response);
      }
    });
  });
});

</script>
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
    // Set up variables
    var lastScrollTop = 0;
    var newsfeedLoaded = true;

    // Check if user has scrolled to the top of the page
    $(window).scroll(function(event){
        var st = $(this).scrollTop();
        if (st == 0 && st < lastScrollTop && newsfeedLoaded) {
            // Set newsfeedLoaded to false to prevent multiple AJAX requests
            newsfeedLoaded = false;

            // Call AJAX function to reload news feed
            reloadNewsFeed();
        }
        lastScrollTop = st;
    });

    // Function to reload news feed
    function reloadNewsFeed() {
        // Call AJAX function to reload news feed
        $.ajax({
            url: 'news-feed.php',
            type: 'GET',
            success: function(data) {
                $('.news-feed-container').html(data);

                // Set newsfeedLoaded back to true
                newsfeedLoaded = true;
            }
        });
    }
});
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
            success: function (data) {
                alert(data)
                $("#commentInput").val("");
            }
        });
    } else {
        alert("Field Missing");
    }

    // Close the modal
    $("#commentModal").modal("hide");
}

</script>

        <script>
          var UserId = <?php echo json_encode($UserId); ?>; 
          // Share button
        $(document).on('click', '.share-button', function() {
          var postId = $(this).data('postid');
          var shareUrl = 'http://localhost:8080/offeyicialchatroom/index.php?postId=' + postId;
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
        $('html, body').animate({scrollTop : 0},10);
        return false;
    });
});

</script>
</html>
