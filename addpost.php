<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('db.php');
$UserId = $_SESSION['UserId'];

if (isset($_POST['title'])) {
    $sql = "SELECT COUNT(PostId) FROM posts";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
            $UserCounter = trim($row[0]);
        }
        $num = $UserCounter + 1;
        $num_padded = sprintf("%03d", $num);
        $num_padded; // return 04
    }
    $RegDate = date("M-d-Y");
    $PostId = 'POS' . $num_padded;
    $title = $_POST['title'];

    if (isset($_POST['content'])) {
        $content = $_POST['content'];
    } else {
        $content = '';
    }

    $datetime = new DateTime();
    $date_posted = $datetime->format('Y-m-d H:i:s');

    $imagePaths = array();
    $videoPaths = array();

    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $imageFiles = $_FILES['image'];

        foreach ($imageFiles['tmp_name'] as $key => $tmp_name) {
            $media_name = $imageFiles['name'][$key];
            $media_tmp = $tmp_name;
            $media_size = $imageFiles['size'][$key];
            $media_error = $imageFiles['error'][$key];

            if ($media_error === 0) {
                if ($media_size <= 2097152) {
                    $media_name_new = uniqid('', true) . '.' . pathinfo($media_name, PATHINFO_EXTENSION);
                    $media_destination = 'uploads/' . $media_name_new;

                    if (move_uploaded_file($media_tmp, $media_destination)) {
                        $imagePaths[] = $media_destination; // Add image file path to the array
                    }
                }
            }
        }
    }

    // Handle video uploads
    if (isset($_FILES['video']) && is_array($_FILES['video']['name'])) {
        $videoFiles = $_FILES['video'];

        foreach ($videoFiles['tmp_name'] as $key => $tmp_name) {
            $media_name = $videoFiles['name'][$key];
            $media_tmp = $tmp_name;
            $media_size = $videoFiles['size'][$key];
            $media_error = $videoFiles['error'][$key];

            // Handle video upload
            if ($media_error === 0) {
                if ($media_size <= 209715200) { // max video size is 200MB
                    $media_name_new = uniqid('', true) . '.' . pathinfo($media_name, PATHINFO_EXTENSION);
                    $media_destination = 'uploads/' . $media_name_new;

                    if (move_uploaded_file($media_tmp, $media_destination)) {
                        $videoPaths[] = $media_destination; // Add video file path to the array
                    }
                }
            }
        }
    }

    $imagePathsString = implode(', ', $imagePaths); // Concatenate image file paths into a single string
    $videoPathsString = implode(', ', $videoPaths); // Concatenate video file paths into a single string

    // Insert post into the database
    $sql = "INSERT INTO posts (UserId, PostId, title, content, image, video, date_posted)
            VALUES ('$UserId', '$PostId', '$title', '$content', '$imagePathsString', '$videoPathsString', '$date_posted')";
    $result = sqlsrv_query($conn, $sql);

    if ($result) {
        echo "success";
    } else {
        echo "Error adding post.";
    }

    sqlsrv_close($conn);
}
?>
