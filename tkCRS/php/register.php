<?php 
session_start();
require_once('config.php');

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

$firstnameErr = $lastnameErr = $emailErr = $passwordErr = $dateErr = $phonenumberErr = $matchErr = "";
$firstname = $lastname = $email = $phonenumber = $password = $repassword = "";
$registrationDate = date("d-m-y h:i:s");
$valid = true;
$accountActivity = 1;

	if(isset($_GET['logout'])){
		session_destroy();
		header("Location: index.php");
	}

if ($_SERVER["REQUEST_METHOD"] == "POST") {



  if (empty($_POST["firstname"])) {
      $firstnameErr = "First name is required";
      $valid = false;
  } else {

      $firstname = test_input($_POST["firstname"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
          $firstnameErr = "Invalid name format";
          $valid = false;
      }
  }

  if (empty($_POST["lastname"])) {
    $lastnameErr = "Last name is required";
    $valid = false;
  } else {
    $lastname = test_input($_POST["lastname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
        $lastnameErr = "Invalid name format";
        $valid = false;
    }
  }

  if (empty($_POST["email"])) {
      $emailErr = "Email is required";
      $valid = false;
  } else {
      $email = test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
          $valid = false;
      }
  }

  if (empty($_POST["phonenumber"])) {
    $phonenumberErr = "Phone number is required";
    $valid = false;
  } else {
    $phonenumber = test_input($_POST["phonenumber"]);
  }

  if (empty($_POST["password"])) {
      $passwordErr = "Password is Required";
      $valid = false;
  } else {
      $password = test_input($_POST["password"]);
      if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
          $passwordErr = "Must contain at least one number and one uppercase and lowercase letter, and at
           least 8 or more characters";
          $valid = false;
      }
  }

  if (!($_POST["password"] === $_POST["repassword"])) {
    $valid = false;
    $matchErr = "Passwords must match";
 }


  if ($valid) {

    $servername = "localhost";
    $serverusername = "root";
    $serverpassword = "1234";
    $databasename = "tkcrs";

    $conn = new mysqli($servername, $serverusername, $serverpassword, $databasename);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $duplicateEmail=mysqli_query($conn,"SELECT * FROM customer where email='$email'");
    $duplicatePhonenumber=mysqli_query($conn,"SELECT * FROM customer where phonenumber='$phonenumber'");

    if ((mysqli_num_rows($duplicateEmail)>0) && (mysqli_num_rows($duplicatePhonenumber)>0)) {
      echo 'A user is already exist with an email of <b>' . $_POST["email"] . '</b> and a phone number of <b> ' . $_POST["phonenumber"] . '</b>!';
    } else {
      if (mysqli_num_rows($duplicateEmail)>0) {
        echo 'A user is already exist with an email of <b>' . $_POST["email"] . '</b>!';
     } 
     else if (mysqli_num_rows($duplicatePhonenumber)>0) {
        echo 'A user is already exist with a phone number of <b>' . $_POST["phonenumber"] . '</b>!';
     } else {
         $stmt = $conn->prepare("INSERT INTO customer (`firstname`,`lastname`,`email`,`phonenumber`,`password`,`active`) VALUES(?,?,?,?,?,?)");
         $stmt->bind_param("ssssss", $firstname, $lastname, $email, $phonenumber, md5($password), $accountActivity);
     
         $stmt->execute();
         $stmt->close();
         $conn->close();
         header('Location: index.php');
       }
    }
  }
}
function test_input($data)  {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Tevfik Kesici">
  <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
  <style> .error {color: #FF0000;} </style>
  <title>Home / tkCRS</title>

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
 <!--Create Account-->
 <div id="createaccmodal" tabindex="-1" role="dialog" aria-labelledby="createaccmodal" aria-hidden="true">
 <div class="modal-dialog" role="document">
   <div class="modal-content">
     <div class="modal-header">
       <h5 class="modal-title text-black-50" id="createacctitle">Create Account</h5>
         <span aria-hidden="true">&times;</span>
       </button>
     </div>
     <div class="modal-body">
       <main class="form-signin">
       <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p><span class="error">* required field</span></p>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="firstname" value="<?php echo $firstname;?>"><label>First Name</label>
             <span class="error">* <?php echo $firstnameErr; ?></span>
           </div>

           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="lastname" value="<?php echo $lastname;?>"><label>Last Name</label>
             <span class="error">* <?php echo $lastnameErr; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="email" value="<?php echo $email;?>"><label>Email address</label>
             <span class="error">* <?php echo $emailErr; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="phonenumber" value="<?php echo $phonenumber;?>"><label>Phone number</label>
             <span class="error">* <?php echo $phonenumberErr; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="password" name="password" value="<?php echo $password;?>"><label>Password</label>
             <span class="error">* <?php echo $passwordErr; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="password" name="repassword" value="<?php echo $repassword;?>"><label>Confirm Password</label>
             <span class="error">* <?php echo $matchErr; ?></span>
           </div>
           <br>
           <div class="checkbox mb-3 text-black-50">
             <label>
               <input type="checkbox" value="terms" required><a class="text-sm-start"> I have read and accept the 
                 <a href="#" target="_blank">terms and conditions</a></a>
             </label>
           </div>
           <input class="w-100 btn btn-lg btn-dark"  type="submit" name="submit" value="Create Account"> 
           <br>
         </form>
       </main>
     </div>
     <div class="modal-footer">
       <button type="button" class="btn btn-warning" onclick="window.location='index.php';">Close</button>
         </div>
       </div>
     </div>
   </div>
</body>
</header>