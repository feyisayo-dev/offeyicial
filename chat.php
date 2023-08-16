<?php
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];
$UserIdx = $_GET['UserIdx'];
// Get the name of the user you are talking to
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$UserIdx'";
$stmt = sqlsrv_prepare($conn, $sql);
if (sqlsrv_execute($stmt)) {
  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $recipientSurname = $row['Surname'];
    $recipientFirstName = $row['First_Name'];
    $Passport = $row['Passport'];
    if (empty($Passport)) {
      $recipientPassport = "UserPassport/DefaultImage.png";
    } else {
      $recipientPassport = "UserPassport/" . $Passport;
    }
  }
}

?>

<?php

function generateSessionID($length = 10)
{
  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $sessionID = '';

  $charCount = strlen($characters);
  for ($i = 0; $i < $length; $i++) {
    $sessionID .= $characters[rand(0, $charCount - 1)];
  }

  return $sessionID;
}

include('db.php');


$UserId = $_SESSION['UserId'];
$UserIdx = $_GET['UserIdx'];

// Prepare and execute the SQL query to check if the combination of UserId and UserIdx already exists
$tsql = "SELECT sessionID FROM sessionID WHERE (UserId = '$UserId' AND UserIdx = '$UserIdx') OR (UserId = '$UserIdx' AND UserIdx = '$UserId')";
$getResults = sqlsrv_query($conn, $tsql);

if ($getResults === false) {
  die(json_encode(array("status" => "error", "message" => "Error querying the database.")));
}

// Check if the combination of UserId and UserIdx already exists
if (sqlsrv_has_rows($getResults)) {
  // If the combination exists, fetch the sessionID from the result set
  $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
  $sessionID = $row['sessionID'];
} else {
  // If the combination does not exist, generate a new sessionID
  $sessionID = generateSessionID();

  // Prepare and execute the SQL query to insert the new sessionID into the database
  $tsql = "INSERT INTO sessionID (sessionID, UserId, UserIdx) VALUES ('$sessionID', '$UserId', '$UserIdx')";
  $insertResult = sqlsrv_query($conn, $tsql);

  if ($insertResult === false) {
    die(json_encode(array("status" => "error", "message" => "Error storing session ID in the database.")));
  }
}

// Free statement and connection resources
sqlsrv_free_stmt($getResults);
sqlsrv_close($conn);
?>


<?php
// Check if user is logged in
?>
<?php
include 'db.php';
$UserId = $_SESSION['UserId'];
// Get the surname and first name of the user with the UserId from the database
$rsql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
$rstmt = sqlsrv_prepare($conn, $rsql);
if (sqlsrv_execute($rstmt)) {
  while ($row = sqlsrv_fetch_array($rstmt, SQLSRV_FETCH_ASSOC)) {
    $Surname = $row['Surname'];
    $First_Name = $row['First_Name'];
  }
}
// Check if the UserId exists
$recipientId = $_GET['UserIdx'];
$sql = "SELECT * FROM User_Profile WHERE UserId = ?";
$params = array($recipientId);
$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false || !sqlsrv_has_rows($stmt)) {
  // UserId not found, redirect to 404 error page
  header("Location: error404.php");
  exit();
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Chat~<?php echo $Surname . " " . $First_Name; ?></title>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
  <link rel="stylesheet" href="css\all.min.css">
  <link rel="stylesheet" href="css\font\bootstrap-icons.css">
  <link rel="stylesheet" href="css\fontawesome.min.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/aos.css" rel="stylesheet">
  <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="css/remixicon/remixicon.css" rel="stylesheet">
  <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/chat.css" rel="stylesheet">
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="js/twemoji.min.js"></script>

</head>

<body>
  <div id="chatbox" class="chat_interface">
    <nav>

      <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success"> Offeyicial </span></div>

      <div class="profile">
        <?php
        // session_start();

        // Connect to the database
        include 'db.php';

        $UserId = $_SESSION['UserId'];

        // Get the surname and first name of the user with the UserId from the database
        $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
        $stmt = sqlsrv_prepare($conn, $sql);
        if (sqlsrv_execute($stmt)) {
          while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $Surname = $row['Surname'];
            $First_Name = $row['First_Name'];
          }
        }
        ?>
        <div class="search-container">
          <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
          <div id="user_table">
            <!-- <ul>
        <li></li>
    </ul> -->
          </div>
        </div>


        <a href="user_profile.php?UserId=<?php echo $UserId ?>" class="profile-name"><i class="bi bi-person"></i><?php echo $Surname . " " . $First_Name; ?></a>
      </div>
    </nav>




    <div class="chat-container">
    <div class="sidebar">
        <ul class="sidebar-nav">
          <li class="nav-item">
            <a class="nav-link" href="home.php"><i class="bi bi-house-door-fill"></i></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="window.location.href='user_profile.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-person"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="window.location.href='reel.php?UserId=<?php echo $UserId ?>'"><i class="bi bi-camera-reels"></i></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="window.location.href='upload.php?UserId=<?php echo $UserId ?>"><i class="bi bi-plus-square"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="notificationLink" href="#"><i class="bi bi-bell-fill"></i></a>
            <div id="notificationBox">
              <!-- Content of the notification box goes here -->
              <!-- You can customize the content as per your requirements -->
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" onclick="location.href='logoutmodal.php'"><i class="bi bi-box-arrow-right"></i></a>
          </li>
        </ul>
      </div>
      <div class="chat-header">
        <h1>
          <?php
          include 'db.php';

          // Get the UserId of the user you are talking to
          $recipientId = $_GET['UserIdx'];

          // Get the name of the user you are talking to
          $sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
          $stmt = sqlsrv_prepare($conn, $sql);
          if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $recipientSurname = $row['Surname'];
              $recipientFirstName = $row['First_Name'];
              $Passport = $row['Passport'];
              if (empty($Passport)) {
                $recipientPassport = "UserPassport/DefaultImage.png";
              } else {
                $recipientPassport = "UserPassport/" . $Passport;
              }
            }
          }

          $UserId = $_SESSION['UserId'];

          // Get the surname and first name of the user with the UserId from the database
          $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
          $stmt = sqlsrv_prepare($conn, $sql);
          if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $Surname = $row['Surname'];
              $First_Name = $row['First_Name'];
            }
            echo '<img class="recipientPassport" src="' . $recipientPassport . '">';
            echo '<a class="icon" href="user_profile.php?UserId=' . $recipientId . '">' . $recipientSurname . ' ' . $recipientFirstName . '</a>';
            // Add the reset button
            echo '<div class="dropdown">
            <button class="dropdown-toggle custom-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-target="#chtheme" aria-controls="chtheme">
              <span class="dots"></span>
              <span class="dots"></span>
              <span class="dots"></span>
            </button>

            <ul class="dropdown-menu reset" id="chtheme" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item" href="#" onclick="resetTheme()">Reset Theme</a></li>
            </ul>
          </div>';
            echo '<a class="call-icon" id="callbtn"><i class="bi bi-telephone"></i></a>';
          }
          echo '</div>';
          ?>
          <div class="chatbox">
            <div id="video-preview"></div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="foot">
                <div class="emoji-picker">
                  <!-- emoji table code goes here -->
                  <button type="button" class="btn btn-primary emoji" onclick="toggleEmojiPicker()">
                    <i class="fas fa-smile"></i>
                  </button>
                  <div class="emoji-table-container" style="display:none">
                    <table>
                      <tr>
                        <td onclick="insertEmoji('&#x1F600;')">😀</td>
                        <td onclick="insertEmoji('&#x1F601;')">😁</td>
                        <td onclick="insertEmoji('&#x1F602;')">😂</td>
                        <td onclick="insertEmoji('&#x1F603;')">😃</td>
                        <td onclick="insertEmoji('&#x1F604;')">😄</td>
                        <td onclick="insertEmoji('&#x1F605;')">😅</td>
                      </tr>
                      <tr>
                        <td onclick="insertEmoji('&#x1F606;')">😆</td>
                        <td onclick="insertEmoji('&#x1F607;')">😇</td>
                        <td onclick="insertEmoji('&#x1F608;')">😈</td>
                        <td onclick="insertEmoji('&#x1F609;')">😉</td>
                        <td onclick="insertEmoji('&#x1F610;')">😐</td>
                        <td onclick="insertEmoji('&#x1F611;')">😑</td>
                      </tr>
                      <!-- Add more rows and columns for additional emojis -->
                      <tr>
                        <td onclick="insertEmoji('&#x1F60A;')">😊</td>
                        <td onclick="insertEmoji('&#x1F60B;')">😋</td>
                        <td onclick="insertEmoji('&#x1F60C;')">😌</td>
                        <td onclick="insertEmoji('&#x1F60D;')">😍</td>
                        <td onclick="insertEmoji('&#x1F60E;')">😎</td>
                        <td onclick="insertEmoji('&#x1F60F;')">😏</td>
                      </tr>
                      <tr>
                        <td onclick="insertEmoji('&#x1F612;')">😒</td>
                        <td onclick="insertEmoji('&#x1F613;')">😓</td>
                        <td onclick="insertEmoji('&#x1F616;')">😖</td>
                        <td onclick="insertEmoji('&#x1F615;')">😕</td>
                        <td onclick="insertEmoji('&#x1F617;')">😗</td>
                        <td onclick="insertEmoji('&#x1F618;')">😘</td>
                      </tr>
                      <tr>
                        <td onclick="insertEmoji('&#x1F619;')">😙</td>
                        <td onclick="insertEmoji('&#x1F61A;')">😚</td>
                        <td onclick="insertEmoji('&#x1F61B;')">😛</td>
                        <td onclick="insertEmoji('&#x1F61C;')">😜</td>
                        <td onclick="insertEmoji('&#x1F61D;')">😝</td>
                        <td onclick="insertEmoji('&#x1F61E;')">😞</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="custom-file">
                  <input type="file" class="image-input" id="image" name="image" accept="image/*" onchange="previewImage()">
                  <label class="custom-file-label" for="image"><i class="bi bi-image"></i></label>
                </div>
                <div class="custom-file">
                  <input type="file" class="video-input" id="video" name="video" accept="video/*" onchange="previewVideo()">
                  <label class="custom-file-label" for="video"><i class="bi bi-camera-video"></i></label>
                </div>


                <div class="d-flex" style="align-items: center">
                  <textarea placeholder="Type in your message" class="form-control" id="message" rows="3" oninput="toggleButtons()"></textarea>
                  <button type="button" class="voice-note" onmousedown="startRecording('voice')" onmouseup="submitRecordedNote()" onmouseleave="cancelRecording()">
                    <i class="bi bi-mic"></i>
                  </button>
                  <button type="button" class="video-note" onmousedown="startRecording('video')" onmouseup="submitRecordedNote()" onmouseleave="cancelRecording()">
                    <i class="bi bi-camera-video"></i>
                  </button>

                  <div id="sound-visualizer" class="boxContainer">
                    <div class="box box1"></div>
                    <div class="box box2"></div>
                    <div class="box box3"></div>
                    <div class="box box4"></div>
                    <div class="box box5"></div>
                  </div>
                  <button type="submit" class="submit" id="send-button" style="display: none;"><i class="bi bi-send"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="footer">
            <?php

            // Retrieve all the chats of the current user
            $sql = "SELECT DISTINCT recipientId FROM chats WHERE UserId = '$UserId' OR recipientId= '$UserId'";
            $stmt = sqlsrv_query($conn, $sql);
            if ($stmt === false) {
              die(print_r(sqlsrv_errors(), true));
            }

            // Display the chats in a list on the sidebar
            echo '<!-- Button to open the sidebar -->
