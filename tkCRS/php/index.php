<?php 
session_start();
require_once('config.php');

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: hire.php");
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
    
    $stmt = $conn->prepare("INSERT INTO customer (`firstname`,`lastname`,`email`,`phonenumber`,`password`,`active`) VALUES(?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $phonenumber, sha1($password), $accountActivity);

    $stmt->execute();
    $stmt->close();
    $conn->close();
    header('Location: index.php');
}
}
function test_input($data)  {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// LOGIN SECTION

$loginEmail = $loginPassword = "";
$loginEmailErr = $loginPasswordErr = $loginErr = "";
$link = mysqli_connect("localhost", "root", "1234", "tkcrs");

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["loginEmail"]))){
        $loginEmailErr = "Please enter your email.";
    } else{
        $loginEmail = trim($_POST["loginEmail"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["loginPassword"]))){
        $loginPasswordErr = "Please enter your password.";
    } else{
        $loginPassword = trim($_POST["loginPassword"]);
    }
    
    // Validate credentials
    if(empty($loginEmailErr) && empty($loginPasswordErr)){
        // Prepare a select statement
        $sql = "SELECT email, password FROM customer WHERE email= ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $loginEmail);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt,$loginEmail, $loginPassword);
                    if(mysqli_stmt_fetch($stmt)){
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $loginEmail;
                        header("location: index.php");

                    }
                    else{
                        // Password is not valid
                        $loginErr = "Invalid email or password.";
                    }
                } else{
                    // Email doesn't exist
                    $loginErr = "Invalid email or password.";
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
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
  <header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <img style="display: inline;" src="../img/logo/banner.png" alt="logo" width="120" height="60"/>
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 text-warning">Home</a></li>
            <li><a href="hire.php" class="nav-link px-2 text-white">Hire</a></li>
            <li><a href="dealers.php" class="nav-link px-2 text-white">Dealers</a></li>
            <li><a href="about.php" class="nav-link px-2 text-white">About</a></li>
            <li><a href="contact.php" class="nav-link px-2 text-white">Contact</a></li>
          </ul>
          <form class="navbar-form navbar-brand" type="GET">
            <div class="input-group"> 
<?php
	  if(!isset($_SESSION['loggedin'])) {
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
        <button type="button" class="btn btn-danger me-2" onclick=" relocate('index.php?logout=true')">Log out</button>
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
        <?php 
        if(!empty($loginErr)){
            echo '<div class="alert alert-danger">' . $loginErr . '</div>';
        }        
        ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-floating text-black-50">
              <label for="floatingInput">Email address</label>
              <input class="form-control" type="text" name="loginEmail" class="form-control <?php echo (!empty($loginEmailErr)) ? 'is-invalid' : ''; ?>" value="<?php echo $loginEmail; ?>">
              <span class="invalid-feedback"><?php echo $loginEmailErr; ?></span>
            </div>
            <br>
            <div class="form-floating text-black-50">
            <label for="floatingPassword">Password</label>
                <input class="form-control" type="password" name="loginPassword" class="form-control <?php echo (!empty($loginPasswordErr)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $loginPasswordErr; ?></span>
            </div>
            <div class="checkbox mb-3 text-black-50">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            <input class="btn btn-primary w-100 btn btn-lg btn-dark" type="submit" value="Login">
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
             <input class="form-control" type="text" name="password" value="<?php echo $password;?>"><label>Password</label>
             <span class="error">* <?php echo $passwordErr; ?></span>
           </div>
           <br>
           <div class="form-floating text-black-50">
             <input class="form-control" type="text" name="repassword" value="<?php echo $repassword;?>"><label>Confirm Password</label>
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
       <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
         </div>
       </div>
     </div>
   </div>
</header>

    <!--Content-->
<div>
  <img class="img-fluid" src="../img/wallpapers/wallpaper4.jpg" alt="Cars1" style="opacity: 0.6;">
  <div class="centered">  
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
      function relocate(text) {
       location.href = text;
    }
</script>
  </body>
</html>