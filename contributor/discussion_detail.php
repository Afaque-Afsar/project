<?php
    require_once('required/session_maintainance.php');
    $page_name = ' | Discussion Detail';
    include_once('includes/header.php');
    include_once('includes/navbar.php');
    require_once('../DB.php');
    if( !isset( $_GET['id'] ) ){
        header('location:manage_discussion.php');
    }

    $sql = "SELECT * FROM discussion WHERE status != 2 AND added_by = ".$_SESSION['user']['user_id']." AND id = ".$_GET['id'];
    $res = $con->query($sql);
    if ( !($res && $res->num_rows > 0) ) {
        echo "<script>alert('Details Not Found, Or this discussion not belongs to you!...');</script>";
        echo "<script>window.history.back();</script>";
    }

    if( isset( $_GET['id'] ) && isset( $_GET['del'] ) && $_GET['del'] === 'yes' && $_GET['id'] != '' ){
        $sql = "UPDATE comments SET status = 2 WHERE id = ".$_GET['comment'];
        if( $con->query( $sql ) ){
            echo "<script>alert('Comment Deleted Successfully');</script>";
        } else {
            echo "<script>alert('Comment Not Deleted, Please Try Again!...');</script>";
        }
        echo "<script>window.location.replace('discussion_detail.php?id=".$_GET['id']."');</script>";
    }

    if( isset( $_GET['id'] ) && isset( $_GET['status'] ) && isset( $_GET['cid'] ) && $_GET['status'] != '' && $_GET['id'] != '' ){
        if( $_GET['status'] == 'disap' ){
            $status = 0;
        } else {
            $status = 1;
        }
        $sql = "UPDATE comments SET status = $status WHERE id = ".$_GET['cid'];
        if( $con->query( $sql ) ){
            echo "<script>alert('Comment Updated Successfully');</script>";
        } else {
            echo "<script>alert('Comment Not Updated, Please Try Again!...');</script>";
        }
        echo "<script>window.location.replace('discussion_detail.php?id=".$_GET['id']."');</script>";
    }

    $id = $_GET['id'];
    ?>
    <div class="ch-container">
        <div class="row">
            <!-- left menu starts -->
            <div class="col-sm-2 col-lg-2">
                <?php include_once('includes/sidebar.php'); ?>
            </div>
            <div id="content" class="col-lg-10 col-sm-10">
                <a class="btn btn-sm btn-warning" href="manage_discussion.php"> Back</a><br><br>
            <?php
                
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
                        <div class="row">
                            <div class="box col-md-12">
                                <div class="box-inner">
                                    <div class="box-header well" data-original-title="">
                                        <h2><i class="glyphicon glyphicon-user"></i> Member Activity</h2>
                                        <div class="box-icon">
                                        <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                        <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                                        </div>
                                    </div>
                                    <div class="box-content">
                                        <div class="box-content">
                                            <ul class="dashboard-list">
                                            <?php
                                            $comment_sql = "SELECT * FROM comments INNER JOIN users ON comments.`added_by` = users.`user_id` WHERE status != 2 AND discussion_id = ".$_GET['id'];
                                            $res = $con->query($comment_sql);
                                            if ($res) {
                                              while ($comment_row = $res->fetch_assoc()) {?>
                                                <li>
                                                    <a href="#">
                                                    <img class="dashboard-avatar" alt="Usman" src="../images/blog/comment/1.jpeg?s=50"></a>
                                                    <a href="#">
                                                        <?=$comment_row['user_fname']." ".$comment_row['user_lname'];?> : 
                                                        At : <?=$comment_row['created_at'];?>
                                                        <?php
                                                            if ( $comment_row['status'] == 1) {
                                                                echo '<span class="label-success label label-default" style="font-size: 11px;">Approved</span>';
                                                            } else {
                                                                echo '<span class="label-danger label label-default" style="font-size: 11px;">Not Approved</span>';
                                                            }
                                                        ?>
                                                    </a>
                                                    <br>
                                                    <strong style="float: right;">
                                                        <a style="color: red;" href="discussion_detail.php?comment=<?=$comment_row['id'];?>&del=yes&id=<?=$id;?>">Delete</a>
                                                        <?php
                                                            if ( $comment_row['status'] == 1) {
                                                                echo '<a style="color: blue;" href="discussion_detail.php?status=disap&cid='.$comment_row['id'].'&id='.$id.'">Un Approve</a>';
                                                            } else {
                                                                echo '<a style="color: blue;" href="discussion_detail.php?status=app&cid='.$comment_row['id'].'&id='.$id.'">Approve</a>';
                                                            }
                                                        ?>
                                                    </strong>
                                                    <br>
                                                    <strong><?=$comment_row['comment'];?></strong> 
                                                    
                                                    
                                                </li>
                                       <?php  }
                                       ?>
                                       <div class="comment_respond">
                                            <p><b>Reply</b></p>
                                            <form class="comment__form" action="logic.php" method="post">
                                                <?php
                                                    if ((isset($_SESSION['user']['user_id'])) == '') {?>
                                                    <div class="input__box">
                                                        <textarea name="comment" placeholder="Please Login First" readonly></textarea>
                                                    </div>
                                                        
                                              <?php } else {
                                                ?>
                                                    <div class="input__box">
                                                        <textarea name="comment" class="form-control" placeholder="Your Comment here"></textarea>
                                                    </div>
                                                    <input type="hidden" name="discussion_id" value="<?=$id;?>">
                                                    <br>
                                                    <input class="btn btn-success" type="submit" class="submite__btn" name="post_comment" value="Post Comment">
                                                <?php } ?>
                                            </form>
                                        </div>
                                       <?php
                                            }
                                          ?>
                                            </ul>
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
                        <strong>Oopss! </strong>No discussion found OR this discussion is not belongs to you...
                    </div>
                <?php
                }

            ?>
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
