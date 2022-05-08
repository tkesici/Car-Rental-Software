<?php 
session_start();

	if(isset($_SESSION['userlogin'])){
		
	} 

	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}
?>


<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Tevfik Kesici">
     <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
    <title>tkCRS - Home</title>

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

</head>

<body class="h-100 text-center text-white bg-dark">

    <!--Header-->
<main>
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <img style="display: inline;" src="../img/logo/banner.png" alt="logo" width="120" height="60"/>
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="index.php" class="nav-link px-2 text-warning">Home</a></li>
          <li><a href="hire.php" class="nav-link px-2 text-white">Hire</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Dealers</a></li>
          <li><a href="#" class="nav-link px-2 text-white">About</a></li>
          <li><a href="#" class="nav-link px-2 text-white">Contact</a></li>
        </ul>

        <form class="navbar-form navbar-brand" action="http://www.google.com" target="_blank" type="GET">
          <div class="input-group"> 
          <?php
	if(!isset($_SESSION['userlogin'])) {
    ?>
    <div class="text-end">
    <a style="font-size: 15px">Welcome, Guest</a>
    <button type="button" class="btn btn-outline-light me-2" data-toggle="modal" data-target="#loginmodal">Login</button>
    <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#createaccmodal">Create Account</button>
    </div>
    <?php 
  } else { 
    ?>
    <div class="text-end">
          <div class="navbar-form navbar-brand">
            <button class="btn btn-light dropdown-toggle" type="button" id="memberdropdown" data-toggle="dropdown">
              <?php echo 'Welcome ' . $_SESSION['email']; ?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Profile</a>
              <a class="dropdown-item" href="#">My Transactions</a>
              <a class="dropdown-item" href="#">Settings</a>
            </div>
          </div>
        </div>
        <button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
    <?php
	}
?>
    </div>
  </form>
      
    <!--Login Modal-->
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
     <!--/Login Modal-->

     <!--Create Account Modal-->
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
        <!--/Create Account Modal-->
       
  </header>
</main>
    <!--/Header-->

    <!--Content-->
<div>
  <img class="img-fluid" src="../img/wallpapers/x.jpg" alt="Cars1" style="opacity: 0.5;">
  <div class="centered">  
</div>
    <!--/Content-->

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
						setTimeout(' window.location.href =  "index.php"', 1000);
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
      function search(word) {
        word.q.value = "http://www.google.com/search/"+word;
    }
      </script>
  </body>
</html>