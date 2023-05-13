<?php
require_once ('vendor/autoload.php'); // if you use Composer
// require_once('ultramsg.class.php'); // if you download ultramsg.class.php
    
$token="q2hqha2y2cbfiiia"; // Ultramsg.com token
$instance_id="instance46912"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($token,$instance_id);
    
$to="09063392515"; 
$body="https://stickers-download.mi-biografia.co/en/pack/2995651/"; 
$api=$client->sendChatMessage($to,$body);
echo $api;
?>