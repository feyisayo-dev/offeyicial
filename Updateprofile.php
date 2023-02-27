<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit();
}
?>

<?php



$UserId=$_GET["UserId"];//edit user id
include ('db.php');


$fetchUserInfo="Select [Surname]
,[First_Name]
,[gender]
,[email]
,[Password]
,[phone]
,[dob]
,[countryId]
,[stateId] from User_Profile where UserId='$UserId'";
$FetchStatement=sqlsrv_query($conn,$fetchUserInfo);
if( $FetchStatement === false ) {
 die( print_r( sqlsrv_errors(), true));
}

if (sqlsrv_fetch($FetchStatement)===false) {
die( print_r( sqlsrv_errors(), true));
}else{
$Surname=sqlsrv_get_field($FetchStatement,0);
$First_Name=sqlsrv_get_field($FetchStatement,1);
$gender=sqlsrv_get_field($FetchStatement,2);
$email=sqlsrv_get_field($FetchStatement,3);
$Password=sqlsrv_get_field($FetchStatement,4);
$phone=sqlsrv_get_field($FetchStatement,5);
$dob=sqlsrv_get_field($FetchStatement,6);
$countryId=sqlsrv_get_field($FetchStatement,7);
$stateId=sqlsrv_get_field($FetchStatement,8);
$Passport=sqlsrv_get_field($FetchStatement,9);
if (empty( $Passport)) {
  $GetPassport="User_Passport/DefaultImage.png";
 }else{
 $GetPassport="User_Passport/".$Passport;
 }
}



?>

<html>
<head>
<meta name="description"  />
<link rel="stylesheet" href="css/normalize.css">
<link href='https://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
<link href="css/all.min.css" rel="stylesheet">
<script src="country-states.js"></script>
<title>STUDENT HELPER</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <script src="js/jquery.min.js"></script>
  <script src="country-states.js"></script>
  <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
<meta charset=utf-8>
<style>
 .form_wrapper {
    width: 100%;
    margin: auto;
    background-image: url(img/connecting_users.jpg);
    }

    .form_container {
      background: transparent;
    /* padding: 20px; */
    /* border-radius: 10px; */
    background-size: cover;
    }

.title_container {
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.form-group label {
    width: 100px;
    font-weight: bold;
    margin-right: 10px;
    color: white;
}

.form-group input {
    flex-grow: 1;
    padding: 10px;
    border-radius: 5px;
    border: none;
    box-shadow: 2px 2px 2px #0066ff;
}

.form-group input[type="checkbox"] {
    margin-left: 10px;
}

.form-inline {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
}

.form-inline label {
    margin: 0 5px 0 0;
}

.form-inline input,
.form-inline select {
    flex: 1;
    margin-bottom: 5px;
}

.form-inline .form-group {
    display: flex;
    align-items: center;
}

.form-inline .form-control {
    width: 100%;
}

  /* .form_wrapper {
            width: 100%;
            margin: auto;
            border-top: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-bottom: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-left: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-right: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-style: groove;
            box-sizing: border-box;
        }
         */
.Update {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 10px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
}        
.form_wrapper input[type=Update]:hover {
            background: #01fa0e;
  }

.form_wrapper input[type=Update]:focus {
            background: #01fa0e;
 }

.form-group input[type="password"] {
    position: relative;
}

.form-group input[type="checkbox"] {
    position: absolute;
    top: 10px;
    right: 10px;
}
.show-password-btn {
  font-size: 12px;
  padding: 3px 6px;
}
button.container {
    font-size: 0.8em; /* make the font smaller */
    padding: 2px; /* reduce the size of the button */
    width: 50px;
}
h2 {
  color: white; /* sets text color to red */
  font-size: 50px; /* sets font size to 20px */
  text-align: center; /* centers the text */
 background: transparent;
}
/* Position the icon at the top left corner of the page */
.icon {
    float: left;
    margin-top: 10px;
    margin-left: 10px;
    width: 50px;
    length: 50px;
}



</style>
</head>


<body>
<div class="form_wrapper">
    <div class="form_container">
      <center>
        <table>
        <div class="title_container">
          <h2>Registration Form</h2>
        </div>
      </center>
      <!-- <form action="UpdateStudentForm.php" method="post"> -->
      
      <div class="form-group">
        <label for="Surname">Surname:</label>
        <input type="text" class="form-control" id="Surname" placeholder="Surname" name="Surname"  value="<?php echo $Surname ?>" />
      </div>
      <div class="form-group">
        <label for="First Name">First Name:</label>
        <input type="text" class="form-control" id="First_Name" placeholder="First Name" name="First_Name" value="<?php echo $First_Name ?>" />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email ?>" />
      </div>
    
      <div class="form-group">
        <label for="Phone">Phone:</label>
        <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value="<?php echo $phone ?>" />
      </div>
      <div class="form-group">
          <label for="dob">DOB:</label>
          <input type="date" class="form-control" id="dob" placeholder="dob" name="dob" value="<?php echo $dob ?>" />
        </div>
      </div>

       <!-- -- -->
       
       <div class="form-group">
  <label for="gender">Gender:</label><br>
  <input type="radio" class="gender" id="rd1" value="Male" name="gender" <?php echo ($gender == 'Male') ? 'checked' : '' ?> >
  <label for="rd1">Male</label>
  <input type="radio" class="gender" id="rd2" value="Female" name="gender" <?php echo ($gender == 'Female') ? 'checked' : '' ?>>
  <label for="rd2">Female</label>
  <input type="radio" class="gender" id="rd3" value="Others" name="gender" <?php echo ($gender == 'Others') ? 'checked' : '' ?>>
  <label for="rd3">I prefer not to say</label>
</div>

<div class="form-group">
<label for="country">Country:</label>
  <select class="form-control" id="countryId" name="country">
    <option value="">Select your country</option>
    <?php
    $tsql = "select distinct countryId FROM User_Profile";
$stmt = sqlsrv_query( $conn,$tsql); 



if( $stmt === false)  
{  
    die(print_r( sqlsrv_errors(), true));  
}  
else  
{  
    while($row= sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))  
    {  
        echo '<option value="'.$row['countryId'].'">'.$row['countryId'].'</option>';  
    }  
} 


