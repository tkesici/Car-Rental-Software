<?php
$booking = $_GET['booking'];
$conn = new mysqli("localhost", "root", "1234", "tkcrs");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = 'UPDATE booking
SET active = 0
WHERE booking.id = "' . $booking . '" ';

if (mysqli_query($conn, $sql)) {
    header( "refresh:0.1;url=managebooking.php?booking=$booking" );
} else {
  echo "Error updating record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>