<?php
header("Access-Control-Allow-Origin: *");

$audioUrl = $_GET['audioUrl'];

if (empty($audioUrl)) {
    http_response_code(400);
    echo 'Missing audioUrl parameter.';
    exit;
}

$audioContent = file_get_contents($audioUrl);

if ($audioContent !== false) {
    header("Content-Type: audio/mpeg");
    header("Content-Length: " . strlen($audioContent));

    echo $audioContent;
} else {
    http_response_code(500);
    echo 'Failed to fetch audio from Deezer.';
}
?>
