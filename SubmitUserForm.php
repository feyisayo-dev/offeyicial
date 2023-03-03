<?php

//insert memebers using unique user id

if (isset($_POST['Submit'])){
	require ('db.php');
	$sql= "select count(UserId) from User_Profile";
	$stmt = sqlsrv_query( $conn,$sql);
	if( $stmt=== false) {
		die( print_r( sqlsrv_errors(), true));
	}else{


		while($row= sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC)){
			$UserCounter= trim($row[0]);
		}
		$num = $UserCounter+1;
		$num_padded = sprintf("%05d", $num);
		$num_padded; // return 04
	}

	$RegDate=date("M-d-Y");

	$UserId='OFF'.$num_padded;



	$Surname = ($_POST['Surname']);
	$First_Name = ($_POST['First_Name']);
	$gender = ($_POST['gender']);
	$email = ($_POST['email']);
	$pasword = ($_POST['psw']);
	$phone = ($_POST['phone']);
	$dob = ($_POST['dob']);
	$countryId = ($_POST['countryId']);
	$stateId = ($_POST['stateId']);
	
	
	
	
	
	include ('db.php');
	
						
	$sql="Insert into User_Profile ([UserId]
	,[Surname]
	,[First_Name]
	,[gender]
	,[email]
	,[Password]
	,[phone]
	,[dob]
	,[countryId]
	,[stateId])
	values('$UserId','$Surname','$First_Name','$gender','$email','$pasword','$phone','$dob','$countryId','$stateId')";
	
	
	$smc=sqlsrv_query($conn,$sql);
	
	//give information if the data is successful or not.
	
	If ($smc===false){
					   echo" <font color='black'><em> data not successfully upload</em></font><br/>";
					   die( print_r( sqlsrv_errors(), true));  
					 }else{
						// echo"1"; //Correct Passowrd
                        session_start();
                       echo $_SESSION['UserId']=$UserId;
	
					   
	
							 }
	
	
	
	

}


?>
<?php 
if(isset($_POST['addbio'])){
	include('db.php');
	$bio = $_POST['bio'];
	$UserId = $_POST['UserId'];

	$query = "UPDATE User_Profile SET bio='$bio' where UserId= '$UserId'";
	$smc = sqlsrv_query($conn,$query);
	
	if ($smc===false){
		echo "Error";
		die(print_r(sqlsrv_errors(), true));  
	} else {
		echo "Updated successfully";
	}
}
?> 




<?php
if(isset($_POST['Update'])){
	include ('db.php');
	$Surname = ($_POST['Surname']);
	$First_Name = ($_POST['First_Name']);
	$gender = ($_POST['gender']);
	$email = ($_POST['email']);
	$phone = ($_POST['phone']);
	$dob = ($_POST['dob']);
	$countryId = ($_POST['countryId']);
	$stateId = ($_POST['stateId']);
	$Update ="Update User_Profile SET 
	Surname='".$Surname."',
	First_Name='".$First_Name."',
	gender='".$gender."',
	email='".$email."',
	phone='".$phone."',
	dob='".$dob."',
	countryId='".$countryId."',
	stateId='".$stateId."' where ltrim(UserId)='$UserId'";
	$UpdateStmt=sqlsrv_query($conn,$Update);

	if( $UpdateStmt===false){  
		echo "fail";
		die( print_r( sqlsrv_errors(), true)); 

			}else{
				session_start();
                echo $_SESSION['UserId']=$UserId;
			} 

}
?>