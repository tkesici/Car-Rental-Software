<?php 
session_start();
if(isset($_GET['logout'])){
  unset($_SESSION["loggedin"]);
  unset($_SESSION["firstname"]);
  unset($_SESSION["lastname"]);
  unset($_SESSION["id"]);
  unset($_SESSION["email"]);
  unset($_SESSION["phonenumber"]);   
  header("Location: index.php");
  die();
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
  <title>Contact / tkCRS</title>
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
            <li><a href="about.php" class="nav-link px-2 text-white">About</a></li>
            <li><a href="contact.php" class="nav-link px-2 text-warning">Contact</a></li>
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
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="mytransactions.php">My Transactions</a>
      </div>
    </div>
  </div>
<button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
<?php } ?>
    </div>
  </form>
</header>
<?php
$valid = false;
if (!empty($_POST['msg'])) {
  $valid = true;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($valid) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $msg = $_POST['msg'];

           $stmt = $conn->prepare("INSERT INTO `contactform` (`firstname`, `lastname`, `email`, `message`) VALUES (?,?,?,?)");
           $stmt->bind_param("ssss", $firstname, $lastname, $email, $msg);
           $stmt->execute();
           $stmt->close();
           $conn->close();
  }


}
?>
<div class="container">
      <hr>
      <div class="">
          <main>  
            <div class="">
              <div class="">
                <h3 class="">Contact Us</h3>
                <form method="post">
                  <div class="row g-3">
                    <div class="col-sm-6">
                      <label for="firstName" class="form-label">First name</label>
                      <input type="text" class="form-control" name="firstname" placeholder="First name" value="<?php if(isset($_SESSION['loggedin'])) echo $_SESSION['firstname'];?>" required>
                    </div>
        
                    <div class="col-sm-6">
                      <label for="lastName" class="form-label">Last name</label>
                      <input type="text" class="form-control" name="lastname" placeholder="Last name" value="<?php if(isset($_SESSION['loggedin'])) echo $_SESSION['lastname'];?>" required>
                    </div>
      
                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Email address" value="<?php if(isset($_SESSION['loggedin'])) echo $_SESSION['email'];?>">
                    </div>
      
                    <div class="col-12">
                      <label for="email" class="form-label">Message</label>
                      <textarea class="form-control" id="msg" name="msg" cols="30" rows="3" placeholder="Your message..."></textarea>
                    </div>
      
                    </div>
                  </div>
                      <br>
                  <input class="w-100 btn btn-lg btn-light"  type="submit" name="submit" value="Submit"> 
                  <br><hr>
                </form>
              </div>
            </div>
          </main>
          <div class="embed-responsive embed-responsive-21by9">
        <div id="map" class="z-depth-1-half map-container-1">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1194.9051131473077!2d30.65102845725499!3d36.898117804171704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c391db4c3dc15f%3A0x7258add44e8254a5!2zQWtkZW5peiDDnG5pdmVyc2l0ZXNpIEJpbGdpc2F5YXIgTcO8aGVuZGlzbGnEn2kgQsO2bMO8bcO8!5e0!3m2!1sen!2str!4v1649320374195!5m2!1sen!2str"></iframe>
       </div>
      </div>
      </div>
    </div>

    <br>
    <!--Footer-->
  <footer class="text-center text-lg-start" style="background-color:#ffc404">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      ?? 2022 Copyright:
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