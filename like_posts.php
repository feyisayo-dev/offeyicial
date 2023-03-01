<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'db.php';

if (!isset($_SESSION['UserId'])) {
    http_response_code(401);
    exit();
}

$PostId = $_POST['PostId'];
$UserId = $_SESSION['UserId'];

// Check if the user has already liked the post
$stmt = $pdo->prepare('SELECT COUNT(Likes) FROM posts WHERE PostId = ? AND UserId = ?');
$stmt->execute([$PostId, $UserId]);
$numLikes = $stmt->fetchColumn();

if ($numLikes == 0) {
    // User has not liked the post, so increment the Likes count and add a new like record
    $stmt = $pdo->prepare('UPDATE posts SET Likes = Likes + 1 WHERE PostId = ?');
    $stmt->execute([$PostId]);

    $stmt = $pdo->prepare('INSERT INTO Likes (PostId, UserId) VALUES (?, ?)');
    $stmt->execute([$PostId, $UserId]);

    $newLikes = $stmt->rowCount();
} else {
    // User has already liked the post, so decrement the Likes count and remove the like record
    $stmt = $pdo->prepare('UPDATE posts SET Likes = Likes - 1 WHERE PostId = ?');
    $stmt->execute([$PostId]);

    $stmt = $pdo->prepare('DELETE FROM Likes WHERE PostId = ? AND UserId = ?');
    $stmt->execute([$PostId, $UserId]);

    $newLikes = $stmt->rowCount() * -1;
}

// Return the new like count
echo json_encode(['Likes' => $newLikes]);
?>
