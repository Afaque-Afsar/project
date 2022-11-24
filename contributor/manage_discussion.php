<?php
    require_once('required/session_maintainance.php');
    $page_name = ' | Discussion';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');

    ?>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
            <?php
                $page = 1;
                $perPage = 10;
                if ( isset($_GET['page']) ) {
                    $page = $_GET['page']; 
                }
                $limit = ( ($page - 1) * $perPage );
                $sql = "SELECT * FROM discussion WHERE status != 2 AND added_by = ".$_SESSION['user']['user_id']." LIMIT $limit , $perPage";
                $res = $con->query($sql);
                if ( $res && $res->num_rows > 0 ) {
                    while( $row = $res->fetch_assoc() ){
                    ?>
                        <div class="row" style="margin: 5px;">
                            <div class="col-sm-12">
                                <div class="box-inner">
                                    <div class="box-header well">
                                        <?php
                                        if( $row['status'] == 1 ){
                                            ?>
                                            <span class="label-success label label-default">Approved</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="label-warning label label-default">Not Approved</span>
                                            <?php
                                        }
                                        ?>
                                        <a class="btn btn-setting btn-round btn-danger delete" data-id="<?= $row['id']; ?>" href="#"><i class="glyphicon glyphicon-trash"></i></a>
                                        <a href="edit_discussion.php?id=<?= $row['id']; ?>">Edit</a>
                                        <div class="box-icon">
                                            <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                    </div> 
                                    <div class="box-content row">
                                        <div class="col-sm-12">
                                            <h1>
                                                <small>
                                                    <a href="discussion_detail.php?id=<?= $row['id']; ?>"><?= $row['subject']; ?></a>
                                                </small>
                                            </h1>
                                            <div style="float: right; color:red;">
                                                
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <?= $row['discussion']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                ?>
                    <div class="alert alert-danger alert-dissmissible show" role="alert">
                        <strong>Oopss! </strong>No any discussion added yet
                    </div>
                <?php
                }

            ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        $total = 0;
                        // $perPage = 10;
                        $sqlCount = "SELECT COUNT(*) AS 'total' FROM discussion WHERE status != 2 AND added_by = ".$_SESSION['user']['user_id'];
                        $resCount = $con->query($sqlCount);
                        if ( $resCount && $resCount->num_rows > 0 ) {
                            $total = ceil($resCount->fetch_assoc()['total']/$perPage);
                        }
                        if( $total > 1 ){
                        ?>
                        <ul class="pagination pagination-centered">
                            <?php 
                                if ( $page == 1 ) {
                                    echo "<li class='disabled'><a>Prev</a></li>";
                                } else {
                                    echo "<li><a href='manage_discussion.php?page=".($page-1)."'>Prev</a></li>";
                                }
                                for ($i=1; $i <= $total; $i++ ) { 
                                ?>
                                    <li <?= is_active_page($i); ?>><a href="manage_discussion.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php
                                }
                                if ( $page == $total ) {
                                    echo "<li class='disabled'><a>Next</a></li>";
                                } else {
                                    echo "<li><a href='manage_discussion.php?page=".($page+1)."'>Next</a></li>";
                                }
                            ?>
                        </ul>
                        <?php
                        }
                    ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php

    include_once('includes/footer.php');

    function is_active_page( $page_no ){
        global $page;
        if ( $page == $page_no ) {
            return 'class="disabled"';
        }
    }
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('.delete').click(function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            if( confirm('Do you want to delete this discussion') ){
               var dis_id = $(this).data('id');
               $.ajax({
                url: "ajaxservices/ajax.php",
                type: "POST",
                data: { 'type':"delete_discussion", discussion_id:dis_id, user_id:"<?= $_SESSION['user']['user_id']; ?>" },
                success: function( response ){
                    if(response.includes('true')){
                        alert("Discussion Deleted Successfully, ");
                        location.reload();
                    } else {
                        alert("Discussion Not Deleted, Please Try Again...");
                    }
                    $(this).prop('disabled', false);
                },
                error: function(){
                    alert("Internal Error!...");
                },
                complete: function(){

                }
               });
            } 
            
        });
    });
</script>