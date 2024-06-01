<script>
    if (result.video !== null && result.video !== '') {
        result.video.forEach(function(videoPath, index) {
            var newId = result.postId + '-' + index;
            var postItem = document.createElement('div');
            postItem.className = 'post-item';
            postItem.id = 'post-item' + newId;

            var videoContainer = document.createElement('div');
            videoContainer.className = 'video';
            var video = document.createElement('video');
            video.setAttribute('data-my-Video-id', newId);
            video.id = 'myVideo-' + newId;
            video.className = 'w-100';

            var source = document.createElement('source');
            source.src = videoPath;
            source.type = 'video/mp4';

            video.appendChild(source);
            videoContainer.appendChild(video);

            var videoControls = document.createElement('div');
            videoControls.className = 'video-controls';

            var rewindButton = document.createElement('button');
            rewindButton.id = 'rewindButton-' + newId;
            rewindButton.onclick = function() {
                rewind(newId);
            };
            rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
            videoControls.appendChild(rewindButton);
            var playPauseButton = document.createElement('button');
            playPauseButton.classList.add('play');
            playPauseButton.onclick = function() {
                togglePlayPause(newId);
            };
            playPauseButton.innerHTML = '<span class="playPauseButton" id="playPauseButton-' + newId + '"><i class="bi bi-play"></i></span>';
            videoControls.appendChild(playPauseButton);
            var fastForwardButton = document.createElement('button');
            fastForwardButton.id = 'fastForwardButton-' + newId;
            fastForwardButton.onclick = function() {
                fastForward(newId);
            };
            fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
            videoControls.appendChild(fastForwardButton);
            var volumeControl = document.createElement('div');
            volumeControl.className = 'volume-control';
            var volumeRange = document.createElement('input');
            volumeRange.type = 'range';
            volumeRange.id = 'volumeRange-' + newId;
            volumeRange.min = '0';
            volumeRange.max = '1';
            volumeRange.step = '0.01';
            volumeRange.value = '1';
            volumeRange.onchange = function() {
                setVolume(newId);
            };
            volumeControl.appendChild(volumeRange);
            videoControls.appendChild(volumeControl);
            var timeControl = document.createElement('div');
            timeControl.className = 'time-control';
            var timeRange = document.createElement('input');
            timeRange.type = 'range';
            timeRange.id = 'timeRange-' + newId;
            timeRange.min = '0';
            timeRange.step = '0.01';
            timeRange.value = '0';
            timeRange.onchange = function() {
                setCurrentTime(newId);
            };
            timeControl.appendChild(timeRange);
            var timeDisplay = document.createElement('div');
            timeDisplay.className = 'time-display';
            var currentTimeDisplay = document.createElement('div');
            currentTimeDisplay.className = 'currentTimeDisplay';
            currentTimeDisplay.id = 'currentTimeDisplay-' + newId;
            currentTimeDisplay.innerHTML = '0:00';
            timeDisplay.appendChild(currentTimeDisplay);
            timeDisplay.innerHTML += '<div class="slash">/</div>';
            var durationDisplay = document.createElement('div');
            durationDisplay.className = 'durationDisplay';
            durationDisplay.id = 'durationDisplay-' + newId;
            durationDisplay.innerHTML = '0:00';

            video.addEventListener('loadedmetadata', function() {
                console.log("Video loaded", video.duration)
                durationDisplay.innerHTML = formatTime(video.duration);
            });

            video.addEventListener('timeupdate', function() {
                handleTimeUpdate(newId);
            });

            timeRange.oninput = function() {
                var newTime = video.duration * (timeRange.value / 100);
                video.currentTime = newTime;
                currentTimeDisplay.innerHTML = formatTime(newTime);
            };
            timeDisplay.appendChild(durationDisplay);
            timeControl.appendChild(timeDisplay);
            videoControls.appendChild(timeControl);

            videoContainer.appendChild(videoControls);
            postItem.appendChild(videoContainer);
            postMediaDiv.appendChild(postItem);
        });
</script>