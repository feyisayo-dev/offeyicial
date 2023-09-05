<?php
header("Access-Control-Allow-Origin: http://localhost:8080"); // Replace with your frontend domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
?>

<?php
session_start();
include 'db.php';
$UserId = $_SESSION["UserId"];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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

    <title>Add Reels</title>
    <style>
        .pick_media_box input[type="file"] {
            display: none;
        }

        /* Your CSS rules */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .reel_container {
            display: flex;
            padding: 20px;
            width: 100vw;
            margin-top: 10px;
        }

        .upload_box {
            width: 40%;
            padding: 20px;
            background-color: transparent;
            text-align: center;
            border: dotted #ccc;
            border-radius: 5px;
            margin-right: 20px;
        }

        .upload_box h3,
        .upload_box h4,
        .upload_box h5 {
            margin: 10px 0;
            color: #555;
        }

        .details_box {
            width: 60%;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pick_media_box {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #bbb4b4;
            border-radius: 10px;
        }

        .upload-box {
            margin-left: 10px;
            padding: 10px;
            background-color: transparent;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .upload-box i {
            font-size: 20px;
            color: #f0f0f0;
        }

        .preview-container {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .preview-items {
            justify-content: center;
            background-color: #555;
            display: flex;
        }

        .preview-items video {
            width: 400px;
        }

        .checkbox_option {
            display: inline-block;
            margin-right: 10px;
        }

        .checkboxes {
            display: inline-block;
        }

        .third_box_text,
        .second_box_text,
        .main_box_text {
            padding-bottom: 20px;
            padding: 1.5rem 1rem;
        }

        .caption_text,
        .pub,
        .publicity,
        .checkboxes {
            padding-bottom: 25px;
        }

        .publicity,
        .checkboxes {
            width: 50%;
            font-size: 1rem;
        }

        .styled-checkbox {
            position: absolute;
            opacity: 0;
        }

        .styled-checkbox+label {
            position: relative;
            cursor: pointer;
            padding: 0;
        }

        .styled-checkbox+label:before {
            content: "";
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            width: 20px;
            height: 20px;
            background: #f0f0f0;
        }

        .styled-checkbox:hover+label:before {
            background: green;
        }

        .styled-checkbox:focus+label:before {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
        }

        .styled-checkbox:checked+label:before {
            background: green;
        }

        .styled-checkbox:disabled+label {
            color: #b8b8b8;
            cursor: auto;
        }

        .styled-checkbox:disabled+label:before {
            box-shadow: none;
            background: #ddd;
        }

        .styled-checkbox:checked+label:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 9px;
            background: white;
            width: 2px;
            height: 2px;
            box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
            transform: rotate(45deg);
        }

        .Submit {
            color: white;
            background-color: #555;
            border-radius: 10px;
            width: 100px;
            padding: 10px;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.5);
        }

        .back {
            display: flex;
            margin: 40px;
            justify-content: space-between;
        }

        .back i {
            margin-right: 5px;
        }

        .logout-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 10px;
        }

        .buttons {
            position: absolute;
            bottom: -90px;
            right: 0;
            display: none;
        }

        .buttons .material-icons {
            font-size: 28px;
            color: black;
            cursor: pointer;
        }

        .material-icons img {
            height: 50px;
        }

        .buttons__button {
            padding: 5px;
            text-align: center;
            margin-right: 40px;
        }

        .close {
            color: white;
            background-color: green;
            border-radius: 10px;
            border: none;
            width: 30px;
        }

        #closebtn {
            color: white;
            background-color: green;
            border-radius: 10px;
            padding: 4px;
            border: outset;
        }

        .modal-backdrop .show {
            opacity: 0.9;
        }

        .flip-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            transform: scaleX(-1);
            /* Flip horizontally */
            margin-right: 5px;
            /* Adjust spacing as needed */
            color: green;
            /* Adjust color as needed */
        }

        .buttons__button p {
            font-size: 12px;
        }

        .audio-upload-box {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .audio-upload-box:hover {
            border-color: #aaa;
        }

        .audio-upload-box input[type="file"] {
            display: none;
        }

        .audio-search-box {
            margin-bottom: 20px;
            text-align: center;
        }

        #audio-search-input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
        }

        #audio-search-button {
            padding: 8px 15px;
            background-color: green;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .audio-search-results {
            max-width: 600px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f6f6f6;
        }

        audio {
            width: 100%;
        }

        .ability {
            display: flex;
            margin-bottom: 20px;
        }

        .friends {
            position: absolute;
            top: 30%;
            display: none;
            right: 30%;
            background-color: #555;
            width: 500px;
            overflow-y: auto;
            padding: 20px;
        }

        /* Style for search input and results */
        #searchInput {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .search-results {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            background-color: #fff;
        }

        .search-results li {
            margin: 5px 0;
            list-style-type: none;
        }

        /* Style for select users button */
        #selectUsersBtn {
            background-color: green;
            color: white;
            border: none;
            float: right;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        #selectUsersBtn:hover {
            background-color: #18e312;
        }

        .checkbox {
            position: absolute;
            opacity: 0;
        }

        .checkbox+label {
            position: relative;
            cursor: pointer;
            padding: 0;
        }

        .checkbox+label:before {
            content: "";
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            width: 20px;
            height: 20px;
            background: #f0f0f0;
        }

        .checkbox:hover+label:before {
            background: green;
        }

        .checkbox:focus+label:before {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
        }

        .checkbox:checked+label:before {
            background: green;
            color: black;
        }

        .checkbox:disabled+label {
            color: #b8b8b8;
            cursor: auto;
        }

        .checkbox:disabled+label:before {
            box-shadow: none;
            background: #ddd;
        }

        .checkbox:checked+label:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 9px;
            background: white;
            width: 2px;
            height: 2px;
            box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
            transform: rotate(45deg);
        }

        /* Style for music search results */
        .music-results {
            list-style: none;
            padding: 0;
            overflow-y: auto;
        }

        .music-results li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .music-checkbox {
            margin-right: 10px;
        }

        .music-checkbox:checked+label {
            color: #333;
            /* Change color when checkbox is checked */
        }

        .duration {
            margin-left: auto;
            font-size: 0.9em;
            color: #777;
        }

        /* Hover effect for the music results */
        .music-results li:hover {
            background-color: #f7f7f7;
            border-radius: 5px;
        }

        #music-search-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .music-checkbox {
            position: absolute;
            opacity: 0;
        }

        .music-checkbox+label {
            position: relative;
            cursor: pointer;
            padding: 0;
        }

        .music-checkbox+label:before {
            content: "";
            margin-right: 10px;
            display: inline-block;
            vertical-align: text-top;
            width: 20px;
            height: 20px;
            background: #f0f0f0;
        }

        .music-checkbox:hover+label:before {
            background: green;
        }

        .music-checkbox:focus+label:before {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
        }

        .music-checkbox:checked+label:before {
            background: green;
        }

        .music-checkbox:disabled+label {
            color: #b8b8b8;
            cursor: auto;
        }

        .music-checkbox:disabled+label:before {
            box-shadow: none;
            background: #ddd;
        }

        .music-checkbox:checked+label:after {
            content: "";
            position: absolute;
            left: 5px;
            top: 9px;
            background: white;
            width: 2px;
            height: 2px;
            box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
            transform: rotate(45deg);
        }

        .loader {
            display: block;
            margin: 0 auto;
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="mainbody">
        <div class="back">
            <button id="backBtn" class="logout-btn"><i class="bi bi-arrow-left"></i>Back</button>
        </div>
        <div class="friends">
            <input type="text" id="searchInput" placeholder="Search for names...">
            <div class="search-results">
                <!-- Search results will be dynamically added here -->
            </div>
            <button id="selectUsersBtn">OK</button>
        </div>
        <div class="reel_container">
            <div class="upload_box">
                <div class="main_box_text">
                    <h3>Select a video</h3>
                </div>
                <div class="second_box_text">
                    <h4>drag or drop video</h4>
                </div>
                <div class="third_box_text">
                    <h5>MP4 or Webm files</h5>
                </div>
                <div class="third_box_text">
                    <h5>a maximum of 10 mins </h5>
                </div>
                <div class="third_box_text">
                    <h5>1-2 gb recommended</h5>
                </div>
                <div class="pick_media_box">
                    <input type="file" name="videos[]" id="videos" accept="video/*">
                    <div class="upload-box"><i class="bi bi-cloud-arrow-down-fill"></i></div>
                    <label for="videos">Upload Reels</label>
                </div>
            </div>
            <div class="details_box">
                <div class="caption_text">
                    <label class="capt" for="caption">Caption:</label>
                    <input type="text" class="form-control" placeholder="Enter your beautiful caption">
                </div>
                <div class="row">
                    <div class="publicity">
                        <label class="pub" for="public">Who do you want to able to see your video:</label>
                        <select name="public" id="public" name="public" class="form-control">
                            <option value="">Select</option>
                            <option class="Everyone" value="Everyone">Everyone</option>
                            <option class="Friends" value="Friends">Friends</option>
                            <option class="people" value="selected">A selected set of people</option>
                        </select>
                    </div>
                    <div class="checkboxes">
                        <label class="ability" for="checkbox">Users can:</label>
                        <div class="input_field checkbox_option">
                            <input class="styled-checkbox" type="checkbox" id="commentcheckboxes">
                            <label for="commentcheckboxes">Comment</label>
                        </div>
                        <div class="input_field checkbox_option">
                            <input class="styled-checkbox" type="checkbox" id="downloadcheckboxes">
                            <label for="downloadcheckboxes">Download</label>
                        </div>
                        <div class="input_field checkbox_option">
                            <input class="styled-checkbox" type="checkbox" id="likecheckboxes">
                            <label for="likecheckboxes">Like</label>
                        </div>
                    </div>
                </div>

                <div class="preview-container">
                    <h3>Reels Preview</h3>
                    <div class="preview-items">
                        <div class="buttons">
                            <div class="buttons__button">
                                <span data-bs-toggle="modal" data-bs-target="#musicpicker" class="material-icons"><img src="icons/music.png">
                                    <p>Music</p>
                                </span>
                            </div>

                            <div class="buttons__button">
                                <span class="material-icons mute"><img src="icons/mute.png">
                                    <p>Mute</p>
                                </span>
                            </div>

                            <div class="buttons__button">
                                <span class="material-icons timer"><img src="icons/timer.png">
                                    <p>Speed</p>
                                </span>
                            </div>

                            <div class="buttons__button">
                                <span class="material-icons flip"><img src="icons/refresh.png">
                                    <p>flip</p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="Submit" value="Submit">
        </div>
    </div>
    <div class="modal fade" id="musicpicker" tabindex="-1" role="dialog" aria-labelledby="musicpickerLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="device-tab" data-bs-toggle="tab" data-bs-target="#device" type="button" role="tab" aria-controls="device" aria-selected="true">From Device</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="search-tab" data-bs-toggle="tab" data-bs-target="#search" type="button" role="tab" aria-controls="search" aria-selected="false">From Server</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="server-tab" data-bs-toggle="tab" data-bs-target="#server" type="button" role="tab" aria-controls="server" aria-selected="false">Search Music/Audio</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="device" role="tabpanel" aria-labelledby="device-tab">
                            <div class="audio-upload-box">
                                <h4>Drag and Drop or Select Audio from Device</h4>
                                <input type="file" accept="audio/*" id="audio-input">
                                <p>Supported formats: MP3, WAV, etc.</p>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search-tab">
                            <div class="audio-search-box">
                                <h4>Search for Audio</h4>
                                <input type="text" id="audio-search-input" placeholder="Search audio...">
                                <button id="audio-search-button">Search</button>
                            </div>
                            <div class="audio-search-results">
                                <!-- Table for displaying search results goes here -->
                                <?php
                                $audioFolder = 'audio_music'; // Folder containing audio files
                                $audioFiles = scandir($audioFolder);
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Audio Name</th>
                                            <th>Play</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($audioFiles as $file) {
                                            if ($file !== '.' && $file !== '..') {
                                                echo '<tr>';
                                                echo '<td>' . $file . '</td>';
                                                echo '<td><audio controls><source src="' . $audioFolder . '/' . $file . '" type="audio/mpeg"></audio></td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="server" role="tabpanel" aria-labelledby="server-tab">
                            <input type="text" id="music-search-input" placeholder="Search for music...">
                            <ul id="music-results" class="music-results"></ul>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closebtn" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script>
        var signalingSocket;
        var UserId = "<?php echo $UserId ?>";
        // alert(UserId);
        function initSignaling() {
            var signalingServerUrl = 'ws://localhost:8888?UserId=' + UserId;

            signalingSocket = new WebSocket(signalingServerUrl);

            signalingSocket.onopen = function() {
                console.log('Signaling socket connection established');
            };



            signalingSocket.onmessage = function(event) {
                var message = JSON.parse(event.data);
                console.log(message);
            };

            signalingSocket.onclose = function(event) {
                console.log('Signaling socket connection closed:', event.code, event.reason);
            };

            signalingSocket.onerror = function(error) {
                console.log('Signaling socket error:', error);
            };
        }

        initSignaling();
    </script>
    <script>
        const selectPublic = document.getElementById('public');
        const friends = document.querySelector('.friends');
        const reelContainer = document.querySelector('.reel_container');

        selectPublic.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.classList.contains('people')) {
                friends.style.display = 'block';
                friends.style.zIndex = '999';
                reelContainer.style.opacity = '0.1';
            } else {
                friends.style.display = 'none';
                reelContainer.style.opacity = '1';
            }
        });
    </script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResultsContainer = document.querySelector('.search-results');
        const selectUsersBtn = document.getElementById('selectUsersBtn');

        // Function to update search results
        function updateSearchResults() {
            const searchQuery = searchInput.value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `searchfriendbackend.php?search_query=${searchQuery}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    searchResultsContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        // Add event listener for keyup on search input
        searchInput.addEventListener('keyup', updateSearchResults);
        const friendss = document.querySelector('.friends');
        const reelContainers = document.querySelector('.reel_container');

        // Add an event listener for capturing selected users
        selectUsersBtn.addEventListener('click', function() {
            const selectedUsers = [];
            friends.style.display = 'none';
            reelContainer.style.opacity = '1';
            const checkboxes = document.querySelectorAll('input[name="selectedUsers[]"]:checked');
            checkboxes.forEach(checkbox => {
                selectedUsers.push(checkbox.value);
            });

            // Update the label text with the count of selected users
            const selectedGroupLabel = document.querySelector('.people');
            const count = selectedUsers.length;
            selectedGroupLabel.textContent = `A selected group of people (${count})`;

            // Do something with selectedUsers, like sending the video to them
        });
    </script>

    <script>
        const musicSearchInput = document.getElementById('music-search-input');
        const musicResultsList = document.getElementById('music-results');

        musicSearchInput.addEventListener('keyup', async function(event) {
            const searchQuery = event.target.value;

            if (searchQuery.trim() === '') {
                musicResultsList.innerHTML = '';
                return;
            }

            try {
                const proxyUrl = 'proxy.php';
                const response = await fetch(`${proxyUrl}?query=search?q=${searchQuery}`);
                const data = await response.json();
                const musicTracks = data.data || [];

                musicResultsList.innerHTML = '';

                musicTracks.forEach(track => {
                    const listItem = document.createElement('li');
                    listItem.innerHTML = `
                    <input type="checkbox" class="music-checkbox" id="music-checkbox-${track.id}" data-track-id="${track.id}">
                        <label for="music-checkbox-${track.id}">
                            ${track.title} - ${track.artist.name}
                            <span class="duration">${formatDuration(track.duration)}</span>
                        </label>`;
                    musicResultsList.appendChild(listItem);
                });
            } catch (error) {
                console.error('Error fetching music:', error);

                // Check if the response is HTML (error message)
                if (response.headers.get('content-type').includes('text/html')) {
                    console.error('Proxy response is HTML:', await response.text());
                }
            }

        });

        function formatDuration(duration) {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }
    </script>
    <script>
        // Get references to the buttons
        const backBtn = document.getElementById('backBtn');

        // Add click event listeners to the buttons
        backBtn.addEventListener('click', function() {
            // Go back to the previous page
            window.history.back();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Display selected videos and photos as a preview
            function previewReels(event) {
                const videos = document.getElementById('videos').files;
                // const photos = document.getElementById('photos').files;
                const previewItems = document.querySelector('.preview-items');
                const buttons = document.querySelector('.buttons');

                // Clear previous previews
                // previewItems.innerHTML = '';

                // Display videos
                for (let i = 0; i < videos.length; i++) {
                    // const videoElement = document.createElement('video');
                    // videoElement.controls = true;
                    // videoElement.autoplay = true;
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    previewItems.appendChild(previewItem);

                    const formData = new FormData();

                    const videoInput = document.getElementById('videos');

                    if (videoInput.files.length > 0) {
                        const videoFile = videoInput.files[0];
                        console.log('VideoFile:', videoFile);
                        console.log('Uploaded file mimetype:', videoFile.type);

                        formData.append('Video', videoFile);

                        const videoElement = document.createElement('video');
                        videoElement.src = URL.createObjectURL(videoFile);

                        videoElement.addEventListener('loadedmetadata', () => {
                            const videoDuration = videoElement.duration;
                            const videoinmins = videoDuration / 60;
                            console.log('Video Duration:', videoinmins);

                            if (videoDuration > 600) {
                                videoElement.style.display = "none";
                                const loader = document.createElement('img');
                                loader.src = 'icons/internet.gif';
                                loader.classList.add('loader');
                                previewItems.style.backgroundColor = "white";
                                previewItem.appendChild(loader);

                                fetch('http://localhost:8888/trimVideo', {
                                        method: 'POST',
                                        body: formData,
                                    })
                                    .then((response) => {
                                        if (!response.ok) {
                                            throw new Error('Error fetching trimmed video data.');
                                        }
                                        return response.blob(); // Get the video data as a Blob
                                    })
                                    .then((videoBlob) => {
                                        previewItem.removeChild(loader);
                                        videoElement.style.display = "block";
                                        buttons.style.display = "block";
                                        const trimmedVideoURL = URL.createObjectURL(videoBlob);
                                        videoElement.src = trimmedVideoURL;
                                        previewItem.appendChild(videoElement);
                                        previewItem.style.backgroundColor = "#333";
                                    })
                                    .catch((error) => {
                                        console.error(error);
                                    });
                            } else {
                                videoElement.controls = true;
                                buttons.style.display = "block";
                                previewItems.style.backgroundColor = "#333";
                                previewItem.appendChild(videoElement);
                            }
                        });
                        // const videoElement = document.querySelector('video');
                        videoElement.addEventListener('click', function() {
                            console.log('clicked');
                            if (videoElement.paused) {
                                videoElement.play();
                            } else {
                                videoElement.pause();
                            }
                        });
                        // Mute Button
                        const muteButton = previewItems.querySelector('.mute');
                        muteButton.addEventListener('click', function() {
                            if (videoElement.muted) {
                                videoElement.muted = false;
                                muteButton.querySelector('p').textContent = 'Mute';
                            } else {
                                videoElement.muted = true;
                                muteButton.querySelector('p').textContent = 'Unmute';
                            }
                        });

                        const flipButton = previewItems.querySelector('.flip');
                        let flipState = 0; // 0: Original, 1: Flip horizontally, 2: Flip vertically, 3: Flip both
                        flipButton.addEventListener('click', function() {
                            flipState = (flipState + 1) % 4;

                            if (flipState === 1) {
                                videoElement.style.transform = 'scaleX(-1)';
                            } else if (flipState === 2) {
                                videoElement.style.transform = 'scaleY(-1)';
                            } else if (flipState === 3) {
                                videoElement.style.transform = 'scale(-1, -1)';
                            } else {
                                videoElement.style.transform = 'scale(1, 1)';
                            }
                        });

                        // Timer Button
                        const timerButton = previewItems.querySelector('.timer');
                        let playbackRate = 1;
                        timerButton.addEventListener('click', function() {
                            if (playbackRate === 1) {
                                playbackRate = 1.5;
                                videoElement.playbackRate = playbackRate;
                                timerButton.querySelector('p').textContent = `${playbackRate}x`;
                            } else if (playbackRate === 1.5) {
                                playbackRate = 2;
                                videoElement.playbackRate = playbackRate;
                                timerButton.querySelector('p').textContent = `${playbackRate}x`;
                            } else {
                                playbackRate = 1;
                                videoElement.playbackRate = playbackRate;
                                timerButton.querySelector('p').textContent = 'Speed';
                            }
                        });
                    } else {
                        console.error('No video file selected.');
                    }
                }


            }

            // Listen for file selection change
            document.getElementById('videos').addEventListener('change', previewReels);
        });
    </script>

    <script>
        var userId = "<?php echo isset($_SESSION['UserId']) ? $_SESSION['UserId'] : '' ?>";

        // Check if the UserId exists
        if (!userId) {
            // UserId not found, redirect to login page
            window.location.href = "login.php";
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.Submit').click(function() {
                var videos = $('#videos').prop('files');

                $.ajax({
                    url: 'add_reel.php', // point to server-side PHP script 
                    dataType: 'text', // what to expect back from the PHP script
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    success: function(response) {
                        if (response === "success") {
                            console.log("reel added successfully");
                            alert("reel added successfully");
                            window.location.href = "index.php";
                        } else {
                            console.log("Error adding reel: " + response);
                            alert("Error adding reel: " + response);
                            $('#photos').val('');
                            $('#videos').val('');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>