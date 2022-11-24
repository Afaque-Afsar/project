<?php
    require_once('required/session_maintanance.php');
    include_once('includes/header.php');
    include_once('includes/navbar.php');

    ?>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                 <ul class="breadcrumb">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                </ul>
                
                <div class="row">
                    <div class="box col-md-12">
                        <?php include('includes/success_error_message.php');?>
                    </div>
                </div
                <?php
                    $books = $users = $papers = $quiz = 0;
                    include_once('../DB.php');
                    $sql = "SELECT count(*) as book FROM books ";
                    $result = $con->query($sql);
                    if ($result && $result->num_rows > 0 ) {
                        $books = $result->fetch_assoc()['book'];
                    }
                    $sql = "SELECT count(*) as user FROM users ";
                    $result = $con->query($sql);
                    if ($result && $result->num_rows > 0 ) {
                        $users = $result->fetch_assoc()['user'];
                    }
                    $sql = "SELECT count(*) as papers FROM past_papers ";
                    $result = $con->query($sql);
                    if ($result && $result->num_rows > 0 ) {
                        $papers = $result->fetch_assoc()['papers'];
                    }
                    $sql = "SELECT count(*) as quiz FROM quiz_submit ";
                    $result = $con->query($sql);
                    if ($result && $result->num_rows > 0 ) {
                        $quiz = $result->fetch_assoc()['quiz'];
                    }
                ?>
                <div class=" row">
                    <div class="col-md-3 col-sm-12">
                        <a data-toggle="tooltip" title="Total Registered Users." class="well top-block" href="#">
                            <i class="glyphicon glyphicon-user blue"></i>
                
                            <div>Total Registered Users</div>
                            <div><?= $users; ?></div>
                        </a>
                    </div>
                
                    <div class="col-md-3 col-sm-12">
                        <a data-toggle="tooltip" title="Total Books Added." class="well top-block" href="#">
                            <i class="glyphicon glyphicon-star green"></i>
                
                            <div>Total Books Added</div>
                            <div><?= $books; ?></div>
                        </a>
                    </div>
                
                    <div class="col-md-3 col-sm-12">
                        <a data-toggle="tooltip" title="Total Papers Uploaded." class="well top-block" href="#">
                            <i class="glyphicon glyphicon-envelope yellow"></i>
                
                            <div>Total Papers Uploaded</div>
                            <div><?= $papers; ?></div>
                        </a>
                    </div>
                
                    <div class="col-md-3 col-sm-12">
                        <a data-toggle="tooltip" title="Total Quiz Attempted." class="well top-block" href="#">
                            <i class="glyphicon glyphicon-envelope red"></i>
                
                            <div>Total Quiz Attempted</div>
                            <div><?= $quiz; ?></div>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>
