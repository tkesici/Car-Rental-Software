<?php 
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: index.php");
 }
 if(isset($_SESSION['loggedin'])) {
  header("Location: index.php");
}

	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
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
    <title>Dashboard \ tkCRS</title>

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
          <li><a href="dashboard.php" class="nav-link px-2 text-light">Dashboard</a></li>
          <li><a href="vehicles.php" class="nav-link px-2 text-dark">Manage Vehicles</a></li>
          <li><a href="customers.php" class="nav-link px-2 text-dark">Manage Customers</a></li>
          <li><a href="bookings.php" class="nav-link px-2 text-dark">Manage Bookings</a></li>
          <li><a href="createbooking.php" class="nav-link px-2 text-dark">Create Booking</a></li>
          
        </ul>
        <?php if(isset($_SESSION['admin'])) { ?>
        <div class="text-end">
          <div class="navbar-form navbar-brand">
            <button class="btn btn-light dropdown-toggle" type="button" id="admindropdown" data-toggle="dropdown">
              Welcome, <?php echo $_SESSION['adminemail']; ?>
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
  $sql1 = 'SELECT SUM(price) AS total FROM booking';
  $sql2 = 'SELECT COUNT(*) AS totalcustomers FROM customer';
  $sql3 = 'SELECT COUNT(*) AS activeorders FROM booking b WHERE b.active = 1';
  $sql4 = 'SELECT COUNT(*) AS inactiveorders FROM booking b WHERE b.active = 0';
  $sql5 = 'SELECT COUNT(*) AS totalvehicles FROM vehicle';

  $revenue = $conn->query($sql1);
  $customers = $conn->query($sql2);
  $activeorders = $conn->query($sql3);
  $inactiveorders = $conn->query($sql4);
  $vehicles = $conn->query($sql5); ?>
  <div class="card-group">
  <?php while ($info = $revenue->fetch_assoc()) { ?>
  <div class="card bg-success">
    <img class="img-fluid" src="https://miro.medium.com/max/1400/0*elFqAeuyXXRbbXOC.png">
    <div class="card-body">
      <h5 class="card-title">Revenue</h5>
      <h1 class="card-title">€<?php echo $info['total']; ?></h1>
      <p class="card-text">Total money earned by the all agencies over all time.</p>
    </div>
  </div>
  <?php } ?>
  <?php while ($info = $customers->fetch_assoc()) { ?>
  <div class="card bg-primary">
    <img class="img-fluid" src="https://www.kindpng.com/picc/m/74-743103_listening-to-customers-png-happy-customer-png-transparent.png" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Our Family</h5>
      <h1 class="card-title"><?php echo $info['totalcustomers']; ?> Users</h1>
      <p class="card-text">We are growing up with you.</p>
    </div>
  </div>
  <?php } ?>
  <?php while ($info = $vehicles->fetch_assoc()) { ?>
  <div class="card bg-danger">
    <img class="imb-fluid" src="https://t4.ftcdn.net/jpg/01/14/62/49/360_F_114624946_hCCOPyY0CE7Nt48z72d7AIh3ie8Txs5V.jpg" alt="Card image cap">
    <div class="card-body">
      <h5 class="card-title">Our Fleet</h5>
      <h1 class="card-title"><?php echo $info['totalvehicles']; ?> Vehicles</h1>
      <p class="card-text">We strive to achieve more every day.</p>
    </div>
  </div>
  </div>
<?php } ?>
<?php while ($info = $activeorders->fetch_assoc()) { ?>
  <div class="card bg-dark">
    <div class="card-body">
      <h5 class="card-title">Active Bookings</h5>
      <h1 class="card-title text-success"><?php echo $info['activeorders']; ?></h1>
      <p class="card-text"></p>
    </div>
  </div>
  <?php } ?>
  <?php while ($info = $inactiveorders->fetch_assoc()) { ?>
  <div class="card bg-dark">
    <div class="card-body">
      <h5 class="card-title">Inactive Bookings</h5>
      <h1 class="card-title text-danger"><?php echo $info['inactiveorders']; ?></h1>
      <p class="card-text"></p>
    </div>
  </div>
  <?php } ?>
<?php } ?>
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
