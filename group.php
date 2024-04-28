<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <style>
        /* Style your chat interface here */
        /* For example, chat bubbles, input box, etc. */
    </style>
</head>
<body>
    <div id="chat-container">
    </div>
    <input type="text" id="message-input" placeholder="Type your message...">
    <button onclick="sendMessage()">Send</button>

    <script>
        function sendMessage() {
            var MessageToBeSent = document.getElementById('message-input').value;
      var imageInput = document.querySelector('.image-input');
      var videoInput = document.getElementById('video');

      var image = null;
      if (imageInput.files.length > 0) {
        image = imageInput.files;
      }

      var video = null;
      if (videoInput.files.length > 0) {
        video = videoInput.files;
      }

      if (socket.connected) {
        socket.emit('newMessages', {
          UserId,
          UserIdx,
          MessageToBeSent,
          image,
          video,
        });
      } else {
        var offlineMessages = localStorage.getItem('offlineMessages') || [];
        offlineMessages.push({
          UserId,
          UserIdx,
          MessageToBeSent,
          image,
          video,
        });
        localStorage.setItem('offlineMessages', JSON.stringify(offlineMessages));
      }

      $('#message').val('');
      $('.image-input').val('');
      $('#video').val('');
        }
    </script>
</body>
</html>