?>

         </select>
         
         <div class="select_arrow"></div>
       </div>

       <div class="form-group">
       <label for="state">State:</label>
  <select class="states form-control" name="state" id="stateId">
    <option>Select a state</option>
    <?php
    $tsql = "select distinct state from User_Profile";  
    $stmt = sqlsrv_query( $conn,$tsql); 
    if( $stmt === false) {  
        die(print_r( sqlsrv_errors(), true));  
    } 
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo '<option value="'.$row['state'].'">'.$row['state'].'</option>';
    }
    ?>
  </select>
</div>
<div class="form-group">
<input type="Update" class="Update" value="Update" />
</div>




   </div>
 </div>
</div>
</div>
<p class="credit">Developed by <a href="" target="_blank">Offeyicial</a></p>

</body>

<script src="js/jquery.min.js"></script>  
<script>
  $(document).ready(function() {
    $('#countryId').on('change', function() {
      var countryId = $(this).val();
      if(countryId) {
        $.ajax({
          url: 'SubmitUserForm.php',
          type: 'POST',
          data: {'countryId': countryId},
          dataType: 'json',
          success: function(data) {
            $('#stateId').empty();
            $.each(data, function(key, value) {
              $('#stateId').append('<option value="'+ key +'">'+ value +'</option>');
            });
          }
        });
      }else{
        $('#stateId').empty();
      }
    });
  });
</script>




<script>
$('.Update').click(function() {
let email=$('#email').val();
let Surname=$('#Surname').val();
let First_Name=$('#First_Name').val();
let phone=$('#phone').val();
let dob=$('#dob').val();




         

let UserId=<?php echo json_encode($UserId) ;?>;

var gender="";
         var ele = document.getElementsByName('gender');
           
         for(i = 0; i < ele.length; i++) {
             if(ele[i].checked)
             gender= ele[i].value;
         }
    

let countryId=$('#countryId').val();
let stateId=$('#stateId').val();

if (password==Confirmpassword) {
 
 $.ajax({
     url: "SubmitUserForm.php",
     type: "POST",
     async: false,
     data: {
       "Update": 1,
     "email": email, 
     "Surname": Surname,
     "First_Name": First_Name,
     "phone": phone,
     "dob": dob,
     "gender": gender,     
     "countryId": countryId,
     "stateId": stateId,
     "UserId": UserId,
     },
     success: function(data) {
  
      alert("Update Successful");
         
     }
     
 
 });

  location.href = 'user_profile.php?UserId='+UserId;


}else{
 alert("There is an issue with the update")
}





});

</script>



<script>
$('.countryId').change(function() {
 let countryId=$('.countryId').val();

     $.ajax({
     url: "Fetch.php",
     type: "POST",
     async: false,
     data: {
       "FetchState": 1,
     "countryId": countryId, 
     },
     success: function(data) {
      $('.stateId').html(data);
         
     }
 
 });
});

</script>









</html> 





