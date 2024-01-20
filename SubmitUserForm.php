<?php
include('db.php');

if (isset($_POST['Submit'])) {
	require('db.php');
	$sql = "SELECT TOP 1 UserId FROM User_Profile ORDER BY UserId DESC";
	$stmt = sqlsrv_query($conn, $sql);
	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	} else {
		if (sqlsrv_has_rows($stmt)) {
			$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC);
			$lastUserId = trim($row[0]);
			$num = substr($lastUserId, -5) + 1;
		} else {
			$num = 1;
		}
		$num_padded = sprintf("%05d", $num);
		$num_padded;
	}

	$RegDate = date("M-d-Y");

	$UserId = 'OFF' . $num_padded;


	$Surname = ($_POST['Surname']);
	$First_Name = ($_POST['First_Name']);
	$gender = ($_POST['gender']);
	$email = ($_POST['email']);
	$password = $_POST['psw'];
	$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
	$phone = ($_POST['phone']);
	$dob = ($_POST['dob']);
	$countryId = ($_POST['countryId']);
	$stateId = ($_POST['stateId']);


	$email_exists_query = "SELECT COUNT(*) AS count FROM User_Profile WHERE email = '$email'";
	$email_exists_result = sqlsrv_query($conn, $email_exists_query);
	if ($email_exists_result === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	$email_exists_count = sqlsrv_fetch_array($email_exists_result, SQLSRV_FETCH_ASSOC)['count'];

	if ($email_exists_count > 0) {
		$response = array('Email already registered');
		echo json_encode(array($response));
	} else {
		$sql = "Insert into User_Profile ([UserId]
	,[Surname]
	,[First_Name]
	,[gender]
	,[email]
	,[Password]
	,[phone]
	,[dob]
	,[countryId]
	,[stateId])
	values('$UserId','$Surname','$First_Name','$gender','$email','$hashedPassword','$phone','$dob','$countryId','$stateId')";


		$smc = sqlsrv_query($conn, $sql);
		if ($smc === false) {
			$error_message = array("error" => "data not successfully upload");
			echo json_encode($error_message);
			die(print_r(sqlsrv_errors(), true));
		} else {
			$response = array('UserId' => $UserId);
			echo json_encode($response);
		}
	}
}
?>

<?php
if (isset($_POST['addbio'])) {
	include('db.php');
	$bio = $_POST['bio'];
	$UserId = $_POST['UserId'];

	$query = "UPDATE User_Profile SET bio='$bio' where UserId= '$UserId'";
	$smc = sqlsrv_query($conn, $query);

	if ($smc === false) {
		echo "Error";
		die(print_r(sqlsrv_errors(), true));
	} else {
		echo "Updated successfully";
	}
}
?> 



<?php
if (isset($_POST['edit'])) {
	include('db.php');
	$UserId = $_POST['UserId'];
	$Surname = ($_POST['Surname']);
	$First_Name = ($_POST['First_Name']);
	$gender = ($_POST['gender']);
	$email = ($_POST['email']);
	$phone = ($_POST['phone']);
	$dob = ($_POST['dob']);
	$countryId = ($_POST['country']);
	$stateId = ($_POST['state']);
	$Update = "Update User_Profile SET 
	Surname='" . $Surname . "',
	First_Name='" . $First_Name . "',
	gender='" . $gender . "',
	email='" . $email . "',
	phone='" . $phone . "',
	dob='" . $dob . "',
	countryId='" . $countryId . "',
	stateId='" . $stateId . "' where UserId='$UserId'";
	$UpdateStmt = sqlsrv_query($conn, $Update);

	if ($UpdateStmt === false) {
		echo "fail";
		die(print_r(sqlsrv_errors(), true));
	} else {
		echo "success";
	}
}
?>