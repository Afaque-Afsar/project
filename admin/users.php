<?php
    require_once('required/session_maintanance.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    include('../DB.php');
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
                <a href="dashboard.php">Home</a>
            </li>
            <li>
                <a href="#">Users</a>
            </li>
        </ul>
    </div>

    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Users List</h2>
    </div>
    <div class="box-content">
        <?php
            if ( isset($_POST['del_user']) ) {
                $user_id = $_POST['user_id'];
                if($con->query("UPDATE users SET user_status = 2 WHERE user_id = $user_id")){
                    $_SESSION['msg'] = "User DELETED successfully...";
                } else {
                    $_SESSION['msg'] = "User not DELETED, please try again...";
                }

                echo "<script>winow.location.replace(window.location.url);</script>";
            }
            // echo "<script>alert(window.location);</script>";
        ?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Date registered</th>
        <th>Role</th>
        <th>Status</th>
        <th>Actions</th>
        <!-- <th>Delete</th> -->
    </tr>
    </thead>
    <tbody>
    <?php
        $sql = "SELECT * FROM users WHERE user_status != 2 AND user_id != ".$_SESSION['user']['user_id'];
        
        $result = $con->query($sql);
        if ($result) {
            while ($rows = $result->fetch_assoc()) {?>
                 <tr>
                    <td><?=$rows['user_fname'].' '.$rows['user_lname'];?></td>
                    <td><?=$rows['user_email'];?></td>
                    <td><?=$rows['user_mobile'];?></td>
                    <td class="center"><?=$rows['created_at'];?></td>
                    <td>
                        <?php
                            if($rows['role_id'] == 1 ){
                                echo "Admin";
                            } else if($rows['role_id'] == 2 ){
                                echo "Contributor";
                            } else {
                                echo "User";
                            }
                        ?>
                    </td>
                    
                    <?php
                     if ($rows['user_status'] == 1) {?>
                            <td class="center">
                                <span class="label-success label label-default">Active</span>
                            </td>
                <?php }
                     else{?> 
                        <td class="center">
                            <span class="label-warning label label-default">Pending</span>
                        </td>
                <?php } ?>
                    <td class="center">
                        <!-- <a class="btn btn-success view" href="#"  data-id='<?= $rows["user_id"]; ?>'>
                            <i class="glyphicon glyphicon-zoom-in icon-white "></i>
                            View
                        </a> -->
                        <a class="btn btn-info edit" href="#" data-id='<?= $rows["user_id"]; ?>'>
                            <i class="glyphicon glyphicon-edit icon-white"></i>
                            Edit
                        </a>
                        <a class="btn btn-danger delete" href='#' data-id='<?= $rows["user_id"]; ?>'>
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                Delete
                            </a>
                        
                    </td>
                    <!-- <td class="center">
                        <form method="POST" action="">
                            <input type="hidden" name="user_id" value='<?= $rows["user_id"]; ?>'>
                            <button class="btn btn-danger delete" name="del_user" type="submit" href='#' data-id='<?= $rows["user_id"]; ?>'>
                                <i class="glyphicon glyphicon-trash icon-white"></i>
                                Delete
                            </button>
                        </form>
                        
                    </td> -->
                    </tr>
     <?php }
        }
    ?>
   
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->

    
    <hr>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>User Details</h3>
                </div>
                <div class="modal-body">
                    <input class='form-control' type="hidden" value="" id="user_id">
                    <table>
                        <tr>
                            <td>First Name</td>
                            <td>
                                <input class='form-control' type="text" name="first_name" value="" id="first_name">
                            </td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>
                                <input class='form-control' type="text" name="last_name" value="" id="last_name">
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>
                                <input class='form-control' type="email" name="email" value="" id="email">
                            </td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>
                                <input class='form-control' type="text" name="mobile" value="" id="mobile">
                            </td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td>
                                <select class='form-control' id="role">
                                    <option value="1">Admin</option>
                                    <option value="2">Contributor</option>
                                    <option value="3">User</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" id="status">
                                  <label id="status_text"></label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" id="edit_user">Save changes</a>
                </div>
            </div>
        </div>
    </div>
<?php
include_once 'includes/footer.php';
?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.view').click(function(){
                $('#myModal').modal('toggle');
            });

            $('.edit').click(function(){
                var user_id = $(this).attr('data-id');
                $.ajax({
                    url:'ajaxservices/services.php',
                    type:'get',
                    data: {user_id:user_id, type:'get_user_detail'},
                    success: function(response){
                        if(response.includes('status')){
                            var rspns = JSON.parse(response);
                            if( rspns.status == 'true' ){
                                $('#user_id').val(rspns.data[0].user_id);
                                $('#first_name').val(rspns.data[0].user_fname);
                                $('#last_name').val(rspns.data[0].user_lname);
                                $('#email').val(rspns.data[0].user_email);
                                $('#mobile').val(rspns.data[0].user_mobile);
                                $('#role option[value="'+rspns.data[0].role_id+'"]').prop("selected", true);
                                if( rspns.data[0].user_status == 1 ){
                                    $('#status').prop('checked', true);
                                    $('#status_text').html('<span class="label-success label label-default">Active</span>');
                                } else {
                                    $('#status').prop('checked', false);
                                    $('#status_text').html('<span class="label-warning label label-default">Pending</span>');
                                }
                                // $('#first_name').val(rspns.data['user_']);
                                // $('#first_name').val(rspns.data['user_fname']);
                                // $('#first_name').val(rspns.data['user_fname']);
                                $('#myModal').modal('toggle');
                            } else {
                                alert("user details not foun.");
                            }
                        } else {
                            alert('internal error, please try again...');
                        }
                    },
                    error: function(){
                        alert('internal error, please try again...');
                    }
                });
                // 
            });

            $(document).on('click', '#edit_user', function(){
                var f_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var email = $('#email').val();
                var mobile = $('#mobile').val();
                if( $('#status').prop('checked') ){
                    var status = 1;
                } else {
                    var status = 0;
                }
                var role = $('#role').val();
                var user_id = $('#user_id').val();
                
                if( f_name == '' || email == '' || mobile == '' || role == '' || user_id == '' ){
                    alert('Some fields are empty');
                } else {
                    $.ajax({
                        url:'ajaxservices/services.php',
                        type:'get',
                        data: {
                                type:'edit_user', 
                                f_name:f_name, 
                                last_name:last_name,
                                email:email,
                                mobile:mobile,
                                status:status,
                                role:role,
                                user_id: user_id
                            },
                        success: function(response){
                            if ( response == 'edited' ) {
                                alert('User edited successfully');
                                location.reload();
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

            $('.delete').click(function(){
                var cnfrm = confirm('Are you sure, you want to delete this user?');
                if( cnfrm ){
                    var user_id = $(this).attr('data-id');
                    $.ajax({
                        url:'ajaxservices/services.php',
                        type:'get',
                        data: {user_id:user_id, type:'delete_user'},
                        success: function(response){
                            if ( response == 'deleted' ) {
                                alert('User deleted successfully');
                                location.reload();
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

            $(document).on('change', '#status', function(){
                if( $(this).prop('checked') ){
                    $('#status_text').html('<span class="label-success label label-default">Active</span>');
                } else {
                    $('#status_text').html('<span class="label-warning label label-default">Pending</span>');                    
                }
            });



            

            
        });
    </script>

</body>
</html>
