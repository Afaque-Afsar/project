<?php 
include 'include/head.php';
include 'DB.php';    
?>

    <body>
        <div class="wrapper" id="wrapper">
        <?php 
                include 'include/header.php'; 
        ?>
        <div class="ht__bradcaump__area bg-image--4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Discussion Page</h2>
                            <nav class="bradcaump-content">
                              <a class="breadcrumb_item" href="index.php">Home</a>
                              <span class="brd-separetor">/</span>
                              <span class="breadcrumb_item active">Discussion</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-blog-details section-padding--lg bg--white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <?php
                        include 'include/success_error_message.php';
                            $id = $_GET['id'];
                            $sql = "SELECT * FROM discussion WHERE id = ".$id;
                            $result = $con->query($sql);
                            $row = $result->fetch_assoc();
                        ?>
                        <div class="blog-details content">
                            <article class="blog-post-details">
                                <div class="post-thumbnail">
                                    <img src="<?=$row['image_path'];?>" alt="blog images">
                                </div>
                                <div class="post_wrapper">
                                    <div class="post_header">
                                        <h2><?=$row['subject'];?></h2>
                                        <div class="blog-date-categori">
                                            <ul>
                                                <li><?=date('d-m-Y',strtotime($row['created_at']));?></li>
                                                <li><a href="#" title="Posts by boighor" rel="author">Author</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post_content">
                                        <p><?=$row['discussion'];?></p>
                                    </div>
                                    <ul class="blog_meta">
                                        <li> <strong>Comments </strong></li>
                                    </ul>
                                </div>
                            </article>
                            <div class="comments_area">
                                <ul class="comment__list">
                                      <?php
                                        $comment_sql = "SELECT * FROM comments INNER JOIN users ON comments.`added_by` = users.`user_id` WHERE status = 1 AND discussion_id = ".$id;
                                        $res = $con->query($comment_sql);
                                        if ($res) {
                                          while ($comment_row = $res->fetch_assoc()) {?>
                                            <li>
                                                <div class="wn__comment">
                                                    <div class="thumb">
                                                        <img src="images/blog/comment/1.jpeg" alt="comment images">
                                                    </div>
                                                    <div class="content">
                                                        <div class="comnt__author d-block d-sm-flex">
                                                            <span><?=$comment_row['user_fname'];?> <?=$comment_row['user_lname'];?></span>
                                                            <span><?=$comment_row['created_at'];?></span>
                                                            <?php 
                                                            if ( isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id'] == $comment_row['added_by'] ) {
                                                            ?>
                                                            <div class="reply__btn">
                                                                <a href="logic.php?comment=<?=$comment_row['id'];?>&id=<?=$id;?>">Delete</a>
                                                            </div>
                                                            <?php  
                                                            }
                                                             ?>
                                                        </div>
                                                        <p><?=$comment_row['comment'];?></p>
                                                    </div>
                                                </div>
                                            </li>
                                   <?php  }
                                        }
                                      ?>
                                </ul>
                            </div>
                            <div class="comment_respond">
                                <form class="comment__form" action="logic.php" method="post">
                                    <?php
                                        if ((isset($_SESSION['user']['user_id'])) == '') {?>
                                        <div class="input__box">
                                            <textarea name="comment" placeholder="Please Login First" readonly></textarea>
                                        </div>
                                            
                                  <?php } else {
                                    ?>
                                        <div class="input__box">
                                            <textarea name="comment" placeholder="Your comment here"></textarea>
                                        </div>
                                        <input type="hidden" name="discussion_id" value="<?=$id;?>">
                                        <input type="submit" class="submite__btn" name="post_comment" value="Post Comment">
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            include 'include/bottom_footer.php'; 
        ?>

        </div>
        <?php include 'include/footer.php';?>
    
    </body>
</html>