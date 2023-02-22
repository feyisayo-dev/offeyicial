<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=
      , initial-scale=1.0">
    <title>HOME</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css" integrity="sha384-oi8o31xSQq8S0RpBcbviIyZF66lZF79dtW1nUSt2FU5ZBD3P2fI9X5Rzf5G1YPa" crossorigin="anonymous">


  <link rel="icon" href="img/offeyicial.jpeg" type="image/jpeg" sizes="32x32" />

    <style>
        * {
            font-family: montserrat;
        }
        
        body {
            background: f1fbff;
        }
        
        .section-padding {
            padding: 100px 0;
        }
        
        .carousel-item {
            height: 100vh;
            min-height: 300px;
        }
        
        .carousel-caption {
            bottom: 220px;
            z-index: 2;
        }
        
        .carousel-caption h5 {
            font-size: 45px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 25px;
        }
        
        .carousel-caption p {
            width: 60%;
            margin: auto;
            font-size: 18px;
            line-height: 1.2;
        }
        
        .carousel-inner::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
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
        
        .w-100 {
            height: 100vh;
        }
        
        .services .card-body i {
            font-size: 50px;
        }
        /*--- media Query ---*/
        
        @media only screen and (min-width:768px) and (max-width:991px) {
            .carousel-caption {
                bottom: 370px;
            }
            .carousel-caption p {
                width: 100%;
            }
        }
        
        @media only screen and (max-width:767px) {
            .navbar-nav {
                text-align: center;
            }
            .carousel-caption {
                bottom: 125px;
            }
            .carousel-caption h5 {
                font-size: 17px;
            }
            .carousel-caption a {
                padding: 10px 15px;
            }
            .carousel-caption p {
                width: 100%;
                line-height: 1.6;
                font-size: 12px;
            }
        }
        /* .container{
          height: 4ev;
          border-radius: 10px;
        } */
    </style>
</head>

<body>
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

    <div id="mycarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mycarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#mycarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#mycarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/7.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <h5>WELCOME TO OFFEYICIAL</h5>
                    <p>where you can meet up with anyone anywhere at anytime.</p>
                    <p><a href="reg.php" class="btn btn-success mt-3">Register Now</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/9.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <h5>YOU ARE WELCOME HERE</h5>
                    <p>blah blah blah blah</p>
                    <p><a href="reg.php" class="btn btn-success mt-3">Register Now</a></p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/8.jpeg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                    <h5>blah blah blah blah</h5>
                    <p>blah blah blah blah</p>
                    <p><a href="reg.php" class="btn btn-success mt-3">Register Now</a></p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mycarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mycarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden"></span>
        </button>
    </div>

    <!--about section-->

    <section id="about" class="about section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="images/small_lion.jpg" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text">
                        <h2>We provide Best Quality Programing <br> Service Ever</h2>
                        <p>blah blah blah blah</p>
                        <a href="#" class="btn btn-success">Read More</a>
                    </div>
                </div>
            </div>
        </div>
<br>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text">
                        <h2>We provide Best Quality Programing <br> Service Ever</h2>
                        <p>blah blah blah blah</p>
                        <a href="#" class="btn btn-success">Read More</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="images/small_lion2.jpg" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
<br>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="images/small_lion3.jpg" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text">
                        <h2>We provide Best Quality Programing <br> Service Ever</h2>
                        <p>blah blah blah blah</p>
                        <a href="#" class="btn btn-success">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>


    <!--services-->


    <section id="Service" class="services section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <h2>Our Services</h2>
                        <p>Virtually talking to everyone you know without living the comfort of your house. <br> Thank you, Welcome.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-light text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-subtract"></i>
                            <h3 class="card-title">What we assure</h3>
                            <p class="text-success">End to End encryption<br>Personalized layout<br></p>
                            <button class="btn btn-success text-light">Read More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script src="js/bootstrap.bundle.min.js"></script>