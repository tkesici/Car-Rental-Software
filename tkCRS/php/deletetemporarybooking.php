<?php
session_start();
$conn = new mysqli("localhost", "root", "1234", "tkcrs");
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
$carId = $_SESSION['temporary'];
$del = $conn->prepare("DELETE FROM `temp` WHERE temp.vehicleid = $carId");
$del->execute();
header( "refresh:0.1;url=hire.php" );
?>