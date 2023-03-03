
<?php
if(isset($_POST['follow'])){
    require('db.php');
    $profileOwnerId = $_POST['profileOwnerId'];
    $recipientId = $_POST['recipientId'];

    // Insert a new row in the follow table
    $sql = "INSERT INTO follows ([UserId], [recipientId]) VALUES (?, ?)";
    $params = array($profileOwnerId, $recipientId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }else{
        echo "followed";
    }




}
?>