<button id="sidebar-toggle" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
<i class="bi bi-chat"></i></button>

<!-- Sidebar -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
    <button type="button" class="btn-close text-reset close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <ul class="list-unstyled">';

            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $recipientId = $row['recipientId'];

              // Get the name of the recipient
              $sql2 = "SELECT Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
              $stmt2 = sqlsrv_query($conn, $sql2);
              if ($stmt2 === false) {
                die(print_r(sqlsrv_errors(), true));
              }

              $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
              $recipientName = $row2['Surname'] . ' ' . $row2['First_Name'];
              $Passport = $row2['Passport'];
              if (empty($Passport)) {
                $passportImage = "UserPassport/DefaultImage.png";
              } else {
                $passportImage = "UserPassport/" . $Passport;
              }

              // Display the recipient name and passport image in the list
              echo '<li>';
              echo '<div class="passport">';
              echo '<a data-bs-toggle="modal" data-bs-target="#profilepicturemodal">';
              echo '<img src="' . $passportImage . '" alt="' . $recipientName . '">';
              echo '</a>';
              echo '</div>';
              echo '<div class="name"><span><a href="chat.php?UserIdx=' . $recipientId . '">' . $recipientName . '</a></span></div>';
              echo '</li>';
            }

            echo '</ul>
</div>
</div>';

            ?>
          </div>
          <!-- Ringing Box -->
          <div class="ringing-box" id="ringingBox">
            <div class="main">
              <div class="profilering">
                <div class="nameDiv">
                  <h2><?php echo $recipientFirstName . ' ' . $recipientSurname; ?></h2>
                </div>
                <div class="status">
                  <h2>Incoming Call</h2>
                </div>
                <div class="imageDiv">
                  <img src="<?php echo $recipientPassport ?>" alt="profile pic">
                </div>
              </div>
              <div class="buttons">
                <div class="reject">
                  <button id="hangup_button_pop" class="rejectBtn"><i class="bi bi-telephone-x"></i></button>
                </div>
                <div class="answer">
                  <button id="answer_button" class="answerBtn"><i class="bi bi-telephone"></i></button>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div id="callInterface" style="display: none;">
      <div class="callmain" id="callmain">
        <div class="info-container">
          <?php
          // Connect to the database
          include 'db.php';

          $UserId = $_SESSION['UserId'];

          // Get the surname and first name of the user with the UserId from the database
          $sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserIdx'";
          $stmt = sqlsrv_prepare($conn, $sql);
          if (sqlsrv_execute($stmt)) {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $Surname = $row['Surname'];
              $First_Name = $row['First_Name'];
            }
          }

          ?>
          <div id="videos">
            <video class="video-player local" id="<?php echo $UserId; ?>" autoplay playsinline></video>
            <video class="video-player remote" id="<?php echo $UserIdx; ?>" autoplay playsinline></video>
          </div>

          <div class="over" id="over">
            <img id="recipientPassport" height="50" width="50" src="<?php echo $recipientPassport ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 80">
              <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle">
                <tspan class="recipientName" dy="0"><?php echo $Surname ?></tspan>
                <tspan class="recipientName" x="50%" dy="1.5em"><?php echo $First_Name ?></tspan>
                <!-- <a id="recipientName" x="50%" dy="1.5em"><?php echo $First_Name . '' . $Surname ?></a> -->
              </text>
            </svg>
            <div id="status" class="status">Calling...</div>
          </div>


          <div id="controls">

            <div class="control-container" id="video_call_button">
              <img src="icons/camera.png" />
            </div>

            <div class="control-container" id="audio_call_button">
              <img src="icons/mic.png" />
            </div>

            <div id="hang">
              <div class="control-container hang" href="" id="hangup_button">
                <img src="icons/phone.png" />
              </div>
            </div>

          </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- <script></script> -->


        <script>
          let mediaRecorder;
          let isRecording = false;
          let soundVisualizerInterval;
          let soundVisualizer = document.getElementById('sound-visualizer');
          let recordingType = 'voice';
          let chunks = [];


          function toggleButtons() {
            var message = document.getElementById('message').value.trim();
            var voiceButton = document.querySelector('.voice-note');
            var videoButton = document.querySelector('.video-note');
            var sendButton = document.getElementById('send-button');

            if (message === '') {
              voiceButton.style.display = 'inline-block';
              videoButton.style.display = 'inline-block';
              sendButton.style.display = 'none';
            } else {
              voiceButton.style.display = 'none';
              videoButton.style.display = 'none';
              sendButton.style.display = 'inline-block';
            }
          }
          let startRecordingTime;

          let maxRetries = 7; // Maximum number of retries
          let retryDelay = 1000; // Delay between retries in milliseconds
          function startRecording(type) {
            if (isRecording) return;
            isRecording = true;
            startRecordingTime = Date.now();

            if (type === 'voice') {
              soundVisualizer.style.display = 'block';
              soundVisualizerInterval = setInterval(updateSoundVisualizer, 100);
            } else if (type === 'video') {
              videoPreview.style.display = 'block';
            }

            function getMediaStreamWithRetry(retriesLeft) {
              navigator.mediaDevices.getUserMedia({
                  audio: true,
                  video: type === 'video'
                })
                .then(function(stream) {
                  // Check if the microphone is providing audio data
                  if (stream.getAudioTracks().length === 0) {
                    console.error('Microphone not providing audio data.');
                    return;
                  }

                  mediaRecorder = new MediaRecorder(stream, {
                    mimeType: 'audio/webm'
                  });

                  mediaRecorder.addEventListener("dataavailable", event => {
                    console.log("Data available:", event.data);
                    chunks.push(event.data);
                  });

                  mediaRecorder.onstop = async function() {
                    isRecording = false;
                    const blob = new Blob(chunks, {
                      type: mediaRecorder.mimeType
                    });
                    console.log('Recording stopped. Blob created:', blob);
                    // Calculate the duration of recording in seconds
                    const recordingDuration = (Date.now() - startRecordingTime) / 1000;

                    console.log('Recording duration:', recordingDuration.toFixed(2), 'seconds');
                    if (type === 'voice') {
                      soundVisualizer.style.display = 'none';
                      clearInterval(soundVisualizerInterval);
                    }

                    // Continue with async submission
                    await submitVoiceNote(blob);

                    chunks = [];
                  };

                  mediaRecorder.start();
                  console.log('Recording started:', type);
                })
                .catch(function(error) {
                  if (retriesLeft > 0) {
                    console.error('Error accessing media devices. Retrying...', error);
                    setTimeout(function() {
                      getMediaStreamWithRetry(retriesLeft - 1);
                    }, retryDelay);
                  } else {
                    console.error('Failed to access media devices after multiple retries:', error);
                  }
                });
            }
            getMediaStreamWithRetry(maxRetries);
          }

          function updateSoundVisualizer(loudness) {
            const spikeContainers = document.querySelectorAll('.boxContainer .box');

            spikeContainers.forEach((spike, index) => {
              const animation = getAnimationForLoudness(loudness, index);
              spike.style.animationName = animation;
            });
          }

          function getAnimationForLoudness(loudness, index) {
            if (loudness < 30) return 'quiet';
            if (loudness < 70) return index % 2 === 0 ? 'normal' : 'quiet';
            const boxContainer = document.getElementById('sound-visualizer');
            boxContainer.style.display = "flex"
            return 'loud';
          }

          function stopRecording(type) {
            if (mediaRecorder && isRecording) {
              mediaRecorder.stop();
            }
          };


          function cancelRecording() {
            if (mediaRecorder && isRecording) {
              mediaRecorder.stop();
              isRecording = false;
              deleteVoiceNote(); // Call the function to delete the voice note
              console.log("To be deleted");
            }
            soundVisualizer.style.display = 'none';
            clearInterval(soundVisualizerInterval);
          }

          async function deleteVoiceNote() {
            const formData = new FormData();
            formData.append('filename', voiceNoteFilename); // Provide the filename to delete

            try {
              const response = await fetch('delete_voice_note.php', {
                method: 'POST',
                body: formData
              });
              const result = await response.text();
              console.log('Voice note deleted:', result);
            } catch (error) {
              console.error('Error deleting voice note:', error);
            }
          }

          function submitRecordedNote() {
            if (mediaRecorder && isRecording) {
              mediaRecorder.stop();
            }
            if (isRecording && recordingType) {
              isRecording = false;
              if (recordingType === 'voice' && mediaRecorder && mediaRecorder.state === 'inactive') {
                // submitVoiceNote(blob);
              } else if (recordingType === 'video') {
                // Handle video recording
                isRecording = false;
                if (recordingType === 'video' && mediaRecorder && mediaRecorder.state === 'inactive') {}
              }
              recordingType = null;
            }
          }

          async function submitVoiceNote(blob) {
            console.log('Blob to be submitted:', blob);
            const recipientId = encodeURIComponent('<?php echo $_GET["UserIdx"]; ?>');
            const formData = new FormData();
            formData.append('voicenote', blob);
            formData.append('recipientId', recipientId);

            try {
              const response = await fetch('send_voice_note.php', {
                method: 'POST',
                body: formData
              });
              const result = await response.text();
              console.log('Voice note saved successfully:', result);
            } catch (error) {
              console.error('Error saving voice note:', error);
            }
          }
        </script>

        <script>
          var userB = '<?php echo $_GET["UserIdx"]; ?>';
          console.log(userB);
          var UserId = '<?php echo $_SESSION["UserId"]; ?>';
          console.log(UserId);
        </script>
        <script>
          $(document).ready(function() {
            // Get the UserIdx from the URL query parameters
            const urlParams = new URLSearchParams(window.location.search);
            const UserIdx = urlParams.get('UserIdx');
            const sessionId = "<?php echo $sessionID ?>";

            $.post('sendsession.php', {
                UserIdx: UserIdx,
                sessionId: sessionId
              })
              .done(function(response) {
                console.log(response);
              })
              .fail(function(xhr, status, error) {
                console.error(error);
              });

          });
        </script>
        <script>
          // Remove unnecessary code
          const hangupButtonpop = document.getElementById('hangup_button_pop');
          const answerButton = document.getElementById('answer_button');
          const ringingBox = document.getElementById('ringingBox');
          var signalingSocket;
          var sessionId = "<?php echo $sessionID ?>";
          var UserId = "<?php echo $UserId ?>";
          var UserIdx = "<?php echo $UserIdx ?>";
          var peerConnection; // Declare peerConnection as a global variable
          console.log(sessionId);
          console.log(UserId);
          console.log(UserIdx);
          var localStream;
          var remoteStream;
          var localVideo = document.getElementById("<?php echo $UserId; ?>");
          var remoteVideo = document.getElementById("<?php echo $UserIdx; ?>");
          var hangupButton = document.getElementById('hangup_button');
          var audioCallButton = document.getElementById('audio_call_button');
          var videoCallButton = document.getElementById('video_call_button');
          var callerStatusElement = document.getElementById('status');
          var chatInterface = document.getElementById('chatbox');
          var callInterface = document.getElementById('callInterface');
          var callbtn = document.getElementById('callbtn');
          const iceCandidates = [];

          // Define the pendingCandidates array at the global scope
          var pendingCandidates = [];
          // hangupButton.addEventListener('click', function() {
          //   hangUpCall();
          // });
          // var iceServers = [{
          //     urls: 'stun:stun.l.google.com:19302'
          //   }, // Google STUN server
          // ];

          callbtn.addEventListener('click', function() {
            // Hide the chat interface
            chatInterface.style.display = 'none';
            // Show the call interface
            callInterface.style.display = 'block';
            startVideoCall();
          });
          audioCallButton.addEventListener('click', toggleAudio);
          videoCallButton.addEventListener('click', toggleVideo);

          function toggleAudio() {
            localStream.getAudioTracks().forEach(function(track) {
              track.enabled = !track.enabled;
            });
          }

          function toggleVideo() {
            localStream.getVideoTracks().forEach(function(track) {
              track.enabled = !track.enabled;
            });
          }

          function startPeerConnection() {
            // Make sure peerConnection is already defined and initialized
            if (!peerConnection) {
              console.error('peerConnection is not initialized');
              return;
            }

            // Initialize the iceCandidates array
            // var iceCandidates = [];

            // Event listener for handling ICE candidates
            peerConnection.addEventListener('icecandidate', event => {
              console.log('Finding ICE candidate:', event);
              if (event.candidate) {
                console.log('ICE candidate found:', event.candidate);
                // Add the ICE candidate to the array
                iceCandidates.push(event.candidate);
                sendIceCandidates(iceCandidates);
              }
            });
            peerConnection.addEventListener('icegatheringstatechange', function() {
              console.log('ICE gathering state:', peerConnection.iceGatheringState);
              if (peerConnection.iceGatheringState === 'gathering') {
                console.log('Gathering ICE candidate gathering:', event);
              }
              if (peerConnection.iceGatheringState === 'complete') {
                // ICE gathering is complete, and all candidates have been gathered
                console.log('Gathering ICE candidate complete:', event);
                console.log('ICE gathering complete. All candidates:', iceCandidates);
                if (iceCandidates.length === 0) {
                  console.log('No ICE candidates were found. Check your media constraints and network connectivity.');
                } else {
                  // Send all ICE candidates to the remote peer
                  sendIceCandidates(iceCandidates);
                }
              }
            });

            // Add event listener for handling ICE connection state change
            peerConnection.addEventListener('iceconnectionstatechange', function() {
              console.log('ICE connection state:', peerConnection.iceConnectionState);
              if (peerConnection.iceConnectionState === 'failed') {
                // Handle ICE connection failure, if needed
              }
            });

            // Add event listener for handling data channel
            peerConnection.addEventListener('datachannel', function(event) {
              // Handle data channel, if needed
            });


            function sendIceCandidates(iceCandidates) {
              // Send all ICE candidates to the remote peer
              console.log('Sending ICE candidates:', iceCandidates);
              sendMessage({
                type: 'candidate',
                candidates: iceCandidates,
                callerUserId: UserIdx,
                callertoUserId: UserId,
              });
            }
          }


          function joinCall(message) {
            // Hide the chat interface
            chatInterface.style.display = 'none';
            // Show the call interface
            callInterface.style.display = 'block';

            var offer = new RTCSessionDescription(message.offer);
            var mediaConstraints = message.mediaConstraints;


            function getUserMediaWithRetry(mediaConstraints, maxRetries, delay) {
              return new Promise(function(resolve, reject) {
                function attempt() {
                  navigator.mediaDevices.getUserMedia(mediaConstraints)
                    .then(resolve)
                    .catch(function(error) {
                      if (maxRetries > 0) {
                        console.log('Failed to access camera and microphone. Retrying...');
                        maxRetries--;
                        setTimeout(attempt, delay);
                      } else {
                        // Use the canvas as the video stream source
                        reject(error);
                      }
                    });
                }
                attempt();
              });
            }
            // Start video and audio using the media constraints from the offer
            getUserMediaWithRetry(mediaConstraints, 7, 1000)
              .then(function(stream) {
                localStream = stream;
                peerConnection = new RTCPeerConnection();
                startPeerConnection();
                stream.getTracks().forEach(function(track) {
                  peerConnection.addTrack(track, stream);
                });
                // Log that the local stream is added to the peer connection
                console.log('Local stream added to peer connection');

                peerConnection.setRemoteDescription(offer)
                  .then(function() {
                    console.log('Remote description set successfully.');

                    if (
                      peerConnection.signalingState === 'have-remote-offer' ||
                      peerConnection.signalingState === 'have-local-pranswer'
                    ) {
                      return peerConnection.createAnswer();
                    } else {
                      throw new Error('Invalid signaling state for creating an answer.');
                    }
                  })
                  .then(function(answer) {
                    return peerConnection.setLocalDescription(answer);
                  })
                  .then(function() {
                    console.log('ICE gathering state:', peerConnection.iceGatheringState);
                    console.log('Local description set successfully.');

                    var sdpAnswer = peerConnection.localDescription;
                    console.log('SDP Answer:', sdpAnswer);

                    sendMessage({
                      type: 'answer',
                      answer: sdpAnswer,
                      mediaConstraints: mediaConstraints,
                      callerUserId: UserIdx,
                      callertoUserId: UserId
                    });

                  })
                  .catch(function(error) {
                    console.log('Error handling call offer:', error);
                  });
                // Set the local stream as the source for the local video element
                localVideo.srcObject = localStream;
                callerStatusElement.textContent = 'Exchanging Stream';

                // When the remote stream is received, set it as the source for the remote video element
                peerConnection.ontrack = function(event) {
                  if (event.streams && event.streams[0]) {
                    // Log that the remote stream is received and set as the source for the remote video element
                    console.log('Received remote stream:', event.streams[0]);
                    remoteVideo.srcObject = event.streams[0];
                  }
                };

                // Log that the local stream is sent as the remote stream
                console.log('Sending local stream as remote stream');
              })
              .catch(function(error) {
                console.log('Error accessing camera and microphone:', error);
              });
          }


          function initSignaling() {
            var signalingServerUrl = 'ws://localhost:8888?UserId=' + UserId + '&sessionID=' + sessionId + '&UserIdx=' + UserIdx;

            signalingSocket = new WebSocket(signalingServerUrl);

            signalingSocket.onopen = function() {
              console.log('Signaling socket connection established');
            };



            signalingSocket.onmessage = function(event) {
              var message = JSON.parse(event.data);
              console.log(message);

              if (message.type === 'offer') {
                handleIncomingOffer(message);
              } else if (message.type === 'incoming_call') {
                handleIncomingCall(message);
              } else if (message.type === 'answer') {
                handleAnswerMessage(message);
              } else if (message.type === 'hangup') {
                handleHangupMessage(message);
              } else if (message.type === 'candidate') {
                handleCandidateMessage(message);
              }
            };

            signalingSocket.onclose = function(event) {
              console.log('Signaling socket connection closed:', event.code, event.reason);
            };

            signalingSocket.onerror = function(error) {
              console.log('Signaling socket error:', error);
            };
          }

          function startVideoCall() {
            function getUserMediaWithRetry(mediaConstraints, maxRetries, delay) {
              return new Promise(function(resolve, reject) {
                function attempt() {
                  navigator.mediaDevices.getUserMedia(mediaConstraints)
                    .then(resolve)
                    .catch(function(error) {
                      if (maxRetries > 0) {
                        console.log('Failed to access camera and microphone. Retrying...');
                        maxRetries--;
                        setTimeout(attempt, delay);
                      } else {
                        reject(error);
                      }
                    });
                }
                attempt();
              });
            }

            var mediaConstraints = {
              video: true,
              audio: true
            };
            var maxRetries = 7;
            var delay = 1000; // 1 second

            getUserMediaWithRetry(mediaConstraints, maxRetries, delay)
              .then(function(stream) {
                localStream = stream;
                // var iceCandidates = []; // Initialize the iceCandidates array
                peerConnection = new RTCPeerConnection();
                startPeerConnection
                stream.getTracks().forEach(function(track) {
                  peerConnection.addTrack(track, stream);
                });
                sendCallOffer(mediaConstraints, UserIdx);

                hangupButton.disabled = false;
                audioCallButton.disabled = false;
                videoCallButton.disabled = false;

                localVideo.style.display = 'block';
                remoteVideo.style.display = 'block';
                localVideo.srcObject = stream;
              })
              .catch(function(error) {
                console.log('Error accessing camera and microphone:', error);
              });

            function sendIncomingCallSignal() {
              var message = {
                type: 'incoming_call',
                callerUserId: UserId,
                callertoUserId: UserIdx,
              };
              sendMessage(message);
            }

            function sendCallOffer(mediaConstraints, UserIdx) {
              callerStatusElement.textContent = 'Sending Call Offer';
              var offerOptions = {
                offerToReceiveAudio: mediaConstraints.audio ? 1 : 0,
                offerToReceiveVideo: mediaConstraints.video ? 1 : 0
              };

              peerConnection.createOffer(offerOptions)
                .then(function(offer) {
                  return peerConnection.setLocalDescription(offer);
                })
                .then(function() {
                  // Check the ICE gathering state after setting the local description
                  // console.log('ICE gathering state:', peerConnection.iceGatheringState);
                  var sdpOffer = peerConnection.localDescription;
                  console.log("SDP Offer:", sdpOffer);

                  var sessionId = "<?php echo $sessionID; ?>";

                  sendMessage({
                    type: 'offer',
                    offer: sdpOffer,
                    mediaConstraints: mediaConstraints,
                    callerUserId: UserId,
                    callertoUserId: UserIdx,
                    sessionId: sessionId
                  });
                  sendIncomingCallSignal();
                  callerStatusElement.textContent = 'Sent Call Offer';
                })
                .catch(function(error) {
                  console.log('Error creating call offer:', error);
                });
            }
          }

          function handleAnswerMessage(message) {
            var answer = new RTCSessionDescription(message.answer);
            var UserId = message.callerUserId;
            console.log(UserId);

            if (peerConnection.signalingState === 'have-local-offer') {
              peerConnection.setRemoteDescription(answer)
                .then(function() {
                  if (pendingCandidates.length > 0) {
                    pendingCandidates.forEach(function(candidate) {
                      peerConnection.addIceCandidate(candidate)
                        .catch(function(error) {
                          console.log('Error handling pending ICE candidate:', error);
                        });
                    });
                    pendingCandidates = [];
                  }
                })
                .catch(function(error) {
                  console.log('Error handling call answer:', error);
                });
            } else {
              peerConnection.addEventListener('signalingstatechange', function() {
                if (peerConnection.signalingState === 'have-local-offer') {
                  peerConnection.setRemoteDescription(answer)
                    .then(function() {
                      if (pendingCandidates.length > 0) {
                        pendingCandidates.forEach(function(candidate) {
                          peerConnection.addIceCandidate(candidate)
                            .catch(function(error) {
                              console.log('Error handling pending ICE candidate:', error);
                            });
                        });
                        pendingCandidates = [];
                      }
                    })
                    .catch(function(error) {
                      console.log('Error handling call answer:', error);
                    });
                }
              });
            }

            // When the remote stream is received as an answer
            peerConnection.ontrack = function(event) {
              if (event.streams && event.streams[0]) {
                // Set the remote stream as the source for the remote video element
                remoteVideo.srcObject = event.streams[0];
                callerStatusElement.textContent = 'Exchanging Stream';

                // Log the remote stream to the console
                console.log('Received remote stream:', event.streams[0]);
              }
            };

          }


          function handleCandidateMessage(message) {
            var candidate = message.candidate;

            // Check if the candidate array is not empty
            if (!Array.isArray(candidate) || candidate.length === 0) {
              console.log('Invalid ICE candidate data:', candidate);
              return;
            }

            // Now you can proceed to create the RTCIceCandidate
            var rtcCandidate = new RTCIceCandidate(candidate);
            var callerUserId = message.callerUserId;
            console.log('Incoming candidate from:', callerUserId);

            function handleAnswerButton() {
              peerConnAdd(rtcCandidate);
            }

            answerButton.addEventListener('click', handleAnswerButton);
          }



          function peerConnAdd(rtcCandidate) {
            peerConnection.addIceCandidate(rtcCandidate)
              .catch(function(error) {
                console.log('Error handling ICE candidate:', error);
              });
          }

          function handleHangupMessage() {
            var callerUserId = message.callerUserId;
            console.log("Call has been ended from:", callerUserId)
            hangUpCall();
          }

          function showRingingBox() {
            ringingBox.style.display = 'block';
          }

          function handleIncomingCall(message) {
            // Handle the incoming call
            var callerUserId = message.callerUserId;
            var callertoUserId = message.callertoUserId;
            console.log('Incoming call from:', callerUserId);

            // Additional logic for handling the incoming call
            // ...
            showRingingBox();
          }

          function handleIncomingOffer(message) {
            // Handle the incoming call
            var callerUserId = message.callerUserId;
            console.log('Incoming offer from:', callerUserId);

            // Function to handle the "Answer" button click
            function handleAnswerButtonClick() {
              joinCall(message);
            }

            // Function to handle the "Reject" button click
            function handleRejectButtonClick() {
              hangUpCall();
            }

            hangupButtonpop.addEventListener('click', handleRejectButtonClick);
            answerButton.addEventListener('click', handleAnswerButtonClick);
          }




          function sendMessage(message) {
            if (signalingSocket && signalingSocket.readyState === WebSocket.OPEN) {
              signalingSocket.send(JSON.stringify(message));
            } else {
              console.log('WebSocket connection is not open. Message not sent:', message);
            }
          }

          function hangUpCall() {
            // Stop the media streams
            localStream.getTracks().forEach(function(track) {
              track.stop();
            });

            // Close the RTCPeerConnection
            if (peerConnection) {
              peerConnection.close();
              peerConnection = null;
            }

            // Update the UI to reflect the call status
            hangupButton.disabled = true;
            audioCallButton.disabled = false;
            videoCallButton.disabled = false;
            localVideo.srcObject = null;
            remoteVideo.srcObject = null;
            callerStatusElement.textContent = 'Call Ended';
            chatInterface.style.display = "block";
            callInterface.style.display = "none";

            sendMessage({
              type: 'hangup',
              callerUserId: UserId,
              callertoUserId: UserIdx,
            });
            ringingBox.style.display = 'none';
          }
          initSignaling();
        </script>



        <script>
          function resetTheme() {
            localStorage.removeItem('messageSentcolor');
            localStorage.removeItem('messageReceivedcolor');
            localStorage.removeItem('messageSentTheme');
            localStorage.removeItem('messageReceivedTheme');
            localStorage.removeItem('dropHeaderTheme');
            localStorage.removeItem('chatboxTheme');
            location.reload(); // Reload the page to apply the default theme
          }
        </script>
        <script>
          var sidebarToggle = document.getElementById('sidebar-toggle');

          sidebarToggle.addEventListener('mousedown', function(e) {
            // get the current position of the button
            var posX = e.clientX - sidebarToggle.offsetLeft;
            var posY = e.clientY - sidebarToggle.offsetTop;

            // make the button draggable
            document.addEventListener('mousemove', moveButton);

            function moveButton(e) {
              sidebarToggle.style.left = (e.clientX - posX) + 'px';
              sidebarToggle.style.top = (e.clientY - posY) + 'px';
            }

            // stop dragging the button when the mouse button is released
            document.addEventListener('mouseup', function() {
              document.removeEventListener('mousemove', moveButton);
            });
          });
        </script>
        <script>
          // Function to save the theme settings to localStorage
          function savechatheaderTheme(theme) {
            localStorage.setItem('dropHeaderTheme', theme);
          }

          // Function to apply the theme settings to the chatbox
          function applychatheaderTheme(theme) {
            var chatheader = document.querySelector('.chat-header');
            chatheader.style.backgroundColor = theme;
          }

          // Check if there are previously saved theme settings in localStorage
          var savedDropdownTheme = localStorage.getItem('dropHeaderTheme');
          if (savedDropdownTheme) {
            // Apply the saved theme settings
            applychatheaderTheme(savedDropdownTheme);
          }

          // Get the chat-header element
          var chatHeader = document.querySelector('.chat-header');

          // Event listener for right-click on chat-header
          chatHeader.addEventListener('contextmenu', function(event) {
            event.preventDefault(); // Prevent the default contextmenu behavior

            // Remove any existing dropdown menus except the one within the clicked .chat-header element
            var existingDropdownMenus = document.querySelectorAll('.dropdown-menu');
            existingDropdownMenus.forEach(function(dropdownMenu) {
              if (dropdownMenu !== chatHeader.querySelector('.dropdown-menu')) {
                dropdownMenu.remove();
              }
            });

            var changeThemeOption = document.createElement('div');
            changeThemeOption.textContent = 'Change header Theme';
            changeThemeOption.classList.add('dropdown-option');

            var dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu', 'change');
            dropdownMenu.appendChild(changeThemeOption);

            // Append the dropdown menu to the clicked .chat-header element
            chatHeader.appendChild(dropdownMenu);

            var rect = event.target.getBoundingClientRect();
            dropdownMenu.style.top = '130px';
            dropdownMenu.style.right = '400px';
            dropdownMenu.style.zIndex = '9999';
            dropdownMenu.style.display = 'block';

            changeThemeOption.addEventListener('click', function() {
              var newColor = prompt('Enter a background color:');
              if (newColor !== null && newColor.trim() !== '') {
                chatHeader.style.backgroundColor = newColor;
                // Save the new theme settings
                savechatheaderTheme(newColor);
                // Apply the new theme settings
                applychatheaderTheme(newColor);
              }
            });

            // Event listener for clicks on the document
            document.addEventListener('click', function(event) {
              // Check if the clicked element is within the dropdown menu or chat-header
              if (!dropdownMenu.contains(event.target) && !chatHeader.contains(event.target)) {
                // If the clicked element is outside both, remove the dropdown from the DOM
                dropdownMenu.remove();
              }
            });
          });
        </script>

        <script>
          // Function to save the theme settings to localStorage
          function savebackgroundTheme(theme) {
            localStorage.setItem('chatboxTheme', theme);
          }

          // Function to apply the theme settings to the chatbox
          function applybackgroundTheme(theme) {
            var chatboxes = document.querySelectorAll('.chatbox, .chat-container');

            chatboxes.forEach(function(chatbox) {
              chatbox.style.backgroundColor = theme;
            });
          }

          // Check if there are previously saved theme settings in localStorage
          var savedChatboxTheme = localStorage.getItem('chatboxTheme');
          if (savedChatboxTheme) {
            // Apply the saved theme settings
            applybackgroundTheme(savedChatboxTheme);
          }

          document.addEventListener('contextmenu', function(event) {
            if (event.target.closest('.chat-header')) {
              return;
            }
            var clickedElement = event.target;

            // Check if the clicked element is within a .chatbox element
            var chatbox = document.querySelector('.chatbox');
            var chatcontainer = document.querySelector('.chat-container');

            // If the right-click is on the chatbox, run the second script's logic
            if (chatbox) {
              event.preventDefault();

              var changeThemeOption = document.createElement('div');
              changeThemeOption.textContent = 'Change Theme';
              changeThemeOption.classList.add('theme-option');

              var backgrounds = document.createElement('div');
              backgrounds.classList.add('changebackground');
              backgrounds.appendChild(changeThemeOption);

              // Append the dropdown menu to the clicked .chatbox element
              chatbox.appendChild(backgrounds);

              var rect = event.target.getBoundingClientRect();
              backgrounds.style.top = '130px';
              backgrounds.style.right = '600px';

              changeThemeOption.addEventListener('click', function() {
                var newColor = prompt('Enter a new background color:');
                if (newColor !== null && newColor.trim() !== '') {
                  chatbox.style.backgroundColor = newColor;
                  chatcontainer.style.backgroundColor = newColor;
                  // Save the new theme settings
                  savebackgroundTheme(newColor);
                  // Apply the new theme settings
                  applybackgroundTheme(newColor);
                }
              });

              // Remove the popup when the user clicks outside of it
              document.addEventListener('click', function(e) {
                if (!backgrounds.contains(e.target)) {
                  backgrounds.remove();
                }
              });
            }
          });
        </script>


        <script>
          // Function to save the theme settings to localStorage
          function saveSentmessagebackgroundTheme(theme) {
            localStorage.setItem('messageSentcolor', theme);
          }

          // Function to save the theme settings to localStorage
          function saveReceivedmessagebackgroundTheme(theme) {
            localStorage.setItem('messageReceivedcolor', theme);
          }

          // Function to apply the theme settings to the chatbox
          function applySentmessagesbackgroundTheme(theme) {
            var sentbackground = document.querySelectorAll('.Sent');
            sentbackground.forEach(function(message) {
              message.style.backgroundColor = theme;
            });
          }

          // Function to apply the theme settings to the chatbox
          function applyReceivedmessagesbackgroundTheme(theme) {
            var receivedbackground = document.querySelectorAll('.received');
            receivedbackground.forEach(function(message) {
              message.style.backgroundColor = theme;
            });
          }

          // Function to save the theme settings to localStorage
          function saveSentmessageTheme(theme) {
            localStorage.setItem('messageSentTheme', theme);
            console.log('saved');
          }

          // Function to save the theme settings to localStorage
          function saveReceivedmessageTheme(theme) {
            localStorage.setItem('messageReceivedTheme', theme);
            console.log('saved');
          }

          // Function to apply the theme settings to the chatbox
          function applySentmessagesTheme(theme) {
            var sent = document.querySelectorAll('.Sent');
            sent.forEach(function(message) {
              message.style.background = theme;
            });
          }

          // Function to apply the theme settings to the chatbox
          function applyReceivedmessagesTheme(theme) {
            var received = document.querySelectorAll('.received');
            received.forEach(function(message) {
              message.style.background = theme;
            });
          }


          var lastTimestamp = Date.now();

          function isSameDay(date1, date2) {
            return (
              date1.getDate() === date2.getDate() &&
              date1.getMonth() === date2.getMonth() &&
              date1.getFullYear() === date2.getFullYear()
            );
          }

          function getFormattedDate(date) {
            return date.toDateString();
          }

          function formatTime(time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);

            minutes = String(minutes).padStart(2, "0");
            seconds = String(seconds).padStart(2, "0");

            return minutes + ":" + seconds;
          }
          // isToday(date);
          var lastDisplayedDate = null;

          function checkForNewMessages() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                if (response.length > 0) {
                  lastTimestamp = response[response.length - 1].time_sent;
                  var chatbox = document.querySelector('.chatbox');
                  response.forEach(function(message) {
                    var div = document.createElement('div');
                    var timestamp = new Date(message.time_sent);

                    div.className = message.senderId == "<?php echo $UserId; ?>" ? 'Sent' : 'received';
                    // Handle received messages
                    var sender = message.senderId
                    if (div.className === 'received') {
                      var chatId = message.chatId;
                      var deletedReceivedMessage = localStorage.getItem('deletedReceivedMessage_' + chatId);
                      if (deletedReceivedMessage === 'true') {
                        div.innerHTML = '<div id="' + chatId + '" class="message">' + 'You deleted the message' + '</div>';
                        div.style.color = 'red';
                      }
                    }

                    // Check if the message contains a video link
                    var videoLinkRegex = /(https?:\/\/[^\s]+)/i;
                    if (videoLinkRegex.test(message.message)) {
                      var videoURL = message.message.match(videoLinkRegex)[0];

                      // Create a link to the video
                      var videoLink = '<a href="' + videoURL + '" target="_blank">' + videoURL + '</a>';

                      // Create a download link for the video
                      var downloadLink = '<a href="' + videoURL + '" download class="download-button">Download Video</a>';

                      // Create the message container with video link and download button
                      div.innerHTML = '<div class="message" id="' + message.chatId + '">' +
                        '<div class="message-container">' + videoLink + '<br>' +
                        '<img src="' + videoURL + '" alt="Thumbnail" class="thumbnail">' + '<br>' +
                        downloadLink + '</div>' +
                        '</div>';
                      var timestamp = new Date(message.time_sent);
                      var formattedTime = timestamp.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                      });
                      div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
                    } else if (message.message !== null) {
                      div.innerHTML = '<div id="' + message.chatId + '" class="message">' + message.message + '</div>';
                      var timestamp = new Date(message.time_sent);
                      var formattedTime = timestamp.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                      });
                      div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
                    }

                    if (message.sent_image) {
                      div.innerHTML += '<div id="' + message.chatId + '" class="image"><img src="' + message.sent_image + '"></div>';
                      var timestamp = new Date(message.time_sent);
                      var formattedTime = timestamp.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                      });
                      div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
                    }
                    if (message.sent_video) {
                      div.innerHTML += '<div id="' + message.chatId + '" class="video-container"><div id="videoplayer"><video width="400" height="400" class="iframe" preload="none" controls autoplay="false"><source src="' + message.sent_video + '" type="video/mp4"></video><button type="button" id="buttonplay" class="btn btn-primary">Watch Video</button></div></div>';
                      // Add event listener to play the video when the "Watch Video" button is clicked
                      var videoPlayer = div.querySelector('video');
                      var playButton = div.querySelector('#buttonplay');
                      playButton.addEventListener('click', function() {
                        videoPlayer.style.display = 'block';
                        videoPlayer.play();
                        playButton.style.display = 'none';
                      });
                      var timestamp = new Date(message.time_sent);
                      var formattedTime = timestamp.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                      });
                      div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
                    }
                    if (message.voice_notes) {
                      // console.log(message.voice_notes);
                      div.innerHTML += '<div id="' + message.chatId + '" class="message">' + '<div id="voiceNote-' + message.chatId + '" class="voiceNote">' + '<audio id="audio-' + message.chatId + '">' + '<source src="' + message.voice_notes + '" type="audio/webm">' + '</audio>' + '<div class="audio-controls-' + message.chatId + ' audio-controls">' + '<div class="controls-' + message.chatId + ' controls">' + '<div class="speed-' + message.chatId + ' speed">' + '<label for="speed-' + message.chatId + '"></label>' + '<span id="speed-label-' + message.chatId + '">1x</span>' + '</div>' + '<button class="play-pause-' + message.chatId + ' play-pause"></button>' + '</div>' + '<div class="timeline-' + message.chatId + ' timeline">' + '<input type="range" class="timeline-slider-' + message.chatId + ' timeline-slider" min="0" value="0">' + '<div class="progress-' + message.chatId + ' progress"></div>' + '</div>' + '<div class="time-' + message.chatId + ' time">' + '<span class="current-time-' + message.chatId + ' current-time">0:00</span>' + '<span class="divider">/</span>' + '<span class="total-time-' + message.chatId + ' total-time">0:00</span>' + '</div>' + '<div class="volume-' + message.chatId + ' volume">' + '<button class="volume-button-' + message.chatId + ' volume-button"></button>' + '<div class="volume-slider-' + message.chatId + ' volume-slider">' + '<div class="volume-percentage-' + message.chatId + ' volume-percentage"></div>' + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';
                      // Assign message.chatId to chatId
                      const chatId = message.chatId;
                      console.log(chatId);
                      setTimeout(function() {
                        // Use chatId to query for elements
                        const messageContainer = document.getElementById(chatId);
                        if (messageContainer) {
                          const voiceNoteContainer = messageContainer.querySelector(".voiceNote");
                          if (voiceNoteContainer) {
                            const audio = voiceNoteContainer.querySelector("#audio-" + chatId);
                            const timeline = voiceNoteContainer.querySelector(".timeline-" + chatId);
                            const progress = voiceNoteContainer.querySelector(".progress-" + chatId);
                            const playPause = voiceNoteContainer.querySelector(".play-pause-" + chatId);
                            const currentTime = voiceNoteContainer.querySelector(".current-time-" + chatId);
                            const totalTime = voiceNoteContainer.querySelector(".total-time-" + chatId);
                            const volumeButton = voiceNoteContainer.querySelector(".volume-button-" + chatId);
                            const volumeSlider = voiceNoteContainer.querySelector(".volume-slider-" + chatId);
                            const volumePercentage = voiceNoteContainer.querySelector(".volume-percentage-" + chatId);
                            const speedButton = voiceNoteContainer.querySelector(".speed-" + chatId);
                            const speedLabel = voiceNoteContainer.querySelector("#speed-label-" + chatId);
                            const speedOptions = [1, 1.5, 2];
                            let currentSpeedIndex = 0;
                            // setTimeout(function() {
                            //   var x = document.getElementById("audio-" + chatId).duration;
                            //   console.log(x);
                            // }, 2000)

                            audio.addEventListener("canplaythrough", () => {
                              // setTimeout(function (){
                              totalTime.innerHTML = formatTime(audio.duration);
                              console.log(totalTime.innerHTML);
                              audio.volume = 0.75;
                              volumePercentage.style.width = audio.volume * 100 + "%";
                              // }, 2500);
                            });
                            audio.addEventListener("ended", () => {
                              audio.currentTime = 0; // Reset back to the beginning
                              playPause.classList.remove("paused"); // Reset the play/pause button state
                              progress.style.width = "0"; // Reset progress bar
                              currentTime.textContent = formatTime(audio.currentTime); // Reset current time display
                            });

                            timeline.addEventListener("input", () => {
                              const timeToSeek = (timeline.value / 100) * audio.duration;
                              audio.currentTime = timeToSeek;
                            });

                            playPause.addEventListener("click", () => {
                              if (audio.paused) {
                                audio.play();
                                playPause.classList.add("paused");
                              } else {
                                audio.pause();
                                playPause.classList.remove("paused");
                              }
                            });

                            audio.addEventListener("timeupdate", () => {
                              const percent = (audio.currentTime / audio.duration) * 100;
                              progress.style.width = percent + "%";
                              currentTime.textContent = formatTime(audio.currentTime);
                              timeline.value = (audio.currentTime / audio.duration) * 100;
                            });

                            volumeButton.addEventListener("click", () => {
                              audio.muted = !audio.muted;
                              updateVolumeIcon();
                            });

                            volumeSlider.addEventListener("click", e => {
                              const sliderWidth = window.getComputedStyle(volumeSlider).width;
                              const newVolume = e.offsetX / parseInt(sliderWidth);
                              audio.volume = newVolume;
                              volumePercentage.style.width = newVolume * 100 + "%";
                              updateVolumeIcon();
                            });

                            speedButton.addEventListener("click", () => {
                              currentSpeedIndex = (currentSpeedIndex + 1) % speedOptions.length;
                              audio.playbackRate = speedOptions[currentSpeedIndex];
                              speedLabel.textContent = speedOptions[currentSpeedIndex] + "x";
                            });

                            function updateVolumeIcon() {
                              volumeButton.classList.remove("volume-off", "volume-low", "volume-high");
                              if (audio.muted) {
                                volumeButton.classList.add("volume-off");
                              } else if (audio.volume < 0.5) {
                                volumeButton.classList.add("volume-low");
                              } else {
                                volumeButton.classList.add("volume-high");
                              }
                            }

                            function getTimeCodeFromNum(num) {
                              const hours = Math.floor(num / 3600);
                              const minutes = Math.floor((num % 3600) / 60);
                              const seconds = Math.floor(num % 60);
                              return hours + ":" + String(minutes).padStart(2, "0") + ":" + String(seconds).padStart(2, "0");
                            }
                          } else {
                            console.log("Voice note container not found");
                          }
                        } else {
                          console.log("Message container not found");
                        }
                      }, 1000); // Delay of 3 seconds
                      var timestamp = new Date(message.time_sent);
                      var formattedTime = timestamp.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                      });
                      div.innerHTML += '<div class="timestamp">' + formattedTime + '</div>';
                    }
                    // JavaScript




                    if (!lastDisplayedDate || !isSameDay(timestamp, lastDisplayedDate)) {
                      var dateDiv = document.createElement('div');
                      dateDiv.className = 'date';
                      dateDiv.textContent = getFormattedDate(timestamp);
                      chatbox.appendChild(dateDiv);
                      lastDisplayedDate = timestamp;
                    }

                    chatbox.appendChild(div);


                    lastDisplayedDate = timestamp;

                    // Check if there are previously saved theme settings in localStorage
                    var savedSentmessagecolorTheme = localStorage.getItem('messageSentcolor');
                    if (savedSentmessagecolorTheme) {
                      // Apply the saved theme settings
                      applySentmessagesbackgroundTheme(savedSentmessagecolorTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var savedReceivedmessagecolorTheme = localStorage.getItem('messageReceivedcolor');
                    if (savedReceivedmessagecolorTheme) {
                      // Apply the saved theme settings
                      applyReceivedmessagesbackgroundTheme(savedReceivedmessagecolorTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var SavedmessageSentTheme = localStorage.getItem('messageSentTheme');
                    if (SavedmessageSentTheme) {
                      // Apply the saved theme settings
                      applySentmessagesTheme(SavedmessageSentTheme);
                    }
                    // Check if there are previously saved theme settings in localStorage
                    var SavedmessageReceivedTheme = localStorage.getItem('messageReceivedTheme');
                    if (SavedmessageReceivedTheme) {
                      // Apply the saved theme settings
                      applyReceivedmessagesTheme(SavedmessageReceivedTheme);
                    }


                  });
                  chatbox.scrollTop = chatbox.scrollHeight; // Scroll to bottom

                  // Add right-click event listener to each message div
                  var messageDivs = document.querySelectorAll('.message');
                  messageDivs.forEach(function(div) {
                    div.addEventListener('contextmenu', function(e) {
                      // Prevent default right-click menu from showing
                      e.preventDefault();
                      // Get the class of the clicked message
                      var clickedClass = e.target.parentNode.className;
                      var clickedId = e.target.parentNode.id;
                      // Remove any existing popup
                      var existingPopups = document.querySelectorAll('.popup');
                      existingPopups.forEach(function(popup) {
                        popup.remove();
                      });

                      // Get the class of the clicked message
                      var clickedClass = e.target.parentNode.className;


                      // Create new popup and position it beside the clicked message
                      var popup = document.createElement('div');
                      popup.className = 'popup';
                      popup.setAttribute('data-chat-id', div.id);
                      popup.innerHTML = '<a class="delete" href="#">Delete</a><a class="reply" href="#">Reply</a><a class="change-theme" href="#">Change Theme</a>';
                      var chatId = popup.getAttribute('data-chat-id');
                      // alert(div.id);
                      // Position the popup beside the clicked message
                      var messageRect = e.target.getBoundingClientRect();
                      var chatboxRect = chatbox.getBoundingClientRect();

                      // Calculate the popup's top and left positions
                      var popupTop = messageRect.top - chatboxRect.top + messageRect.height / 2 - popup.offsetHeight / 2;
                      var popupLeft;
                      if (clickedClass === 'Sent') {
                        popupLeft = messageRect.left - chatboxRect.left - popup.offsetWidth;
                      } else if (clickedClass === 'received') {
                        popupLeft = messageRect.left - chatboxRect.left + messageRect.width;
                      }
                      popup.style.top = popupTop + 'px';
                      popup.style.left = popupLeft + 'px';
                      // Add event listeners to delete, reply, and change theme options
                      var deleteBtn = popup.querySelector('.delete');
                      deleteBtn.addEventListener('click', function() {
                        var chatId = popup.getAttribute('data-chat-id');
                        var senderId = message.senderId;
                        var currentUserId = "<?php echo $UserId; ?>";
                        console.log(currentUserId)
                        var isSentMessage = senderId === currentUserId;

                        if (isSentMessage = true) {
                          // Send an AJAX request to delete the message from the database
                          var xhr = new XMLHttpRequest();
                          xhr.open('POST', 'delete_message.php', true);
                          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                          var formData = 'chatId=' + encodeURIComponent(chatId);

                          xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                              console.log('Response:', xhr.responseText);
                              var response = JSON.parse(xhr.responseText);
                              var message = response.message;

                              // Message deleted successfully from database, update UI for sent message
                              var deletedMessage = document.getElementById(chatId);
                              deletedMessage.innerHTML = 'You deleted this message';
                              deletedMessage.class = 'message';
                              deletedMessage.style.color = 'red';
                              alert(message);
                              popup.style.display = 'none';
                            }
                          };

                          xhr.send(formData);
                        } else {
                          // Update UI for received message
                          var deletedMessage = document.getElementById(chatId);
                          deletedMessage.innerHTML = 'You deleted the message';
                          deletedMessage.style.color = 'red';
                          localStorage.setItem('deletedReceivedMessage_' + chatId, 'true'); // Save the setting
                          popup.style.display = 'none';
                        }
                      });


                      var replyBtn = popup.querySelector('.reply');
                      replyBtn.addEventListener('click', function() {
                        // TODO: Implement reply functionality
                        // Show a reply form for the user to enter a reply message
                      });

                      var changeThemeBtn = popup.querySelector('.change-theme');
                      changeThemeBtn.addEventListener('click', function() {
                        // Check if change theme options already exist
                        var changeThemeOptions = popup.querySelector('.change-theme-options');
                        if (changeThemeOptions) {
                          // If change theme options already exist, remove them
                          changeThemeOptions.remove();
                        } else {
                          var changeThemeOptions = document.createElement('div');
                          changeThemeOptions.className = 'change-theme-options';
                          changeThemeOptions.innerHTML = '<a class="background-gradient" href="#">Change Background</a><a class="background-color" href="#">Change Background Color</a>';
                          popup.appendChild(changeThemeOptions);

                          var backgroundBtn = popup.querySelector('.background-gradient');
                          backgroundBtn.addEventListener('click', function(e) {
                            var newColor = prompt('Enter a new background gradient:');
                            if (newColor !== null && newColor.trim() !== '') {
                              if (clickedClass === 'Sent') {
                                var sentElements = document.querySelectorAll('.Sent');
                                sentElements.forEach(function(element) {
                                  element.style.background = newColor;
                                  // Save the new theme settings
                                  saveSentmessageTheme(newColor);
                                  // Apply the new theme settings
                                  applySentmessagesTheme(newColor);
                                });
                              } else if (clickedClass === 'received') {
                                var receivedElements = document.querySelectorAll('.received');
                                receivedElements.forEach(function(element) {
                                  element.style.background = newColor;
                                  // Save the new theme settings
                                  saveReceivedmessageTheme(newColor);
                                  // Apply the new theme settings
                                  applyReceivedmessagesTheme(newColor);
                                });
                              }
                            }
                          });



                          var backgroundcolorBtn = popup.querySelector('.background-color');
                          backgroundcolorBtn.addEventListener('click', function(e) {
                            var newColor = prompt('Enter a new background color:');
                            if (newColor !== null && newColor.trim() !== '') {
                              if (clickedClass === 'Sent') {
                                var sentElements = document.querySelectorAll('.Sent');
                                sentElements.forEach(function(element) {
                                  element.style.backgroundColor = newColor;
                                  // Save the new theme settings
                                  saveSentmessagebackgroundTheme(newColor);
                                  // Apply the new theme settings
                                  applySentmessagesbackgroundTheme(newColor);
                                });
                              } else if (clickedClass === 'received') {
                                var receivedElements = document.querySelectorAll('.received');
                                receivedElements.forEach(function(element) {
                                  element.style.backgroundColor = newColor;
                                  // Save the new theme settings
                                  saveRecievedmessagebackgroundTheme(newColor);
                                  // Apply the new theme settings
                                  applyReceivedmessagesbackgroundTheme(newColor);
                                });
                              }
                            }
                          });
                        }
                      });
                      // Add the popup to the chatbox
                      chatbox.appendChild(popup);

                      // Remove the popup when the user clicks outside of it
                      document.addEventListener('click', function(e) {
                        if (popup && !popup.contains(e.target)) {
                          popup.remove();
                        }
                      });
                    });
                  });
                }
              }
            };
            xhttp.open('POST', 'checkForNewMessages.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var UserId = '<?php echo $UserId; ?>';
            var recipientId = '<?php echo $_GET['UserIdx']; ?>';
            var data = 'UserId=' + UserId + '&recipientId=' + recipientId + '&timestamp=' + lastTimestamp;
            xhttp.send(data);
          }

          setInterval(checkForNewMessages, 500); // Call the function every 1 second
        </script>

        <script>
          var UserId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

          // Check if the UserId exists
          if (!UserId) {
            // UserId not found, redirect to login page
            window.location.href = "login.php";
          }
        </script>

        <script>
          function insertEmoji(emoji) {
            var textarea = document.querySelector("#message");
            textarea.value += emoji;
          }
        </script>
        <script>
          function toggleEmojiPicker() {
            var container = document.querySelector(".emoji-table-container");
            if (container.style.display === "none") {
              container.style.display = "block";
            } else {
              container.style.display = "none";
            }
          }
        </script>

        <script>
          function previewImage() {
            // Get the selected file
            var file = document.getElementById('image').files[0];
            // Create a FileReader object
            var reader = new FileReader();
            // Set the image source when the file is loaded
            reader.onload = function(e) {
              var imgModal = document.getElementById('image-modal');
              var imgPreview = document.getElementById('image-preview');
              imgPreview.src = e.target.result;
              imgModal.style.display = "block";
            }
            // Load the file as a data URL
            reader.readAsDataURL(file);
          }

          function previewVideo() {
            let fileInput = document.querySelector('.video-input');
            let file = fileInput.files[0];
            let videoPreview = document.querySelector('#video-preview');
            let videoModal = document.querySelector('#video-modal');
            let closeModal = videoModal.querySelector('.close');
            let reader = new FileReader();
            reader.addEventListener('load', function() {
              videoPreview.src = reader.result;
              videoModal.style.display = 'block';
            }, false);

            if (file) {
              reader.readAsDataURL(file);
            }
            closeModal.addEventListener('click', function() {
              videoModal.style.display = 'none';
              videoPreview.src = '';
            });
          }
          $(document).ready(function() {
            // Send the message
            $('.submit').click(function() {

              var message = $('#message').val();
              var image = $('.image-input').prop('files')[0];
              // var videonote = $('.video-note').prop('files')[0];
              // var voicenote = $('.voice-note').prop('files')[0];
              var UserId = '<?php echo $UserId; ?>';
              var recipientId = '<?php echo $_GET['UserIdx']; ?>';
              var video = $('#video').prop('files')[0];
              var formData = new FormData();
              formData.append('message', message);
              formData.append('image', image);
              // formData.append('voicenote', voicenote);
              // formData.append('videonote', videonote);
              formData.append('UserId', UserId);
              formData.append('recipientId', recipientId);
              formData.append('video', video);
              // Send the AJAX request
              $.ajax({
                url: 'send_message.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                  console.log(response);
                  $('#message').val('');
                }
              });
            });
          });
        </script>
        <script>
          $(document).ready(function() {
            $("#search").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              if (value === "") {
                // Clear the table if the search box is empty
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
                data: {
                  search_query: search_query
                },
                success: function(data) {
                  // Update the table with the returned results
                  $("#user_table").html(data);
                }
              });
            });
          });
        </script>



        <script>
          var sessionId = "<?php echo $sessionID ?>"; // Retrieve the sessionId from PHP

          // Pass the sessionId to call.js
          sessionStorage.setItem('sessionId', sessionId);
        </script>

        <!-- Modal -->
        <div class="modal fade" id="profilepicturemodal" tabindex="-1" role="dialog" aria-labelledby="profilepicturemodalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <?php
                include 'db.php';
                // Get the UserId of the user you are talking to
                $recipientId = $_GET['UserIdx'];
                // Fetch the passport image
                $sql = "SELECT Passport FROM User_Profile WHERE UserId = '$recipientId'";
                $stmt = sqlsrv_query($conn, $sql);
                if ($stmt === false) {
                  die(print_r(sqlsrv_errors(), true));
                }

                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
                $Passport = $row['Passport'];
                if (empty($Passport)) {
                  $passportImage = "UserPassport/DefaultImage.png";
                } else {
                  $passportImage = "UserPassport/" . $Passport;
                }
                echo '<img id="modalImg" src="' . $passportImage . '">';

                ?>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div class="preview">
          <div id="image-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="image-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="image-modal-label">Image Preview</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <img id="image-preview" src="#" alt="Image Preview">
                </div>
              </div>
            </div>
          </div>
          <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="video-modal-label" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="video-modal-label">Video Preview</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <video id="video-preview" src="#"></video>
                </div>
              </div>
            </div>
          </div>
        </div>
</body>

</html>