<?php
    require_once('required/session_maintanance.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    include_once('../DB.php');
?>
<div class="ch-container">
    <div class="row">
        <div class="col-sm-2 col-lg-2">
            <?php include_once('includes/sidebar.php'); ?>
        </div> 

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
                <div>
        <ul class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Categories</a>
            </li>
        </ul>
    </div>

    <div class="row">
    <div class="box col-md-12">
    <?php include('includes/success_error_message.php');?>
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-plus"></i> Add Category</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <form action="logic.php" method="post">
            <label>Category Tittle</label>
            <input type="text" name="tittle" class="form-control" placeholder="Enter Category tittle">
            <div class="text-center ">
              <input type="submit" name="add_category" class="btn btn-success" value="Add" style="margin-top: 18px;">
            </div>
          </form>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

      <!-- Edit student MODAL -->
<div id="edit_user" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form  method="post" action="logic.php">

        <div class="modal-body">
          <input type="hidden" name="user_id" id="user_id" class="form-control">
          <label><strong>First Name</strong></label>
          <input type="text" name="fname" id="fname" class="form-control">
          <label><strong>Last Name</strong></label>
          <input type="text" name="lname" id="lname" class="form-control">
          <label><strong>Email</strong></label>
          <input type="email" name="email" id="email" class="form-control"></input>
          <label><strong>Mobile</strong></label>
          <input type="text" name="mobile" id="mobile" max-length=11 class="form-control">
          
        </div>
        <div class="modal-footer">    
          <button type="submit" name="update_user" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Student Modal -->


<?php
    include_once 'includes/footer.php';
?>
    <script type="text/javascript">
    $(document).on("click", ".edit-user", function () {
        var user_id = $(this).data('id');
        var fname = $(this).data('fname');
        var lname = $(this).data('lname');
        var email = $(this).data('email');
        var mobile = $(this).data('mobile');
        
        $(".modal-body input[type='hidden']").val(user_id);
        $(".modal-body #fname").val(fname);
        $(".modal-body #lname").val(lname);
        $(".modal-body #email").val(email);
        $(".modal-body #mobile").val(mobile);
});
    </script>