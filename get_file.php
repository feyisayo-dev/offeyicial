<?php
$audioFileName = $_GET['audioFileName'];
$directory = "temp/";
$audioFileNameedit = str_replace(' ', '_', $audioFileName);


$filePath = $directory . $audioFileNameedit;


if (file_exists($filePath)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $audioFileNameedit . '"');
    
    readfile($filePath);
} else {
    http_response_code(404);
    echo 'File not found';
}
?>
