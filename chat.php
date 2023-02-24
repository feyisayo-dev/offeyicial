
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: login.php');
  exit();
}
?>
<?php
// echo $recipientId=$_GET["UserIdx"];
// echo $UserId = $_GET['UserId'];
// session_start();


?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Chat App</title>
        <link rel="icon" href="img\offeyicial.jpeg" type="image/jpeg" sizes="32x32" />
        <link rel="stylesheet" href="css\all.min.css">
        <link rel="stylesheet" href="css\font\bootstrap-icons.css">
        <link rel="stylesheet" href="css\boostrap-icons">


        <style>
            nav {
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 50px;
                background-color: #04AA6D;
                color: white;
                padding: 0 20px;
            }
            
            nav a {
                color: white;
                text-decoration: none;
                margin: 0 10px;
            }
            
            .chat-container {
                width: 80%;
                margin: 50px auto;
                background-color: #f2f2f2;
                border-radius: 10px;
                padding: 20px;
            }
            
            .chat-header {
                text-align: center;
                background-color: #04AA6D;
                color: white;
                padding: 10px;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
            }
            
            .chat-header h1 {
                margin: 0;
            }
            
            .chat-messages {
                height: 300px;
                overflow-y: scroll;
                padding: 20px;
            }
            
            .chat-messages ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .chat-messages li {
                display: flex;
                align-items: flex-start;
                margin-bottom: 10px;
            }
            
            .Sent {
                /* float: right; */
                background-color: #33cabb;
                color: white;
                padding: 10px;
                border-radius: 10px;
                margin-top: 10px;
                margin-right: 20px;
                max-width: 60%;
            }
            
            .recieved {
                /* float: left; */
                background-color: #e5e5e5;
                color: black;
                padding: 10px;
                border-radius: 10px;
                margin-top: 10px;
                margin-left: 20px;
                max-width: 60%;
            }
            
            .chat-input {
                display: flex;
                padding: 20px;
                background-color: #f2f2f2;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
            }
            
            .chat-input input[type="text"] {
                flex: 1;
                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
                border: 2px solid #ccc;
                border-radius: 10px;
                box-shadow: 2px 2px 2px blue;
            }
            
            button[type="submit"] {
                padding: 12px 20px;
                background-color: #04AA6D;
                color: white;
                border: none;
                border-radius: 5px;
                margin-left: 10px;
            }
            
            .image-icon {
                display: inline-block;
                cursor: pointer;
            }
            
            /* .image-icon i {
                font-size: 25px;
                color: gray;
            } */
            
            .image-input {
                /* display: none; */
                width: 180px;
                background-color: #04AA6D;
                color: white;
            }
            
            textarea {
                width: 60%;
                height: 30px;
                padding: 5px;
                font-size: 16px;
                font-family: montserrat;
                resize: none;
                border-radius: 10px;
                box-shadow: 2px 2px 2px #04AA6D;
            }
            
            .message-sender {
                font-size: 12px;
                color: black;
            }
            
            .chats {
                height: auto;
                background: auto;
                border: 4px;
            }
        </style>
    </head>

    <body>

        <nav>
            <a href="home.php">Home</a>
            <?php
// session_start();

// Connect to the database
include('db.php');

$UserId = $_SESSION['UserId'];

// Get the surname and first name of the user with the UserId from the database
$sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
$stmt = sqlsrv_prepare($conn, $sql);
if(sqlsrv_execute($stmt)){
  while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
    $Surname = $row['Surname'];
    $First_Name = $row['First_Name'];
  }
}

// Display the user's surname and first name on the page
echo $Surname . " " . $First_Name;

?>


                <a href="user_profile.php?UserId=<?php echo $_SESSION['UserId']; ?>">Profile</a>


        </nav>

        <div class="chat-container">
            <div class="chat-header">
                <h1>
                <?php
include('db.php');

// Get the UserId of the user you are talking to
$recipientId = $_GET['UserIdx'];

// Get the name of the user you are talking to
$sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$recipientId'";
$stmt = sqlsrv_prepare($conn, $sql);
if(sqlsrv_execute($stmt)){
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $recipientSurname = $row['Surname'];
        $recipientFirstName = $row['First_Name'];
    }
}

$UserId = $_SESSION['UserId'];

// Get the surname and first name of the user with the UserId from the database
$sql = "select Surname, First_Name FROM User_Profile WHERE UserId = '$UserId'";
$stmt = sqlsrv_prepare($conn, $sql);
if(sqlsrv_execute($stmt)){
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        $Surname = $row['Surname'];
        $First_Name = $row['First_Name'];
    }
    echo $recipientSurname . " " . $recipientFirstName;

}

include 'db.php';

$query = "select * FROM chats ORDER BY chatId DESC";
$result = sqlsrv_query($conn, $query);

while ($row = sqlsrv_fetch_array($result)) {
    $UserId = $row['UserId'];
    $recipientId = $row['recipientId'];
    $senderId = $row['senderId'];
    $message = $row['Sent'];

    echo '<li class="' . ($senderId == $UserId ? 'Sent' : 'received') . '">';
    echo '<p>' . $message . '</p>';
    echo '<div class="message-sender">' . ($senderId == $UserId ? $Surname . ' ' . $First_Name : $recipientSurname . ' ' . $recipientFirstName) . '</div>';
    echo '</li>';
}

?>

        </div>
        <br><br>
        <div class="form-group">
            <textarea class="form-control" id="message" rows="3"></textarea>
            <div class="image-icon">
                <!-- <i class="bi-file-image"></i> -->
                <input type="file" class="image-input" accept="image/*" />
            </div>
            <button type="submit" class="submit">Send</button>
        </div>

        </div>
        <script src="js/jquery.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.submit').click(function() {
                    var message = $('#message').val();
                    var image = $('.image-input').prop('files')[0];
                    var UserId = '<?php echo $UserId; ?>';
                    var recipientId = '<?php echo $recipientId; ?>';

                    var formData = new FormData();
                    formData.append('message', message);
                    formData.append('image', image);
                    formData.append('UserId', UserId);
                    formData.append('recipientId', recipientId);

                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                        }
                    });
                });
            });
        </script>


    </body>

    </html>