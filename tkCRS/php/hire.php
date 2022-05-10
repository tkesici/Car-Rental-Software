<?php 
session_start();
require_once('config.php');

	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: hire.php");
	}

  $sql1 = "SELECT * from vehicle";
    $handle1 = $db->prepare($sql1);
    $handle1->execute();
    $getAllVehicles = $handle1->fetchAll(PDO::FETCH_ASSOC);

  $sql2 = "SELECT * from agency";
    $handle2 = $db->prepare($sql2);
    $handle2->execute();
    $getAllAgencies = $handle2->fetchAll(PDO::FETCH_ASSOC);
 
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Tevfik Kesici">
  <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
  <title>Hire / tkCRS</title>

  <!--Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" 
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" 
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" 
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body class="h-100 text-center text-white bg-dark">
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
<?php
	  if(!isset($_SESSION['userlogin'])) {
?>
        <div class="text-end">
        <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#loginmodal">Login</button>
        <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#createaccmodal">Create Account</button>
        </div>
<?php 
    } 
      else { 
?>
        <div class="text-end">
          <div class="navbar-form navbar-brand">
            <button class="btn btn-light dropdown-toggle" type="button" id="memberdropdown" data-toggle="dropdown">
<?php 
                echo 'Welcome, ' . $_SESSION['email']; 
?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">My Transactions</a>
              <a class="dropdown-item" href="#">Settings</a>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-danger me-2" onclick=" relocate('hire.php?logout=true')">Log out</button>
<?php
	}
?>
    </div>
  </form>
      
  <!--Login-->
<div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="logintitle">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <main class="form-signin">
          <form>
            <div class="form-floating text-black-50">
              <input type="email" class="form-control" id="email" placeholder="name@example.com">
              <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating text-black-50">
              <input type="password" class="form-control" id="password" placeholder="Password">
              <label for="floatingPassword">Password</label>
            </div>
            <div class="checkbox mb-3 text-black-50">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            <button class="btn btn-primary w-100 btn btn-lg btn-dark" type="button" name="button" id="login">Login</button> 
            <br>
            <div class="text-center">
              <br>
            <a href="#" class="text-justify">Are you an employee?</a>
          </div>
          </form>
        </main>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

  <!--Create Account-->
<div class="modal fade" id="createaccmodal" tabindex="-1" role="dialog" aria-labelledby="createaccmodal" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title text-black-50" id="createacctitle">Create Account</h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <main class="form-signin">
         <form>
           <div class="form-floating text-black-50">
             <input type="text" class="form-control" placeholder="text" id="firstname" required><label>First Name</label>
           </div>
           <div class="form-floating text-black-50">
             <input type="text" class="form-control" placeholder="text" id="lastname" required><label>Last Name</label>
           </div>
           <div class="form-floating text-black-50">
             <input type="email" class="form-control" placeholder="email" id="email" required><label>Email address</label>
           </div>
           <div class="form-floating text-black-50">
             <input type="text" class="form-control" placeholder="text" id="phonenumber" required><label>Phone number</label>
           </div>
           <div class="form-floating text-black-50">
             <input type="password" class="form-control" placeholder="Password" id="password" required><label>Password</label>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input type="password" class="form-control" placeholder="Password" id="confirmpassword" required><label>Confirm Password</label>
           </div>
           <div class="checkbox mb-3 text-black-50">
             <label>
               <input type="checkbox" value="terms" required><a class="text-sm-start"> I have read and accept the 
                 <a href="#" target="_blank">terms and conditions</a></a>
             </label>
           </div>
           <input class="w-100 btn btn-lg btn-dark"  type="submit" id="register" name="create" value="Create Account"> 
           <br>
         </form>
       </main>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
</header>


<!--Content-->

<section class="py-5 text-center container">
        <div class="row py-lg-5">
          <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Choose the best one for you.</h1>
            <p class="lead text-muted">The subscription fee is based on your fleet size, number of locations, advanced functionality, and includes support and updates.</p>
            <p>
              <input type="button" class="btn btn-warning" value="Get Help" onclick=" relocate('../html/contact.php')">
              <a href="#cars" class="btn btn-secondary my-2">Continue</a>
            </p>
          </div>
        </div>
      </section>

