<!-- <script>
          $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const UserIdx = urlParams.get('UserIdx');
            const sessionId = "<?php echo $sessionID ?>";
            console.log('data to be sent to sever for chat', UserIdx, 'and',sessionId);

            $.post('sendsession.php', {
                UserIdx: UserIdx,
                sessionId: sessionId
              })
              .done(function(response) {
                console.log('response gotten back from server from chat',response);
              })
              .fail(function(xhr, status, error) {
                console.error(error);
              });

          });
        </script> -->

<?php
// Start the PHP session
session_start();

// Retrieve the UserId from the PHP session
$UserId = $_SESSION['UserId'];
$UserIdx = $_POST['UserIdx'];
$sessionId = $_POST['sessionId'];

// Return a response
// echo 'UserIdx received: ' . $UserIdx;

// Set the URL of the Node.js server
$url = 'http://localhost:8888/start';

// Set the data to be sent in the request body
$data = [
    'UserId' => $UserId,
    'UserIdx' => $UserIdx,
    'sessionId' => $sessionId
];

// Create the request headers and options
$options = [
    'http' => [
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
    ],
];

// Create the stream context
$context = stream_context_create($options);

// Send the HTTP request and get the response
$result = file_get_contents($url, false, $context);

// Handle the response from the Node.js server
echo $result;
?>
