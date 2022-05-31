<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
 }
if(isset($_GET['adminlogout'])){
		unset($_SESSION["admin"]);
    unset($_SESSION["adminfirstname"]);
    unset($_SESSION["adminlastname"]);
    unset($_SESSION["adminid"]);
    unset($_SESSION["adminmeail"]);
		header("Location: adminlogin.php");
}
$conn = new mysqli("localhost", "root", "1234", "tkcrs");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$today = date_create()->format('Y-m-d');
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tevfik Kesici">
     <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
    <title>Create Booking \ tkCRS</title>

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
          <li><a href="agencies.php" class="nav-link px-2 text-dark">Manage Agencies</a></li>
          <li><a href="customers.php" class="nav-link px-2 text-dark">Manage Customers</a></li>
          <li><a href="bookings.php" class="nav-link px-2 text-dark">Manage Bookings</a></li>
          <li><a href="createbooking.php" class="nav-link px-2 text-light">Create Booking</a></li>
          
        </ul>
        <?php if(isset($_SESSION['admin'])) { ?>
        <div class="text-end">
          <div class="navbar-form navbar-brand">
            <button class="btn btn-light dropdown-toggle" type="button" id="admindropdown" data-toggle="dropdown">
              Welcome, <?php echo $_SESSION['adminemail']; ?>
            </button>
            <button type="button" class="btn btn-danger me-2" onclick=" relocate('dashboard.php?adminlogout=true')">Log out</button>
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
    $valid = true;
    $active = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['customerid'])) {
        $customerid = $_POST['customerid'];
    } else { $valid = false; }
    if(!empty($_POST['vehicleid'])) {
        $vehicleid = $_POST['vehicleid'];
    } else { $valid = false; }
    if(!empty($_POST['startdate'])) {
        $startdate = $_POST['startdate'];
    } else { $valid = false; }
    if(!empty($_POST['enddate'])) {
        $enddate = $_POST['enddate'];
    } else { $valid = false; }
    if(!empty($_POST['price'])) {
        $price = $_POST['price'];
    } else { $valid = false; }
    
    if($valid) {
        $stmt = $conn->prepare("INSERT INTO `booking` (`customerid`, `vehicleid`, `startdate`, `enddate`, `price`, `active`) VALUES (?,?,?,?,?,?);");
        $stmt->bind_param("iisssi",$customerid,$vehicleid,$startdate,$enddate,$price,$active);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        ?><?php echo '<h3 class="text-success">Booking successfully created.</h3>'?> <?php
    }

 }
}
?>
<br>
<main class="col-md-4 mx-auto">
       <form method="post">
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="customerid"><label>Customer ID</label>
          </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="vehicleid"><label>Vehicle ID</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="startdate"><label>Start Date</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="enddate"><label>End Date</label>
            </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="price"><label>Price</label>
           </div>
           <br>
           <div class="checkbox mb-3 text-black-50">
           </div>
           <input class="w-100 btn btn-lg btn-success"  type="submit" name="submit" value="Create Booking"> 
         </form>
       </main>
<br>
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
