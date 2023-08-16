<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $voicenoteFolder = 'voiceNote/';
    
    // Construct the full path to the file
    $filePath = $voicenoteFolder . $filename;

    // Delete the file if it exists
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo 'Voice note deleted successfully';
        } else {
            echo 'Failed to delete voice note';
        }
    } else {
        echo 'Voice note does not exist';
    }
}
?>
