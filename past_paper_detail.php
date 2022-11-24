<?php 
include 'include/head.php';
include 'DB.php';    
?>
<style type="text/css">
     .comment-scroll {
max-height:430px;
overflow-y:scroll;
}
.comments{
    border-top: 1px solid lightgray;
    border-bottom: 1px solid lightgray;
    padding: 8px;
}
</style>

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
                                <h2 class="bradcaump-title">Past-Paper Detail</h2>
                            <nav class="bradcaump-content">
                              <a class="breadcrumb_item" href="index.php">Home</a>
                              <span class="brd-separetor">/</span>
                              <span class="breadcrumb_item active">Detail</span>
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
                            $sql = "SELECT *, pp.`created_at` AS 'created' FROM past_papers pp INNER JOIN users ON pp.`added_by` = users.`user_id`  WHERE id = ".$id. " AND status !=2 ORDER BY created";
                            $result = $con->query($sql);
                            $row = $result->fetch_assoc();
                        ?>
                        <div class="blog-details content">
                            <article class="blog-post-details">
                                <div class="post_wrapper" style="border-bottom: 1px solid lightgray; margin-bottom: 18px;">
                                    <div class="post_header">
                                        <h2><?=$row['tittle'];?></h2>
                                        <div class="blog-date-categori">
                                            <ul>
                                                <li><?=date('d-m-Y',strtotime($row['created']));?></li>
                                                <li><?= $row['user_fname'].' '. $row['user_lname'];?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="post_content">
                                        <p><?=$row['description'];?></p>
                                    </div>
                                </div>
                                <div class="post-thumbnail">
                                    <a href="<?=$row['paper_image'];?>" download>
                                        <img src="<?=$row['paper_image'];?>" alt="blog images">
                                    </a>
                                </div>
                            </article>
                            <ul class="blog_meta comments">
                                <li> <strong>Comments </strong></li>
                            </ul>
                            <br>
                            <div class="comments_area comment-scroll">
                                <ul class="comment__list">
                                      <?php
                                        $comment_sql = "SELECT * ,paper_comments.`created_at` AS 'created_time' FROM paper_comments LEFT JOIN users ON paper_comments.`added_by` = users.`user_id`  WHERE paper_id = ".$id." AND status != 2 ORDER BY created_time";
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
                                                            <span><?=$comment_row['created_time'];?></span>
                                                            <div class="reply__btn">
                                                                <a href="logic.php?comment=<?=$comment_row['id'];?>&id=<?=$id;?>">Delete</a>
                                                            </div>
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
                                    <?php } ?>
                                    <input type="hidden" name="paper_id" value="<?=$id;?>">
                                    <input type="submit" class="submite__btn" name="paper_comment" value="Post Comment">
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