<?php
	  if(!isset($_SESSION['userlogin'])) {
      ?>
      <div class="row">
        <?php
        foreach($getAllVehicles as $vehicle)
        {
        ?>
            <div class="col-md-3 mt-2" id="cars">
                <div class="card">
                        <img class="card-img-top img-fluid" src="<?php echo $vehicle['image'] ?>">
                    <div class="card-body">
                        <h3 class="card-title text-dark">
                                <?php echo ' <b>' . $vehicle['manufacturer']  . '</b> ' . $vehicle['model']; ?>
                                </h3>
                                <h5 class="text-dark">€<?php echo $vehicle['price']?>/day</h5>
                                <br>

                    <div class="btn-group">
                      <input type="button" class="btn btn-sm btn-secondary" value="Specifications" data-toggle="modal" data-target="#specsmodal">
                      <input type="button" class="btn btn-sm btn-warning" value="Hire" disabled>
                    </div>
                    </div>
                    
                </div>
            </div>
        <?php 
        }
        ?>
    </div>
        <?php
      }  
      else {
        ?>
<div class="row">
  
        <?php
        foreach($getAllVehicles as $vehicle)
        {
        ?>
            <div class="col-md-3 mt-2" id="cars">
                <div class="card">
                        <img class="card-img-top img-fluid" src="<?php echo $vehicle['image'] ?>">
                    <div class="card-body">
                        <h3 class="card-title text-dark">
                                <?php echo ' <b>' . $vehicle['manufacturer']  . '</b> ' . $vehicle['model']; ?>
                                </h3>
                                <h5 class="text-dark">€<?php echo $vehicle['price']?>/day</h5>
                                <br>

                    <div class="btn-group">
                      <input type="button" class="btn btn-sm btn-secondary" value="Specifications" data-toggle="modal" data-target="#specsmodal">
                      <input type="button" class="btn btn-sm btn-warning" value="Hire" data-toggle="modal" data-target="#hiremodal">
                    </div>
                    </div>
                </div>
            </div>
        <?php 
        }
        ?>
    </div>
        <?php
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
<!--Datepicker Modal-->
<div class="modal fade" id="hiremodal" tabindex="-1" role="dialog" aria-labelledby="hire" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black-50" id="hire">Hire</h5>
      </div>
        <div class="modal-body">
            <form class="col">
              </form>
              <form class="container-fluid">
                <label class="text-black-50">Pick-up location</label>
              <select class="custom-select">
                <?php
                foreach($getAllAgencies as $agency)
                      {
                  ?>
                    <option><?php echo $agency['city'];?></option>
                    <?php
                      }
                      ?>
              </select>
            </form>

            <form class="container-fluid">
                <label class="text-black-50">Drop-off location</label>
              <select class="custom-select">
                <?php
                foreach($getAllAgencies as $agency)
                      {
                  ?>
                    <option><?php echo $agency['city'];?></option>
                    <?php
                      }
                      ?>
              </select>
            </form>

            <form class="container-fluid">
                <label class="text-black-50">Date</label>
            </form>
          

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-warning" onclick=" relocate('../html/payment.html')">Payment</button>
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!--/Datepicker Modal-->
    <!--Footer-->
  <footer class="text-center text-lg-start" style="background-color:#ffc404">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-primary" href="index.php">tkCRS.com</a>
    </div>
  </footer>
<!--Javascript-->
<script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
	$(function(){
		$('#register').click(function(e){

			var valid = this.form.checkValidity();
			var passwordmatch = false;

			if(valid){

			var firstname 	  	= $('#firstname').val();
			var lastname		    = $('#lastname').val();
			var email 			    = $('#email').val();
			var phonenumber   	= $('#phonenumber').val();
			var password 	    	= $('#password').val();
			var confirmpassword = $('#confirmpassword').val();

				e.preventDefault();	

				$.ajax({
					type: 'POST',
					url: 'process.php',
					data: {firstname: firstname,lastname: lastname,email: email,phonenumber: phonenumber,password: password, confirmpassword: confirmpassword},
					success: function(data){

						Swal.fire({'title': 'Successful','text': 'You are successfully registered.','type': 'success'})
						
					},
					error: function(data){
					
						Swal.fire({'icon': 'error', 'text': 'hata 1The form must be filled up correctly.', 'type': 'error'})

					}
				});

			} else {

				e.preventDefault();	

				Swal.fire({'icon': 'error', 'text': 'hata 2 The form must be filled up correctly.', 'type': 'error'})

			}
		});		

	});
	
</script>
<script>
	$(function(){
		$('#login').click(function(e){

			var valid = this.form.checkValidity();

			if(valid){
				var email = $('#email').val();
				var password = $('#password').val();
			}

			e.preventDefault();

			$.ajax({
				type: 'POST',
				url: 'jslogin.php',
				data:  {email: email, password: password},
				success: function(data){
					alert(data);
					if($.trim(data) === "1"){
						setTimeout(' window.location.href =  "hire.php"', 1000);
					}
				},
				error: function(data){
					alert('There were errors while doing the operation.');
				}
			});

		});
	});
</script>
<script>
	var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('confirmpassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Passwords match';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Passwords do not match';
  }
}
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
</script>
  </body>
</html>