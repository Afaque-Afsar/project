<?php
session_start();
if((isset($_SESSION['user']['user_id'])) && (isset($_SESSION['user']['role_id'])) && ($_SESSION['user']['user_id']) && ($_SESSION['user']['role_id'])){
	unset($_SESSION['user']);
	$_SESSION['success'] = true;
	$_SESSION['error'] = false;
	$_SESSION['message'] = "Successfully Logout!";
}
	header('location:login.php');
?>