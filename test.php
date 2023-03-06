$sql = "SELECT * FROM likes WHERE UserId = ? AND postId = ?";
$params = array($UserId, $postId);
$stmt = sqlsrv_query($conn, $sql, $params);
$islikeing = sqlsrv_has_rows($stmt);
echo '<button id="likeBtn" class="like ' . ($islikeing ? 'likeing' : 'unlike') . '">' . ($islikeing ? 'Unlike' : 'like') . '</button>';
echo '<script>
$(document).ready(function() {
    var UserId = $_SESSION['UserId'];
    var likeBtn = $("#likeBtn");
    var postId = $_GET['postId']

    $(".like").click(function() {
        // alert("Button is working!");
        $.ajax({
            url: "like.php",
            type: "POST",
            data: {
                like: 1,
                unlike: 1,
                UserId: UserId,
                postId: postId,
            },
            success: function(response) {
                alert(response);

                if (response == "liked") {
                    likeBtn.removeClass("btn-primary").addClass("btn-secondary").text("Unlike");
                } else if (response == "unliked") {
                    likeBtn.removeClass("btn-secondary").addClass("btn-primary").text("like");
                }
                        
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    });
});
</script>';
<?php

$query = "SELECT User_Pofile.Surname, User_Profile.First_Name, User_Profile.Passport, comments.PostId, comments.UserId, comments.comment
 from comments
 join User_Profile on User_Profile.UserId = comments.UserId
 order by desc";

$query = "SELECT User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted, COUNT(likes.PostId) AS num_likes, MAX(CASE WHEN likes.UserId = ? THEN 1 ELSE 0 END) AS is_liking
    FROM posts 
    JOIN User_Profile ON User_Profile.UserId = posts.UserId 
    LEFT JOIN likes ON likes.PostId = posts.PostId
    GROUP BY User_Profile.Surname, User_Profile.First_Name, User_Profile.Passport, posts.UserId, posts.PostId, posts.title, posts.content, posts.image, posts.video, posts.date_posted
    ORDER BY posts.date_posted DESC";


if(isset($_POST['like'])){
    require('db.php');
    $UserId = $_POST['UserId'];
    $postId = $_POST['postId'];

    // Check if the user has already liked the recipient
    $sql = "SELECT * FROM likes WHERE UserId = ? AND postId = ?";
    $params = array($UserId, $postId);
    $stmt = sqlsrv_query($conn, $sql, $params);
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if($row) {
        // User has already liked the recipient, so unfollow them
        $sql = "DELETE FROM likes WHERE UserId = ? AND postId = ?";
        $params = array($UserId, $postId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "unliked";
        }
    } else {
        // User has not liked the recipient, so follow them
        $sql = "INSERT INTO likes (UserId, postId) VALUES (?, ?)";
        $params = array($UserId, $postId);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "liked";
        }
    }
}

?>



<script>
function showCommentBox() {
    // Your AJAX function for showing the comment box goes here
    var postId = <?php echo json_encode($postId); ?>;
    $.ajax({
        url: "getCommentBox.php",
        type: "POST",
        data: { postId: postId },
        success: function(data) {
            // Display the comment box
            $("#commentBox").html(data);
        },
        error: function(xhr, status, error) {
            // Handle the error response here
            alert("Error: " + error);
        }
    });
}
</script>
<script>
    function submitComment() {
    var postId = <?php echo json_encode($postId); ?>;
    var comment = $("#commentInput").val();
    
    $.ajax({
        url: "submitComment.php",
        type: "POST",
        data: {
            postId: postId,
            comment: comment
        },
        success: function(data) {
            alert(data);
            // refresh comments section
            $("#commentsSection").load("getComment.php?postId=" + postId);
            // clear comment input
            $("#commentInput").val("");
        },
        error: function(xhr, status, error) {
            alert("Error: " + error);
        }
    });
}

</script>


<script>
function share() {
  // Get the post ID from the URL parameter
  var postId = <?php echo $_GET['postId']; ?>;
  
  // Your AJAX function for sharing goes here
  $.ajax({
    url: 'SharePost.php',
    type: 'POST',
    data: {
      postId: postId
    },
    success: function(data) {
      // Handle the success response here
      alert('Post shared!');
    },
    error: function(xhr, status, error) {
      // Handle the error response here
      alert('Error sharing post: ' + error);
    }
  });
  
  // Generate the share link and prompt the user to copy it
  var shareUrl = 'http://localhost:8080/offeyicialchatroom/index.php?postId=' + postId;
  prompt('Copy this link to share:', shareUrl);
}


function comment() {
    // Your AJAX function for commenting goes here
}
</script>
     $query = "SELECT * from comments where PostId= ? order by desc";
