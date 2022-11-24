<?php 
session_start();

if (isset($_SESSION['user']['user_id'])) {
	if( $_SESSION['user']['role_id'] == 1 ){
		header('location:admin/dashboard.php');
	} else if( $_SESSION['user']['role_id'] == 2 ){
		header('location:contributor/dashboard.php');
	} else if( $_SESSION['user']['role_id'] == 3 ){
		header('location:user/dashboard.php');
	}
  // header("location: index.php");
}

include ('include/head.php');
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
	width: 400px;
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
.signup-form a {
	color: #fff;
	text-decoration: underline;
}
.signup-form a:hover {
	text-decoration: none;
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
    width: 100%;}
}
</style>
</head>
<body>
<div class="wrapper" id="wrapper">
<?php include 'include/header.php';?>
<div class="row">
    <div class="col-sm-12">
<div class="signup-form">
    <form action="logic.php" method="post">
    	<?php include 'include/success_error_message.php'?>
		<h2>Sign In</h2>
		<hr>
        <div class="form-group">
        	<input type="email" class="form-control" name="email" placeholder="Email" required="required">
        </div>
		<div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
		      
        
		<div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg form-control" name="login">Log In</button>
        </div>
        <hr>
        <p class="text-center hint-text"><a href="#forget" data-toggle="modal">Forgot password?</a></p>
    </form>
	<div class="hint-text">Not Registered? <a href="register.php">Create an Account</a></div>
</div>
        
    </div>
</div>

 <!-- Forget Password -->
<div id="forget" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="color:black;">Password Reset</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form  method="post" action="logic.php" >
        <div class="modal-body">
          <label style="color:black;">Email</label>
          <input type="email" name="email" class="form-control" style="color:black;" placeholder="Enter Email Address">
        </div>
        <div class="modal-footer">
          <button type="submit" name="forget_pass" class="btn btn-success btn-sm">Submit</button>
        </div>

      </form>
    </div>
  </div>
</div>   <!-- End Forget Password Modal -->
</div>
<?php include 'include/footer.php';?>
</body>
</html>