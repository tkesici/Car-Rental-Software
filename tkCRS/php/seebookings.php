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
    <title>See Bookings \ tkCRS</title>

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
$sql1 = 'SELECT *, b.id as bookingid, c.email AS customermail, c.phonenumber AS customerphone
FROM booking AS b
LEFT JOIN customer AS c
ON b.customerid = c.id 
LEFT JOIN vehicle AS v 
ON b.vehicleid = v.id
LEFT JOIN agency AS a
ON v.agency_id = a.id
LEFT JOIN cartype AS ct
ON v.type_id = ct.id
WHERE b.active = 1 AND b.vehicleid = "' . $_GET['car'] . '" ';

$sql2 = 'SELECT *, b.id AS bookingid, c.email AS customermail, c.phonenumber AS customerphone
FROM booking AS b
LEFT JOIN customer AS c
ON b.customerid = c.id 
LEFT JOIN vehicle AS v 
ON b.vehicleid = v.id
LEFT JOIN agency AS a
ON v.agency_id = a.id
LEFT JOIN cartype AS ct
ON v.type_id = ct.id
WHERE b.active = 0 AND b.vehicleid = "' . $_GET['car'] . '" ';

$sql3 = 'SELECT *, b.id AS bookingid, c.email AS customermail, c.phonenumber AS customerphone
FROM booking AS b
LEFT JOIN customer AS c
ON b.customerid = c.id 
LEFT JOIN vehicle AS v 
ON b.vehicleid = v.id
LEFT JOIN agency AS a
ON v.agency_id = a.id
LEFT JOIN cartype AS ct
ON v.type_id = ct.id
WHERE b.active = 1 AND b.vehicleid = "' . $_GET['car'] . '" ';

     $active = $conn->query($sql1);
     $inactive = $conn->query($sql2);
     $past = $conn->query($sql3);

      ?>
      <div class="row table-light btn-success" id ="transactions"><h1>Active Reservations</h1> <?php 
      while ($info = $active->fetch_assoc()) {         
        $start = strtotime($info['startdate']);
        $end = strtotime($info['enddate']);
        $now = strtotime($today);
        if ($end - $now > 0) { ?>
            <div class='card-body row-2 table-success'>
                 <h6 class='card-title text-dark'>
                 <h1>Booking #<?php echo $info['bookingid']; ?></h1>
                 <?php echo "<img class='img-fluid img-thumbnail' src=". $info['image'] ." alt='Image'>" ;?>
                    <h5 class="text-decoration-underline"><strong>Customer Information</strong></h5>
                    Name: <b><?php echo $info['firstname'] . ' ' . $info['lastname']; ?><br></b>
                    E-mail: <b><?php echo $info['customermail']?><br></b>
                    Phone number: <b><?php echo $info['customerphone']?><br></b>
                    <h5 class="text-decoration-underline"><strong>Booking Information</strong></h5>
                    Start Date: <b><?php echo $info['startdate']; ?><br></b>
                    End Date: <b><?php echo $info['enddate']; ?><br></b>
                    Total Price: <b>€<?php echo $info['price']; ?><br></b>
                    Manufacturer: <b><?php echo $info['manufacturer']; ?><br></b>
                    Model: <b><?php echo $info['model']; ?><br></b>
                    Type: <b> <?php echo $info['type']; ?><br></b>
                    Car plate: <b><?php echo $info['plate']; ?><br></b>
                    Agency: <b><?php echo $info['city']; ?></b><br>
                    E-mail: <b><?php echo $info['email']; ?><br></b>
                    Phone number: <b><?php echo $info['phonenumber']; ?></b>
                </h6>
              <div class='row-cols-6'>          
          <?php } ?>   
    </div>
    <?php } ?>
  </div>
</div>

               <div class="row table-light btn-danger" id ="transactions"><h1>Inactive Reservations</h1> <?php 
      while ($info = $inactive->fetch_assoc()) {  ?>
            <div class='card-body table-danger'>
                 <h6 class='card-title text-dark'>
                 <h1>Booking #<?php echo $info['bookingid']; ?></h1>
                 <?php echo "<img class='img-fluid img-thumbnail' src=". $info['image'] ." alt='Image'>" ;?>
                    <h5 class="text-decoration-underline"><strong>Customer Information</strong></h5>
                    Name: <b><?php echo $info['firstname'] . ' ' . $info['lastname']; ?><br></b>
                    E-mail: <b><?php echo $info['customermail']?><br></b>
                    Phone number: <b><?php echo $info['customerphone']?><br></b>
                    <h5 class="text-decoration-underline"><strong>Booking Information</strong></h5>
                    Start Date: <b><?php echo $info['startdate']; ?><br></b>
                    End Date: <b><?php echo $info['enddate']; ?><br></b>
                    Total Price: <b>€<?php echo $info['price']; ?><br></b>
                    Manufacturer: <b><?php echo $info['manufacturer']; ?><br></b>
                    Model: <b><?php echo $info['model']; ?><br></b>
                    Type: <b> <?php echo $info['type']; ?><br></b>
                    Car plate: <b><?php echo $info['plate']; ?><br></b>
                    Agency: <b><?php echo $info['city']; ?></b><br>
                    E-mail: <b><?php echo $info['email']; ?><br></b>
                    Phone number: <b><?php echo $info['phonenumber']; ?></b>
                </h6>
                <div class='row-cols-6'>  
      </div>
    <?php } ?> 
  </div>
</div>  

      <div class="row table-light btn-primary" id ="transactions"><h1>Past Reservations</h1> <?php 
      while ($info = $past->fetch_assoc()) {  
          $start = strtotime($info['startdate']);
          $end = strtotime($info['enddate']);
          $now = strtotime($today);
         if ($now - $end > 0) { ?>
          <div class='card-body row-2 table-primary'>
          <h6 class='card-title text-dark'>
          <h1>Booking #<?php echo $info['bookingid']; ?></h1>
          <?php echo "<img class='img-fluid img-thumbnail' src=". $info['image'] ." alt='Image'>" ;?>
             <h5 class="text-decoration-underline"><strong>Customer Information</strong></h5>
             Name: <b><?php echo $info['firstname'] . ' ' . $info['lastname']; ?><br></b>
             E-mail: <b><?php echo $info['customermail']?><br></b>
             Phone number: <b><?php echo $info['customerphone']?><br></b>
             <h5 class="text-decoration-underline"><strong>Booking Information</strong></h5>
             Start Date: <b><?php echo $info['startdate']; ?><br></b>
             End Date: <b><?php echo $info['enddate']; ?><br></b>
             Total Price: <b>€<?php echo $info['price']; ?><br></b>
             Manufacturer: <b><?php echo $info['manufacturer']; ?><br></b>
             Model: <b><?php echo $info['model']; ?><br></b>
             Type: <b> <?php echo $info['type']; ?><br></b>
             Car plate: <b><?php echo $info['plate']; ?><br></b>
             Agency: <b><?php echo $info['city']; ?></b><br>
             E-mail: <b><?php echo $info['email']; ?><br></b>
             Phone number: <b><?php echo $info['phonenumber']; ?></b>
         </h6>
<?php } } } ?>  
  </div>
</div>  



      
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