<?php
// Get the userIdx from the AJAX request
$UserIdx = $_POST['UserIdx'];

// Update the $recipientId with the received UserIdx
$recipientId = $UserIdx;

// Perform any necessary operations with $recipientId

// Return a response if needed
// You can echo a success message or any other relevant information
echo $recipientId;
?>
