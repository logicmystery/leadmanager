<?php
include "session.php";
?>
<html>

<head>
  <!-- Latest compiled and minified CSS -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <style>
    html {
      font-size: 100%;
    }
  </style>

  <title>LEARNING CRM</title>
</head>

<body>

  <nav class="navbar navbar-expand-md bg-dark navbar-dark ">
    <!-- Brand -->
    <a class="navbar-brand" href="customer.php"><img src="banerjz.jpeg" width="100" height="40" alt="logo"></a>

    <!-- Toggler/collapsibe Button -->
    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>-->

    <!-- Navbar links -->
    <!--<div class="collapse navbar-collapse" id="collapsibleNavbar">-->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#"><?php
                                      if ($_SESSION["name"]) {
                                      ?>
            Welcome <?php echo $_SESSION["name"]; ?>
          <?php
                                      } else echo "<h1>Please login first .</h1>";
          ?>
        </a>
      </li>
      <li>
        <a href="logout.php" title="Logout">
          <button class="btn btn-sm btn-success navbar-btn text-white">
            logout
          </button>
        </a>

      </li>

    </ul>
    <!--</div>-->

  </nav>