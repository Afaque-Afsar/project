<?php
session_start();
require_once 'DB.php';
//...........User Register ...........

if (isset($_POST['signup'])) {
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$mobile = $_POST['mobile'];
	$created = date("Y-m-d H:i:s");
	
	$check_email = "SELECT * FROM users WHERE user_email='".$email."'";
	$res = $con->query($check_email);
	$rows = $res->num_rows;
	if ($rows >= 1) {
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Email already exist !!";
		header('location:register.php');
	}
	else{

		$sql = "INSERT into users (user_fname,user_lname,user_email,user_password,user_mobile,user_status,created_at) VALUES ('$fname','$lname','$email','$password','$mobile',0,'$created')";
		
		$result = $con->query($sql);

		if ($result) {
			$_SESSION['success'] = true;
			$_SESSION['error'] = false;
			$_SESSION['message'] = " Account Created";
			header('location:register.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = " Account not Created!!";
			header('location:register.php');
		}	

	}
}

//.......LOGIN.........
if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM users WHERE user_email='$email' && user_password='$password'";

	$result = $con->query($sql);
	if ($result->num_rows == 1) {
		$record = $result->fetch_assoc();
		if (($record['role_id'] == 1) && ($record['user_status'] == 1)) {
			$_SESSION['user'] = $record;
			$_SESSION['success'] = true;
			$_SESSION['error'] = false;
			$_SESSION['message'] = "Successfully Login!";
			header('location:admin/dashboard.php');
		} 
		
		elseif(($record['role_id'] == 3) && ($record['user_status'] == 1)) {
			$_SESSION['user'] = $record;
			$_SESSION['success'] = true;
			$_SESSION['error'] = false;
			$_SESSION['message'] = "Successfully Login!";
			header('location:user/dashboard.php');
		}
		elseif(($record['role_id'] == 2) && ($record['user_status'] == 1)) {
			$_SESSION['user'] = $record;
			$_SESSION['success'] = true;
			$_SESSION['error'] = false;
			$_SESSION['message'] = "Successfully Login!";
			header('location:contributor/dashboard.php');
		}
		else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = "Account not approved !!";
			header('location:login.php');
		}
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Invalid Email & Password";
		header('location:login.php');
	}
}

if (isset($_POST['post_comment'])) {

	if ($_SESSION['user']['user_id'] == '') {
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Please Login Your Account";
		header('location:login.php');
	}
	
	$comment= $_POST['comment'];
	$discussion_id = $_POST['discussion_id'];
	$added_by = $_SESSION['user']['user_id'];

	$sql = "INSERT INTO comments (comment, added_by, discussion_id) VALUES ('$comment','$added_by','$discussion_id')";
	$result = $con->query($sql);
	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Comment Added !!!";
		header('location:discussion-details.php?id='.$discussion_id);
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Comment not Added!!";
		header('location:discussion-details.php?id='.$discussion_id);		
	}
}

if (isset($_GET['comment'])) {
	$id = $_GET['comment'];
	$discussion_id= $_GET['id'];
	$sql = "UPDATE comments SET status = 2 WHERE id = ".$id;
	$result = $con->query($sql);
	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Comment Deleted !!!";
		header('location:discussion-details.php?id='.$discussion_id);
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Comment not Deleted!!";
		header('location:discussion-details.php?id='.$discussion_id);		
	}
}

//...........QUIZ SUBMIT................
if (isset($_POST['quiz_submit'])) {

	$quiz_part_id = $_POST['quiz_part_id'];
	$option = array_values($_POST['option']);
	$answer = array_values($_POST['answer']);
	$json_option = json_encode($_POST['option']);
	$submit_by = $_SESSION['user']['user_id'];
	$correct = 0;
	$wrong = 0;
	
	for ($i=0; $i < count($option); $i++) { 
		if ($option[$i] == $answer[$i]) {
				$correct++;
		}
		else{ $wrong++;	}
	}
	
	$sql = "INSERT INTO quiz_submit (json_option,correct,wrong,quiz_part_id,submit_by) VALUES('$json_option','$correct','$wrong', $quiz_part_id, $submit_by)";

	$result = $con->query($sql);

	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = " Quiz submitted";
		header('location:quiz.php?id='.$quiz_part_id);
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Quiz not submitted!!";
		header('location:quiz.php?id='.$quiz_part_id);
	}	
}

//............Paper Comment ................
if (isset($_POST['paper_comment'])) {


	if ($_SESSION['user']['user_id'] == '') {
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = "Please Login Your Account";
		header('location:login.php');
	}
	
	$comment= $_POST['comment'];
	$paper_id = $_POST['paper_id'];
	$added_by = $_SESSION['user']['user_id'];

	$sql = "INSERT INTO paper_comments (comment, added_by, paper_id) VALUES ('$comment','$added_by','$paper_id')";
	$result = $con->query($sql);
	if ($result) {
		$_SESSION['success'] = true;
		$_SESSION['error'] = false;
		$_SESSION['message'] = "Comment Added !!!";
		header('location:past_paper_detail.php?id='.$paper_id);
	}
	else{
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Comment not Added!!";
		header('location:past_paper_detail.php?id='.$paper_id);		
	}
}

//.................Forget Password..................
if (isset($_POST['forget_pass'])) {
	$email = $_POST['email'];
	$sql = "SELECT * FROM users WHERE user_email = '".$email."'";
	
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$id = $row['user_id'];

	$rows = $result->num_rows;
	if ($rows == 0) {
		$_SESSION['success'] = false;
		$_SESSION['error'] = true;
		$_SESSION['message'] = " Enter valid Email";
		header('location:login.php');
	}
	if ($rows == 1) {
	    $rand = rand(1000000, 99999999);
	    $sql = "UPDATE users SET tmp_field = $rand WHERE user_email = '".$email."'";
	
	    if( $con->query($sql) ) {
    		$to = $email;
        	$subject = "Reset your password";
        	$msg = "Please Click on below link to reset your password. <br><a href='http://s-cubelearning.com/project/new_password.php?id=$id&tmp=$rand&email=$email'> Click Here</a>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$headers.= "From: info@csm.com";
    	    $msg = wordwrap($msg,70);
    	    
    	    if(mail($to, $subject, $msg, $headers)){
        		$_SESSION['success'] = true;
        		$_SESSION['error'] = false;
        		$_SESSION['message'] = " Please Check your provided Email";
        		header('location:login.php');
    		}
	        
	    } else {
	        $_SESSION['success'] = false;
    		$_SESSION['error'] = true;
    		$_SESSION['message'] = " Internal Error, Please Try Again...";
    		header('location:login.php');
	    }
	
        
	}
}

//...............Password Reset Update.................
if (isset($_POST['password_update'])) {
    $id =$_POST['user_id'];
	$pass = $_POST['password'];
	$confirm = $_POST['confirm_password'];

	if ($pass = $confirm) {
		$sql = "UPDATE users SET user_password = '".$pass."', tmp_field = 0 WHERE user_id = $id";
		$result = $con->query($sql);
		
		if ($result) {
			$_SESSION['success'] = true;
			$_SESSION['error'] = false;
			$_SESSION['message'] = " Password Changed";
			header('location:login.php');
		}
	}
	else{
			$_SESSION['success'] = false;
			$_SESSION['error'] = true;
			$_SESSION['message'] = " Password not matched";
			header('location:login.php');
	}
}


?>