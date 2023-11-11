<?php
session_start();
?>
<?php
include('db.php');
$UserId = $_SESSION['UserId'];
?>

<!-- rest of your HTML code -->
<!DOCTYPE html>
<html>

<head>
  <title>
    Share a Post
  </title>

  <link rel="stylesheet" href="css\font\bootstrap-icons.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <style>
    /* Add mobile-friendly styles */
    @media (max-width: 500px) {
      body {
        font-size: 12px;
      }

      #title,
      #content {
        width: 100%;
      }

      .title_container strong {
        font-size: 30px;
        width: 100%;
      }

      .form-group {
        padding: 0.5rem;
      }

      .custom-body .submit,
      .custom-body .profile {
        width: 100%;
      }
    }


    .custom-body {
      background-color: #f2f2f2;
      font-family: Arial, sans-serif;
      font-size: 16px;
    }

    .container {
      background: url(img/13.jpeg);
      background-size: cover;
      width: 100%;
      margin: 50px auto;
      padding: 40px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .title_container {
      text-align: center;
      margin-bottom: 30px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
      color: white;
    }

    input[type="text"],
    textarea {
      width: 100%;
      /* padding: 10px; */
      border-radius: 5px;
      border: 1px solid #ddd;
      margin-bottom: 20px;
      resize: vertical;
      height: 40px;
    }

    .custom-file-label {
      padding: 10px;
      border-radius: 5px;
      /* border: 1px solid #ddd; */
      margin-top: 20px;
      cursor: pointer;
    }

    .submit {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
    }

    .profile {
      background-color: #ddd;
      color: #333;
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
      width: 123px;
    }

    .profile:hover {
      background-color: #333;
      color: #fff;
    }

    strong {
      color: pink;
      font-family: 'Calligraffitti';
      /* sets text color to red */
      font-size: 50px;
      /* sets font size to 20px */
      text-align: center;
      /* centers the text */
      background: transparent;
      width: 50%;
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

    .navbar-brand img {
      display: inline-block;
      height: 30px;
      /* adjust height as needed */
      margin-right: 10px;
      /* add some space between image and text */
    }




    .custom-link {
      text-decoration: none;
      cursor: pointer;
    }

    .custom-file-input {
      opacity: 0;
      position: absolute;
      pointer-events: none;
    }

    .custom-file-label {
      cursor: pointer;
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
      /* border: 1px solid #ddd; */
      border-top: none;

    }

    .fixed-size-video {
      width: 400px;
      height: 300px;
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

    #modalicon {
      color: black;
    }

    #modalicon:hover {
      transform: scaleX(1.05);
      color: green;
    }

    .carousel {
      text-align: center;
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <a class="navbar-brand" href="home.php"><span class="text-success">Offeyicial </span></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navmenu">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
      </li>
      <li class="nav-item">
        <div class="search-container">
          <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
          <div id="user_table">
      </li>
      <li class="nav-item">
        <a class="nav-link custom-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i>Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link custom-link" onclick="window.location.href='index.php'"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
      </li>

  </div>
</nav>

<body class="custom-body">
  <div class="container">
    <div class="title_container">
      <strong>Unleash Your Creativity!</strong>
    </div>
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title">
    </div>
    <div class="form-group">
      <label for="content">Content:</label>
      <textarea id="content" name="content"></textarea>
    </div>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" multiple>
      <label class="custom-file-label" for="image"><i class="bi bi-image"></i> Choose Images</label>
    </div>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="video" name="video" accept="video/*" multiple>
      <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i> Choose Video</label>
    </div>
    <input type="submit" value="Add Post" class="submit">
    <input class="profile" value="Back to profile" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'">
  </div>
</body>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<div class="modal" id="previewModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="carousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner" id="previewContainer"></div>
          <a class="carousel-control-prev modalicon" href="#carousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" id="modalicon" aria-hidden="true"></span>
            <span class="sr-only"></span>
          </a>
          <a class="carousel-control-next modalicon" href="#carousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" id="modalicon" aria-hidden="true"></span>
            <span class="sr-only"></span>
          </a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm accept">Accept</button>
        <button type="button" class="btn btn-primary btn-sm cancel" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="node_modules/socket.io-client/dist/socket.io.js"></script>
<script>
  var UserId = "<?php echo $_SESSION['UserId']; ?>";
  var socketUrl = 'http://localhost:8888';
  const socket = io(socketUrl, {
    query: {
      UserId,
    }
  });
  let attemptForConnect = 0;
  socket.on('connect', () => {
    console.log('Socket.IO connection established');
    socket.emit('userConnected', UserId);
    if (attemptForConnect === 0) {
      attemptForConnect++;
    } else {
      console.log('Reconnected');
    }
    var offlinePosts = JSON.parse(localStorage.getItem('offlinePosts'));
    if (offlinePosts && offlinePosts.length > 0) {
      offlinePosts.forEach(function(post) {
        fetch('http://localhost:8888/submitPost', {
            method: 'POST',
            body: form_data,
          })
          .then((response) => {
            if (!response.ok) {
              throw new Error('Error submitting post');
            }
            return response.json();
          })
          .then((result) => {
            if (result) {
              alert('post submitted successfully');
            } else {
              console.log(null);
            }
          })
          .catch((error) => {
            reject(error);
          });
      });
      localStorage.removeItem('offlinePosts');
    }
  });

  socket.on('disconnect', () => {
    socket.emit('userDisconnected', UserId);
  });

  $(document).ready(function() {
    $('.custom-file-input').on('change', function() {
      var files = this.files;
      var fileType = this.accept.split('/')[0];
      var previewContainer = $('#previewContainer');
      var modalicon = document.querySelectorAll('.modalicon');
      modalicon.style.display = 'block';
      previewContainer.empty();

      if (fileType === 'image') {
        if(files && files.length > 1){
          $.each(files, function(index, file) {
          var reader = new FileReader();
          reader.onload = function(e) {
            var activeClass = (index === 0) ? 'active' : '';
            previewContainer.append('<div class="carousel-item ' + activeClass + '"><img src="' + e.target.result + '" class="img-fluid"></div>');
          };
          reader.readAsDataURL(file);
        });
        }else{
          $.each(files, function(index, file) {
          var reader = new FileReader();
          reader.onload = function(e) {
            var activeClass = (index === 0) ? 'active' : '';
            modalicon.style.display = 'none';
            previewContainer.append('<div class="carousel-item ' + activeClass + '"><img src="' + e.target.result + '" class="img-fluid"></div>');
          };
          reader.readAsDataURL(file);
        });
        }
        
      } else if (fileType === 'video') {
        $.each(files, function(index, file) {
          var videoURL = URL.createObjectURL(file);
          var activeClass = (index === 0) ? 'active' : '';
          previewContainer.append('<div class="carousel-item ' + activeClass + '"><video src="' + videoURL + '" class="fixed-size-video" controls></video></div>');
        });
      }

      $('.accept').data('type', fileType);
      $('.cancel').data('type', fileType);

      var label = $(this).siblings('.custom-file-label');
      var fileNames = [];

      if (files && files.length > 0) {
        $.each(files, function(index, file) {
          fileNames.push(file.name);
        });
        label.html(fileNames.join('<br>'));
      } else {
        if (fileType === 'video') {
          label.html('<i class="bi bi-camera-video"></i> Choose Video');
        } else {
          label.html('<i class="bi bi-image"></i> Choose image');
        }
      }

      $('#previewModal').modal('show');
    });
    $('.cancel').click(function() {
    var fileType = $(this).data('type');
    var label = $(this).closest('.custom-file').find('.custom-file-label');

    if (fileType === 'video') {
        $('#video').val(null);
        label.html('<i class="bi bi-camera-video"></i> Choose Video');
    } else {
        $('#image').val(null);
        label.html('<i class="bi bi-image"></i> Choose image');
    }
});

    $('.accept').click(function() {
      var fileType = $(this).data('type');
      var fileInputs = [];

      if (fileType === 'image') {
        fileInputs = $('#image').get(0).files;
      } else if (fileType === 'video') {
        fileInputs = $('#video').get(0).files;
      }

      if (fileInputs.length > 0) {
        var fileNames = [];

        for (var i = 0; i < fileInputs.length; i++) {
          fileNames.push(fileInputs[i].name);
        }

        alert('Selected Files: ' + fileNames.join(', '));

        $('#previewContainer').empty();
        $('#previewModal').modal('hide');

      } else {
        alert('No files selected.');
      }
    });
  });


  $(document).ready(function() {
    $('.submit').click(function() {
      var title = $('#title').val();
      var content = $('#content').val();
      var imageFiles = $('#image').prop('files');
      var videoFiles = $('#video').prop('files');

      if (title === '' || content === '') {
        alert('Title and content are required.');
        return;
      }

      var form_data = new FormData();
      form_data.append('title', title);
      form_data.append('content', content);
      form_data.append('UserId', UserId);


      $.each(imageFiles, function(index, file) {
        form_data.append('image[]', file);
      });

      $.each(videoFiles, function(index, file) {
        form_data.append('video[]', file);
      });
      const formDataArray = Array.from(form_data.entries());

      alert(JSON.stringify(formDataArray, null, 2));

      if (socket.connected) {
        fetch('http://localhost:8888/submitPost', {
            method: 'POST',
            body: form_data,
          })
          .then((response) => {
            if (!response.ok) {
              throw new Error('Error submitting post');
            }
            return response.json();
          })
          .then((result) => {
            if (result) {
              alert('post submitted successfully');
            } else {
              console.log(null);
            }
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        var offlinePosts = localStorage.getItem('offlinePosts') || [];
        offlinePosts.push({
          form_data
        });
        localStorage.setItem('offlinePosts', JSON.stringify(offlinePosts));
      }

      //     $.ajax({
      //       url: 'addpost.php',
      //       dataType: 'text',
      //       cache: false,
      //       contentType: false,
      //       processData: false,
      //       data: form_data,
      //       type: 'post',
      //       success: function(response) {
      //         if (response === "success") {
      //           console.log("Post added successfully");
      //           alert("Post added successfully");
      //           alert(response);
      //           window.location.href = "index.php";
      //         } else {
      //           console.log("Error adding post: " + response);
      //           alert("Error adding post: " + response);
      //           $('#title').val('');
      //           $('#content').val('');
      //           $('#image').val('');
      //           $('#video').val('');
      //         }
      //       }
      //     });
    });
  });

  $(document).ready(function() {
    $("#search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#user_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  const searchBox = document.getElementById('search');
  const resultsDiv = document.getElementById('user_table');

  searchBox.addEventListener('input', function() {
    const searchTerm = this.value;

    if (!searchTerm.trim()) {
      resultsDiv.innerHTML = '';
      return;
    }

    $("#search").on("keyup", function() {
      var search_query = $(this).val();
      $.ajax({
        url: "searchbackend.php",
        method: "POST",
        data: {
          search_query: search_query
        },
        success: function(data) {
          $("#user_table").html(data);
        }
      });
    });
  });
</script>


</html>