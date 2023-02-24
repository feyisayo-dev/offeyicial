<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contact Us - Offeyicial</title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css\font\bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        
        .contact-section {
            display: flex;
            justify-content: space-between;
            padding: 30px;
        }
        
        .contact-form {
            width: 100%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 10px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        
        label {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        input[type="text"],
        input[type="email"],
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            resize: none;
            width: 100%;
            box-sizing: border-box;
        }
        
        textarea {
            height: 150px;
        }
        
        button[type="submit"] {
            background-color: #37a000;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }
        
        .contact-info {
            width: 50%;
            /* align-item: right; */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 10px;
        }
        
        .company-info {
            width: 50%;
            /* align-item: right; */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 10px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        h3 {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        p {
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 0;
        }
        
        .navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }
        
        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }
        
        .columns {
            float: left;
            width: 33.3%;
            padding: 8px;
            box-shadow: 2px 2px 2px 2px #1024;
        }
        
        .price {
            list-style-type: none;
            border: 1px solid #eee;
            margin: 0;
            padding: 0;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }
        
        .price:hover {
            box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2)
        }
        
        .price .header {
            background-color: #111;
            color: white;
            font-size: 25px;
        }
        
        .price li {
            border-bottom: 1px solid #eee;
            padding: 20px;
            text-align: center;
        }
        
        .price .grey {
            background-color: #eee;
            font-size: 20px;
        }
        
        .button {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 10px 25px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
        }
        
        @media only screen and (max-width: 600px) {
            .columns {
                width: 100%;
            }
        }
                
        p {
            font-size: 30px;
        }
        
        .profile_img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 10px auto;
            border: 10px solid #ccc;
            border-radius: 50%;
            align-items: center;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reg.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                </li>

        </div>
    </nav>

    <!-- Contact Us Form -->
    <section class="contact-form">
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="board">
                        <h2 style="text-align:center">Meet the board</h2>
                        <div class="columns">
                            <ul class="price">
                                <img class="profile_img" src="img/21.jpeg" alt="">
                                <li class="header">Offeyicial</li>
                                <li class="grey">Name</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li class="grey">
                                    <a href="https://www.instagram.com/offeyicial" class="button">Meet</a>
                                </li>
                            </ul>
                        </div>

                        <div class="columns">
                            <ul class="price">
                                <img class="profile_img" src="img/17.jpeg" alt="">
                                <li class="header" style="background-color:#04AA6D">GOD</li>
                                <li class="grey">Name</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li class="grey">
                                    <a href="https://www.facebook.com/offeyicial" class="button">Meet</a>
                                </li>
                            </ul>
                        </div>

                        <div class="columns">
                            <ul class="price">
                                <img class="profile_img" src="img/23.jpeg" alt="">
                                <li class="header">HS</li>
                                <li class="grey">Name</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li>#</li>
                                <li class="grey">
                                    <a href="https://www.twitter.com/offeyicial" class="button">Meet</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2>Contact us</h2>
                    <form>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="row my-5">


    </section>
    <div class="row">
        <!-- About the Company -->
        <div class="company-info">
            <div class="left-section">
                <h2 class="text-success">About the Company</h2>
                <p>Add information about your company here</p>
            </div>
            <div class="right-section">
                <h2 class="text-success">Location</h2>
                <p>Add your location information here</p>
            </div>
        </div>
        <!-- Contact Information -->
        <section class="contact-info">
            <h2 class="text-success">Contact Information</h2>
            <p>Information and Sales: offeyicial@offeyicial.com</p>
            <p>Support: support@offeyicial.com</p>
        </section>


        </section>
    </div>
</body>

</html>