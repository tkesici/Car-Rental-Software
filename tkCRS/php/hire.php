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

if(!empty($_SESSION['temporary'])) {
$carId = $_SESSION['temporary'];
$del = $conn->prepare("DELETE FROM `temp` WHERE temp.vehicleid = $carId");
$del->execute();
}

  $startdate = $enddate = "";
  $sql1 = "SELECT * FROM vehicle";
  $getAllVehicles = $conn->query($sql1);
  $sql2 = "SELECT * FROM agency";
  $getAllAgencies = $conn->query($sql2);
  $today = date_create()->format('Y-m-d');
  $sql3 = "SELECT * FROM cartype";
  $getVehicleType = $conn->query($sql3);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Tevfik Kesici">
  <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
  <title>Hire / tkCRS</title>
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
            <li><a href="hire.php" class="nav-link px-2 text-warning">Hire</a></li>
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
<button type="button" class="btn btn-danger me-2" onclick=" relocate('hire.php?logout=true')">Log out</button>
<?php } ?>
    </div>
  </form>
</header>
<!--Content-->
<?php if(isset($_SESSION['loggedin'])) { ?>
<section class="container">
  <div class="row py-lg-12">
    <div class="col-lg-6 col-md- mx-auto">
      <h1 class="fw-light text-warning">Choose the best one for you, <?php echo $_SESSION["firstname"];?>.</h1>
      <p class="lead text-muted">Running a car rental operation is a complex business and can be stressful when first starting out. Our priority at our website is to simplify this responsibility for you and make it an overall more enjoyable experience. </p>
      <br>
       <body>
          <section class="container">
          <form method="POST">
              <div class="row form-group">
                 <div class="col-4 mx-auto">
                  <div class="input-group date" id="datepicker" name="datepicker">
                   <input type="text" name="startdate" class="form-control" placeholder="Pick-up date">
                    <span class="input-group-append">
                     <span class="input-group-text bg-white d-block">
                       <i class="fa fa-calendar"></i>
                   </span>
                 </span>
              </div>  
            </div>
             <div class="col-4 mx-auto">
              <div class="input-group date" id="datepicker2" name="datepicker2" >
                <input type="text" name="enddate" class="form-control" placeholder="Drop-off date">
                 <span class="input-group-append">
                  <span class="input-group-text bg-white d-block">
                   <i class="fa fa-calendar"></i>
              </span>
            </span>
          </div>
        </div>
        <br>
        <br>
        
    </div>    
    <select class="col-2 mx-auto form-control" name="city">
                            <option value="" selected>Location</option>
                            <?php while ($row1 = mysqli_fetch_array($getAllAgencies)): ?>
                                <option value="<?php echo $row1['id']; ?>"><?php echo $row1['city']; ?></option>
                            <?php endwhile; ?>
                        </select>
                        <br>
<select class="col-2 mx-auto form-control" name="type">
                          <option value="" selected>Car Type</option>
                          <?php while ($row1 = mysqli_fetch_array($getVehicleType)): ?>
                              <option value="<?php echo $row1['id']; ?>"><?php echo $row1['type']; ?></option>
                          <?php endwhile; ?>
                       </select>
</section>
</body>
<br>
<input class="btn btn-warning" type="submit" name="submit" value="Search">
</form>
              
              <a href="index.php" class="btn btn-secondary my-2">See Cars</a>           
            </p>
          </div>
        </div>
      </section>
<?php } else { ?>
  <section class="py-5 text-center container">
  <div class="row py-lg-12">
    <div class="col-lg-6 col-md- mx-auto">
      <h1 class="fw-light text-warning">Choose the best one for you.</h1>
      <p class="lead text-muted">Running a car rental operation is a complex business and can be stressful when first starting out. Our priority at our website is to simplify this responsibility for you and make it an overall more enjoyable experience. </p>
      </div>
        </div>
</section>
<?php } ?>
<?php

  if(!empty($_POST['startdate']) && !empty($_POST['enddate'])) {
    $startdate = $_POST['startdate'];
    $startdate = str_replace(' ', '', $startdate);
    $startdate = DateTime::createFromFormat('m/d/Y', $startdate)->format('Y-m-d');
    $_SESSION['startdate'] = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $enddate = str_replace(' ', '', $enddate);
    $enddate = DateTime::createFromFormat('m/d/Y', $enddate)->format('Y-m-d');
    $_SESSION['enddate'] = $_POST['enddate'];
    $datetime1 = strtotime($_SESSION['startdate']);
    $datetime2 = strtotime($_SESSION['enddate']);
    $secs = $datetime2 - $datetime1;
    $days = $secs / 86400;
    $datetime3 = strtotime($_SESSION['startdate']);
    $datetime4 = strtotime($today);
    $secs2 = $datetime3 - $datetime4;
    $days2 = $secs2 / 86400;
    
  }
if(!empty($_POST['startdate']) && !empty($_POST['enddate']) && !empty($_POST['city']) && !empty($_POST['type'])) {

  if(isset($days2) && $days2 < 0) { ?>
    <h3 class="text-danger">You cannot hire a car before today.</h3> <?php
  } else if(isset($days) && $days < 1) { ?>
      <h3 class="text-danger">You can't hire a car for <?php echo $days;?> days.</h3> <?php
  } else if (isset($startdate) && isset($enddate)) { ?>
      <h3 class="text-warning">Results between <?php echo $_POST['startdate'] . ' and ' . $_POST['enddate']; ?></h3> <?php 
      $city = $_POST['city'];
      $start = $_POST['startdate'];
      $start = str_replace(' ', '', $start);
      $start = DateTime::createFromFormat('m/d/Y', $start)->format('Y-m-d');
      $end = $_POST['enddate'];
      $end = str_replace(' ', '', $end);
      $end = DateTime::createFromFormat('m/d/Y', $end)->format('Y-m-d');    
      $active = 1;
      $sql = 'SELECT v.id,v.manufacturer,v.model,v.image,v.price,v.agency_id,v.plate
      FROM vehicle v
      INNER JOIN agency a ON v.agency_id = a.id 
      WHERE v.id NOT IN 
      (SELECT b.vehicleid FROM booking b 
      WHERE NOT (b.enddate < "' . $start . '" OR b.startdate > "' . $end . '" ) AND b.enddate  AND b.active = 1) 
      AND v.agency_id = "' . $_POST['city'] . '"
      AND v.type_id = "' . $_POST['type'] . '" 
      AND v.id NOT IN (SELECT vehicleid from `temp` t WHERE NOT (t.enddate < "' . $start . '"
      OR t.startdate > "' . $end . '" ))
      AND v.id NOT IN (SELECT vehicleid from damaged d)';


                    
      $cars = $conn->query($sql);
      $count = mysqli_num_rows($cars);
      if ($count>0) {
        if($count==1) { ?>
          <h5 class="text-success"><?php echo $count . ' car available'; ?></h5> <?php 
        } else { ?>
          <h5 class="text-success"><?php echo $count . ' cars available'; ?></h5> <?php
        }
      } else { ?>
        <h5 class="text-danger"><?php echo 'No cars available'; ?></h5> <?php

      }
      if (!$cars) {
          die($conn->error);
      } ?>
          <div class="row"> <?php 
      while ($vehicle = $cars->fetch_assoc()) {
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
                <input type='button' class='btn btn-sm btn-secondary' value='Specifications' data-toggle='modal' data-target='#specsmodal'>
                <a class='btn  btn-sm btn-warning' href=\"payment.php?car=".$vehicle['id']."\">Hire</a>                    
                <div class='img-desc'>
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
}
?>
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