<?php
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];
$callerUserId = $_GET['callerUserId'];
// Get the name of the user you are talking to
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$callerUserId'";
$stmt = sqlsrv_prepare($conn, $sql);
if (sqlsrv_execute($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $recipientSurname = $row['Surname'];
        $recipientFirstName = $row['First_Name'];
        $Passport = $row['Passport'];
        if (empty($Passport)) {
            $recipientPassport = "UserPassport/DefaultImage.png";
        } else {
            $recipientPassport = "UserPassport/" . $Passport;
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ring</title>
    <link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link rel="stylesheet" href="css\all.min.css">
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <link rel="stylesheet" href="css\fontawesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/twemoji.min.js"></script>

    <style>
        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nameDiv h2 {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .status h2 {
            font-size: 16px;
            color: #888;
        }

        .imageDiv img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin: 16px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }

        .rejectBtn,
        .answerBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            font-size: 24px;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .rejectBtn {
            background-color: #dc3545;
            margin-right: 16px;
        }

        .answerBtn {
            background-color: #28a745;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="profile">
            <div class="nameDiv">
                <h2><?php echo $recipientFirstName . ' ' . $recipientSurname; ?></h2>
            </div>
            <div class="status">
                <h2>Incoming Call</h2>
            </div>
            <div class="imageDiv">
                <img src="<?php echo $recipientPassport ?>" alt="profile pic">
            </div>
        </div>
        <div class="buttons">
            <div class="reject">
                <button id="hang_button" class="rejectBtn"><i class="bi bi-telephone-x"></i></button>
            </div>
            <div class="answer">
                <button id="answer_button" class="answerBtn"><i class="bi bi-telephone"></i></button>
            </div>
        </div>
    </div>
</body>

</html>