<?php
$user = $_GET['user'];
$conn = new mysqli("localhost", "root", "1234", "tkcrs");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = 'DELETE FROM `customer` WHERE `customer`.`id` = "' . $user . '" ';

if (mysqli_query($conn, $sql)) {
    header( "refresh:0.1;url=customers.php" );
} else {
  echo "Error updating record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>