<?php
session_start();
include('db.php');
$UserId = $_SESSION['UserId'];
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['Caption'])) {
    $sql = "SELECT COUNT(reelId) FROM reels";
    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC)) {
            $UserCounter = trim($row[0]);
        }
        $num = $UserCounter + 1;
        $num_padded = sprintf("%03d", $num);
    }

    $reelId = 'REL' . $num_padded;
    if (isset($_POST['AudioFileNames'])) {
        $audioFileNames = $_POST['AudioFileNames'];
    } else {
        $audioFileNames = "User's audio";
    }
    $videoBlob = $_POST['VideoBlob'];
    $caption = $_POST['Caption'];
    $visibility = $_POST['Visibility'];
    $canComment = isset($_POST['CanComment']) ? $_POST['CanComment'] : '';
    $canDownload = isset($_POST['CanDownload']) ? $_POST['CanDownload'] : '';
    $canLike = isset($_POST['CanLike']) ? $_POST['CanLike'] : '';
    $audioFileNames = isset($_POST['AudioFileNames']) ? $_POST['AudioFileNames'] : '';
    
    
    // echo "Caption: " . $caption . "<br>";
    // echo "VideoBlob: " . $videoBlob . "<br>";
    // echo "Visibility: " . $visibility . "<br>";
    // echo "Can Comment: " . $canComment . "<br>";
    // echo "Can Download: " . $canDownload . "<br>";
    // echo "Can Like: " . $canLike . "<br>";
    // echo "Audio File Names: " . $audioFileNames . "<br>";


    $datetime = new DateTime();
    $date_posted = $datetime->format('Y-m-d H:i:s');
    if (isset($_POST['VideoBlob'])) {
        $blob = $_POST['VideoBlob'];

        // $videoFileName = 'reel_' . uniqid() . '.mp4';

        $savePath = 'reels/'.$blob;

        
        $sql = "INSERT INTO reels ([UserId]
        ,[reelId]
        ,[Video]
        ,[audioFileNames]
        ,[caption]
        ,[visibility]
        ,[comment]
        ,[download]
        ,[like]
        ,[date_posted])
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = array($UserId, $reelId, $savePath, $audioFileNames, $caption, $visibility, $canComment, $canDownload, $canLike, $date_posted);

        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "success";
        }
    }

    sqlsrv_close($conn);
}
