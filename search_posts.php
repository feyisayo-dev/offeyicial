<?php
include 'db.php';

$searchTerm = $_GET['searchTerm'];

$query = "SELECT title, UserId, content, PostId, CONVERT(VARCHAR, date_posted, 120) AS date_posted FROM posts WHERE LOWER(title) LIKE '%$searchTerm%' OR LOWER(content) LIKE '%$searchTerm%'";
$result = sqlsrv_query($conn, $query);

if ($result === false) {
    die(json_encode(array('error' => "Error executing query: " . sqlsrv_errors()[0]['message'])));
}

$posts = array();

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $posts[] = array(
        'title' => $row['title'],
        'content' => $row['content'],
        'UserId' => $row['UserId'],
        'PostId' => $row['PostId'],
        'date_posted' => $row['date_posted']
    );
}

echo json_encode($posts);
?>
