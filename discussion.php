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
	        <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
	        	<div class="container">
	        		<div class="row">
	        			<div class="col-lg-12 col-12">
	        				<div class="blog-page">
	        					<!-- Start Single Post -->
	        						<?php
	        							 $page = 1;
	        							 $perPage = 10;
						                if ( isset($_GET['page']) ) {
						                    $page = $_GET['page']; 
						                }
						                $limit = ( ($page - 1) * $perPage );

	        							$discuss_sql = "SELECT * , discussion.`image_path` AS 'discuss_image' FROM discussion INNER JOIN users ON discussion.`added_by` = users.`user_id` WHERE status = 1 LIMIT $limit , $perPage ";
	        							$result = $con->query($discuss_sql);
	        							if ($result) {
	        								while ($row = $result->fetch_assoc()) {?>
					        					<article class="blog__post d-flex flex-wrap">
					        						<div class="thumb">
					        							<img src="<?=$row['discuss_image'];?>" alt="discussion images">
					        						</div>
					        						<div class="content">
					        							<h4><?=$row['subject'];?></h4>
					        							<ul class="post__meta">
					        								<li>Posts by : <?=$row['user_fname'];?> <?= $row['user_lname'];?></li>
					        								<li class="post_separator">/</li>
					        								<li><?=$row['created_at']; ?></li>
					        							</ul>
					        							<p><?=$row['discussion'];?></p>
					        							<div class="blog__btn">
					        								<a href="discussion-details.php?id=<?=$row['id'];?>">read more</a>
					        							</div>
					        						</div>
		        								</article>
	        				<?php		}
	        							}
	        						?>
	        				</div>
	        				<?php
                        $total = 0;
                        // $perPage = 10;
                        $sqlCount = "SELECT COUNT(*) AS 'total' FROM discussion WHERE status = 1";
                        $resCount = $con->query($sqlCount);
                        if ( $resCount && $resCount->num_rows > 0 ) {
                            $total = ceil($resCount->fetch_assoc()['total']/$perPage);
                        }
                        if( $total > 1 ){
                        ?>
                        <ul class="wn__pagination">
                            
                            <?php
                            	if ( $page == 1 ) {
                                    echo "<li class='disabled'><a>Prev</a></li>";
                                } else {
                                    echo "<li><a href='discussion.php?page=".($page-1)."'>Prev</a></li>";
                                }
                                for ($i=1; $i <= $total; $i++ ) { 
                                ?>
                                    <li <?= is_active_page($i); ?>><a href="discussion.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                                <?php
                                }
                                if ( $page == $total ) {
                                    echo "<li class='disabled'><a>Next</a></li>";
                                } else {
                                    echo "<li><a href='discussion.php?page=".($page+1)."'>Next</a></li>";
                                }
                            ?>
                        </ul>
                        <?php
                        }
                    ?>
	        			<!-- 	<ul class="wn__pagination">
	        					<li class="active"><a href="#">1</a></li>
	        					<li><a href="#">2</a></li>
	        					<li><a href="#">3</a></li>
	        					<li><a href="#">4</a></li>
	        					<li><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
	        				</ul> -->
	        			</div>
	        		</div>
	        	</div>
	        </div>
	        <?php 
				include 'include/bottom_footer.php'; 
				 function is_active_page( $page_no ){
        global $page;
        if ( $page == $page_no ) {
            return 'class="disabled"';
        }
    }
			?>

		</div>
		<?php include 'include/footer.php';?>
	
	</body>
</html>