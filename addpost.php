<?php
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

    $imageUploadSuccess = true;
    $videoUploadSuccess = true;

    // Handle image uploads
    if (isset($_FILES['image']) && is_array($_FILES['image']['name'])) {
        $images = $_FILES['image'];

        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $image_name = $images['name'][$key];
            $image_tmp = $tmp_name;
            $image_size = $images['size'][$key];
            $image_error = $images['error'][$key];

            $image_ext = explode('.', $image_name);
            $image_ext = strtolower(end($image_ext));

            $allowed_ext = array('jpg', 'jpeg', 'png');

            if (in_array($image_ext, $allowed_ext)) {
                if ($image_error === 0) {
                    if ($image_size <= 2097152) {
                        $image_name_new = uniqid('', true) . '.' . $image_ext;
                        $image_destination = 'uploads/' . $image_name_new;
                        $UserId = $_SESSION['UserId'];
                        if (move_uploaded_file($image_tmp, $image_destination)) {
                            $sql = "INSERT INTO posts (UserId, PostId, title, content, image, date_posted)
                                    VALUES ('$UserId', '$PostId', '$title', '$content', '$image_destination', '$date_posted')";
                            $result = sqlsrv_query($conn, $sql);
                            if (!$result) {
                                $imageUploadSuccess = false;
                            }
                        } else {
                            $imageUploadSuccess = false;
                        }
                    } else {
                        $imageUploadSuccess = false;
                    }
                } else {
                    $imageUploadSuccess = false;
                }
            } else {
                $imageUploadSuccess = false;
            }
        }
    }

    // Handle video uploads
    if (isset($_FILES['video']) && is_array($_FILES['video']['name'])) {
        $videos = $_FILES['video'];

        foreach ($videos['tmp_name'] as $key => $tmp_name) {
            $video_name = $videos['name'][$key];
            $video_tmp = $tmp_name;
            $video_size = $videos['size'][$key];
            $video_error = $videos['error'][$key];

            $video_ext = explode('.', $video_name);
            $video_ext = strtolower(end($video_ext));

            $allowed_ext = array('mp4', 'avi', 'wmv');

            if (in_array($video_ext, $allowed_ext)) {
                if ($video_error === 0) {
                    if ($video_size <= 209715200) { // max video size is 200MB
                        $video_name_new = uniqid('', true) . '.' . $video_ext;
                        $video_destination = 'uploads/' . $video_name_new;
                        $UserId = $_SESSION['UserId'];
                        if (move_uploaded_file($video_tmp, $video_destination)) {
                            $sql = "INSERT INTO posts (UserId, PostId, title, content, video, date_posted)
                                    VALUES ('$UserId', '$PostId', '$title', '$content', '$video_destination', '$date_posted')";
                            $result = sqlsrv_query($conn, $sql);
                            if (!$result) {
                                $videoUploadSuccess = false;
                            }
                        } else {
                            $videoUploadSuccess = false;
                        }
                    } else {
                        $videoUploadSuccess = false;
                    }
                } else {
                    $videoUploadSuccess = false;
                }
            } else {
                $videoUploadSuccess = false;
            }
        }
    }

    // Check if both image and video uploads were successful
    if ($imageUploadSuccess && $videoUploadSuccess) {
        echo "success";
    } else {
        echo "Error adding post.";
    }

    sqlsrv_close($conn);
}
?>
