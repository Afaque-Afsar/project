<?php
	session_start();
	if( !( (isset($_SESSION['user']['user_id'])) && (isset($_SESSION['user']['role_id'])) && ($_SESSION['user']['user_id']) && ($_SESSION['user']['role_id'] == 3) ) ){
		header('location:../login.php');
	}