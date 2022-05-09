<?php
session_start();
require_once('config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM customer WHERE email = ? AND password = ? LIMIT 1";
$stmtselect  = $db->prepare($sql);
$result = $stmtselect->execute([$email, sha1($password)]);

if($result){
	$user = $stmtselect->fetch(PDO::FETCH_ASSOC);
	if($stmtselect->rowCount() > 0){
		$_SESSION['email'] = $email;
		$_SESSION['userlogin'] = $user;
		echo '1';
	}else{
		echo 'Invalid email or password.';		
	}
}else{
	echo 'There were errors while connecting to database.';
}
?>