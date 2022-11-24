<?php
    // die();
    require_once('required/session_maintainance.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once("../DB.php");
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
            if( move_uploaded_file( $img['tmp_name'], "../uploads/user_images/".$fileName ) ){
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
    
?>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>User Profile</h2>

                    <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <table class="table table-bordered table-striped table-condensed">
                        <?php
                            $sql = "SELECT * FROM users WHERE user_id = ".$_SESSION['user']['user_id'];
                            $result = $con->query($sql);
                            if ($result) {
                                $row = $result->fetch_assoc();
                            } else {
                                echo "<script>window.location.reload();</script>";
                            }
                        ?>
                        <tbody>
                            <form method="POST" action="" enctype="multipart/form-data">
                                
                            <tr>
                                <td>First Name</td>
                                <td>
                                    <input type="text" name="user_fname" value="<?= $row['user_fname']; ?>" class="form-control">
                                </td>
                                <td rowspan="5">
                                    <img src="../uploads/user_images/<?= $row['image_path']; ?>" width="100px" height="100px" class="center">
                                    <label for="profile">Upload Image</label>
                                    <input type="file" name="profile" id="profile">
                                </td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td>
                                    <input type="text" name="user_lname" value="<?= $row['user_lname']; ?>" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td class="center">
                                    <input type="email" name="user_email" value="<?= $row['user_email']; ?>" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td class="center">
                                    <input type="text" name="user_mobile" value="<?= $row['user_mobile']; ?>" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Date Registered</td>
                                <td class="center">
                                    <input type="date" name="registered_at" disabled value="<?= date('Y-m-d', strtotime($row['created_at'])); ?>" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth</td>
                                <td class="center">
                                    <input type="date" name="dob" value="<?= $row['date_of_birth']; ?>" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td class="center">
                                    <label for="male">Male</label>
                                    <input type="radio" id="male" name="gender" <?= ($row['gender']=='male')?'checked':''; ?> value="male">
                                    <label for="female">Female</label>
                                    <input type="radio" id="female" name="gender" <?= ($row['gender']=='Female')?'checked':''; ?> value="Female">
                                </td>
                                <td class="center">
                                    <span>Status</span>
                                    <span class="label-warning label label-default">Pending</span>
                                </td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td class="center">
                                    <input type="text" name="home_town" value="<?= $row['city']; ?>" class="form-control">
                                </td>
                                <td class="center">
                                    <span>Role </span>
                                    <span class="label-success label label-default"> <?= getRoleName($row['role_id']); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td class="center" colspan="2">
                                    <textarea name="address" class="form-control"><?= $row['address']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="3">
                                    <button class="btn btn-sm btn-success center" type="submit" name="update_profile">Save</button>
                                </td>
                            </tr>
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
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
    
    include_once('includes/footer.php');
    