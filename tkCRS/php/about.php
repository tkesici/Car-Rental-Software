<?php 
session_start();
	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}
    $conn = new mysqli("localhost", "root", "1234", "tkcrs");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql1 = "SELECT * FROM manufacturer";
  $getAllVehicles = $conn->query($sql1);
  $today = date_create()->format('Y-m-d');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Tevfik Kesici">
  <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
  <title>About / tkCRS</title>
  <!--CSS-->
<style>
  .img-desc {
  position: relative;
  display: inline-block;
}

  .img-desc span {
  opacity: 0;
  margin: 0 10px;
  transition: opacity 0.4s;
  position: absolute;
  pointer-events:none;
  white-space: nowrap;
  
  background-color: #000;
  border-radius: 3px;
  padding: 2px 4px;
  color: #FFF;
  font-family: sans-serif;
  font-size: 12px;
}

  .img-desc:hover > span {
  opacity: 1;
}     
</style>
  <!--Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" 
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" 
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head>

<body class="h-100 text-center text-white bg-dark" id="top">
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <img style="display: inline;" src="../img/logo/banner.png" alt="logo" width="120" height="60"/>
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
            <li><a href="hire.php" class="nav-link px-2 text-white">Hire</a></li>
            <li><a href="dealers.php" class="nav-link px-2 text-white">Dealers</a></li>
            <li><a href="about.php" class="nav-link px-2 text-warning">About</a></li>
            <li><a href="contact.php" class="nav-link px-2 text-white">Contact</a></li>
          </ul>
          <form class="navbar-form navbar-brand" type="GET">
            <div class="input-group"> 
<?php if(!isset($_SESSION['loggedin'])) { ?>
 <div class="text-end">
 <button type="button" class="btn btn-outline-light me-2" onclick="window.location='login.php';">Login</button>
 <button type="button" class="btn btn-outline-warning" onclick="window.location='register.php';">Create Account</button>
 </div>
<?php } else { ?>
  <div class="text-end">
    <div class="navbar-form navbar-brand">
      <button class="btn btn-light dropdown-toggle" type="button" id="memberdropdown" data-toggle="dropdown">
<?php echo 'Welcome, ' . $_SESSION['email']; ?>
  </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#">Profile</a>
        <a class="dropdown-item" href="#">My Transactions</a>
        <a class="dropdown-item" href="#">Settings</a>
      </div>
    </div>
  </div>
<button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
<?php } ?>
    </div>
  </form>
</header>
<main>
    <br>
      <div class="container-sm">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">We are working.<span class="text-muted"> With all of them.</span></h2>
          <p class="lead">The car rental shortage is America's number-one travel problem of 2021. This summer, more people will have to make a difficult choice between car-sharing, relying on mass transportation or paying hundreds of dollars per day for a rental car if they can find one!</p>
        </div>
        <div class="col-md-5">
          <img src="../img/wallpapers/wallpaper7.jpg" width="90%" height="80%" role="img" class="img-fluid" alt="Wallpaper1">

        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 order-md-2">
          <h2 class="featurette-heading">Need a car right now? <span class="text-muted"> Just worry about choosing one.</span></h2>
          <p class="lead">You can even leave the booking until (almost) the last minute. If you book by noon, your car can be delivered to your door on the very same day. How much does it all cost? the service is free of charge. Same day delivery is subject to availability and you will be notified if delivery is unavailable.</p>
        </div>
        <div class="col-md-5 order-md-1">
          <img src="../img/wallpapers/wallpaper8.jpg" width="90%" height="90%" role="img" class="img-fluid" alt="Wallpaper2">

        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">We are all working for you. <span class="text-muted">Checkmate.</span></h2>
          <p class="lead">The way that people perceive their work can be fluid, but so too is their sense of purpose. In fact, it’s not unlikely that what someone finds purposeful today won’t be entirely different a year down the road—and that’s all right. “When you’re in your 20s, what drives you and gives you purpose may be very different than when you’re in your 40s and 50s,” Jimenez says. </p>
        </div>
        <div class="col-md-5">
          <img src="../img/wallpapers/wallpaper9.jpg" width="800" height="800" role="img" class="img-fluid" alt="Wallpaper4">
        </div>
      </div>
      <br>

    </div>
  </main>
    <!--Footer-->
  <footer class="text-center text-lg-start" style="background-color:#ffc404">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-primary" href="index.php">tkCRS.com</a>
    </div>
  </footer>
<!--Javascript-->
<script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
        $(function() {
            $('#datepicker2').datepicker();
        });
</script>
<script>
      function relocate(text) {
       location.href =text;
    }

      function over(id) {
       id.class = "nav-link px-2 text-secondary";
    }

      function out(id) {
        if (!(id.class = "nav-link px-2 text-warning")) {
           id.class = "nav-link px-2 text-white";
         }
    }

    function imgHover(obj, event) {
  let span = obj.querySelector('span');
  span.style.left = event.offsetX + 'px';
  span.style.top = event.offsetY + 'px';
}
</script>
  </body>
</html>