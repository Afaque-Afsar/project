<?php
	require_once('../../DB.php');
	if ( isset($_GET['type']) && $_GET['type'] == 'get_user_detail' ) {
		$user_id = $_GET['user_id'];
		$sql = "SELECT * FROM users WHERE user_id = ".$user_id;
        $result = $con->query($sql);
        $return = ['status' => 'false', 'data' => []];
        if ($result) {
        	$return['status'] = 'true';
            while ($row = $result->fetch_assoc()) {
            	$return['data'][] = $row; 
            }
        }
        echo json_encode($return);
	} else if ( isset($_GET['type']) && $_GET['type'] == 'delete_user' ) {
		$user_id = $_GET['user_id'];
		if($con->query("UPDATE users SET user_status = 2 WHERE user_id = $user_id")){
            echo 'deleted';
        } else {
            echo 'not';
        }        
	} else if ( isset($_GET['type']) && $_GET['type'] == 'edit_user' ) {
		$user_id = $_GET['user_id'];
		$f_name = $_GET['f_name'];
		$last_name = $_GET['last_name'];
		$email = $_GET['email'];
		$mobile = $_GET['mobile'];
		$status = $_GET['status'];
		$role = $_GET['role'];
		$sql = "UPDATE users SET user_fname = '$f_name', user_lname = '$last_name', user_email = '$email', user_mobile = '$mobile', role_id = $role, user_status = $status WHERE user_id = $user_id";
		if($con->query($sql)){
            echo 'edited';
        } else {
            echo 'not edited';
        }        
	} else if ( isset($_GET['type']) && $_GET['type'] == 'add_user' ) {
		$f_name = $con->real_escape_string($_GET['f_name']);
		$last_name = $con->real_escape_string($_GET['last_name']);
		$email = $con->real_escape_string($_GET['email']);
		$mobile = $con->real_escape_string($_GET['mobile']);
		$status = $_GET['status'];
		$role = $_GET['role'];
		$password = $_GET['password'];
		
		$sqlCHeck = "SELECT user_id FROM users WHERE user_email = '$email'";
		$resCheck = $con->query($sqlCHeck);
		if($resCheck && $resCheck->num_rows > 0){
            echo 'This email is already exist in our system...';
        } else {
            $sql = "INSERT INTO users(user_fname, user_lname, user_email, user_password, user_mobile, role_id, user_status) 
                    VALUES('$f_name', '$last_name', '$email', '$password', '$mobile', $role, $status)";
            if($con->query($sql)){
                echo 'added';
            } else {
                echo 'not added';
            } 
        }        
	} 

	