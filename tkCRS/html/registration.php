<?php
require_once('process.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>

<div>
	<form action="registration.php" method="post">
		<div class="container">
			
			<div class="row">
				<div class="col-sm-3">
					<h1>Registration</h1>
					<hr class="mb-3">
					<label for="firstname"><b>First Name</b></label>
					<input class="form-control" id="firstname" type="text" name="firstname" required>

					<label for="lastname"><b>Last Name</b></label>
					<input class="form-control" id="lastname"  type="text" name="lastname" required>

					<label for="email"><b>Email Address</b></label>
					<input class="form-control" id="email"  type="email" name="email" required>

					<label for="phonenumber"><b>Phone Number</b></label>
					<input class="form-control" id="phonenumber"  type="text" name="phonenumber" required>

					<label for="password"><b>Password</b></label>
					<input class="form-control" id="password"  type="password" name="password" required onkeyup='check();'>

					<label for="password"><b>Confirm Password</b></label>
					<input class="form-control" id="confirmpassword"  type="password" name="confirmpassword" required onkeyup='check();'>
					<span id='message'></span>

					<hr class="mb-3">
					<input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">
				</div>
			</div>
		</div>
	</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
	$(function(){
		$('#register').click(function(e){

			var valid = this.form.checkValidity();
			var passwordmatch = false;

			if ($('#password').val() == $('#confirmpassword').val()) {
				passwordmatch = true;
			}

			if(valid && passwordmatch){

			var firstname 		= $('#firstname').val();
			var lastname		= $('#lastname').val();
			var email 			= $('#email').val();
			var phonenumber 	= $('#phonenumber').val();
			var password 		= $('#password').val();
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
					
						Swal.fire({'icon': 'error', 'text': 'The form must be filled up correctly.', 'type': 'error'})

					}
				});

			} else {

				e.preventDefault();	

				Swal.fire({'icon': 'error', 'text': 'The form must be filled up correctly.', 'type': 'error'})

			}
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
</body>
</html>