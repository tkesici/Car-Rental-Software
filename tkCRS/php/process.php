<?php
$db_user = "root";
$db_pass = "1234";
$db_name = "tkcrs";

$db = new PDO('mysql:host=localhost;dbname='. $db_name . ';charset=utf8', $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<?php

if(isset($_POST)){

	$firstname 		= $_POST['firstname'];
	$lastname 		= $_POST['lastname'];
	$email 			= $_POST['email'];
	$phonenumber	= $_POST['phonenumber'];
	$password 		= sha1($_POST['password']);

	$sql = "INSERT INTO customer (firstname, lastname, email, phonenumber, password, active) VALUES(?,?,?,?,?,?)";
	$stmtinsert = $db->prepare($sql);
	$result = $stmtinsert->execute([$firstname, $lastname, $email , $phonenumber, $password, 1]);
	if($result){
		echo 'Successfully saved.';
	}else{
		echo 'There were erros while saving the data.';
	}
	}
	else	{
	echo 'No data.';
}

?>