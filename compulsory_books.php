<?php 
if( !(isset( $_GET['slug'] ) && $_GET['slug'] != '') ){
    echo "<script>window.history.back();</script>";
}
include 'include/head.php';
include 'DB.php';    
?>
<style>
    .bradcaump-content a, .bradcaump-content span {
        color: #000 !important;
    }
    .bradcaump-content span.active {
        color: #e59285 !important;
    }
    .bradcaump-content a:hover {
        color: #e59285 !important;
    }
</style>
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
                                <h2 class="bradcaump-title"><?= ucwords($_GET['slug']); ?> Books</h2>
                            <nav class="bradcaump-content">
                              <a  style="color: #000;" class="breadcrumb_item" href="index.php">Home</a>
                              <span style="color: #000;"  class="brd-separetor">/</span>
                              <a class="breadcrumb_item" href="<?= $_GET['slug']; ?>_books.php"><?= ucwords($_GET['slug']); ?> Books</a>
								<span class="brd-separetor">/</span>
								<span class="breadcrumb_item active">Compulsory Books</span>
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
                        <h2>Compulsory Books</h2>
                        Download <?= ucwords($_GET['slug']); ?> Books for all compulsory subjects.
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 >English Precis & Composition </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-english-precis-composition-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
                            </div>
						</div>
					</div>
					<div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 ><?= ucwords($_GET['slug']); ?> Essay </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-essay-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
                            </div> 
						</div>
					</div>
					<div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 >Pakistan Affairs </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-pakistan-affairs-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
                            </div> 
						</div>
					</div>
					<div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 >General Science & Ability </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-general-science-and-ability-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
                            </div> 
						</div>
					</div>
					<div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 >Islamic Studies </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-islamic-studies-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
                            </div> 
						</div>
					</div>
					<div class="card book-style" style="width: 16rem; margin: 10px; border: 0px; text-align: center;">
						<div class="card-body "> 
							<div class="row">
                                <div class="col-sm-12" style=" border-radius: 5px; background-color: #dcdce0; margin: 0px; height: 10rem;  padding-top: 1rem;  ">
                                    <h3 >Current Affairs </h3><h4 >Books</h4>
                                    <a class="btn btn-size-md btn-shape-rounded btn-color-grey" href="books_compulsory_view.php?slug=<?= $_GET['slug']; ?>-current-affairs-books" title="Optional Books">
                                        <i class="vc_btn3-icon fa fa-download"></i> Check Books
                                    </a>
                                </div>
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