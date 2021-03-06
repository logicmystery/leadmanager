<?php
session_start();
include "db.php";
if (isset($_SESSION["id"])) {
  $myid = $_SESSION["id"];
  if ($myid > 0) {
    header("Location:customer.php");
    exit();
  }
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  if (!empty($password) && !empty($username)) {
    $sql = "SELECT * FROM users where users_email = '" . $username . "' AND users_password = '" . $password . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      //print_r($row);
      $_SESSION["id"] = $row['users_id'];
      $_SESSION["name"] = $row['users_name'];
      if ($row["users_email"] == $username && $row["users_password"] == $password) {
        header("Location:customer.php");
        exit();
      }
    } else {
      $_SESSION["msg"] = "Invalid username and password!";
    }
  }
}
?>
<html>

<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    html {
      font-size: 100%;
    }

    :root {
      --input-padding-x: 1.5rem;
      --input-padding-y: .75rem;
    }

    body {
      background: #007bff;
      background: linear-gradient(to right, #0062E6, #33AEFF);
    }

    .card-signin {
      border: 0;
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
    }

    .card-signin .card-title {
      margin-bottom: 2rem;
      font-weight: 300;
      font-size: 2rem;
    }

    .card-signin .card-body {
      padding: 2rem;
    }

    .form-signin {
      width: 100%;
    }

    .form-signin .btn {
      font-size: 80%;
      border-radius: 5rem;
      letter-spacing: .1rem;
      font-weight: bold;
      padding: 0.3rem;
      transition: all 0.2s;
      height: 30px;

    }

    /*.btn-x{
margin: 0 auto;
    vertical-align: middle;

}*/

    .form-label-group {
      position: relative;
      margin-bottom: 1rem;
    }

    .form-label-group input {
      height: auto;
      border-radius: 2rem;
    }

    .form-label-group>input,
    .form-label-group>label {
      padding: var(--input-padding-y) var(--input-padding-x);
    }

    .form-label-group>label {
      position: absolute;
      top: 0;
      left: 0;
      display: block;
      width: 100%;
      margin-bottom: 0;
      /* Override default `<label>` margin */
      line-height: 1.5;
      color: #495057;
      border: 1px solid transparent;
      border-radius: .25rem;
      transition: all .1s ease-in-out;
    }

    .form-label-group input::-webkit-input-placeholder {
      color: transparent;
    }

    .form-label-group input:-ms-input-placeholder {
      color: transparent;
    }

    .form-label-group input::-ms-input-placeholder {
      color: transparent;
    }

    .form-label-group input::-moz-placeholder {
      color: transparent;
    }

    .form-label-group input::placeholder {
      color: transparent;
    }

    .form-label-group input:not(:placeholder-shown) {
      padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
      padding-bottom: calc(var(--input-padding-y) / 3);
    }

    .form-label-group input:not(:placeholder-shown)~label {
      padding-top: calc(var(--input-padding-y) / 3);
      padding-bottom: calc(var(--input-padding-y) / 3);
      font-size: 12px;
      color: #777;
    }

    .btn-google {
      color: white;
      background-color: #ea4335;
    }

    .btn-facebook {
      color: white;
      background-color: #3b5998;
    }

    /* Fallback for Edge
-------------------------------------------------- */

    @supports (-ms-ime-align: auto) {
      .form-label-group>label {
        display: none;
      }

      .form-label-group input::-ms-input-placeholder {
        color: #777;
      }
    }

    /* Fallback for IE
-------------------------------------------------- */

    @media all and (-ms-high-contrast: none),
    (-ms-high-contrast: active) {
      .form-label-group>label {
        display: none;
      }

      .form-label-group input:-ms-input-placeholder {
        color: #777;
      }
    }
  </style>

  <head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-5 mx-auto">
          <div class="card card-signin my-5 mx-auto">
            <div class="card-body">
              <div style="text-align:center"><img src="banerjz.jpeg" width="100" height="40" /></div>
              <h5 class="card-title text-center" style="margin-bottom:0px;">Sign In</h5>
              <p style="color:red; text-align:center;"><?php if(isset($_SESSION["msg"])){echo $_SESSION["msg"]; }?></p>
              <form class="form-signin" action="" method="post">
                <div class="form-label-group">
                  <input type="email" id="inputEmail" class="form-control" name="username" placeholder="Email address" required autofocus>
                  <label for="inputEmail">Email address</label>
                </div>

                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
                  <label for="inputPassword">Password</label>
                </div>

                <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Remember password</label>
                </div>
                <button class="btn btn-lg btn-primary btn-x btn-block text-uppercase text-center" type="submit" value="login">Sign in</button>
                <span class="text-dark" style="width:48%; text-align:center;text-color:black;  display: inline-block;"><a class="small-text text-dark text-center" href="#">Forgot password?</a></span>
                <!-- <hr class="my-2">
              <button class="btn btn-sm btn-google btn-block  btn-x text-uppercase" type="submit"><i class="fab fa-google mr-2"></i> Sign in with Google</button>
              <button class="btn btn-lg btn-facebook btn-block btn-x text-uppercase" type="submit"><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button>-->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

</html>