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
  $today = date_create()->format('Y-m-d');
  $password = $oldpass = "";
  $password_err = $oldpass_err = "";
?>
<?php 
       if($_SERVER["REQUEST_METHOD"] == "POST"){
    $conn = new mysqli("localhost", "root", "1234", "tkcrs");

    if(empty(trim($_POST["oldpass"]))){
        $oldpass_err = "Please enter your password.";
    } else {
        $oldpass = trim($_POST["oldpass"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    $mail = $_SESSION['email'];
    $id = $_SESSION['id'];
    $sql = 'UPDATE `customer` SET `password` = "' . md5($password) . '" WHERE `customer`.`id` = "' . $id . '" ';
    if(empty($password_err) && empty($oldpass_err)){
        $sql = "SELECT id,`firstname`,lastname,email,`password`,active,phonenumber FROM customer WHERE email='$mail'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
            while ($row = $result->fetch_assoc()) {
                    if ($row['password'] == md5($oldpass)) {
                      $stmt = $conn->prepare('UPDATE `customer` SET `password` = "' . md5($password) . '" WHERE `customer`.`id` = "' . $id . '" ');
                      //$stmt->bind_param("ssssss", $firstname, $lastname, $email, $phonenumber, md5($password), $accountActivity);
                      $stmt->execute();
                      $stmt->close();
                      $conn->close();
                      ?><h3 class="text-success"><?php echo 'Password updated successfully.'; ?></h3><?php
                    } else {
                      ?><h3 class="text-danger"><?php echo 'Invalid password.'; ?></h3><?php
                        $conn->close();
                }
            }
            if (is_resource($conn)) {
              $conn->close();
              header("Location:login.php");
         }   
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Tevfik Kesici">
  <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
  <title>Profile / tkCRS</title>
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
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="mytransactions.php">My Transactions</a>
      </div>
    </div>
  </div>
<button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
<?php } ?>
    </div>
  </form>
</header> <?php
if(isset($_SESSION['loggedin'])) { ?>
<main class="d-flex justify-content-center">
       <form method="post">
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="firstname" value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];?>" disabled><label>Name</label>
          </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="email" value="<?php echo $_SESSION['email'];?>" disabled><label>Email address</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="phonenumber" value="<?php echo $_SESSION['phonenumber'];?>" disabled><label>Phone number</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="password" id="oldpass" name="oldpass"><label>Old password</label>
             <span class="invalid-feedback"><?php echo $oldpass_err; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="password" id="password" name="password" onkeyup=check();><label>New password</label>
             <span class="invalid-feedback"><?php echo $password_err; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="password" id="repassword" name="repassword" onkeyup=check();><label>New password again</label>
           </div>
           <span id='message'></span>
           <div class="checkbox mb-3 text-black-50">
           </div>
           <input class="w-100 btn btn-lg btn-light"  type="submit" name="submit" value="Save"> 
         </form>
       </main>
       <br>
       <?php } ?>
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
<script>
	var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('repassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Passwords match';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Passwords do not match';
  }
}
</script>
  </body>
</html>