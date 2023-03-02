<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
<link rel="icon" href="img\offeyicial.png" type="image/jpeg" sizes="32x32" />

    <title>Donate</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css" />

    <!-- Custom styles for this template -->
    <link href="css/donate.css" rel="stylesheet" />

    <!-- Other CSS files -->
    <link href="css/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/font/bootstrap-icons.css" />
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="css/remixicon/remixicon.css" rel="stylesheet" />
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet" />
  </head>

  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Donate</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Donate</a>
      </li>
    </ul>
  </div>

  <style>
    .navbar {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      font-size: 18px;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 24px;
    }

    .navbar-nav .nav-item .nav-link {
      color: #333;
      font-weight: 500;
      margin-right: 20px;
    }

    .navbar-nav .nav-item .nav-link:hover {
      color: #7fad39;
    }

    .navbar-nav .nav-item.active .nav-link {
      color: #7fad39;
      font-weight: 600;
    }

    .navbar-toggler {
      border: none;
      background-color: #fff;
    }

    .navbar-toggler:focus {
      outline: none;
    }

    .navbar-toggler-icon {
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"><path stroke="#333" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/></svg>');
    }
  </style>
</nav>


    <div class="container">
      <div class="row mt-5">
        <div class="col-md-12">
          <div class="donate-progress">
            <div class="progress">
              <div
                class="progress-bar"
                role="progressbar"
                style="width: 0%"
                aria-valuenow="0"
                aria-valuemin="0"
                aria-valuemax="100"
              ></div>
            </div>
            <div class="donate-progress-text">
              <span>0%</span>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-md-12">
          <div class="donate-stats text-center">
            <p class="mb-2">Amount Donated So Far</p>
            <h3 class="mb-0">$0</h3>
          </div>
        </div>
      </div>
      <div class="row mt-5">
  <div class="col-md-12">
    <h3 class="text-center">Choose a donation amount</h3>
    <div class="donate-amount text-center mt-4">
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $1
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $5
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $10
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $20
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $50
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $100
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $500
      </button>
      <button type="button" class="btn btn-lg btn-outline-primary mr-2">
        $1000
      </button>
    </div>
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="donate-amount">
          <form>
            <div class="form-group">
              <label for="amount">Other Amount</label>
              <input type="text" class="form-control" id="amount" placeholder="Enter amount">
            </div>
            <button id="submit" type="submit" class="btn btn-primary btn-block">Donate Now</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

            <!-- <div class="row mt-5">
                <div class="col-md-12">
                    <div class="donate-stats text-center">
                        <p class="mb-2">Amount Donated So Far</p>
                        <h3 class="mb-0">$50,000</h3>
                    </div>
                </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </body>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>  
  <script>
    $('#submit').click(function(){
        
    })
  </script>
</html>

