<?php
    include('required/session_maintanance.php');
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
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');
?>