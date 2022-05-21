<?php 
session_start();
	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}
  if(!isset($_SESSION['startdate']) || !isset($_SESSION['enddate'])) {
    header("Location: index.php");
  }
    $conn = new mysqli("localhost", "root", "1234", "tkcrs");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $today = date_create()->format('Y-m-d');

  $startdate = $_SESSION['startdate'];
  $startdate = str_replace(' ', '', $startdate);
  $startdate = DateTime::createFromFormat('m/d/Y', $startdate)->format('Y-m-d');
  $enddate = $_SESSION['enddate'];
  $enddate = str_replace(' ', '', $enddate);
  $enddate = DateTime::createFromFormat('m/d/Y', $enddate)->format('Y-m-d');
  $datetime1 = strtotime($_SESSION['startdate']);
  $datetime2 = strtotime($_SESSION['enddate']);
  $secs = $datetime2 - $datetime1;
  $days = $secs / 86400;
  $pricequery = "SELECT price FROM vehicle v WHERE v.id = '".$_GET['car']."'";
  $priceresult = mysqli_query($conn,$pricequery);
  while ($row1 = mysqli_fetch_array($priceresult)):
  $total = $row1['price']*$days;
  endwhile;
  $ccnumber = $expiration = $cvv = "";
  $ccnumberErr = $expirationErr = $cvvErr = "";
  $valid = false;

  if (($_SERVER["REQUEST_METHOD"] ?? 'POST') == "POST") {
    function order(){
      global $conn,$startdate,$enddate,$total;
      $stmt = $conn->prepare("INSERT INTO booking (`customerid`,`vehicleid`,`startdate`,`enddate`,`price`) VALUES(?,?,?,?,?)");
      $stmt->bind_param("iissi",$_SESSION['id'],$_GET["car"],$startdate,$enddate,$total);
      $stmt->execute();
      $stmt->close();
      $conn->close();
      header('Location:index.php');
    }

    if(isset($_POST['submit'])){
      order();
    }

        function test_input($data)  {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
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
  <title>Payment / tkCRS</title>
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

<body class="text-black-50 ">

    <!--Header-->
<main>
  <header class="p-3 bg-warning text-white">
    <div >
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <img style="display: inline;" src="../img/logo/secondarybanner.png" alt="logo" width="120" height="60"/>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="../php/hire.php" class="nav-link px-2 text-dark">Back to page</a></li>
  </header>
</main>
    <!--/Header-->
    <div class="row mt-0">
    <?php

$conn = new mysqli("localhost", "root", "1234", "tkcrs");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    
    $sql = "SELECT *
    FROM vehicle v 
        WHERE v.id = '".$_GET['car']."'";
    $cars = $conn->query($sql);
    if (!$cars) {
        die($conn->error);
    }
  
    while ($vehicle = $cars->fetch_assoc()) { ?>

              </div>
    <!--Content-->

    <div class="container">
      <main>
        <div class="text-center">
          <img class="d-block mx-auto mb-4" src="../img/logo/banner.png" width="300" height="150">
          <h2>Checkout</h2>
        </div>
        <div class="row g-5">
           <div>
           <form method="post">
              <div class="row gy-3">
                <div class="col-md-6">
                  <label for="cc-name" class="form-label">Name on card</label>
                  <input type="text" class="form-control" id="cc-name" value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];?>">
                </div>
    
                <div class="col-md-6">
                  <label for="cc-number" class="form-label">Credit card number</label>
                  <input type="text" class="form-control" id="cc-number" placeholder="0000-0000-0000-0000">
                </div>
    
                <div class="col-md-3">
                  <label for="cc-expiration" class="form-label">Expiration</label>
                  <input type="text" class="form-control" id="cc-expiration" placeholder="00/00">
                </div>
    
                <div class="col-md-3">
                  <label for="cc-cvv" class="form-label">CVV</label>
                  <input type="text" class="form-control" id="cc-cvv" placeholder="000">
                </div>
              </div>

                 
              <h4 class="d-flex justify-content-between align-items-center mb-3">
              </h4>
              <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-sm">
                  <div>                
                    <h3 class="text-dark"><?php echo ' <b>' . $vehicle['manufacturer']  . '</b> ' . $vehicle['model'];?> </h3>
                    <h6 class="text-muted"><?php echo $_SESSION['startdate'] . ' to ' . $_SESSION['enddate'];?></h6>
                    <small class="text-muted">€<?php echo $vehicle['price']?> x <?php echo $days . ' days';?> </small>
                    <div class="col-7">
                      <div class="card-top-left">
                         <img class="img-fluid" src="<?php echo $vehicle['image'] ?>" alt="Image">
                  </div>
                </div>
                <strong>€<?php echo number_format((float)$vehicle['price']*$days, 2, '.', '');?></strong>
                  </div>
                </li>
              </ul>
              <input class="w-100 btn btn-outline-warning container-fluid" type="submit" name="submit" value="Order"> 
              <hr>            
              </form>
          
          </div>
        </div>
      </main>
    </div>
</main>
<?php 
              } 
            ?>
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