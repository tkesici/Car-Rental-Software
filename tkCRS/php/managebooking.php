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
  $today = date_create()->format('Y-m-d');
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tevfik Kesici">
     <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
    <title>Manage Booking \ tkCRS</title>

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
<?php if(isset($_SESSION['admin'])) { ?>
 
  <?php
$valid = true;
       if($_SERVER["REQUEST_METHOD"] == "POST") {
        $booking      = $_GET['booking'];
        $bookingid    = $_POST['bookingid'];
        $startdate    = $_POST['startdate'];
        $enddate      = $_POST['enddate'];
        $price        = $_POST['totalprice'];
        $vehicleid    = $_POST['vehicleid'];
        $customerid   = $_POST['customerid'];
        $agencyid     = $_POST['agencyid'];
        if($valid){
            $updatebookingid = $conn->prepare('UPDATE `booking` SET `id` = "' . $bookingid . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            $updatestart = $conn->prepare('UPDATE `booking` SET `startdate` = "' . $startdate . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            $updateend = $conn->prepare('UPDATE `booking` SET `enddate` = "' . $enddate . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            $updateprice = $conn->prepare('UPDATE `booking` SET `price` = "' . $price . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            $updatevehicle = $conn->prepare('UPDATE `booking` SET `vehicleid` = "' . $vehicleid . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            $updatecustomer = $conn->prepare('UPDATE `booking` SET `customerid` = "' . $customerid . '" WHERE `booking`.`id` = "' . $booking . '" ;');
           // $updateagency = $conn->prepare('UPDATE `booking` SET `id` = "' . $agencyid . '" WHERE `booking`.`id` = "' . $booking . '" ;');
            
            $updatebookingid->execute();
            $updatestart->execute();
            $updateend->execute();
            $updateprice->execute();
            $updatevehicle->execute();
            $updatecustomer->execute();
           // $updateagency->execute();
             header( "refresh:0;url=managebooking.php?booking=$bookingid" );
            ?><h3 class="text-success"><?php echo 'Records updated successfully.'; ?></h3><?php
        }
    }

$bookingid = $_GET['booking'];
$sql = 'SELECT *, v.id AS vehicleid, c.id AS customerid, c.email AS customermail, c.phonenumber AS customerphone, b.price AS totalprice, b.active AS `status`, ct.type AS cartype
FROM booking AS b
LEFT JOIN customer AS c
ON c.id = b.customerid
LEFT JOIN vehicle AS v
ON v.id = b.vehicleid
LEFT JOIN agency AS a
ON a.id = v.agency_id
LEFT JOIN cartype AS ct
ON v.type_id = ct.id
WHERE b.id = "' . $bookingid . '" ';
$query = $conn->query($sql); ?>
<br>
 <?php 
      while ($vehicle = $query->fetch_assoc()) { ?><?php
      echo "<img class='img-thumbnail' src=". $vehicle['image'] ." alt='Image'>"; ?>
     <hr>
      <main class="d-flex justify-content-center">
       <form method="post">
           <div class="form-floating text-black-50">
             <input class="form-control<?php if($vehicle['status']) { echo ' btn-success';} else { echo ' btn-danger';};
                 ?>" type="text" name="status" value="<?php if($vehicle['status']) { echo 'Active';} else { echo 'Inactive';};
                 ?>" disabled><label>Status</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control btn-primary" type="text" name="bookingid" value="<?php echo $_GET['booking'];?>"><label>Booking ID</label>
          </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="startdate" value="<?php echo $vehicle['startdate'];?>"><label>Start Date</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="enddate" value="<?php echo $vehicle['enddate'];?>"><label>End Date</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="totalprice" value="<?php echo $vehicle['totalprice'];?>"><label>Total Price</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control btn-primary" type="text" name="vehicleid" value="<?php echo $vehicle['vehicleid'];?>"><label>Vehicle ID</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="manufacturer" value="<?php echo $vehicle['manufacturer'];?>" disabled><label>Manufacturer</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="model" value="<?php echo $vehicle['model'];?>" disabled><label>Model</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="cartype" value="<?php echo $vehicle['cartype'];?>" disabled><label>Car Type</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="plate" value="<?php echo $vehicle['plate'];?>" disabled><label>Car Plate</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control btn-primary" type="text" name="customerid" value="<?php echo $vehicle['customerid'];?>"><label>Customer ID</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="name" value="<?php echo $vehicle['firstname'] . ' ' . $vehicle['lastname'];?>" disabled><label>Customer Name</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="customermail" value="<?php echo $vehicle['customermail'];?>" disabled><label>Customer E-mail</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="customerphone" value="<?php echo $vehicle['customerphone'];?>" disabled><label>Customer phone number</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control btn-primary" type="text" name="agencyid" value="<?php echo $vehicle['agency_id'];?>"><label>Agency ID</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="city" value="<?php echo $vehicle['city'];?>" disabled><label>Location</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="agencymail" value="<?php echo $vehicle['email'];?>" disabled><label>Agency E-mail</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="agencyphone" value="<?php echo $vehicle['phonenumber'];?>" disabled><label>Agency phone number</label>
           </div>
           <br>
           <div class="checkbox mb-3 text-black-50">
           </div>
           <input class="w-100 btn btn-lg btn-light"  type="submit" name="submit" value="Save">
           <br><br>
           <?php echo "<a class='btn btn-sm btn-success' href=\"activatebooking.php?booking=".$_GET['booking']."\">Activate Booking</a>";?>
           <?php echo "<a class='btn btn-sm btn-danger' href=\"deactivatebooking.php?booking=".$_GET['booking']."\">Deactivate Booking</a>";?>
         </form>
       </main>
<?php } }?>
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
