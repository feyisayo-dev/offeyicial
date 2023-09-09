<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$baseUrl = "https://api.deezer.com/track/";
$query = $_GET['query'];
$url = $baseUrl . $query;

$response = file_get_contents($url);

if (empty($response) || stripos($response, '<html') !== false) {
    http_response_code(500);
    echo json_encode(array('error' => 'Failed to fetch data from Deezer API.'));
} else {
    echo $response;
}
?>
