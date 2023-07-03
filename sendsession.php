<?php
// Start the PHP session
session_start();

// Retrieve the UserId from the PHP session
$UserId = $_SESSION['UserId'];

// Set the URL of the Node.js server
$url = 'http://localhost:8888/start?UserId=' . $UserId;

// Set the data to be sent in the request body
$data = ['UserId' => $UserId];

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
