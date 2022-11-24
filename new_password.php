<?php
    session_start();
?>
<?php include 'include/head.php'; ?>
<body>
  <main id="main">
    <?php
        $id = $_GET['id'];
        $tmp = $_GET['tmp'];
        $email = $_GET['email'];
        require_once 'DB.php';
        $sql = "SELECT * FROM users WHERE user_email = '".$email."' AND tmp_field = $tmp ";
    	
    	$result = $con->query($sql);
    	
    	if( $result && $result->num_rows > 0 ){
    	    
    	} else {
    	    echo "<script>window.location.replace('login.php');</script>";
    	}
    	
        
    ?>
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <!-- <div class="col-md-4"></div> -->
          <div class="col-md-6 col-lg-4 mx-auto">
            <div class="card login">
              <article class="card-body">
                <h4 class="card-title text-center mb-2" style="margin-top: 2rem;"> Reset Password</h4>
                <hr>
               <form action="logic.php" method="POST">
                   <input type="hidden" name="user_id" value="<?=$id;?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <br>
                <button type="submit" name="password_update" class="btn btn-primary btn-block">Update Password</button>
                </div> <!-- form-group// -->
                </form>
              </article>
            </div> <!-- card.// -->
          </div>
          <!-- <div class="col-md-4"></div> -->
          </div>
        </div>
        
    </section><!-- End About Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->

  <?php include 'include/footer.php';?>
</body>

</html>