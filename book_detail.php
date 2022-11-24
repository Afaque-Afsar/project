<?php 
include 'include/head.php';
include 'DB.php';    
?>

    <body>
        <div class="wrapper" id="wrapper">
        <?php 
                include 'include/header.php'; 
        ?>
        <div class="ht__bradcaump__area bg-image--11">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Book Detail</h2>
                            <nav class="bradcaump-content">
                              <a class="breadcrumb_item" href="index.php">Home</a>
                              <span class="brd-separetor">/</span>
                              <span class="breadcrumb_item active">Book Detail</span>
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
                            $sql = "SELECT * FROM books WHERE id = ".$id;
                            $result = $con->query($sql);
                            $row = $result->fetch_assoc();
                        ?>
                        <div class="blog-details content">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="<?=$row['cover_image'];?>" class="img-fluid float-right" alt="blog images">
                                </div>
                                <div class="col-md-9 mt-4">
                                    <h2><?=$row['tittle'];?></h2>
                                    <p><?=$row['description'];?></p>
                                    <a href="<?=$row['book_pdf'];?>" class="btn btn-primary btn-sm mt-3" target="_blank">View</a>
                                    <a href="<?=$row['book_pdf'];?>" class="btn btn-success btn-sm mt-3" download>Download</a>
                                </div>
                            </div>
                           <!--  <article class="blog-post-details">
                                <div class="post-thumbnail">
                                    <img src="<?=$row['cover_image'];?>" alt="blog images">
                                </div>
                                <div class="post_wrapper">
                                    <div class="post_header">
                                        <h2><?=$row['tittle'];?></h2>
                                    </div>
                                    <div class="post_content">
                                        <p><?=$row['description'];?></p>
                                    </div>
                                </div>
                            </article> -->
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