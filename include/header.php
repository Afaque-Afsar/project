<?php
require_once('DB.php');
error_reporting(0);
session_start();

function create_categories_li( $categories_array, $link ){
    $return = '';
    foreach( $categories_array as $category ){
        $return .= '<li><a href="'.$link.'?id='.$category['id'].'">'.$category['tittle'].'</a></li>';
    }
    return $return;
}

?>
<header id="wn__header" class="header__area header__absolute sticky__header">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-6 col-lg-2">
				<div class="logo">
					<a href="index.php">
						<img src="images/logo/logo.png" alt="logo images" style="height: 50px;">
					</a>
				</div>
			</div>
			<div class="col-lg-8 d-none d-lg-block">
				<nav class="mainmenu__nav">
					<ul class="meninmenu d-flex justify-content-start">
						<li class="drop with--one--item"><a href="index.php">Home</a></li>
						<li class="drop"><a href="discussion.php">Discussion</a>
						<li class="drop"><a href="#">Study Material</a>
							<div class="megamenu dropdown">
								<ul class="item item01">
									<!--<li><a href="tips.php">Tips/Reviews</a></li>-->
									<li class="label2"><a href="#">Material</a>
										<ul>
											<?php
											$cat_sql = "SELECT * FROM material_categories WHERE status = 1";
											$result = $con->query($cat_sql);
											$categories_array = [];
											if ($result) {
												while ($rows = $result->fetch_assoc()) {
												    $categories_array[] = $rows;
												}
											}
                                            echo create_categories_li( $categories_array, 'material.php' );
											?>
										</ul>
									</li>
									<!--<li class="label2"><a href="#">Books</a>
										<ul>
											<?php
											//echo create_categories_li( $categories_array, 'books.php' );
											
											?>
										</ul>
									</li>-->
									<li class="label2"><a href="#">Quiz</a>
										<ul>
										    <li><a href="quiz_category.php">All</a></li>
											<?php
											echo create_categories_li( $categories_array, 'quiz_category.php' );
											?>
										</ul>
								    </li>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="#">Books</a>
							<div class="megamenu dropdown">
								<ul class="item item01">
								    <?php
    								    foreach( $categories_array as $category ){
    								        if( $category['tittle'] == 'CSS' ){
    								            ?>
            								        <li class="label2"><a href="new_books.php?slug=css"><?=$category['tittle'];?></a>
                										<ul>
                										    <li><a href="compulsory_books.php?slug=css">Compulsory Subjects</a></li>
                										    <li><a href="optional_books.php?slug=css">Optional Subjects</a></li>
                										</ul>
                								    </li>
            								    <?php
    								        } else if( $category['tittle'] == 'PCS' ){
    								            ?>
            								        <li class="label2"><a href="new_books.php?slug=pcs"><?=$category['tittle'];?></a>
                										<ul>
                										    <li><a href="compulsory_books.php?slug=pcs">Compulsory Subjects</a></li>
                										    <li><a href="optional_books.php?slug=pcs">Optional Subjects</a></li>
                										</ul>
                								    </li>
            								    <?php
    								        } else if( $category['tittle'] == 'PMS' ){
    								            ?>
            								        <li class="label2"><a href="new_books.php?slug=pms"><?=$category['tittle'];?></a>
                										<ul>
                										    <li><a href="compulsory_books.php?slug=pms">Compulsory Subjects</a></li>
                										    <li><a href="optional_books.php?slug=pms">Optional Subjects</a></li>
                										</ul>
                								    </li>
            								    <?php
    								        } else if( $category['tittle'] == 'TOFIL' ){
    								            ?>
            								        <li class="label2"><a href="#"><?=$category['tittle'];?></a>
                										<ul>
                										    <li><a href="sections_wise_books.php?slug=tofil-listening">Listening</a></li>
                										    <li><a href="sections_wise_books.php?slug=tofil-reading">Reading</a></li>
                										    <li><a href="sections_wise_books.php?slug=tofil-writing">Writing</a></li>
                										    <li><a href="sections_wise_books.php?slug=tofil-speaking">Speaking</a></li>
                										</ul>
                								    </li>
            								    <?php
    								        } else if( $category['tittle'] == 'IELTS' ){
    								            ?>
            								        <li class="label2"><a href="#"><?=$category['tittle'];?></a>
                										<ul>
                										    <li><a href="sections_wise_books.php?slug=ielts-listening">Listening</a></li>
                										    <li><a href="sections_wise_books.php?slug=ielts-reading">Reading</a></li>
                										    <li><a href="sections_wise_books.php?slug=ielts-writing">Writing</a></li>
                										    <li><a href="sections_wise_books.php?slug=ielts-speaking">Speaking</a></li>
                										</ul>
                								    </li>
            								    <?php
    								        } else{
    								            echo '<li><a href="books.php?id='.$category['id'].'">'.$category['tittle'].'</a></li>';
    								        }
    								    
                                        }
									?>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="#">Past Papers</a>
								<div class="megamenu dropdown">
									<ul class="item item01">
									    <li><a href="past_paper_category.php">All</a></li>	
										<?php
										    echo create_categories_li( $categories_array, 'past_paper_category.php' );
										?>
									</ul>
								</div>
							</li>
					<!-- 	<li class="drop"><a href="#">Shop</a>
							<div class="megamenu mega03">
								<ul class="item item03">
									<li class="title">Shop Layout</li>
									<li><a href="shop-grid.php">Shop Grid</a></li>
									<li><a href="single-product.php">Single Product</a></li>
								</ul>
								<ul class="item item03">
									<li class="title">Shop Page</li>
									<li><a href="my-account.php">My Account</a></li>
									<li><a href="cart.php">Cart Page</a></li>
									<li><a href="checkout.php">Checkout Page</a></li>
									<li><a href="wishlist.php">Wishlist Page</a></li>
									<li><a href="error404.php">404 Page</a></li>
									<li><a href="faq.php">Faq Page</a></li>
								</ul>
								<ul class="item item03">
									<li class="title">Bargain Books</li>
									<li><a href="shop-grid.php">Bargain Bestsellers</a></li>
									<li><a href="shop-grid.php">Activity Kits</a></li>
									<li><a href="shop-grid.php">B&N Classics</a></li>
									<li><a href="shop-grid.php">Books Under $5</a></li>
									<li><a href="shop-grid.php">Bargain Books</a></li>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="shop-grid.php">Books</a>
							<div class="megamenu mega03">
								<ul class="item item03">
									<li class="title">Categories</li>
									<li><a href="shop-grid.php">Biography </a></li>
									<li><a href="shop-grid.php">Business </a></li>
									<li><a href="shop-grid.php">Cookbooks </a></li>
									<li><a href="shop-grid.php">Health & Fitness </a></li>
									<li><a href="shop-grid.php">History </a></li>
								</ul>
								<ul class="item item03">
									<li class="title">Customer Favourite</li>
									<li><a href="shop-grid.php">Mystery</a></li>
									<li><a href="shop-grid.php">Religion & Inspiration</a></li>
									<li><a href="shop-grid.php">Romance</a></li>
									<li><a href="shop-grid.php">Fiction/Fantasy</a></li>
									<li><a href="shop-grid.php">Sleeveless</a></li>
								</ul>
								<ul class="item item03">
									<li class="title">Collections</li>
									<li><a href="shop-grid.php">Science </a></li>
									<li><a href="shop-grid.php">Fiction/Fantasy</a></li>
									<li><a href="shop-grid.php">Self-Improvemen</a></li>
									<li><a href="shop-grid.php">Home & Garden</a></li>
									<li><a href="shop-grid.php">Humor Books</a></li>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="shop-grid.php">Kids</a>
							<div class="megamenu mega02">
								<ul class="item item02">
									<li class="title">Top Collections</li>
									<li><a href="shop-grid.php">American Girl</a></li>
									<li><a href="shop-grid.php">Diary Wimpy Kid</a></li>
									<li><a href="shop-grid.php">Finding Dory</a></li>
									<li><a href="shop-grid.php">Harry Potter</a></li>
									<li><a href="shop-grid.php">Land of Stories</a></li>
								</ul>
								<ul class="item item02">
									<li class="title">More For Kids</li>
									<li><a href="shop-grid.php">B&N Educators</a></li>
									<li><a href="shop-grid.php">B&N Kids' Club</a></li>
									<li><a href="shop-grid.php">Kids' Music</a></li>
									<li><a href="shop-grid.php">Toys & Games</a></li>
									<li><a href="shop-grid.php">Hoodies</a></li>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="#">Pages</a>
							<div class="megamenu dropdown">
								<ul class="item item01">
									<li><a href="about.php">About Page</a></li>
									<li class="label2"><a href="portfolio.php">Portfolio</a>
										<ul>
											<li><a href="portfolio.php">Portfolio</a></li>
											<li><a href="portfolio-details.php">Portfolio Details</a></li>
										</ul>
									</li>
									<li><a href="my-account.php">My Account</a></li>
									<li><a href="cart.php">Cart Page</a></li>
									<li><a href="checkout.php">Checkout Page</a></li>
									<li><a href="wishlist.php">Wishlist Page</a></li>
									<li><a href="error404.php">404 Page</a></li>
									<li><a href="faq.php">Faq Page</a></li>
									<li><a href="team.php">Team Page</a></li>
								</ul>
							</div>
						</li>
						<li class="drop"><a href="blog.php">Blog</a>
							<div class="megamenu dropdown">
								<ul class="item item01">
									<li><a href="blog.html">Blog Page</a></li>
									<li><a href="blog-details.html">Blog Details</a></li>
								</ul>
							</div>
						</li> -->
						<!-- <li><a href="contact.php">Contact</a></li> -->
					</ul>
				</nav>
			</div>
			<div class="col-md-6 col-sm-6 col-6 col-lg-2">
				<ul class="header__sidebar__right d-flex justify-content-end align-items-center">
					 <li class="shop_search"><a class="search__active" href="#"></a></li>
						<!--<li class="wishlist"><a href="#"></a></li> -->
						<!-- <li class="shopcart"><a class="cartbox_active" href="#"><span class="product_qun">3</span></a> -->
							<!-- Start Shopping Cart -->
						<!-- <div class="block-minicart minicart__active">
							<div class="minicart-content-wrapper">
								<div class="micart__close">
									<span>close</span>
								</div>
								<div class="items-total d-flex justify-content-between">
									<span>3 items</span>
									<span>Cart Subtotal</span>
								</div>
								<div class="total_amount text-right">
									<span>$66.00</span>
								</div>
								<div class="mini_action checkout">
									<a class="checkout__btn" href="cart.html">Go to Checkout</a>
								</div>
								<div class="single__items">
									<div class="miniproduct">
										<div class="item01 d-flex">
											<div class="thumb">
												<a href="product-details.html"><img src="images/product/sm-img/1.jpg" alt="product images"></a>
											</div>
											<div class="content">
												<h6><a href="product-details.html">Voyage Yoga Bag</a></h6>
												<span class="prize">$30.00</span>
												<div class="product_prize d-flex justify-content-between">
													<span class="qun">Qty: 01</span>
													<ul class="d-flex justify-content-end">
														<li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
														<li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="item01 d-flex mt--20">
											<div class="thumb">
												<a href="product-details.html"><img src="images/product/sm-img/3.jpg" alt="product images"></a>
											</div>
											<div class="content">
												<h6><a href="product-details.html">Impulse Duffle</a></h6>
												<span class="prize">$40.00</span>
												<div class="product_prize d-flex justify-content-between">
													<span class="qun">Qty: 03</span>
													<ul class="d-flex justify-content-end">
														<li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
														<li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="item01 d-flex mt--20">
											<div class="thumb">
												<a href="product-details.html"><img src="images/product/sm-img/2.jpg" alt="product images"></a>
											</div>
											<div class="content">
												<h6><a href="product-details.html">Compete Track Tote</a></h6>
												<span class="prize">$40.00</span>
												<div class="product_prize d-flex justify-content-between">
													<span class="qun">Qty: 03</span>
													<ul class="d-flex justify-content-end">
														<li><a href="#"><i class="zmdi zmdi-settings"></i></a></li>
														<li><a href="#"><i class="zmdi zmdi-delete"></i></a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="mini_action cart">
									<a class="cart__btn" href="cart.html">View and edit cart</a>
								</div>
							</div>
						</div> -->
						<!-- End Shopping Cart -->
						<!-- </li> -->
						<li class="setting__bar__icon"><a class="setting__active" href="#"></a>
							<div class="searchbar__content setting__block">
								<div class="content-inner">
								<!-- <div class="switcher-currency">
									<strong class="label switcher-label">
										<span>Currency</span>
									</strong>
									<div class="switcher-options">
										<div class="switcher-currency-trigger">
											<span class="currency-trigger">USD - US Dollar</span>
											<ul class="switcher-dropdown">
												<li>GBP - British Pound Sterling</li>
												<li>EUR - Euro</li>
											</ul>
										</div>
									</div>
								</div> -->
								<!-- <div class="switcher-currency">
									<strong class="label switcher-label">
										<span>Language</span>
									</strong>
									<div class="switcher-options">
										<div class="switcher-currency-trigger">
											<span class="currency-trigger">English01</span>
											<ul class="switcher-dropdown">
												<li>English02</li>
												<li>English03</li>
												<li>English04</li>
												<li>English05</li>
											</ul>
										</div>
									</div>
								</div> -->
								<!-- <div class="switcher-currency">
									<strong class="label switcher-label">
										<span>Select Store</span>
									</strong>
									<div class="switcher-options">
										<div class="switcher-currency-trigger">
											<span class="currency-trigger">Fashion Store</span>
											<ul class="switcher-dropdown">
												<li>Furniture</li>
												<li>Shoes</li>
												<li>Speaker Store</li>
												<li>Furniture</li>
											</ul>
										</div>
									</div>
								</div> -->
								<div class="switcher-currency">
									<!-- <strong class="label switcher-label">
										<span>My Account</span>
									</strong> -->
									<?php
										if (isset($_SESSION['user']['user_id'])) {
											$us = "SELECT role_id FROM users WHERE user_id= ".$_SESSION['user']['user_id'];
											$rz = $con->query($us);
											$rw = $rz->fetch_assoc();
											if ($rw['role_id'] == 3) {?>
												<div class="switcher-options">
													<div class="switcher-currency-trigger">
														<div class="setting__menu">
															
															<span><a href="profile.php">Profile</a></span>
															<span><a href="logout.php">Logout</a></span>
														</div>
													</div>
												</div>
									<?php	}
											elseif ($rw['role_id'] == 2) {?>
												<div class="switcher-options">
													<div class="switcher-currency-trigger">
														<div class="setting__menu">
															
															<span><a href="contributor/dashboard.php">Dashboard</a></span>
															<span><a href="logout.php">Logout</a></span>
														</div>
													</div>
												</div>
									<?php	}
											elseif ($rw['role_id'] == 1) {?>
												<div class="switcher-options">
													<div class="switcher-currency-trigger">
														<div class="setting__menu">
															
															<span><a href="admin/dashboard.php">Dashboard</a></span>
															<span><a href="logout.php">Logout</a></span>
														</div>
													</div>
												</div>
									<?php	}
										} else{?>
											<div class="switcher-options">
												<div class="switcher-currency-trigger">
													<div class="setting__menu">
														
														<span><a href="login.php">Sign In</a></span>
														<span><a href="register.php">Create An Account</a></span>
													</div>
												</div>
											</div>
								    <?php }
									?>
									
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- Start Mobile Menu -->
		<div class="row d-none">
			<div class="col-lg-12 d-none">
				<nav class="mobilemenu__nav">
					<ul class="meninmenu">
						<li><a href="index.php">Home</a></li>
						<li><a href="discussion.php">Discussion</a></li>
						<li><a href="#">Material</a>
							<ul>
								<?php
    								echo create_categories_li( $categories_array, 'material.php' );
								?>
							</ul>
						</li>
						<li><a href="#">Books</a>
							<ul>
								<?php
    								//echo create_categories_li( $categories_array, 'books.php' );
    								
    								foreach( $categories_array as $category ){
								        if( $category['tittle'] == 'CSS' ||  $category['tittle'] == 'PCS' || $category['tittle'] == 'PMS' ){
								            ?>
        								        <li class="label2"><a href="new_books.php?slug=<?= strtolower($category['tittle']);?>"><?=$category['tittle'];?></a>
            										<ul>
            										    <li><a href="compulsory_books.php?slug=<?= strtolower($category['tittle']);?>">Compulsory Subjects</a></li>
            										    <li><a href="optional_books.php?slug=<?= strtolower($category['tittle']);?>">Optional Subjects</a></li>
            										</ul>
            								    </li>
        								    <?php
								        } else if( $category['tittle'] == 'TOFIL' || $category['tittle'] == 'IELTS' ){
								            ?>
        								        <li class="label2"><a href="#"><?=$category['tittle'];?></a>
            										<ul>
            										    <li><a href="sections_wise_books.php?slug=<?= strtolower($category['tittle']);?>-listening">Listening</a></li>
            										    <li><a href="sections_wise_books.php?slug=<?= strtolower($category['tittle']);?>-reading">Reading</a></li>
            										    <li><a href="sections_wise_books.php?slug=<?= strtolower($category['tittle']);?>-writing">Writing</a></li>
            										    <li><a href="sections_wise_books.php?slug=<?= strtolower($category['tittle']);?>-speaking">Speaking</a></li>
            										</ul>
            								    </li>
        								    <?php
								        } else{
								            echo '<li><a href="books.php?id='.$category['id'].'">'.$category['tittle'].'</a></li>';
								        }
								    
                                    }
    								
    								
								?>
							</ul>
						</li>
						<li><a href="#">Quiz</a>
							<ul>
								<?php
    								echo create_categories_li( $categories_array, 'quiz_category.php' );
								?>
							</ul>
						</li>
						<li><a href="#">Past Papers</a>
							<ul>
								<?php
    								echo create_categories_li( $categories_array, 'past_paper_category.php' );
								?>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- End Mobile Menu -->
		<div class="mobile-menu d-block d-lg-none">
		</div>
		<!-- Mobile Menu -->	
	</div>		
</header>
<br> <br> <br> 

<!-- Start Search Popup -->
		<div class="brown--color box-search-content search_active block-bg close__top">
			<form id="search_mini_form" class="minisearch" action="search.php" method="POST">
				<div class="field__search">
					<input type="text" name="keyword" placeholder="Search here..." required>
					<div class="action">
						<button type="submit" class="btn-link search-btn" name="search"> <i class="zmdi zmdi-search"></i> </button>
					</div>
				</div>
			</form>
			<div class="close__wrap">
				<span>close</span>
			</div>
		</div>
		<!-- End Search Popup -->