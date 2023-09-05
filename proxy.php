<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$baseUrl = "https://api.deezer.com/";
$query = $_GET['query'];
$url = $baseUrl . $query;

$response = file_get_contents($url);

echo $response;
?>
