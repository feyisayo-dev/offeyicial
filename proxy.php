<?php
header("Access-Control-Allow-Origin: *"); // Allow all domains to access this proxy
header("Content-Type: application/json");

$baseUrl = "https://api.deezer.com/";
$query = $_GET['query'];
$url = $baseUrl . $query;

$response = file_get_contents($url);

echo $response;
?>
