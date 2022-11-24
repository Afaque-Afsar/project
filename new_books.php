<?php 
if( !(isset( $_GET['slug'] ) && $_GET['slug'] != '') ){
    echo "<script>window.history.back();</script>";
}
$slug = $_GET['slug'];
include 'include/head.php';
include 'DB.php';    
?>

    <body>
        <div class="wrapper" id="wrapper">
        <?php 
                include 'include/header.php'; 
        ?>
        <div class="ht__bradcaump__area " style="padding-bottom: 0px; padding-top: 0px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title"><?= ucwords($slug); ?> Books</h2>
                            <nav class="bradcaump-content">
                              <a  style="color: #000;" class="breadcrumb_item" href="index.php">Home</a>
                              <span style="color: #000;"  class="brd-separetor">/</span>
                              <span class="breadcrumb_item active"><?= ucwords($slug); ?> Books</span>
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
                        <h2><?= ucwords($slug); ?> Books</h2>
                        Download <?= ucwords($slug); ?> Books for <?= ucwords($slug); ?> Compulsory & Optional Subjects.
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6 col-sm-12" style="border: 3px solid #f0f0f0; border-radius: 5px; padding: 10px;">
                        <h2><?= ucwords($slug); ?> Compulsory Books</h2><h4>Download <?= ucwords($slug); ?> Compulsory Books FREE</h4>
                        <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="compulsory_books.php?slug=<?= $slug; ?>" title="Optional Books">
                            <i class="vc_btn3-icon fa fa-download"></i> <?= ucwords($slug); ?> Compulsory Books
                        </a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-6 col-sm-12" style="border: 3px solid #f0f0f0; border-radius: 5px; padding: 10px;">
                        <h2><?= ucwords($slug); ?> Optional Books</h2><h4>Download <?= ucwords($slug); ?> Optional Books FREE</h4>
                        <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="optional_books.php?slug=<?= $slug; ?>" title="Optional Books">
                            <i class="vc_btn3-icon fa fa-download"></i> <?= ucwords($slug); ?> Optional Books
                        </a>
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