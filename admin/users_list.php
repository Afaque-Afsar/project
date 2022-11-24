<?php
session_start();
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
                <a href="#">Users</a>
            </li>
        </ul>
    </div>
    <?php include_once('includes/success_error_message.php');?>

    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> All Users</h2>

        <div class="box-icon">
            <a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
            <a href="#" class="btn btn-minimize btn-round btn-default"><i
                    class="glyphicon glyphicon-chevron-up"></i></a>
            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
    <div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>Username</th>
        <th>Date registered</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM users WHERE role_id = 3";
            $result = $con->query($sql);
            if ($result) {
                while ($row = $result->fetch_assoc()) { ?>
                   <tr>
                       <td class="center"><?= $row['user_fname'];?> <?= $row['user_lname']; ?></td>
                       <td class="center"><?= $row['created_at']; ?></td>
                       <?php
                        if ($row['user_status'] == 1) {
                            echo "<td class='center'><span class='label-success label label-default'>Approve</span></td>";
                        }
                        else{
                            echo "<td class='center'><span class='label-warning label label-default'>Pending</span></td>";
                        }
                       ?>
                       <td class="center">
                             <a class="btn btn-success" href="#">
                                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                                View
                            </a>
                            <a class="btn btn-info edit-user" href="#edit_user" data-toggle="modal" data-id="<?=$row['user_id'];?>" data-fname="<?=$row['user_fname'];?>" data-lname="<?=$row['user_lname'];?>" data-email="<?=$row['user_email']?>" data-mobile="<?=$row['user_mobile'];?>">
                                <i class="glyphicon glyphicon-edit icon-white"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger" href="#">
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                Delete
                            </a>
                        </td>
                   </tr> 
        <?php   }
            }
        ?>
   
    </tbody>
    </table>
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