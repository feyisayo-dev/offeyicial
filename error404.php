<?php
// $pageNotFound = true; // Replace this with your own logic to determine if the page is not found
// if ($pageNotFound) {
//   header("Location: error404.php");
//   exit();
// }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Error 404 - Page Not Found</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f2f2f2;
    }

    svg {
      font-family: "Modern-Age";
      width: 100%;
      height: 100%;
    }

    svg text {
      animation: stroke 5s infinite alternate;
      stroke-width: 2;
      stroke: #1DA035;
      margin-top: 0;
      margin-bottom: 20px;
      font-size: 4rem;
      text-align: center;
    }

    @keyframes stroke {
      0% {
        fill: rgba(35, 204, 67, 0);
        stroke: rgba(29, 160, 53, 1);
        stroke-dashoffset: 25%;
        stroke-dasharray: 0 50%;
        stroke-width: 2;
      }

      70% {
        fill: rgba(35, 204, 67, 0);
        stroke: rgba(29, 160, 53, 1);
      }

      80% {
        fill: rgba(35, 204, 67, 0);
        stroke: rgba(29, 160, 53, 1);
        stroke-width: 3;
      }

      100% {
        fill: rgba(35, 204, 67, 1);
        stroke: rgba(29, 160, 53, 0);
        stroke-dashoffset: -25%;
        stroke-dasharray: 50% 0;
        stroke-width: 0;
      }
    }

    .wrapper {
      width: 100%;
      background-color: transparent;
    }

    @font-face {
      font-family: 'Modern-Age';
      src: url('fonts/Modern-Age.ttf');
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <svg>
      <text x="50%" y="50%" dy=".35em" text-anchor="middle">
        Error 404 - Page Not Found
      </text>
    </svg>
  </div>
</body>
</html>
