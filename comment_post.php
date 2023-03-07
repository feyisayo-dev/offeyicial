<?php
if(isset($_POST['addcoment'])){
	include('db.php');
	$comment = $_POST['comment'];
	$UserId = $_POST['UserId'];
	$postId = $_POST['postId'];

    $datetime = new DateTime();
    $date_posted = $datetime->format('Y-m-d H:i:s');


	$query = "INSERT into comments ([PostId], [UserId], [comment], [date_posted]) VALUES ('$postId', '$UserId', '$comment', '$date_posted')";

	$smc = sqlsrv_query($conn,$query);
	
	if ($smc === false){
		echo "Error";
		die(print_r(sqlsrv_errors(), true));  
	} else {
		echo "Updated successfully";
	}
}
?>
