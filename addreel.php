<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Add Reels</title>
    <style>
        /* CSS styles here */

        .body {
            background-color: #000000;
            color: #ffffff;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="file"] {
            display: none;
        }

        .upload-box-container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-top: 10px;
        }

        .upload-box {
            flex: 1;
            background-color: #ffffff;
            text-align: center;
            line-height: 200px;
            font-size: 80px;
            cursor: pointer;
        }

        .upload-box:hover {
            background-color: #cccccc;
        }

        .preview-container {
            margin-top: 20px;
            text-align: center;
        }

        .preview-item {
            display: inline-block;
            margin-right: 10px;
        }

        .preview-item img,
        .preview-item video {
            width: 200px;
            height: auto;
        }

        .Submit {
            padding: 10px;
            border-radius: 10px;
            background-color: aqua;
            justify-self: center;
            align-self: center;
        }

        .Submit:hover {
            transform: scaleX(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Reels</h2>
        <div class="form-group">
            <label for="photos">Upload Photos:</label>
            <input type="file" name="photos[]" id="photos" accept="image/*" multiple>
            <div class="upload-box"><i class="bi bi-image"></i> </div>
            <label class="upload-box" for="photos"></label>
        </div>
        <div class="form-group">
            <label for="videos">Upload Videos:</label>
            <input type="file" name="videos[]" id="videos" accept="video/*" multiple>
            <div class="upload-box"><i class="bi bi-camera-video"></i></div>
            <label class="upload-box" for="videos"></label>
        </div>

        <div class="form-group">
            <input type="submit" class="Submit" value="Upload Reels">
        </div>
        <div class="preview-container">
            <h3>Reels Preview</h3>
            <div class="preview-items"></div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>

    <script>
        // Display selected videos and photos as a preview
        function previewReels(event) {
            const videos = document.getElementById('videos').files;
            const photos = document.getElementById('photos').files;
            const previewItems = document.querySelector('.preview-items');

            // Clear previous previews
            previewItems.innerHTML = '';

            // Display videos
            for (let i = 0; i < videos.length; i++) {
                const videoURL = URL.createObjectURL(videos[i]);
                const videoElement = document.createElement('video');
                videoElement.src = videoURL;
                videoElement.controls = true;
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.appendChild(videoElement);
                previewItems.appendChild(previewItem);
            }

            // Display photos
            for (let i = 0; i < photos.length; i++) {
                const photoURL = URL.createObjectURL(photos[i]);
                const photoElement = document.createElement('img');
                photoElement.src = photoURL;
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.appendChild(photoElement);
                previewItems.appendChild(previewItem);
            }
        }

        // Listen for file selection change
        document.getElementById('videos').addEventListener('change', previewReels);
        document.getElementById('photos').addEventListener('change', previewReels);
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
                var photos = $('#photos').prop('files');
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