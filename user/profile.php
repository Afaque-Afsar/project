<?php
    require_once('required/session_maintanance.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    include('../DB.php');
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

                   <!--  <div class="box-icon">
                        <a href="#" class="btn btn-setting btn-round btn-default"><i
                                class="glyphicon glyphicon-cog"></i></a>
                        <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                class="glyphicon glyphicon-chevron-up"></i></a>
                        <a href="#" class="btn btn-close btn-round btn-default"><i
                                class="glyphicon glyphicon-remove"></i></a>
                    </div> -->
                </div>
                <div class="box-content">
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                          <?php
                           // $sql = "SELECT * FROM users WHERE user_id = ".$_SESSION['user_id'];
                            $sql = "SELECT * FROM users WHERE user_id =17";
                            //echo '<pre>';

                            //print_r($_SESSION['user_id']); exit;
                            $result = $con->query($sql);
                            $rows = $result->fetch_assoc();

                          ?>
                        <tr>
                            <td>User Name</td>
                            <td class="center"><?= $rows['user_fname'];?> <?= $rows['user_lname'];?></td>
                            <td rowspan="6">
                                <img src="img/logo.png" width="50px" height="50px" class="center">
                            </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td class="center"><?= $rows['user_email'];?></td>
                        </tr>
                        <tr>
                            <td>Date Registered</td>
                            <td class="center"><?= date('Y/m/d', strtotime($rows['created_at']));?></td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td class="center">2012/03/01</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td class="center">Male</td>
                        </tr>
                        <tr>
                            <td>Home Town</td>
                            <td class="center">Hyderabad</td>
                        </tr>
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
    include_once('includes/footer.php');
    ?>