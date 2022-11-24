<?php
session_start();
require_once '../DB.php';
//.......LOGIN.........
if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM users WHERE user_email='$email' && user_password='$password'";
	$result = $con->query($sql);
	if ($result->num_rows >= 1) {
		$record = $result->fetch_assoc();
		$_SESSION['user_id'] = $record['user_id'];
		$_SESSION['role_id'] = $record['role_id'];
		$_SESSION['message'] = "Successfully Login!";
		header('location:profile.php');
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Invalid Email & Password";
		header('location:../login.php');
	}
}

?>