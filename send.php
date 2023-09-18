<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$audioUrl = $_GET['audioUrl'];
$audioFileName = $_POST['audioFileName'];
$audioFileNameedit = str_replace(' ', '_', $audioFileName);
$audioContent = file_get_contents($audioUrl);

if ($audioContent === false) {
    http_response_code(500);
    echo json_encode(array('error' => 'Failed to fetch audio content from the URL.'));
} else {
    $tempFolder = 'temp/';

    if (!file_exists($tempFolder)) {
        mkdir($tempFolder, 0755, true);
    }


    $audioFilePath = $tempFolder . $audioFileNameedit;

    if (file_put_contents($audioFilePath, $audioContent) !== false) {
        echo json_encode(array('success' => true, 'message' => 'Audio saved to the server.'));
    } else {
        http_response_code(500);
        echo json_encode(array('error' => 'Failed to save the audio file.'));
    }
}
?>
