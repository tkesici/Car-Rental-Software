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
    <title>Manage Vehicles \ tkCRS</title>

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
          <li><a href="vehicles.php" class="nav-link px-2 text-light">Manage Vehicles</a></li>
          <li><a href="agencies.php" class="nav-link px-2 text-dark">Manage Agencies</a></li>
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
<br>
<!--Content-->
<?php if(isset($_SESSION['admin'])) { 
  $sql1 = 'SELECT * FROM vehicle ORDER BY manufacturer';
  $vehicles = $conn->query($sql1); ?>

  <div class='col-md-2 rounded mx-auto d-block' id='cars'>
    <div class='card'>
    <div style="width:100%; text-align:center">
     <br>
        <img class="img-fluid" width="150px" src='https://cdn.pixabay.com/photo/2014/04/02/10/55/plus-304947_1280.png' alt='Image'>
        </div>
          <div class='card-body'>
          <div class='btn-group'>                    
            <div class='img-desc' onmousemove='imgHover(this, event)'>
            <br>
            <a class='btn btn-sm btn-success' href=addcar.php>Add Car</a>
               </div>
             </div>
          </div>
      </div>
  </div>
  <br>
  <div class='col-md-2 rounded mx-auto d-block' id='cars'>
    <div class='card'>
    <div style="width:100%; text-align:center">
     <br>
        <img class="img-fluid" width="150px" src='https://upload.wikimedia.org/wikipedia/commons/e/e0/Tools_clipart.png' alt='Image'>
        </div>
          <div class='card-body'>
          <div class='btn-group'>                    
            <div class='img-desc' onmousemove='imgHover(this, event)'>
            <br>
            <a class='btn btn-sm btn-warning' href=damaged.php>Damaged Cars</a>
               </div>
             </div>
          </div>
      </div>
  </div>
  <br>


<div class="row"> <?php 
      while ($vehicle = $vehicles->fetch_assoc()) {
      echo "<div class='col-md-2 mt-2' id='cars'>
            <div class='card'>
            <img class='img-fluid img-thumbnail' src=". $vehicle['image'] ." alt='Image'>
                  <div class='card-body'>
                  <h4 class='card-title text-dark'>
                    <b>" . $vehicle['manufacturer']  . "</b> 
                </h4>
                  <h6 class='card-title text-dark'>" .$vehicle['model'] ."
                  <h6 class='text-muted'><small>" .$vehicle['plate'] ."</small><br><br>
                <div class='btn-group d-grid gap-2 mx-auto'>                
                <a class='btn btn-sm btn-primary' href=\"managecar.php?car=".$vehicle['id']."\">Manage Properties</a>
                <a class='btn btn-sm btn-danger' href=\"deletecar.php?car=".$vehicle['id']."\">Delete Car</a> 
                <a class='btn btn-sm btn-warning' href=\"seebookings.php?car=".$vehicle['id']."\">See Bookings</a> 
                <div class='img-desc' onmousemove='imgHover(this, event)'>
                   </div>
                 </div>
              <h6 class='text-sm-center text-dark font-weight-light'>???". $vehicle['price']."/day</h6>
              </div>
          </div>
      </div>";
        } 
      ?>
      </tbody>
  </table>
</div>
</div>
</div> 
<?php
  }
?>
<br>
    <!--Footer-->
  <footer class="text-center text-lg-start" style="background-color:#ffc404">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      ?? 2022 Copyright:
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
