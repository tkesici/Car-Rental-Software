<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
 }

	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: dashboard.php");
	}
    $conn = new mysqli("localhost", "root", "1234", "tkcrs");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql1 = "SELECT * FROM booking";
  $customers = $conn->query($sql1);
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tevfik Kesici">
     <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
    <title>Bookings \ tkCRS</title>

    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--Bootstrap JS-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!--Internal CSS-->
    <link href="../css/style.css" rel="stylesheet">

    <!--Internal JS-->
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
      function search(word) {
        word.q.value = "http://www.google.com/search/"+word;
    }
      </script>

</head>

<body class="h-100 text-center text-white bg-dark">

    <!--Header-->
    <main>
  <header class="p-3 bg-warning text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <img style="display: inline;" src="../img/logo/secondarybanner.png" alt="logo" width="120" height="60"/>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
        <li><a href="dashboard.php" class="nav-link px-2 text-dark">Dashboard</a></li>
          <li><a href="vehicles.php" class="nav-link px-2 text-dark">Manage Vehicles</a></li>
          <li><a href="customers.php" class="nav-link px-2 text-dark">Manage Customers</a></li>
          <li><a href="bookings.php" class="nav-link px-2 text-light">Manage Bookings</a></li>
          
        </ul>
        <?php if(isset($_SESSION['admin'])) { ?>
        <div class="text-end">
          <div class="navbar-form navbar-brand">
            <button class="btn btn-light dropdown-toggle" type="button" id="admindropdown" data-toggle="dropdown">
              Welcome, <?php echo $_SESSION['email']; ?>
            </button>
            <button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
          </div>
        </div>
  </header>
</main>
<?php } ?>
    <!--/Header-->
    </div>
  </form>
</header>
<!--Content-->

<?php if(isset($_SESSION['admin'])) {
$sql = 'SELECT *, b.id as bookingid, c.email AS customermail, c.phonenumber AS customerphone, b.active AS activeres
FROM booking AS b
LEFT JOIN customer AS c
ON b.customerid = c.id 
LEFT JOIN vehicle AS v 
ON b.vehicleid = v.id
LEFT JOIN agency AS a
ON v.agency_id = a.id
LEFT JOIN cartype AS ct
ON v.type_id = ct.id;';

$reservations = $conn->query($sql);
?>
<h1 class="text-danger">Inactive Reservations</h1> <?php
while ($info = $reservations->fetch_assoc()) {       
  if($info['activeres'] == 0) {
    echo $info['bookingid']; ?> <br> <?php
    echo $info['customerid']; ?> <br> <?php
    echo $info['vehicleid']; ?> <br> <?php
    echo $info['startdate']; ?> <br> <?php
    echo $info['enddate']; ?> <br> <?php
    echo $info['price']; ?> <br> <?php
    echo $info['firstname']; ?> <br> <?php
    echo $info['lastname']; ?> <br> <?php
    echo $info['customermail']; ?> <br> <?php
    echo $info['customerphone']; ?> <br> <?php
    echo $info['manufacturer']; ?> <br> <?php
    echo $info['model']; ?> <br> <?php
    echo $info['image']; ?> <br> <?php
    echo $info['plate']; ?> <br> <?php
    echo $info['type']; ?> <br> <?php
    echo $info['city']; ?> <br> <?php
    echo $info['email']; ?> <br> <?php
    echo $info['phonenumber']; ?> <br> <?php
    }  
  } 
?>
<?php $reservations = $conn->query($sql); ?>
<h1 class="text-success">Active Reservations</h1> <?php
 while ($info = $reservations->fetch_assoc()) {       
   if($info['activeres'] == 1) {
     echo 'Active Reservations'; ?> <br> <?php
     echo $info['bookingid']; ?> <br> <?php
     echo $info['customerid']; ?> <br> <?php
     echo $info['vehicleid']; ?> <br> <?php
     echo $info['startdate']; ?> <br> <?php
     echo $info['enddate']; ?> <br> <?php
     echo $info['price']; ?> <br> <?php
     echo $info['firstname']; ?> <br> <?php
     echo $info['lastname']; ?> <br> <?php
     echo $info['customermail']; ?> <br> <?php
     echo $info['customerphone']; ?> <br> <?php
     echo $info['manufacturer']; ?> <br> <?php
     echo $info['model']; ?> <br> <?php
     echo $info['image']; ?> <br> <?php
     echo $info['plate']; ?> <br> <?php
     echo $info['type']; ?> <br> <?php
     echo $info['city']; ?> <br> <?php
     echo $info['email']; ?> <br> <?php
     echo $info['phonenumber']; ?> <br> <?php
  }
} 
} 
?>
    <br>      
<div class="modal fade" id="specsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black-50" id="specs">Specifications</h5>
      </div>
      <div class="modal-body">
        <img class="img-fluid" src="../img/specs.png" alt="Specifications">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


    <!--Footer-->
  <footer class="text-center text-lg-start" style="background-color:#ffc404">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-primary" href="index.html">tkCRS.com</a>
    </div>
  </footer>
    <!--/Footer-->
  
<!--External Javascript-->
  <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>

  </body>
</html>
