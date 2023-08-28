function loadNewsFeed() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          console.log('Response:', xhr.responseText);
          var newsFeed = document.getElementById('posts');
          newsFeed.innerHTML = '';

          response.posts.forEach(function(post) {
            var postElement = document.createElement('section');
            var postDiv = document.createElement('div');
            postDiv.className = 'post';

            var newsFeedPostDiv = document.createElement('div');
            newsFeedPostDiv.className = 'news-feed-post';

            var postHeaderDiv = document.createElement('div');
            postHeaderDiv.className = 'post-header';

            var userPassportImg = document.createElement('img');
            userPassportImg.className = 'UserPassport';
            userPassportImg.src = post.passport;

            var authorLink = document.createElement('a');
            authorLink.href = 'user_profile.php?UserId=' + post.UserId;
            authorLink.style.textDecoration = 'none';

            var authorNameP = document.createElement('p');
            authorNameP.className = 'post-author';
            authorNameP.innerHTML = '<strong>' + post.surname + ' ' + post.firstName + '</strong>';

            authorLink.appendChild(authorNameP);
            postHeaderDiv.appendChild(userPassportImg);
            postHeaderDiv.appendChild(authorLink);

            // var threeDotsDiv = document.createElement('div');
            // threeDotsDiv.id = 'threedots';

            // var dropdownButton = document.createElement('button');
            // dropdownButton.type = 'button';
            // dropdownButton.className = 'btn btn-link';
            // dropdownButton.dataset.bsToggle = 'dropdown';
            // dropdownButton.setAttribute('aria-haspopup', 'true');
            // dropdownButton.setAttribute('aria-expanded', 'false');
            // dropdownButton.innerHTML = '<i class="fas fa-ellipsis-h"></i>';

            // var dropdownMenu = document.createElement('div');
            // dropdownMenu.className = 'dropdown-menu dropdown-menu-right';

            // var blockUserDiv = document.createElement('div');
            // var blockUserButton = document.createElement('button');
            // blockUserButton.type = 'button';
            // blockUserButton.className = 'btn btn-primary blockUser';
            // blockUserButton.id = 'blockUser-' + post.UserId;
            // blockUserButton.dataset.recipientid = post.UserId;
            // blockUserButton.dataset.bsToggle = 'modal';
            // blockUserButton.dataset.bsTarget = '#blockUserModal-' + post.UserId;
            // blockUserButton.innerHTML = 'Block User';

            // var blockUserInput = document.createElement('input');
            // blockUserInput.type = 'hidden';
            // blockUserInput.id = 'bu' + post.UserId;
            // blockUserInput.value = post.UserId;

            // blockUserDiv.appendChild(blockUserButton);
            // blockUserDiv.appendChild(blockUserInput);

            // var blockButtonDiv = document.createElement('div');
            // var blockButtonButton = document.createElement('button');
            // blockButtonButton.type = 'button';
            // blockButtonButton.className = 'btn btn-primary blockButton';
            // blockButtonButton.id = 'blockButton-' + post.postId;
            // blockButtonButton.dataset.postid = post.postId;
            // blockButtonButton.dataset.bsToggle = 'modal';
            // blockButtonButton.dataset.bsTarget = '#blockTypeofPostModal-' + post.postId;
            // blockButtonButton.innerHTML = 'Block this type of post';

            // var blockButtonInput = document.createElement('input');
            // blockButtonInput.type = 'hidden';
            // blockButtonInput.id = 'b' + post.postId;
            // blockButtonInput.value = post.postId;

            // blockButtonDiv.appendChild(blockButtonButton);
            // blockButtonDiv.appendChild(blockButtonInput);

            // dropdownMenu.appendChild(blockUserDiv);
            // dropdownMenu.appendChild(blockButtonDiv);
            // dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
            //   '<a class="dropdown-item" href="#">Repost post</a>';

            // threeDotsDiv.appendChild(dropdownButton);
            // threeDotsDiv.appendChild(dropdownMenu);

            // Update the code to handle images and videos directly without carouselItems
            // Create a div for the post media
            var postMediaDiv = document.createElement('div');
            postMediaDiv.className = 'post-media';

            // Check if the post has an image
            if (post.image !== null && post.image !== '') {
              var postItem = document.createElement('div');
              postItem.className = 'post-item';
              var image = document.createElement('img');
              image.className = 'post-image';
              image.src = post.image;
              postItem.appendChild(image);
              postMediaDiv.appendChild(postItem);
            }

            // Check if the post has a video
            if (post.video !== null && post.video !== '') {
              var postItem = document.createElement('div');
              postItem.className = 'post-item';
              var videoContainer = document.createElement('div');
              videoContainer.className = 'post-video';
              var video = document.createElement('video');
              video.setAttribute('data-my-Video-id', post.postId);
              video.id = 'myVideo-' + post.postId;
              video.className = 'w-100';
              var source = document.createElement('source');
              source.src = post.video;
              source.type = 'video/mp4';
              video.appendChild(source);
              videoContainer.appendChild(video);
              // videoContainer.innerHTML += 'Your browser does not support the video tag.';
              var videoControls = document.createElement('div');
              videoControls.className = 'video-controls';
              var rewindButton = document.createElement('button');
              rewindButton.id = 'rewindButton-' + post.postId;
              rewindButton.onclick = function() {
                rewind(post.postId);
              };
              rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
              videoControls.appendChild(rewindButton);
              var playPauseButton = document.createElement('button');
              playPauseButton.onclick = function() {
                togglePlayPause(post.postId);
              };
              playPauseButton.innerHTML = '<span id="playPauseButton-' + post.postId + '"><i class="bi bi-play"></i></span>';
              videoControls.appendChild(playPauseButton);
              var fastForwardButton = document.createElement('button');
              fastForwardButton.id = 'fastForwardButton-' + post.postId;
              fastForwardButton.onclick = function() {
                fastForward(post.postId);
              };
              fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
              videoControls.appendChild(fastForwardButton);
              var volumeControl = document.createElement('div');
              volumeControl.className = 'volume-control';
              var volumeRange = document.createElement('input');
              volumeRange.type = 'range';
              volumeRange.id = 'volumeRange-' + post.postId;
              volumeRange.min = '0';
              volumeRange.max = '1';
              volumeRange.step = '0.01';
              volumeRange.value = '1';
              volumeRange.onchange = function() {
                setVolume(post.postId);
              };
              volumeControl.appendChild(volumeRange);
              videoControls.appendChild(volumeControl);
              var timeControl = document.createElement('div');
              timeControl.className = 'time-control';
              var timeRange = document.createElement('input');
              timeRange.type = 'range';
              timeRange.id = 'timeRange-' + post.postId;
              timeRange.min = '0';
              timeRange.step = '0.01';
              timeRange.value = '0';
              timeRange.onchange = function() {
                setCurrentTime(post.postId);
              };
              timeControl.appendChild(timeRange);
              var timeDisplay = document.createElement('div');
              timeDisplay.className = 'time-display';
              var currentTimeDisplay = document.createElement('div');
              currentTimeDisplay.className = 'currentTimeDisplay';
              currentTimeDisplay.id = 'currentTimeDisplay-' + post.postId;
              currentTimeDisplay.innerHTML = '0:00';
              timeDisplay.appendChild(currentTimeDisplay);
              timeDisplay.innerHTML += '<div class="slash">/</div>';
              var durationDisplay = document.createElement('div');
              durationDisplay.className = 'durationDisplay';
              durationDisplay.id = 'durationDisplay-' + post.postId;
              durationDisplay.innerHTML = '0:00';
              timeDisplay.appendChild(durationDisplay);
              timeControl.appendChild(timeDisplay);
              videoControls.appendChild(timeControl);
              videoContainer.appendChild(videoControls);
              postItem.appendChild(videoContainer);
              postMediaDiv.appendChild(postItem);

              // Create the Previous and Next buttons
              var previousButton = document.createElement('button');
              previousButton.className = 'previous-button';
              previousButton.innerHTML = '<i class="bi bi-arrow-left"></i>';

              var nextButton = document.createElement('button');
              nextButton.className = 'next-button';
              nextButton.innerHTML = '<i class="bi bi-arrow-right"></i>';

              var button = document.createElement('div');
              button.className = 'button';

              // Append the Previous and Next buttons to the postMediaDiv
              button.appendChild(previousButton);
              button.appendChild(nextButton);
              postMediaDiv.appendChild(button);

              // Get all the post items
              var postItems = postMediaDiv.getElementsByClassName('post-item');
              var currentIndex = 0; // Track the current index of the post item

              // Add click event listeners to scroll to the previous and next post items
              previousButton.addEventListener('click', function() {
                if (currentIndex > 0) {
                  postItems[currentIndex].style.display = 'none'; // Hide the current post item
                  currentIndex--; // Decrement the current index
                  postItems[currentIndex].style.display = 'block'; // Show the previous post item
                  postItems[currentIndex].scrollIntoView({
                    behavior: 'smooth'
                  }); // Scroll to the previous post item
                }
              });

              nextButton.addEventListener('click', function() {
                if (currentIndex < postItems.length - 1) {
                  postItems[currentIndex].style.display = 'none'; // Hide the current post item
                  currentIndex++; // Increment the current index
                  postItems[currentIndex].style.display = 'block'; // Show the next post item
                  postItems[currentIndex].scrollIntoView({
                    behavior: 'smooth'
                  }); // Scroll to the next post item
                }
              });
            }

            // Hide all media elements except the first one
            var mediaItems = postMediaDiv.getElementsByClassName('post-item');
            console.log(mediaItems.length);
            for (var i = 1; i < mediaItems.length; i++) {
              mediaItems[i].style.display = 'none';
            }

            // Append the post media div before the post content
            // newsFeedPostDiv.insertBefore(postMediaDiv, postContentDiv);

            var postContentDiv = document.createElement('div');
            postContentDiv.className = 'post-content';
            postContentDiv.textContent = post.content;

            var postDateDiv = document.createElement('div');
            postDateDiv.className = 'post-date';
            postDateDiv.textContent = post.timeAgo;

            var footerDiv = document.createElement('div');
            footerDiv.className = 'footer';

            var likeButton = document.createElement('button');
            likeButton.type = 'button';
            likeButton.className = 'btn btn-primary like ' + (post.isLiking ? 'likeing' : 'unlike');
            likeButton.dataset.postid = post.postId;
            likeButton.innerHTML = '<span class="like-count">' + post.likes + '</span>' +
              '<span class="emoji">&#x2764;</span>' +
              (post.isLiking ? 'Unlike' : 'Like');

            var shareButton = document.createElement('button');
            shareButton.type = 'button';
            shareButton.className = 'btn btn-primary share-button';
            shareButton.dataset.postid = post.postId;
            shareButton.innerHTML = '<i class="bi bi-share"></i> Share';

            var commentButton = document.createElement('button');
            commentButton.type = 'button';
            commentButton.className = 'btn btn-primary comment-button';
            commentButton.dataset.postid = post.postId;
            commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> Comment';

            footerDiv.appendChild(likeButton);
            footerDiv.appendChild(shareButton);
            footerDiv.appendChild(commentButton);

            postDiv.appendChild(newsFeedPostDiv);
            newsFeedPostDiv.appendChild(postHeaderDiv);
            // postHeaderDiv.appendChild(threeDotsDiv);
            var postTitleDiv = document.createElement('div');
            postTitleDiv.className = 'post-title';

            var postTitleH2 = document.createElement('h2');
            postTitleH2.textContent = post.title;

            postTitleDiv.appendChild(postTitleH2);
            postDiv.appendChild(postTitleDiv);
            // Append the post media div to the post div
            postDiv.appendChild(postMediaDiv);
            postDiv.appendChild(postContentDiv);
            postDiv.appendChild(postDateDiv);
            postDiv.appendChild(footerDiv);
            postElement.appendChild(postDiv);

            newsFeed.appendChild(postElement);
          });
          $('.owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: false,
            navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>']
          })
        } else {
          console.log('Error: ' + xhr.status);
        }
      }
    };

    xhr.open('GET', 'get_posts.php', true);
    xhr.send();
  }

  // Load initial news feed
  loadNewsFeed();

  $(document).ready(function() {
    $(".owl-carousel").owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: false
      // You can customize other options according to your needs
    });
  });