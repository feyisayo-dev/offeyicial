<!DOCTYPE html>
<html>

<head>
    <title>Logging out</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <style>
        .html-box {
            /* display: none; */
            /* Hide the box by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            /* Black with transparency */
        }

        .html-box-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }

        .html-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .html-box-header h2 {
            margin: 0;
        }

        .html-box-body {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .html-box-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #ccc;
        }

        .logout-btn {
            background-color: #f44336;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="html-box">
        <div class="html-box-content">
            <div class="html-box-header">
                <span class="close">&times;</span>
                <h2>You are leaving us</h2>
            </div>
            <div class="html-box-body">
                <p>We would love to have you back soon.</p>
                <p>Miss you.</p>
            </div>
            <div class="html-box-footer">
                <button id="cancelBtn" class="btn cancel-btn">Cancel</button>
                <button id="logoutBtn"  onclick="location.href='logout.php'" class="btn logout-btn">Logout</button>
            </div>
        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script>
        // Get references to the buttons
        const cancelBtn = document.getElementById('cancelBtn');
        const logoutBtn = document.getElementById('logoutBtn');

        // Add click event listeners to the buttons
        cancelBtn.addEventListener('click', function() {
            // Go back to the previous page
            window.history.back();
        });
    </script>

</body>

</html>