<?php
$car = $_GET['car'];
$conn = new mysqli("localhost", "root", "1234", "tkcrs");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = 'DELETE FROM vehicle WHERE vehicle.id = "' . $car . '" ';

if (mysqli_query($conn, $sql)) {
    header( "refresh:0.1;url=vehicles.php" );
} else {
  echo "Error updating record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>