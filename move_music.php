<?php
$uploadDir = 'temp/';

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$uploadedFile = $_FILES['audio']; 

$response = array('success' => false);

$fileName = $uploadedFile['name'];
$destPath = $uploadDir . $fileName;

if (move_uploaded_file($uploadedFile['tmp_name'], $destPath)) {
    $response['success'] = true;
}else {
    error_log("Failed to move uploaded file $fileName to $destPath");
}

header('Content-Type: application/json');
echo json_encode($response);
?>
