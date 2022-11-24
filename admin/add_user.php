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
        
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-plus"></i> Add User</h2>

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
          <form action="" id="add_user_form" method="post">
            <label><strong>First Name</strong></label>
                <input type="text" name="fname" id="first_name" class="form-control">
                <label><strong>Last Name</strong></label>
                <input type="text" name="lname" id="last_name" class="form-control">
                <label><strong>Email</strong></label>
                <input type="email" name="email" id="email" class="form-control"></input>
                <label><strong>Mobile</strong></label>
                <input type="text" name="mobile" id="mobile" max-length=11 class="form-control">
                <label><strong>Role</strong></label>
                <select class="form-control" id="role">
                    <option value="1">Admin</option>
                    <option value="2">Contributor</option>
                    <option value="3">User</option>
                </select>
                <label><strong>Password</strong></label>
                <input type="password" name="password" id="password" class="form-control">
                <label><strong>Status</strong></label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" id="status">
                  <label id="status_text"><span class="label-warning label label-default">Pending</span></label>
                </div>
                <button type="submit" class="btn btn-primary" id="add_user">Save changes</button>
          </form>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

<?php
    include_once 'includes/footer.php';
?>
<script>
    $(document).ready(function(){
        $(document).on('change', '#status', function(){
            if( $(this).prop('checked') ){
                $('#status_text').html('<span class="label-success label label-default">Active</span>');
            } else {
                $('#status_text').html('<span class="label-warning label label-default">Pending</span>');                    
            }
        });
        
        $(document).on('submit', '#add_user_form', function(e){
            e.preventDefault();
            $('#add_user').prop('disabled', true);
            var f_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            var password = $('#password').val();
            if( $('#status').prop('checked') ){
                var status = 1;
            } else {
                var status = 0;
            }
            var role = $('#role').val();
            
            if( f_name == '' || email == '' || mobile == '' || role == '' || password == '' ){
                alert('Some fields are empty');
            } else {
                $.ajax({
                    url:'ajaxservices/services.php',
                    type:'get',
                    data: {
                            type:'add_user', 
                            f_name:f_name, 
                            last_name:last_name,
                            email:email,
                            mobile:mobile,
                            status:status,
                            role:role,
                            password:password
                        },
                    success: function(response){
                        $('#add_user').prop('disabled', false);
                        if ( response == 'added' ) {
                            alert('User added successfully');
                            $("#add_user_form")[0].reset();
                        } else if ( response == 'not added' ) {
                            alert('User Not added, Please try again...');
                            
                        } else {
                            alert(response);
                        }
                    },
                    error: function(){
                        alert('internal error, please try again...');
                    }
                });
            }
        });
        
    });
</script>