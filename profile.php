<?php 
session_start();

	if( !(isset($_SESSION['user']['role_id']) && $_SESSION['user']['user_id'] == 3) ){
		header("location: login.php");
	}
	include 'include/head.php';
	require_once("DB.php");
	if( isset( $_POST['update_profile'] ) ){
        $user_id = $_SESSION['user']['user_id'];
        $f_name = $_POST['user_fname'];
        $l_name = $_POST['user_lname'];
        $user_email = $_POST['user_email'];
        $user_mobile = $_POST['user_mobile'];
        $dob = $_POST['dob'];
        $home_town = $_POST['home_town'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $image_link = "";
        if( isset($_FILES['profile'])){
            $img = $_FILES['profile'];
            $fileName = time()."_".$img['name'];
            if( move_uploaded_file( $img['tmp_name'], "uploads/user_images/".$fileName ) ){
                $image_link = $fileName;
                $sql = "UPDATE users SET user_fname = '$f_name', user_lname = '$l_name', user_email = '$user_email', user_mobile = '$user_mobile',
                     date_of_birth = '$dob', gender = '$gender', address = '$address', city = '$home_town', image_path = '$image_link'  WHERE user_id = $user_id ";
            } else {
                $sql = "UPDATE users SET user_fname = '$f_name', user_lname = '$l_name', user_email = '$user_email', user_mobile = '$user_mobile',
                 date_of_birth = '$dob', gender = '$gender', address = '$address', city = '$home_town'  WHERE user_id = $user_id ";
            }
        } else {
            $sql = "UPDATE users SET user_fname = '$f_name', user_lname = '$l_name', user_email = '$user_email', user_mobile = '$user_mobile',
                 date_of_birth = '$dob', gender = '$gender', address = '$address', city = '$home_town'  WHERE user_id = $user_id ";
        }
        
        
        if( $con->query( $sql ) ){
            $_SESSION['success'] = true;
    		$_SESSION['error'] = false;
    		$_SESSION['message'] = " Profile Updated Successfully...";
        } else {
            $_SESSION['success'] = false;
    		$_SESSION['error'] = true;
    		$_SESSION['message'] = " Error, Profile Update, Please try again...";
        }
        
    }

    $sql = "SELECT * FROM users WHERE user_id = ".$_SESSION['user']['user_id'];
    $result = $con->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>window.location.reload();</script>";
    }
?>

<style>
body {
	color: #fff;
	/*background: #3598dc;*/
	font-family: 'Roboto', sans-serif;
}
.form-control {
	height: 41px;
	background: #f2f2f2;
	box-shadow: none !important;
	border: none;
}
.form-control:focus {
	background: #e2e2e2;
}
.form-control, .btn {        
	border-radius: 3px;
}
.signup-form {
	width: 600px;
	margin: 30px auto;
	margin-top: 100px;
}
.signup-form form {
	color: #999;
	border-radius: 3px;
	margin-bottom: 15px;
	background: #fff;
	box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	padding: 30px;
}
.signup-form h2  {
	color: #333;
	font-weight: bold;
	margin-top: 0;
}
.signup-form hr  {
	margin: 0 -30px 20px;
}    
.signup-form .form-group {
	margin-bottom: 20px;
}
.signup-form input[type="checkbox"] {
	margin-top: 3px;
}
.signup-form .row div:first-child {
	padding-right: 10px;
}
.signup-form .row div:last-child {
	padding-left: 10px;
}
.signup-form .btn {        
	font-size: 16px;
	font-weight: bold;
	background: #3598dc;
	border: none;
	min-width: 140px;
}
.signup-form .btn:hover, .signup-form .btn:focus {
	background: #2389cd !important;
	outline: none;
}
.signup-form .hint-text a {
	color: #3598dc;
	text-decoration: none;
}	
.signup-form .hint-text a:hover {
	text-decoration: underline;
}
.signup-form .hint-text  {
	padding-bottom: 15px;
	text-align: center;
	color: black;
}
@media screen and (max-width: 767px) {
  .signup-form {
    width: 100%;
  }
  #profile_img {
  	margin-top: 0px !important;
  }
}
</style>
</head>
<body>
<?php include 'include/header.php';?>
<div class="signup-form">
    <form action="" method="post" enctype="multipart/form-data">
		<?php include 'include/success_error_message.php';?>
		<div class="row">
			<div class="col-md-6 col-sm-12" align="center">
				<h2>Profile<hr></h2>
			</div>
			<div class="col-md-6 col-sm-12" align="center">
				<img src="uploads/user_images/<?= $row['image_path']; ?>" id='profile_img' width="100px" height="100px" style="margin-top: -50px; margin-bottom: 15px;" class="center">	
			</div>
		</div> 
		<hr>
        <div class="form-group">
			<div class="row">
				<div class="col">
					First Name<input type="text" class="form-control" name="user_fname" value="<?= $row['user_fname']; ?>" placeholder="First Name" required="required"></div>
				<div class="col">
					Last Name<input type="text" class="form-control" name="user_lname" value="<?= $row['user_lname']; ?>" placeholder="Last Name" required="required"></div>
			</div>        	
        </div>
        <div class="form-group">Email
        	<input type="email" class="form-control" name="user_email" value="<?= $row['user_email']; ?>" placeholder="Email" required="required">
        </div>
		<div class="form-group">Registered At
            <input type="date" class="form-control" name="registered_at" value="<?= date('Y-m-d', strtotime($row['created_at'])); ?>" disabled required="required">
        </div>
     <div class="form-group">Date Of Birth
            <input type="date" class="form-control" name="dob" value="<?= $row['date_of_birth']; ?>" required="required">
        </div>
		<div class="form-group"> Mobile No
            <input type="text" class="form-control" name="user_mobile" value="<?= $row['user_mobile']; ?>" placeholder="Mobile Number" required="required">
        </div>        
     <div class="form-group">
			<div class="row">
				<div class="col">
					Role : <span class="label-success label label-default"> <?= getRoleName($row['role_id']); ?></span></div>
				<div class="col">
					Status : 
					<?php
            if( $row['user_status'] == 1 ){
            ?>
                <span class="label-success btn-success label label-default" style="padding: 4px;">Approved</span>
            <?php
            } else {
            ?>
                <span class="label-warning btn-warning label label-default" style="padding: 4px;">Pending</span>
            <?php
            }
        ?>
				</div>
			</div>        	
    </div>
    <div class="form-group"> Gender : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="male">Male</label>
            <input type="radio" id="male" name="gender" <?= ($row['gender']=='male')?'checked':''; ?> value="male">
            <label for="female">Female</label>
            <input type="radio" id="female" name="gender" <?= ($row['gender']=='Female')?'checked':''; ?> value="Female">
        </div>  
    <div class="form-group"> Home Town : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name="home_town" value="<?= $row['city']; ?>" class="form-control">
    </div>

    <div class="form-group"> Address : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <textarea name="address" class="form-control"><?= $row['address']; ?></textarea>
    </div>  
     <div class="form-group"> Change Profile Image : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="file" name="profile" id="profile">
        </div>   
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" name="update_profile">Save</button>
        </div>
    </form>
</div>
</body>

<?php 
function getRoleName($role_id){
        if( $role_id == 1 ){
            return "Admin";
        } else if( $role_id == 2 ){
            return "Contributor";
        } else {
            return "User";
        }
    }
include 'include/footer.php';?>
</html>