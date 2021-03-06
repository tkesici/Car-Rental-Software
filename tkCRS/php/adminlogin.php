<?php
session_start();
if(isset($_SESSION["admin"])){
    header("location: dashboard.php");
    exit;
}
if(isset($_GET['adminlogout'])){
  unset($_SESSION["admin"]);
  unset($_SESSION["firstname"]);
  unset($_SESSION["lastname"]);
  unset($_SESSION["id"]);
  unset($_SESSION["adminmeail"]);
  header("Location: adminlogin.php");
}

$email = $password = "";
$email_err = $password_err = $login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $conn = new mysqli("localhost", "root", "1234", "tkcrs");

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($email_err) && empty($password_err)){
      $sql = "SELECT id,`firstname`,lastname,email,`password` FROM manager WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            while ($row = $result->fetch_assoc()) {
                    if ($row['password'] == md5($password)) {
                        $_SESSION["adminfirstname"] = $row['firstname'];
                        $_SESSION["adminlastname"] = $row['lastname'];
                        $_SESSION["adminid"] = $row['id'];
                        $_SESSION["adminemail"] = $row['email'];
                        $_SESSION["admin"] = true;
                        header("Location:dashboard.php");
                    } else {
                        $password_err = "Invalid password.";
                        $conn->close();
                    }
            }
            if ( is_resource($conn)) {
              $conn->close();
              header("Location:adminlogin.php");
         }
            
        } else {
            $login_err = "No such employee.";
            $conn->close();
        }        
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
  <style> .error {color: #FF0000;} </style>
  <title>Admin Login / tkCRS</title>

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
 <!--Login-->
 <div id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="logintitle">Employee Login</h5>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <main class="form-signin">
        <?php 
        if (!empty($login_err)){
          echo '<div class="alert alert-danger">' . $login_err . '</div>';               
        } 
        if (!empty($email_err)) {
          echo '<div class="alert alert-danger">' . $email_err . '</div>';
        }   
        if (!empty($password_err)) {
          echo '<div class="alert alert-danger">' . $password_err . '</div>';
        }  
        ?>
        
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-floating text-black-50">
              <input class="form-control" type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
              <label for="floatingInput">Email address</label>
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <br>
            <div class="form-floating text-black-50">
                <input class="form-control" type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <label for="floatingPassword">Password</label>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="checkbox mb-3 text-black-50">
              <label>
                <input type="checkbox" value="remember-me"> Remember me
              </label>
            </div>
            <input class="btn btn-primary w-100 btn btn-lg btn-warning" type="submit" value="Employee Login">
            <br>
            <div class="text-center">
              <br>
            <a href="login.php" class="text-justify">Are you a customer?</a>
          </div>
          </form>
        </main>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" onclick="window.location='index.php';">Abandon</button>
          </div>
        </div>
      </div>
    </div>
    </body>
</html>